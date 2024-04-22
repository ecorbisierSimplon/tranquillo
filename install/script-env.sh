# =========================================================
# =========================================================
# DEFINIR LES UTILISATEURS DE LA BASE DE DONNÉS
# =========================================================
# =========================================================
# ADMINSTRATEUR :

echo -e "\e[32mIdentifiant root \e[97m[\e[33mroot\e[97m] : \e[0m"
read -rp $'\e[97m> \e[35m' root
root=${root:-"root"}
echo -e "\e[32m\e[3mIdentifiant root\e[0m\e[97m : \e[33m${root}\e[0m"
echo "-----------------"
echo

echo -e "\e[32mMot de pass root \e[97m[\e[33mP@ssW0rd!\e[97m] : \e[0m"
read -rp $'\e[97m> \e[35m' pass_root
pass_root=${pass_root:-"P@ssW0rd!"}
echo -e "\e[32m\e[3mMot de pass root\e[0m\e[97m : \e[33m${pass_root}\e[0m"
echo "-----------------"
echo

echo -e "\e[32mIdentifiant utilisateur \e[97m[\e[33muser\e[97m] : \e[0m"
read -rp $'\e[97m> \e[35m' user
user=${user:-"user"}
echo -e "\e[32m\e[3mIdentifiant utilisateur\e[0m\e[97m : \e[33m${user}"
echo "-----------------"
echo

echo -e "\e[32mMot de passe utilisateur \e[97m[\e[33mpassword\e[97m] : \e[0m"
read -rp $'\e[97m> \e[35m' password
password=${password:-"password"}
echo -e "\e[32m\e[3mMot de passe utilisateur\e[0m\e[97m : \e[33m${password}\e[0m"
echo "-----------------"
echo

# Écrire le contenu par défaut dans le fichier .env
cat >"$file_rel_env" <<EOF
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
###> symfony/docker ###
#

NAME=$name
BASE=$basedb

DATABASE_NAME=\${NAME}_\${BASE}

###> VERSIONS ###
BACKEND_VERSION=$version_default
MARIADB_VERSION=$version_mariadb
ADMINER_VERSION=$version_adminer
PHPMYADMIN_VERSION=$version_phpmyadmin
###< VERSIONS ###

###>  FOLDERS ###
FOLDER_BACK=$folder_serveur
FOLDER_DATA=database
FOLDER_DATASQL=\${FOLDER_DATA}/sql
FOLDER_DATABASE=\${FOLDER_DATA}/\${DATABASE_NAME}
###<  FOLDERS ###

###> PORTS ###
HTTP_LOCALHOST_PORT=$port_symfony
HTTPS_LOCALHOST_PORT=443
HTTP3_LOCALHOST_PORT=443

HTTP_DOCKER_PORT=80
HTTPS_DOCKER_PORT=443
HTTP3_DOCKER_PORT=443

SQL_LOCALHOST_PORT=3388
SQL_DOCKER_PORT=3306

ADMINER_LOCALHOST_PORT=5088
ADMINER_DOCKER_PORT=8080

PHPMYADMIN_LOCALHOST_PORT=6088
PHPMYADMIN_DOCKER_PORT=80

MAILER_LOCALHOST_SMTP_PORT=1025
MAILER_DOCKER_SMTP_PORT=1025
PMA_PORT=\${SQL_DOCKER_PORT}

MAILER_LOCALHOST_HTML_PORT=8025
MAILER_DOCKER_HTML_PORT=8025
###< PORTS ###
EOF

# Écrire le contenu par défaut dans le fichier .env.local
cat >"${file_rel_env}.local" <<EOF
# Fichier de configuration .env par défaut

###> symfony/docker ###
#


###> MYSQL/ mariadb - adminer ###
#
MYSQL_HOST=database
MYSQL_LOCALHOST=127.0.0.1
MYSQL_DATABASE=\${NAME}
MYSQL_USER=$user
MYSQL_PASSWORD=$password
MYSQL_ROOT=$root
MYSQL_ROOT_PASSWORD=$pass_root

MYSQL_USER_API=api
MYSQL_PASSWORD_API=password

PMA_HOST=\${MYSQL_HOST}
PMA_USER=\${MYSQL_ROOT}
PMA_PASSWORD=\${MYSQL_ROOT_PASSWORD}
PMA_ARBITRARY=1


ADMINER_DEFAULT_SERVER=\${MYSQL_HOST}
ADMINER_DEFAULT_DRIVER=mySQL
ADMINER_DEFAULT_DB_NAME=\${MYSQL_DATABASE}

#
###< MYSQL/ mariadb - adminer ###



#
###< symfony/docker ###

###> symfony/framework-bundle ###
# Generat key secret : https://pwpush.com/fr/pages/generate_key
APP_ENV=dev
APP_SECRET=2f6461f06470400fe321fd026ec1af7121ff1a2bcb908f1ca473037f6b1e8cdf
###< symfony/framework-bundle ###
###> doctrine/doctrine-bundle ###
# The two next lines can be removed after initial installation
## SYMFONY_VERSION=\${SYMFONY_VERSION:-7.0}
## STABILITY=\${STABILITY:-stable}
#
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
DATABASE_URL="mysql://\${MYSQL_ROOT}:\${MYSQL_ROOT_PASSWORD}@\${MYSQL_LOCALHOST}:\${SQL_LOCALHOST_PORT}/\${MYSQL_DATABASE}?serverVersion=\${MARIADB_VERSION}-MariaDB&charset=utf8mb4"
###< doctrine/doctrine-bundle ###


###> symfony/messenger ###
# Choose one of the transports below
# MESSENGER_TRANSPORT_DSN=amqp://guest:guest@localhost:5672/%2f/messages
# MESSENGER_TRANSPORT_DSN=redis://localhost:6379/messages
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
###< symfony/messenger ###

###> symfony/mailer ###
# MAILER_DSN=null://null
###< symfony/mailer ###


###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=5d2182349fa74e53d666addf312f2626637da2b1abf9022e0742f4e7270049eb
###< lexik/jwt-authentication-bundle ###

EOF
