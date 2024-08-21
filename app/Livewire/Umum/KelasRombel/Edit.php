<?php

namespace App\Livewire\Umum\KelasRombel;

use App\Models\Kelas;
use App\Models\Level;
use App\Models\Siswa;
use App\Models\Jurusan;
use Livewire\Component;
use App\Models\Semester;
use App\Models\SesiSiswa;
use App\Models\KelasDetail;
use App\Helpers\GlobalHelper;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

class Edit extends Component
{
    #[Title('Kelas Rombel Edit')]

    public $dataId, $id_level, $id_jurusan, $nama_kelas, $kode_kelas, $id_guru, $jumlah_siswa;
    public $id_siswa = [];
    public $levels, $jurusans, $siswas, $siswasedit, $openForm, $prev_id_siswa;
    public $id_tp, $id_smt;

    public function mount($id)
    {
        $this->id_tp    = GlobalHelper::getActiveTahunPelajaranId();
        $this->id_smt   = GlobalHelper::getActiveSemesterId();

        $this->levels   = Level::get();
        $this->jurusans = Jurusan::get();

        $this->siswas = Siswa::select('id', 'nama_siswa', 'nisn', 'status_kelas', 'id_kelas')->where('id_tp', $this->id_tp)->get();

        $data                = Kelas::findOrFail($id);
        $this->dataId        = $id;
        $this->nama_kelas    = $data->nama_kelas;
        $this->kode_kelas    = $data->kode_kelas;
        $this->id_jurusan    = $data->id_jurusan;
        $this->id_level      = $data->id_level;
        $this->id_guru       = $data->id_guru;
        $this->jumlah_siswa  = $data->jumlah_siswa;

        $this->id_siswa      = KelasDetail::where('id_kelas', $data->id)->pluck('id_siswa')->toArray();
        $this->prev_id_siswa = $this->id_siswa;
        $this->dispatch('setSelectedValues', ['id_siswa' => $this->id_siswa]);
    }

    public function render()
    {
        return view('livewire.umum.kelas-rombel.edit');
    }

    public function update()
    {
        DB::transaction(function () {
            $flattened_currentlySelected = array_map(function ($item) {
                return is_array($item) ? $item[0] : $item;
            }, $this->id_siswa);
            $unselectedItems = array_diff($this->prev_id_siswa, $flattened_currentlySelected);

            $this->validate([
                'nama_kelas' => 'required',
            ]);

            Kelas::findOrFail($this->dataId)->update([
                'id_tp'          => $this->id_tp,
                'id_smt'         => $this->id_smt,
                'nama_kelas'     => $this->nama_kelas,
                'kode_kelas'     => $this->kode_kelas,
                'id_jurusan'     => $this->id_jurusan,
                'id_level'       => $this->id_level,
                'id_guru'        => '0',
                'jumlah_siswa'   => $this->jumlah_siswa,
            ]);

            $kelas_detail = KelasDetail::where('id_kelas', $this->dataId);
            $kelas_detail->delete();

            $kelasDetailData = [];

            foreach ($this->id_siswa as $siswa_id) {
                $kelasDetailData[] = [
                    'id_kelas'       => $this->dataId,
                    'id_tp'          => $this->id_tp,
                    'id_smt'         => $this->id_smt,
                    'id_siswa'       => $siswa_id[0],
                ];
            }

            KelasDetail::insert($kelasDetailData);

            Siswa::where('id_kelas', $this->dataId)->update(['status_kelas' => '0', 'id_kelas' => '0']);

            Siswa::whereIn('id', $this->id_siswa)->update(['status_kelas' => '1', 'id_kelas' => $this->dataId]);

            SesiSiswa::whereIn('id_siswa', $unselectedItems)->delete();

            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
        });
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);

        $this->redirect('/umum/kelas-rombel');
    }
}
