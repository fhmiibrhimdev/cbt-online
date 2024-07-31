<?php

namespace App\Livewire\Pengaturan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use App\Models\ProfileSekolah as ModelsProfileSekolah;

class ProfileSekolah extends Component
{
    use WithFileUploads;
    #[Title('Profile Sekolah')]
    #[Validate('nullable|image|max:1024')] // 1MB Max
    public $nama_aplikasi, $nama_sekolah, $nss_nsm, $npsn, $jenjang, $satuan_pendidikan, $alamat, $desa_kelurahan, $kecamatan, $kabupaten_kota, $kodepos, $provinsi, $faksimili, $website, $email, $nomor_telepon, $kepala_sekolah, $nip, $ttd, $logo_aplikasi, $logo_sekolah;

    public function mount()
    {
        $profile = ModelsProfileSekolah::first();
        if ($profile) {
            $this->nama_aplikasi     = $profile->nama_aplikasi;
            $this->nama_sekolah      = $profile->nama_sekolah;
            $this->nss_nsm           = $profile->nss_nsm;
            $this->npsn              = $profile->npsn;
            $this->jenjang           = $profile->jenjang;
            $this->satuan_pendidikan = $profile->satuan_pendidikan;
            $this->alamat            = $profile->alamat;
            $this->desa_kelurahan    = $profile->desa_kelurahan;
            $this->kecamatan         = $profile->kecamatan;
            $this->kabupaten_kota    = $profile->kabupaten_kota;
            $this->kodepos           = $profile->kodepos;
            $this->provinsi          = $profile->provinsi;
            $this->faksimili         = $profile->faksimili;
            $this->website           = $profile->website;
            $this->email             = $profile->email;
            $this->nomor_telepon     = $profile->nomor_telepon;
            $this->kepala_sekolah    = $profile->kepala_sekolah;
            $this->nip               = $profile->nip;
            $this->ttd               = $profile->ttd;
            $this->logo_aplikasi     = $profile->logo_aplikasi;
            $this->logo_sekolah      = $profile->logo_sekolah;
        }
    }

    public function render()
    {
        return view('livewire.pengaturan.profile-sekolah');
    }

    public function update()
    {
        $profile = ModelsProfileSekolah::first();

        if ($profile) {
            $disk = Storage::disk('public');
            if ($this->ttd instanceof \Illuminate\Http\UploadedFile) {
                if ($profile->ttd && $disk->exists($profile->ttd)) {
                    $disk->delete($profile->ttd);
                }

                $profile->ttd = $this->ttd->store('logo', 'public');
            }

            if ($this->logo_aplikasi instanceof \Illuminate\Http\UploadedFile) {
                if ($profile->logo_aplikasi && $disk->exists($profile->logo_aplikasi)) {
                    $disk->delete($profile->logo_aplikasi);
                }
                $profile->logo_aplikasi = $this->logo_aplikasi->store('logo', 'public');
            }

            if ($this->logo_sekolah instanceof \Illuminate\Http\UploadedFile) {
                if ($profile->logo_sekolah && $disk->exists($profile->logo_sekolah)) {
                    $disk->delete($profile->logo_sekolah);
                }
                $profile->logo_sekolah = $this->logo_sekolah->store('logo', 'public');
            }

            $profile->nama_aplikasi     = $this->nama_aplikasi;
            $profile->nama_sekolah      = $this->nama_sekolah;
            $profile->nss_nsm           = $this->nss_nsm;
            $profile->npsn              = $this->npsn;
            $profile->jenjang           = $this->jenjang;
            $profile->satuan_pendidikan = $this->satuan_pendidikan;
            $profile->alamat            = $this->alamat;
            $profile->desa_kelurahan    = $this->desa_kelurahan;
            $profile->kecamatan         = $this->kecamatan;
            $profile->kabupaten_kota    = $this->kabupaten_kota;
            $profile->kodepos           = $this->kodepos;
            $profile->provinsi          = $this->provinsi;
            $profile->faksimili         = $this->faksimili;
            $profile->website           = $this->website;
            $profile->email             = $this->email;
            $profile->nomor_telepon     = $this->nomor_telepon;
            $profile->kepala_sekolah    = $this->kepala_sekolah;
            $profile->nip               = $this->nip;

            $profile->save();

            $this->dispatchAlert('success', 'Success!', 'Data updated successfully.');
        } else {
            ModelsProfileSekolah::create([
                'nama_aplikasi'     => $this->nama_aplikasi,
                'nama_sekolah'      => $this->nama_sekolah,
                'nss_nsm'           => $this->nss_nsm,
                'npsn'              => $this->npsn,
                'jenjang'           => $this->jenjang,
                'satuan_pendidikan' => $this->satuan_pendidikan,
                'alamat'            => $this->alamat,
                'desa_kelurahan'    => $this->desa_kelurahan,
                'kecamatan'         => $this->kecamatan,
                'kabupaten_kota'    => $this->kabupaten_kota,
                'kodepos'           => $this->kodepos,
                'provinsi'          => $this->provinsi,
                'faksimili'         => $this->faksimili,
                'website'           => $this->website,
                'email'             => $this->email,
                'nomor_telepon'     => $this->nomor_telepon,
                'kepala_sekolah'    => $this->kepala_sekolah,
                'nip'               => $this->nip,
                'ttd'               => $this->ttd->store('logo', 'public'),
                'logo_aplikasi'     => $this->logo_aplikasi->store('logo', 'public'),
                'logo_sekolah'      => $this->logo_sekolah->store('logo', 'public'),
            ]);

            $this->dispatchAlert('success', 'Success!', 'Profile created successfully.');
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
}
