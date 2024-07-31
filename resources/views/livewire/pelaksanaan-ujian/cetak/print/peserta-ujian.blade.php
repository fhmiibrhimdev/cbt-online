<div>
    @if ($by == 'ruang')
        <div class="container header">
            <div class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-5">
                <img src="http://localhost:8081/uploads/settings/logo_kiri.png" alt="Logo Left" class="tw-h-[104px]">
                <div class="tw-text-center px-1">
                    <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900">DAFTAR PESERTA
                    </h1>
                    <h2 class="tw-text-2xl tw-uppercase tw-font-bold tw-text-gray-900">
                        {{ $jenis_ujian ?? '...' }}</h2>
                    <h4 class="tw-text-2xl tw-font-bold tw-text-gray-900">
                        {{ $header_3 }}
                    </h4>
                    <h4 class="tw-text-base tw-text-gray-600">{{ $header_4 }}</h4>
                </div>
                <img src="http://localhost:8081/uploads/settings/logo_kanan.png" alt="Logo Right" class="tw-h-[104px]">
            </div>
            <div class="tw-mt-5">
                <div class="tw-text-gray-900 tw-font-bold tw-mt-10 text-center">
                    <h1 class="tw-text-2xl tw tw-uppercase">
                        Tahun Pelajaran: {{ $tahun_pelajaran }}
                    </h1>
                </div>
            </div>
        </div>
        <div class="container content">
            @foreach ($data->groupBy('nama_ruang') as $row)
                @foreach ($row->groupBy('nama_sesi') as $sesi)
                    <div class="mt-5">
                        <div class="tw-pb-2">
                            <div class="row mt-2 mb-3 page-break">
                                <div class="col-4">
                                    <table>
                                        <tr>
                                            <td width="40%"
                                                class="tw-text-xl tw-text-gray-900 tw-font-bold tw-p-0 tw-border-none">
                                                Ruang</td>
                                            <td width="8%"
                                                class="tw-text-xl tw-text-gray-900 tw-font-bold tw-p-0 tw-border-none">
                                                :
                                            </td>
                                            <td width="70%"
                                                class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none tw-font-semibold">
                                                {{ $row[0]['nama_ruang'] ?? '...' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="tw-text-xl tw-text-gray-900 tw-font-bold tw-p-0 tw-border-none">
                                                Sesi</td>
                                            <td class="tw-text-xl tw-text-gray-900 tw-font-bold tw-p-0 tw-border-none">:
                                            </td>
                                            <td
                                                class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none tw-font-semibold">
                                                {{ $sesi[0]['nama_sesi'] ?? '...' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="tw-text-xl tw-text-gray-900 tw-font-bold tw-p-0 tw-border-none">
                                                Waktu</td>
                                            <td class="tw-text-xl tw-text-gray-900 tw-font-bold tw-p-0 tw-border-none">:
                                            </td>
                                            <td
                                                class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none tw-font-semibold">
                                                {{ $row[0]['waktu_mulai'] ?? '...' }} s/d
                                                {{ $row[0]['waktu_akhir'] ?? '...' }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <table class="tw-border tw-border-black">
                            <thead>
                                <tr class="tw-border tw-border-black tw-text-center">
                                    <th width="8%"
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                        No
                                    </th>
                                    <th width="23%"
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                        No.
                                        Peserta</th>
                                    <th width="50%"
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                        Nama Peserta</th>
                                    <th width="12%"
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                        Kelas</th>
                                    <th width="13%"
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                        Ruang</th>
                                    <th width="13%"
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                        Sesi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sesi as $result)
                                    <tr class="tw-text-center">
                                        <td
                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td
                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                            {{ $result->nomor_peserta }}
                                        </td>
                                        <td
                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black tw-text-left tw-uppercase">
                                            {{ $result->nama_siswa }}
                                        </td>
                                        <td
                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                            {{ $result->nama_kelas }}
                                        </td>
                                        <td
                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                            {{ $result->nama_ruang }}
                                        </td>
                                        <td
                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-gray-900 tw-text-lg tw-bg-white tw-border tw-border-black">
                                            {{ $result->nama_sesi }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endforeach
        </div>
    @else
        <div class="container header">
            <div class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-5">
                <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                    alt="Logo Left" class="tw-h-[104px]">
                <div class="tw-text-center px-1">
                    <h1 class="tw-text-2xl tw-font-bold tw-text-gray-900">DAFTAR PESERTA
                    </h1>
                    <h2 class="tw-text-2xl tw-uppercase tw-font-bold tw-text-gray-900">
                        {{ $jenis_ujian ?? '...' }}</h2>
                    <h4 class="tw-text-2xl tw-font-bold tw-text-gray-900">
                        {{ $header_3 }}
                    </h4>
                    <h4 class="tw-text-base tw-text-gray-600">{{ $header_4 }}</h4>
                </div>
                <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_sekolah')->logo_sekolah) }}"
                    alt="Logo Right" class="tw-h-[104px]">
            </div>
            <div class="tw-mt-5">
                <div class="tw-text-gray-900 tw-font-bold tw-mt-10 text-center">
                    <h1 class="tw-text-2xl tw tw-uppercase">
                        Tahun Pelajaran: {{ $tahun_pelajaran }}
                    </h1>
                </div>
            </div>
        </div>
        <div class="container content">
            @foreach ($data->groupBy('nama_kelas') as $row)
                <div class="mt-5">
                    <div class="tw-pb-2">
                        <div class="row mt-2 mb-3 page-break">
                            <div class="col-4">
                                <table>
                                    <tr>
                                        <td width="40%" class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none">
                                            Kelas</td>
                                        <td width="8%" class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none">
                                            :
                                        </td>
                                        <td width="70%"
                                            class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none tw-font-semibold">
                                            {{ $row[0]['nama_kelas'] ?? '...' }}</td>
                                    </tr>
                                    @foreach ($sesis as $sesi)
                                        <tr>
                                            <td class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none">
                                                {{ $sesi->nama_sesi ?? '...' }}</td>
                                            <td class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none">:</td>
                                            <td
                                                class="tw-text-xl tw-text-gray-900 tw-p-0 tw-border-none tw-font-semibold">
                                                {{ $sesi->waktu_mulai ?? '...' }} s/d
                                                {{ $sesi->waktu_akhir ?? '...' }}
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <table class="tw-border tw-border-black">
                        <thead>
                            <tr class="tw-border tw-border-black tw-text-center">
                                <th width="8%"
                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                    No
                                </th>
                                <th width="23%"
                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                    No.
                                    Peserta</th>
                                <th width="50%"
                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                    Nama Peserta</th>
                                <th width="12%"
                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                    Kelas</th>
                                <th width="13%"
                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                    Ruang</th>
                                <th width="13%"
                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                    Sesi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($row as $result)
                                <tr class="tw-text-center">
                                    <td
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                        {{ $result->nomor_peserta }}
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black tw-text-left tw-uppercase">
                                        {{ $result->nama_siswa }}
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                        {{ $result->nama_kelas }}
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                        {{ $result->nama_ruang }}
                                    </td>
                                    <td
                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-lg tw-text-gray-900 tw-bg-white tw-border tw-border-black">
                                        {{ $result->nama_sesi }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endif
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
                padding-bottom: 40px
            }

            .content {
                /* margin-top: 500px; */
            }

            .page-break {
                page-break-before: always;
                padding-top: 205px;

            }

            table {
                border-collapse: unset;
            }
        }
    </style>
@endpush
@push('scripts')
    <script>
        window.print()
    </script>
@endpush
