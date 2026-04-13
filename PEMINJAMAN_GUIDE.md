# Sistem Peminjaman Buku - Dokumentasi

## Overview
Sistem peminjaman buku untuk tracking peminjaman, pengembalian, denda otomatis, dan status buku.

## Database Table: `peminjaman_bukus`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | User yang meminjam (FK ke users) |
| book_stock_id | bigint | Buku yang dipinjam (FK ke book_stocks, nullable) |
| kategori | string | Kategori buku (Fabel, Pendidikan, Laporan Karya Ilmiah) |
| judul_buku | string | Judul buku |
| tanggal_peminjaman | datetime | Tanggal dan waktu peminjaman |
| tanggal_kembali_rencana | datetime | Target tanggal pengembalian |
| tanggal_kembali_aktual | datetime | Tanggal actual pengembalian |
| status | enum | Status: dipinjam, dikembalikan, hilang |
| denda | decimal | Denda keterlambatan (dalam Rp) |
| catatan | text | Catatan/keterangan |
| created_at | timestamp | Dibuat saat |
| updated_at | timestamp | Diubah saat |

## Model: PeminjamanBuku

### Relationships
```php
$peminjaman = PeminjamanBuku::find(1);
$user = $peminjaman->user;              // Get User
$bookStock = $peminjaman->bookStock;    // Get BookStock
```

### Methods

#### 1. Get Status Warna
```php
$peminjaman = PeminjamanBuku::find(1);
$warna = $peminjaman->getStatusWarna();
// Returns: 'warning' (dipinjam), 'success' (dikembalikan), 'danger' (hilang)
```

#### 2. Check Terlambat
```php
$peminjaman = PeminjamanBuku::find(1);
if ($peminjaman->isTerlambat()) {
    echo "Peminjaman terlambat!";
}
```

#### 3. Calculate Denda
```php
$peminjaman = PeminjamanBuku::find(1);
$denda = $peminjaman->calculateDenda($hargaPerHari = 10000);
// Default: Rp 10,000 per hari
```

#### 4. Mark as Returned
```php
$peminjaman = PeminjamanBuku::find(1);
$peminjaman->markAsReturned();
// Otomatis:
// - Set tanggal_kembali_aktual = now()
// - Set status = 'dikembalikan'
// - Hitung denda jika terlambat
// - Increment stok di BookStock
```

#### 5. Mark as Lost
```php
$peminjaman = PeminjamanBuku::find(1);
$peminjaman->markAsLost('Catatan kehilangan buku');
// Otomatis:
// - Set status = 'hilang'
// - Catat stok hilang di BookStock
```

## Filament Admin Panel

### Menu
- Akses di: **Peminjaman Buku** (di sidebar)

### Form Input
**Bagian 1: Informasi Peminjam**
- Pilih nama peminjam (dropdown dari users)

**Bagian 2: Data Buku**
- Pilih buku dari BookStock (auto-fill kategori & judul)
- Kategori dan judul otomatis terisi saat select buku

**Bagian 3: Tanggal Peminjaman**
- Tanggal peminjaman (default: sekarang)
- Tanggal kembali rencana (harus >= tanggal peminjaman)

**Bagian 4: Riwayat Pengembalian**
- Tanggal kembali aktual (hanya saat status='dikembalikan')
- Status: Dipinjam / Dikembalikan / Hilang
- Denda (read-only, otomatis dihitung)

**Bagian 5: Catatan**
- Catatan/keterangan tambahan

### Tabel
Kolom yang ditampilkan:
- ID
- Nama Peminjam (searchable)
- Kategori (badge dengan warna)
- Judul Buku (searchable)
- Tanggal Pinjam
- Tanggal Kembali Plan
- Status (badge: Warning/Success/Danger)
- Denda (format Rp)

### Filter
- Status: Dipinjam / Dikembalikan / Hilang
- Kategori: Fabel / Pendidikan / Laporan Karya Ilmiah

### Actions
- **Edit** - Update data peminjaman
- **Tandai Dikembalikan** (hanya status dipinjam)
  - Auto-increment stok
  - Auto-hitung denda
  - Confirm dialog
- **Tandai Hilang** (hanya status dipinjam)
  - Ask for "Catatan Kehilangan"
  - Update stok hilang

## Fitur Otomatis

### 1. Decrement Stok Peminjaman
Saat membuat peminjaman baru dengan book_stock_id:
- Otomatis kurangi `stok_saat_ini` di BookStock
- Catat di keterangan: "Dipinjam"

### 2. Increment Stok Return
Saat mark as returned:
- Otomatis tambah `stok_saat_ini` di BookStock
- Catat di keterangan: "Buku dikembalikan"

### 3. Tracking Stok Hilang
Saat mark as lost:
- Otomatis catat stok hilang di BookStock
- Update status peminjaman ke 'hilang'

### 4. Denda Otomatis
Rumus denda:
```
Jika tanggal_kembali_aktual > tanggal_kembali_rencana:
  hari_terlambat = tanggal_kembali_aktual - tanggal_kembali_rencana
  denda = hari_terlambat × Rp 10,000
```

Default: Rp 10,000 per hari (bisa dikustomisasi di method)

## Query Examples

### Get Active Peminjaman
```php
$aktivePeminjaman = PeminjamanBuku::where('status', 'dipinjam')->get();
```

### Get Terlambat
```php
$terlambat = PeminjamanBuku::where('status', 'dipinjam')
    ->where('tanggal_kembali_rencana', '<', now())
    ->get();
```

### Total Denda per User
```php
$totalDenda = PeminjamanBuku::where('user_id', 1)
    ->where('status', 'dikembalikan')
    ->sum('denda');
```

### Get by Kategori
```php
$peminjamanFabel = PeminjamanBuku::where('kategori', 'Fabel')->get();
```

## Relasi Database
```
users
  ├─ peminjaman_bukus (1:Many)
  
book_stocks
  ├─ peminjaman_bukus (1:Many)
  
peminjaman_bukus
  ├─ user (belongsTo)
  └─ bookStock (belongsTo)
```

## Notes
- Stok otomatis tersync antara BookStock dan peminjaman
- Denda calculated otomatis berdasarkan keterlambatan
- Status tracking lengkap: dipinjam → dikembalikan atau hilang
- History peminjaman tersimpan lengkap dengan timestamps
