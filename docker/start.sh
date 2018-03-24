#!/usr/bin/env bash

if [ ! -f /app/.initalized ]; then
    sed -i  's/message_level=debug/message_level="$LOG_LEVEL"/g' /app/etc/config.ini.php
    sed -i  's/host="localhost"/host="$DB_HOST"/g' /app/etc/config.ini.php
    sed -i  's/port="3306"/port="$DB_PORT"/g' /app/etc/config.ini.php
    sed -i  's/user=""/user="$DB_USER"/g' /app/etc/config.ini.php
    sed -i  's/password=""/password="$DB_PASSWORD"/g' /app/etc/config.ini.php
    sed -i  's/dbname="steem"/dbname="$DB_NAME"/g' /app/etc/config.ini.php

    touch .initialized
fi

while true
do
    php /app/run.php
    sleep 5;
done