FROM php:7.3-apache

RUN apt-get update && apt-get install -y mariadb-client

# install php extensions
RUN NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
    docker-php-ext-install -j${NPROC} \
    mysqli

# overwrite docker entrypoint
COPY ./docker-cmd.sh /docker-cmd.sh
RUN chmod +x /docker-cmd.sh
CMD /docker-cmd.sh