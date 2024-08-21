<?php

namespace App\Livewire\Ujian;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\Semester;
use App\Helpers\GlobalHelper;
use App\Models\FormatNomorPeserta;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use App\Models\NomorPeserta as ModelsNomorPeserta;

class NomorPeserta extends Component
{
    #[Title('Nomor Peserta')]

    public $id_kelas, $nomor_peserta = [];
    public $kelass, $siswas;
    public $id_tp, $id_smt;
    public $kelasDisabled = [];
    public $kode_jenjang, $kode_tahun, $kode_provinsi, $kode_kota, $kode_sekolah;

    public function mount()
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $this->siswas = collect();

        $format = FormatNomorPeserta::first();
        $this->kode_jenjang = $format->kode_jenjang;
        $this->kode_tahun = $format->kode_tahun;
        $this->kode_provinsi = $format->kode_provinsi;
        $this->kode_kota = $format->kode_kota;
        $this->kode_sekolah = $format->kode_sekolah;

        $this->kelass  = DB::table('kelas')->select('kelas.id', 'kode_kelas', 'level', 'level.id as id_level')
            ->leftJoin('level', 'level.id', 'kelas.id_level')
            ->where([
                ['kelas.id_tp', $this->id_tp],
            ])
            ->get()
            ->groupBy('level');

        $this->kelasDisabled = [];

