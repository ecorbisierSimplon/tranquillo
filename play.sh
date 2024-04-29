#!/bin/bash
# Exectute > chmod +x ./play.sh && ./play.sh
clear

# Obtenir toutes les adresses IP associées à cet ordinateur
ip_addresses=$(hostname -I)

backend() {
    # Variable pour stocker l'adresse IP du réseau local
    local_ip=""

    # Parcourir chaque adresse IP pour trouver celle qui commence par "192.168"
    for ip in $ip_addresses; do
        if [[ $ip == 192.168.* ]]; then
            local_ip=$ip
            break
        fi
    done

    # Vérifier si une adresse IP du réseau local a été trouvée
    if [ -n "$local_ip" ]; then
        echo "L'adresse IP du réseau local est : $local_ip"
    else
        echo "Aucune adresse IP du réseau local (commençant par 192.168) n'a été trouvée."
    fi

    echo

    ip_server="localhost"
    if [ -n "$local_ip" ]; then
        # Afficher la boîte de dialogue avec les cases à cocher et récupérer les choix de l'utilisateur
        choices=$(dialog --stdout --no-tags --clear --title "Démarrer le serveur back" \
            --radiolist "Choisir le réseau :" 0 0 0 \
            "reseau_localhost" "Reseau localhost (localhost)" on \
            "reseau_local" "Reseau local (${local_ip})" off)
        clear
        # Vérifier si l'utilisateur a appuyé sur Annuler ou a fermé la boîte de dialogue
        if [ -z "$choices" ]; then
            echo "Aucune option sélectionnée."
            exit 0
        fi
        echo "${choices[@]}"
        # Traitement des choix de l'utilisateur
        for choice in $choices; do
            echo $choice
            case $choice in
            "reseau_local")
                ip_server=$local_ip
                ;;
            esac
        done
    fi

    echo "${ip_server}"
}

layout="$PWD/install"
source "$layout/variables.sh"
echo -e "Voulez-vous lancer Symfony ?  \e[35m(\e[33mo\e[32mui\e[97m/\e[33mn\e[32mon\e[35m)\e[0m \e[97m[\e[33m\e[1mn\e[0m\e[97m]\e[0m :"
read -n 1 -rp "> " val_ser
line
line -t ""

if [[ "${val_ser^^}" == "O" ]]; then

    if [ -d "$folder_rel_serveur" ]; then
        backend
        cd $folder_rel_serveur
        # clear
        echo
        echo -e ' Lien pour ouvrir symfony (CTRL + clic): '
        echo -e "\e[1m\e[34mhttp://${ip_server}:${port_symfony}\e[0m"
        echo

        php -S $ip_server:$port_symfony -t public
        pause s 2 m
        exit 1
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
