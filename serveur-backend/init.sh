#!/bin/bash
# Exectute > chmod +x ./init.sh && ./init.sh

echo docker compose
echo "1 : Create build (defaut)"
echo "2 : recreate"
echo "3 : rebuild"
echo ":q : quitter"
read val
#
if [[ "$val" == ":q" ]]; then
    exit 1
fi

echo "Voulez-vous supprimer la base de donnée ?"
echo "(Yes pour oui sinon c'est non)"
read val
if [[ "$val" == "Yes" ]]; then
    # Suppression de la base de donnée
    sudo rm -rf ../database/tranquillo_sql/
fi

env_file=".env"
default_version="1.0.00"
name="tranquillo"

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

if [[ $val == 2 ]]; then
    echo "Recreate :"
    echo "----------"
    docker-compose up --force-recreate -d
    exit 1
fi
if [[ $val == 3 ]]; then
    echo "Rebuild :"
    echo "----------"
    docker compose down --remove-orphans
    docker image rm backend_$name
    docker compose build --pull --no-cache
    docker compose exec php bin/console dbal:run-sql -q "SELECT 1" && echo "OK" || echo "Connection is not working"
    docker-compose up --force-recreate -d
    exit 1
fi
echo "compose up :"
echo "------------"
docker compose down --remove-orphans
docker image rm backend_$name
docker compose build --no-cache
docker compose up --pull always -d --wait
