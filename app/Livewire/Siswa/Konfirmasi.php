<?php

namespace App\Livewire\Siswa;

use App\Models\BankSoal;
use App\Models\DurasiSiswa;
use App\Models\Soal;
use App\Models\Siswa;
use App\Models\Token;
use App\Models\Jadwal;
use App\Models\NilaiSoalSiswa;
use Livewire\Component;
use App\Models\SoalSiswa;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class Konfirmasi extends Component
{
    #[Title('Ujian')]
    public $ids = '', $id_user = '', $id_siswa;
    public $token;
    public $jadwal;
    public $siswa;

    public function mount($id_jadwal = '')
    {
        try {
            $this->ids = Crypt::decryptString($id_jadwal);
            $this->id_user = Auth::user()->id;
            $this->id_siswa = Siswa::where('id_user', Auth::user()->id)->first()->id;
        } catch (\Throwable $th) {
            return redirect('/siswa/ujian');
        }

        $checkStatusUjian = NilaiSoalSiswa::select('status')
            ->where([
                ['id_jadwal', $this->ids],
                ['id_siswa', $this->id_siswa]
            ])->first()->status ?? 0;

        if ($checkStatusUjian == "1") {
            $this->redirect('/siswa/ujian');
        }


        $this->siswa = DB::table('siswa')->select('nomor_peserta', 'ruang.id as id_ruang', 'nama_ruang', 'sesi.id as id_sesi', 'nama_sesi', 'waktu_mulai', 'waktu_akhir', 'nama_kelas', 'level')
            ->leftJoin('sesi_siswa', 'sesi_siswa.id_siswa', 'siswa.id')
            ->leftJoin('ruang', 'ruang.id', 'sesi_siswa.id_ruang')
            ->leftJoin('sesi', 'sesi.id', 'sesi_siswa.id_sesi')
            ->leftJoin('nomor_peserta', 'nomor_peserta.id_siswa', 'siswa.id')
            ->leftJoin('kelas', 'kelas.id', 'siswa.id_kelas')
            ->leftJoin('level', 'level.id', 'kelas.id_level')
            ->where('siswa.id_user', $this->id_user)->first();


        if (date("H:i") >= $this->siswa->waktu_akhir) {
            return redirect('/siswa/ujian');
        }

        $this->jadwal = DB::table('jadwal')->select(
            'nama_mapel',
            'nama_jenis',
            'durasi_ujian',
            'acak_opsi',
            'token',
            'id_bank',
            // 'pengawas.id_guru',
            DB::raw("GROUP_CONCAT(DISTINCT guru.nama_guru ORDER BY guru.nama_guru ASC SEPARATOR ', ') as nama_guru"),
            DB::raw("(bank_soal.jml_pg + bank_soal.jml_esai + bank_soal.jml_kompleks + bank_soal.jml_jodohkan + bank_soal.jml_isian) as total_soal")
        )
            ->leftJoin('bank_soal', 'bank_soal.id', '=', 'jadwal.id_bank')
            ->leftJoin('mata_pelajaran', 'mata_pelajaran.id', '=', 'bank_soal.id_mapel')
            ->leftJoin('jenis_ujian', 'jenis_ujian.id', '=', 'jadwal.id_jenis_ujian')
            ->leftJoin('kelas', DB::raw('FIND_IN_SET(kelas.id, bank_soal.id_kelas)'), '>', DB::raw('0'))
            ->leftJoin('siswa', 'siswa.id_kelas', '=', 'kelas.id')
            ->leftJoin('pengawas', 'pengawas.id_jadwal', '=', 'jadwal.id')
            ->leftJoin('guru', DB::raw('FIND_IN_SET(guru.id, pengawas.id_guru)'), '>', DB::raw('0'))
            ->where([
                ['jadwal.id', $this->ids],
                ['pengawas.id_ruang', $this->siswa->id_ruang],
                ['pengawas.id_sesi', $this->siswa->id_sesi],
                ['siswa.id_user', $this->id_user],
            ])
            ->first();

        // dd($this->jadwal);
        // dd($this->ids);
    }

    public function render()
    {
        return view('livewire.siswa.konfirmasi');
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);
    }

    public function checkToken()
    {
        if ($this->jadwal->token == "1") {
            if ($this->token == "") {
                $this->dispatchAlert('error', 'Kesalahan!', 'Token tidak boleh kosong.');
                return;
            }

            $token = Token::first()->token;
            if ($token != $this->token) {
                $this->dispatchAlert('error', 'Kesalahan!', 'Token yang anda masukkan salah. Hubungi Pengawas');
                return;
            }
        }

        $check_ada = NilaiSoalSiswa::where([
            ['id_bank', $this->jadwal->id_bank],
            ['id_jadwal', $this->ids],
            ['id_siswa', $this->id_siswa],
        ])->whereDate('tanggal', date('Y-m-d'))->exists();

        // dd($check_ada);

        if (!$check_ada) {
            $soals = Soal::select('soal.id', 'id_bank', 'jenis', 'nomor_soal', 'soal', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'opsi_e', 'jawaban', 'jml_pg', 'bobot_pg', 'jml_esai', 'bobot_esai')
                ->leftJoin('bank_soal', 'bank_soal.id', 'soal.id_bank')
                ->where([
                    ['id_bank', $this->jadwal->id_bank],
                    ['tampilkan', '1']
                ])
                ->orderBy('jenis', 'ASC')
                ->get();

            DB::transaction(function () use ($soals) {
                DurasiSiswa::where([['id_siswa', $this->id_siswa], ['id_jadwal', $this->ids],])->update(['status' => '1', 'mulai' => now()]);

                $nilai_soal = DB::table('nilai_soal_siswa')->insertGetId([
                    'tanggal'        => date('Y-m-d'),
                    'id_bank'        => $this->jadwal->id_bank,
                    'id_jadwal'      => $this->ids,
                    'id_siswa'       => $this->id_siswa,
                ]);

                $data = [];

                foreach ($soals as $index => $soal) {
                    $options = [
                        'A' => $soal->opsi_a,
                        'B' => $soal->opsi_b,
                        'C' => $soal->opsi_c,
                        'D' => $soal->opsi_d,
                        'E' => $soal->opsi_e,
                    ];

                    // Mengacak urutan opsi jika acak_opsi bernilai 1
                    if ($this->jadwal->acak_opsi == 1) {
                        $keys = array_keys($options); // Contoh: ['A', 'B', 'C', 'D', 'E']
                        shuffle($keys); // Mengacak urutan, contoh: ['B', 'D', 'A', 'C', 'E']
                    } else {
                        $keys = array_keys($options); // Tidak mengacak urutan
                    }

                    $aliases = "";

                    if ($soal->jawaban == $keys[0]) {
                        $aliases = "A";
                    } elseif ($soal->jawaban == $keys[1]) {
                        $aliases = "B";
                    } elseif ($soal->jawaban == $keys[2]) {
                        $aliases = "C";
                    } elseif ($soal->jawaban == $keys[3]) {
                        $aliases = "D";
                    } elseif ($soal->jawaban == $keys[4]) {
                        $aliases = "E";
                    }

                    $jwb_siswa = '';
                    if ($soal->jenis == "3") {
                        $jwb_jodoh = json_decode($soal->jawaban, true);
                        if (isset($jwb_jodoh['links']) && is_array($jwb_jodoh['links'])) {
                            foreach ($jwb_jodoh['links'] as &$link) {
                                if (is_array($link)) {
                                    $link = [];
                                }
                            }
                        }
                        $jwb_siswa = json_encode($jwb_jodoh, JSON_UNESCAPED_SLASHES);
                    }

                    $data[] = [
                        'id_nilai_soal'  => $nilai_soal,
                        'id_soal'        => $soal->id,
                        'jenis_soal'     => $soal->jenis,
                        'no_soal_alias'  => $index + 1,
                        'opsi_alias_a'   => $soal->jenis == "1" ? $keys[0] : ($soal->jenis == "2" ? $soal->opsi_a : ''),
                        'opsi_alias_b'   => $soal->jenis == "1" ? $keys[1] : '',
                        'opsi_alias_c'   => $soal->jenis == "1" ? $keys[2] : '',
                        'opsi_alias_d'   => $soal->jenis == "1" ? $keys[3] : '',
                        'opsi_alias_e'   => $soal->jenis == "1" ? $keys[4] : '',
                        'jawaban_alias'  => $soal->jenis == "1" ? $aliases : ($soal->jenis == "2" || $soal->jenis == "3" || $soal->jenis == "4" || $soal->jenis == "5" ? $soal->jawaban : ''),
                        'jawaban_siswa'  => $soal->jenis == "2" ?  '[]' : ($soal->jenis == "3" ? $jwb_siswa : ''),
                        'jawaban_benar'  => $soal->jawaban,
                        'point_essai'    => (float)$soal->jml_esai > 0 ? (float)$soal->bobot_esai / (float)$soal->jml_esai : 0,
                        'soal_end'       => '0',
                        'point_soal'     => (float)$soal->jml_pg > 0 ? (float)$soal->bobot_pg / (float)$soal->jml_pg : 0,
                        'nilai_koreksi'  => '0',
                        'nilai_otomatis' => '0',
                        'created_at'     => now(),
                        'updated_at'     => now(),
                    ];
                }

                // Simpan data ke tabel soal_siswa
                DB::table('soal_siswa')->insert($data);
            });

            return redirect('/siswa/mengerjakan/' . Crypt::encryptString($this->ids));
        } else {
            return redirect('/siswa/mengerjakan/' . Crypt::encryptString($this->ids));
        }

        return;
    }

    function getOption($alias, $item)
    {
        switch ($alias) {
            case 'A':
                return $item->opsi_a;
            case 'B':
                return $item->opsi_b;
            case 'C':
                return $item->opsi_c;
            case 'D':
                return $item->opsi_d;
            case 'E':
                return $item->opsi_e;
            default:
                return null;
        }
    }
}
