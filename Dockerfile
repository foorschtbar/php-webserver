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

# copy php extensions installer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# install php extensions
RUN install-php-extensions \
    @composer \
    mysqli \
    pdo_mysql \
    imap \
    soap \
    opcache \
    imagick

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


ARG PYTHON=no-python
# install python
RUN if [ "$PYTHON" = "python" ]; then \
    set -eux; \
    echo "Build image with python"; \
    apt-get update && apt-get install -y \
    # python
    python2 python-pip python-dev build-essential \
    # cleanup
    && rm -r /var/lib/apt/lists/*; \
    fi

# install python modules
RUN if [ "$PYTHON" = "python" ]; then \
    set -eux; \
    pip2 install js2py pytz tzlocal cfscrape; \
    fi

# overwrite docker entrypoint
COPY ./assets/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT [ "/entrypoint.sh" ]
CMD ["apache2-foreground"]