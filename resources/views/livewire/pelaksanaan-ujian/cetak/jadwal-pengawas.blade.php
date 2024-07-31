<div>
    <section class="section custom-section">
        <div class="section-header">
            <a href="{{ url('pelaksanaan-ujian/cetak') }}" class="btn btn-muted">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Jadwal Pengawas</h1>
        </div>


        <div class="section-body">
            <div class="card">
                <div class="card-body px-4 py-0 pt-3">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="id_jenises">Jenis Ujian</label>
                                <select wire:model="id_jenises" id="id_jenises" class="form-control">
                                    <option value="">-- Pilih Jenis Ujian --</option>
                                    @foreach ($ujians as $ujian)
                                        <option value="{{ $ujian->id }}">{{ $ujian->nama_jenis }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="start_date">Dari Tanggal</label>
                                <input type="date" wire:model.live="start_date" id="start_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="end_date">Sampai Tanggal</label>
                                <input type="date" wire:model.live="end_date" id="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="ttd">Kolom Tanda Tangan? </label>
                                <label class="switch tw-mt-2.5">
                                    <input type="checkbox" wire:model.live="ttd">
                                    <span class="slider round"></span>
                                </label>
                                <a href="{{ url('/pelaksanaan-ujian/cetak/jadwal-pengawas/' . $this->id_jenises . '/' . $this->start_date . '/' . $this->end_date . '/' . ($ttd ? '1' : '0')) }}"
                                    class="btn btn-primary ml-2" target="_BLANK">
                                    <i class="fas fa-print"></i> Cetak
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body px-4">
                    @foreach ($data->groupBy('nama_ruang') as $ruang => $row)
                        <div
                            class="tw-flex tw-justify-center tw-items-center tw-max-h-screen-md tw-p-10 tw-bg-gray-100 tw-rounded-md">
                            <div
                                class="tw-shadow tw-shadow-gray-300 tw-rounded-md tw-p-8 tw-max-w-screen-md tw-w-[210mm] tw-h-[297mm] tw-bg-white">
                                <div
                                    class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-5">
                                    <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                                        alt="Logo Left" class="tw-h-20">
                                    <div class="tw-text-center px-1 ">
                                        <h1 class="tw-text-base tw-font-bold tw-text-gray-700">DAFTAR PENGAWAS
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
                                <div class="tw-mt-5">
                                    <div class="tw-text-gray-700 tw-font-semibold text-center">
                                        <h1 class="tw-text-base">
                                            Tahun Pelajaran: {{ $tahun_pelajaran }}
                                        </h1>
                                        <p></p>
                                    </div>
                                    <p class="tw-text-gray-700 tw-text-sm tw-mt-5 tw-mb-5">
                                        {{ $ruang }}</p>
                                    <table>
                                        <thead>
                                            <tr class="tw-text-center">
                                                <th width="23%"
                                                    class="tw-tracking-normal tw-py-2 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    Hari & TGL</th>
                                                <th width="30%"
                                                    class="tw-tracking-normal tw-py-2 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    Mata Pelajaran</th>
                                                <th width="9%"
                                                    class="tw-tracking-normal tw-py-2 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    Sesi</th>
                                                <th width="25%"
                                                    class="tw-tracking-normal tw-py-2 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    Pengawas</th>
                                                @if ($ttd)
                                                    <th width="10%"
                                                        class="tw-tracking-normal tw-py-2 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        TTD</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($row->groupBy('tgl_mulai') as $tgl => $items)
                                                @php $tglDisplayed = false; @endphp

                                                @foreach ($items->groupBy('nama_mapel') as $mapel => $mapelItems)
                                                    @php $mapelDisplayed = false; @endphp

                                                    @foreach ($mapelItems->groupBy('nama_sesi') as $sesi => $sesiItems)
                                                        @php
                                                            $sesiRowSpan = $sesiItems->count();
                                                            $supervisorsCollection = $sesiItems
                                                                ->pluck('nama_guru')
                                                                ->filter()
                                                                ->unique();
                                                            $supervisors = $supervisorsCollection->implode(', ');
                                                            $supervisorsCount = $supervisorsCollection->count();
                                                        @endphp

                                                        @foreach ($sesiItems as $index => $gg)
                                                            <tr>
                                                                @if (!$tglDisplayed)
                                                                    <td rowspan="{{ $items->count() }}"
                                                                        class="tw-text-xs tw-text-center tw-border tw-border-black tw-px-2 tw-py-2">
                                                                        {{ \Carbon\Carbon::parse($tgl)->isoFormat('dddd, D MMMM Y') }}
                                                                    </td>
                                                                    @php $tglDisplayed = true; @endphp
                                                                @endif

                                                                @if (!$mapelDisplayed)
                                                                    <td rowspan="{{ $mapelItems->count() }}"
                                                                        class="tw-text-xs tw-border tw-border-black tw-px-2 tw-py-2">
                                                                        {{ $mapel }}</td>
                                                                    @php $mapelDisplayed = true; @endphp
                                                                @endif

                                                                @if ($index == 0)
                                                                    <td rowspan="{{ $sesiRowSpan }}"
                                                                        class="tw-text-xs tw-text-center tw-border tw-border-black tw-px-2 tw-py-2">
                                                                        {{ $sesi }}</td>
                                                                    <td rowspan="{{ $sesiRowSpan }}"
                                                                        class="tw-text-xs tw-border tw-border-black tw-px-2 tw-py-2">
                                                                        {{ $supervisors }}</td>
                                                                    @if ($ttd)
                                                                        <td rowspan="{{ $supervisorsCount }}"
                                                                            class="tw-text-xs tw-border tw-border-black tw-px-2 tw-py-2 tw-text-left">
                                                                            @for ($i = 1; $i <= $supervisorsCount; $i++)
                                                                                @if ($i % 2 != 0)
                                                                                    <span>{{ $i }}.</span><br>
                                                                                @else
                                                                                    <span
                                                                                        class="ml-4">{{ $i }}.</span><br>
                                                                                @endif
                                                                            @endfor
                                                                        </td>
                                                                    @endif
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                $('#id_jenises').select2();

                $('#id_jenises').on('change', function(e) {
                    var data = $('#id_jenises').select2("val");
                    @this.set('id_jenises', data);
                });
            });
        })
    </script>
@endpush
