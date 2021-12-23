FROM php:7.4-fpm-alpine AS php-fpm
LABEL Description="app"
ENV TZ Europe/Kiev
ENV PATH /scripts:/scripts/aliases:$PATH
ENV PHP_REDIS_VERSION 5.2.0
#ENV PHP_IMAGICK_VERSION 3.4.4
ENV BUILD_DEPS autoconf cmake file g++ gcc libc-dev pcre-dev make pkgconf re2c
	#for imagick
#	imagemagick-dev

ENV PERSISTENT_DEPS bash nano tzdata git \
# for intl extension
icu-dev \
# for pgsql
postgresql-dev
# for imagick
#imagemagick

RUN set -xe \
&& ln -s /usr/lib /usr/local/lib64 \
&& apk add --no-cache --update --virtual .persistent-deps $PERSISTENT_DEPS \
&& apk add --no-cache --update --virtual .build-deps $BUILD_DEPS

ENV MEMCACHED_DEPS zlib-dev libmemcached-dev cyrus-sasl-dev
RUN apk add --no-cache --update libmemcached-libs zlib
RUN set -xe \
    && apk add --no-cache --update --virtual .phpize-deps $PHPIZE_DEPS \
    && apk add --no-cache --update --virtual .memcached-deps $MEMCACHED_DEPS \
    && pecl install memcached \
    && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/20_memcached.ini \
    && rm -rf /usr/share/php7 \
    && rm -rf /tmp/* 

RUN docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install -j$(nproc) tokenizer bcmath intl pcntl pdo_pgsql opcache \
    && echo -e "opcache.memory_consumption=128\n\
		opcache.interned_strings_buffer=8\n\
		opcache.max_accelerated_files=4000\n\
		opcache.revalidate_freq=60\n\
		opcache.fast_shutdown=1\n\
		opcache.enable_cli=1\n\
		opcache.enable=1\n" > /usr/local/etc/php/conf.d/opcache.ini

#install php-redis
RUN git clone --branch ${PHP_REDIS_VERSION} https://github.com/phpredis/phpredis /tmp/phpredis \
	&& cd /tmp/phpredis && phpize && ./configure && make && make install && make test \
	&& echo 'extension=redis.so' > /usr/local/etc/php/conf.d/redis.ini

#install imagick
#RUN git clone -o ${PHP_IMAGICK_VERSION} --depth 1 https://github.com/Imagick/imagick.git /tmp/imagick \
#	&& cd /tmp/imagick && phpize && ./configure && make && make install \
#	&& echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini

# Install mbstring extension
RUN apk add --no-cache \
    oniguruma-dev \
    && docker-php-ext-install mbstring \
    && docker-php-ext-enable mbstring \
    && rm -rf /tmp/*

# Setup GD extension
RUN apk add --no-cache \
      freetype \
      openssh \
      sudo \
      ffmpeg \
      libjpeg-turbo \
      libpng \
      libwebp \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
      libwebp-dev \
    && docker-php-ext-configure gd \
      --with-freetype \
#      --with-png \
      --with-jpeg \
      --with-webp \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && apk del --no-cache \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && rm -rf /tmp/*

#clear deps and prepare folders
RUN apk del .build-deps \
    && rm -rf /tmp/* \
    && rm -rf /app \
    && mkdir /app \
    && rm -rf /scripts \
    && mkdir /scripts \
    && mkdir -p /scripts/aliases \
    && rm -rf /home/user \
&& mkdir /home/user \
&& chmod 777 /home/user \
    && rm -f /docker-entrypoint.sh \
    && rm -f /usr/local/etc/php-fpm.d/*

#COPY ./supervisor/supervisord.conf /etc/supervisord.conf
#COPY ./supervisor/conf.d/ /etc/supervisor/conf.d/
COPY ./etc/php/php.ini /usr/local/etc/php/php.ini
COPY ./etc/php/php-fpm.conf /usr/local/etc/php-fpm.conf
#COPY ./keep-alive.sh /scripts/keep-alive.sh
#COPY ./scheduler.sh /scripts/scheduler.sh
COPY ./fpm-entrypoint.sh /fpm-entrypoint.sh
#COPY ./aliases/* /scripts/aliases/
#COPY ./cron/* /etc/cron.d/

#RUN crontab /etc/cron.d/scheduler-cron


# Installing composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
RUN set -xe && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#Installing nodejs npm
#RUN set -xe && apk add --no-cache --update nghttp2-dev nodejs npm unzip

WORKDIR /app
ENTRYPOINT []

USER root

EXPOSE 9001
CMD [""]
