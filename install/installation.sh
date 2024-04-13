#!/bin/bash

# echo $folder_rel_serveur
clear
cd $myfolder

if [ -d "$myfolder/symfony-docker" ]; then
    echo "suppression du dossier clone symfony"
    echo "--------------------------------"
    pause s 1 m
    sudo rm -rf $myfolder/symfony-docker
    echo " ** suppression effectuée **"
    echo
fi

if [ -d "$folder_rel_serveur" ]; then
    cd $folder_rel_serveur
    echo "remove-orphans"
    echo "--------------------------------"
    docker compose down --remove-orphans
    echo " ** Opération effectuée **"
    echo
    cd $myfolder

    echo "suppression backend"
    echo "--------------------------------"
    pause s 1 m
    sudo rm -rf $folder_rel_serveur
    echo " ** suppression effectuée **"
    echo
fi

if [ -d "$folder_rel_data" ]; then
    echo "suppression base de données"
    echo "--------------------------------"
    pause s 1 m
    sudo rm -rf $folder_rel_data
    echo " ** suppression effectuée **"
    echo
fi

echo -e "'\e[1m Ajout d'un module php 8.3 '$folder_serveur'\e[0m'"
echo "---------------------------------------------------"
pause s 1 m

sudo apt install php8.3 -y
pause s 1 m
sudo apt install php8.3-xml -y
echo
echo "** module php 8.3 est prêt **"
echo

echo -e "'\e[1m Installation de Symfony \e[0m'"
echo "---------------------------------------------------"
pause s 1 m
mkdir $folder_rel_serveur
cd $folder_rel_serveur
composer create-project symfony/skeleton:"$version_symfony" .

pause s 1 m
composer require webapp

pause s 1 m
echo " ** Installation effectué**"
echo

# Mise à jour de env et n° de version
source "$layout/script-default.sh"

echo -e "'\e[1m Mise à jour de compose.yaml\e[0m'"
echo "-----------------------------"
pause s 1 m
source "$layout/script-compose.sh"
echo "** Fichier compose.yaml est prêt **"
echo

source "$layout/buildnews.sh"

cd $folder_rel_serveur

pause s 5 m
