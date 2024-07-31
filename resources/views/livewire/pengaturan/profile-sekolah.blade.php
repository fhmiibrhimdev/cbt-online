<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Profile Sekolah</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body px-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_aplikasi">Nama Aplikasi</label>
                                <input type="text" class="form-control" id="nama_aplikasi" wire:model="nama_aplikasi">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nama_sekolah">Nama Sekolah</label>
                                <input type="text" class="form-control" id="nama_sekolah" wire:model="nama_sekolah">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nss_nsm">NSS/NSM</label>
                                <input type="text" class="form-control" id="nss_nsm" wire:model="nss_nsm">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="npsn">NPSN</label>
                                <input type="text" class="form-control" id="npsn" wire:model="npsn">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="jenjang">Jenjang</label>
                                <select class="form-control" id="jenjang" wire:model.live="jenjang">
                                    <option value="" disabled>-- Pilih Jenjang --</option>
                                    <option value="SD/MI">SD/MI</option>
                                    <option value="SMP/MTS">SMP/MTS</option>
                                    <option value="SMA/MA/SMK">SMA/MA/SMK</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="satuan_pendidikan">Satuan Pendidikan</label>
                                <select class="form-control" id="satuan_pendidikan" wire:model="satuan_pendidikan">
                                    <option value="" disabled>-- Pilih Satuan Pend --</option>
                                    @if ($jenjang == 'SD/MI')
                                        <option value="SD">SD</option>
                                        <option value="MI">MI</option>
                                    @elseif ($jenjang == 'SMP/MTS')
                                        <option value="SMP">SMP</option>
                                        <option value="MTS">MTS</option>
                                    @elseif ($jenjang == 'SMA/MA/SMK')
                                        <option value="SMA">SMA</option>
                                        <option value="MA">MA</option>
                                        <option value="SMK">SMK</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" wire:model="alamat" style="height: 135px !important;"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="desa_kelurahan">Desa/Kelurahan</label>
                                <input type="text" class="form-control" id="desa_kelurahan"
                                    wire:model="desa_kelurahan">
                            </div>
                            <div class="form-group">
                                <label for="kabupaten_kota">Kabupaten/Kota</label>
                                <input type="text" class="form-control" id="kabupaten_kota"
                                    wire:model="kabupaten_kota">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" wire:model="kecamatan">
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="kodepos">Kode Pos</label>
                                        <input type="number" class="form-control" id="kodepos" wire:model="kodepos">
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi</label>
                                        <input type="text" class="form-control" id="provinsi"
                                            wire:model="provinsi">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="faksimili">Faksimili</label>
                                <input type="text" class="form-control" id="faksimili" wire:model="faksimili">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="website">Website</label>
                                <input type="text" class="form-control" id="website" wire:model="website">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" wire:model="email">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="nomor_telepon">Nomor Telepon</label>
                                <input type="text" class="form-control" id="nomor_telepon"
                                    wire:model="nomor_telepon">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kepala_sekolah">Kepala Sekolah</label>
                                <input type="text" class="form-control" id="kepala_sekolah"
                                    wire:model="kepala_sekolah">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" id="nip" wire:model="nip">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            @if (is_string($ttd))
                                <center>
                                    <img src="{{ Storage::url($ttd) }}" alt="ttd.jpeg" width="50%">
                                </center>
                            @elseif ($ttd && $ttd->temporaryUrl() && !$errors->has('ttd'))
                                <center>
                                    <img src="{{ $ttd->temporaryUrl() }}" alt="ttd.jpeg" width="50%">
                                </center>
                            @endif
                            <div class="form-group">
                                <label for="ttd">TTD</label>
                                <input type="file" class="form-control" id="ttd" wire:model="ttd">
                                @error('ttd')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            @if (is_string($logo_aplikasi))
                                <center>
                                    <img src="{{ Storage::url($logo_aplikasi) }}" alt="logo_aplikasi.jpeg"
                                        width="50%">
                                </center>
                            @elseif ($logo_aplikasi && $logo_aplikasi->temporaryUrl() && !$errors->has('logo_aplikasi'))
                                <center>
                                    <img src="{{ $logo_aplikasi->temporaryUrl() }}" alt="logo_aplikasi.jpeg"
                                        width="50%">
                                </center>
                            @endif
                            <div class="form-group">
                                <label for="logo_aplikasi">Logo Aplikasi</label>
                                <input type="file" class="form-control" id="logo_aplikasi"
                                    wire:model="logo_aplikasi">
                                @error('logo_aplikasi')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4">
                            @if (is_string($logo_sekolah))
                                <center>
                                    <img src="{{ Storage::url($logo_sekolah) }}" alt="logo_sekolah.jpeg"
                                        width="50%">
                                </center>
                            @elseif ($logo_sekolah && $logo_sekolah->temporaryUrl() && !$errors->has('logo_sekolah'))
                                <center>
                                    <img src="{{ $logo_sekolah->temporaryUrl() }}" alt="logo_sekolah.jpeg"
                                        width="50%">
                                </center>
                            @endif
                            <div class="form-group">
                                <label for="logo_sekolah">Logo Sekolah</label>
                                <input type="file" class="form-control" id="logo_sekolah"
                                    wire:model="logo_sekolah">
                                @error('logo_sekolah')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="float-right">
                        <button wire:click="update()" class="btn btn-primary">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
