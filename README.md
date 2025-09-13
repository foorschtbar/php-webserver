# php-webserver - A PHP Webserver

[
![](https://img.shields.io/docker/v/foorschtbar/php-webserver/latest?style=plastic)
![](https://img.shields.io/docker/pulls/foorschtbar/php-webserver?style=plastic)
![](https://img.shields.io/docker/stars/foorschtbar/php-webserver?style=plastic)
![](https://img.shields.io/docker/image-size/foorschtbar/php-webserver?style=plastic)
](https://hub.docker.com/repository/docker/foorschtbar/php-webserver)
[
![](https://img.shields.io/github/actions/workflow/status/foorschtbar/php-webserver/build.yml?style=plastic)
![](https://img.shields.io/github/languages/top/foorschtbar/php-webserver?style=plastic)
![](https://img.shields.io/github/last-commit/foorschtbar/php-webserver?style=plastic)
![](https://img.shields.io/github/license/foorschtbar/php-webserver?style=plastic)
](https://github.com/foorschtbar/php-webserver)

This is an usefull extension of the official php:\*-apache Docker image.

- GitHub: [foorschtbar/php-webserver](https://github.com/foorschtbar/php-webserver)
- Docker Hub: [foorschtbar/php-webserver](https://hub.docker.com/r/foorschtbar/php-webserver)

## Improvements

... compared to the official image:

- PHP extensions: `mysqli`, `mysql_pdo`, `imap`, `soap`, `imagick`, `yaml` and `op_cache`
- Apache Modules: `mod_rewrite`, `mod_headers`, `mod_remoteip`
- Prepared for use behind a reverse proxy
- `Composer`
- `Python 3` (with extra Docker tag `python`)

## Tags and Versions

| Tag                  | PHP Version | Branch  | Python |
| -------------------- | ----------- | ------- | ------ |
| `latest`             | 8.4         | master  | no     |
| `python`             | 8.4         | master  | yes    |
| `develop`            | 8.4         | develop | no     |
| `8.4`                | 8.4         | master  | no     |
| `8.4-develop`        | 8.4         | develop | no     |
| `8.4-python`         | 8.4         | master  | yes    |
| `8.4-python-develop` | 8.4         | develop | yes    |

## Usage

Example docker-compose configuration:

```yml
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
    ports:
      - 127.0.0.1:<changeme>:3306
    labels:
      - "com.centurylinklabs.watchtower.enable=true"

networks:
  internal:
    external: false
  reverse-proxy:
    external: true
```
