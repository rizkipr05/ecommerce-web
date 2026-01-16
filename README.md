# E-commerce UMKM Nasi Bakar

Aplikasi e-commerce untuk UMKM nasi bakar dengan tiga peran utama (Admin, Seller, Customer). Sistem ini mendukung manajemen produk, stok, pesanan, dan pembayaran manual (tanpa payment gateway). Cocok untuk kebutuhan harian maupun pemesanan acara khusus.

## Tech Stack
- **Backend**: Laravel 10 (PHP)
- **Database**: MySQL
- **Auth**: Laravel Sanctum (API) + session web
- **Frontend**: Blade + Bootstrap 5

## Fitur Utama
### Admin
- Kelola user & role
- Kelola kategori
- Monitoring semua transaksi
- Laporan penjualan global

### Seller
- Kelola produk (nasi bakar/sayuran) sendiri
- Kelola stok & harga
- Kelola ongkir per wilayah
- Melihat pesanan masuk
- Konfirmasi pesanan

### Customer
- Register & login
- Lihat toko & produk
- Keranjang & checkout
- Upload bukti pembayaran
- Tracking pesanan

## Struktur Role
- **Admin**: Akses penuh, manajemen global.
- **Seller**: Akses data toko sendiri.
- **Customer**: Akses belanja & pesanan pribadi.

---

# Instalasi

## 1. Clone Project
```bash
git clone <repo-url>
cd ecommerce-app
```

## 2. Install Dependency
```bash
composer install
```

## 3. Konfigurasi Environment
Salin `.env.example` menjadi `.env` dan sesuaikan DB:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce_db
DB_USERNAME=root
DB_PASSWORD=
```

Generate key:
```bash
php artisan key:generate
```

## 4. Setup Database
Buat database MySQL:
```sql
CREATE DATABASE ecommerce_db;
```

Lalu jalankan migrasi:
```bash
php artisan migrate
```

## 5. Seed Data Awal
Seeder membuat akun admin + sample data.
```bash
php artisan db:seed
```

Akun default:
- Admin: `admin@gmail.com` / `admin123`
- Seller: `seller@umkm.id` / `seller123`
- Customer: `customer@umkm.id` / `customer123`

## 6. Storage Link (Upload Gambar)
```bash
php artisan storage:link
```

## 7. Jalankan Server
```bash
php artisan serve
```

Akses aplikasi:
- Customer: `http://localhost:8000/beranda`
- Admin login: `http://localhost:8000/admin/login`
- Seller login: `http://localhost:8000/seller/login`

---

# Catatan Penting
- **Pembayaran manual**: customer upload bukti pembayaran.
- **Keranjang**: saat ini hanya bisa berisi produk dari satu seller.
- **Ongkir**: dikelola oleh seller per kabupaten/kecamatan.

---

# Testing
Jika dibutuhkan:
```bash
php artisan test
```

---

# Lisensi
Proyek ini dibuat untuk kebutuhan UMKM dan dapat dikembangkan lebih lanjut sesuai kebutuhan.
