# E-KATALOG

## Persyaratan

-   PHP >= 7.1
-   Install Composer
      ```bash
      https://getcomposer.org/Composer-Setup.exe
      ```
-   Laravel

## Instalasi

1. Clone repositori

    ```bash
    git clone https://github.com/fandiap13/e-katalog.git
    cd repository
    ```

2. Install dependensi
    ```
    composer install
    ```
3. Konfigurasi environment
    ```
    cp .env.example .env
    php artisan key:generate
    ```
4. Buat database `db_katalog` dan setting file .env
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_katalog
   ```
6. Migrasi database
    ```
    php artisan migrate
    ```
7. Jalankan server lokal

    ```
    php artisan serve
    ```
