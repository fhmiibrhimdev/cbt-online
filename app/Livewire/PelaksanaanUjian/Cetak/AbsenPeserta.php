<?php

namespace App\Livewire\PelaksanaanUjian\Cetak;

use App\Models\Sesi;
use App\Models\Ruang;
use App\Models\Jadwal;
use Livewire\Component;
use App\Models\BankSoal;
use App\Models\KopAbsensi;
use App\Models\MataPelajaran;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class AbsenPeserta extends Component
{
    #[Title('Absen Peserta')]
    public $id_ruang, $id_sesi, $id_jadwal;
    public $id_ruanges = "0", $id_sesies = "0", $id_jadwales = "0";
    public $header_1, $header_2, $header_3, $header_4;
    public $ruangs, $sesis, $mapels, $nama_ruang, $nama_sesi, $nama_mapel, $waktu, $data, $hari_tanggal;

    public function mount($id_ruang = "0", $id_sesi = "0", $id_jadwal = "0")
    {
        $data = KopAbsensi::findOrFail('1');
        $this->header_1  = $data->header_1;
        $this->header_2  = $data->header_2;
        $this->header_3  = $data->header_3;
        $this->header_4  = $data->header_4;

        $this->id_ruang  = $id_ruang;
        $this->id_sesi   = $id_sesi;
        $this->id_jadwal = $id_jadwal;

        if ($id_ruang == "0" && $id_sesi == "0" && $id_jadwal == "0") {
            $this->data   = collect();
            $this->ruangs = Ruang::select('id', 'nama_ruang')->get();
            $this->sesis  = Sesi::select('id', 'nama_sesi')->get();
            $this->mapels = Jadwal::select('mata_pelajaran.id', 'mata_pelajaran.nama_mapel')
                ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
                ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
                ->groupBy('mata_pelajaran.id', 'mata_pelajaran.nama_mapel')
                ->get();
        } else {
            $this->initialData($id_ruang, $id_sesi, $id_jadwal);

            $ruang            = Ruang::find($id_ruang);
            $this->nama_ruang = $ruang ? $ruang->nama_ruang : null;

            $sesi             = Sesi::find($id_sesi);
            $this->nama_sesi  = $sesi ? $sesi->nama_sesi : null;

            $this->waktu      = $sesi ? $sesi->waktu_mulai . ' s/d ' . $sesi->waktu_akhir : null;

            $jadwal = Jadwal::select('mata_pelajaran.nama_mapel', 'jadwal.tgl_mulai')
                ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
                ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
                ->where('mata_pelajaran.id', $id_jadwal)
                ->first();

            $this->nama_mapel   = $jadwal ? $jadwal->nama_mapel : null;
            $this->hari_tanggal = $jadwal ? $jadwal->tgl_mulai : null;
        }

        $this->dispatch('initSelect2');
    }

    public function updated()
    {
        $this->mapels  = Jadwal::select('mata_pelajaran.id', 'mata_pelajaran.nama_mapel')
            ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->groupBy('mata_pelajaran.id', 'mata_pelajaran.nama_mapel')
            ->get();

        $this->initialData($this->id_ruanges, $this->id_sesies, $this->id_jadwales);

        $this->dispatch('initSelect2');
    }

    public function updatedIdRuanges($value)
    {
        $ruang            = Ruang::find($value);
        $this->nama_ruang = $ruang ? $ruang->nama_ruang : null;

        $this->initialData($this->id_ruanges, $this->id_sesies, $this->id_jadwales);
    }

    public function updatedIdSesies($value)
    {
        $sesi = Sesi::find($value);
        $this->nama_sesi = $sesi ? $sesi->nama_sesi : null;

        $this->waktu     = $sesi ? $sesi->waktu_mulai . ' s/d ' . $sesi->waktu_akhir : null;

        $this->initialData($this->id_ruanges, $this->id_sesies, $this->id_jadwales);
    }

    public function updatedIdJadwales($value)
    {
        $jadwal = Jadwal::select('mata_pelajaran.nama_mapel', 'jadwal.tgl_mulai')
            ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->where('mata_pelajaran.id', $value)
            ->first();

        $this->nama_mapel   = $jadwal ? $jadwal->nama_mapel : null;
        $this->hari_tanggal = $jadwal ? $jadwal->tgl_mulai : null;
    }

    public function render()
    {
        \Carbon\Carbon::setLocale('id');

        if ($this->id_ruang == "0" && $this->id_sesi == "0" && $this->id_jadwal == "0") {
            return view('livewire.pelaksanaan-ujian.cetak.absen-peserta');
        } else {
            return view('livewire.pelaksanaan-ujian.cetak.print.absen-peserta')->layout('components.layouts.print');
        }
    }

    private function initialData($id_ruang, $id_sesi, $id_jadwal)
    {
        $this->data = BankSoal::select(
            'bank_soal.id',
            'siswa.id AS id_siswa',
            'nomor_peserta.nomor_peserta',
            'siswa.nama_siswa',
            'kelas.nama_kelas',
            'jadwal.tgl_mulai',
            'mata_pelajaran.nama_mapel'
        )
            ->join('jadwal', 'jadwal.id_bank', 'bank_soal.id')
            ->join('kelas', DB::raw('FIND_IN_SET(kelas.id, bank_soal.id_kelas)'), '>', DB::raw('0'))
            ->join('sesi_siswa', 'sesi_siswa.id_kelas', 'kelas.id')
            ->join('siswa', 'siswa.id', 'sesi_siswa.id_siswa')
            ->join('kelas_detail AS kelas_detail1', 'kelas_detail1.id_kelas', 'kelas.id')
            ->join('kelas_detail AS kelas_detail2', 'kelas_detail2.id_siswa', 'sesi_siswa.id_siswa')
            ->join('ruang', 'ruang.id', 'sesi_siswa.id_ruang')
            ->join('sesi', 'sesi.id', 'sesi_siswa.id_sesi')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->join('nomor_peserta', 'nomor_peserta.id_siswa', '=', 'siswa.id')
            ->when($id_jadwal, function ($query) use ($id_jadwal) {
                return $query->where('mata_pelajaran.id', $id_jadwal);
            })
            ->when($id_ruang, function ($query) use ($id_ruang) {
                return $query->where('ruang.id', $id_ruang);
            })
            ->when($id_sesi, function ($query) use ($id_sesi) {
                return $query->where('sesi.id', $id_sesi);
            })
            ->orderBy('bank_soal.id', 'ASC')
            ->get();
    }


    public function update()
    {
        KopAbsensi::findOrFail('1')->update([
            'header_1' => $this->header_1,
            'header_2' => $this->header_2,
            'header_3' => $this->header_3,
            'header_4' => $this->header_4,
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
