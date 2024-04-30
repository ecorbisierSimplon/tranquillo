#!/bin/bash
# Exectute > chmod +x ./install.sh && ./install.sh
clear
sudo test

layout="$PWD/install"
source "$layout/variables.sh"

chmod +x "$layout/script-init.sh"
source "$layout/script-init.sh"

choices=$(
    dialog \
        --title "MENU !" \
        --ok-label "Poursuivre" \
        --no-label "Quitter" \
        --stdout --no-tags --clear \
        --radiolist "
Appuyez sur ESPACE pour activer/désactiver une option. \n\n\
  Faites un choix :" 0 0 0 \
        "I" "Symfony - Docker - Nouvelle installation (tout supprimer et tout recréer)" off \
        "C" "Docker  - Créer un nouveau Build" off \
        "R" "Docker  - Recréer les containers (compose up)" off \
        "D" "Docker  - Recréer des containers (composer) avec suppression et remise à zéro de la base de données" off \
        "B" "Docker  - Rebuild (supprimer les anciennes images et recréer le Build)" off \
        "L" "Lancer les serveurs" off \
        "Q" "Quitter" on
)
clear
retval=$?

# echo "${retval}"
# echo "${choices[@]}"

case ${retval:-0} in
$DIALOG_OK)
    # Traitement des choix de l'utilisateur
    for choice in $choices; do
        val=$choice
    done
    ;;
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

if [[ ! ${val^^} == "L" ]]; then
    pause s 2 m

    if [[ ${val^^} == "I" ]]; then
        echo "Nouvelle Installation :"
        echo "----------"

    elif [[ ${val^^} == "R" ]]; then
        echo "Recreate containers (compose up) :"
        echo "----------"

    elif [[ ${val^^} == "D" ]]; then
        echo "Recreate containers (compose up) with recreate db:"
        echo "----------"

    elif [[ ${val^^} == "B" ]]; then
        echo "Rebuild :"
        echo "----------"
    elif [[ ${val^^} == "C" ]]; then
        echo "Create Build :"
        echo "-------------"
    else
        clear
        exit 1
    fi

    if [ -d "$folder_rel_data" ]; then
        case "$val" in
        [Rr] | [Bb] | [Cc])
            # Suppression de la base de donnée
            echo
            echo "------------------------------------------"
            echo -e "Voulez-vous supprimer la base de donnée ?  \e[35m(\e[33mo\e[32mui\e[97m/\e[33mn\e[32mon\e[33mq\e[32muitter\e[35m)\e[0m \e[97m[\e[33m\e[1mn\e[0m\e[97m]\e[0m :"
            read -n 1 -rp "> " val_bd
            line
            line -t ""

            if [[ "${val_bd^^}" == "Q" ]]; then
                clear
                exit 1
            fi

            case "$val_bd" in
            [YyOo] | [YyOo][EeUu][SsIi])
                sudo rm -rf $folder_rel_data
                ;;
            esac
            ;;
        esac
    fi
    case "$val" in
    [Rr] | [Bb] | [Cc])
        source $layout/script-default.sh
        ;;
    esac

    if [[ ${val^^} == "I" ]]; then
        source "$layout/installation.sh"

    elif [[ ${val^^} == "R" ]]; then
        source "$layout/composeup.sh"

    elif [[ ${val^^} == "D" ]]; then
        source "$layout/newsdb.sh"

    elif [[ ${val^^} == "B" ]]; then
        source "$layout/rebuild.sh"

    elif [[ ${val^^} == "C" ]]; then
        source "$layout/buildnews.sh"

    else
        exit 1

    fi

    # if [ -d "$folder_rel_data" ]; then
    # sudo chown -R $user $folder_rel_data
    # fi

    echo -e "'\e[1m Nettoyage des images\e[0m'"
    echo "-----------------------------"
    my_array=("backend_$name" "<none>" "app-php")
    pause s 2 m

    # Boucle pour lire le tableau
    for element in "${my_array[@]}"; do
        docker rmi $(docker images | grep "$element" | awk '{print $3}')
    done

    docker volume prune --force
    echo "** Images nettoyées **"
    echo

    docker-desktop
    pause s 2 m

fi
cd $folder_rel_serveur
# echo
# echo -e ' Lien pour ouvrir symfony (CTRL + clic): '
# echo -e "\e[1m\e[34mhttp://localhost:$port_symfony\e[0m"
# echo
# echo

DIALOG_ERROR=254
export DIALOG_ERROR

$DIALOG --title "SYMFONY" --clear "$@" \
    --clear \
    --ok-label "Oui" \
    --no-label "Quitter" \
    --extra-label "Non" --extra-button \
    --yesno "Voulez-vous lancer le serveur symfony ?" 0 0

retval=$?
clear

case ${retval:-0} in
$DIALOG_OK)
    php -S localhost:$port_symfony -t public
    exit 1
    ;;
esac

pause s 2 m
