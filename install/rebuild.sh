#!/bin/bash

cd $folder_rel_serveur
echo "remove-orphans"
echo "--------------------------------"
docker compose down --remove-orphans
echo " ** Opération effectuée **"
echo

echo "image rm _$name"
echo "--------------------------------"
pause s 2 m
docker rmi $(docker images | grep '' | awk '{print $3}')
pause s 2 m
docker volume rm $(docker volume ls)
pause s 2 m
echo " ** Opération effectuée **"
echo

source "$layout/newsdb.sh"
