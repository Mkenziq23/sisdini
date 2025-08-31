# Sistem Deteksi Faktor Risiko Kesehatan

Sistem ini dirancang untuk membantu **mendeteksi faktor risiko kesehatan** pengguna berdasarkan data yang dimasukkan, kemudian menampilkan hasil rekomendasi yang jelas dan mudah dipahami. Sistem ini dibuat menggunakan **Laravel 12** dengan antarmuka berbasis Blade dan Bootstrap.

---

## Fitur Utama

| Fitur | Deskripsi |
|-------|-----------|
| **Form Deteksi Risiko** | Pengguna dapat memasukkan data seperti usia, jenis kelamin, tinggi badan, berat badan, tekanan darah, aktivitas, gula darah, hipertensi, dan kardiovaskular. |
| **Analisis Data** | Sistem menganalisis data dan menentukan apakah pengguna **Berisiko** atau **Tidak Berisiko** berdasarkan beberapa kriteria yang sudah ditentukan. |
| **Hasil Diagnosa** | Menampilkan hasil rekomendasi secara jelas dan bisa dicetak dalam format PDF. |
| **Halaman Informasi** | Memberikan informasi umum terkait aplikasi dan panduan penggunaan. |
| **Halaman Kontak** | Pengguna dapat mengirim pertanyaan atau saran melalui form kontak, dan semua pesan disimpan dalam database. |

---

## Tampilan Halaman

Berikut contoh tampilan halaman dari sistem:

<div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">

<div style="flex: 1 1 45%; text-align: center;">
**1. Halaman Home**  
![Home](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/Home.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**2. Halaman About / Tentang**  
![About](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/about.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**3. Halaman Informasi**  
![Information](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/information.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**4. Halaman Kontak**  
![Contact](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/contact.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**5. Halaman Deteksi Risiko**  
![Deteksi](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/deteksi.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**6. Halaman Hasil Deteksi**  
![Hasil Deteksi](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/hasil.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**7. Halaman Dashboard**  
![Dashboard](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/dashboard.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**8. Halaman Dashboard Hasil Deteksi**  
![Hasil Dashboard](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/hasil-deteksi.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**9. Halaman Dashboard Kelola Pesan**  
![Kelola Pesan](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/kelola-pesan.png)
</div>

<div style="flex: 1 1 45%; text-align: center;">
**10. Halaman Dashboard Kelola Akun**  
![Kelola Akun](https://github.com/Mkenziq23/sisdini/blob/main/public/screenshoots/kelola-akun.png)
</div>

</div>

---

## Instalasi & Penggunaan

Ikuti langkah berikut untuk menjalankan sistem di lokal:

### 1. Clone Repository
```bash
git clone https://github.com/username/project-name.git
cd project-name
