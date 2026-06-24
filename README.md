# SIMOM — Sistem Informasi Manajemen Organisasi Mahasiswa

## Deskripsi
Aplikasi web manajemen organisasi mahasiswa berbasis Laravel 12 + Tailwind CSS + MySQL.

---

## Teknologi
- **Laravel 12** — Backend Framework
- **Laravel Breeze** — Autentikasi (Blade + Alpine.js)
- **Tailwind CSS** — Styling
- **MySQL** — Database
- **CKEditor 5** — Editor notulensi rapat
- **Alpine.js** — Interaktivitas UI (bundled dengan Breeze)

---

## Fitur Utama
| Modul | Fitur |
|---|---|
| Dashboard | Multi-role: Admin / Kepala Departemen / Anggota |
| Departemen & Anggota | CRUD departemen, anggota, program kerja + progress tracking |
| Rapat Akbar | Penjadwalan, presensi online, notulensi CKEditor, dokumentasi |
| Inventaris | CRUD barang, pengajuan peminjaman, workflow approval |
| Berkas | Upload/download/preview dokumen organisasi |

---

## Akun Default Setelah Seeder

| Role | Email | Password |
|---|---|---|
| Admin Utama | admin@simom.ac.id | password |
| Kepala PSDM | rizky.maulana.hakim@student.simom.ac.id | password |
| Kepala Media | gilang.permana.putra@student.simom.ac.id | password |
| Kepala Pendidikan | arif.budi.santoso@student.simom.ac.id | password |
| Kepala Inventaris | hendra.gunawan.wijaya@student.simom.ac.id | password |
| Anggota/Staff | nadia.kusuma.dewi@student.simom.ac.id | password |

---

## Cara Instalasi

### 1. Buat project Laravel 12 baru
```bash
composer create-project laravel/laravel:^12 simom
cd simom
```

### 2. Install Laravel Breeze
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

### 3. Copy semua file dari paket SIMOM ini
Salin seluruh isi folder `simom/` ke dalam project Laravel yang baru dibuat.
File yang di-copy akan **menimpa** file bawaan Laravel (itu wajar).

### 4. Install dependency frontend
```bash
npm install
npm run dev
```

### 5. Konfigurasi environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuaikan database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simom_db
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Buat database
```sql
CREATE DATABASE simom_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 7. Jalankan migrasi & seeder
```bash
php artisan migrate:fresh --seed
```

### 8. Link storage untuk file upload
```bash
php artisan storage:link
```

### 9. Jalankan server
```bash
php artisan serve
npm run dev
```

Akses di: **http://127.0.0.1:8000**

---

## Urutan File Migrasi
File migrasi harus dijalankan dalam urutan berikut:
1. `2024_01_01_000000_create_departemens_table.php`
2. `*_create_users_table.php` (bawaan Breeze)
3. `2024_01_01_000001_add_fields_to_users_table.php`
4. `2024_01_01_000002_create_program_kerjas_table.php`
5. `2024_01_01_000003_create_rapat_akbars_table.php`
6. `2024_01_01_000004_create_inventaris_table.php`
7. `2024_01_01_000005_create_berkas_table.php`

> **Penting:** Pastikan tanggal prefix migrasi departemen (`000000`) lebih awal dari migrasi `users`, karena users memerlukan foreign key ke departemens.

---

## Struktur Folder Kustom

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php
│   │   ├── DepartemenController.php
│   │   ├── RapatAkbarController.php
│   │   ├── InventarisController.php
│   │   └── BerkasController.php
│   └── Middleware/
│       └── CheckRole.php
└── Models/
    ├── User.php
    ├── Departemen.php
    ├── ProgramKerja.php
    ├── RapatAkbar.php
    ├── Presensi.php
    ├── NotulensiRapat.php
    ├── DokumentasiRapat.php
    ├── Inventaris.php
    ├── PeminjamanInventaris.php
    └── Berkas.php

database/
├── migrations/         ← 6 file migrasi kustom
└── seeders/
    └── DatabaseSeeder.php   ← Data dummy lengkap

resources/views/
├── layouts/app.blade.php   ← Layout utama + sidebar
├── dashboard/
│   ├── admin.blade.php
│   ├── kepala.blade.php
│   └── anggota.blade.php
├── departemen/
│   ├── index.blade.php
│   ├── anggota.blade.php
│   ├── create-anggota.blade.php
│   ├── edit-anggota.blade.php
│   └── proker.blade.php
├── rapat/
│   ├── index.blade.php
│   ├── show.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── presensi.blade.php
│   └── notulensi.blade.php
├── inventaris/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   ├── peminjaman.blade.php
│   └── ajukan.blade.php
└── berkas/
    ├── index.blade.php
    ├── create.blade.php
    └── show.blade.php

routes/web.php          ← Semua route + RBAC middleware
bootstrap/app.php       ← Registrasi middleware alias 'role'
```

---

## RBAC Summary

| Role | Dashboard | CRUD Anggota | Kelola Proker | Rapat | Ajukan Pinjam | Approve Pinjam | CRUD Inventaris | CRUD Berkas |
|---|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| Admin | ✅ Full | ✅ | ✅ Semua dep | ✅ CRUD | ✅ | ✅ | ✅ | ✅ |
| Kepala Dep. | ✅ Partial | ❌ | ✅ Dep sendiri | ✅ View + presensi | ✅ | ❌ | ❌ | ❌ |
| Kepala Inventaris | ✅ Partial | ❌ | ✅ Dep sendiri | ✅ View + presensi | ✅ | ✅ | ✅ | ❌ |
| Anggota/Staff | ✅ Simple | ❌ | ❌ | ✅ View + presensi | ❌ | ❌ | ❌ | ❌ |

---

## Catatan Pengembangan
- Menggunakan **Alpine.js** (bundled Breeze) untuk dropdown, modal, dan toggle
- **CKEditor 5** dimuat via CDN untuk editor notulensi
- File upload disimpan di `storage/app/public/` dengan symlink ke `public/storage`
- Pagination menggunakan Tailwind theme dari Breeze
- Semua form menggunakan CSRF protection `@csrf`

---

*SIMOM v1.0 — Dibuat untuk keperluan tugas kuliah Pemrograman Web / Rekayasa Perangkat Lunak*
