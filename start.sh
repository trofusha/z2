#!/bin/bash

export UID=${UID:-$(id -u)}
export GID=${GID:-$(id -g)}

docker compose down
docker compose up -d --build --pull always

docker compose exec app php artisan optimize:clear
docker compose exec app composer install
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan l5-swagger:generate
