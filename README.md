# raspi-services-tool-backend
A backend-API for managing your services on a raspi via web

## Set-Up
To set up this project, you need the following dependencies:
- php 7.4
- composer
- a webserver like nginx
- docker 19.03
- docker-compose 1.26

Follow these steps:
1. Configure a virtualhost on your local machine to handle webconnections for the backend (see "Configure nginx" for an example nginx config)
2. Configure your credentials:
    2.1 Create a file called `mariadb-variables.env` in `./docker/mariadb` and set your credentials as described in [the documentation](https://hub.docker.com/_/mariadb)
    2.2 Create a file called `mariadb.php` in `./app/credentials`, returning an array with keys `user` and `password` and their corresponding values
    2.3 Create a file called `phpmyadmin-vars.env` in `./docker/phpmyadmin` and set the same credentials as described in [the documentation](https://hub.docker.com/r/phpmyadmin/phpmyadmin)
3. Start the docker-containers via `docker-compose up -d`
4. There is a phpmyadmin at `localhost:8080` to set up your database

## Setting up the websocket

Run `php public/websocket.php` to start the websocket server on port 8081.

## Configure nginx

This is an example config for nginx. Copy it to `/etc/nginx/site-enabled/testing.raspi-services-tools.local` or where ever you have your nginx vhost config.
```
server {
    listen [::1]:80;

    root /wherever/your/project/root/is;

    server_name testing.raspi-services-tools.local;

    index index.html index.htm index.php;

    error_log /var/log/nginx/error-testing-raspi-services-tools-local.log;

    location / {
        try_files $uri $uri/ /index.php$is_args$args;
    }

    location /ws/ {
         resolver 127.0.0.53;
         proxy_pass http://localhost:8081$request_uri;
         proxy_http_version 1.1;
         proxy_set_header Upgrade $http_upgrade;
         proxy_set_header Connection $http_connection;
    }

    location ~ \.php$ {
        fastcgi_param APP_ENV testing;
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
    }
}
```
