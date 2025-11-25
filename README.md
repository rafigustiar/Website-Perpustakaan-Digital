# 📚 Perpustakaan Digital

Perpustakaan Digital adalah aplikasi manajemen buku berbasis **PHP & MySQL** yang mendukung CRUD lengkap, upload cover, serta tampilan modern dan responsif.  
Project ini dibuat sebagai tugas mata kuliah **Pemrograman Web**.

---

## 🚀 Fitur Utama

- Menampilkan daftar buku.
- Menambah buku baru.
- Mengedit data buku.
- Menghapus buku.
- Upload cover buku (JPG/PNG/GIF, max 2MB).
- Validasi form server-side.
- Tampilan dark mode modern & responsif.

---

## 📁 Struktur Folder

project-perpustakaan
- index.php        (read)
- create.php       (create)
- edit.php         (update)
- delete.php       (delete)
- db.php           (koneksi database)
- assets           (css)

---

#  Instalasi & Konfigurasi (Laragon – Windows)

### **1. Jalankan Laragon**
Pastikan:
- Apache: Running  
- MySQL: Running  

### **2. Buat database baru**
Masuk phpMyAdmin → Buat database: perpustakaan_db

### **3. Import database**
Menu **Import** → upload file: perpustakaan_db.sql


### **4. Konfigurasi koneksi (db.php)**

```php
const DB_HOST = '127.0.0.1';
const DB_PORT = '3306';
const DB_NAME = 'perpustakaan_db';
const DB_USER = 'root';
const DB_PASS = '';  // default Laragon kosong
```

#  Instalasi & Konfigurasi (Mamp – MacOS)

### **1. Jalankan Mamp**
Pastikan:
-Running Start Localhost

### **2. Buat database baru**
Masuk phpMyAdmin → Buat database: perpustakaan_db

### **3. Import database**
Menu **Import** → upload file: perpustakaan_db.sql


### **4. Konfigurasi koneksi (db.php)**
```php
const DB_HOST = 'localhost';
const DB_PORT = '8889'; 
const DB_NAME = 'perpustakaan_db';
const DB_USER = 'root';
const DB_PASS = 'root';  // default MAMP
```
### **5. Akes Website**
http://localhost:8888/perpustakaan-digital/

## Dokumentasi
<img width="1512" height="861" alt="Screenshot 2025-11-25 at 22 55 25" src="https://github.com/user-attachments/assets/80fbb1c7-0b1b-4638-8521-188ac173e4a4" />
<img width="1512" height="859" alt="Screenshot 2025-11-25 at 22 55 42" src="https://github.com/user-attachments/assets/7ca23dbe-4298-4dff-901f-e79b47d7ebe9" />
<img width="1512" height="860" alt="Screenshot 2025-11-25 at 22 56 05" src="https://github.com/user-attachments/assets/21893b4b-6089-4bcd-96d4-9e95850388c4" />
<img width="1512" height="860" alt="Screenshot 2025-11-25 at 22 56 48" src="https://github.com/user-attachments/assets/f121974f-47a9-4100-a38b-35db20879d74" />
<img width="1512" height="861" alt="Screenshot 2025-11-25 at 22 57 42" src="https://github.com/user-attachments/assets/7914e12c-9935-4f56-a01f-a577dfe538c9" />
<img width="1512" height="859" alt="Screenshot 2025-11-25 at 22 57 57" src="https://github.com/user-attachments/assets/c957b07b-7d0d-44c1-9f6d-0e3eaced9758" />


