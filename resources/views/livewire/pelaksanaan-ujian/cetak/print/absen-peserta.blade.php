<div>
    <div class="container">
        <div class="tw-flex tw-justify-center  tw-items-center">
            <div class="tw-rounded-md tw-bg-white">
                <div class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-5">
                    <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                        alt="Logo Left" class="tw-h-[104px]">
                    <div class="tw-text-center px-1">
                        <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900">{{ $header_1 }}
                        </h1>
                        <h2 class="tw-text-2xl tw-font-bold tw-text-gray-900">
                            {{ $header_2 }}</h2>
                        <h4 class="tw-text-2xl tw-font-bold tw-text-gray-900">{{ $header_3 }}
                        </h4>
                        <h4 class="tw-text-base tw-text-gray-600">{{ $header_4 }}</h4>
                    </div>
                    <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_sekolah')->logo_sekolah) }}"
                        alt="Logo Right" class="tw-h-[104px]">
                </div>
                <div class="tw-text-sm tw-pb-2 tw-mb-2">
                    <div class="row tw-text-xs my-4">
                        <div class="col-5">
                            <table>
                                <tr>
                                    <td width="40%" class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        Ruang</td>
                                    <td width="8%" class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        :
                                    </td>
                                    <td width="70%" class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        {{ $nama_ruang ?? '...' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">Sesi</td>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">:</td>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        {{ $nama_sesi ?? '...' }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">Waktu</td>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">:</td>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        {{ $waktu ?? '...' }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-7">
                            <table>
                                <tr>
                                    <td width="30%" class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        Hari/Tanggal</td>
                                    <td width="3%" class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        :
                                    </td>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        {{ $hari_tanggal ? \Carbon\Carbon::parse($hari_tanggal)->isoFormat('dddd, D MMMM Y') : '...' }}
                                </tr>
                                <tr>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">Mata Pelajaran
                                    </td>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">:</td>
                                    <td class="tw-text-lg tw-text-black tw-p-0 tw-border-none">
                                        {{ $nama_mapel ?? '...' }}
                                        {{-- Pendidikan Pancasila dan Kewarganegaraan --}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table class="tw-border tw-border-black" border="1">
                        <thead>
                            <tr class="tw-border tw-border-black tw-text-center">
                                <th width="7%"
                                    class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                    No
                                </th>
                                <th width="30%"
                                    class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                    No.
                                    Peserta</th>
                                <th width="45%"
                                    class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                    Nama</th>
                                <th width="12%"
                                    class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                    Kelas</th>
                                <th colspan="2" width="25%"
                                    class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                    Tanda Tangan</th>
                                <th width="15%"
                                    class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                    Ket
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @php
                                $x = 105;
                            @endphp --}}
                            @foreach ($data->groupBy('id_siswa') as $row)
                                {{-- @for ($i = 0; $i < $x; $i++) --}}
                                <tr class="tw-text-center">
                                    <td
                                        class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                        {{ $row[0]['nomor_peserta'] }}
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black tw-text-left">
                                        {{ strtoupper($row[0]['nama_siswa']) }}</td>
                                    <td
                                        class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                        {{ $row[0]['nama_kelas'] }}</td>
                                    <td
                                        class="tw-tracking-normal tw-text-black tw-py-2 tw-px-2 tw-text-base tw-bg-white tw-border tw-border-black tw-text-left">
                                        @if ($loop->index % 2 == 0)
                                            {{ $loop->index + 1 }}.
                                        @endif
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-text-black tw-py-2 tw-px-2 tw-text-base tw-bg-white tw-border tw-border-black tw-text-left">
                                        @if ($loop->index % 2 == 1)
                                            {{ $loop->index + 1 }}.
                                        @endif
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-text-black tw-py-2 tw-px-3 tw-text-base tw-bg-white tw-border tw-border-black">
                                    </td>
                                </tr>
                                {{-- @endfor --}}
                            @endforeach
                        </tbody>
                    </table>
                    @php
                        $classString = 'row';
                        // $j = $x;
                        $j = (int) count($data->groupBy('id_siswa'));

                        if ($j <= 18) {
                            $classString .= ' tw-mt-10';
                        } elseif ($j >= 19 && $j <= 27) {
                            $classString .= ' print:tw-mt-[360px] tw-mt-10';
                        } elseif ($j >= 28 && $j <= 51) {
                            $classString .= ' tw-mt-10';
                        } elseif ($j >= 52 && $j <= 61) {
                            $classString .= ' print:tw-mt-[360px] tw-mt-10';
                        } elseif ($j >= 62 && $j <= 85) {
                            $classString .= ' tw-mt-10';
                        } elseif ($j >= 86 && $j <= 95) {
                            $classString .= ' print:tw-mt-[360px] tw-mt-10';
                        } else {
                            $classString .= ' tw-mt-10';
                        }
                    @endphp
                    <div class="{{ $classString }}">
                        <div class="col-6">
                            <table>
                                <tr>
                                    <td width="150%"
                                        class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border tw-border-l tw-border-t tw-border-b-0 tw-border-r-0 tw-border-black">
                                        Jumlah
                                        peserta yang seharusnya hadir</td>
                                    <td class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border-t tw-border-b-0 tw-border-black"
                                        width="5%">:</td>
                                    <td class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border tw-border-r tw-border-t tw-border-b-0 tw-border-l-0 tw-border-black"
                                        width="50%">____ orang</td>
                                </tr>
                                <tr>
                                    <td width="150%"
                                        class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border tw-border-l tw-border-t-0 tw-border-b-0 tw-border-r-0 tw-border-black">
                                        Jumlah
                                        peserta yang tidak hadir</td>
                                    <td class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border-t-0 tw-border-b-0 tw-border-black"
                                        width="5%">:</td>
                                    <td class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border tw-border-r tw-border-t-0 tw-border-b-0 tw-border-l-0 tw-border-black"
                                        width="50%">____ orang</td>
                                </tr>
                                <tr>
                                    <td width="150%"
                                        class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border tw-border-l tw-border-t-0 tw-border-b tw-border-r-0 tw-border-black">
                                        Jumlah
                                        peserta yang hadir</td>
                                    <td class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border-t-0 tw-border-b tw-border-black"
                                        width="5%">:</td>
                                    <td class="tw-text-base tw-text-black tw-px-2 tw-py-1 tw-border tw-border-r tw-border-t-0 tw-border-b tw-border-l-0 tw-border-black"
                                        width="50%">____ orang</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row tw-text-center tw-my-10">
                        <div class="col-6 tw-font-semibold tw-text-lg tw-text-black">
                            <p class="tw-mb-20">PENGAWAS I</p>
                            <p>( .......................................... )</p>
                            <p class="tw-text-lg tw-text-gray-700">NIP .......................................</p>
                        </div>
                        <div class="col-6 tw-font-semibold tw-text-lg tw-text-black">
                            <p class="tw-mb-20">PENGAWAS II</p>
                            <p>( .......................................... )</p>
                            <p class="tw-text-lg tw-text-gray-700">NIP .......................................</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@push('general-css')
    <style>
        @media print {
            @page {
                margin: 0.75in 0.39in 0.75in 0.39in;
                /* Atur margin: atas-bawah 0.75 inci, kiri-kanan 0.39 inci */
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        window.print()
    </script>
@endpush
