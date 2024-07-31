<div>
    <section class="section custom-section">
        <div class="section-header">
            <a href="{{ url('pelaksanaan-ujian/cetak') }}" class="btn btn-muted">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Cetak Daftar Kehadiran</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="tw-flex tw-ml-6 tw-mt-6 tw-mb-5 lg:tw-mb-1">
                            <h3 class="tw-tracking-wider tw-text-[#34395e]  tw-text-base tw-font-semibold">
                                Setting Kop Daftar Kehadiran
                            </h3>
                            <button wire:click="update()" class="btn btn-primary ml-auto mr-4"><i
                                    class="fas fa-save"></i>
                                SAVE DATA</button>
                        </div>
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="header_1">Header 1</label>
                                        <input wire:model.live="header_1" id="header_1" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="header_2">Header 2</label>
                                        <input wire:model.live="header_2" id="header_2" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="header_3">Header 3</label>
                                        <input wire:model.live="header_3" id="header_3" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="header_4">Header 4</label>
                                        <input wire:model.live="header_4" id="header_4" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <h3>Cetak</h3>
                        {{-- <pre>@json($data->groupBy('id_siswa'), JSON_PRETTY_PRINT)</pre> --}}
                        <div class="card-body px-4">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="id_ruanges">Ruang</label>
                                        <select wire:model="id_ruanges" id="id_ruanges" class="form-control">
                                            <option value="0">-- Pilih Ruang --</option>
                                            @foreach ($ruangs as $ruang)
                                                <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="id_sesies">Sesi</label>
                                        <select wire:model="id_sesies" id="id_sesies" class="form-control">
                                            <option value="0">-- Pilih Sesi --</option>
                                            @foreach ($sesis as $sesi)
                                                <option value="{{ $sesi->id }}">{{ $sesi->nama_sesi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="id_jadwales">Jadwal</label>
                                        {{-- @json($mapels) --}}
                                        <select wire:model="id_jadwales" id="id_jadwales" class="form-control">
                                            <option value="0">-- Pilih Jadwal --</option>
                                            @foreach ($mapels as $mapel)
                                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <a href="{{ url('/pelaksanaan-ujian/cetak/absen-peserta/' . $this->id_ruanges . '/' . $this->id_sesies . '/' . $this->id_jadwales) }}"
                                        target="_BLANK"
                                        class="btn btn-primary tw-py-2 tw-mt-7 form-control @if ($this->id_ruanges == '0' && $this->id_sesies == '0' && $this->id_jadwales == '0') disabled @endif"><i
                                            class="fas fa-print"></i>
                                        Cetak</a>
                                </div>
                            </div>

                            <div class="tw-flex tw-justify-center tw-items-center tw-p-10 tw-bg-gray-100 tw-rounded-md">
                                <div
                                    class="tw-shadow tw-shadow-gray-300 tw-rounded-md tw-p-8 tw-max-w-screen-md tw-bg-white">
                                    <div
                                        class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-5">
                                        <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                                            alt="Logo Left" class="tw-h-20">
                                        <div class="tw-text-center px-1">
                                            <h1 class="tw-text-base tw-font-bold tw-text-gray-700">{{ $header_1 }}
                                            </h1>
                                            <h2 class="tw-text-base tw-font-bold tw-text-gray-700">
                                                {{ $header_2 }}</h2>
                                            <h4 class="tw-text-base tw-font-bold tw-text-gray-700">{{ $header_3 }}
                                            </h4>
                                            <h4 class="tw-text-xs">{{ $header_4 }}</h4>
                                        </div>
                                        <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_sekolah')->logo_sekolah) }}"
                                            alt="Logo Right" class="tw-h-20">
                                    </div>
                                    <div class="tw-text-sm tw-pb-2 tw-mb-2">
                                        <div class="row tw-text-xs my-4">
                                            <div class="col-4">
                                                <table>
                                                    <tr>
                                                        <td width="40%" class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            Ruang</td>
                                                        <td width="8%" class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            :
                                                        </td>
                                                        <td width="70%" class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            {{ $nama_ruang ?? '...' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">Sesi</td>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">:</td>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            {{ $nama_sesi ?? '...' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">Waktu</td>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">:</td>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            {{ $waktu ?? '...' }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-8">
                                                <table>
                                                    <tr>
                                                        <td width="30%"
                                                            class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            Hari/Tanggal</td>
                                                        <td width="3%"
                                                            class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            :
                                                        </td>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            {{ $hari_tanggal ? \Carbon\Carbon::parse($hari_tanggal)->isoFormat('dddd, D MMMM Y') : '...' }}
                                                    </tr>
                                                    <tr>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">Mata Pelajaran
                                                        </td>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">:</td>
                                                        <td class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            {{ $nama_mapel ?? '...' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <table class="tw-border tw-border-black" border="1">
                                            <thead>
                                                <tr class="tw-border tw-border-black tw-text-center">
                                                    <th width="8%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        No
                                                    </th>
                                                    <th width="20%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        No.
                                                        Peserta</th>
                                                    <th width="40%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        Nama</th>
                                                    <th width="12%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        Kelas</th>
                                                    <th colspan="2" width="25%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        Tanda Tangan</th>
                                                    <th width="15%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        Ket
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data->groupBy('id_siswa') as $row)
                                                    <tr class="tw-text-center">
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                            {{ $loop->index + 1 }}
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                            {{ $row[0]['nomor_peserta'] }}
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black tw-text-left">
                                                            {{ strtoupper($row[0]['nama_siswa']) }}</td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                            {{ $row[0]['nama_kelas'] }}</td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-2 tw-text-xs tw-bg-white tw-border tw-border-black tw-text-left">
                                                            @if ($loop->index % 2 == 0)
                                                                {{ $loop->index + 1 }}.
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-2 tw-text-xs tw-bg-white tw-border tw-border-black tw-text-left">
                                                            @if ($loop->index % 2 == 1)
                                                                {{ $loop->index + 1 }}.
                                                            @endif
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="row mt-5">
                                            <div class="col-6">
                                                <table>
                                                    <tr>
                                                        <td width="150%"
                                                            class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border tw-border-l tw-border-t tw-border-b-0 tw-border-r-0 tw-border-black">
                                                            Jumlah
                                                            peserta yang seharusnya hadir</td>
                                                        <td class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border-t tw-border-b-0 tw-border-black"
                                                            width="5%">:</td>
                                                        <td class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border tw-border-r tw-border-t tw-border-b-0 tw-border-l-0 tw-border-black"
                                                            width="50%">____ orang</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="150%"
                                                            class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border tw-border-l tw-border-t-0 tw-border-b-0 tw-border-r-0 tw-border-black">
                                                            Jumlah
                                                            peserta yang tidak hadir</td>
                                                        <td class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border-t-0 tw-border-b-0 tw-border-black"
                                                            width="5%">:</td>
                                                        <td class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border tw-border-r tw-border-t-0 tw-border-b-0 tw-border-l-0 tw-border-black"
                                                            width="50%">____ orang</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="150%"
                                                            class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border tw-border-l tw-border-t-0 tw-border-b tw-border-r-0 tw-border-black">
                                                            Jumlah
                                                            peserta yang hadir</td>
                                                        <td class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border-t-0 tw-border-b tw-border-black"
                                                            width="5%">:</td>
                                                        <td class="tw-text-[12.5px] tw-px-2 tw-py-1 tw-border tw-border-r tw-border-t-0 tw-border-b tw-border-l-0 tw-border-black"
                                                            width="50%">____ orang</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row tw-text-center tw-my-10">
                                            <div class="col-6 tw-font-semibold tw-text-xs tw-text-black">
                                                <p class="tw-mb-20">PENGAWAS I</p>
                                                <p>( .......................................... )</p>
                                                <p class="tw-text-xs tw-text-gray-600">NIP
                                                    .......................................</p>
                                            </div>
                                            <div class="col-6 tw-font-semibold tw-text-xs tw-text-black">
                                                <p class="tw-mb-20">PENGAWAS II</p>
                                                <p>( .......................................... )</p>
                                                <p class="tw-text-xs tw-text-gray-600">NIP
                                                    .......................................</p>
                                            </div>
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
                $('#id_ruanges').select2();
                $('#id_ruanges').on('change', function(e) {
                    var data = $('#id_ruanges').select2("val");
                    @this.set('id_ruanges', data);
                });

                $('#id_sesies').select2();
                $('#id_sesies').on('change', function(e) {
                    var data = $('#id_sesies').select2("val");
                    @this.set('id_sesies', data);
                });

                $('#id_jadwales').select2();
                $('#id_jadwales').on('change', function(e) {
                    var data = $('#id_jadwales').select2("val");
                    @this.set('id_jadwales', data);
                });
            });
        })
    </script>
@endpush
