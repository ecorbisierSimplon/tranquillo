#!/bin/bash

env_file=".env"
default_version="1.0.00"

name="tranquillo"
user=$LOGNAME

myfolder=$PWD
home=~
server_folder="serveur-backend"
layout="$PWD/layout"

current_version="1.0.00"
# Vérifier si le fichier .env n'existe pas

folder_env=$myfolder/$server_folder/$env_file
echo "variables.sh = $folder_env"

if [ ! -f "$folder_env" ]; then
    current_version=$(grep '^BACKEND_VERSION=' $folder_env | cut -d '=' -f2)
fi

# Définir l'indentation
file=compose.yaml
basedonnees="\n# ##> BASE DE DONNÉES \/\/ ADMINER ET mariadb\n  adminer:\n    platform: linux\/x86_64\n    container_name: adminer_\${NAME}_\${ADMINER_VERSION}\n    image: adminer:\${ADMINER_VERSION}\n    restart: unless-stopped\n    ports:\n      - \${ADMINER_LOCALHOST_PORT}:\${ADMINER_DOCKER_PORT}\n    env_file:\n      - .env\n    depends_on:\n      - database\n\n  database:\n    platform: linux\/x86_64\n    container_name: mariadb_\${NAME}_\${MARIADB_VERSION}\n    image: mariadb:\${MARIADB_VERSION}\n    restart: unless-stopped\n    env_file:\n      - .env\n    volumes:\n      - ..\/\${DATA}\/sql:\/docker-entrypoint-initdb.d\/\n      - ..\/\${MYSQL_DATA}:\/var\/lib\/mysql\n    ports:\n      - \${SQL_LOCALHOST_PORT}:\${SQL_DOCKER_PORT}\n# ##< BASE DE DONNÉES \/\/ ADMINER ET mariadb\n "

pause() {
    declare -a tab
    # Lecture et conversion de la chaîne en tableau
    read -r -a tab <<<"$@"

    pause="p"
    stop="stop"
    clear="c"
    sleep="s"

    test= in_array "${tab[*]}" "$pause"
    result=$?
    test= in_array "${tab[*]}" "$sleep"
    result2=$?
    # echo "result : $result"
    if [[ "$result" == "0" && "$result2" == "0" ]]; then
        read -p "Appuyez sur'Entrée' pour continuer ou [s] pour quitter > " text
        case "$text" in
        [Qq] | [Ss] | [Ss][Tt][Oo][Pp])
            exit 1
            ;;
        esac
    fi

    test= in_array "${tab[*]}" "$sleep"
    result=$?
    # echo "result : $result"
    if [[ "$result" == "1" ]]; then
        index=-1
        for ((i = 0; i < ${#tab[@]}; i++)); do
            if [[ "${tab[$i]}" == "$sleep" ]]; then
                index=$((i + 1))
                break
            fi
        done
        # echo "index : $index"
        if [[ "$index" != "-1" ]]; then
            num=${tab[$index]}
            # echo "num = $num"
            echo "$num" | egrep -q '^[-+]?[0-9]+$'
            result=$?
            # echo "result if '$num' is number : $result"
            if [[ "$result" == "0" ]]; then
                # Compte à rebours de 10 à 1
                for ((i = $num; i >= 1; i--)); do
                    # Efface la ligne précédente
                    printf "\r"
                    printf "\033[J"
                    # Affiche le message de patientez
                    printf "Appuyez sur [\033[36;5mc\033[0m] pour continuer (\033[31;1m%ds\033[0m) ou [\033[36;5mq\033[0m] pour quitter > " "$i"
                    # Attendre 1 seconde
                    read -t 1 -n 1 key                            # Lire une touche en temps limité (1 seconde)
                    if [[ "$key" == "q" || "$key" == "Q" ]]; then # Si "q" est pressé, quitter
                        printf "\n"
                        # Effacer la ligne après la fin du compte à rebours
                        printf "\r"
                        printf "\033[J"
                        # Afficher un message final
                        printf "Le processus est arrêté.\n"
                        exit 1
                    elif [[ "$key" == "c" || "$key" == "C" ]]; then # Si "Entrée" est pressée, sortir de la boucle
                        break
                    fi
                done

                # Effacer la ligne après la fin du compte à rebours
                printf "\r"
                printf "\033[J"
                # Afficher un message final
                printf "Merci d'avoir patienté.\n"
                sleep 1
            fi
        fi

    fi

    test= in_array "${tab[*]}" "$stop"
    result=$?
    # echo "result : $result"
    if [[ "$result" == "1" ]]; then
        echo "Procédure stoppée !"
        exit 1
    fi

    test= in_array "${tab[*]}" "$clear"
    result=$?
    # echo "result : $result"
    if [[ "$result" == "1" ]]; then
        clear
    fi
}

function in_array() {
    local tableau=("$1")
    local comparaison="$2"
    # echo "Tableau: ${tableau[@]}"
    # echo "Élément de comparaison: $comparaison"

    if echo "${tableau[@]}" | grep -qw "$comparaison"; then
        return 1
    else
        return 0
    fi
}
