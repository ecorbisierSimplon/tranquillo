#!/bin/bash
# Exectute > chmod +x ./install.sh && ./install.sh
clear
sudo test

layout="$PWD/install"
source "$layout/variables.sh"

chmod +x "$layout/script-init.sh"
source "$layout/script-init.sh"

echo "Menu :"
echo "-------------------------------"
echo
echo -e "\e[31m[\e[33m\e[1mc\e[0m\e[31m]\e[32m - Docker  - \e[33mCréer un nouveau Build\e[0m"
echo -e "\e[31m[\e[33m\e[1mr\e[0m\e[31m]\e[32m - Docker  - \e[0m\e[33mRecréer les containers (compose up)\e[0m"
echo -e "\e[31m[\e[33m\e[1md\e[0m\e[31m]\e[32m - Docker  - \e[0m\e[33mRecréer des containers (composer) avec suppression et remise à zéro de la base de données\e[0m"
echo -e "\e[31m[\e[32m\e[1mi\e[0m\e[31m]\e[32m - Symfony - \e[0m\e[33mDocker - Nouvelle installation (tout supprimer et tout recréer)\e[0m"
echo -e "\e[31m[\e[33m\e[1mb\e[0m\e[31m]\e[32m - Docker  - \e[0m\e[33mRebuild (supprimer les anciennes images et recréer le Build)\e[0m"
echo -e "\e[31m[\e[33m\e[1ml\e[0m\e[31m]\e[32m - Lancer les serveurs\e[0m"
echo -e "\e[31m[\e[34m\e[1mq\e[0m\e[31m]\e[32m - Quitter \e[97m[\e[34mpar défaut\e[0m]"
read -n 1 -rp "> " val
line -t ""
#
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
echo
echo -e ' Lien pour ouvrir symfony (CTRL + clic): '
echo -e "\e[1m\e[34mhttp://localhost:$port_symfony\e[0m"
echo
echo
echo "---------------------------------"
echo -e "Veux-tu lancer le serveur symfony ? \e[35m(\e[33mo\e[32mui\e[97m/\e[33mn\e[32mon\e[35m)\e[0m \e[97m[\e[33m\e[1mn\e[0m\e[97m]\e[0m :"
read -n 1 -rp "> " val
line -t ""

case "$val" in
[YyOo] | [YyOo][EeUu][SsIi])
    php -S localhost:$port_symfony -t public
    ;;
esac

pause s 2 m
