<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Kelas Rombel</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Kelas Rombel</h3>
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
                                    <th class="text-center" width="12%">Nama Kelas</th>
                                    <th class="text-center" width="12%">Kode Kelas</th>
                                    <th width="30%">Jurusan</th>
                                    <th class="text-center">Wali Kelas</th>
                                    <th>Jumlah Siswa</th>
                                    <th class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data->groupBy('level') as $row)
                                    <tr>
                                        <td class="tw-text-base" colspan="7"> <b>Kelas: {{ $row[0]['level'] }}</b>
                                        </td>
                                    </tr>
                                    @foreach ($row as $result)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td class="text-center">{{ $result['nama_kelas'] }}</td>
                                            <td class="text-center">{{ $result['kode_kelas'] }}</td>
                                            <td>{{ $result['nama_jurusan'] }}</td>
                                            <td class="text-center">...</td>
                                            <td class="text-center">{{ $result['jumlah_siswa'] }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-primary"
                                                    href="{{ route('kelas-rombel-edit', $result['id']) }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button wire:click.prevent="deleteConfirm({{ $result['id'] }})"
                                                    class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
        <button class="btn-modal" data-toggle="modal" data-backdrop="static" data-keyboard="false"
            data-target="#formDataModal">
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
                                    <label for="nama_kelas">Nama Kelas</label>
                                    <input type="text" wire:model="nama_kelas" id="nama_kelas" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="kode_kelas">Kode Kelas</label>
                                    <input type="text" wire:model="kode_kelas" id="kode_kelas" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_jurusan">Jurusan</label>
                                    <select wire:model="id_jurusan" id="id_jurusan" class="form-control">
                                        <option value="" disabled>-- Opsi Pilihan --</option>
                                        @foreach ($jurusans as $jurusan)
                                            <option value="{{ $jurusan->id }}">{{ $jurusan->nama_jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="id_level">Level</label>
                                    <select wire:model="id_level" id="id_level" class="form-control">
                                        <option value="" disabled>-- Opsi Pilihan --</option>
                                        @foreach ($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Daftar Siswa</label>
                            {{-- {{ json_encode($id_siswa, JSON_PRETTY_PRINT) }} --}}
                            <div wire:ignore>
                                <select multiple="multiple" id="my-select-searchable" wire:model="id_siswa">
                                    @foreach ($siswas as $siswa)
                                        <option value='{{ $siswa->id }}'>{{ $siswa->nisn }} -
                                            {{ $siswa->nama_siswa }}</option>
                                    @endforeach
                                </select>
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
    <link rel="stylesheet" href="{{ asset('assets/multiselect/css/multi-select.css') }}">
@endpush

@push('js-libraries')
    <script src="{{ asset('assets/multiselect/js/jquery.quicksearch.js') }}"></script>
    <script src="{{ asset('assets/multiselect/js/jquery.multi-select.js') }}"></script>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            let data = [];

            $('#my-select-searchable').multiSelect({
                selectableHeader: "<div class='custom-header mb-2 tw-text-xs'>Semua Siswa</div><input type='text' class='search-input form-control mb-2' autocomplete='off' placeholder='Search here...'>",
                selectionHeader: "<div class='custom-header mb-2 tw-text-xs'>Jumlah Siswa: <span id='selected-count'>0</span></div><input type='text' class='search-input form-control mb-2' autocomplete='off' placeholder='Search here...'>",
                afterInit: function(ms) {
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#' + that.$container.attr('id') +
                        ' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e) {
                            if (e.which === 40) {
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e) {
                            if (e.which == 40) {
                                that.$selectionUl.focus();
                                return false;
                            }
                        });

                    that.$container.addClass('w-auto');
                },
                afterSelect: function(values) {
                    this.qs1.cache();
                    this.qs2.cache();
                    $('#selected-count').text(countList);
                    updateSelectedCount(values, 'select');
                },
                afterDeselect: function(values) {
                    this.qs1.cache();
                    this.qs2.cache();
                    $('#selected-count').text(countList);
                    updateSelectedCount(values, 'deselect');
                }
            });

            function updateSelectedCount(values, method) {
                if (method === "select") {
                    data.push(values);
                } else if (method === "deselect") {
                    var indexToRemove = data.findIndex(item => JSON.stringify(item) === JSON.stringify(values));
                    if (indexToRemove !== -1) {
                        data.splice(indexToRemove, 1);
                    }
                }

                @this.set('id_siswa', data)
            }

            function countList() {
                var len = $('#my-select-searchable option:selected').length;
                @this.set('jumlah_siswa', len)
                return len
            }

            window.addEventListener('reloadPage', event => {
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            })
        });
    </script>
@endpush
