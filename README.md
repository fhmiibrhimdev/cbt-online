# CBT Online - Sistem Ujian Berbasis Komputer

![image](https://github.com/fhmiibrhimdev/livewire-3/assets/129714988/a8977834-c67a-466b-a36c-946f44e42852)

CBT Online adalah aplikasi Ujian Berbasis Komputer yang dibangun dengan **Laravel 11** dan **Livewire 3**. Aplikasi ini menyediakan solusi lengkap untuk manajemen ujian sekolah, mulai dari pengelolaan bank soal, penjadwalan, pelaksanaan ujian oleh siswa, hingga rekapitulasi nilai.

Sistem ini mendukung **Multi-Authentication** (Administrator, Guru, Siswa) dan dirancang dengan antarmuka yang modern dan responsif.

## Fitur Unggulan

-   **Manajemen Bank Soal & Jadwal**: Buat soal dan atur jadwal ujian dengan mudah.
-   **Ujian Online Real-time**: Siswa dapat mengerjakan ujian dengan sistem token dan timer.
-   **Monitoring Ujian**: Admin dapat memantau status peserta ujian.
-   **Cetak Dokumen**: Kartu peserta, absen, dan rekap nilai otomatis.
-   **Multi-Role**: Akses terpisah untuk Admin, Guru, dan Siswa.

## Prasyarat

Pastikan Anda sudah menginstall berikut ini di sistem Anda:

-   PHP 8.1+
-   [Composer](https://getcomposer.org/)
-   [Node.js](https://nodejs.org/)

## Instalasi

Ikuti langkah-langkah di bawah ini untuk mengatur dan menjalankan proyek ini di mesin lokal Anda.

1. Clone repositori ini

    ```bash
    git clone https://github.com/fhmiibrhimdev/cbt-online.git
    cd cbt-online
    ```

2. Buka Terminal, lalu Install dependencies PHP menggunakan Composer

    ```bash
    composer install
    ```

3. Install dependencies JavaScript menggunakan NPM dan build asset

    ```bash
    npm install
    npm run dev
    ```

4. Salin file `.env.example` menjadi `.env`

    ```bash
    cp .env.example .env
    ```

5. Buka file `.env` dan lakukan perubahan berikut:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=

    SESSION_DRIVER=file
    ```

6. Buat aplikasi key baru

    ```bash
    php artisan key:generate
    ```

7. Buat symbolic link untuk storage
    ```bash
    php artisan storage:link
    php artisan migrate:fresh --seed
    ```

## Penggunaan

Setelah menyelesaikan langkah-langkah instalasi di atas, jalankan server lokal menggunakan perintah berikut:

```bash
php artisan serve
```

Aplikasi akan dapat diakses di http://localhost:8000.
