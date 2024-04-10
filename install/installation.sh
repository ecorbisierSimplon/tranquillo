#!/bin/bash

# echo $folder_rel_serveur
clear

if [ -d "$myfolder/symfony-docker" ]; then
    echo "suppression du dossier clone symfony"
    echo "--------------------------------"
    pause s 1 m
    sudo rm -rf $myfolder/symfony-docker
    echo " ** suppression effectuée **"
    echo
fi

if [ -d "$folder_rel_serveur" ]; then
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

sudo apt install php8.3-xml
echo
echo "** module php 8.3 est prêt **"
echo

echo -e "'\e[1m Clonage de dunglas/symfony-docker.git\e[0m'"
echo "---------------------------------------------------"
pause s 1 m
cd $myfolder
git clone git@github.com:dunglas/symfony-docker.git
mv $myfolder/symfony-docker $folder_rel_serveur
cd $folder_rel_serveur
echo " ** clonage effectué **"
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

echo -e "'\e[1m Ajout de maker-bundle\e[0m'"
echo "-----------------------------"
pause s 1 m
composer require symfony/maker-bundle --dev
echo "** Marker-bundle est prêt **"
echo

echo -e "'\e[1m Ajout du template twig\e[0m'"
echo "-----------------------------"
pause s 1 m
composer require twig/twig
composer require twig
echo "** Twig est prêt **"
echo
