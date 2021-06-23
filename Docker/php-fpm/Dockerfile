FROM php:8.0.3-fpm-alpine
# Apk install
RUN apk --no-cache update && apk --no-cache add bash git zsh
# Install pdo
RUN docker-php-ext-install pdo_mysql
# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php && php -r "unlink('composer-setup.php');" && mv composer.phar /usr/local/bin/composer
# Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

WORKDIR /var/www/html

# Install 
CMD composer install

CMD sleep 40 && symfony console d:s:u --force  && symfony console d:f:l -n

CMD symfony server:start --no-tls 

