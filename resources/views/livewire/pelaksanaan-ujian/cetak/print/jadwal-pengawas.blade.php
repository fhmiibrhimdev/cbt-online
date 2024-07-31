<div>
    <div class="container header">
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-5">
            <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                alt="Logo Left" class="tw-h-[104px]">
            <div class="tw-text-center px-1 ">
                <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900">DAFTAR PENGAWAS</h1>
                <h2 class="tw-text-2xl tw-font-bold tw-text-gray-900">
                    {{ $header_2 }}</h2>
                <h4 class="tw-text-2xl tw-font-bold tw-text-gray-900">{{ $header_3 }}
                </h4>
                <h4 class="tw-text-base tw-text-gray-600">{{ $header_4 }}</h4>
            </div>
            <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_sekolah')->logo_sekolah) }}"
                alt="Logo Right" class="tw-h-[104px]">
        </div>
        <div class="tw-text-black tw-font-bold text-center tw-mt-10">
            <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900">DAFTAR HADIR PENGAWAS</h1>
            <h1 class="tw-text-lg tw-text-gray-600 tw-uppercase">
                Tahun Pelajaran: {{ $tahun_pelajaran }}
            </h1>
            <p></p>
        </div>
    </div>
    <div class="container content">
        @foreach ($data->groupBy('nama_ruang') as $ruang => $row)
            <div class="page-break">
                <p class="tw-text-black tw-font-bold tw-text-xl tw-mt-5 tw-mb-5">
                    {{ $ruang }}
                </p>
                <table>
                    <thead>
                        <tr class="tw-text-center">
                            <th width="23%"
                                class="tw-tracking-normal tw-py-2 tw-text-lg tw-text-black tw-bg-white tw-border tw-border-black">
                                Hari & TGL</th>
                            <th width="40%"
                                class="tw-tracking-normal tw-py-2 tw-text-lg tw-text-black tw-bg-white tw-border tw-border-black">
                                Mata Pelajaran</th>
                            <th width="9%"
                                class="tw-tracking-normal tw-py-2 tw-text-lg tw-text-black tw-bg-white tw-border tw-border-black">
                                Sesi</th>
                            <th width="25%"
                                class="tw-tracking-normal tw-py-2 tw-text-lg tw-text-black tw-bg-white tw-border tw-border-black">
                                Pengawas</th>
                            @if ($ttds)
                                <th width="10%"
                                    class="tw-tracking-normal tw-py-2 tw-text-lg tw-text-black tw-bg-white tw-border tw-border-black">
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
                                        $supervisorsCollection = $sesiItems->pluck('nama_guru')->filter()->unique();
                                        $supervisors = $supervisorsCollection->implode(', ');
                                        $supervisorsCount = $supervisorsCollection->count();
                                    @endphp

                                    @foreach ($sesiItems as $index => $gg)
                                        <tr>
                                            @if (!$tglDisplayed)
                                                <td rowspan="{{ $items->count() }}"
                                                    class="tw-text-lg tw-text-black tw-border tw-border-black tw-px-2 tw-py-2 tw-text-center">
                                                    {{ \Carbon\Carbon::parse($tgl)->isoFormat('dddd, D MMMM Y') }}
                                                </td>
                                                @php $tglDisplayed = true; @endphp
                                            @endif

                                            @if (!$mapelDisplayed)
                                                <td rowspan="{{ $mapelItems->count() }}"
                                                    class="tw-text-lg tw-text-black tw-border tw-border-black tw-px-2 tw-py-2">
                                                    {{ $mapel }}</td>
                                                @php $mapelDisplayed = true; @endphp
                                            @endif

                                            @if ($index == 0)
                                                <td rowspan="{{ $sesiRowSpan }}"
                                                    class="tw-text-lg tw-text-black tw-border tw-border-black tw-px-2 tw-py-2 tw-text-center">
                                                    {{ $sesi }}</td>
                                                <td rowspan="{{ $sesiRowSpan }}"
                                                    class="tw-text-lg tw-text-black tw-border tw-border-black tw-px-2 tw-py-2">
                                                    {{ $supervisors }}</td>
                                                @if ($ttds)
                                                    <td rowspan="{{ $supervisorsCount }}"
                                                        class="tw-text-lg tw-text-black tw-border tw-border-black tw-px-2 tw-py-2 tw-text-left">
                                                        @for ($i = 1; $i <= $supervisorsCount; $i++)
                                                            @if ($i % 2 != 0)
                                                                <span>{{ $i }}.</span><br>
                                                            @else
                                                                <span class="ml-4">{{ $i }}.</span><br>
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
            <div class="footer">
                <div class="row">
                    <div class="col-6">
                        <div class="tw-text-black tw-font-bold tw-mt-10 tw-text-xl tw-tracking-normal">
                            <p>Mengetahui :</p>
                            <p>Kepala Sekolah,</p>
                            <br><br><br><br>
                            <p>NIP</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="tw-text-black tw-font-bold tw-mt-10 tw-text-xl tw-tracking-normal">
                            <p>&nbsp;</p>
                            <p>Ketua Penyelenggara,</p>
                            <br><br><br><br>
                            <p>NIP</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@push('general-css')
    <style>
        @media print {
            @page {
                margin: 0.75in 0.39in 0.75in 0.39in;
            }

            .header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background: white;
                z-index: 1000;
            }

            .footer {
                background: white;
                z-index: 1000;
                margin-top: 20px;
                /* Adjust this value if needed */
                padding-bottom: 30px;
                /* Ensure space for footer */
                page-break-after: always;
                /* Ensure footer appears at the bottom of each page */
            }

            .content {
                top: 0
            }

            .page-break {
                page-break-before: always;
                margin-top: 270px;
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        window.print()
    </script>
@endpush
