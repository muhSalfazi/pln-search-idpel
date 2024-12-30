# ⚡ PLN Data TO Web Application

## Deskripsi Proyek
Aplikasi web ini dirancang untuk memudahkan pencarian data pelanggan PLN menggunakan ID pelanggan (IDPEL) atau nomor meter.  
Aplikasi ini memiliki antarmuka yang modern dan responsif, memungkinkan pengguna untuk mengakses informasi dengan cepat dan mudah.

---

## 📸 Tampilan Utama
![PLN Data TO](https://github.com/user-attachments/assets/21392a00-092f-4a32-8a6d-1c3ff993ddb5)
  
*Gambar tampilan halaman pencarian data pelanggan PLN.*

---

## ✨ Fitur Utama
1. **Pencarian Data Pelanggan**  
   - Masukkan ID pelanggan (IDPEL) atau nomor meter pada kolom input.  
   - Klik tombol **"Cari"** untuk mendapatkan informasi pelanggan.  

2. **Riwayat Pencarian**  
   - Menyimpan riwayat pencarian pelanggan sebelumnya agar pengguna bisa mengakses kembali dengan mudah.  

3. **Manajemen Pengguna (Admin Only)**  
   - Admin dapat mengakses dan mengatur daftar pengguna melalui halaman **Users**.  

4. **Pengaturan Akun**  
   - Akses cepat ke halaman **Account Settings** untuk memperbarui informasi akun pengguna.  

5. **Autentikasi dan Keamanan**  
   - **Login dan Logout** dengan konfirmasi SweetAlert.  
   - Halaman login tidak dapat diakses kembali setelah pengguna berhasil masuk (middleware prevent back).  

6. **Responsif dan Modern**  
   - Desain berbasis **TailwindCSS** dan komponen modern untuk pengalaman pengguna yang lebih baik.  

---

## 🚀 Teknologi yang Digunakan
- **Frontend**: TailwindCSS, HTML, Blade Templating (Laravel)  
- **Backend**: Laravel 11  
- **Database**: MySQL / PostgreSQL  
- **Javascript**: SweetAlert2, Animate.css  
