#!/bin/bash

# Fixer les permissions des volumes montés
chown -R www-data:www-data /var/www/html/uploads /var/www/html/logs 2>/dev/null
chmod -R 775 /var/www/html/uploads /var/www/html/logs 2>/dev/null

# Seed des utilisateurs (génère les hashes bcrypt via PHP)
echo "=== Seed utilisateurs ==="
php /var/www/html/docker/seed-users.php
echo "========================="

# Lancer Apache
exec apache2-foreground
