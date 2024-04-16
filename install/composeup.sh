#!/bin/bash

# "Recreate :"

echo "compose up force"
echo "--------------------------------"
pause s 2 m
docker-compose up --force-recreate -d
echo "** Opération éffectué **"
echo
