<?php

namespace App\Livewire\Ujian;

use Livewire\Component;
use App\Models\BankSoal;
use App\Models\Pengawas;
use App\Models\Semester;
use App\Models\JenisUjian;
use Livewire\WithPagination;
use App\Models\MataPelajaran;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use App\Models\Jadwal as ModelsJadwal;

class Jadwal extends Component
{
    use WithPagination;
    #[Title('Jadwal')]

    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'id_bank' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $id_bank = '0', $id_jenis_ujian = '0', $tgl_mulai, $tgl_selesai, $durasi_ujian, $acak_soal, $acak_opsi, $hasil_tampil, $token, $status, $ulang, $reset_login, $rekap, $jam_ke, $jarak;
    public $id_mapel;
    public $mapels, $banks, $ujians;

    public function mount()
    {
        $this->id_mapel       = '';

        $this->mapels         = MataPelajaran::select('id', 'nama_mapel')->where('status', '1')->get();
        $this->banks          = [];
        $this->ujians         = JenisUjian::get();

        $this->id_bank        = '';
        $this->id_jenis_ujian = '';

        $this->tgl_mulai      = date('Y-m-d');
        $this->tgl_selesai      = date('Y-m-d');

        $this->durasi_ujian   = '90';
        $this->jarak          = '1';

        $this->acak_soal      = '0';
        $this->acak_opsi      = '0';
        $this->hasil_tampil   = '0';
        $this->token          = '0';
        $this->status         = '0';
        $this->ulang          = '0';
        $this->reset_login    = '0';

        $this->rekap          = '0';
        $this->jam_ke         = '0';

        $this->dispatch('initSelect2');
    }

    public function updated()
    {
        $this->dispatch('initSelect2');
    }

    public function updatedIdMapel()
    {
        $this->banks = BankSoal::select(
            'id',
            'kode_bank',
            DB::raw("(jml_pg + jml_esai + jml_kompleks + jml_jodohkan + jml_isian) as total_seharusnya"),
            DB::raw("(tampil_pg + tampil_esai + tampil_kompleks + tampil_jodohkan + tampil_isian) as total_ditampilkan")
        )
            ->where('id_mapel', $this->id_mapel)
            ->havingRaw('total_seharusnya = total_ditampilkan')
            ->get();
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

    public function render()
    {
        \Carbon\Carbon::setLocale('id');
        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data = ModelsJadwal::select('jadwal.id', 'bank_soal.kode_bank', 'jenis_ujian.kode_jenis', 'mata_pelajaran.nama_mapel', 'bank_soal.id_kelas', 'jadwal.status', 'jadwal.durasi_ujian', 'jadwal.tgl_mulai')
            ->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')
            ->join('mata_pelajaran', 'mata_pelajaran.id', 'bank_soal.id_mapel')
            ->join('jenis_ujian', 'jenis_ujian.id', 'jadwal.id_jenis_ujian')
            ->where(function ($query) use ($search) {
                $query->where('mata_pelajaran.nama_mapel', 'LIKE', $search)
                    ->orWhere('bank_soal.kode_bank', 'LIKE', $search);
            })
            ->orderBy('tgl_mulai', 'ASC')
            ->paginate($this->lengthData);

        return view('livewire.ujian.jadwal', compact('data'));
    }

    private function dispatchAlert($type, $message, $text)
    {
        $this->dispatch('swal:modal', [
            'type'      => $type,
            'message'   => $message,
            'text'      => $text
        ]);

        $this->resetInputFields();
    }

    public function isEditingMode($mode)
    {
        $this->isEditing = $mode;
    }

    private function resetInputFields()
    {
        $this->mount();
    }

    public function cancel()
    {
        $this->resetInputFields();
    }

    public function store()
    {
        $this->validate();

        $id_tp      = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt     = Semester::where('active', '1')->first()->id;

        ModelsJadwal::create([
            'id_tp'          => $id_tp,
            'id_smt'         => $id_smt,
            'id_bank'        => $this->id_bank,
            'id_jenis_ujian' => $this->id_jenis_ujian,
            'tgl_mulai'      => $this->tgl_mulai,
            'tgl_selesai'    => $this->tgl_selesai,
            'durasi_ujian'   => $this->durasi_ujian,
            'acak_soal'      => $this->acak_soal,
            'acak_opsi'      => $this->acak_opsi,
            'hasil_tampil'   => $this->hasil_tampil,
            'token'          => $this->token,
            'status'         => $this->status,
            'ulang'          => '0',
            'reset_login'    => $this->reset_login,
            'rekap'          => '0',
            'jam_ke'         => '0',
            'jarak'          => $this->jarak,

        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function edit($id)
    {
        $this->isEditing      = true;
        $this->dispatch('initSelect2');
        $data                 = ModelsJadwal::findOrFail($id);
        $this->dataId         = $id;
        $this->id_mapel       = ModelsJadwal::select('id_mapel')->join('bank_soal', 'bank_soal.id', 'jadwal.id_bank')->where('jadwal.id', $id)->first()->id_mapel;
        $this->updatedIdMapel();
        $this->id_bank        = $data->id_bank;
        $this->id_jenis_ujian = $data->id_jenis_ujian;
        $this->tgl_mulai      = $data->tgl_mulai;
        $this->tgl_selesai    = $data->tgl_selesai;
        $this->durasi_ujian   = $data->durasi_ujian;
        $this->jarak          = $data->jarak;
        $this->acak_soal      = $data->acak_soal;
        $this->acak_opsi      = $data->acak_opsi;
        $this->token          = $data->token;
        $this->hasil_tampil   = $data->hasil_tampil;
        $this->reset_login    = $data->reset_login;
        $this->status         = $data->status;
    }

    public function update()
    {
        $this->validate();

        $id_tp      = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt     = Semester::where('active', '1')->first()->id;

        if ($this->dataId) {
            ModelsJadwal::findOrFail($this->dataId)->update([
                'id_tp'          => $id_tp,
                'id_smt'         => $id_smt,
                'id_bank'        => $this->id_bank,
                'id_jenis_ujian' => $this->id_jenis_ujian,
                'tgl_mulai'      => $this->tgl_mulai,
                'tgl_selesai'    => $this->tgl_selesai,
                'durasi_ujian'   => $this->durasi_ujian,
                'acak_soal'      => $this->acak_soal,
                'acak_opsi'      => $this->acak_opsi,
                'hasil_tampil'   => $this->hasil_tampil,
                'token'          => $this->token,
                'status'         => $this->status,
                'reset_login'    => $this->reset_login,
                'jarak'          => $this->jarak,
            ]);

            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
            $this->dataId = null;
        }
    }

    public function deleteConfirm($id)
    {
        $this->dataId = $id;
        $this->dispatch('swal:confirm', [
            'type'      => 'warning',
            'message'   => 'Are you sure?',
            'text'      => 'If you delete the data, it cannot be restored!'
        ]);
    }

    public function delete()
    {
        ModelsJadwal::findOrFail($this->dataId)->delete();
        Pengawas::where('id_jadwal', $this->dataId)->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
