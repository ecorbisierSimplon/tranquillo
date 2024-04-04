#!/bin/bash

echo docker compose
echo "1 : up (defaut)"
echo "2 : recreate"
echo "3 : rebuild"
echo ":q : quitter"
read val
#
if [[ "$val" == ":q" ]]; then
    exit 1
fi

echo "Voulez-vous supprimer la base de donnée ?"
echo "(Yes pour oui sinon c'est non)"
read val
if [[ "$val" == "Yes" ]]; then
    # Suppression de la base de donnée
    sudo rm -rf ../database/tranquillo_sql/
fi

# Extraire le numéro de version actuel
current_version=$(grep '^BACKEND_VERSION=' .env | cut -d '=' -f2)

# Séparer le numéro de version en parties (major, minor, patch)
major=$(echo "$current_version" | cut -d'.' -f1)
minor=$(echo "$current_version" | cut -d'.' -f2)
patch=$(echo "$current_version" | cut -d'.' -f3)

# Incrémenter la partie patch
patch=$((patch + 1))
if [[ "$path" == "100" ]]; then
    patch=0
    minor=$((minor + 1))
    if [[ "$minor" == "10" ]]; then
        patch=0
        major=$((major + 1))
    fi
fi

# Reconstruire le numéro de version mis à jour
new_version="$major.$minor.$patch"

# Remplacer la valeur de BACKEND_VERSION dans le fichier .env
sed -i "s/^BACKEND_VERSION=.*/BACKEND_VERSION=$new_version/" .env

echo "La version a été mise à jour à $new_version"

if [[ $val == 2 ]]; then
    echo "Recreate :"
    echo "----------"
    docker-compose up --force-recreate -d
    exit 1
fi
if [[ $val == 3 ]]; then
    echo "Rebuild :"
    echo "----------"
    docker compose down --remove-orphans
    docker compose build --pull --no-cache
    docker compose exec php bin/console dbal:run-sql -q "SELECT 1" && echo "OK" || echo "Connection is not working"
    docker-compose up --force-recreate -d
    exit 1
fi
echo "compose up :"
echo "------------"
docker compose build --no-cache
docker compose up --pull always -d --wait
