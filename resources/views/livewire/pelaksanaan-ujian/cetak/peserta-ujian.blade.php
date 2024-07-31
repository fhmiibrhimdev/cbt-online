<div>
    <section class="section custom-section">
        <div class="section-header">
            <a href="{{ url('pelaksanaan-ujian/cetak') }}" class="btn btn-muted">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Peserta Ujian</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body px-4 py-0">
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <select wire:model="id_jenises" id="id_jenises" class="form-control">
                                    <option value="">-- Pilih Jenis Ujian --</option>
                                    @foreach ($ujians as $ujian)
                                        <option value="{{ $ujian->id }}">{{ $ujian->nama_jenis }}
                                            ({{ $ujian->kode_jenis }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="tw-flex float-right">
                                <button wire:click.prevent="byMode('ruang')"
                                    class="mr-2 btn btn-lg @if ($byes == 'ruang') btn-primary @else btn-muted @endif">
                                    By Ruang
                                </button>
                                <button wire:click.prevent="byMode('kelas')"
                                    class="mr-2 btn btn-lg @if ($byes == 'kelas') btn-primary @else btn-muted @endif ">
                                    By Kelas
                                </button>
                                <a target="_BLANK"
                                    href="{{ url('pelaksanaan-ujian/cetak/peserta-ujian/' . $id_jenises . '/' . $byes) }}"
                                    class="btn btn-lg btn-info">
                                    <i class="fas fa-print"></i> Cetak
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body px-4">
                    @if ($byes == 'ruang')
                        @foreach ($data->groupBy('nama_ruang') as $row)
                            @foreach ($row->groupBy('nama_sesi') as $sesi)
                                <div
                                    class="tw-flex tw-justify-center tw-items-center tw-max-h-screen-md tw-p-10 tw-bg-gray-100 tw-rounded-md">
                                    <div
                                        class="tw-shadow tw-shadow-gray-300 tw-rounded-md tw-p-8 tw-max-w-screen-md tw-w-[210mm] tw-h-[297mm] tw-bg-white">
                                        <div
                                            class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-5">
                                            <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                                                alt="Logo Left" class="tw-h-20">
                                            <div class="tw-text-center px-1">
                                                <h1 class="tw-text-base tw-font-bold tw-text-gray-700">DAFTAR PESERTA
                                                </h1>
                                                <h2 class="tw-text-base tw-uppercase tw-font-bold tw-text-gray-700">
                                                    {{ $jenis_ujian ?? '...' }}</h2>
                                                <h4 class="tw-text-base tw-font-bold tw-text-gray-700">
                                                    {{ $header_3 }}
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
                                            </div>
                                        </div>
                                        <div class="tw-text-sm tw-pb-2">
                                            <div class="row tw-text-xs mt-2 mb-3">
                                                <div class="col-4">
                                                    <table>
                                                        <tr>
                                                            <td width="40%"
                                                                class="tw-text-[13px] tw-p-0 tw-border-none">
                                                                Ruang</td>
                                                            <td width="8%"
                                                                class="tw-text-[13px] tw-p-0 tw-border-none">
                                                                :
                                                            </td>
                                                            <td width="70%"
                                                                class="tw-text-[13px] tw-p-0 tw-border-none tw-font-semibold">
                                                                {{ $row[0]['nama_ruang'] ?? '...' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tw-text-[13px] tw-p-0 tw-border-none">Sesi</td>
                                                            <td class="tw-text-[13px] tw-p-0 tw-border-none">:</td>
                                                            <td
                                                                class="tw-text-[13px] tw-p-0 tw-border-none tw-font-semibold">
                                                                {{ $sesi[0]['nama_sesi'] ?? '...' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="tw-text-[13px] tw-p-0 tw-border-none">Waktu</td>
                                                            <td class="tw-text-[13px] tw-p-0 tw-border-none">:</td>
                                                            <td
                                                                class="tw-text-[13px] tw-p-0 tw-border-none tw-font-semibold">
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
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        No
                                                    </th>
                                                    <th width="23%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        No.
                                                        Peserta</th>
                                                    <th width="50%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        Nama Peserta</th>
                                                    <th width="12%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        Kelas</th>
                                                    <th width="13%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        Ruang</th>
                                                    <th width="13%"
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        Sesi
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sesi as $result)
                                                    <tr class="tw-text-center">
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                            {{ $loop->index + 1 }}
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                            {{ $result->nomor_peserta }}
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black tw-text-left tw-uppercase">
                                                            {{ $result->nama_siswa }}
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                            {{ $result->nama_kelas }}
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                            {{ $result->nama_ruang }}
                                                        </td>
                                                        <td
                                                            class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                            {{ $result->nama_sesi }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @else
                        @foreach ($data->groupBy('nama_kelas') as $row)
                            <div
                                class="tw-flex tw-justify-center tw-items-center tw-max-h-screen-md tw-p-10 tw-bg-gray-100 tw-rounded-md">
                                <div
                                    class="tw-shadow tw-shadow-gray-300 tw-rounded-md tw-p-8 tw-max-w-screen-md tw-w-[210mm] tw-h-[297mm] tw-bg-white">
                                    <div
                                        class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-5">
                                        <img src="http://localhost:8081/uploads/settings/logo_kiri.png" alt="Logo Left"
                                            class="tw-h-20">
                                        <div class="tw-text-center px-1">
                                            <h1 class="tw-text-base tw-font-bold tw-text-gray-700">DAFTAR PESERTA
                                            </h1>
                                            <h2 class="tw-text-base tw-uppercase tw-font-bold tw-text-gray-700">
                                                {{ $jenis_ujian ?? '...' }}</h2>
                                            <h4 class="tw-text-base tw-font-bold tw-text-gray-700">{{ $header_3 }}
                                            </h4>
                                            <h4 class="tw-text-xs">{{ $header_4 }}</h4>
                                        </div>
                                        <img src="http://localhost:8081/uploads/settings/logo_kanan.png"
                                            alt="Logo Right" class="tw-h-20">
                                    </div>
                                    <div class="tw-mt-5">
                                        <div class="tw-text-gray-700 tw-font-semibold text-center">
                                            <h1 class="tw-text-base">
                                                Tahun Pelajaran: {{ $tahun_pelajaran }}
                                            </h1>
                                        </div>
                                    </div>
                                    <div class="tw-text-sm tw-pb-2">
                                        <div class="row tw-text-xs mt-2 mb-3">
                                            <div class="col-4">
                                                <table>
                                                    <tr>
                                                        <td width="40%"
                                                            class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            Kelas</td>
                                                        <td width="8%"
                                                            class="tw-text-[13px] tw-p-0 tw-border-none">
                                                            :
                                                        </td>
                                                        <td width="70%"
                                                            class="tw-text-[13px] tw-p-0 tw-border-none tw-font-semibold">
                                                            {{ $row[0]['nama_kelas'] ?? '...' }}</td>
                                                    </tr>
                                                    @foreach ($sesis as $sesi)
                                                        <tr>
                                                            <td class="tw-text-[13px] tw-p-0 tw-border-none">
                                                                {{ $sesi->nama_sesi ?? '...' }}</td>
                                                            <td class="tw-text-[13px] tw-p-0 tw-border-none">:</td>
                                                            <td
                                                                class="tw-text-[13px] tw-p-0 tw-border-none tw-font-semibold">
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
                                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    No
                                                </th>
                                                <th width="23%"
                                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    No.
                                                    Peserta</th>
                                                <th width="50%"
                                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    Nama Peserta</th>
                                                <th width="12%"
                                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    Kelas</th>
                                                <th width="13%"
                                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    Ruang</th>
                                                <th width="13%"
                                                    class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                    Sesi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($row as $result)
                                                <tr class="tw-text-center">
                                                    <td
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        {{ $loop->index + 1 }}
                                                    </td>
                                                    <td
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        {{ $result->nomor_peserta }}
                                                    </td>
                                                    <td
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black tw-text-left tw-uppercase">
                                                        {{ $result->nama_siswa }}
                                                    </td>
                                                    <td
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        {{ $result->nama_kelas }}
                                                    </td>
                                                    <td
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        {{ $result->nama_ruang }}
                                                    </td>
                                                    <td
                                                        class="tw-tracking-normal tw-py-2 tw-px-3 tw-text-xs tw-bg-white tw-border tw-border-black">
                                                        {{ $result->nama_sesi }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
