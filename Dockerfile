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

# overwrite docker entrypoint
COPY ./docker-cmd.sh /docker-cmd.sh
RUN chmod +x /docker-cmd.sh
CMD /docker-cmd.sh