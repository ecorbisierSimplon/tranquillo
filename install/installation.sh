#!/bin/bash

# echo $folder_rel_serveur
clear
cd $myfolder

if [ -d "$folder_rel_serveur" ]; then
    cd $folder_rel_serveur
    echo "remove-orphans"
    echo "--------------------------------"
    docker compose down --remove-orphans
    echo " ** Opération effectuée **"
    echo
    cd $myfolder
fi

# Définition du tableau
my_array=("$myfolder/symfony-docke" "$folder_rel_serveur" "$folder_rel_data" "TutoSymfony")

# Boucle pour lire le tableau
for element in "${my_array[@]}"; do
    if [ -d "$element" ]; then
        echo "suppression de '$element'"
        echo "--------------------------------"
        pause s 1 m
        sudo rm -rf $element
        echo " ** suppression effectuée **"
        echo
    fi
done

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

cd $folder_rel_serveur
pause s 1 m
composer require webapp --quiet


# Mise à jour de env et n° de version
source "$layout/script-default.sh"

echo -e "'\e[1m Mise à jour de compose.yaml\e[0m'"
echo "-----------------------------"
pause s 1 m
source "$layout/script-compose.sh"
echo "** Fichier compose.yaml est prêt **"
echo


cd $folder_rel_serveur
pause s 1 m
composer remove "symfony/ux-turbo"

cd $folder_rel_serveur
pause s 1 m
composer require "symfony/var-exporter:7.0.4"

cd $folder_rel_serveur
pause s 1 m
composer require orm-fixtures --dev

cd $folder_rel_serveur
pause s 1 m
composer require fakerphp/faker --dev

cd $folder_rel_serveur
pause s 1 m
composer require league/factory-muffin --dev

cd $folder_rel_serveur
pause s 1 m
composer require league/factory-muffin-faker --dev

cd $folder_rel_serveur
pause s 1 m
composer require symfony/serializer-pack

# cd $folder_rel_serveur
# pause s 1 m
# composer require sensio/framework-extra-bundle


# cd $folder_rel_serveur
# pause s 1 m
# composer require nelmio/api-doc-bundle

# cd $folder_rel_serveur
# pause s 1 m
# composer require twig asset

# cd $folder_rel_serveur
# pause s 1 m
# composer require symfony/mercure-bundle

cd $folder_rel_serveur
pause s 1 m
composer require api


cd $folder_rel_serveur
pause s 1 m
composer require lexik/jwt-authentication-bundle


pause s 1 m
echo " ** Installation effectué**"
echo


echo -e "Voulez-vous générer Docker ? \e[35m(\e[33mo\e[32mui\e[97m/\e[33mn\e[32mon\e[35m)\e[0m \e[97m[\e[33m\e[1mn\e[0m\e[97m]\e[0m :"
read -n 1 -rp "> " val_dk
line
line -t ""

case "$val_dk" in
[YyOo] | [YyOo][EeUu][SsIi])
    source "$layout/buildnews.sh"
    ;;
esac

cd $folder_rel_serveur
 mkdir ./config/jwt

