# E-KATALOG

## Prasyarat

-   PHP >= 7.1
-   Composer
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
4. Buat database `db_katalog` dan setting env
   ```bash
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
