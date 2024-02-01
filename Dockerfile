ARG FROM_TAG=8.3-apache

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

# add php extensions installer
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
    @composer \
    mysqli \
    pdo_mysql \
    imap \
    soap \
    opcache \
    Imagick/imagick@master
# to fix imagick amd64 bug https://github.com/mlocati/docker-php-extension-installer/issues/739

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
    python3 python3-pip python3-dev python3-venv build-essential \
    # cleanup
    && rm -r /var/lib/apt/lists/*; \
    fi

# install python modules
RUN if [ "$PYTHON" = "python" ]; then \
    set -eux; \
    python3 -m venv /opt/venv; \
    . /opt/venv/bin/activate; \
    python3 -m pip install js2py pytz tzlocal cfscrape; \
    fi

# overwrite docker entrypoint
COPY ./assets/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT [ "/entrypoint.sh" ]
CMD ["apache2-foreground"]