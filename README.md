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
1. Configure a virtualhost on your local machine to handle webconnections for the backend
2. Configure your credentials:
    2.1 Create a file called `mariadb-variables.env` in `./docker/mariadb` and set your credentials as described in [the documentation](https://hub.docker.com/_/mariadb)
    2.2 Create a file called `mariadb.php` in `./app/credentials`, returning an array with keys `user` and `password` and their corresponding values
    2.3 Create a file called `phpmyadmin-vars.env` in `./docker/phpmyadmin` and set the same credentials as described in [the documentation](https://hub.docker.com/r/phpmyadmin/phpmyadmin)
3. Start the docker-containers via `docker-compose up -d`
4. There is an phpmyadmin at `localhost:8080` to set up your database