<?php

namespace App\Livewire\PelaksanaanUjian\HasilUjian;

use App\Models\NilaiSoalSiswa;
use App\Models\SoalSiswa;
use Exception;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class Koreksi extends Component
{
    #[Title('Koreksi')]

    protected $listeners = ['updatePoint' => 'updateP'];

    public $id_jadwal, $id_siswa;
    public $detail, $soals;
    public $point = [];

    public function mount($id_jadwal = '0', $id_siswa = '0')
    {
        try {
            $this->id_jadwal = $id_jadwal;
            $this->id_siswa = $id_siswa;

            $this->detailData();
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function updateP()
    {
        // Mengambil kunci pertama dari array (id) dan nilai pertama (value)
        $id = key($this->point);
        $value = reset($this->point);

        // Mendapatkan data soal siswa berdasarkan id
        $soalSiswa = SoalSiswa::select('id_nilai_soal', 'jenis_soal', 'nilai_koreksi')
            ->where('id', $id)
            ->first();

        if (!$soalSiswa) {
            // Jika tidak ada data soal siswa, hentikan proses
            return;
        }

        // Mendapatkan data nilai soal siswa berdasarkan id_nilai_soal
        $nss = NilaiSoalSiswa::select('nilai_pk', 'nilai_jo', 'nilai_is', 'nilai_es')
            ->where('id', $soalSiswa->id_nilai_soal)
            ->first();

        if (!$nss) {
            // Jika tidak ada data nilai soal siswa, hentikan proses
            return;
        }

        // Menentukan kolom dan nilai sesuai jenis_soal
        $kolom = "";
        $valueNSS = 0;

        switch ($soalSiswa->jenis_soal) {
            case "2":
                $kolom = "nilai_pk";
                $valueNSS = $nss->nilai_pk;
                break;
            case "3":
                $kolom = "nilai_jo";
                $valueNSS = $nss->nilai_jo;
                break;
            case "4":
                $kolom = "nilai_is";
                $valueNSS = $nss->nilai_is;
                break;
            case "5":
                $kolom = "nilai_es";
                $valueNSS = $nss->nilai_es;
                break;
            default:
                // Handle jika jenis_soal tidak valid
                return;
        }

        // Hitung selisih dan perbarui nilai
        $totalAlt = (float)$value - (float)$soalSiswa->nilai_koreksi;

        if ((float)$value >= 0) {
            // Update nilai berdasarkan selisih
            NilaiSoalSiswa::where('id', $soalSiswa->id_nilai_soal)
                ->update([$kolom => (float)$valueNSS + $totalAlt]);
            $this->point = [];
            $this->dispatchAlert('success', 'Success!', 'Poin berhasil diubah.');
            // $this->detailData();
        } else {
            $this->point = [];
            $this->dispatchAlert('warning', 'Perhatian!', 'Nilai tidak boleh minus!');
            return;
        }

        // Update nilai_koreksi dan nilai_otomatis dalam tabel SoalSiswa
        SoalSiswa::where('id', $id)
            ->update(['nilai_koreksi' => $value, 'nilai_otomatis' => '1']);
    }

    public function sudahDikoreksi()
    {
        try {
            $nss = NilaiSoalSiswa::where([
                ['id_jadwal', $this->id_jadwal],
                ['id_siswa', $this->id_siswa],
            ])->update(["dikoreksi" => "1"]);

            if ($nss) {
                $this->dispatchAlert('success', 'Success!', 'Siswa telah dikoreksi.');
            } else {
                $this->dispatchAlert('warning', 'Gagal!', 'Kesalahan didatabase hubungi programmer.');
            }
        } catch (Exception $e) {
            //throw $th;
        }
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
    }

    public function detailData()
    {
        $this->detail = DB::table('bank_soal')->select(
            'nss2.id as id_nss',
            'bank_soal.opsi',
            'siswa.nama_siswa',
            'siswa.nis',
            'siswa.nisn',
            'level.level',
            'kelas.kode_kelas',
            'nomor_peserta.nomor_peserta',
            'sesi.kode_sesi',
            'ruang.kode_ruang',
            'mata_pelajaran.kode_mapel',
            'guru.nama_guru',
            'jenis_ujian.kode_jenis',
            'tahun_pelajaran.tahun',
            'nss2.nilai_pg',
            'nss2.nilai_pk',
            'nss2.nilai_jo',
            'nss2.nilai_is',
            'nss2.nilai_es',
            'nss2.dikoreksi',
        )
            ->leftJoin('jadwal', 'jadwal.id_bank', 'bank_soal.id')
            ->leftJoin('kelas', DB::raw('FIND_IN_SET(kelas.id, bank_soal.id_kelas)'), '>', DB::raw('0'))
            ->leftJoin('level', 'level.id', 'kelas.id_level')
            ->leftJoin('siswa', 'siswa.id_kelas', 'kelas.id')
            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
            ->leftJoin('durasi_siswa as ds1', 'ds1.id_jadwal', 'jadwal.id')
            ->leftJoin('durasi_siswa as ds2', 'ds2.id_siswa', 'siswa.id')
            ->leftJoin('ruang', 'ruang.id', 'ds2.id_ruang')
            ->leftJoin('sesi', 'sesi.id', 'ds2.id_sesi')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->leftJoin('guru', 'guru.id', 'bank_soal.id_guru')
            ->leftJoin('jenis_ujian', 'jenis_ujian.id', 'jadwal.id_jenis_ujian')
            ->leftJoin('tahun_pelajaran', 'tahun_pelajaran.id', 'jadwal.id_tp')
            ->leftJoin('nilai_soal_siswa as nss1', 'nss1.id_jadwal', 'ds2.id_jadwal')
            ->leftJoin('nilai_soal_siswa as nss2', 'nss2.id_siswa', 'ds2.id_siswa')
            ->where([
                ['ds2.id_jadwal', $this->id_jadwal],
                ['ds2.id_siswa', $this->id_siswa],
            ])
            ->distinct()
            ->first();


        $this->soals = DB::table('soal_siswa')->select(
            'soal_siswa.id',
            'soal_siswa.jenis_soal',
            'soal.soal',
            'soal_siswa.no_soal_alias',
            'soal_siswa.opsi_alias_a',
            'soal_siswa.opsi_alias_b',
            'soal_siswa.opsi_alias_c',
            'soal_siswa.opsi_alias_d',
            'soal_siswa.opsi_alias_e',
            'soal_siswa.jawaban_alias',
            'soal_siswa.jawaban_siswa',
            'soal_siswa.ragu',
            'soal.opsi_a',
            'soal.opsi_b',
            'soal.opsi_c',
            'soal.opsi_d',
            'soal.opsi_e',
            'point_soal',
            'nilai_koreksi',
            'nilai_otomatis',
        )
            ->leftJoin('soal', 'soal.id', 'soal_siswa.id_soal')
            ->where('id_nilai_soal', $this->detail->id_nss)
            ->get();

        foreach ($this->soals as &$item) {
            $optionsMap = [
                'A' => $item->opsi_a,
                'B' => $item->opsi_b,
                'C' => $item->opsi_c,
                'D' => $item->opsi_d,
                'E' => $item->opsi_e,
            ];

            $item->opsi_alias_a = $optionsMap[$item->opsi_alias_a] ?? null;
            $item->opsi_alias_b = $optionsMap[$item->opsi_alias_b] ?? null;
            $item->opsi_alias_c = $optionsMap[$item->opsi_alias_c] ?? null;
            $item->opsi_alias_d = $optionsMap[$item->opsi_alias_d] ?? null;
            $item->opsi_alias_e = $optionsMap[$item->opsi_alias_e] ?? null;
        }
        // dd($this->soals);
    }

    public function render()
    {
        $this->detailData();

        return view('livewire.pelaksanaan-ujian.hasil-ujian.koreksi');
    }
}
