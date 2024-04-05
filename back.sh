#!/bin/bash
# Exectute > chmod +x ./back.sh && ./back.sh
clear
sudo test
source "./variables.sh"

cd $server_folder

echo docker compose
echo "[c]reate build (default)"
echo "[r]ecreate (compose up)"
echo "Re[b]uild (delete old image and recreate build)"
echo "[q]uitter"
read -p " > " val
#
if [[ "$val" == "q" ]]; then
    exit 1
fi

if [[ "$val" == "r" ]]; then
    echo "Recreate :"
    echo "----------"

elif [[ "$val" == "b" ]]; then
    echo "Rebuild :"
    echo "----------"
else
    echo "compose up :"
    echo "-------------"
fi

# Suppression de la base de donnée
echo
echo "Voulez-vous supprimer la base de donnée ? "
read -p " [Y]es / [N]o (is default) > " val_bd

case "$val_bd" in
[Yy] | [Yy][Ee][Ss])
    sudo rm -rf ../database/${name}_sql/
    ;;
esac

# Vérifier si le fichier .env existe
if [ ! -f "$env_file" ]; then
    # Si le fichier .env n'existe pas, le créer avec un contenu par défaut
    echo "# Fichier de configuration .env par défaut" >"$env_file"
    echo "BACKEND_VERSION=$default_version" >>"$env_file"
    echo "NAME=$name" >>"$env_file"
    echo "" >>"$env_file"
    echo "###> symfony/framework-bundle ###" >>"$env_file"
    echo "APP_ENV=dev" >>"$env_file"
    echo "APP_SECRET=cfa2bb1f7a945527239795cb4301cc57" >>"$env_file"
    echo "###< symfony/framework-bundle ###" >>"$env_file"
    echo "" >>"$env_file"

    # Ajoutez d'autres variables par défaut si nécessaire
fi

# Extraire le numéro de version actuel
current_version=$(grep '^BACKEND_VERSION=' .env | cut -d '=' -f2)
if [[ "$current_version" == "" ]]; then
    echo "BACKEND_VERSION=$default_version" >>"$env_file"
fi

# Séparer le numéro de version en parties (major, minor, patch)
major=$(echo "$current_version" | cut -d'.' -f1)
minor=$(echo "$current_version" | cut -d'.' -f2)
patch=$(echo "$current_version" | cut -d'.' -f3)

# Incrémenter la partie patch
patch=$((patch + 1))
# Formater le patch pour qu'il soit sur deux chiffres
patch=$(printf "%02d" $patch)

if [[ "$path" == "100" ]]; then
    patch=0
    minor=$((minor + 1))
    if [[ "$minor" == "10" ]]; then
        patch=0
        major=$((major + 1))
    fi
fi

# Reconstruire le numéro de version mis à jour
new_version="$major.$minor.$patch"

# Remplacer la valeur de BACKEND_VERSION dans le fichier .env
sed -i "s/^BACKEND_VERSION=.*/BACKEND_VERSION=$new_version/" .env

echo "La version a été mise à jour à $new_version"

if [[ "$val" == "2" ]]; then

    # "Recreate :"

    echo
    echo "compose up force"
    echo "--------------------------------"
    echo
    docker-compose up --force-recreate -d

elif [[ "$val" == "3" ]]; then
    # "Rebuild :"

    echo "remove-orphans"
    echo "--------------------------------"
    docker compose down --remove-orphans

    sleep 5
    echo
    echo "image rm "
    echo "--------------------------------"
    docker image rm backend_$name:$current_version

    echo
    echo "build --pull"
    echo "--------------------------------"
    docker compose build --pull --no-cache

    # docker-compose up --force-recreate -d

    echo
    echo "compose up pull"
    echo "--------------------------------"
    docker compose up --pull always -d --wait

    # echo "compose exec php"
    # echo "--------------------------------"
    # docker compose exec php bin/console dbal:run-sql -q "SELECT 1" && echo "OK" || echo "Connection is not working"

else
    # Create new build
    # "remove-orphans"

    echo
    echo "build --pull"
    echo "--------------------------------"
    docker compose build --no-cache

    echo
    echo "compose up pull"
    echo "--------------------------------"
    docker compose up --pull always -d --wait

fi

echo
echo "---------------------------------"
echo -e " Lien pour ouvrir symfony (CTRL + clic): "
echo -e "'\e[1m\e[34mhttps://localhost:443\e[0m'"
echo
