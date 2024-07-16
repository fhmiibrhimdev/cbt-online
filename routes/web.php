<?php

use App\Livewire\Umum\Guru;
use App\Livewire\Ujian\Sesi;
use App\Livewire\Umum\Siswa;
use App\Livewire\Ujian\Ruang;
use App\Livewire\Control\User;
use App\Livewire\Umum\Jurusan;
use App\Livewire\Example\Example;
use App\Livewire\Profile\Profile;
use App\Livewire\Ujian\AturRuang;
use App\Livewire\Ujian\JenisUjian;
use App\Livewire\Ujian\NomorPeserta;
use App\Livewire\Umum\MataPelajaran;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Umum\TahunPelajaran;
use Illuminate\Support\Facades\Route;
use App\Livewire\Umum\Ekstrakurikuler;
use App\Livewire\Ujian\BankSoal\Detail as BankSoalDetail;
use App\Livewire\Ujian\BankSoal\BankSoal;
use App\Http\Controllers\ProfileController;
use App\Livewire\Umum\KelasRombel\KelasRombel;
use App\Livewire\Umum\KelasRombel\Edit as KelasRombelEdit;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UploadController;

Route::get('/', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

Route::post('/', [AuthenticatedSessionController::class, 'store']);

Route::post('summernote/file/upload', [UploadController::class, 'uploadImageSummernote']);
Route::post('summernote/file/delete', [UploadController::class, 'deleteImageSummernote']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class);
});

Route::group(['middleware' => ['auth', 'role:administrator']], function() {
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

    Route::get('/example', Example::class);
    Route::get('/control-user', User::class);
});

Route::group(['middleware' => ['auth', 'role:guru']], function() {

});

require __DIR__.'/auth.php';
