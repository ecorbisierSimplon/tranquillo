#!/bin/bash

echo
echo -e "\e[1m Suppression des dossiers\e[0m"
echo "---------------------------------------------------"
cd $server_folder

pause s 2
echo "rm container"
echo "--------------------------------"
docker compose down --remove-orphans

pause s 2
echo
echo "rm image backend_$name:$current_version"
echo "--------------------------------"

docker rmi $(docker images | grep backend_$name | awk '{print $3}')

pause s 2
docker volume prune -f
chem_docker=$(which docker)
# docker volume ls | grep 'serveur-backend_' | awk '{print $2}' | xargs -r $chem_docker/docker volume rm

# exit 1
pause s 2
cd ..
echo
echo "rm '$server_folder'"
echo "--------------------------------"
rm -rf ./$server_folder

pause s 2
echo
echo "rm base de données"
echo "--------------------------------"
sudo rm -rf $PWD/database/$name/

echo
echo -e "'\e[1m Ajout d'un module php 8.3 '$server_folder'\e[0m'"
echo "---------------------------------------------------"
pause s 2

sudo apt-get install php8.3-xml

echo
echo -e "'\e[1m Clonage de dunglas/symfony-docker.git\e[0m'"
echo "---------------------------------------------------"
pause s 2

git clone git@github.com:dunglas/symfony-docker.git

mv symfony-docker $server_folder

cd $server_folder

echo
echo -e "'\e[1m Écrire le contenu par défaut dans le fichier .env\e[0m'"
echo "---------------------------------------------------"
pause s 2

# Vérifier si le fichier .env n'existe pas
if [ ! -f "$folder_env" ]; then
    # Écrire le contenu par défaut dans le fichier .env
    sudo cp "$layout/env" "$folder_env"
fi

echo
echo -e "'\e[1m Mise à jour de compose.yaml\e[0m'"
echo "-----------------------------"
pause s 2

sed -i "s/image: \${IMAGES_PREFIX:-}app-php/image: backend_\${NAME}:\${BACKEND_VERSION}/g" $file
sed -i "/image: backend_\${NAME}:\${BACKEND_VERSION}/a \    container_name: backend_\${NAME}" $file
sed -i "s/HTTP_PORT/HTTP_LOCALHOST_PORT/g" $file
sed -i "s/HTTPS_PORT/HTTPS_LOCALHOST_PORT/g" $file
sed -i "s/HTTP3_PORT/HTTP3_LOCALHOST_PORT/g" $file
sed -i '/^ *ports: *$/,/^ *# HTTP *$/ s/^ *ports: *$/\    env_file:\n      - .env\n&/' $file
sed -i "s/- target: 80/- target: \${HTTP_DOCKER_PORT:-80}/g" $file
sed -i '/# HTTPS/{n; s/^ *- target: 443 *$/\      - target: ${HTTPS_DOCKER_PORT:-443}/}' $file
sed -i '/# HTTP\/3/{n; s/^ *- target: 443 *$/\      - target: ${HTTP3_DOCKER_PORT:-443}/}' $file
sed -i "0,/^$/ s/^$/${basedonnees}\n/" $file
sed -i "/\  caddy_config:/a \  ${name}_sql:" $file
sed -i "/\        protocol: udp/a \    depends_on:\n\      - database" $file
echo

echo -e "'\e[1mbuild --pull\e[0m'"
echo "--------------------------------"
pause s 2

docker compose build --no-cache

echo
echo -e "'\e[1mcompose up pull\e[0m'"
echo "--------------------------------"
pause s 2

docker compose up --pull always -d --wait

pause s 2
composer require symfony/maker-bundle --dev
pause s 1
composer require twig
pause s 1

echo
echo -e "'\e[1mAjout du module maker bundle \e[0m'"
echo "---------------------------------"
pause s 2

sudo chown -R $user:$user $myfolder/database/$name

pause s 2
# composer require twig
echo
echo -e "'\e[1mInstallation terminée \e[0m'"
echo "---------------------------------"
echo
echo -e " Lien pour ouvrir symfony (CTRL + clic): "
echo -e "'\e[1m\e[34mhttps://localhost:443\e[0m'"
echo
