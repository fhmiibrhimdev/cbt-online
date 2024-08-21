<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Jadwal</h1>
        </div>

        <div class="section-body">
            <div class="tw-border-l-4 tw-border-blue-500 tw-bg-blue-100 tw-p-4 tw-mb-4 tw-rounded-lg">
                <h4 class="tw-text-blue-700 tw-font-bold tw-mb-2"><i class="fas fa-exclamation-circle"></i> Informasi
                </h4>
                <p class="tw-text-blue-700"><i class="fas fa-badge-check tw-text-green-700"></i> : Jadwal Aktif</p>
                <p class="tw-text-blue-700">Untuk menampilkan opsi Bank Soal, pastikan Bank Soal harus sudah siap
                    digunakan.
                </p>
            </div>
            <div class="card">
                <h3>Table Jadwal</h3>
                <div class="card-body">
                    <div class="show-entries">
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
                                    <th width="18%">Bank Soal</th>
                                    <th width="8%" class="text-center">Jenis</th>
                                    <th width="25%">Mata Pelajaran</th>
                                    <th width="20%">Kelas</th>
                                    <th width="10%">Durasi</th>
                                    <th class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->groupBy('tgl_mulai') as $row)
                                    <tr class="tw-bg-zinc-50">
                                        <td colspan="7"
                                            class="tw-font-bold tw-py-3 tw-tracking-wider tw-text-gray-700">
                                            {{ \Carbon\Carbon::parse($row[0]['tgl_mulai'])->isoFormat('dddd, D MMMM Y') }}
                                        </td>
                                    </tr>
                                    @foreach ($row as $result)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td>
                                                {{ $result['kode_bank'] }}
                                                @if ($result['status'] == '1')
                                                    <i class="fas fa-badge-check tw-text-green-600 tw-text-base"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $result['kode_jenis'] }}</td>
                                            <td>{{ Str::limit($result['nama_mapel'], 30) }}</td>
                                            <td>
                                                @foreach ($result->getKelas()->take(2) as $class)
                                                    <span
                                                        class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">{{ $class->level }}
                                                        - {{ $class->kode_kelas }}</span>
                                                @endforeach

                                                @if ($result->getKelas()->count() > 2)
                                                    <button id="kelas-toggle" data-id="{{ $result['id'] }}">
                                                        <span
                                                            class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">...</span>
                                                    </button>
                                                    <span id="tampilkan-kelas-{{ $result['id'] }}"
                                                        class="tw-hidden tw-mt-3">
                                                        @foreach ($result->getKelas()->skip(2) as $class)
                                                            <span
                                                                class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">{{ $class->level }}
                                                                - {{ $class->kode_kelas }}</span>
                                                        @endforeach
                                                    </span>
                                                @endif
                                            </td>
                                            <td>{{ $result['durasi_ujian'] }} menit</td>
                                            <td class="text-center">
                                                <button wire:click.prevent="edit({{ $result['id'] }})"
                                                    class="btn btn-primary" data-toggle="modal"
                                                    data-target="#formDataModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                @if (!$result['nilai_count'] > 0)
                                                    <button wire:click.prevent="deleteConfirm({{ $result['id'] }})"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Not data available in the table</td>
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
        <button wire:click.prevent="isEditingMode(false)" class="btn-modal" data-toggle="modal" data-backdrop="static"
            data-keyboard="false" data-target="#formDataModal">
            <i class="far fa-plus"></i>
        </button>
    </section>
    <div class="modal fade" wire:ignore.self id="formDataModal" aria-labelledby="formDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formDataModalLabel">{{ $isEditing ? 'Edit Data' : 'Add Data' }}</h5>
                    <button type="button" wire:click="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_mapel">Mata Pelajaran</label>
                                    {{-- <div wire:ignore> --}}
                                    <select wire:model="id_mapel" id="id_mapel" class="form-control">
                                        <option value="" disabled>-- Pilih Mata Pelajaran --</option>
                                        @foreach ($mapels as $mapel)
                                            <option value="{{ $mapel->id }}"
                                                @if ((int) $mapel->id == (int) $id_mapel) selected @endif>
                                                {{ $mapel->nama_mapel }}</option>
                                        @endforeach
                                    </select>
                                    {{-- </div> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_bank">Bank Soal</label>
                                    <select wire:model="id_bank" id="id_bank" class="form-control">
                                        <option value="" disabled>-- Pilih Bank Soal --</option>
                                        @foreach ($banks as $bank)
                                            <option value="{{ $bank->id }}"
                                                @if ((int) $bank->id == (int) $id_bank) selected @endif>
                                                {{ $bank->kode_bank }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_bank')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_jenis_ujian">Jenis Ujian</label>
                            <select wire:model="id_jenis_ujian" id="id_jenis_ujian" class="form-control">
                                <option value="" disabled>-- Pilih Jenis Ujian --</option>
                                @foreach ($ujians as $ujian)
                                    <option value="{{ $ujian->id }}"
                                        @if ((int) $ujian->id == (int) $id_jenis_ujian) selected @endif>{{ $ujian->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_jenis_ujian')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tgl_mulai">Tanggal Mulai</label>
                                    <input type="date" wire:model="tgl_mulai" id="tgl_mulai"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tgl_selesai">Tanggal Akhir</label>
                                    <input type="date" wire:model="tgl_selesai" id="tgl_selesai"
                                        class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="durasi_ujian">Durasi Ujian (Menit)</label>
                                    <input type="number" wire:model="durasi_ujian" id="durasi_ujian"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="jarak">Durasi Minimal (Menit)</label>
                                    <input type="number" wire:model="jarak" id="jarak" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="form-group tw-flex">
                                    <label for="acak_soal">Acak Soal</label>
                                    <div class="ml-auto">
                                        <label class="switch" wire:key="{{ rand() }}">
                                            <input type="checkbox" id="acak_soal" wire:model="acak_soal"
                                                @if ($acak_soal == '1') checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group tw-flex">
                                    <label for="acak_opsi">Acak Jawaban</label>
                                    <div class="ml-auto">
                                        <label class="switch" wire:key="{{ rand() }}">
                                            <input type="checkbox" id="acak_opsi"
                                                @if ($acak_opsi == '1') checked @endif
                                                @if ($nilai_count > 0) disabled @else wire:model="acak_opsi" @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group tw-flex">
                                    <label for="token">Gunakan Token</label>
                                    <div class="ml-auto">
                                        <label class="switch" wire:key="{{ rand() }}">
                                            <input type="checkbox" wire:model="token" id="token"
                                                @if ($token == '1') checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group tw-flex">
                                    <label for="hasil_tampil">Tampilkan Hasil</label>
                                    <div class="ml-auto">
                                        <label class="switch" wire:key="{{ rand() }}">
                                            <input type="checkbox" wire:model="hasil_tampil" id="hasil_tampil"
                                                @if ($hasil_tampil == '1') checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group tw-flex">
                                    <label for="reset_login">Reset Izin</label>
                                    <div class="ml-auto">
                                        <label class="switch" wire:key="{{ rand() }}">
                                            <input type="checkbox" wire:model="reset_login" id="reset_login"
                                                @if ($reset_login == '1') checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group tw-flex">
                                    <label for="status">Aktif</label>
                                    <div class="ml-auto">
                                        <label class="switch" wire:key="{{ rand() }}">
                                            <input type="checkbox" id="status"
                                                @if ($status == '1') checked @endif
                                                @if ($nilai_count > 0) disabled @else wire:model="status" @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="cancel()" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="{{ $isEditing ? 'update()' : 'store()' }}"
                            wire:loading.attr="disabled" class="btn btn-primary tw-bg-blue-500">Save Data</button>
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
        $(document).ready(function() {
            $(document).on('click', '#kelas-toggle', function() {
                var id = $(this).data('id');
                $('#tampilkan-kelas-' + id).removeClass('tw-hidden').addClass('tw-block');
                $(this).addClass('tw-hidden');
            });
        });
    </script>
    <script>
        window.addEventListener('initSelect2', event => {
            $(document).ready(function() {
                $('#id_mapel').select2();
                $('#id_mapel').on('change', function(e) {
                    var data = $('#id_mapel').select2("val");
                    @this.set('id_mapel', data);
                });

                $('#id_bank').select2();
                $('#id_bank').on('change', function(e) {
                    var data = $('#id_bank').select2("val");
                    @this.set('id_bank', data);
                });

                $('#id_jenis_ujian').select2();
                $('#id_jenis_ujian').on('change', function(e) {
                    var data = $('#id_jenis_ujian').select2("val");
                    @this.set('id_jenis_ujian', data);
                });
            });
        })
    </script>
@endpush
