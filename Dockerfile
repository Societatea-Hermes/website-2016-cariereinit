FROM bitnami/laravel:9.5.2

WORKDIR /web

COPY . /web

USER root


RUN composer install --no-scripts
RUN composer update --no-scripts
RUN cp .env.example .env
RUN npm install
RUN php artisan key:generate
RUN php artisan migrate --force 

EXPOSE 8000

CMD [ "php", "artisan", "serve", "--host", "0.0.0.0" ]