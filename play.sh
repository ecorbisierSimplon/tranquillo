#!/bin/bash
# Exectute > chmod +x ./play.sh && ./play.sh
clear
layout="$PWD/install"
source "$layout/variables.sh"
# Obtenir toutes les adresses IP associées à cet ordinateur
ip_addresses=$(hostname -I)

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

if [ -n "$local_ip" ]; then
    # Afficher la boîte de dialogue avec les cases à cocher et récupérer les choix de l'utilisateur
    choices=$(dialog --stdout --no-tags --clear --title "Démarrer les serveurs" \
        --radiolist "Choisir le serveur:" 0 0 0 \
        "back_localhost" "Symfony sur reseau localhost (localhost)" off \
        "back_local" "Symfony sur reseau local (${local_ip})" off \
        "front" "Frontend" off)

else
    # Afficher la boîte de dialogue avec les cases à cocher et récupérer les choix de l'utilisateur
    choices=$(dialog --stdout --no-tags --clear --title "Démarrer les serveurs" \
        --radiolist "Choisir le serveur:" 0 0 0 \
        "back_localhost" "Symfony sur reseau localhost (localhost)" off \
        "front" "Frontend" off)
fi
retval=$?
clear
# echo $retval
case ${retval:-0} in
$DIALOG_CANCEL)
    clear
    exit 1
    ;;
$DIALOG_EXTRA)
    clear
    exit 1
    ;;
$DIALOG_ITEM_HELP) ;;
$DIALOG_ERROR)
    clear
    echo "ERROR!"
    exit 1
    ;;
$DIALOG_ESC)
    clear
    exit 1
    ;;
esac
# echo "${choices[$@]}"

serveur=NULL
# Traitement des choix de l'utilisateur
for choice in $choices; do
    # echo $choice
    case $choice in
    "back_local")
        serveur="back"
        ip_server=$local_ip
        echo "Lancement du back : ip_server=${local_ip}"
        ;;
    "back_localhost")
        serveur="back"
        ip_server="localhost"
        echo "Lancement du back : ip_server= localhost"
        ;;
    "front")
        serveur="front"
        echo "Lancement du front."
        ;;
    "")
        clear
        echo "Aucun choix effectué"
        exit 1
        ;;
    esac
done

if [[ $serveur == NULL ]]; then
    clear
    echo "Aucun choix effectué"
    exit 1
fi
if ! docker images >/dev/null 2>&1; then
    echo "Lancement de Docker desktop"
    echo "--------------------------------"
    pause s 2 m
    docker-desktop
    echo " ** Lancement en cours ... **"

    i=0
    while true; do
        ((i++))
        printf "\r"
        printf "\033[J"
        printf "Merci de patienter (%ds) > " "$i"

        read -t 1 -n 1 -s keys # Lire un seul caractère en mode silencieux

        if [[ "${keys^^}" == "Q" ]]; then
            printf "\n"
            printf "\r"
            printf "\033[J"
            echo "Attente annulée"
            exit 1
        fi

        if docker images >/dev/null 2>&1; then
            printf "\n"
            printf "\r"
            printf "\033[J"
            echo "Lancement effectué"
            break
        fi
    done
else
    echo "Docker desktop est lancé"
    echo "--------------------------------"

fi
pause s 2 m
echo "${ip_server}"
pause s 2 m

if [[ "${serveur}" == "back" ]]; then

    if [ -d "$folder_rel_serveur" ]; then
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
else

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
