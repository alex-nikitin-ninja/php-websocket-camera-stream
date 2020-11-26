#!/bin/bash

# capture vebcamera into file "img.jpg"
# ffmpeg -i /dev/video0 -q:v 0.5 -updatefirst 1 ws-server-php/tmp/img.jpg


cd ws-server-php/
rm -r tmp/
mkdir -p tmp/
chmod 777 tmp/
# rm -r composer-stable.phar
# wget https://getcomposer.org/composer-stable.phar
# php composer-stable.phar update
php server.php


