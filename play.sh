#!/bin/bash
# Exectute > chmod +x ./play.sh && ./play.sh
clear

layout="$PWD/install"
source "$layout/variables.sh"
echo -e "Voulez-vous lancer Symfony ?  \e[35m(\e[33mo\e[32mui\e[97m/\e[33mn\e[32mon\e[35m)\e[0m \e[97m[\e[33m\e[1mn\e[0m\e[97m]\e[0m :"
read -n 1 -rp "> " val_ser
line
line -t ""

if [[ "${val_ser^^}" == "O" ]]; then

    if [ -d "$folder_rel_serveur" ]; then
        cd $folder_rel_serveur
        clear
        echo
        echo -e ' Lien pour ouvrir symfony (CTRL + clic): '
        echo -e "\e[1m\e[34mhttp://localhost:$port_symfony\e[0m"
        echo

        php -S localhost:$port_symfony -t public
        pause s 2 m
    else
        chmod +x ./install.sh && ./install.sh
    fi
fi

echo -e "Voulez-vous lancer Preview ?  \e[35m(\e[33mo\e[32mui\e[97m/\e[33mn\e[32mon\e[35m)\e[0m \e[97m[\e[33m\e[1mn\e[0m\e[97m]\e[0m :"
read -n 1 -rp "> " val_ser
line
line -t ""

if [[ "${val_ser^^}" == "O" ]]; then

    if [ -d "$folder_rel_front" ]; then
        cd $folder_rel_front
        clear
        echo
        echo -e ' Lien pour ouvrir preview(CTRL + clic): '
        echo -e "\e[1m\e[34mhttp://localhost:9876\e[0m"
        echo
        URL "http://localhost:9876"
        command ns preview android
        pause s 2 m
    else
        chmod +x ./install.sh && ./install.sh
    fi
fi
