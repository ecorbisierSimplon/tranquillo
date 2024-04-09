#!/bin/bash

# Vérifier si le fichier .env n'existe pas
if [ ! -f "$folder_env" ]; then
    # Écrire le contenu par défaut dans le fichier .env
    sudo cp "$layout/env" "$folder_env"
fi

# Extraire le numéro de version actuel
if [[ "$current_version" == "" ]]; then
    echo "BACKEND_VERSION=$default_version" >>"$env_file"
fi

# Séparer le numéro de version en parties (major, minor, patch)
major=$(echo "$current_version" | cut -d'.' -f1)
minor=$(echo "$current_version" | cut -d'.' -f2)
patch=$(echo "$current_version" | cut -d'.' -f3)

# Incrémenter la partie patch
patch=$((patch + 1))
# Formater le patch pour qu'il soit sur deux chiffres
patch=$(printf "%02d" $patch)

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
