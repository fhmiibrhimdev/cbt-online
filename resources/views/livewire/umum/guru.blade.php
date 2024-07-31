<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Guru</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="show-entries lg:tw-mt-[-10px]">
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
                    <div class="search-column lg:tw-mt-[-35px] lg:tw-mb-[-10px]">
                        <p>Search: </p><input type="search" wire:model.live.debounce.750ms="searchTerm"
                            id="search-data" placeholder="Search here..." class="form-control" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($data->groupBy('nip') as $row)
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <div class="flex">
                                    <div>
                                        <img src="https://www.svgrepo.com/show/335455/profile-default.svg"
                                            alt="" class="tw-w-16 tw-h-16 tw-rounded-full">
                                    </div>
                                    <div class="ml-3">
                                        <p class="tw-text-xs">{{ $row[0]['nip'] }}</p>
                                        <p class="tw-text-gray-700 tw-font-semibold">{{ $row[0]['nama_guru'] }}</p>
                                        <p class="tw-text-xs">{{ $row[0]['nama_level'] }}@if ($row[0]['walikelas'] != '')
                                                : {{ $row[0]['walikelas'] }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="card-header-action ml-auto">
                                    <a data-collapse="#mycard-collapse-{{ $loop->index }}"
                                        class="btn btn-icon btn-secondary" href="#" wire:ignore.self>
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="collapse px-4 pb-3 pt-2" id="mycard-collapse-{{ $loop->index }}"
                                wire:ignore.self>
                                <p class="tw-text-gray-700 tw-font-semibold">Pengampu :</p>
                                @foreach ($data->where('id', $row[0]['id'])->groupBy('nama_mapel') as $mapel => $groupedData)
                                    <div class="mt-3">
                                        <p class="tw-text-gray-700 tw-font-semibold tw-text-xs">#
                                            {{ substr($mapel, 0, 39) }}: </p>
                                        @foreach ($groupedData as $mapelData)
                                            <div
                                                class="mr-1 mt-2 tw-bg-purple-50 tw-text-xs tw-tracking-wide tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold tw-inline-flex">
                                                <span class="tw-text-gray-600">{{ $mapelData->level }} -</span>
                                                {{ $mapelData->kelas_ngajar }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                                <div class="mt-3 tw-flex tw-justify-end">
                                    <button wire:click.prevent="edit({{ $row[0]['id'] }})" class="btn btn-primary mr-1"
                                        data-toggle="modal" data-target="#formDataModal"><i
                                            class="fas fa-edit"></i></button>
                                    <button wire:click.prevent="deleteConfirm({{ $row[0]['id'] }})"
                                        class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card">
                <div class="card-body px-4 py-3">
                    {{ $data->links() }}
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
                        @if (!$isEditing)
                            <div class="form-group">
                                <label for="kode_guru">Kode Guru</label>
                                <input type="text" wire:model="kode_guru" id="kode_guru" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="number" wire:model="nip" id="nip" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nama_guru">Nama Guru</label>
                                <input type="text" wire:model="nama_guru" id="nama_guru" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" wire:model="email" id="email" class="form-control">
                            </div>
                        @else
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile"
                                        role="tab" aria-controls="home" aria-selected="true"
                                        wire:ignore.self>Profile</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="data-lengkap-tab" data-toggle="tab" href="#data-lengkap"
                                        role="tab" aria-controls="profile" aria-selected="false"
                                        wire:ignore.self>Data Lengkap</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="jabatan-tab" data-toggle="tab" href="#jabatan"
                                        role="tab" aria-controls="contact" aria-selected="false"
                                        wire:ignore.self>Jabatan</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel"
                                    aria-labelledby="profile-tab" wire:ignore.self>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nama_guru">Nama Lengkap</label>
                                                <input type="text" wire:model="nama_guru" id="nama_guru"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" wire:model="email" id="email"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nip">NIP</label>
                                                <input type="number" wire:model="nip" id="nip"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="no_hp">No. Handphone</label>
                                                <input type="number" wire:model="no_hp" id="no_hp"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jk">Jenis Kelamin</label>
                                                <div wire:ignore>
                                                    <select wire:model="jk" id="jk" class="form-control">
                                                        <option value="" disabled>-- Opsi Pilihan --</option>
                                                        <option value="L">Laki-Laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="agama">Agama</label>
                                                <div wire:ignore>
                                                    <select wire:model="agama" id="agama" class="form-control">
                                                        <option value="" disabled>-- Opsi Pilihan --</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Kristen">Kristen</option>
                                                        <option value="Katolik">Katolik</option>
                                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Budha">Budha</option>
                                                        <option value="Konghucu">Konghucu</option>
                                                        <option value="Lainnya">Lainnya</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="data-lengkap" role="tabpanel"
                                    aria-labelledby="data-lengkap-tab" wire:ignore.self>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="kode_guru">Kode Guru</label>
                                                <input type="text" wire:model="kode_guru" id="kode_guru"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="no_ktp">No. KTP</label>
                                                <input type="number" wire:model="no_ktp" id="no_ktp"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="tempat_lahir">Tempat Lahir</label>
                                                <input type="text" wire:model="tempat_lahir" id="tempat_lahir"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="tgl_lahir">Tgl. Lahir</label>
                                                <input type="date" wire:model="tgl_lahir" id="tgl_lahir"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea wire:model="alamat" id="alamat" class="form-control" style="height: 70px !important;"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="rt">RT</label>
                                                <input type="number" wire:model="rt" id="rt"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="rw">RW</label>
                                                <input type="number" wire:model="rw" id="rw"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="kode_pos">Kode Pos</label>
                                                <input type="number" wire:model="kode_pos" id="kode_pos"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="kelurahan_desa">Kelurahan/Desa</label>
                                                <input type="text" wire:model="kelurahan_desa" id="kelurahan_desa"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="kecamatan">Kecamatan</label>
                                                <input type="text" wire:model="kecamatan" id="kecamatan"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="kabupaten_kota">Kabupaten/Kota</label>
                                                <input type="text" wire:model="kabupaten_kota" id="kabupaten_kota"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="kewarganegaraan">Kewarganegaraan</label>
                                                <div wire:ignore>
                                                    <select wire:model="kewarganegaraan" id="kewarganegaraan"
                                                        class="form-control">
                                                        <option value="" disabled>-- Opsi Pilihan --</option>
                                                        <option value="WNI">Warga Negara Indonesia</option>
                                                        <option value="WNA">Warga Negara Asing</option>
                                                        <option value="DK">Dua Kewarganegaraan</option>
                                                        <option value="TK">Tanpa Kewarganegaraan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="status_nikah">Status Nikah</label>
                                                <div wire:ignore>
                                                    <select wire:model="status_nikah" id="status_nikah"
                                                        class="form-control">
                                                        <option value="" disabled>-- Opsi Pilihan --</option>
                                                        <option value="Sudah">Sudah Menikah</option>
                                                        <option value="Belum">Belum Menikah</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="jabatan" role="tabpanel"
                                    aria-labelledby="jabatan-tab" wire:ignore.self>
                                    <div
                                        class="tw-px-2 tw-py-1 tw-bg-purple-50 tw-text-purple-500 tw-rounded-lg tw-inline-flex tw-font-semibold">
                                        # Jabatan</div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="id_jabatan">Jabatan</label>
                                                <div wire:ignore>
                                                    <select wire:model.live="id_jabatan" id="id_jabatan"
                                                        class="form-control">
                                                        <option value="0" disabled>-- Opsi Pilihan --</option>
                                                        @foreach ($level_guru as $level)
                                                            <option value="{{ $level->id }}">{{ $level->level }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div
                                                class="form-group @if ($id_jabatan == '4') tw-block @else tw-hidden @endif">
                                                <label for="id_kelas">Kelas</label>
                                                <div wire:ignore>
                                                    <select wire:model.live="id_kelas" id="id_kelas"
                                                        class="form-control">
                                                        <option value="0" disabled>-- Opsi Pilihan --</option>
                                                        @foreach ($kelas as $kela)
                                                            <optgroup label="{{ $kela->level }}">
                                                                <option value="{{ $kela->id }}">
                                                                    {{ $kela->kode_kelas }}</option>
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                    <div
                                        class="mt-3 tw-px-2 tw-py-1 tw-bg-yellow-50 tw-text-yellow-500 tw-rounded-lg tw-inline-flex tw-font-semibold">
                                        # Mengajar</div>
                                    {{-- @json($id_mapel) --}}
                                    <div class="form-group">
                                        <label for="id_mapel_select2">Mata Pelajaran</label>
                                        <div wire:ignore>
                                            <select multiple wire:model="id_mapel" id="id_mapel_select2"
                                                class="form-control">
                                                @foreach ($mapels as $mapel)
                                                    <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group">
                                    <label for="ekstrakurikuler">Ekstrakurikuler</label>
                                    <select wire:model="ekstrakurikuler" id="ekstrakurikuler" class="form-control">
                                        <option value=""></option>
                                    </select>
                                </div> --}}

                                    <hr>
                                    <div
                                        class="mt-3 tw-px-2 tw-py-1 tw-bg-green-50 tw-text-green-500 tw-rounded-lg tw-inline-flex tw-font-semibold">
                                        # Tentukan Kelas Mapel</div>
                                    {{-- @json($id_mapel_kelas) --}}
                                    @foreach ($mapels as $mapel)
                                        @if (!empty($id_mapel) && in_array((string) $mapel->id, $id_mapel))
                                            <div class="form-group">
                                                <label
                                                    for="id_mapel_kelas_{{ $mapel->id }}">{{ $mapel->nama_mapel }}</label>
                                                <div wire:ignore>
                                                    <select wire:model="id_mapel_kelas.{{ $mapel->id }}"
                                                        id="id_mapel_kelas_{{ $mapel->id }}" class="form-control"
                                                        multiple>
                                                        @foreach ($kelas as $kela)
                                                            <optgroup label="{{ $kela->level }}">
                                                                <option value="{{ $kela->id }}">
                                                                    {{ $kela->kode_kelas }}</option>
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
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
                $('#id_kelas').select2();
                $('#id_kelas').on('change', function(e) {
                    var id = $(this).attr('id');
                    var data = $(this).select2("val");
                    @this.set(id, data);
                });

                $('#id_jabatan').select2();
                $('#id_jabatan').on('change', function(e) {
                    var id = $(this).attr('id');
                    var data = $(this).select2("val");
                    @this.set(id, data);
                });

                $('#id_mapel_select2').select2();
                $('#id_mapel_select2').on('change', function(e) {
                    var data = $(this).select2("val");
                    @this.set('id_mapel', data);
                });

                $('[id^=id_mapel_kelas_]').each(function() {
                    $(this).select2();
                    $(this).on('change', function(e) {
                        let mapelId = $(this).attr('id').split('_').pop();
                        let data = $(this).val();
                        @this.set('id_mapel_kelas.' + mapelId, data);
                    });
                });
            });
        })
    </script>
@endpush
