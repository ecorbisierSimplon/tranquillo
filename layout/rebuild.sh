#!/bin/bash

# "Rebuild :"

echo "remove-orphans"
echo "--------------------------------"
docker compose down --remove-orphans

sleep 5
echo
echo "image rm "
echo "--------------------------------"
docker image rm backend_$name:$current_version

echo
echo "build --pull"
echo "--------------------------------"
docker compose build --pull --no-cache

# docker-compose up --force-recreate -d

echo
echo "compose up pull"
echo "--------------------------------"
docker compose up --pull always -d --wait

# echo "compose exec php"
# echo "--------------------------------"
# docker compose exec php bin/console dbal:run-sql -q "SELECT 1" && echo "OK" || echo "Connection is not working"
