ARG FROM_TAG

FROM php:$FROM_TAG

# update image
RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y --with-new-pkgs; \
    apt-get install -y --no-install-recommends \
    vim \
    wget; \
    rm -rf /var/lib/apt/lists/*

# confige php
RUN set -eux; \
    mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY ./assets/php.ini $PHP_INI_DIR/conf.d/000-default.ini

# install some packages
RUN set -eux; \
    apt-get update && apt-get install -y \
    # mariadb
    mariadb-client \
    # for imap
    libc-client-dev libkrb5-dev \
    # for soap
    libxml2-dev \
    # cleanup
    && apt-get clean -y && rm -r /var/lib/apt/lists/*

# configure php extensions
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl

# install php extensions
RUN NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
    docker-php-ext-install -j${NPROC} \
    mysqli \
    pdo_mysql \
    imap \
    soap

# install composer
RUN set -eux; \
    EXPECTED_CHECKSUM="$(wget -q -O - https://composer.github.io/installer.sig)"; \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"; \
    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then \
    >&2 echo 'ERROR: Invalid installer checksum'; \
    rm composer-setup.php; \
    exit 1; \
    fi; \
    php composer-setup.php --quiet; \
    RESULT=$?; \
    mv composer.phar /usr/local/bin/composer; \
    rm composer-setup.php; \
    exit $RESULT

# confige apache
RUN set -eux; \
    a2enmod rewrite; \
    a2enmod headers; \
    a2enmod remoteip; \
    rm -r /var/www/html; \
    mkdir -p /var/www/html/public /var/www/html_error; \
    chown -R www-data:www-data /var/www
COPY ./assets/index.php /var/www/html/public/index.php
COPY ./assets/errordoc.php /var/www/html_error/errordoc.php
COPY ./assets/apache.conf $APACHE_CONFDIR/sites-available/000-default.conf


ARG PYTHON=False
# install python
RUN if [ "$PYTHON" = "True" ]; then \
    set -eux; \
    echo "Build image with python"; \
    apt-get update && apt-get install -y \
    # python
    python2 python-pip python-dev build-essential \
    # cleanup
    && rm -r /var/lib/apt/lists/*; \
    fi

# install python modules
RUN if [ "$PYTHON" = "True" ]; then \
    set -eux; \
    pip2 install js2py pytz tzlocal cfscrape; \
    fi

# overwrite docker entrypoint
COPY ./assets/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT [ "/entrypoint.sh" ]
CMD ["apache2-foreground"]