        $this->dispatch('initSelect2');
    }

    public function updatedIdKelas()
    {
        $this->updateSiswa();

        $this->nomor_peserta = [];
        // $this->dispatch('initSelect2');
    }

    public function updateSiswa()
    {
        // dd($this->id_kelas);
        // Ambil level yang dipilih dengan prefix "all_"
        $levelYangDipilih = array_filter($this->id_kelas, function ($nilai) {
            return strpos($nilai, 'all_') === 0;
        });

        // Ambil id_kelas yang tidak dimulai dengan "all_"
        $kelasYangDipilih = array_filter($this->id_kelas, function ($nilai) {
            return strpos($nilai, 'all_') !== 0;
        });

        // Menghapus prefix 'all_' dari level yang dipilih
        $levelUntukDipilih = array_map(function ($nilai) {
            return str_replace('all_', '', $nilai);
        }, $levelYangDipilih);

        // Inisialisasi ID kelas yang akan digunakan untuk filter
        $idKelasYangDipilih = $kelasYangDipilih;

        if (!empty($levelUntukDipilih)) {
            // Dapatkan ID kelas yang sesuai dengan level yang dipilih
            $idKelasUntukLevel = Kelas::whereIn('id_level', $levelUntukDipilih)
                ->pluck('id')
                ->toArray();

            // Gabungkan ID kelas yang dipilih secara manual dengan ID kelas untuk level
            $idKelasYangDipilih = array_merge($idKelasYangDipilih, $idKelasUntukLevel);

            // Update kelas yang dinonaktifkan
            $this->kelasDisabled = $idKelasUntukLevel;
        } else {
            // Reset kelas yang dinonaktifkan jika tidak ada level yang dipilih
            $this->kelasDisabled = [];
        }


        // Filter siswa berdasarkan ID kelas yang dipilih
        $this->siswas = Siswa::select('siswa.id', 'nama_siswa', 'users.email', 'kelas.kode_kelas', 'nomor_peserta.nomor_peserta', 'level.level')
            ->join('users', 'users.id', 'siswa.id_user')
            ->join('kelas', 'kelas.id', 'siswa.id_kelas')
            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
            ->leftJoin('level', 'level.id', 'kelas.id_level')
            ->whereIn('siswa.id_kelas', $idKelasYangDipilih)
            ->orderBy('kelas.id', 'ASC')
            ->get();

        // Jika tidak ada ID kelas yang dipilih, kosongkan daftar siswa
        if (empty($idKelasYangDipilih)) {
            $this->siswas = collect();
        }
        $this->dispatch('initSelect2');
    }

    public function generateNomorPeserta()
    {
        $this->updateSiswa();

        $counter = 1;

        foreach ($this->siswas as $siswa) {
            // Format nomor peserta tanpa kode siswa dan cek digit
            $baseFormat = "$this->kode_jenjang-$this->kode_tahun-$this->kode_provinsi-$this->kode_kota-$this->kode_sekolah-";

            // Generate kode siswa dengan padding
            $kode_siswa = str_pad($counter++, 4, '0', STR_PAD_LEFT);

            // Kalkulasi cek digit
            $nomorTanpaCekDigit = $baseFormat . $kode_siswa;
            // $cekDigit = $this->calculateCheckDigit($nomorTanpaCekDigit);

            // Format nomor peserta lengkap
            $nomor_peserta = $nomorTanpaCekDigit . '-' . rand(2, 9);
            $siswa->nomor_peserta = $nomor_peserta;
            $this->nomor_peserta[$siswa->id] = $nomor_peserta;
        }
    }

    public function hapusNomorPeserta()
    {
        // Ambil level yang dipilih dengan prefix "all_"
        $levelYangDipilih = array_filter($this->id_kelas, function ($nilai) {
            return strpos($nilai, 'all_') === 0;
        });

        // Ambil id_kelas yang tidak dimulai dengan "all_"
        $kelasYangDipilih = array_filter($this->id_kelas, function ($nilai) {
            return strpos($nilai, 'all_') !== 0;
        });

        // Menghapus prefix 'all_' dari level yang dipilih
        $levelUntukDipilih = array_map(function ($nilai) {
            return str_replace('all_', '', $nilai);
        }, $levelYangDipilih);

        // Inisialisasi ID kelas yang akan digunakan untuk filter
        $idKelasYangDipilih = $kelasYangDipilih;

        if (!empty($levelUntukDipilih)) {
            // Dapatkan ID kelas yang sesuai dengan level yang dipilih
            $idKelasUntukLevel = Kelas::whereIn('id_level', $levelUntukDipilih)
                ->pluck('id')
                ->toArray();

            // Gabungkan ID kelas yang dipilih secara manual dengan ID kelas untuk level
            $idKelasYangDipilih = array_merge($idKelasYangDipilih, $idKelasUntukLevel);

            // Update kelas yang dinonaktifkan
            $this->kelasDisabled = $idKelasUntukLevel;
        } else {
            // Reset kelas yang dinonaktifkan jika tidak ada level yang dipilih
            $this->kelasDisabled = [];
        }


        // Filter siswa berdasarkan ID kelas yang dipilih
        $this->siswas = Siswa::select('siswa.id', 'nama_siswa', 'users.email', 'kelas.kode_kelas', 'nomor_peserta.nomor_peserta', 'level.level')
            ->join('users', 'users.id', 'siswa.id_user')
            ->join('kelas', 'kelas.id', 'siswa.id_kelas')
            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
            ->leftJoin('level', 'level.id', 'kelas.id_level')
            ->whereIn('siswa.id_kelas', $idKelasYangDipilih)
            ->get();


        foreach ($this->siswas as $siswa) {
            $siswa->nomor_peserta = '';
        }

        $this->dispatch('initSelect2');
        $this->nomor_peserta = [];
    }

    public function render()
    {
        return view('livewire.ujian.nomor-peserta');
    }

    public function store()
    {
        $id_tp  = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt = Semester::where('active', '1')->first()->id;

        foreach ($this->nomor_peserta as $id_siswa => $nomorPeserta) {
            // if (ModelsNomorPeserta::where('nomor_peserta', $nomorPeserta)->exists()) {
            //     $this->dispatchAlert('error', 'Error!', "Nomor peserta $nomorPeserta sudah ada!.");
            //     return;  // Berhenti jika nomor peserta sudah ada
            // }

            ModelsNomorPeserta::updateOrCreate(
                ['id_siswa' => $id_siswa],
                [
                    'id_tp'         => $id_tp,
                    'id_smt'        => $id_smt,
                    'nomor_peserta' => $nomorPeserta
                ]
            );
        }

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);

        $this->updateSiswa();
    }

    public function update()
    {
        FormatNomorPeserta::first()->update([
            'kode_jenjang' => $this->kode_jenjang,
            'kode_tahun' => $this->kode_tahun,
            'kode_provinsi' => $this->kode_provinsi,
            'kode_kota' => $this->kode_kota,
            'kode_sekolah' => $this->kode_sekolah,
        ]);

        $this->dispatch('swal:modal', [
            'type'      => 'success',
            'message'   => 'Success!',
            'text'      => 'Data updated successfully!',
        ]);

        $this->dispatch('initSelect2');
    }
}
