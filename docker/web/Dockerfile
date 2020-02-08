FROM php:7.3-apache

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY dariorivera.jobsitychallenge.com.conf /etc/apache2/sites-available/000-default.conf

RUN apt-get -y update \
    && apt-get -y install \
    libpng-dev \
    libzip-dev \
    libxml2-dev \
    iputils-ping \
    vim \
    wget \
    && a2enmod rewrite \
    && docker-php-ext-install pdo_mysql intl gd zip

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

RUN useradd -u ${PUID} -g www-data -m jobsity

# Entry point
USER root
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

CMD tail -f /dev/null
