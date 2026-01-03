# Deskripsi Proyek CBT Online

## Ringkasan Proyek

CBT Online adalah sistem Ujian Berbasis Komputer (Computer Based Test) yang dibangun menggunakan Framework Laravel 11 dan Livewire 3. Aplikasi ini dirancang untuk memfasilitasi proses ujian secara digital dengan fitur manajemen yang lengkap, mulai dari pengaturan data master, bank soal, penjadwalan, hingga pelaksanaan ujian dan rekapitulasi nilai.

Sistem ini mendukung multi-user dengan role yang berbeda (Administrator, Guru, dan Siswa), sehingga dapat digunakan oleh seluruh civitas akademik sekolah untuk kegiatan ujian seperti UTS, UAS, atau ujian harian lainnya.

## Fitur Utama

### 1. Masuk & Autentikasi (Authentication)

-   **Multi-Role**: Dukungan akses untuk Administrator, Guru, dan Siswa.
-   **Keamanan**: Menggunakan autentikasi standar Laravel yang aman.

### 2. Manajemen Data Master (Administrator)

Pengelolaan data referensi sekolah yang mudah:

-   **Tahun Pelajaran**: Mengatur tahun ajaran aktif.
-   **Mata Pelajaran & Jurusan**: Mengelola daftar mapel dan jurusan.
-   **Data Kelas & Rombel**: Manajemen pembagian kelas siswa.
-   **Data Siswa & Guru**: Import, edit, dan manajemen profil pengguna.
-   **Ekstrakurikuler**: Pendataan kegiatan ekstrakurikuler.

### 3. Manajemen Ujian (Bank Soal & Jadwal)

Fitur inti untuk persiapan ujian:

-   **Bank Soal**: Pembuatan dan pengelolaan soal ujian (Pilihan Ganda, Essay, dll).
-   **Jenis Ujian**: Pengaturan kategori ujian (Harian, UTS, UAS).
-   **Sesi & Ruang**: Pembagian sesi ujian dan alokasi ruang peserta.
-   **Jadwal Ujian**: Penjadwalan ujian yang fleksibel dengan pengaturan token.
-   **Token Ujian**: Sistem token untuk keamanan akses ujian.

### 4. Pelaksanaan Ujian (Siswa)

Antarmuka khusus untuk siswa mengerjakan ujian:

-   **Dashboard Siswa**: Melihat jadwal ujian yang tersedia.
-   **Konfirmasi Ujian**: Verifikasi data sebelum memulai.
-   **Halaman Mengerjakan**: Interface ujian yang responsif dengan navigasi soal.

### 5. Administrasi Ujian & Cetak Dokumen

Mempermudah administrasi pelaporan:

-   **Cetak Kartu Peserta & Absensi**: Generate dokumen PDF.
-   **Cetak Jadwal Pengawas**: Manajemen tugas pengawas ujian.
-   **Status Peserta**: Monitoring status siswa yang sedang ujian (Online/Offline).

### 6. Penilaian & Laporan

-   **Koreksi Otomatis**: Untuk soal pilihan ganda.
-   **Koreksi Manual**: Fitur koreksi untuk soal essay.
-   **Rekap Nilai**: Melihat dan mencetak hasil ujian siswa.
-   **Pengaturan Raport**: Integrasi nilai ke format raport sederhana.

### 7. Pengaturan Sistem

-   **Profil Sekolah**: Mengatur identitas sekolah (Nama, Logo, Alamat).
-   **Manajemen User**: Kontrol akses akun Admin, Guru, dan Siswa.

## Teknologi yang Digunakan

-   **Backend**: Laravel 11
-   **Frontend**: Livewire 3, Tailwind CSS
-   **Database**: MySQL
