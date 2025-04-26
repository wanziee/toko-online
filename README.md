## 🛒 Toko Online

<p align="center"><img src="public/backend/image/logo_ubsi.png" width="200" alt="Logo UBSI"></p>
<p align="center"><img src="public/backend/image/logo_text2.png" width="300" alt="Text Logo Project"></p>

## 📌 Pengenalan

Project ini merupakan project Laravel pada mata kuliah Web Programming III di Universitas Bina Sarana Informatika yang bertemakan tentang Toko Online.

## ✅ Kebutuhan Sistem

Sebelumnya pastikan menginstall terlebih dahulu kebutuhan sistem untuk menggunakan project ini.

-   Git
-   Composer
-   Code Editor _(VS Code, Sublime, dll)_
-   Web Server _(Laragon, XAMPP, dll)_
-   Web Browser _(Chrome, Firefox, dll)_

## ⚙️ Instalasi Project

1. Cloning repository ini melalui terminal. Tunggu hingga selesai cloning.

```
https://github.com/wanziee/toko-online.git
```

2.  Buka project menggunakan Code Editor, lalu inisiasi dependensi composer melalui terminal.

```
composer install
```

3. Duplikat file `.env.example` menjadi `.env` dan konfigurasikan koneksi database menjadi seperti ini pada file `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_tokoonline
DB_USERNAME=root
DB_PASSWORD=
```

4. Generate key aplikasi pada env melalui terminal.

```
php artisan key:generate
```

5. Generate Storage Link melalui terminal agar dapat mengakses storage.

```
php artisan storage:link
```

6. Migrasikan tabel beserta seeder melalui terminal.

```
php artisan migrate:fresh --seed
```

## 🖼️ Screenshot

<table width="100%">
<tr>
<td><h3 align="center">(admin)Login</h3><img src="public/backend/image/screenshot/ss_login.png"></td>
<td><h3 align="center">(admin)Home</h3><img src="public/backend/image/screenshot/ss_home.png"></td>
</tr>
<tr>
<td><h3 align="center">(admin)User</h3><img src="public/backend/image/screenshot/ss_user.png"></td>
<td><h3 align="center">(admin)Kategori</h3><img src="public/backend/image/screenshot/ss_kategori.png"></td>
</tr>
<tr>
<td><h3 align="center">(admin)Produk</h3><img src="public/backend/image/screenshot/ss_produk.png"></td>
<td><h3 align="center">(user)Dashboard</h3><img src="public/backend/image/screenshot/ss_user_dashboard.png"></td>
</tr>
<tr>
<td><h3 align="center">(user)Produk Detail</h3><img src="public/backend/image/screenshot/ss_produk_detail.png"></td>
<td><h3 align="center">(user)login using Firebase</h3><img src="public/backend/image/screenshot/ss_user_login.png"></td>
</tr>

<!-- <tr>
<td><h3 align="center">Laporan User</h3><img src="public/backend/image/screenshot/ss_laporan_user.png"></td>
<td><h3 align="center">Laporan Produk</h3><img src="public/backend/image/screenshot/ss_laporan_produk.png"></td>
</tr> -->
</table>

## 📄 Lisensi

Project ini mengacu pada modul praktik dari mata kuliah Web Programming III Universitas Bina Sarana Informatika (UBSI). Project ini bersifat open-source untuk edukasi.

<blockquote>Kuliah...? BSI AJA !!</blockquote>
