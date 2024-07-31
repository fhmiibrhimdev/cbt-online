<div>
    <section class="section custom-section">
        <div class="section-header">
            <a href="{{ url('pelaksanaan-ujian/cetak') }}" class="btn btn-muted">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Cetak Kartu Peserta</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="tw-flex tw-ml-6 tw-mt-6 tw-mb-5 lg:tw-mb-1">
                            <h3 class="tw-tracking-wider tw-text-[#34395e]  tw-text-base tw-font-semibold">
                                Setting Kartu</h3>
                            <button wire:click="update()" class="btn btn-primary ml-auto mr-4"><i
                                    class="fas fa-save"></i>
                                SAVE DATA</button>
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group">
                                <label for="header_1">Header 1</label>
                                <textarea wire:model.live="header_1" id="header_1" class="form-control" style="height: 65px !important"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="header_2">Header 2</label>
                                <textarea wire:model.live="header_2" id="header_2" class="form-control" style="height: 65px !important"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="header_3">Header 3</label>
                                <textarea wire:model.live="header_3" id="header_3" class="form-control" style="height: 65px !important"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="header_4">Header 4</label>
                                <textarea wire:model.live="header_4" id="header_4" class="form-control" style="height: 65px !important"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal</label>
                                <input type="text" wire:model.live="tanggal" id="tanggal" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="ukuran_ttd">Ukuran TTD</label>
                                <input type="text" wire:model.live="ukuran_ttd" id="ukuran_ttd" class="form-control">
                            </div>
                            <div class="card">
                                <div class="card-body p-4">
                                    <div>
                                        <h3 class="tw-tracking-wider tw-text-[#34395e]  tw-text-base tw-font-semibold">
                                            Tampilan Kartu</h3>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6 tw-flex tw-justify-between">
                                            <label for="nomor_peserta">Nomor Peserta</label>
                                            <label class="switch">
                                                <input type="checkbox" wire:model="nomor_peserta"
                                                    @if ($nomor_peserta) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-6 tw-flex tw-justify-between">
                                            <label for="nama_peserta">Nama Peserta</label>
                                            <label class="switch">
                                                <input type="checkbox" wire:model="nama_peserta"
                                                    @if ($nama_peserta) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6 tw-flex tw-justify-between">
                                            <label for="nis_nisn">NIS/NISN</label>
                                            <label class="switch">
                                                <input type="checkbox" wire:model="nis_nisn"
                                                    @if ($nis_nisn) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-6 tw-flex tw-justify-between">
                                            <label for="ruang_sesi">Ruang/Sesi</label>
                                            <label class="switch">
                                                <input type="checkbox" wire:model="ruang_sesi"
                                                    @if ($ruang_sesi) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-6 tw-flex tw-justify-between">
                                            <label for="username">Username</label>
                                            <label class="switch">
                                                <input type="checkbox" wire:model="username"
                                                    @if ($username) checked @endif>
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                        <div class="col-lg-6 tw-flex tw-justify-between">
                                            <label for="password">Password</label>
                                            <label class="switch">
                                                <input type="checkbox" wire:model="password"
                                                    @if ($password) checked @endif>
                                                <span class="slider round" wire:model="password"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <h3>Preview</h3>
                                <div class="card-body px-4">
                                    <div
                                        class="tw-flex tw-justify-center tw-items-center tw-p-10 tw-bg-gray-100 tw-rounded-md">
                                        <div class="tw-border tw-border-black tw-p-4 tw-max-w-md tw-bg-white">
                                            <div
                                                class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-2">
                                                <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                                                    alt="Logo Left" class="tw-h-14">
                                                <div class="tw-text-center px-1">
                                                    <h1 class="tw-text-xs">{{ $header_1 }}</h1>
                                                    <h2 class="tw-text-xs tw-font-bold tw-text-gray-700">
                                                        {{ $header_2 }}</h2>
                                                    <h4 class="tw-text-xs">{{ $header_3 }}</h4>
                                                    <h4 class="tw-text-xs">{{ $header_4 }}</h4>
                                                </div>
                                                <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_sekolah')->logo_sekolah) }}"
                                                    alt="Logo Right" class="tw-h-14">
                                            </div>
                                            <div class="tw-text-sm tw-pb-2 tw-mb-2">
                                                <table>
                                                    <tbody>
                                                        @if ($nomor_peserta)
                                                            <tr class="tw-text-black">
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="35%">
                                                                    Nomor
                                                                    Peserta</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="4%">
                                                                    :</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="50%">
                                                                    0000.00.000
                                                                </td>
                                                                <td></td>
                                                            </tr>
                                                        @endif
                                                        @if ($nama_peserta)
                                                            <tr class="tw-text-black">
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="35%">Nama Peserta
                                                                </td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="4%">:</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="50%">Fahmi Ibrahim
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if ($nis_nisn)
                                                            <tr class="tw-text-black">
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="35%">NIS/NISN</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="4%">:</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="50%">0044379311
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        <tr class="tw-text-black">
                                                            <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                width="35%">Kelas</td>
                                                            <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                width="4%">:</td>
                                                            <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                width="50%">XII - TEDK
                                                            </td>
                                                        </tr>
                                                        @if ($ruang_sesi)
                                                            <tr class="tw-text-black">
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="35%">Ruang/Sesi
                                                                </td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="4%">:</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="50%">R1/S2</td>
                                                            </tr>
                                                        @endif
                                                        @if ($username)
                                                            <tr class="tw-text-black">
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="35%">Username</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="4%">:</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="50%">0044379311@
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @if ($password)
                                                            <tr class="tw-text-black">
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="35%">Password</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="4%">:</td>
                                                                <td class="tw-border-none tw-p-0 tw-text-xs"
                                                                    width="50%">203932</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tw-flex tw-justify-between tw-items-center tw-mt-2">
                                                <div
                                                    class="tw-flex tw-flex-col tw-items-center tw-border tw-border-black tw-p-2">
                                                    <img src="http://localhost:8081/assets/img/siswa.png"
                                                        alt="Student Photo" class="tw-h-[70px] tw-w-[60px] tw-border">
                                                </div>
                                                <div class="tw-text-center tw-text-black">
                                                    <p class="tw-text-xs">Jakarta Timur, {{ $tanggal }}</p>
                                                    <p class="tw-text-xs tw-font-bold">Kepala Sekolah,</p>
                                                    <center>
                                                        <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('ttd')->ttd) }}"
                                                            alt="Signature" class="tw-h-8 tw-my-2"
                                                            style="transform: scale({{ $ukuran_ttd }});">
                                                    </center>
                                                    <p class="tw-text-xs tw-font-bold">Fahmi Ibrahim</p>
                                                    <p class="tw-text-xs">NIP: -</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <h3>Cetak</h3>
                                <div class="card-body px-4">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <select wire:model="id_kelases" id="id_kelases" class="form-control">
                                                <option value="0" disabled>-- Pilih Kelas --</option>
                                                @foreach ($kelases as $kelas)
                                                    <optgroup label="{{ $kelas->level }}">
                                                        <option value="{{ $kelas->id }}">{{ $kelas->level }} -
                                                            {{ $kelas->kode_kelas }}
                                                        </option>
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <a href="{{ route('cetak-kartu-peserta', ['id_kelas' => $id_kelases]) }}"
                                                target="_BLANK"
                                                class="btn btn-primary tw-py-2 @disabled($id_kelases == '0')"><i
                                                    class="fas fa-print"></i>
                                                Cetak</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>
</div>

@push('general-css')
    <link href="{{ asset('assets/midragon/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('js-libraries')
    <script src="{{ asset('/assets/midragon/select2/select2.full.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        window.addEventListener('initSelect2', event => {
            $(document).ready(function() {
                $('#id_kelases').select2();

                $('#id_kelases').on('change', function(e) {
                    var data = $('#id_kelases').select2("val");
                    @this.set('id_kelases', data);
                });
            });
        })
    </script>
@endpush
