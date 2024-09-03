FROM php:8.1.29-fpm-alpine

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql mysqli opcache

# Copier la configuration personnalisée pour opcache
COPY opcache.ini $PHP_INI_DIR/conf.d/

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers du projet dans le conteneur
COPY . .

# Assurer les permissions appropriées
RUN chown -R www-data:www-data /var/www/html
