FROM php:8.2-apache

# Activer les modules Apache nécessaires
RUN a2enmod rewrite headers

# Installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install pdo_mysql intl \
    && docker-php-ext-enable pdo_mysql intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Masquer X-Powered-By PHP
RUN echo "expose_php = Off" > /usr/local/etc/php/conf.d/security.ini

# Copier la config Apache
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copier le code source
COPY . /var/www/html/

# Créer les dossiers nécessaires et fixer les permissions
RUN mkdir -p /var/www/html/uploads/products \
    /var/www/html/uploads/categories \
    /var/www/html/uploads/news \
    /var/www/html/uploads/events \
    /var/www/html/uploads/pages \
    /var/www/html/logs \
    && chown -R www-data:www-data /var/www/html/uploads /var/www/html/logs \
    && chmod -R 775 /var/www/html/uploads /var/www/html/logs

# Script d'entrée : fix permissions + seed users + lancer Apache
COPY docker/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

CMD ["docker-entrypoint.sh"]
