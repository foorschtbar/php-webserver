# A simple PHP Webserver for Docker #

[
  ![](https://img.shields.io/docker/v/foorschtbar/php-webserver?style=plastic)
  ![](https://img.shields.io/docker/pulls/foorschtbar/php-webserver?style=plastic)
  ![](https://img.shields.io/docker/stars/foorschtbar/php-webserver?style=plastic)
  ![](https://img.shields.io/docker/image-size/foorschtbar/php-webserver?style=plastic)
  ![](https://img.shields.io/docker/cloud/build/foorschtbar/php-webserver?style=plastic)
](https://hub.docker.com/repository/docker/foorschtbar/php-webserver)
[
  ![](https://img.shields.io/github/last-commit/foorschtbar/php-webserver?style=plastic)
](https://github.com/foorschtbar/php-webserver)


This container is simple PHP Webserver for Docker. Please note: I use this image for my own web servers. Everything can change at any time and without notice.

* GitHub: [foorschtbar/php-webserver](https://github.com/foorschtbar/php-webserver)
* Docker Hub: [foorschtbar/php-webserver](https://hub.docker.com/r/foorschtbar/php-webserver)

## Usage ##

Example docker-compose configuration:

```yml
version: "3"

services:
  web:
    image: foorschtbar/php-webserver
    container_name: <changeme>-web
    hostname: <changeme>
    restart: unless-stopped
    volumes:
      - ./data/web:/var/www/html/public
    environment:
      - "UID=1000"
      - "GID=1000"
    labels:
      - "com.centurylinklabs.watchtower.enable=true"
      - "traefik.enable=true"
      # Entrypoint and TLS
      - "traefik.http.routers.<changeme>.entrypoints=https"
      - "traefik.http.routers.<changeme>.rule=Host(`<changeme>`)"
      - "traefik.http.routers.<changeme>.tls.certresolver=le"
      # Loadbalancer
      - "traefik.http.services.<changeme>.loadbalancer.server.scheme=http"
      - "traefik.http.services.<changeme>.loadbalancer.server.port=80"
    networks:
      - internal
      - reverse-proxy
    depends_on:
      - db
      
  db:
    image: mariadb
    command: --transaction-isolation=READ-COMMITTED --binlog-format=ROW
    restart: unless-stopped
    container_name: <changeme>-db
    volumes:
      - ./data/db:/var/lib/mysql
    environment:
      - MYSQL_ROOT_PASSWORD=<changeme>
      - MYSQL_PASSWORD=<changeme>
      - MYSQL_DATABASE=<changeme>
      - MYSQL_USER=<changeme>
    networks:
      - internal
      - mysqlbackup
    ports:
      - 127.0.0.1:<changeme>:3306
    labels: 
      - "com.centurylinklabs.watchtower.enable=true"

networks:
  internal:
    external: false
  mysqlbackup:
    external: true
  reverse-proxy:
    external: true
```
