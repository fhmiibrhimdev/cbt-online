<?php

namespace App\Livewire\Umum;

use App\Models\BankSoal;
use App\Models\User;
use App\Models\Kelas;
use Livewire\Component;
use App\Models\Semester;
use App\Models\LevelGuru;
use App\Models\JabatanGuru;
use Livewire\WithPagination;
use App\Models\MataPelajaran;
use App\Models\TahunPelajaran;
use Livewire\Attributes\Title;
use App\Models\JabatanGuruDetail;
use App\Models\Guru as ModelsGuru;
use App\Models\Pengawas;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Hash;

class Guru extends Component
{
    use WithPagination;
    #[Title('Guru')]

    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'delete'
    ];
    protected $rules = [
        'nama_guru' => 'required',
        'email'     => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $id_user, $nip, $nama_guru, $email, $kode_guru, $no_ktp, $tempat_lahir, $tgl_lahir, $jk, $no_hp, $alamat, $rt, $rw, $kelurahan_desa, $kecamatan, $kabupaten_kota, $kode_pos, $kewarganegaraan, $nuptk, $jenis_ptk, $tgs_tambahan, $status_pegawai, $status_aktif, $status_nikah, $tmt, $keahlian_isyarat, $npwp, $foto, $level_guru, $agama;

    public $id_jabatan, $id_kelas, $id_jabatan_guru, $id_mapel, $id_mapel_kelas;

    public function mount()
    {
        $this->id_jabatan       = '';
        $this->id_kelas         = '';
        $this->id_mapel         = [];
        $this->id_mapel_kelas   = [];
        $this->id_user          = '';
        $this->nip              = '';
        $this->nama_guru        = '';
        $this->email            = '';
        $this->kode_guru        = '';
        $this->no_ktp           = '';
        $this->tempat_lahir     = '';
        $this->tgl_lahir        = '';
        $this->jk               = '';
        $this->no_hp            = '';
        $this->alamat           = '';
        $this->rt               = '';
        $this->rw               = '';
        $this->kelurahan_desa   = '';
        $this->kecamatan        = '';
        $this->kabupaten_kota   = '';
        $this->kode_pos         = '';
        $this->kewarganegaraan  = '';
        $this->nuptk            = '';
        $this->jenis_ptk        = '';
        $this->tgs_tambahan     = '';
        $this->status_pegawai   = '';
        $this->status_aktif     = '';
        $this->status_nikah     = '';
        $this->tmt              = '';
        $this->keahlian_isyarat = '';
        $this->npwp             = '';
        $this->foto             = '';
        $this->agama            = '';

        $this->level_guru       = LevelGuru::get();
    }

    public function updatedIdMapel()
    {
        $this->dispatch('initSelect2');
        $this->syncMapelKelas();
    }

    public function syncMapelKelas()
    {
        foreach ($this->id_mapel_kelas as $mapelId => $kelasIds) {
            if (!in_array((string) $mapelId, $this->id_mapel)) {
                unset($this->id_mapel_kelas[$mapelId]);
            }
        }
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
        $this->searchResetPage();
        $search = '%' . $this->searchTerm . '%';

        $data   = ModelsGuru::select('guru.id', 'guru.nama_guru', 'guru.nip', 'level_guru.level as nama_level', 'kelas1.kode_kelas as walikelas', 'kelas2.kode_kelas as kelas_ngajar', 'mata_pelajaran.nama_mapel', 'level.level')
            ->join('jabatan_guru', 'jabatan_guru.id_guru', 'guru.id')
            ->leftjoin('jabatan_guru_detail', 'jabatan_guru_detail.id_jabatan_guru', 'jabatan_guru.id')
            ->leftJoin('mata_pelajaran', 'jabatan_guru_detail.id_mapel', 'mata_pelajaran.id')
            ->leftJoin('kelas as kelas1', 'jabatan_guru.id_kelas', 'kelas1.id')
            ->leftJoin('kelas as kelas2', 'jabatan_guru_detail.id_kelas', 'kelas2.id')
            ->leftJoin('level_guru', 'jabatan_guru.id_jabatan', 'level_guru.id')
            ->leftJoin('level', 'kelas2.id_level', 'level.id')
            ->distinct()
            ->where(function ($query) use ($search) {
                $query->where('guru.nama_guru', 'LIKE', $search);
            })
            ->orderBy('guru.id', 'DESC')
            ->paginate($this->lengthData);

        $mapels = MataPelajaran::select('id', 'nama_mapel')->where('status', '1')->get();
        $kelas  = Kelas::select('kelas.id', 'kode_kelas', 'level')->leftJoin('level', 'level.id', 'kelas.id_level')->get();

        return view('livewire.umum.guru', compact('data', 'mapels', 'kelas'));
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

        $user = User::create([
            'name'     => $this->nama_guru,
            'email'    => $this->email,
            'password' => Hash::make('1'),
            'active'   => '0'
        ]);

        $user->addRole('guru');

        $guru = ModelsGuru::create([
            'id_user'   => $user->id,
            'nip'       => $this->nip,
            'nama_guru' => $this->nama_guru,
            'email'     => $this->email,
            'kode_guru' => $this->kode_guru,
        ]);

        $id_tp  = TahunPelajaran::where('active', '1')->first()->id;
        $id_smt = Semester::where('active', '1')->first()->id;

        JabatanGuru::create([
            'id_guru'    => $guru->id,
            'id_jabatan' => '0',
            'id_kelas'   => '0',
            'id_tp'      => $id_tp,
            'id_smt'     => $id_smt,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }

    public function edit($id)
    {
        $this->isEditing        = true;
        $data                   = ModelsGuru::findOrFail($id);
        $this->dataId           = $id;
        $this->id_user          = $data->id_user;
        $this->nip              = $data->nip;
        $this->nama_guru        = $data->nama_guru;
        $this->email            = $data->email;
        $this->kode_guru        = $data->kode_guru;
        $this->no_ktp           = $data->no_ktp;
        $this->tempat_lahir     = $data->tempat_lahir;
        $this->tgl_lahir        = $data->tgl_lahir;
        $this->jk               = $data->jk;
        $this->agama            = $data->agama;
        $this->no_hp            = $data->no_hp;
        $this->alamat           = $data->alamat;
        $this->rt               = $data->rt;
        $this->rw               = $data->rw;
        $this->kelurahan_desa   = $data->kelurahan_desa;
        $this->kecamatan        = $data->kecamatan;
        $this->kabupaten_kota   = $data->kabupaten_kota;
        $this->kode_pos         = $data->kode_pos;
        $this->kewarganegaraan  = $data->kewarganegaraan;
        $this->nuptk            = $data->nuptk;
        $this->jenis_ptk        = $data->jenis_ptk;
        $this->tgs_tambahan     = $data->tgs_tambahan;
        $this->status_pegawai   = $data->status_pegawai;
        $this->status_aktif     = $data->status_aktif;
        $this->status_nikah     = $data->status_nikah;
        $this->tmt              = $data->tmt;
        $this->keahlian_isyarat = $data->keahlian_isyarat;
        $this->npwp             = $data->npwp;
        $this->foto             = $data->foto;

        $jg                    = JabatanGuru::select('id', 'id_jabatan', 'id_kelas')->where('id_guru', $this->dataId)->first();
        $this->id_jabatan_guru = $jg->id;
        $this->id_jabatan      = $jg->id_jabatan;
        $this->id_kelas        = $jg->id_kelas;

        $jgd = JabatanGuru::select('jabatan_guru.id_guru', 'jabatan_guru.id_kelas as jabatan_kelas', 'jabatan_guru_detail.id', 'jabatan_guru_detail.id_jabatan_guru', 'jabatan_guru_detail.id_mapel', 'jabatan_guru_detail.id_kelas')
            ->join('jabatan_guru_detail', 'jabatan_guru_detail.id_jabatan_guru', 'jabatan_guru.id')
            ->where('jabatan_guru.id_guru', $id)
            ->get();

        $this->id_mapel = array_values(array_unique($jgd->pluck('id_mapel')->toArray()));
        $id_mapel_kelas = [];

        foreach ($jgd as $detail) {
            $id_mapel = $detail->id_mapel;
            $id_kelas = $detail->id_kelas;

            if (!isset($id_mapel_kelas[$id_mapel])) {
                $id_mapel_kelas[$id_mapel] = [];
            }

            if (!in_array($id_kelas, $id_mapel_kelas[$id_mapel])) {
                $id_mapel_kelas[$id_mapel][] = $id_kelas;
            }
        }

        $this->id_mapel_kelas = $id_mapel_kelas;

        $this->dispatch('initSelect2');
    }

    public function update()
    {
        $this->validate();

        if ($this->dataId) {
            User::findOrFail($this->id_user)->update([
                'name'     => $this->nama_guru,
                'email'    => $this->email,
            ]);

            ModelsGuru::findOrFail($this->dataId)->update([
                'nip'              => $this->nip,
                'nama_guru'        => $this->nama_guru,
                'email'            => $this->email,
                'kode_guru'        => $this->kode_guru,
                'no_ktp'           => $this->no_ktp,
                'tempat_lahir'     => $this->tempat_lahir,
                'tgl_lahir'        => $this->tgl_lahir,
                'jk'               => $this->jk,
                'agama'            => $this->agama,
                'no_hp'            => $this->no_hp,
                'alamat'           => $this->alamat,
                'rt'               => $this->rt,
                'rw'               => $this->rw,
                'kelurahan_desa'   => $this->kelurahan_desa,
                'kecamatan'        => $this->kecamatan,
                'kabupaten_kota'   => $this->kabupaten_kota,
                'kode_pos'         => $this->kode_pos,
                'kewarganegaraan'  => $this->kewarganegaraan,
                'nuptk'            => $this->nuptk,
                'jenis_ptk'        => $this->jenis_ptk,
                'tgs_tambahan'     => $this->tgs_tambahan,
                'status_pegawai'   => $this->status_pegawai,
                'status_aktif'     => $this->status_aktif,
                'status_nikah'     => $this->status_nikah,
                'tmt'              => $this->tmt,
                'keahlian_isyarat' => $this->keahlian_isyarat,
                'npwp'             => $this->npwp,
                'foto'             => $this->foto,
            ]);

            JabatanGuru::where('id_guru', $this->dataId)->update([
                'id_jabatan' => $this->id_jabatan,
                'id_kelas'   => $this->id_jabatan == '4' ? $this->id_kelas : '0',
            ]);

            $existingEntries = JabatanGuruDetail::where('id_jabatan_guru', $this->id_jabatan_guru)
                ->get();

            foreach ($existingEntries as $entry) {
                if (!isset($this->id_mapel_kelas[$entry->id_mapel]) || !in_array($entry->id_kelas, $this->id_mapel_kelas[$entry->id_mapel])) {
                    $entry->delete();
                }
            }

            foreach ($this->id_mapel_kelas as $id_mapel => $kelasIds) {
                foreach ($kelasIds as $id_kelas) {
                    JabatanGuruDetail::updateOrCreate(
                        ['id_jabatan_guru' => $this->id_jabatan_guru, 'id_mapel' => $id_mapel, 'id_kelas' => $id_kelas],
                        []
                    );
                }
            }

            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
            $this->dataId = null;
        }
    }

    public function deleteConfirm($id)
    {
        $this->dataId = $id;
        $this->dispatch('swal:confirm', [
            'type'    => 'warning',
            'message' => 'Are you sure?',
            'text'    => 'If you delete the data, it cannot be restored!'
        ]);
    }

    public function delete()
    {

        $guru = ModelsGuru::findOrFail($this->dataId);
        User::findOrFail($guru->id_user)->delete();
        RoleUser::where('user_id', $guru->id_user)->delete();
        $guru->delete();
        $jg = JabatanGuru::select('id')->where('id_guru', $this->dataId)->first();
        JabatanGuruDetail::where('id_jabatan_guru', $jg->id)->delete();
        $jg->delete();

        BankSoal::where('id_guru', $this->dataId)->update(['id_guru' => '']);
        $pengawases = Pengawas::where('id_guru', 'LIKE', '%' . $this->dataId . '%')->get();
        foreach ($pengawases as $pengawas) {
            $idGurus = explode(',', $pengawas->id_guru);
            $idGurus = array_filter($idGurus, function ($id) {
                return $id != $this->dataId;
            });
            $pengawas->id_guru = implode(',', $idGurus);
            if (empty($pengawas->id_guru)) {
                $pengawas->id_guru = null;
            }
            $pengawas->save();
        }

        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}
