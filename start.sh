#!/bin/sh

###
# Install php dependencies
###
echo "Installing dependencies…"
composer install

###
# Create .env from sample
###
echo "Creating .env from sample"
cp .env.example .env

###
# Generate application kex
###
echo "Generating application key"
php artisan key:generate

###
# Run migration
###
echo "Running migrations…"
php artisan migrate --force

###
# Run database seeders
###
echo "Running database seeders…"
php artisan db:seed --class=UserSeeder --force
php artisan db:seed --class=TaskSeeder --force

###
# Install node dependencies
###
echo "Installing dependencies…"
npm install

###
# Run webpack mix
###
echo "Running webpack mix…"
npm run dev
