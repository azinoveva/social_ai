#!/bin/bash

echo "Copying custom default.conf over to /etc/nginx/sites-available/default.conf"
cp /home/site/wwwroot/default.conf /etc/nginx/sites-available/default
service nginx reload
npm run build
