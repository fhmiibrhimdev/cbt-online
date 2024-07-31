<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Jurusan</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Jurusan</h3>
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
                                    <th width="10%" class="text-center">Kode</th>
                                    <th width="30%">Jurusan</th>
                                    <th width="40%">Mapel Peminatan</th>
                                    <th class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td class="text-center">{{ $row->kode_jurusan }}</td>
                                        <td>{{ $row->nama_jurusan }}</td>
                                        <td>
                                            @foreach($row->getMataPelajaran() as $mapel)
                                                <span class="badge badge-info">{{ $mapel->nama_mapel }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            <button wire:click.prevent="edit({{ $row->id }})"
                                                class="btn btn-primary" data-toggle="modal"
                                                data-target="#formDataModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click.prevent="deleteConfirm({{ $row->id }})"
                                                class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Not data available in the table</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mt-5 px-3">
                        {{ $data->links() }}
                    </div> --}}
                </div>
            </div>
        </div>
        <button wire:click.prevent="isEditingMode(false)" class="btn-modal" data-toggle="modal" data-backdrop="static"
            data-keyboard="false" data-target="#formDataModal">
            <i class="far fa-plus"></i>
        </button>
    </section>
    <div class="modal fade" id="formDataModal" aria-labelledby="formDataModalLabel" aria-hidden="true" wire:ignore.self>
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
                        <div class="form-group">
                            <label for="kode_jurusan">Kode Jurusan</label>
                            <input type="text" wire:model.live="kode_jurusan" id="kode_jurusan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="nama_jurusan">Nama Jurusan</label>
                            <input type="text" wire:model="nama_jurusan" id="nama_jurusan" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="mapel_peminatan">Mapel Peminatan</label>
                            <div wire:ignore>
                                <select multiple wire:model.live="mapel_peminatan" id="mapel_peminatan" class="form-control">
                                    <optgroup label="Kelompok C">
                                        @foreach ($kelompok_c as $c)
                                        <option value="{{ $c->id }}">{{ $c->nama_mapel }}</option>
                                        @endforeach
                                    </optgroup>
                                    @foreach ($kelompoks->groupBy('kode_kelompok') as $kelompok)
                                    <optgroup label="{{ $kelompok[0]['nama_kelompok'] }}">
                                        @foreach ($kelompok as $rowkelompok)
                                        <option value="{{ $rowkelompok['id'] }}" @if (in_array($rowkelompok['id'], $mapel_peminatan)) {{ 'selected' }} @endif>{{ $rowkelompok['nama_mapel'] }}</option>
                                        @endforeach
                                    </optgroup>
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
<link href="{{ asset('assets/midragon/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('js-libraries')
<script src="{{ asset('/assets/midragon/select2/select2.full.min.js') }}"></script>
@endpush

@push('scripts')
<script>
    window.addEventListener('initSelect2', event => {
        $(document).ready(function() {
            $('#mapel_peminatan').select2();
            
            $('#mapel_peminatan').on('change', function(e) {
                var data = $('#mapel_peminatan').select2("val");
                @this.set('mapel_peminatan', data);
            });
        });
    })

    window.addEventListener('resetSelect2', event => {
        $('#mapel_peminatan').select2().val("").trigger('change');
    });
</script>
@endpush