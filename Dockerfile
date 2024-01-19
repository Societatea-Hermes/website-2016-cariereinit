FROM bitnami/laravel:9.5.2

WORKDIR /web

COPY . /web

USER root


RUN composer install --no-scripts
RUN composer update --no-scripts
RUN php artisan migrate --force
RUN cp .env.example .env
RUN npm install
RUN php artisan key:generate

EXPOSE 8000

CMD [ "php", "artisan", "serv", "--host", "0.0.0.0" ]