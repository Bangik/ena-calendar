
# Project Kalender Event

Backend Dikembangkan dengan bahasa pemograman PHP 7.4 dan Framework Laravel 8

Frontend Dikembangkan dengan html dan JS serta library fullcalendar.JS 5.11
## Cara install kalender event backend

Download Zip

Install dependencies

```bash
  composer install
```

Copy file .env.example dan rename menjadi .env

```bash
  cp .env.example .env
```

Edit .env file dan sesuaikan kredensial database postgres

Generate key

```bash
  php artisan key:generate
```

Migrasi database

```bash
  php artisan migrate
```

Jalankan project

```bash
  php artisan serve
```

Jika database diimport secara langsung ke postgres, maka tidak perlu menjalankan perintah migrasi database dan import data simulasi

## Cara install kalender event frontend
Download Zip file

Extract zip file ke dalam folder mana saja, disarankan extract ke dalam folder htdocs xampp atau folder server

Ubah value dari variabel baseURL yang terdapat pada file js/index.js sesuai dengan URL backend

Buka file index.html di browser
## 🚀 About Me
Jika terdapat kendala, dapat menghubungi Dino +62 812 5236 7128

