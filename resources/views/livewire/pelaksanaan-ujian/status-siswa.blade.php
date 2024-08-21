<div>
    <section class="section custom-section">
        <div class="section-header tw-block">
            <div class="tw-flex">
                <h1 class="tw-text-lg">Status Siswa</h1>
                <div class="ml-auto">
                    <button wire:click.prevent="refresh()" class="btn btn-info mr-2"
                        @if ($id_jadwal == '0') disabled @endif><i class="fas fa-sync mr-1"></i>
                        Refresh</button>
                    <button wire:click.prevent="terapkanAksiConfirm()" class="btn btn-primary"
                        @if ((int) $id_jadwal > 0 && (!empty($reset_izin) || !empty($paksa_selesai) || !empty($ulang))) @else disabled @endif><i class="fas fa-check mr-1"></i>
                        Terapkan Aksi</button>
                </div>
            </div>
        </div>

        <div class="section-body">
            {{-- <pre>@json($reset_izin)</pre> --}}
            <div class="card">
                <div class="card-body px-4 py-0">
                    <div class="form-group mt-4">
                        <input type="text" wire:model="token"
                            class="form-control tw-font-bold tw-tracking-widest tw-text-gray-700 text-center tw-text-lg"
                            disabled>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="id_jadwal">Jadwal</label>
                                <select wire:model="id_jadwal" id="id_jadwal" class="form-control">
                                    <option value="0" {{ $id_jadwal == '0' ? 'selected' : '' }}>-- Pilih
                                        Jadwal --</option>
                                    @foreach ($jadwals as $jadwal)
                                        <option value="{{ $jadwal->id }}">{{ $jadwal->kode_bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="id_ruang">Ruang</label>
                                <select wire:model="id_ruang" id="id_ruang" class="form-control">
                                    <option value="0" {{ $id_ruang == '0' ? 'selected' : '' }}>-- Pilih
                                        Ruang --</option>
                                    @foreach ($ruangs as $ruang)
                                        <option value="{{ $ruang->id }}">{{ $ruang->nama_ruang }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="id_sesi">Sesi</label>
                                <select wire:model="id_sesi" id="id_sesi" class="form-control">
                                    <option value="0" {{ $id_sesi == '0' ? 'selected' : '' }}>-- Pilih
                                        Sesi --</option>
                                    @foreach ($sesis as $sesi)
                                        <option value="{{ $sesi->id }}">{{ $sesi->nama_sesi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-0">
                    {{-- <pre>@json($data, JSON_PRETTY_PRINT)</pre> --}}
                    <div class="tw-overflow-x-auto no-scrollbar">
                        <table class="tw-w-full tw-min-w-full tw-table-auto">
                            <thead>
                                <tr class="text-center">
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">No. Peserta</th>
                                    <th rowspan="2">Nama Siswa</th>
                                    <th rowspan="2">Kelas</th>
                                    <th rowspan="2">Ruang</th>
                                    <th rowspan="2">Sesi</th>
                                    <th colspan="3">Status</th>
                                    <th rowspan="2">Reset Waktu</th>
                                    <th colspan="3">Aksi</th>
                                </tr>
                                <tr class="text-center">
                                    <th>Mulai</th>
                                    <th>Stat</th>
                                    <th>Durasi</th>
                                    <th>
                                        Reset Izin <br>
                                        <input type="checkbox" id="all-reset-izin"
                                            class="tw-border tw-border-gray-200 tw-rounded-sm tw-p-2 mt-1">
                                    </th>
                                    <th>
                                        Paksa Selesai <br>
                                        <input type="checkbox" id="all-paksa-selesai"
                                            class="tw-border tw-border-gray-200 tw-rounded-sm tw-p-2 mt-1">
                                    </th>
                                    <th>
                                        Ulang <br>
                                        <input type="checkbox" id="all-ulang"
                                            class="tw-border tw-border-gray-200 tw-rounded-sm tw-p-2 mt-1">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <pre>@json($reset_izin)</pre>
                                <pre>@json($paksa_selesai)</pre>
                                <pre>@json($ulang)</pre> --}}
                                @if ($id_jadwal != '0')
                                    @forelse ($data as $row)
                                        <tr class="tw-whitespace-nowrap text-center">
                                            <td class="tw-py-3">{{ $loop->index + 1 }}</td>
                                            <td class="tw-py-3">{{ $row->nomor_peserta }}</td>
                                            <td class="tw-py-3 text-left">{{ $row->nama_siswa }}</td>
                                            <td class="tw-py-3">{{ $row->level }}-{{ $row->nama_kelas }}</td>
                                            <td class="tw-py-3">{{ $row->kode_ruang }}</td>
                                            <td class="tw-py-3">{{ $row->kode_sesi }}</td>
                                            <td class="tw-py-3">
                                                @if ($row->status == '0')
                                                    --:--
                                                @else
                                                    {{ $row->mulai }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->status == '0')
                                                    <span
                                                        class="tw-bg-red-50 tw-text-xs tw-tracking-wider tw-text-red-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">Belum</span>
                                                @elseif ($row->status == '1')
                                                    <span
                                                        class="tw-bg-blue-50 tw-text-xs tw-tracking-wider tw-text-blue-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">Proses</span>
                                                @else
                                                    <span
                                                        class="tw-bg-green-50 tw-text-xs tw-tracking-wider tw-text-green-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">Selesai</span>
                                                @endif
                                            </td>
                                            <td class="tw-py-3">
                                                @if ($row->status == '0' || $row->status == '1')
                                                    --
                                                @else
                                                    {{ $row->lama_ujian }}
                                                @endif
                                            </td>
                                            <td class="">
                                                <button wire:click.prevent="resetIzin({{ $row->id_siswa }})"
                                                    class="btn btn-sm px-2 btn-secondary">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                            </td>
                                            <td class="tw-py-3" wire:key="{{ rand() }}">
                                                <input type="checkbox"
                                                    @if ($row->user_id == null) disabled @else wire:model.blur="reset_izin" value="{{ $row->id_siswa }}" @endif
                                                    id="reset_izin-{{ $loop->index }}"
                                                    class="tw-border tw-border-gray-200 tw-rounded-sm tw-p-2 disabled:tw-bg-gray-100 reset-izin">
                                            </td>
                                            <td class="tw-py-3" wire:key="{{ rand() }}">
                                                <input type="checkbox"
                                                    @if ($row->status == '0' || $row->status == '2') disabled @else wire:model.blur="paksa_selesai" value="{{ $row->id_siswa }}" @endif
                                                    id="paksa_selesai-{{ $loop->index }}"
                                                    class="tw-border tw-border-gray-200 tw-rounded-sm tw-p-2 disabled:tw-bg-gray-100 paksa-selesai">
                                            </td>
                                            <td class="tw-py-3" wire:key="{{ rand() }}">
                                                <input type="checkbox"
                                                    @if ($row->status == '0' || $row->status == '1') disabled @else wire:model.blur="ulang" value="{{ $row->id_siswa }}" @endif
                                                    id="ulang-{{ $loop->index }}"
                                                    class="tw-border tw-border-gray-200 tw-rounded-sm tw-p-2 disabled:tw-bg-gray-100 ulang">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center py-3" colspan="13">No data available on the table
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td class="text-center py-3" colspan="13">No data available on the table
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <button class="btn-modal" data-toggle="modal" data-backdrop="static" data-keyboard="false"
            data-target="#formDataModal">
            <i class="far fa-info tw-text-lg"></i>
        </button>
    </section>
    <div class="modal fade" wire:ignore.self id="formDataModal" aria-labelledby="formDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title tw-font-bold tw-text-gray-900" id="formDataModalLabel">Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        {{-- <div class="tw-border-l-4 tw-border-green-500 tw-bg-green-100 tw-p-4 tw-mb-4 tw-rounded-lg">
                            <h4 class="tw-text-green-700 tw-font-bold tw-mb-2"><i
                                    class="fas fa-exclamation-circle"></i>
                                Informasi Ujian
                            </h4>
                            <table class="tw-mt-5">
                                <thead>
                                    <tr class="tw-text-gray-700 tw-font-semibold">
                                        <td width="33%" class="tw-bg-transparent">Mata Pelajaran</td>
                                        <td width="3%" class="tw-bg-transparent">:</td>
                                        <td class="tw-bg-transparent">Matematika</td>
                                    </tr>
                                    <tr class="tw-text-gray-700 tw-font-semibold">
                                        <td width="33%" class="tw-bg-transparent">Guru</td>
                                        <td width="3%" class="tw-bg-transparent">:</td>
                                        <td class="tw-bg-transparent">Martono</td>
                                    </tr>
                                    <tr class="tw-text-gray-700 tw-font-semibold">
                                        <td width="33%" class="tw-bg-transparent">Jenis Ujian</td>
                                        <td width="3%" class="tw-bg-transparent">:</td>
                                        <td class="tw-bg-transparent">Penilaian Harian</td>
                                    </tr>
                                    <tr class="tw-text-gray-700 tw-font-semibold">
                                        <td width="33%" class="tw-bg-transparent">Jml. Soal</td>
                                        <td width="3%" class="tw-bg-transparent">:</td>
                                        <td class="tw-bg-transparent">5</td>
                                    </tr>
                                </thead>
                            </table>
                        </div> --}}
                        <div class="tw-border-l-4 tw-border-blue-500 tw-bg-blue-100 tw-p-4 tw-mb-4 tw-rounded-lg">
                            <ul class="tw-list-disc tw-text-gray-700 tw-ml-5 tw-text-[13pxs]">
                                <li>Gunakan tombol <button class="btn btn-sm btn-primary"><i class="fas fa-sync"></i>
                                        Refresh</button> untuk merefresh halaman</li>
                                <li><b>RESET WAKTU.</b> Jika siswa logout sebelum selesai dan tidak melanjutkan sampai
                                    waktu
                                    ujian habis maka akan ditolak, jika ingin melanjutkan maka harus reset waktu.</li>
                                <li>Aksi <b>RESET IZIN</b> untuk mengizinkkan siswa mengerjakan ujian di perangkat
                                    berbeda.
                                </li>
                                <li>
                                    Aksi <b>PAKSA SELESAI</b> untuk memaksa siswa menyelesaikan ujian.
                                </li>
                                <li>
                                    Aksi <b>ULANG</b> untuk mengulang ujian siswa dari awal.
                                </li>
                                <li>
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-check"></i> Terapkan
                                        Aksi</button> untuk menerapkan aksi
                                    terpilih ke setiap siswa yang dipilih
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('general-css')
    <link href="{{ asset('assets/midragon/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('js-libraries')
    <script src="{{ asset('/assets/midragon/select2/select2.full.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                title: event.detail[0].message,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('terapkanAksi')
                }
            })
        })
    </script>
    <script>
        $(document).ready(function() {
            handleCheckboxChange('#all-reset-izin', 'input[type="checkbox"].reset-izin', 'reset_izin');
            handleCheckboxChange('#all-paksa-selesai', 'input[type="checkbox"].paksa-selesai', 'paksa_selesai');
            handleCheckboxChange('#all-ulang', 'input[type="checkbox"].ulang', 'ulang');

            function handleCheckboxChange(allSelector, itemClass, livewireKey) {
                $(allSelector).change(function() {
                    var isChecked = $(this).is(':checked');

                    $(itemClass + ':not(:disabled)').prop('checked', isChecked);

                    var checkedValues = [];
                    $(itemClass + ':not(:disabled)').each(function() {
                        if ($(this).is(':checked')) {
                            checkedValues.push($(this).val());
                        }
                    });

                    @this.set(livewireKey, checkedValues);
                });
            }
        });
        window.addEventListener('initSelect2', event => {

            $(document).ready(function() {
                $('#id_jadwal').select2();

                $('#id_jadwal').on('change', function(e) {
                    var data = $('#id_jadwal').select2("val");
                    @this.set('id_jadwal', data);
                });

                $('#id_ruang').select2();

                $('#id_ruang').on('change', function(e) {
                    var data = $('#id_ruang').select2("val");
                    @this.set('id_ruang', data);
                });

                $('#id_sesi').select2();

                $('#id_sesi').on('change', function(e) {
                    var data = $('#id_sesi').select2("val");
                    @this.set('id_sesi', data);
                });
            });
        })
    </script>
@endpush
