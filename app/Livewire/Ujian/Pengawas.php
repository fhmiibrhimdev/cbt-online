<?php

namespace App\Livewire\Ujian;

use App\Models\Guru;
use App\Models\Jadwal;
use Livewire\Component;
use App\Models\Semester;
use App\Models\SesiSiswa;
use App\Models\JenisUjian;
use Livewire\WithPagination;
use App\Helpers\GlobalHelper;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use App\Models\Pengawas as ModelsPengawas;

class Pengawas extends Component
{
    use WithPagination;
    #[Title('Pengawas')]

    public $ujians, $gurus;
    public $id_jenis_ujian = '1';
    public $selectedGurus = [], $formattedData = [];

    public $isEditing = false;

    public $dataId, $title;
    public $id_tp, $id_smt;


    public function mount()
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $this->ujians = JenisUjian::get();
        $this->gurus = Guru::select('id', 'nama_guru')->where('id_tp', $this->id_tp)->get();
        $this->intialData();
        $this->initSelect2();
    }

    private function intialData()
    {
        $pengawas = ModelsPengawas::select('pengawas.*')
            ->join('jadwal', 'jadwal.id', 'pengawas.id_jadwal')
            ->where([
                ['id_jenis_ujian', $this->id_jenis_ujian],
                ['pengawas.id_tp', $this->id_tp],
            ])
            ->get();
        $this->selectedGurus = [];

        foreach ($pengawas as $record) {
            $id_jadwal = $record->id_jadwal;
            $id_ruang = $record->id_ruang;
            $id_sesi = $record->id_sesi;
            $id_guru = explode(',', $record->id_guru); // Split the id_guru string into an array

            if (!isset($this->selectedGurus[$id_jadwal])) {
                $this->selectedGurus[$id_jadwal] = [];
            }

            if (!isset($this->selectedGurus[$id_jadwal][$id_ruang])) {
                $this->selectedGurus[$id_jadwal][$id_ruang] = [];
            }

            if (!isset($this->selectedGurus[$id_jadwal][$id_ruang][$id_sesi])) {
                $this->selectedGurus[$id_jadwal][$id_ruang][$id_sesi] = [];
            }

            $this->selectedGurus[$id_jadwal][$id_ruang][$id_sesi] = $id_guru;
        }

        $this->formatData();
        // dd($this->selectedGurus);
    }

    public function render()
    {
        $sesis = SesiSiswa::select('sesi_siswa.id_kelas', 'sesi.id as id_sesi', 'sesi.nama_sesi', 'ruang.id as id_ruang', 'ruang.nama_ruang')
            ->join('sesi', 'sesi.id', 'sesi_siswa.id_sesi')
            ->join('ruang', 'ruang.id', 'sesi_siswa.id_ruang')
            ->distinct()
            ->orderBy('sesi_siswa.id_kelas')
            ->where('id_tp', $this->id_tp)
            ->get();

        $dataJadwals = Jadwal::select('jadwal.id', 'bank_soal.id_kelas', 'bank_soal.kode_bank', 'nama_mapel', 'jadwal.tgl_mulai')
            ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->where([
                ['id_jenis_ujian', $this->id_jenis_ujian],
                ['jadwal.id_tp', $this->id_tp],
            ])
            ->orderBy('jadwal.tgl_mulai', 'DESC')
            // ->orderBy('nama_mapel', 'DESC')
            ->get();

        $data = $dataJadwals->map(function ($item, $key) {
            $item['id_kelas'] = explode(',', $item['id_kelas']);
            return $item;
        })->toArray();

        // dd($data);

        return view('livewire.ujian.pengawas', compact('data', 'sesis'));
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);

        $this->initSelect2();
    }

    public function initSelect2()
    {
        $this->dispatch('initSelect2');
    }

    public function store()
    {
        $formattedData = $this->formattedData;
        // dd($this->selectedGurus);
        // dd($this->formattedData);

        $processedJadwals = [];

        DB::transaction(function () use ($formattedData, &$processedJadwals, &$id_tp, &$id_smt) {
            foreach ($this->formattedData['id_jadwal'] as $jadwalId => $ruangData) {
                foreach ($ruangData['id_ruang'] as $ruangId => $sesiData) {
                    foreach ($sesiData['id_sesi'] as $sesiId => $guruData) {
                        if (!empty($guruData['id_guru'])) {
                            $guruIds = implode(',', $guruData['id_guru']);

                            ModelsPengawas::updateOrCreate(
                                [
                                    'id_jadwal' => $jadwalId,
                                    'id_tp'     => $this->id_tp,
                                    'id_smt'    => $this->id_smt,
                                    'id_ruang'  => $ruangId,
                                    'id_sesi'   => $sesiId,
                                ],
                                ['id_guru'   => $guruIds,]
                            );

                            // Tambahkan jadwal yang diproses ke array
                            $processedJadwals[] = [
                                'id_jadwal' => $jadwalId,
                                'id_tp'     => $this->id_tp,
                                'id_smt'    => $this->id_smt,
                                'id_ruang'  => $ruangId,
                                'id_sesi'   => $sesiId,
                            ];
                        }
                    }
                }
            }
        });

        // Ambil data yang diproses
        $processedJadwalKeys = array_map(function ($jadwal) {
            return $jadwal['id_jadwal'] . '-' . $jadwal['id_tp'] . '-' . $jadwal['id_smt'] . '-' . $jadwal['id_ruang'] . '-' . $jadwal['id_sesi'];
        }, $processedJadwals);

        // Hapus data yang tidak ada di input baru
        ModelsPengawas::whereNotIn(DB::raw("CONCAT(id_jadwal, '-', id_tp, '-', id_smt, '-', id_ruang, '-', id_sesi)"), $processedJadwalKeys)
            ->delete();

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function updated($id, $value)
    {
        $this->formatData();

        $this->initSelect2();
    }

    public function formatData()
    {
        $this->formattedData = [
            'id_jadwal' => [],
        ];

        foreach ($this->selectedGurus as $jadwalId => $ruangData) {
            foreach ($ruangData as $ruangId => $sesiData) {
                if (!isset($this->formattedData['id_jadwal'][$jadwalId])) {
                    $this->formattedData['id_jadwal'][$jadwalId] = [];
                }
                if (!isset($this->formattedData['id_jadwal'][$jadwalId]['id_ruang'])) {
                    $this->formattedData['id_jadwal'][$jadwalId]['id_ruang'] = [];
                }
                if (!isset($this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId])) {
                    $this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId] = [];
                }
                foreach ($sesiData as $sesiId => $guruData) {
                    if (!isset($this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId]['id_sesi'])) {
                        $this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId]['id_sesi'] = [];
                    }
                    if (!isset($this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId]['id_sesi'][$sesiId])) {
                        $this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId]['id_sesi'][$sesiId] = [];
                    }
                    foreach ($guruData as $guruId) {
                        if (!isset($this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId]['id_sesi'][$sesiId]['id_guru'])) {
                            $this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId]['id_sesi'][$sesiId]['id_guru'] = [];
                        }
                        $this->formattedData['id_jadwal'][$jadwalId]['id_ruang'][$ruangId]['id_sesi'][$sesiId]['id_guru'][] = $guruId;
                    }
                }
            }
        }
    }

    public function updatedIdJenisUjian()
    {
        $this->intialData();
    }
}
