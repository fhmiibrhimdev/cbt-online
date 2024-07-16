<?php

namespace App\Livewire\Umum;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Siswa as ModelsSiswa;
use Illuminate\Support\Facades\Hash;

class Siswa extends Component
{
    use WithPagination;
    #[Title('Siswa')]
    
    protected $listeners = [
        'delete'
    ];
    
    protected $rules = [
        'nama_siswa' => 'required',
        'nis' => 'required',
        'nisn' => 'required',
        'tgl_lahir' => 'required',
    ];

    public $lengthData = 25;
    public $searchTerm;
    public $previousSearchTerm = '';
    public $isEditing = false;

    public $dataId, $id_user, $nama_siswa, $nis, $nisn, $jk, $kelas, $tahun_masuk, $sekolah_asal, $status,
           $tempat_lahir, $tgl_lahir, $agama, $alamat, $rt, $rw, $kelurahan_desa, $kecamatan, $kabupaten_kota, $kode_pos, $no_hp,
           $status_keluarga, $anak_ke, $nama_ayah, $pekerjaan_ayah, $alamat_ayah, $nohp_ayah, $nama_ibu, $pekerjaan_ibu, $alamat_ibu, $nohp_ibu,
           $nama_wali, $pekerjaan_wali, $alamat_wali, $nohp_wali;

