# E-KATALOG

## Prasyarat

-   PHP >= 7.1
-   Composer
-   Laravel

## Instalasi

1. Clone repositori

    ```bash
    git clone https://github.com/fandiap13/test-pegawai.git
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
4. Buat database `db_katalog`
5. Migrasi database
    ```
    php artisan migrate
    ```
6. Jalankan server lokal

    ```
    php artisan serve
    ```
