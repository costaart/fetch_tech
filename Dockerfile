# Usar a imagem oficial do PHP
FROM php:8.2-fpm

# Instalar extensões e dependências
RUN apt-get update && apt-get install -y \
    curl libpng-dev libjpeg-dev libfreetype6-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar uma versão mais recente do Node.js
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Atualizar o npm
RUN npm install -g npm@latest

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do Laravel
COPY . .

RUN chown -R www-data:www-data /var/www
# Instalar dependências Node.js
RUN if [ -f package.json ]; then npm install; fi

# Definir permissões
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Expor a porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]

