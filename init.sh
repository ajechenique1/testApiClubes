#!/bin/bash

echo "------------------ Checking for Composer ------------------"
composer -n install
composer -n update

echo "------------------ Exec Migrations ------------------------"
php bin/console doctrine:migrations:migrate