#!/bin/bash
# Exectute > chmod +x ./install.sh && ./install.sh
clear
sudo test
source "./variables.sh"

echo
echo -e "'\e[1m Suppression du dossier '$server_folder'\e[0m'"
echo "---------------------------------------------------"
pause s 20

rm -rf ./$server_folder

echo
echo -e "'\e[1m Clonage de dunglas/symfony-docker.git\e[0m'"
echo "---------------------------------------------------"
pause s 20

git clone git@github.com:dunglas/symfony-docker.git

mv symfony-docker $server_folder

cd $server_folder

echo
echo -e "'\e[1m Écrire le contenu par défaut dans le fichier .env\e[0m'"
echo "---------------------------------------------------"
pause s 20

# Vérifier si le fichier .env n'existe pas
if [ ! -f "$env_file" ]; then
    # Écrire le contenu par défaut dans le fichier .env
    cat >"$env_file" <<EOF
# Fichier de configuration .env par défaut

# In all environments, the following files are loaded if they exist,
# the latter taking precedence over the former:
# 
# * .env                contains default values for the environment variables needed by the app
# * .env.local          uncommitted file with local overrides
# * .env.\$APP_ENV       committed environment-specific defaults
# * .env.\$APP_ENV.local uncommitted environment-specific overrides
# 
# Real environment variables win over .env files.
# 
# DO NOT DEFINE PRODUCTION SECRETS IN THIS FILE NOR IN ANY OTHER COMMITTED FILES.
# https://symfony.com/doc/current/configuration/secrets.html
# 
# Run "composer dump-env prod" to compile .env files for production use (requires symfony/flex >=1.2).
# https://symfony.com/doc/current/best_practices.html#use-environment-variables-for-infrastructure-configuration

# ##> symfony/docker ###
#
BACKEND_VERSION=$default_version

FOLDER_BACK=$server_folder
NAME=$name

HTTP_DOCKER_PORT=80
HTTPS_DOCKER_PORT=443
HTTP3_DOCKER_PORT=443

HTTP_LOCALHOST_PORT=8000
HTTPS_LOCALHOST_PORT=443
HTTP3_LOCALHOST_PORT=443

#
# ##< symfony/docker ###

# ##> symfony/framework-bundle ###
#
APP_ENV=dev
APP_SECRET=4c4ad78b8a9ed1347ed8113081a3f6cf

#
# ##< symfony/framework-bundle ###

# ##> doctrine/doctrine-bundle ###
#
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml


## SERVER_NAME="\${SERVER_NAME:-localhost}:\${HTTP_LOCALHOST_PORT:-80}, php:\${HTTP_LOCALHOST_PORT}"
## MERCURE_PUBLISHER_JWT_KEY=\${CADDY_MERCURE_JWT_SECRET:-4c4ad78b8a9ed1347ed8113081a3f6cf}
## MERCURE_SUBSCRIBER_JWT_KEY=\${CADDY_MERCURE_JWT_SECRET:-4c4ad78b8a9ed1347ed8113081a3f6cf}
## TRUSTED_PROXIES=\${TRUSTED_PROXIES:-127.0.0.0/8,10.0.0.0/8,172.16.0.0/12,192.168.0.0/16}
## TRUSTED_HOSTS=^\${SERVER_NAME:-example\\.com|localhost}|php\$$

# Run "composer require symfony/mercure-bundle" to install and configure the Mercure integration
## MERCURE_URL=\${CADDY_MERCURE_URL:-http://php/.well-known/mercure}
# MERCURE_PUBLIC_URL=http://\${SERVER_NAME:-localhost}:\${HTTP_LOCALHOST_PORT:-443}/.well-known/mercure
# MERCURE_JWT_SECRET=\${CADDY_MERCURE_JWT_SECRET:-4c4ad78b8a9ed1347ed8113081a3f6cf}
# The two next lines can be removed after initial installation
## SYMFONY_VERSION=\${SYMFONY_VERSION:-7.0}
## STABILITY=\${STABILITY:-stable}
#
# ##< doctrine/doctrine-bundle ###

# ##> MYSQL/ mariadb - adminer ###
#
DATABASE_NAME=\${NAME}_sql
MYSQL_HOST=database
MYSQL_ROOT_PASSWORD=P@ssW0rd!
MYSQL_DATABASE=\${NAME}
MYSQL_USER=user
MYSQL_PASSWORD=password
DATA=database
MYSQL_DATA=\${DATA}/\${MYSQL_DATABASE}

SQL_LOCALHOST_PORT=3306
SQL_DOCKER_PORT=3306

MARIADB_VERSION="11.3.2"
ADMINER_VERSION="4.8.1"

ADMINER_DEFAULT_SERVER=\${MYSQL_HOST}
ADMINER_DEFAULT_DRIVER=mySQL
ADMINER_DEFAULT_DB_NAME=\${MYSQL_DATABASE}

ADMINER_LOCALHOST_PORT=5050
ADMINER_DOCKER_PORT=8080

# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32&charset=utf8mb4"
# ## DATABASE_URL="mysql://\${MYSQL_USER}:\${MYSQL_PASSWORD}@\${MYSQL_HOST}:\${SQL_DOCKER_PORT}/\${MYSQL_DATABASE}?serverVersion=\${MARIADB_VERSION}-MariaDB&charset=utf8mb4"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
#
# ##> MYSQL/ mariadb - adminer ###

EOF
fi

echo
echo -e "'\e[1m Mise à jour de compose.yaml\e[0m'"
echo "-----------------------------"
pause s 20

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
pause s 20

docker compose build --no-cache

echo
echo -e "'\e[1mcompose up pull\e[0m'"
echo "--------------------------------"
pause s 20

docker compose up --pull always -d --wait

echo
echo -e "'\e[1mInstallation terminée \e[0m'"
echo "---------------------------------"
echo
echo -e " Lien pour ouvrir symfony (CTRL + clic): "
echo -e "'\e[1m\e[34mhttps://localhost:443\e[0m'"
echo
