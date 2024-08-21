<div>
    <section class="section custom-section">
        <div class="section-header">
            <a href="{{ url('pelaksanaan-ujian/rekap-nilai') }}" class="btn btn-muted tw-ml-[-10px]">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Rekap Nilai Detail</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Ekspor Hasil Siswa</h3>
                <div class="card-body">
                    <div class="row tw-mb-5">
                        <div class="col-lg-8">
                            <div class="form-group pl-4">
                                <select wire:model="id_kelas" id="id_kelas" class="form-control">
                                    <option value="" disabled>-- Pilih Kelas --</option>
                                    @foreach ($kelas as $level => $kelasGroup)
                                        <optgroup label="{{ $level }}">
                                            @foreach ($kelasGroup as $kelasItem)
                                                <option value="{{ $kelasItem->id }}">
                                                    {{ $level }}-{{ $kelasItem->kode_kelas }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="float-right mr-4">
                                <button wire:click.prevent="tampil({{ $tampilkan ? '0' : '1' }})"
                                    class="btn btn-primary"><i class="fas fa-list"></i> Tampil
                                    Detail</button>
                                <button class="btn btn-success tw-bg-green-500"><i class="fas fa-file-excel"></i>
                                    Ekspor
                                    Excel</button>
                            </div>
                        </div>
                    </div>
                    @if (!$this->id_kelas == '')
                        <table>
                            <tr>
                                <td width="15%">Soal</td>
                                <td width="30%">{{ $data->kode_bank }}
                                </td>
                                <td width="30%">Mata Pelajaran</td>
                                <td width="50%">{{ $data->nama_mapel }}
                                </td>
                            </tr>
                            <tr>
                                <td>Jenis Penilaian</td>
                                <td>{{ $data->kode_jenis }}</td>
                                <td>Guru Pengampu</td>
                                <td>{{ $data->nama_guru }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>{{ $nama_kelas }}</td>
                                <td>Waktu Pelaksanaan</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($data->tgl_mulai)->isoFormat('D MMMM Y') }}
                                    s/d
                                    {{ \Carbon\Carbon::parse($data->tgl_selesai)->isoFormat('D MMMM Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td>Jumlah Soal</td>
                                <td>5</td>
                                <td>Tahun Pelajaran / Semester</td>
                                <td>{{ $data->tahun }}
                                    {{ $data->semester }}
                                    {{ $data->nama_semester }}</td>
                            </tr>
                        </table>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body py-0">
                    <div class="tw-overflow-x-auto">
                        @php
                            $dataGroupedBySiswa = [];
                            foreach ($detail as $item) {
                                $dataGroupedBySiswa[$item['id_siswa']][] = $item;
                            }
                            $soalCount = null;
                            foreach ($dataGroupedBySiswa as $items) {
                                foreach ($items as $item) {
                                    if ($item['jml_pg'] !== null) {
                                        $soalCount = $item['jml_pg'];
                                        break 2;
                                    }
                                }
                            }
                        @endphp
                        <pre>@json($dataGroupedBySiswa, JSON_PRETTY_PRINT)</pre>
                        <table class="tw-w-full tw-min-w-full tw-table-auto">
                            <thead>
                                <tr class="text-center">
                                    <th width="8%" rowspan="2">No</th>
                                    <th width="13%" rowspan="2">No Peserta</th>
                                    <th width="23%" rowspan="2">Nama Siswa</th>
                                    @if ($tampilkan)
                                        <th width="23%" colspan="{{ $soalCount }}">Nomor Soal</th>
                                    @endif
                                    <th class="tw-whitespace-nowrap" rowspan="2">PG Benar</th>
                                    <th width="10%" colspan="1">SKOR</th>
                                    <th width="10%" rowspan="2">Nilai</th>
                                </tr>
                                <tr class="tw-text-center">
                                    @if ($tampilkan)
                                        @if ($soalCount == 0)
                                            <th></th>
                                        @else
                                            @for ($i = 1; $i <= $soalCount; $i++)
                                                <th width="10%">{{ $i }}</th>
                                            @endfor
                                        @endif
                                    @endif
                                    <th>PG</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataGroupedBySiswa as $siswaData)
                                    @php
                                        $pgBenar = 0;
                                    @endphp
                                    <tr class="tw-text-center">
                                        <td class="tw-py-3">{{ $loop->iteration }}</td>
                                        <td class="tw-py-3 tw-whitespace-nowrap">{{ $siswaData[0]['nomor_peserta'] }}
                                        </td>
                                        <td class="tw-py-3 tw-whitespace-nowrap tw-uppercase tw-text-left">
                                            {{ $siswaData[0]['nama_siswa'] }}</td>
                                        @for ($i = 1; $i <= $soalCount; $i++)
                                            @php
                                                $soalItem = collect($siswaData)->firstWhere('no_soal_alias', $i);
                                                $jawabanBenar = $soalItem['jawaban_alias'] ?? null;
                                                $jawabanSiswa = $soalItem['jawaban_siswa'] ?? null;
                                                if ($jawabanSiswa == null && $jawabanBenar == null) {
                                                    $pgBenar = 0;
                                                } elseif ($jawabanSiswa === $jawabanBenar) {
                                                    $pgBenar++;
                                                }
                                            @endphp
                                            {{-- <pre>@json($soalItem, JSON_PRETTY_PRINT)</pre> --}}
                                            @if ($tampilkan)
                                                <td>
                                                    @if ($jawabanSiswa == null && $jawabanBenar == null)
                                                    @elseif ($jawabanSiswa === $jawabanBenar)
                                                        <i class="fas fa-check text-success"
                                                            title="{{ $soalItem['jawaban_siswa'] ?? '' }}"></i>
                                                    @elseif ($jawabanSiswa == '')

                                                    @elseif ($jawabanSiswa !== $jawabanBenar)
                                                        <i class="fas fa-times text-danger"
                                                            title="{{ $soalItem['jawaban_siswa'] ?? '' }}"></i>
                                                    @endif
                                                </td>
                                            @endif
                                        @endfor
                                        <td class="tw-py-3">{{ $pgBenar }}</td>
                                        <td class="tw-py-3 tw-text-green-700 tw-font-bold">
                                            {{ (float) $pgBenar * (float) $siswaData[0]['point_soal'] }}</td>
                                        <td class="tw-py-3">
                                            {{ (float) $pgBenar * (float) $siswaData[0]['point_soal'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                $('#id_kelas').select2();

                $('#id_kelas').on('change', function(e) {
                    var data = $('#id_kelas').select2("val");
                    @this.set('id_kelas', data);
                });
            });
        })
    </script>
@endpush
