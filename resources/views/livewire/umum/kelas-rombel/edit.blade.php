<div>
    <section class="section custom-section">
        <div class="section-header">
            <a href="{{ url('umum/kelas-rombel') }}" class="btn btn-muted">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1>Kelas Rombel Edit</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body p-4">
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
                        <div wire:ignore>
                            <select multiple="multiple" id="my-select-searchable" wire:model="id_siswa">
                                @foreach ($siswas as $siswa)
                                @if ($siswa->status_kelas == '0')
                                <option value='{{ $siswa->id }}'>{{ $siswa->nisn }} - {{ $siswa->nama_siswa }}</option>
                                @endif
                                @if ($siswa->id_kelas == $dataId)
                                <option value='{{ $siswa->id }}'>{{ $siswa->nisn }} - {{ $siswa->nama_siswa }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="float-right">
                        <button @if($jumlah_siswa == "0") disabled @endif type="submit" wire:click.prevent="update()"
                            wire:loading.attr="disabled" class="btn btn-primary tw-bg-blue-500">Save Data</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    $(document).ready(function () {
        let data = {!! json_encode(array_map(fn($id) => [$id], $id_siswa)) !!};

        $('#my-select-searchable').multiSelect({
            selectableHeader: "<div class='custom-header mb-2 tw-text-xs'>Semua Siswa</div><input type='text' class='search-input form-control mb-2' autocomplete='off' placeholder='Search here...'>",
            selectionHeader: "<div class='custom-header mb-2 tw-text-xs'>Jumlah Siswa: <span id='selected-count'>0</span></div><input type='text' class='search-input form-control mb-2' autocomplete='off' placeholder='Search here...'>",
            afterInit: function(ms) {
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

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

                $('#selected-count').text(countList);
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

        window.addEventListener('setSelectedValues', event => {
            let selectedValues = event.detail.id_siswa;
            $('#my-select-searchable').multiSelect('deselect_all');
            $('#my-select-searchable').multiSelect('select', selectedValues);
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
    });
</script>
@endpush
