<div>
    <section class="section custom-section">
        <div class="section-header tw-block">
            <div class="tw-flex">
                <a href="{{ url('pelaksanaan-ujian/hasil-ujian') }}" class="btn btn-muted">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h1 class="tw-text-lg">Koreksi Hasil Siswa</h1>
                @if ($detail->dikoreksi != null)
                    <button class="btn btn-primary ml-auto tw-tracking-wider"
                        wire:click.prevent="sudahDikoreksi('{{ $id_jadwal }}')"><i class="fas fa-check"></i> Tandai
                        Sudah
                        Dikoreksi</button>
                @endif
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body px-4">
                    <div class="row">
                        <div class="col-lg-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="35%" class="tw-border tw-border-gray-200">Nama</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->nama_siswa }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-tracking-wider tw-border tw-border-gray-200">NIS/NISN</td>
                                        <td class="tw-tracking-wider tw-border tw-border-gray-200">
                                            {{ $detail->nis }}/{{ $detail->nisn }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">Kelas</td>
                                        <td class="tw-border tw-border-gray-200">
                                            {{ $detail->level }}-{{ $detail->kode_kelas }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">No. Peserta</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->nomor_peserta }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">Sesi</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->kode_sesi }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="45%" class="tw-border tw-border-gray-200">Ruang</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->kode_ruang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">Mata Pelajaran</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->kode_mapel }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">Guru</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->nama_guru }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">Jenis Ujian</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->kode_jenis }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">Tahun Pelajaran</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->tahun }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="25%" class="tw-border tw-border-gray-200">PG</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->nilai_pg }}</td>
                                        <td class="tw-border tw-tracking-wider tw-border-gray-200 tw-align-top text-center tw-font-semibold"
                                            rowspan="3">
                                            <span>NILAI</span> <br><br>
                                            <span class="tw-text-3xl">
                                                {{ (float) $detail->nilai_pg + (float) $detail->nilai_pk + (float) $detail->nilai_jo + (float) $detail->nilai_is + (float) $detail->nilai_es }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">PK</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->nilai_pk }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">JO</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->nilai_jo }}</td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">IS</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->nilai_is }}</td>
                                        <td class="tw-border tw-tracking-wider tw-border-gray-200 text-center tw-font-semibold"
                                            rowspan="2">
                                            @if ($detail->dikoreksi == null)
                                                <span class="tw-text-red-700"><i class="fas fa-times mr-2"></i>Tidak ada
                                                    soal</span>
                                            @elseif ($detail->dikoreksi == '0')
                                                <span class="tw-text-red-700"><i class="fas fa-times mr-2"></i>Belum
                                                    dikoreksi</span>
                                            @else
                                                <span class="tw-text-green-700"><i class="fas fa-check mr-2"></i>Sudah
                                                    dikoreksi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="tw-border tw-border-gray-200">ES</td>
                                        <td class="tw-border tw-border-gray-200">{{ $detail->nilai_es }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @php
                // Mendefinisikan nama jenis soal
                $jenisSoalNames = [
                    1 => 'Pilihan Ganda',
                    2 => 'Pilihan Ganda Kompleks',
                    3 => 'Menjodohkan',
                    4 => 'Isian Singkat',
                    5 => 'Essay / Uraian',
                ];

                // Kelompokkan data berdasarkan jenis_soal
                $groupedSoals = $soals->groupBy('jenis_soal');
            @endphp

            @foreach ($groupedSoals as $jenisSoal => $soalsGroup)
                @php
                    // Pisahkan soal berdasarkan kondisi jawaban
                    $correctAnswers = $soalsGroup->filter(function ($item) {
                        return $item->jawaban_alias === $item->jawaban_siswa;
                    });

                    $incorrectAnswers = $soalsGroup->filter(function ($item) {
                        return $item->jawaban_alias !== $item->jawaban_siswa;
                    });

                    // Hitung total skor untuk jawaban yang benar
                    $correctScore = $correctAnswers->sum(function ($item) {
                        // Jika nilai koreksi lebih besar dari 0, gunakan nilai koreksi
                        // Jika tidak, gunakan point_soal
                        return $item->nilai_koreksi > 0 ? $item->nilai_koreksi : $item->point_soal;
                    });

                    // Hitung total skor untuk jawaban yang salah (jika diperlukan)
                    $incorrectScore = $incorrectAnswers->sum(function ($item) {
                        // Misalnya, jika jawaban salah, skor bisa menjadi 0 atau nilai tertentu
                        // Atur logika sesuai kebutuhan Anda. Di sini, saya anggap 0 untuk jawaban salah
                        return $item->nilai_koreksi;
                    });

                    // Total skor adalah skor jawaban benar dan salah (jika ada pertimbangan khusus untuk jawaban salah)
                    $totalScore = $correctScore + $incorrectScore;
                @endphp
                <div class="card">
                    <div class="card-header">
                        <h4 class="tw-font-semibold">{{ $jenisSoalNames[$jenisSoal] }}</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse-{{ $jenisSoal }}" class="btn btn-icon btn-info"
                                href="#"><i class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse-{{ $jenisSoal }}">
                        <div class="card-body px-0 py-0">
                            <div class="tw-overflow-x-auto no-scrollbar">
                                <table class="tw-w-full tw-min-w-full tw-table-auto">
                                    <thead>
                                        <tr class="text-center ">
                                            <th>No</th>
                                            <th>Soal</th>
                                            @if ($jenisSoal == '1' || $jenisSoal == '2')
                                                <th>Pilihan</th>
                                            @endif
                                            <th class="tw-whitespace-nowrap">JWB Benar</th>
                                            <th class="tw-whitespace-nowrap">JWB Siswa</th>
                                            <th>Analisa</th>
                                            <th class="tw-whitespace-nowrap">Point Max. 10</th>
                                            @if ($jenisSoal != '1')
                                                <th><i class="fas fa-cogs"></i></th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $countTotalScore = 6;

                                            $jenisSoal == '2' ? ($countTotalScore = 7) : ($countTotalScore = 6);

                                        @endphp
                                        @foreach ($soalsGroup as $soal)
                                            <tr class="tw-align-top">
                                                <td class="text-center tw-py-4">{{ $soal->no_soal_alias }}.</td>
                                                <td class="tw-py-3 tw-w-1/3">
                                                    <p>{!! $soal->soal !!}</p>
                                                </td>
                                                @if ($jenisSoal == '1')
                                                    <td class="tw-whitespace-nowrap tw-py-3">
                                                        @php
                                                            // Definisikan label dan opsi dalam array
                                                            $optionLabels = [
                                                                'A' => $soal->opsi_alias_a,
                                                                'B' => $soal->opsi_alias_b,
                                                                'C' => $soal->opsi_alias_c,
                                                                'D' => $soal->opsi_alias_d,
                                                                'E' => $soal->opsi_alias_e,
                                                            ];

                                                            // Ambil jumlah opsi yang ingin ditampilkan
                                                            $optionCount = intval($detail->opsi);

                                                            // Ambil opsi yang sesuai dengan jumlah yang diinginkan
                                                            $optionsToShow = array_slice(
                                                                $optionLabels,
                                                                0,
                                                                $optionCount,
                                                                true,
                                                            );
                                                        @endphp
                                                        @if (!empty($optionsToShow))
                                                            <ul>
                                                                @foreach ($optionsToShow as $label => $option)
                                                                    <li class="tw-flex">{{ $label }}. &nbsp;
                                                                        {!! $option !!}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </td>
                                                @elseif ($jenisSoal == '2')
                                                    <td class="tw-whitespace-nowrap tw-py-3">
                                                        <ul>
                                                            @foreach (json_decode($soal->opsi_a) as $key => $opsi_kompleks)
                                                                <li class="tw-flex">{{ $key }}. &nbsp;
                                                                    {!! $opsi_kompleks !!}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                @endif
                                                @if ($jenisSoal == '1')
                                                    <td class="text-center tw-py-3">
                                                        {!! $soal->jawaban_alias !!}</td>
                                                    <td class="text-center tw-py-3">
                                                        {!! $soal->jawaban_siswa !!}</td>
                                                @elseif ($jenisSoal == '2')
                                                    <td class="text-center tw-py-3">
                                                        {{ implode(', ', json_decode($soal->jawaban_alias, true)) }}
                                                    </td>
                                                    <td class="text-center tw-py-3">
                                                        {{ implode(', ', json_decode($soal->jawaban_siswa, true)) }}
                                                    </td>
                                                @elseif ($jenisSoal == '3')
                                                    <td class="tw-w-1/3">
                                                        @php
                                                            // Decode JSON
                                                            $jawabanAlias = json_decode($soal->jawaban_alias, true);
                                                            $jawabanSiswa = json_decode($soal->jawaban_siswa, true);

                                                            // Ambil deskripsi dari header jawaban alias
                                                            $descriptionsAlias = $jawabanAlias['jawaban'][0];

                                                            // Menyusun data dalam format yang diinginkan untuk jawaban alias
                                                            $itemsAlias = [];
                                                            foreach ($jawabanAlias['jawaban'] as $index => $row) {
                                                                if ($index > 0) {
                                                                    // Skip header row
                                                                    // Temukan posisi angka '1' dalam baris ini
                                                                    $position = array_search('1', $row);

                                                                    if ($position !== false) {
                                                                        $itemsAlias[] = [
                                                                            'name' => $row[0],
                                                                            'description' =>
                                                                                $descriptionsAlias[$position],
                                                                        ];
                                                                    }
                                                                }
                                                            }

                                                            // Ambil deskripsi dari header jawaban siswa
                                                            $descriptionsSiswa = $jawabanSiswa['jawaban'][0];

                                                            // Menyusun data dalam format yang diinginkan untuk jawaban siswa
                                                            $itemsSiswa = [];
                                                            foreach ($jawabanSiswa['jawaban'] as $index => $row) {
                                                                if ($index > 0) {
                                                                    // Skip header row
                                                                    // Temukan posisi angka '1' dalam baris ini
                                                                    $position = array_search('1', $row);

                                                                    if ($position !== false) {
                                                                        $itemsSiswa[] = [
                                                                            'name' => $row[0],
                                                                            'description' =>
                                                                                $descriptionsSiswa[$position],
                                                                        ];
                                                                    }
                                                                }
                                                            }
                                                        @endphp
                                                        @foreach ($itemsAlias as $item)
                                                            {!! $item['name'] !!} <span>--</span>
                                                            {!! $item['description'] !!} <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="tw-w-1/3">
                                                        @foreach ($itemsSiswa as $item)
                                                            {!! $item['name'] !!} <span>--</span>
                                                            {!! $item['description'] !!} <br>
                                                        @endforeach
                                                    </td>
                                                @elseif ($jenisSoal == '5')
                                                    <td class="text-left tw-w-1/2">
                                                        {!! $soal->jawaban_alias !!}</td>
                                                    <td class="text-left tw-w-1/2">
                                                        {!! $soal->jawaban_siswa !!}</td>
                                                @else
                                                    <td class="text-left tw-py-3">
                                                        {!! $soal->jawaban_alias !!}</td>
                                                    <td class="text-left tw-py-3">
                                                        {!! $soal->jawaban_siswa !!}</td>
                                                @endif
                                                <td class="text-center tw-py-3">
                                                    @if ($soal->jawaban_siswa === $soal->jawaban_alias)
                                                        <i class="fas fa-badge-check text-success tw-text-lg"></i>
                                                    @else
                                                        <i class="fas fa-times text-danger tw-text-lg"></i>
                                                    @endif
                                                </td>
                                                <td class="text-center tw-py-3">
                                                    @if ($soal->jawaban_siswa === $soal->jawaban_alias)
                                                        <center>
                                                            <input type="number"
                                                                class="tw-w-[50px] form-control tw-text-center"
                                                                value="{{ (int) $soal->point_soal }}"
                                                                id="input{{ $soal->id }}" style="display: none;"
                                                                data-point="{{ $soal->point_soal }}"
                                                                wire:model="point.{{ $soal->id }}">
                                                        </center>
                                                        <span data-idsoal="{{ $soal->id }}"
                                                            id="span{{ $soal->id }}" wire:ignore>
                                                            @if ($soal->nilai_koreksi != 0)
                                                                <i
                                                                    class="fas fa-exclamation-triangle text-warning"></i>
                                                                {{ $soal->nilai_koreksi }}
                                                            @else
                                                                {{ $soal->point_soal }}
                                                            @endif
                                                        </span>
                                                    @else
                                                        <center>
                                                            <input type="number"
                                                                class="tw-w-[50px] form-control tw-text-center"
                                                                value="{{ $soal->nilai_koreksi }}"
                                                                id="input{{ $soal->id }}" style="display: none;"
                                                                data-point="{{ $soal->point_soal }}"
                                                                wire:model="point.{{ $soal->id }}">
                                                        </center>
                                                        <span data-idsoal="{{ $soal->id }}"
                                                            id="span{{ $soal->id }}" wire:ignore> <i
                                                                class="fas fa-exclamation-triangle text-warning"></i>
                                                            {{ $soal->nilai_koreksi }}</span>
                                                    @endif
                                                </td>
                                                @if ($jenisSoal != '1')
                                                    @if ($soal->jawaban_siswa !== $soal->jawaban_alias)
                                                        <td class="tw-py-3">
                                                            <div class="tw-flex tw-justify-center">
                                                                <button id="edit{{ $soal->id }}"
                                                                    onclick="edit({{ $soal->id }})"
                                                                    class="btn btn-sm btn-primary mr-3"><i
                                                                        class="fas fa-edit"></i></button>
                                                            </div>
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <thead>
                                        <tr>
                                            <th class="text-right" colspan="{{ $countTotalScore }}">TOTAL SCORE
                                                {{ $jenisSoalNames[$jenisSoal] }}</th>
                                            <th class="text-right">
                                                {{ $totalScore }}
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>
</div>

@push('general-css')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function edit(id) {
            var input = $(`#input${id}`);
            var span = $(`#span${id}`);
            var btnedit = $(`#edit${id}`);

            if (input.is(":visible")) {
                let val = input.val();
                let point_soal = input.data('point');
                if (parseFloat(val) < 0) {
                    Swal.fire({
                        title: 'Perhatian!',
                        text: 'Nilai tidak boleh minus!',
                        icon: 'warning',
                        confirmButtonText: 'Okay',
                    })
                } else {
                    if (parseFloat(val) > parseFloat(point_soal)) {
                        Swal.fire({
                            title: 'Perhatian!',
                            text: 'Nilai yang anda inputkan melebihi batas point max, point max: ' + parseFloat(
                                point_soal),
                            icon: 'warning',
                            confirmButtonText: 'Okay',
                        })
                    } else {
                        Livewire.dispatch('updatePoint')
                        input.hide();
                        span.text(input.val()).show();
                        console.log(input.val())
                        btnedit.html(`<i class="fa fa-pencil"></i>`);
                    }

                }
            } else {
                span.hide();
                input.val(span.text()).show();
                btnedit.html(`<i class="fa fa-check"></i>`);
            }
        }
        $(document).ready(function() {});
    </script>
@endpush
