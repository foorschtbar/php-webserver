#!/bin/sh

usermod -u $UID www-data
groupmod -g $GID www-data

apache2-foreground