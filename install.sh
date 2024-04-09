#!/bin/bash
# Exectute > chmod +x ./install.sh && ./install.sh
clear
sudo test
layout="$PWD/layout"
source "$layout/variables.sh"

cd $server_folder

echo docker compose
echo -e "\e[31m\e[1m[n]\e[0m - New install (delete all images and recreate build)"
echo -e "\e[31m\e[1m[c]\e[0m - Create build (default)"
echo -e "\e[31m\e[1m[r]\e[0m - Recreate containers (compose up)"
echo -e "\e[31m\e[1m[b]\e[0m - Rebuild (delete old images and recreate build)"
echo -e "\e[31m\e[1m[q]\e[0m - Quitter"
read -p " > " val
#
if [[ "$val" == "q" ]]; then
    clear
    exit 1
fi
pause s 2

# Vérifier si le fichier .env n'existe pas
if [ ! -f "$folder_env" ]; then
    # Écrire le contenu par défaut dans le fichier .env
    sudo cp "$layout/env" "$folder_env"
fi

if [[ "$val" == "n" ]]; then
    echo "Nouvelle Installation :"
    echo "----------"

elif [[ "$val" == "r" ]]; then
    echo "Recreate :"
    echo "----------"

elif [[ "$val" == "b" ]]; then
    echo "Rebuild :"
    echo "----------"
else
    echo "Recreate containers (compose up) :"
    echo "-------------"
fi

# Suppression de la base de donnée
echo
echo "Voulez-vous supprimer la base de donnée ? "
read -p " \e[31m\e[1m[Y]\e[0mes / \e[31m\e[1m[N]\e[0mo (is default) > " val_bd

case "$val_bd" in
[Yy] | [Yy][Ee][Ss])
    sudo rm -rf ../database/${name}/
    ;;
esac

if [[ "$val" == "n" ]]; then
    source "$layout/installation.sh"
elif [[ "$val" == "r" ]]; then
    source "$layout/buildnews.sh"

elif [[ "$val" == "b" ]]; then
    source "$layout/composeup.sh"

else
    source "$layout/installation.sh"

fi
pause s 3
echo
echo "---------------------------------"
echo -e " Lien pour ouvrir symfony (CTRL + clic): "
echo -e "'\e[1m\e[34mhttps://localhost:443\e[0m'"
echo
