<?php

namespace App\Livewire\Ujian;

use Carbon\Carbon;
use App\Models\Level;
use App\Models\Jadwal;
use Livewire\Component;
use App\Models\JenisUjian;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class AlokasiWaktu extends Component
{
    use WithPagination;
    #[Title('Alokasi Waktu')]

    public $id_jenis_ujian = '', $id_level = '', $start_date, $end_date, $jam_ke = [];
    public $ujians, $levels;

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId;

    public function mount()
    {
        $this->ujians     = JenisUjian::get();
        $this->levels     = Level::get();
        $this->start_date = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->end_date   = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->initSelect2();
    }

    public function updatingLengthData()
    {
        $this->resetPage();
    }

    private function searchResetPage()
    {
        if ($this->searchTerm !== $this->previousSearchTerm) {
            $this->resetPage();
        }

        $this->previousSearchTerm = $this->searchTerm;
    }

    public function updated()
    {
        $this->initSelect2();
    }

    private function initSelect2()
    {
        $this->dispatch('initSelect2');
    }

    public function render()
    {
        \Carbon\Carbon::setLocale('id');
        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data = Jadwal::select('jadwal.id', 'bank_soal.kode_bank', 'bank_soal.id_level', 'mata_pelajaran.nama_mapel', 'bank_soal.id_kelas', 'jadwal.tgl_mulai', 'jadwal.jam_ke')
            ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->where('id_jenis_ujian', $this->id_jenis_ujian)
            ->whereBetween('tgl_mulai', [$this->start_date, $this->end_date])
            ->when($this->id_level, function ($query, $id_level) {
                return $query->where('bank_soal.id_level', $id_level);
            })
            ->where(function ($query) use ($search) {
                $query->where('mata_pelajaran.nama_mapel', 'LIKE', $search)
                    ->orWhere('bank_soal.kode_bank', 'LIKE', $search);
            })
            ->orderBy('tgl_mulai', 'ASC')
            ->paginate($this->lengthData);

        $this->jam_ke = [];

        foreach ($data as $item) {
            $this->jam_ke[$item->id] = $item->jam_ke;
        }

        return view('livewire.ujian.alokasi-waktu', compact('data'));
    }

    public function update()
    {
        foreach ($this->jam_ke as $id => $jamKe) {
            if (array_key_exists($id, $this->jam_ke)) {
                Jadwal::where('id', $id)->update(['jam_ke' => $jamKe]);
            }
        }

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
