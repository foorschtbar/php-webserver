#!/bin/sh
set -e

usermod -u $UID www-data
groupmod -g $GID www-data

# upstream entrypoint (php:*-apache)
exec docker-php-entrypoint $@