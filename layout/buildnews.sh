#!/bin/bash

# Create new build
# "remove-orphans"

echo
echo "build --pull"
echo "--------------------------------"
docker compose build --no-cache

echo
echo "compose up pull"
echo "--------------------------------"
docker compose up --pull always -d --wait
