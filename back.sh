#!/bin/bash
# Exectute > chmod +x ./back.sh && ./back.sh

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

if [[ "$val" == "2" ]]; then

elif [[ "$val" == "3" ]]; then

else

fi

echo
echo "---------------------------------"
echo -e " Lien pour ouvrir symfony (CTRL + clic): "
echo -e "'\e[1m\e[34mhttps://localhost:443\e[0m'"
echo
