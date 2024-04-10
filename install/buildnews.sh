#!/bin/bash

# Create new build

echo "build --pull"
echo "--------------------------------"
pause s 1 m
docker compose build --no-cache
echo " ** build effectuée **"
echo

echo "compose up pull"
echo "--------------------------------"
pause s 1 m
docker compose up --pull always -d --wait
echo " ** compose up effectuée **"
echo
