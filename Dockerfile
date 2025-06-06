FROM php:8.2-apache

# 1. Set working directory
WORKDIR /var/www/html

# Ensure index.php is treated as default
RUN echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

# Enable directory indexing (optional)
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/Options Indexes FollowSymLinks/Options FollowSymLinks/' /etc/apache2/apache2.conf

# 2. Copy files (excluding unnecessary files)
COPY . .

# 3. Install MySQL extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# 4. Enable Apache modules
RUN a2enmod rewrite

# 5. Fix permissions for Apache
RUN chown -R www-data:www-data /var/www/html
