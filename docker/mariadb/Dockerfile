FROM mariadb:10.5-focal

COPY docker/mariadb/sql /docker-entrypoint-initdb.d/
COPY docker/mariadb/mariadb.conf /etc/mysql/my.cnf
