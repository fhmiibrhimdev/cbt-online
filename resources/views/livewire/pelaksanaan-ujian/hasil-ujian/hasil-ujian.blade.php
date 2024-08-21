<div>
    <section class="section custom-section">
        <div class="section-header tw-block">
            <div class="tw-flex">
                <h1 class="tw-text-lg">Hasil Ujian</h1>
                @if ($jadwals !== '')
                    <div class="ml-auto">

                        <button wire:click.prevent="refresh()" class="btn btn-info ml-auto tw-tracking-wider mr-2"><i
                                class="fas fa-sync mr-1"></i>
                            Refresh</button>
                        <button class="btn btn-primary ml-auto tw-tracking-wider" data-toggle="modal"
                            data-backdrop="static" data-keyboard="false" data-target="#formDataModal"><i
                                class="fas fa-info-circle mr-1"></i>
                            Detail</button>
                    </div>
                @endif
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body px-4 py-0">
                            <div class="row mt-3">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="id_kelas">Kelas</label>
                                        <select wire.model="id_kelas" id="id_kelas" class="form-control">
                                            <option value="0" {{ $id_kelas == '0' ? 'selected' : '' }} disabled>--
                                                Pilih Kelas --</option>
                                            @foreach ($kelases as $level => $kelasGroup)
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
                                    <div class="form-group">
                                        <label for="id_jadwal">Jadwal</label>
                                        <select wire.model="id_jadwal" id="id_jadwal" class="form-control">
                                            <option value="0" {{ $id_jadwal == '0' ? 'selected' : '' }} disabled>--
                                                Pilih Jadwal --</option>
                                            @foreach ($jadwales as $jadwal)
                                                <option value="{{ $jadwal->id }}">{{ $jadwal->kode_bank }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="tw-flex tw-mt-7">
                                        <button wire:click.prevent="inputNilai()"
                                            class="btn btn-primary tw-text-xs form-control mr-4 {{ $id_kelas == '0' || $id_jadwal == '0' ? 'disabled' : '' }}"
                                            data-toggle="modal" data-backdrop="static" data-keyboard="false"
                                            data-target="#inputDataModal">
                                            <i class="fas fa-edit"></i> Input Nilai
                                        </button>
                                        <button wire:click.prevent="tandaiSemua()"
                                            class="btn btn-success tw-text-xs form-control {{ $id_kelas == '0' || $id_jadwal == '0' ? 'disabled' : '' }}">
                                            <i class="fas fa-check"></i> Tandai Semua
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body py-0">
                    <div class="tw-overflow-x-auto no-scrollbar">
                        <table class="tw-w-full tw-min-w-full tw-table-auto">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">No. Peserta</th>
                                    <th rowspan="2">Nama Siswa</th>
                                    <th rowspan="2">Ruang</th>
                                    <th rowspan="2">Sesi</th>
                                    <th rowspan="2">Mulai</th>
                                    <th rowspan="2">Durasi</th>
                                    <th colspan="2">PG</th>
                                    <th colspan="5">Skor</th>
                                    <th rowspan="2">Nilai</th>
                                    <th rowspan="2"><i class="fas fa-cogs"></i></th>
                                </tr>
                                <tr class="text-center">
                                    <th>B</th>
                                    <th>S</th>
                                    <th>PG</th>
                                    <th>PK</th>
                                    <th>JO</th>
                                    <th>IS</th>
                                    <th>ES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hasil_ujian as $row)
                                    <tr class="text-center tw-whitespace-nowrap">
                                        <td class="tw-py-3">{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->nomor_peserta }}</td>
                                        <td class="text-left">{{ $row->nama_siswa }}</td>
                                        <td>{{ $row->kode_ruang }}</td>
                                        <td>{{ $row->kode_sesi }}</td>
                                        <td>
                                            @if ($row->status == '0')
                                                --:--
                                            @else
                                                {{ $row->mulai }}
                                            @endif
                                        </td>
                                        @if ($row->status == '0')
                                            <td>--</td>
                                            <td class="text-success">0</td>
                                            <td class="text-danger">0</td>
                                            <td class="tw-text-gray-600 ">0</td>
                                            <td class="tw-text-gray-600 ">0</td>
                                            <td class="tw-text-gray-600 ">0</td>
                                            <td class="tw-text-gray-600 ">0</td>
                                            <td class="tw-text-gray-600 ">0</td>
                                            <td class="tw-font-bold">0</td>
                                        @else
                                            <td>{{ $row->lama_ujian }}</td>
                                            <td class="text-success">{{ $row->pg_benar }}</td>
                                            <td class="text-danger">{{ $row->pg_salah }}</td>
                                            <td class="tw-text-gray-600 ">{{ $row->nilai_pg }}</td>
                                            <td class="tw-text-gray-600 ">{{ $row->nilai_pk }}</td>
                                            <td class="tw-text-gray-600 ">{{ $row->nilai_jo }}</td>
                                            <td class="tw-text-gray-600 ">{{ $row->nilai_is }}</td>
                                            <td class="tw-text-gray-600 ">{{ $row->nilai_es }}</td>
                                            <td class="tw-font-bold">
                                                {{ (float) $row->nilai_pg + (float) $row->nilai_pk + (float) $row->nilai_jo + (float) $row->nilai_is + (float) $row->nilai_es }}
                                            </td>
                                        @endif
                                        <td>
                                            @if ($row->dikoreksi == 1)
                                                <a target="_BLANK"
                                                    href="{{ url('/pelaksanaan-ujian/hasil-ujian/koreksi/' . $id_jadwal . '/' . $row->id_siswa) }}"
                                                    class="tw-no-underline tw-bg-green-100 tw-text-xs tw-tracking-wider tw-text-green-600 tw-px-2.5 tw-py-1.5 tw-rounded-md tw-font-semibold mt-1 tw-whitespace-nowrap">
                                                    <i class="fas fa-check tw-text-xs tw-text-green-600"></i>
                                                    KOREKSI
                                                </a>
                                            @else
                                                <a target="_BLANK"
                                                    href="{{ url('/pelaksanaan-ujian/hasil-ujian/koreksi/' . $id_jadwal . '/' . $row->id_siswa) }}"
                                                    class="tw-no-underline tw-bg-blue-100 tw-text-xs tw-tracking-wider tw-text-blue-600 tw-px-2.5 tw-py-1.5 tw-rounded-md tw-font-semibold mt-1 tw-whitespace-nowrap">
                                                    <i
                                                        class="fas fa-exclamation-triangle tw-text-xs tw-text-blue-600"></i>
                                                    KOREKSI
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center py-3" colspan="20">Tidak ada data didalam tabel</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="modal fade" wire:ignore.self id="formDataModal" aria-labelledby="formDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formDataModalLabel">Detail Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body px-0">
                        <table class="mt-3">
                            <tr>
                                <td width="35%">Mata Pelajaran</td>
                                <td width="3%">:</td>
                                <td>{{ $jadwals->nama_mapel ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Kelas</td>
                                <td>:</td>
                                <td>{{ $nama_kelas }}</td>
                            </tr>
                            <tr>
                                <td>Guru</td>
                                <td>:</td>
                                <td>{{ $jadwals->nama_guru ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Soal</td>
                                <td>:</td>
                                <td>{{ $jadwals->kode_bank ?? '' }}</td>
                            </tr>
                            <tr>
                                <td>Jumlah Soal</td>
                                <td>:</td>
                                <td>{{ $jadwals->total_soal ?? '' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button class="btn btn-success"><i class="fas fa-file-excel"></i> Export
                            Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="inputDataModal" aria-labelledby="inputDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="inputDataModalLabel">Input Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body px-0">
                        <div class="tw-overflow-x-auto no-scrollbar">
                            <table class="tw-w-full tw-min-w-full tw-table-auto">
                                <thead>
                                    <tr class="tw-whitespace-nowrap text-center">
                                        <th>No.</th>
                                        <th>No. Peserta</th>
                                        <th>Nama Siswa</th>
                                        <th>Nilai PG <br> Max. Point: 20</th>
                                        <th>Nilai PG Kompleks <br> Max. Point: 20</th>
                                        <th>Nilai Menjodohkan <br> Max. Point: 20</th>
                                        <th>Nilai Isian Singkat <br> Max. Point: 20</th>
                                        <th>Nilai Essai/Uraian <br> Max. Point: 20</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($nilais as $nilai)
                                        <tr class="tw-whitespace-nowrap text-center">
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $nilai->nomor_peserta }}</td>
                                            <td class="tw-text-left">{{ $nilai->nama_siswa }}</td>
                                            <td>{{ $nilai->nilai_pg }}</td>
                                            <td>
                                                <center>
                                                    <input type="number"
                                                        wire:model="inputan.{{ $nilai->id }}.nilai_pk"
                                                        class="form-control tw-w-1/2 tw-text-center"
                                                        wire:key="{{ rand() }}" />
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <input type="number"
                                                        wire:model="inputan.{{ $nilai->id }}.nilai_jo"
                                                        class="form-control tw-w-1/2 tw-text-center"
                                                        wire:key="{{ rand() }}" />
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <input type="number"
                                                        wire:model="inputan.{{ $nilai->id }}.nilai_is"
                                                        class="form-control tw-w-1/2 tw-text-center"
                                                        wire:key="{{ rand() }}" />
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <input type="number"
                                                        wire:model="inputan.{{ $nilai->id }}.nilai_es"
                                                        class="form-control tw-w-1/2 tw-text-center"
                                                        wire:key="{{ rand() }}" />
                                                </center>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="8">No data available in the table</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button wire:click.prevent="updateNilai()" wire:loading.attr="disabled"
                            class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('general-css')
    <link href="{{ asset('assets/midragon/select2/select2.min.css') }}" rel="stylesheet" />
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

                $('#id_jadwal').select2();

                $('#id_jadwal').on('change', function(e) {
                    var data = $('#id_jadwal').select2("val");
                    @this.set('id_jadwal', data);
                });
            });
        })
    </script>
@endpush
