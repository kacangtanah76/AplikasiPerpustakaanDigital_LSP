# BookStock Model & Management Guide

## Overview
Model `BookStock` digunakan untuk tracking dan manajemen stok buku secara terperinci dengan history perubahan stok.

## Database Structure

### Table: `book_stocks`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| buku_id | bigint | Foreign key ke table books |
| stok_awal | integer | Stok awal buku |
| stok_masuk | integer | Total stok yang masuk |
| stok_keluar | integer | Total stok yang keluar (dipinjam) |
| stok_hilang | integer | Total stok yang hilang |
| stok_rusak | integer | Total stok yang rusak |
| stok_saat_ini | integer | Stok saat ini (dihitung otomatis) |
| keterangan | text | Catatan/keterangan |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diubah |

Rumus Stok Saat Ini:
```
stok_saat_ini = stok_awal + stok_masuk - stok_keluar - stok_rusak - stok_hilang
```

## Model Methods

### 1. Relationship
```php
$stock = BookStock::find(1);
$book = $stock->book; // Get related book
```

### 2. Tambah Stok Masuk
```php
$stock = BookStock::where('buku_id', $book_id)->first();
$stock->tambahStokMasuk(5, 'Pembelian buku baru');
```

### 3. Kurangi Stok Keluar (Peminjam)
```php
$stock = BookStock::where('buku_id', $book_id)->first();
$stock->kurangiStokKeluar(2, 'Peminjaman oleh siswa');
// Akan throw exception jika stok tidak cukup
```

### 4. Catat Stok Rusak
```php
$stock = BookStock::where('buku_id', $book_id)->first();
$stock->catatStokRusak(1, 'Halaman robek');
```

### 5. Catat Stok Hilang
```php
$stock = BookStock::where('buku_id', $book_id)->first();
$stock->catatStokHilang(1, 'Hilang saat pengiriman');
```

### 6. Cek Status Stok
```php
$stock = BookStock::find(1);
$status = $stock->getStatusStok();
// Return: 'Habis', 'Terbatas', atau 'Tersedia'
```

### 7. Persentase Stok
```php
$stock = BookStock::find(1);
$percentage = $stock->getPersentaseStok();
// Return: 85.5 (representing 85.5%)
```

## Console Commands

### Command Syntax
```bash
php artisan stock:manage {action} {book_id?} {quantity?}
```

### 1. List Semua Stok
```bash
php artisan stock:manage list
```
Output: Tabel berisi semua buku dengan detail stok

### 2. Tambah Stok
```bash
php artisan stock:manage add 1 5
```
- book_id: 1
- quantity: 5
- System akan ask untuk keterangan

### 3. Kurangi Stok (Keluaran)
```bash
php artisan stock:manage remove 1 2
```
- book_id: 1
- quantity: 2
- System akan ask untuk keterangan

### 4. Catat Kerusakan
```bash
php artisan stock:manage damage 1 1
```
- book_id: 1
- quantity: 1 buku rusak
- System akan ask untuk keterangan kerusakan

### 5. Catat Kehilangan
```bash
php artisan stock:manage lost 1 1
```
- book_id: 1
- quantity: 1 buku hilang
- System akan ask untuk keterangan kehilangan

## Integration dengan Book Model

Model Book memiliki relationship ke BookStock:
```php
$book = Book::find(1);
$stock = $book->stock; // Get BookStock record
```

Setiap perubahan stok di BookStock akan otomatis update field `stok_saat_ini` di table books.

## Usage Examples

### Example 1: Add Stock & Track
```php
use App\Models\BookStock;

$stock = BookStock::where('buku_id', 1)->first();
$stock->tambahStokMasuk(10, 'Pembelian dari penerbit');
// stok_saat_ini otomatis update
```

### Example 2: Handle Peminjaman
```php
try {
    $stock = BookStock::where('buku_id', 1)->first();
    $stock->kurangiStokKeluar(1, 'Peminjaman ke siswa');
} catch (\Exception $e) {
    echo "Stok tidak cukup!";
}
```

### Example 3: Get Status Dashboard
```php
$stocks = BookStock::with('book')->get();
$stocks->each(function($stock) {
    echo $stock->book->judul . ': ' . $stock->getStatusStok();
});
```

## Sample Books (Sudah Dibuat)
1. Laskar Pelangi (10 unit)
2. Sang Pemimpi (8 unit)
3. Negeri 5 Menara (15 unit)
4. Filosofi Teras (12 unit)
5. Bumi Manusia (7 unit)

## Notes
- Semua perubahan stok otomatis di-sync dengan table books
- History perubahan dapat dilihat melalui updated_at dan keterangan
- Validasi stok cukup (tidak bisa minus) sudah built-in
- Status stok otomatis berubah berdasarkan jumlah yang tersedia
