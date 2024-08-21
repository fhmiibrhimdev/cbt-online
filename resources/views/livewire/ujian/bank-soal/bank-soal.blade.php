<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Bank Soal</h1>
        </div>

        <div class="section-body">
            <div class="tw-border-l-4 tw-border-blue-500 tw-bg-blue-100 tw-p-4 tw-mb-4 tw-rounded-lg">
                <h4 class="tw-text-blue-700 tw-font-bold tw-mb-2"><i class="fas fa-exclamation-circle"></i> Informasi
                </h4>
                <p class="tw-text-blue-700"><i class="fas fa-badge-check tw-text-base tw-text-green-700"></i> : Bank
                    Soal sudah siap digunakan</p>
                <p class="tw-text-blue-700"><span class="tw-bg-gray-400 tw-px-2 tw-rounded-sm mr-1"></span> : Tidak
                    digunakan (bisa dihapus)</p>
                <p class="tw-text-blue-700"><span class="tw-bg-yellow-400 tw-px-2 tw-rounded-sm mr-1"></span> :
                    Digunakan jadwal (tidak bisa dihapus)</p>
                <p class="tw-text-blue-700"><span class="tw-bg-purple-400 tw-px-2 tw-rounded-sm mr-1"></span> :
                    Digunakan siswa (tidak bisa dihapus)</p>
            </div>
            <div class="card">
                <h3>Table Bank Soal</h3>
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
                                    <th width="20%">Kode</th>
                                    <th width="27%">Mata Pelajaran</th>
                                    <th width="15%">Guru Pengampu</th>
                                    <th width="20%">Kelas</th>
                                    <th width="15%" class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td>
                                            @if ($row->jadwal_count == 0 && $row->nilai_count == 0)
                                                <span class="tw-bg-gray-400 tw-px-2 tw-rounded-sm mr-1"></span>
                                            @elseif ($row->jadwal_count > 0 && $row->nilai_count == 0)
                                                <span class="tw-bg-yellow-400 tw-px-2 tw-rounded-sm mr-1"></span>
                                            @elseif ($row->jadwal_count > 0 && $row->nilai_count > 0)
                                                <span class="tw-bg-purple-400 tw-px-2 tw-rounded-sm mr-1"></span>
                                            @endif
                                            {{ $row->kode_bank }}
                                            @if ($row->total_seharusnya == $row->total_ditampilkan)
                                                <i class="fas fa-badge-check tw-text-base tw-text-green-600"></i>
                                            @endif
                                        </td>
                                        <td>{{ $row->nama_mapel }} ({{ $row->kode_mapel }})</td>
                                        <td>{{ $row->nama_guru }}</td>
                                        <td>
                                            @foreach ($row->getKelas()->take(2) as $class)
                                                <span
                                                    class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">{{ $class->level }}
                                                    - {{ $class->kode_kelas }}</span>
                                            @endforeach

                                            @if ($row->getKelas()->count() > 2)
                                                <button id="kelas-toggle" data-id="{{ $row->id }}"
                                                    class="tw-mt-2.5">
                                                    <span
                                                        class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">...</span>
                                                </button>
                                                <span id="tampilkan-kelas-{{ $row->id }}"
                                                    class="tw-hidden tw-mt-3">
                                                    @foreach ($row->getKelas()->skip(2) as $class)
                                                        <span
                                                            class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">{{ $class->level }}
                                                            - {{ $class->kode_kelas }}</span>
                                                    @endforeach
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">

                                            @if ($row->jadwal_count == 0 && $row->nilai_count == 0)
                                                <a href="{{ route('bank-soal-detail', [Crypt::encrypt($row->id), 1]) }}"
                                                    class="btn btn-success" title="Buat Soal">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                                <button wire:click.prevent="edit({{ $row->id }})"
                                                    class="btn btn-primary" data-toggle="modal"
                                                    data-target="#formDataModal" title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click.prevent="deleteConfirm({{ $row->id }})"
                                                    class="btn btn-danger" title="Delete Data">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button wire:click.prevent="replicatedConfirm({{ $row->id }})"
                                                    class="btn btn-warning" title="Replicate Data">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <a href="{{ route('bank-soal-detail', [Crypt::encrypt($row->id), 1]) }}"
                                                    class="btn btn-primary" title="Buat Soal">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Not data available in the table</td>
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
                    <button type="button" wire:click="cancel()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div
                            class="tw-bg-gray-50 tw-p-2 tw-rounded-lg tw-text-center tw-shadow-inner tw-shadow-gray-100">
                            <div class="row tw-font-bold tw-text-gray-600">
                                <div class="col-lg-6">
                                    <p>Total Soal</p>
                                    <p>{{ (int) $jml_pg + (int) $jml_kompleks + (int) $jml_jodohkan + (int) $jml_isian + (int) $jml_esai }}
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <p>Total Bobot</p>
                                    <p>{{ (int) $bobot_pg + (int) $bobot_kompleks + (int) $bobot_jodohkan + (int) $bobot_isian + (int) $bobot_esai }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="status_soal">Status Bank Soal</label>
                            <div wire:ignore>
                                <select wire:model="status_soal" id="status_soal" class="form-control">
                                    <option value="">-- Opsi Pilihan --</option>
                                    <option value="1">AKTIF</option>
                                    <option value="0">NON AKTIF</option>
                                </select>
                            </div> @error('status_soal')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_mapel">Mata Pelajaran</label>
                                    <div wire:ignore>
                                        <select wire:model="id_mapel" id="id_mapel" class="form-control">
                                            <option value="">-- Opsi Pilihan --</option>
                                            @foreach ($mapels as $mapel)
                                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </div> @error('id_mapel')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_guru">Guru Pengampu</label>
                                    <select wire:model="id_guru" id="id_guru" class="form-control"
                                        {{ empty($gurus) ? 'disabled' : '' }}>
                                        <option value="">-- Opsi Pilihan --</option>
                                        @foreach ($gurus as $guru)
                                            <option value="{{ $guru['id'] }}"
                                                {{ $id_guru == $guru['id'] ? 'selected' : '' }}>
                                                {{ $guru['nama_guru'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_guru')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_level">Level</label>
                                    <select wire:model="id_level" id="id_level" class="form-control">
                                        <option value="">-- Opsi Pilihan --</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_level')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_kelas">Kelas</label>
                                    <select wire:model="id_kelas" id="id_kelas" class="form-control" multiple
                                        {{ empty($kelass) || $id_level == '' ? 'disabled' : '' }}>
                                        <option value="">-- Opsi Pilihan --</option>
                                        @foreach ($kelass as $level => $kelasGroup)
                                            <optgroup label="{{ $level }}">
                                                @foreach ($kelasGroup as $kelasItem)
                                                    <option value="{{ $kelasItem->id }}"
                                                        {{ in_array($kelasItem->id, $id_kelas) ? 'selected' : '' }}>
                                                        {{ $level }}-{{ $kelasItem->kode_kelas }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('id_kelas')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div id="accordion">
                            <div class="accordion">
                                <div class="accordion-header" role="button" wire:ignore.self data-toggle="collapse"
                                    data-target="#pilihan-ganda" aria-expanded="false">
                                    <h4>Soal Pilihan Ganda</h4>
                                </div>
                                <div class="accordion-body collapse" wire:ignore.self id="pilihan-ganda"
                                    data-parent="#accordion" style="">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jml_pg">Jumlah Soal</label>
                                                <input type="number" wire:model.blur="jml_pg" id="jml_pg"
                                                    class="form-control">
                                                @error('jml_pg')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="bobot_pg">Bobot (%)</label>
                                                <input type="text" wire:model.blur="bobot_pg" id="bobot_pg"
                                                    class="form-control">
                                                @error('bobot_pg')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="opsi">Opsi Jawaban</label>
                                        <div wire:ignore>
                                            <select wire:model="opsi" id="opsi" class="form-control">
                                                <option value="" disabled>-- Opsi Pilihan --</option>
                                                <option value="3">3 (A, B, C)</option>
                                                <option value="4">4 (A, B, C, D)</option>
                                                <option value="5">5 (A, B, C, D, E)</option>
                                            </select>
                                        </div> @error('opsi')
                                            <small class='text-danger'>{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header collapsed" role="button" wire:ignore.self
                                    data-toggle="collapse" data-target="#pilihan-ganda-kompleks"
                                    aria-expanded="false">
                                    <h4>Soal Pilihan Ganda Kompleks</h4>
                                </div>
                                <div class="accordion-body collapse" wire:ignore.self id="pilihan-ganda-kompleks"
                                    data-parent="#accordion" style="">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jml_kompleks">Jumlah Soal</label>
                                                <input type="number" wire:model.blur="jml_kompleks"
                                                    id="jml_kompleks" class="form-control">
                                                @error('jml_kompleks')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="bobot_kompleks">Bobot (%)</label>
                                                <input type="number" wire:model.blur="bobot_kompleks"
                                                    id="bobot_kompleks" class="form-control">
                                                @error('bobot_kompleks')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header collapsed" role="button" wire:ignore.self
                                    data-toggle="collapse" data-target="#soal-menjodohkan" aria-expanded="false">
                                    <h4>Soal Menjodohkan</h4>
                                </div>
                                <div class="accordion-body collapse" wire:ignore.self id="soal-menjodohkan"
                                    data-parent="#accordion" style="">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jml_jodohkan">Jumlah Soal</label>
                                                <input type="number" wire:model.blur="jml_jodohkan"
                                                    id="jml_jodohkan" class="form-control">
                                                @error('jml_jodohkan')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="bobot_jodohkan">Bobot (%)</label>
                                                <input type="number" wire:model.blur="bobot_jodohkan"
                                                    id="bobot_jodohkan" class="form-control">
                                                @error('bobot_jodohkan')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header collapsed" role="button" wire:ignore.self
                                    data-toggle="collapse" data-target="#isian-singkat" aria-expanded="false">
                                    <h4>Soal Isian Singkat</h4>
                                </div>
                                <div class="accordion-body collapse" wire:ignore.self id="isian-singkat"
                                    data-parent="#accordion" style="">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jml_isian">Jumlah Soal</label>
                                                <input type="number" wire:model.blur="jml_isian" id="jml_isian"
                                                    class="form-control">
                                                @error('jml_isian')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="bobot_isian">Bobot (%)</label>
                                                <input type="number" wire:model.blur="bobot_isian" id="bobot_isian"
                                                    class="form-control">
                                                @error('bobot_isian')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header collapsed" role="button" wire:ignore.self
                                    data-toggle="collapse" data-target="#uraian-esai" aria-expanded="false">
                                    <h4>Soal Uraian/Esai</h4>
                                </div>
                                <div class="accordion-body collapse" wire:ignore.self id="uraian-esai"
                                    data-parent="#accordion" style="">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jml_esai">Jumlah Soal</label>
                                                <input type="number" wire:model.blur="jml_esai" id="jml_esai"
                                                    class="form-control">
                                                @error('jml_esai')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="bobot_esai">Bobot (%)</label>
                                                <input type="number" wire:model.blur="bobot_esai" id="bobot_esai"
                                                    class="form-control">
                                                @error('bobot_esai')
                                                    <small class='text-danger'>{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
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
        window.addEventListener('swal:replicatedConfirm', event => {
            Swal.fire({
                title: event.detail[0].message,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('replicate')
                }
            })
        })
    </script>
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
                    var id = $(this).attr('id');
                    var data = $(this).select2("val");
                    @this.set(id, data);
                });

                $('#id_guru').select2();
                $('#id_guru').on('change', function(e) {
                    var id = $(this).attr('id');
                    var data = $(this).select2("val");
                    @this.set(id, data);
                });

                $('#id_level').select2();
                $('#id_level').on('change', function(e) {
                    var id = $(this).attr('id');
                    var data = $(this).select2("val");
                    @this.set(id, data);
                });

                $('#id_kelas').select2();
                $('#id_kelas').on('change', function(e) {
                    var id = $(this).attr('id');
                    var data = $(this).select2("val");
                    @this.set(id, data);
                });
            });
        })
    </script>
@endpush
