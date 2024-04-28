# Инструкция по запуску:
1. склонировать проект
2. composer install
3. настроить .env по файлу .env-example
4. запустить mysql
5. запустить php командой: php -S localhost:8000
6. запустить миграции командой: php migration.php
7. запустить тесты командой: ./vendor/bin/phpunit ApiTest.php