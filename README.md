# 📌 Pcraft LyraMVC - Lightweight PHP MVC Framework

Pcraft LyraMVC adalah framework **MVC ringan** berbasis PHP yang dirancang untuk mempermudah pengembangan aplikasi web dengan arsitektur yang bersih dan terorganisir. Project ini dibuat disaat saya sedang tidak melakukan apa-apa dan dalam kondisi gabutz:V, serta mungkin saja project ini bisa mangkrak seperti project lainnya yang dibuat saat dalam kondisi yang sama ~hehe

---

## 🚀 Instalasi

### 1️⃣ **Persyaratan Sistem**
Sebelum menginstal, pastikan sistem Anda memiliki:
- PHP `^8.0`
- Composer `^2.0`
- MySQL atau database yang kompatibel
- Ekstensi PHP yang dibutuhkan:
  - `pdo_mysql`
  - `mbstring`
  - `openssl`

### 2️⃣ **Menginstal via Composer**
Jalankan perintah berikut untuk menginstal LyraMVC:

```bash
composer create-project pcraft/lyrammvc App --stability=stable
```

Atau, jika terjadi masalah dengan stabilitas, coba dengan versi spesifik:

```bash
composer create-project pcraft/lyrammvc:^1.0 App
```

Setelah selesai, masuk ke folder proyek:

```bash
cd App
```

---

## 🔧 Konfigurasi

### 1️⃣ **Pengaturan Environment (`.env`)**
Konfigurasi utama seperti database disimpan dalam file **`.env`**. :

```
APP_NAME=LyraMVC
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🚀 Menjalankan Server

Gunakan perintah berikut untuk menjalankan **server development**:

```bash
php app run
```

Secara default, server akan berjalan di:

```
http://127.0.0.1:8000
```

Jika ingin mengatur IP dan port secara manual:

```bash
php app run --server=127.0.0.1 --port=8080
```

```bash
php app run --port=8080
```

---

## 🛠 Perintah CLI (`php app`)

Pcraft LyraMVC memiliki beberapa perintah untuk membantu pengembangan:

| Perintah                  | Deskripsi |
|---------------------------|-------------|
| `php app run` | Menjalankan server development (`--server:IP --port:PORT`) |
| `php app migrate` | Menjalankan semua migration yang belum dieksekusi |
| `php app create:migration users` | Membuat file migration baru |
| `php app create:model UserModel` | Membuat file model baru |
| `php app help` | Menampilkan daftar perintah yang tersedia |

---

## 🏗 Struktur Folder

```
App/
│── config/           # Konfigurasi aplikasi
│── public/           # Direktori yang diakses publik (index.php, assets)
│── src/              # Kode utama framework
│   ├── Controllers/  # Controller untuk menangani request
│   ├── Models/       # Model untuk menghubungkan database
│   ├── Views/        # Template tampilan (Twig)
│   ├── Core/         # Kelas utama (Router, Database, CLI, dll.)
│── database/         # File migrasi database
│── vendor/           # Dependensi yang diinstal Composer
│── .env.example      # Contoh file konfigurasi lingkungan
│── composer.json     # File dependensi Composer
│── README.md         # Dokumentasi proyek
│── app               # File CLI untuk menjalankan perintah
```

---

## 🚀 Cara Menggunakan

### 1️⃣ **Membuat Controller**
Buat file controller baru di `src/Controllers/ExampleController.php`:

```php
<?php

namespace Pcraft\Lyrammvc\Controllers;

use Pcraft\Lyrammvc\Core\View;
use Pcraft\Lyrammvc\Models\UserModel;

class ExampleController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->getAll();
        View::render('example', ['users' => $users]);
    }
}
```

Atau gunakan perintah CLI:

```bash
php app create:controller ExampleController
```

Tambahkan route di `src/Core/Router.php`:

```php
$router->get('/users', 'ExampleController@index');
```

---

### 2️⃣ **Membuat Model**
Buat model di `src/Models/UserModel.php`:

```php
<?php

namespace Pcraft\Lyrammvc\Models;

use Pcraft\Lyrammvc\Models\Model;

class UserModel extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct($this->table);
    }
}
```

Atau gunakan perintah CLI:

```bash
php app create:model UserModel
```

---

### 3️⃣ **Migrasi Database**
Untuk membuat file migration baru:

```bash
php app create:migration users
```

Untuk menjalankan semua migration yang belum dieksekusi:

```bash
php app migrate
```

---

## 🎨 View dengan Twig
Tampilan (`.twig`) diletakkan di `src/Views/`. Misalnya, buat `src/Views/example.twig`:

```html
<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
</head>
<body>
    <h1>Daftar Pengguna</h1>
    <ul>
        {% for user in users %}
            <li>{{ user.name }} - {{ user.email }}</li>
        {% endfor %}
    </ul>
</body>
</html>
```

---

## 🏗 Kontribusi
Ingin berkontribusi? Silakan buat **Pull Request** atau **laporkan bug** di **Issues**.

---

## 📄 Lisensi
Proyek ini dirilis di bawah lisensi **MIT**.

---

