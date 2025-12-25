# 🎬 CineScope – Movie Review Website

CineScope adalah sebuah website *movie review* berbasis web yang memungkinkan pengguna untuk melihat informasi film, membaca ulasan pengguna lain, serta memberikan rating dan review terhadap film tertentu. Website ini juga dilengkapi dengan **panel admin** untuk mengelola data film, termasuk upload poster dan trailer.

---

## 📌 Fitur Utama

* Menampilkan daftar film lengkap dengan detail informasi
* Menampilkan rating rata-rata dan jumlah ulasan setiap film
* Menambahkan review dan rating film oleh pengguna
* Menampilkan semua ulasan pengguna pada halaman khusus
* Filter ulasan berdasarkan jumlah bintang
* Panel admin untuk menambahkan film baru
* Upload poster dan video trailer film
* API berbasis JSON untuk pengelolaan review
* Desain antarmuka modern dan responsif

---

## 🛠️ Teknologi yang Digunakan

* **Backend**: PHP (Native)
* **Database**: MySQL
* **Frontend**: HTML5, CSS3, JavaScript
* **Database Access**: MySQLi & PDO
* **Web Server**: Apache (XAMPP)
* **Format API**: JSON

---

## 📂 Struktur Folder

```
movie-review/
│
├── config.php              # Konfigurasi & koneksi database
├── api_reviews.php         # API pengelolaan review film
├── all_reviews.php         # Halaman semua ulasan film
├── admin_upload.php        # Panel admin upload film
├── movie_detail.php        # Halaman detail film
├── index.html              # Halaman utama
│
├── uploads/
│   ├── posters/            # Poster film
│   └── videos/             # Video trailer
│
└── README.md               # Dokumentasi proyek
```

---

## ⚙️ Instalasi & Konfigurasi

### 1️⃣ Clone / Download Project

Pindahkan folder `movie-review` ke direktori:

```
C:/xampp/htdocs/
```

### 2️⃣ Jalankan XAMPP

Aktifkan:

* Apache
* MySQL

### 3️⃣ Buat Database

Buat database MySQL dengan nama:

```
movie_review_db
```

### 4️⃣ Import Database

Import file SQL (jika tersedia) ke database `movie_review_db` melalui phpMyAdmin.

### 5️⃣ Konfigurasi Database

Pastikan konfigurasi database sesuai pada file:

* `config.php`
* `admin_upload.php`
* `all_reviews.php`

Contoh konfigurasi:

```php
$host = '127.0.0.1';
$username = 'root';
$password = '';
$dbname = 'movie_review_db';
```

---

## 🚀 Cara Menjalankan Website

* Halaman utama

  ```
  http://localhost/movie-review/
  ```

* Detail film

  ```
  http://localhost/movie-review/movie_detail.php?id=1
  ```

* Semua ulasan film

  ```
  http://localhost/movie-review/all_reviews.php?id=1
  ```

* Admin upload film

  ```
  http://localhost/movie-review/admin_upload.php
  ```

---

## 🔌 API Endpoint (Review)

### GET – Ambil Review Film

```
GET api_reviews.php?action=get&movie_id=1
```

Response:

```json
{
  "success": true,
  "reviews": [],
  "count": 0,
  "average": 0
}
```

### POST – Tambah Review Film

```
POST api_reviews.php
```

Parameter:

* `action=add`
* `movie_id`
* `rating`
* `review_text`

---


