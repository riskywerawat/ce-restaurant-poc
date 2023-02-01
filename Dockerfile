FROM php:8.0.8-fpm

RUN apt-get update -y && apt-get install -y \
        zip \
        unzip \
        npm \
        libmcrypt-dev \
        libfreetype6-dev \
        openssl \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql exif 

RUN pecl install mcrypt 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-enable mcrypt mysqli pdo_mysql pdo exif gd

WORKDIR /app

COPY . /app

RUN composer update --prefer-dist

RUN chmod -R 777 storage && chmod -R 777 vendor && chmod -R 777 public/js/public

RUN npm install

RUN npm run production

RUN npm run admin-production

RUN chmod -R 777 node_modules/v-calendar && chmod -R 777 bootstrap

RUN php artisan cache:clear

CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000