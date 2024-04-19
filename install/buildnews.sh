#!/bin/bash

# Create new build

echo "build --pull"
echo "--------------------------------"
pause s 2 m

docker compose build
# docker compose build --no-cache
echo " ** build effectuée **"
echo
pause s 2

echo "compose up pull"
echo "--------------------------------"
pause s 2 m

docker compose up -d
# docker compose up --pull always -d --wait
echo " ** compose up effectuée **"
echo
pause s 5 m
