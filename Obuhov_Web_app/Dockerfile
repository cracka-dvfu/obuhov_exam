# Берём готовый образ PHP 8.1 с Apache внутри
FROM php:8.1-apache

# Устанавливаем расширение mysqli — оно нужно, чтобы PHP умел работать с MySQL
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Код приложения монтируется через volume в docker-compose,
# поэтому копировать тут ничего не нужно.

# Apache слушает 80 порт внутри контейнера
EXPOSE 80
