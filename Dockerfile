FROM php:7.3-apache

# install some packages
RUN apt-get update && apt-get install -y \
    # mariadb
    mariadb-client \
    # for imap
    libc-client-dev libkrb5-dev \
    # cleanup
    && rm -r /var/lib/apt/lists/*

# configure php extensions
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl

# install php extensions
RUN NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
    docker-php-ext-install -j${NPROC} \
    mysqli \
    imap

# modrewirte
RUN a2enmod rewrite

# copy default index.php for testing. getting overwritten from a volume later...
COPY ./assets/index.php /var/www/html/index.php

# configure apache
COPY ./assets/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./assets/ErrorDocument.php /var/www/html_errordocument/ErrorDocument.php

# overwrite docker entrypoint
COPY ./docker-cmd.sh /docker-cmd.sh
RUN chmod +x /docker-cmd.sh
CMD /docker-cmd.sh