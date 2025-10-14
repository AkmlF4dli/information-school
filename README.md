# 🏫 Information School - Sistem Informasi Sekolah & Manajemen Ekstrakurikuler

Aplikasi **Information School** adalah sistem manajemen sekolah yang terintegrasi untuk mendukung:
- Manajemen absensi siswa & guru
- Pengelolaan ekstrakurikuler (eskul)
- Dokumentasi kegiatan & kedisiplinan
- Dashboard kesiswaan, pembina, pelatih, ketua, dan siswa

Aplikasi ini dikembangkan menggunakan **Laravel**, **MySQL**, dan dijalankan melalui **Docker** untuk kemudahan deployment.

---

## 🚀 Fitur Utama

### 1. Dashboard Piket
- Menampilkan data **kehadiran** dan **ketidakhadiran** siswa.
- Menampilkan data **keterlambatan** dan **kedisiplinan**.
- Tersedia tombol **Cari Siswa** untuk memantau data individual.

### 2. Dashboard Ekstrakurikuler (Eskul)
- Menampilkan **gambar**, **nama eskul**, **aktivitas**, **jadwal**, dan **jam kegiatan**.
- Tersedia **pengurus**, **pembina**, dan **pelatih** yang dapat dikelola langsung.
- Fitur **tambah member** oleh pembina.

### 3. Dashboard Pelatih
- Fitur **edit data pelatih**.
- Dapat menambahkan **jadwal** dan **materi** kegiatan eskul.
- Melakukan **absensi** anggota.

### 4. Dashboard Siswa
- Dapat melihat **jadwal eskul**, **materi**, dan melakukan **absensi eskul**.
- Menampilkan daftar kegiatan dan kehadiran siswa dalam kegiatan eskul.

### 5. Dashboard Pembina
- Membuat dan melihat **uraian kegiatan eskul**.
- Dapat menambahkan **aktivitas eskul** serta memantau absensi pelatih & siswa.

### 6. Dashboard Ketua Eskul
- Melakukan **absensi anggota eskul**.
- Mencatat **aktivitas dan dokumentasi kegiatan eskul**.

### 7. Dashboard Admin
- Mengelola seluruh **data eskul**, termasuk pembina, pelatih, dan anggota.
- Melihat **daftar eskul** dan aktivitas seluruhnya.
- Mengelola **akun pengguna** dan **role**.

### 8. Dashboard Kesiswaan
- Role khusus untuk melihat seluruh aktivitas ekstrakurikuler.
- Dapat memantau **absensi, kegiatan, dan dokumentasi foto** semua eskul.
- Hanya memiliki hak akses **view-only** (melihat, tidak mengedit).

---

## 🧱 Struktur Role Pengguna

| Role         | Deskripsi                                                                 |
|---------------|---------------------------------------------------------------------------|
| **Admin**     | Mengelola semua data, user, eskul, dan absensi                            |
| **Kesiswaan** | Melihat seluruh kegiatan eskul dan absensi (read-only)                    |
| **Pembina**   | Membuat uraian kegiatan, mengabsen, dan menambah anggota                  |
| **Pelatih**   | Mengelola jadwal dan materi serta absensi pelatihan                       |
| **Ketua**     | Mengabsen anggota eskul dan mencatat kegiatan                             |
| **Siswa**     | Melihat jadwal dan melakukan absensi eskul                                |

---

## ⚙️ Langkah-langkah Deploy Menggunakan Docker

### 🧩 Prasyarat
Pastikan sudah menginstal:
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- [Git Bash](https://git-scm.com/downloads)

---

### 🧭 Langkah Deploy

1. **Clone Repository**
   ```bash
   git clone https://github.com/AkmlF4dli/information-school.git
   cd information-school
   docker-compose build --no-cache
   mv .env.sample .env
   rm -rf public/storage
   docker-compose up -d
   docker-compose exec app rm -rf public/storage
   docker-compose exec app composer update
   docker-compose exec app php artisan migrate --force
   docker-compose exec app php artisan db:seed --class='DatabaseSeeder'
   docker-compose exec app php artisan db:seed --class='Cabangeskul' 
   docker-compose exec app php artisan storage:link


