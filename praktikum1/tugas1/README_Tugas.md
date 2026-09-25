# Tugas 1

### biodata1.php
Modifikasi yang Dilakukan:
1. Penambahan Field Baru: Menambahkan input dan penanganan data untuk Program Studi dan Email.
2. Validasi & Styling: Menambahkan styling CSS agar tampilan kartu biodata lebih rapi dan menarik.

### kalkulator1.php
Modifikasi yang Dilakukan:
1. Kondisi & Operasi Baru: Menambahkan operasi Modulus (%) dan Pangkat (^).
2. Validasi Pembagian: Menambahkan pengecekan agar pembagian atau modulus dengan angka 0 tidak menyebabkan error (division by zero).

### Penjelasan 5 Bagian Kode Paling Penting
1. $_SERVER["REQUEST_METHOD"] == "POST"
Mengecek apakah form dikirim menggunakan metode HTTP POST. Bagian ini mencegah kode pemrosesan PHP berjalan secara otomatis sebelum pengguna menekan tombol submit.

2. htmlspecialchars(...)
Digunakan untuk menyaring (sanitize) input teks dari pengguna sebelum ditampilkan kembali pada layar. Hal ini penting untuk mencegah celah keamanan Cross-Site Scripting (XSS).

3. is_numeric($angka1) && is_numeric($angka2)
Memastikan data yang dikirimkan oleh pengguna benar-benar berupa angka sebelum dilakukan perhitungan matematika, mencegah terjadinya type error di PHP.

4. if ($angka2 == 0) { ... } (Validasi Pembagian & Modulus)
Mengecek penyebut saat melakukan operasi pembagian/modulus. Tanpa validasi ini, pembagian dengan angka 0 akan memicu error kritikal (DivisionByZeroError) pada PHP 8+.

5. pow($angka1, $angka2)
Fungsi bawaan PHP untuk menghitung perpangkatan, di mana $angka1 sebagai basis dan $angka2 sebagai eksponen.

### Sebelum Modifikasi:
1. kalkulator.php
<img width="687" height="296" alt="WhatsApp Image 2026-09-24 at 19 34 17" src="https://github.com/user-attachments/assets/27a36da6-895c-469c-8297-19a59b754d81" />

2. biodata.php
<img width="808" height="347" alt="WhatsApp Image 2026-09-24 at 19 35 06" src="https://github.com/user-attachments/assets/98949049-2284-4a8d-9417-8244b3b5b8a0" />

### Sesudah Modifikasi:
1. kalkulator1.php
<img width="1600" height="553" alt="WhatsApp Image 2026-09-24 at 19 45 53" src="https://github.com/user-attachments/assets/103f24fd-acc1-4d6f-8835-7a207c0d037a" />

2. biodata1.php
<img width="1600" height="788" alt="WhatsApp Image 2026-09-24 at 19 46 08" src="https://github.com/user-attachments/assets/ecb5f720-b290-4409-8945-13e8af76baea" />
