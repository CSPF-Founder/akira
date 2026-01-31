FROM php:8.1-apache

ARG AKIRA_VERSION=latest
ENV PHP_MEMORY_LIMIT=256M

RUN a2enmod rewrite

RUN set -ex; \
    apt-get update; \
    apt-get install -y --no-install-recommends cron libpq-dev libzip-dev pkg-config; \
    docker-php-ext-configure zip --with-zip; \
    docker-php-ext-install pdo pdo_pgsql pgsql zip; \
    apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
    rm -rf /var/lib/apt/lists/*

COPY php.ini /usr/local/etc/php/conf.d/php-akira.ini
COPY akira-cron /etc/cron.d/akira-cron

# https://secure.php.net/manual/en/opcache.installation.php
RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini

RUN curl -fsSL -o akira.tar.gz "https://github.com/CSPF-Founder/akira/archive/refs/tags/${AKIRA_VERSION}.tar.gz" && \
    tar -xzf akira.tar.gz --strip-components=1 -C /var/www/html/ && \
    rm akira.tar.gz

RUN touch /var/www/html/assets/logs/error.log && touch /var/www/html/assets/logs/blacklist.log

RUN chown -R www-data:www-data /var/www/html

RUN chmod 0644 /etc/cron.d/akira-cron \
    && crontab /etc/cron.d/akira-cron \
    && touch /var/log/cron.log

CMD ["sh", "-c", "cron && apache2-foreground"]
