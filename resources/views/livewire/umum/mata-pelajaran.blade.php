<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Mata Pelajaran</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="flex">
                                <h3 class="tw-text-base tw-ml-5 tw-mb-5 tw-text-gray-800 tw-font-semibold">Kelompok Utama</h3>
                                <div class="tw-ml-auto">
                                    <button wire:click.prevent="isEditingMode(false)" class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                                    data-keyboard="false" data-target="#formDataKelompokModal">
                                        <i class="fas fa-plus-square"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive tw-max-h-96">
                                <table>
                                    <thead class="tw-sticky tw-top-0">
                                        <tr class="tw-text-gray-700">
                                            <th width="23%" class="text-center">Kategori</th>
                                            <th width="17%" class="text-center">Kode</th>
                                            <th width="35%">Nama</th>
                                            <th width="30%" class="text-center"><i class="fas fa-cog"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($kelompok_mapels as $kelompok_mapel)
                                        @if ($kelompok_mapel->id_parent == 0)
                                        <tr>
                                            <td class="text-center">{{ $kelompok_mapel->kategori }}</td>
                                            <td class="text-center">{{ $kelompok_mapel->kode_kelompok }}</td>
                                            <td>{{ $kelompok_mapel->nama_kelompok }}</td>
                                            <td class="text-center">
                                                <button wire:click.prevent="edit({{ $kelompok_mapel->id }}, 'kelompok')" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#formDataKelompokModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click.prevent="deleteConfirm({{ $kelompok_mapel->id }}, 'kelompok')" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Not data available in the table</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="flex">
                                <h3 class="tw-text-base tw-mb-5 tw-text-gray-800 tw-font-semibold">Sub Kelompok</h3>
                                <div class="tw-ml-auto tw-mr-2">
                                    <button wire:click.prevent="isEditingMode(false)" class="btn btn-primary" data-toggle="modal" data-backdrop="static"
                                    data-keyboard="false" data-target="#formDataSubKelompokModal">
                                        <i class="fas fa-plus-square"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="table-responsive tw-max-h-96">
                                <table>
                                    <thead class="tw-sticky tw-top-0">
                                        <tr class="tw-text-gray-700">
                                            <th width="15%" class="text-center">Kode</th>
                                            <th>Nama</th>
                                            <th class="text-center">Kel. Utama</th>
                                            <th class="text-center"><i class="fas fa-cog"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($kelompok_mapels as $kelompok_mapel)
                                        @if ($kelompok_mapel->id_parent > 0)
                                        <tr>
                                            <td class="text-center">{{ $kelompok_mapel->kode_kelompok }}</td>
                                            <td>{{ $kelompok_mapel->nama_kelompok }}</td>
                                            <td  class="text-center">{{ $kelompok_mapel->kategori }}</td>
                                            <td class="text-center">
                                                <button wire:click.prevent="edit({{ $kelompok_mapel->id }}, 'kelompok')" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#formDataSubKelompokModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click.prevent="deleteConfirm({{ $kelompok_mapel->id }}, 'subkelompok')" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Not data available in the table</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3>Mata Pelajaran</h3>
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
                    <div class="table-responsive">
                        <table>
                            <thead class="tw-sticky tw-top-0">
                                <tr class="tw-text-gray-700">
                                    <th width="12%" class="text-center">No. Urut</th>
                                    <th width="35%">Mata Pelajaran</th>
                                    <th class="text-center">Kode Mapel</th>
                                    <th class="text-center">Kelompok</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($data->groupBy('kode_kelompok') as $row)
                                <tr>
                                    <td class="tw-bg-gray-200 tw-font-bold" colspan="6">{{ $row[0]['nama_kelompok'] }}</td>
                                </tr>
                                @foreach ($row as $result)
                                    <tr>
                                        <td class="text-center">{{ $result['no_urut'] }}</td>
                                        <td>{{ $result['nama_mapel'] }}</td>
                                        <td class="text-center">{{ $result['kode_mapel'] }}</td>
                                        <td class="text-center">{{ $result['kode_kelompok'] }}</td>
                                        <td class="text-center">
                                            @if ($result['status'] == '1')
                                            <button wire:click.prevent="active({{ $result['id'] }}, 'nonactive')" class="btn btn-sm btn-success">
                                                AKTIF
                                            </button>
                                            @else
                                            <button wire:click.prevent="active({{ $result['id'] }}, 'active')" class="btn btn-sm btn-secondary">
                                                NONAKTIF
                                            </button>
                                            @endif
                                        <td class="text-center">
                                            <button wire:click.prevent="edit({{ $result['id'] }}, 'mapel')"
                                                class="btn btn-primary" data-toggle="modal"
                                                data-target="#formDataModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button wire:click.prevent="deleteConfirm({{ $result['id'] }}, 'mapel')"
                                                class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
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
                    <button type="button" wire:click="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="no_urut">No. Urut</label>
                            <input type="number" wire:model="no_urut" id="no_urut" class="form-control">
                            @error('no_urut') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_mapel">Nama Mapel</label>
                            <input type="text" wire:model="nama_mapel" id="nama_mapel" class="form-control">
                            @error('nama_mapel') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kode_mapel">Kode Mapel</label>
                            <input type="text" wire:model="kode_mapel" id="kode_mapel" class="form-control">
                            @error('kode_mapel') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="id_kelompok">Kelompok</label>
                            <div wire:ignore>
                                <select wire:model="id_kelompok" id="id_kelompok" class="form-control select2">
                                    <option value="" selected>-- Opsi Pilihan--</option>
                                    @foreach ($kelompok_mapels as $kelompok_mapel)
                                    <option value="{{ $kelompok_mapel->id }}">{{ $kelompok_mapel->nama_kelompok }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_kelompok') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="cancel()" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="{{ $isEditing ? 'update("mapel")' : 'store("mapel")' }}"
                            wire:loading.attr="disabled" class="btn btn-primary tw-bg-blue-500">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="formDataKelompokModal" aria-labelledby="formDataKelompokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formDataKelompokModalLabel">{{ $isEditing ? 'Edit Data' : 'Add Data' }}</h5>
                    <button type="button" wire:click="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <div wire:ignore>
                                <select wire:model.live="kategori" id="kategori" class="form-control select2">
                                    <option value="" selected>-- Opsi Pilihan --</option>
                                    <option value="WAJIB">WAJIB</option>
                                    <option value="PAI (Kemenag)">PAI (Kemenag)</option>
                                    <option value="PEMINATAN">PEMINATAN</option>
                                    <option value="AKADEMIK KEJURUAN">AKADEMIK KEJURUAN</option>
                                    <option value="LINTAS MINAT">LINTAS MINAT</option>
                                    <option value="MULOK">MULOK</option>
                                </select>
                            </div>
                            @error('kategori') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kode_kelompok">Kode Kelompok</label>
                            <input type="text" wire:model="kode_kelompok" id="kode_kelompok" class="form-control">
                            @error('kode_kelompok') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_kelompok">Nama Kelompok</label>
                            <input type="text" wire:model="nama_kelompok" id="nama_kelompok" class="form-control">
                            @error('kode_kelompok') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="cancel()" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="{{ $isEditing ? 'update("kelompok")' : 'store("kelompok")' }}"
                            wire:loading.attr="disabled" class="btn btn-primary tw-bg-blue-500">Save Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="formDataSubKelompokModal" aria-labelledby="formDataSubKelompokModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formDataSubKelompokModalLabel">{{ $isEditing ? 'Edit Data' : 'Add Data' }}</h5>
                    <button type="button" wire:click="cancel()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id_parent">Kelompok</label>
                            <div wire:ignore>
                                <select wire:model="id_parent" id="id_parent" class="form-control select2">
                                    <option value="0" selected>-- Opsi Pilihan --</option>
                                    @foreach ($kelompok_mapels as $kelompok_mapel)
                                    <option value="{{ $kelompok_mapel->id }}">{{ $kelompok_mapel->nama_kelompok }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('id_parent') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="kode_kelompok">Kode Sub Kelompok</label>
                            <input type="text" wire:model="kode_kelompok" id="kode_kelompok" class="form-control">
                            @error('kode_kelompok') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_kelompok">Nama Sub Kelompok</label>
                            <input type="text" wire:model="nama_kelompok" id="nama_kelompok" class="form-control">
                            @error('nama_kelompok') <small class='text-danger'>{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="cancel()" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="{{ $isEditing ? 'update("subkelompok")' : 'store("subkelompok")' }}"
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
            $('.select2').select2();

            $('.select2').on('change', function(e) {
                var id = $(this).attr('id');
                var data = $(this).select2("val");
                @this.set(id, data);
            });
        });
    })

    window.addEventListener('resetSelect2', event => {
        $('#kategori').select2().val("").trigger('change');
        $('#id_parent').select2().val("0").trigger('change');
    });
</script>
@endpush