    public function mount()
    {
        $this->id_user = '';
        $this->nama_siswa = '';
        $this->nis = '';
        $this->nisn = '';
        $this->jk = '';
        $this->kelas = '';
        $this->tahun_masuk = '';
        $this->sekolah_asal = '';
        $this->status = 'Aktif';
        $this->tempat_lahir = '';
        $this->tgl_lahir = '';
        $this->agama = '';
        $this->alamat = '';
        $this->rt = '';
        $this->rw = '';
        $this->kelurahan_desa = '';
        $this->kecamatan = '';
        $this->kabupaten_kota = '';
        $this->kode_pos = '';
        $this->no_hp = '';
        $this->status_keluarga = '';
        $this->anak_ke = '';
        $this->nama_ayah = '';
        $this->pekerjaan_ayah = '';
        $this->alamat_ayah = '';
        $this->nohp_ayah = '';
        $this->nama_ibu = '';
        $this->pekerjaan_ibu = '';
        $this->alamat_ibu = '';
        $this->nohp_ibu = '';
        $this->nama_wali = '';
        $this->pekerjaan_wali = '';
        $this->alamat_wali = '';
        $this->nohp_wali = '';
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
        $search = '%'.$this->searchTerm.'%';

        $data = ModelsSiswa::where(function($query) use ($search) {
                        $query->where('nama_siswa', 'LIKE', $search);
                        $query->orWhere('nis', 'LIKE', $search);
                        $query->orWhere('nisn', 'LIKE', $search);
                        $query->orWhere('jk', 'LIKE', $search);
                        $query->orWhere('kelas', 'LIKE', $search);
                    })
                    ->paginate($this->lengthData);

        return view('livewire.umum.siswa', compact('data'));
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
            'name' => $this->nama_siswa,
            'email' => $this->nisn.'@cbt',
            'password' => Hash::make($this->tgl_lahir),
            'active' => '0'
        ]);

        $user->addRole('siswa');

        ModelsSiswa::create([
            'id_user'     => $user->id,
            'nama_siswa'     => $this->nama_siswa,
            'nis'     => $this->nis,
            'nisn'     => $this->nisn,
            'jk'     => $this->jk,
            'kelas'     => $this->kelas,
            'tahun_masuk'     => $this->tahun_masuk,
            'tgl_lahir'     => $this->tgl_lahir,
        ]);

        $this->dispatchAlert('success', 'Success!', 'Data created successfully.');
    }
    
    public function edit($id)
    {
        $this->isEditing = true;
        $data = ModelsSiswa::findOrFail($id);
        $this->dataId = $id;
        $this->id_user = $data->id_user;
        $this->nama_siswa = $data->nama_siswa;
        $this->nis = $data->nis;
        $this->nisn = $data->nisn;
        $this->jk = $data->jk;
        $this->kelas = $data->kelas;
        $this->tahun_masuk = $data->tahun_masuk;
        $this->sekolah_asal = $data->sekolah_asal;
        $this->status = $data->status;
        $this->tempat_lahir = $data->tempat_lahir;
        $this->tgl_lahir = $data->tgl_lahir;
        $this->agama = $data->agama;
        $this->alamat = $data->alamat;
        $this->rt = $data->rt;
        $this->rw = $data->rw;
        $this->kelurahan_desa = $data->kelurahan_desa;
        $this->kecamatan = $data->kecamatan;
        $this->kabupaten_kota = $data->kabupaten_kota;
        $this->kode_pos = $data->kode_pos;
        $this->no_hp = $data->no_hp;
        $this->status_keluarga = $data->status_keluarga;
        $this->anak_ke = $data->anak_ke;
        $this->nama_ayah = $data->nama_ayah;
        $this->pekerjaan_ayah = $data->pekerjaan_ayah;
        $this->alamat_ayah = $data->alamat_ayah;
        $this->nohp_ayah = $data->nohp_ayah;
        $this->nama_ibu = $data->nama_ibu;
        $this->pekerjaan_ibu = $data->pekerjaan_ibu;
        $this->alamat_ibu = $data->alamat_ibu;
        $this->nohp_ibu = $data->nohp_ibu;
        $this->nama_wali = $data->nama_wali;
        $this->pekerjaan_wali = $data->pekerjaan_wali;
        $this->alamat_wali = $data->alamat_wali;
        $this->nohp_wali = $data->nohp_wali;
    }
    
    public function update()
    {
        $this->validate();
        
        if ($this->dataId) {

            $siswa = ModelsSiswa::findOrFail($this->dataId);

            User::findOrFail($siswa->id_user)->update([
                'name' => $this->nama_siswa,
                'email' => $this->nisn.'@cbt',
                'password' => Hash::make($this->tgl_lahir),
            ]);

            $siswa->update([
                'nama_siswa' => $this->nama_siswa,
                'nis' => $this->nis,
                'nisn' => $this->nisn,
                'jk' => $this->jk,
                'kelas' => $this->kelas,
                'tahun_masuk' => $this->tahun_masuk,
                'sekolah_asal' => $this->sekolah_asal,
                'status' => $this->status,
                'tempat_lahir' => $this->tempat_lahir,
                'tgl_lahir' => $this->tgl_lahir,
                'agama' => $this->agama,
                'alamat' => $this->alamat,
                'rt' => $this->rt,
                'rw' => $this->rw,
                'kelurahan_desa' => $this->kelurahan_desa,
                'kecamatan' => $this->kecamatan,
                'kabupaten_kota' => $this->kabupaten_kota,
                'kode_pos' => $this->kode_pos,
                'no_hp' => $this->no_hp,
                'status_keluarga' => $this->status_keluarga,
                'anak_ke' => $this->anak_ke,
                'nama_ayah' => $this->nama_ayah,
                'pekerjaan_ayah' => $this->pekerjaan_ayah,
                'alamat_ayah' => $this->alamat_ayah,
                'nohp_ayah' => $this->nohp_ayah,
                'nama_ibu' => $this->nama_ibu,
                'pekerjaan_ibu' => $this->pekerjaan_ibu,
                'alamat_ibu' => $this->alamat_ibu,
                'nohp_ibu' => $this->nohp_ibu,
                'nama_wali' => $this->nama_wali,
                'pekerjaan_wali' => $this->pekerjaan_wali,
                'alamat_wali' => $this->alamat_wali,
                'nohp_wali' => $this->nohp_wali,
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
        $siswa = ModelsSiswa::findOrFail($this->dataId);
        User::findOrFail($siswa->id_user)->delete();
        RoleUser::where('user_id', $siswa->id_user)->delete();
        $siswa->delete();
        $this->dispatchAlert('success', 'Success!', 'Data deleted successfully.');
    }
}