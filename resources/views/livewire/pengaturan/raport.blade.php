<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Pengaturan Raport</h1>
        </div>

        <div class="section-body">
            <div class="tw-border-l-4 tw-border-blue-500 tw-bg-blue-100 tw-p-4 tw-mb-4 tw-rounded-lg">
                <p class="tw-text-blue-700 tw-font-bold">KKM</p>
                <ul class="tw-list-disc ml-4 tw-text-blue-700">
                    <li>KKM Tunggal: mengatur semua mapel mempunyai KKM yang sama</li>
                    <li>Total BOBOT harus 100</li>
                    <li>Jangan lupa untuk menyimpan perubahan</li>
                </ul>
                <p class="tw-text-blue-700 tw-font-bold mt-3">TAMPILKAN NIP</p>
                <ul class="tw-list-disc ml-4 tw-text-blue-700">
                    <li>Pilih <b>YA</b> jika NIP kepala sekolah / walikelas diisi NIP</li>
                    <li>Jika NIP kepala sekolah / walikelas diisi NUPTK atau nomor lain selain NIP maka sebaiknya pilih
                        <b>TIDAK</b> ditampilkan
                    </li>
                </ul>
            </div>
            <div class="card">
                <div class="card-body px-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tgl_raport_pts">Tgl Rapor PTS</label>
                                <input type="date" wire:model="tgl_raport_pts" id="tgl_raport_pts"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tgl_raport_akhir">Tgl Rapor Akhir Kls X-XI</label>
                                <input type="date" wire:model="tgl_raport_akhir" id="tgl_raport_akhir"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="tgl_raport_kelas_akhir">Tgl Rapor Akhir Kls XII</label>
                                <input type="date" wire:model="tgl_raport_kelas_akhir" id="tgl_raport_kelas_akhir"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nip_kepsek">Tampilkan NIP Kepala Sekolah</label>
                                <select wire:model="nip_kepsek" id="nip_kepsek" class="form-control">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nip_walikelas">Tampilkan NIP Walikelas</label>
                                <select wire:model="nip_walikelas" id="nip_walikelas" class="form-control">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="kkm_tunggal">KKM Tunggal</label>
                                <select wire:model.live="kkm_tunggal" id="kkm_tunggal" class="form-control">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="kkm">KKM</label>
                                <input type="text" wire:model="kkm" id="kkm" class="form-control"
                                    @if ($kkm_tunggal == 0) disabled @endif>
                            </div>
                            <div class="form-group">
                                <label for="bobot_ph">Bobot PH</label>
                                <input type="text" wire:model="bobot_ph" id="bobot_ph" class="form-control"
                                    @if ($kkm_tunggal == 0) disabled @endif>
                            </div>
                            <div class="form-group">
                                <label for="bobot_pts">Bobot PTS</label>
                                <input type="text" wire:model="bobot_pts" id="bobot_pts" class="form-control"
                                    @if ($kkm_tunggal == 0) disabled @endif>
                            </div>
                            <div class="form-group">
                                <label for="bobot_pas">Bobot PAS</label>
                                <input type="text" wire:model="bobot_pas" id="bobot_pas" class="form-control"
                                    @if ($kkm_tunggal == 0) disabled @endif>
                            </div>
                        </div>
                    </div>
                    <button wire:click.prevent="update()" wire:loading.attr="disabled"
                        class="btn btn-primary float-right">
                        <i class="fas fa-save"></i> Save Data
                    </button>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        window.onbeforeunload = function() {
            window.scrollTo(350, 500);
        };
    </script>
@endpush
