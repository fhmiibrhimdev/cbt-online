<?php

namespace App\Livewire\PelaksanaanUjian\Cetak;

use App\Models\Kelas;
use App\Models\Siswa;
use Livewire\Component;
use App\Models\KopKartu;
use App\Models\ProfileSekolah;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class KartuPeserta extends Component
{
    #[Title('Cetak')]

    public $header_1, $header_2, $header_3, $header_4, $tanggal;
    public $nomor_peserta, $nama_peserta, $nis_nisn, $kelas, $ruang_sesi, $username, $password, $ukuran_ttd;
    public $id_kelas, $id_kelases = '0', $banyak_aktif, $kelases, $data = [];
    public $profile_sekolah;

    public function mount($id_kelas = null)
    {
        $this->id_kelas = $id_kelas;

        $data = KopKartu::findOrFail('1');
        $this->header_1      = $data->header_1;
        $this->header_2      = $data->header_2;
        $this->header_3      = $data->header_3;
        $this->header_4      = $data->header_4;
        $this->tanggal       = $data->tanggal;

        $this->nomor_peserta = $data->nomor_peserta;
        $this->nama_peserta  = $data->nama_peserta;
        $this->nis_nisn      = $data->nis_nisn;
        $this->kelas         = $data->kelas;
        $this->ruang_sesi    = $data->ruang_sesi;
        $this->username      = $data->username;
        $this->password      = $data->password;
        $this->ukuran_ttd    = $data->ukuran_ttd;

        $this->kelases = DB::table('kelas')->select('kelas.id', 'kode_kelas', 'level')->leftJoin('level', 'level.id', 'kelas.id_level')->get();

        if ($this->id_kelas != "0") {
            $this->data = Siswa::select('nomor_peserta', 'siswa.nama_siswa as nama_peserta', 'siswa.nis', 'siswa.nisn', 'kelas.kode_kelas', 'ruang.kode_ruang', 'sesi.kode_sesi', 'users.email as username', 'siswa.tgl_lahir as password', 'level')
                ->leftJoin('kelas', 'kelas.id', 'siswa.id_kelas')
                ->leftJoin('level', 'level.id', 'kelas.id_level')
                ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
                ->leftJoin('sesi_siswa', 'sesi_siswa.id_siswa', 'siswa.id')
                ->leftJoin('ruang', 'ruang.id', 'sesi_siswa.id_ruang')
                ->leftJoin('sesi', 'sesi.id', 'sesi_siswa.id_sesi')
                ->leftJoin('users', 'users.id', 'siswa.id_user')
                ->where('kelas.id', $this->id_kelas)
                ->get();
        }

        $this->countOnes();
        $this->dispatch('initSelect2');
    }

    public function updatedIdKelases()
    {
        $this->dispatch('initSelect2');
    }

    public function countOnes()
    {
        $dataProperties = [
            $this->nomor_peserta,
            $this->nama_peserta,
            $this->nis_nisn,
            $this->kelas,
            $this->ruang_sesi,
            $this->username,
            $this->password,
        ];

        $countOnes = count(array_filter($dataProperties, function ($value) {
            return $value == 1;
        }));

        $this->banyak_aktif = $countOnes;
    }
    public function render()
    {
        if ($this->id_kelas == null) {
            return view('livewire.pelaksanaan-ujian.cetak.kartu-peserta');
        } else {
            return view('livewire.pelaksanaan-ujian.cetak.print.kartu-peserta')->layout('components.layouts.print');
        }
    }

    public function update()
    {
        KopKartu::findOrFail('1')
            ->update([
                'header_1'      => $this->header_1,
                'header_2'      => $this->header_2,
                'header_3'      => $this->header_3,
                'header_4'      => $this->header_4,
                'tanggal'       => $this->tanggal,
                'nomor_peserta' => $this->nomor_peserta,
                'nama_peserta'  => $this->nama_peserta,
                'nis_nisn'      => $this->nis_nisn,
                'ruang_sesi'    => $this->ruang_sesi,
                'username'      => $this->username,
                'password'      => $this->password,
                'ukuran_ttd'    => $this->ukuran_ttd
            ]);

        $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
    }
}
