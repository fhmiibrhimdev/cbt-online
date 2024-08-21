<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Alokasi Waktu</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body p-0">
                    <div class="px-4 mt-3">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="id_jenis_ujian">Jenis Ujian</label>
                                    <select wire:model="id_jenis_ujian" id="id_jenis_ujian" class="form-control">
                                        <option value="" disabled>-- Pilih Jenis Ujian --</option>
                                        @foreach ($ujians as $ujian)
                                            <option value="{{ $ujian->id }}">{{ $ujian->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="id_level">Level Kelas</label>
                                    <select wire:model="id_level" id="id_level" class="form-control">
                                        <option value="" disabled>-- Pilih Level Kelas --</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="start_date">Dari Tanggal</label>
                                    <input type="date" wire:model="start_date" id="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="end_date">Sampai Tanggal</label>
                                    <input type="date" wire:model="end_date" id="end_date" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="tw-flex tw-ml-6 tw-mt-6 tw-mb-5 lg:tw-mb-1">
                    <h3 class="tw-tracking-wider tw-text-[#34395e] tw-text-base tw-font-semibold">
                        Table Alokasi Waktu</h3>
                    <button wire:click="update()" class="btn btn-primary ml-auto mr-3"><i class="fas fa-save"></i> Save
                        Data</button>
                </div>
                <div class="card-body">
                    <div class="show-entries mt-1">
                        <p class="show-entries-show">Show</p>
                        <select wire:model.live="lengthData" id="length-data">
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="250">250</option>
                            <option value="500">500</option>
                        </select>
                        <p class="show-entries-entries">Entries</p>
                    </div>
                    <div class="search-column">
                        <p>Search: </p><input type="search" wire:model.live.debounce.750ms="searchTerm"
                            id="search-data" placeholder="Search here..." class="form-control" value="">
                    </div>
                    <div class="table-responsive tw-max-h-96">
                        <table>
                            <thead class="tw-sticky tw-top-0">
                                <tr class="tw-text-gray-700">
                                    <th width="6%" class="text-center">No</th>
                                    <th width="13%">Bank Soal</th>
                                    <th width="25%">Mata Pelajaran</th>
                                    <th width="28%">Kelas</th>
                                    <th width="8%" class="text-center">Jam ke</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->groupBy('tgl_mulai') as $row)
                                    <tr class="tw-bg-zinc-50">
                                        <td colspan="5"
                                            class="tw-font-bold tw-py-3 tw-tracking-wider tw-text-gray-700">
                                            {{ \Carbon\Carbon::parse($row[0]['tgl_mulai'])->isoFormat('dddd, D MMMM Y') }}
                                        </td>
                                    </tr>
                                    @foreach ($row as $result)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td>{{ $result['kode_bank'] }}</td>
                                            <td>{{ $result['nama_mapel'] }}</td>
                                            <td>
                                                @foreach ($result->getKelas()->take(5) as $class)
                                                    <span
                                                        class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">{{ $class->kode_kelas }}</span>
                                                @endforeach

                                                @if ($result->getKelas()->count() > 5)
                                                    <button id="kelas-toggle" data-id="{{ $result['id'] }}">
                                                        <span
                                                            class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">...</span>
                                                    </button>
                                                    <span id="tampilkan-kelas-{{ $result['id'] }}"
                                                        class="tw-hidden tw-mt-3">
                                                        @foreach ($result->getKelas()->skip(5) as $class)
                                                            <span
                                                                class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">{{ $class->kode_kelas }}</span>
                                                        @endforeach
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <input type="number" inputmode="numeric"
                                                    wire:model="jam_ke.{{ $result['id'] }}" class="form-control"
                                                    wire:key="jam_ke_{{ $result['id'] }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Not data available in the table</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-5 px-3">
                        {{ $data->links() }}
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
                $('#id_jenis_ujian').select2();
                $('#id_jenis_ujian').on('change', function(e) {
                    var data = $('#id_jenis_ujian').select2("val");
                    @this.set('id_jenis_ujian', data);
                });

                $('#id_level').select2();
                $('#id_level').on('change', function(e) {
                    var data = $('#id_level').select2("val");
                    @this.set('id_level', data);
                });
            });
        })
    </script>
@endpush
