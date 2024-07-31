<?php

use App\Livewire\Umum\Guru;
use App\Livewire\Ujian\Sesi;
use App\Livewire\Umum\Siswa;
use App\Livewire\Ujian\Ruang;
use App\Livewire\Ujian\Token;
use App\Livewire\Control\User;
use App\Livewire\Ujian\Jadwal;
use App\Livewire\Umum\Jurusan;
use App\Livewire\Ujian\Pengawas;
use App\Livewire\Example\Example;
use App\Livewire\Profile\Profile;
use App\Livewire\Ujian\AturRuang;
use App\Livewire\Ujian\JenisUjian;
use App\Livewire\Pengaturan\Raport;
use App\Livewire\Ujian\AlokasiWaktu;
use App\Livewire\Ujian\NomorPeserta;
use App\Livewire\Umum\MataPelajaran;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Umum\TahunPelajaran;
use Illuminate\Support\Facades\Route;
use App\Livewire\Umum\Ekstrakurikuler;
use App\Livewire\Pengumuman\Pengumuman;
use App\Livewire\PelaksanaanUjian\Cetak;
use App\Livewire\Ujian\BankSoal\BankSoal;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Pengaturan\ProfileSekolah;
use App\Livewire\Umum\KelasRombel\KelasRombel;
use App\Livewire\Pengaturan\Guru as PengaturanGuru;
use App\Livewire\PelaksanaanUjian\Cetak\AbsenPeserta;
use App\Livewire\PelaksanaanUjian\Cetak\KartuPeserta;
use App\Livewire\PelaksanaanUjian\Cetak\PesertaUjian;
use App\Livewire\Pengaturan\Siswa as PengaturanSiswa;
use App\Livewire\PelaksanaanUjian\Cetak\JadwalPengawas;
use App\Livewire\Ujian\BankSoal\Detail as BankSoalDetail;
use App\Livewire\Umum\KelasRombel\Edit as KelasRombelEdit;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Livewire\Pengaturan\Administrator as PengaturanAdministrator;
use App\Livewire\Siswa\Konfirmasi;
use App\Livewire\Siswa\Mengerjakan;
use App\Livewire\Siswa\Ujian;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return app()->make('App\Http\Controllers\Auth\AuthenticatedSessionController')->create();
})->name('login');

Route::post('/', [AuthenticatedSessionController::class, 'store']);

Route::post('summernote/file/upload', [UploadController::class, 'uploadImageSummernote']);
Route::post('summernote/file/delete', [UploadController::class, 'deleteImageSummernote']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class);
});

Route::group(['middleware' => ['auth', 'role:administrator']], function () {
    Route::get('/umum/tahun-pelajaran', TahunPelajaran::class);
    Route::get('/umum/mata-pelajaran', MataPelajaran::class);
    Route::get('/umum/jurusan', Jurusan::class);
    Route::get('/umum/siswa', Siswa::class);
    Route::get('/umum/kelas-rombel', KelasRombel::class);
    Route::get('/umum/kelas-rombel/{id}/edit', KelasRombelEdit::class)->name('kelas-rombel-edit');
    Route::get('/umum/ekstrakurikuler', Ekstrakurikuler::class);
    Route::get('/umum/guru', Guru::class);

    Route::get('/ujian/ruang', Ruang::class);
    Route::get('/ujian/atur-ruang', AturRuang::class);
    Route::get('/ujian/atur-ruang/{id_kelas}', AturRuang::class)->name('atur-ruang');
    Route::get('/ujian/nomor-peserta', NomorPeserta::class);
    Route::get('/ujian/bank-soal', BankSoal::class);
    Route::get('/ujian/bank-soal/{id_bank_soal}/{jenis}/detail', BankSoalDetail::class)->name('bank-soal-detail');
    Route::get('/ujian/jenis-ujian', JenisUjian::class);
    Route::get('/ujian/sesi', Sesi::class);
    Route::get('/ujian/jadwal', Jadwal::class);
    Route::get('/ujian/alokasi-waktu', AlokasiWaktu::class);
    Route::get('/ujian/pengawas', Pengawas::class);
    Route::get('/ujian/token', Token::class)->name('token');

    Route::get('/pengumuman', Pengumuman::class);

    Route::get('/pelaksanaan-ujian/cetak', Cetak::class);
    Route::get('/pelaksanaan-ujian/cetak/kartu-peserta', KartuPeserta::class);
    Route::get('/pelaksanaan-ujian/cetak/kartu-peserta/{id_kelas}', KartuPeserta::class)->name('cetak-kartu-peserta');
    Route::get('/pelaksanaan-ujian/cetak/absen-peserta', AbsenPeserta::class);
    Route::get('/pelaksanaan-ujian/cetak/absen-peserta/{id_ruang?}/{id_sesi?}/{id_jadwal?}', AbsenPeserta::class)->name('cetak-absen-peserta');
    Route::get('/pelaksanaan-ujian/cetak/jadwal-pengawas', JadwalPengawas::class);
    Route::get('/pelaksanaan-ujian/cetak/jadwal-pengawas/{id_jenis_ujian?}/{tgl_mulai?}/{tgl_akhir?}/{ttds?}', JadwalPengawas::class);
    Route::get('/pelaksanaan-ujian/cetak/peserta-ujian', PesertaUjian::class);
    Route::get('/pelaksanaan-ujian/cetak/peserta-ujian/{id_jenis_ujian?}/{by?}', PesertaUjian::class);

    Route::get('/pengaturan/raport', Raport::class);
    Route::get('/pengaturan/profile-sekolah', ProfileSekolah::class);
    Route::get('/pengaturan/administrator', PengaturanAdministrator::class);
    Route::get('/pengaturan/guru', PengaturanGuru::class);
    Route::get('/pengaturan/siswa', PengaturanSiswa::class);

    Route::get('/example', Example::class);
    Route::get('/control-user', User::class);
});

Route::group(['middleware' => ['auth', 'role:guru']], function () {
});

Route::group(['middleware' => ['auth', 'role:siswa']], function () {
    Route::get('/siswa/ujian', Ujian::class);
    Route::get('/siswa/konfirmasi/{id_jadwal?}', Konfirmasi::class);
    Route::get('/siswa/mengerjakan/{id_jadwal?}', Mengerjakan::class);
});

require __DIR__ . '/auth.php';
