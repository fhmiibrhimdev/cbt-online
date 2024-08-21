<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Siswa</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="tw-flex tw-ml-6 tw-mt-6 lg:tw-mb-1">
                    <h3 class="tw-tracking-wider  tw-text-base tw-text-[#34395e] tw-font-semibold">
                        Table Siswa</h3>
                    <div class="show-entries ml-auto mr-3 tw-mt-[-5px]">
                        <p class="show-entries-show">Filter</p>
                        <select wire:model.live="filter">
                            <option value="1">Aktif</option>
                            <option value="2">Tanpa Kelas</option>
                        </select>
                    </div>
                </div>
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
                                    <th width="18%" class="text-center">Nis / Nisn</th>
                                    <th width="40%">Nama & Jurusan</th>
                                    <th width="8%" class="text-center">JK</th>
                                    <th width="12%" class="text-center">Progress</th>
                                    <th class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td class="text-center">{{ $row->nis }} / {{ $row->nisn }}</td>
                                        <td><span
                                                class="badge badge-primary">{{ $row->level }}-{{ $row->nama_kelas }}</span>
                                            -
                                            {{ Str::limit($row->nama_siswa, 27) }}</td>
                                        <td class="text-center">L</td>
                                        <td class="text-center">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                    data-width="{{ $row->getCompletionPercentage() }}"
                                                    aria-valuenow="{{ $row->getCompletionPercentage() }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: {{ $row->getCompletionPercentage() }}%;">
                                                    {{ $row->getCompletionPercentage() }}%</div>
                                            </div>
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
                        @if ($isEditing)
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="siswa-tab" data-toggle="tab" href="#siswa"
                                        role="tab" aria-controls="siswa" aria-selected="true">Siswa</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="detail-tab" data-toggle="tab" href="#detail"
                                        role="tab" aria-controls="detail" aria-selected="false">Detail</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="keluarga-tab" data-toggle="tab" href="#keluarga"
                                        role="tab" aria-controls="keluarga" aria-selected="false">Keluarga</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="wali-tab" data-toggle="tab" href="#wali"
                                        role="tab" aria-controls="wali" aria-selected="false">Wali</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade active show" id="siswa" role="tabpanel"
                                    aria-labelledby="siswa-tab">
                                    <div class="form-group">
                                        <label for="nama_siswa">Nama Siswa</label>
                                        <input type="text" wire:model="nama_siswa" id="nama_siswa"
                                            class="form-control">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nis">NIS</label>
                                                <input type="number" wire:model="nis" id="nis"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nisn">NISN</label>
                                                <input type="number" wire:model="nisn" id="nisn"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jk">Jenis Kelamin</label>
                                                <select wire:model="jk" id="jk" class="form-control">
                                                    <option value="" disabled>-- Opsi Pilihan--</option>
                                                    <option value="L">Pria</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="kelas">Kelas</label>
                                                <select wire:model="kelas" id="kelas" class="form-control">
                                                    <option value="" disabled>-- Opsi Pilihan--</option>
                                                    @for ($i = 1; $i <= 13; $i++)
                                                        <option value="{{ $i }}">Kelas {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tahun_masuk">Tahun Masuk</label>
                                        <input type="date" wire:model="tahun_masuk" id="tahun_masuk"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="sekolah_asal">Sekolah Asal</label>
                                        <input type="text" wire:model="sekolah_asal" id="sekolah_asal"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select wire:model="status" id="status" class="form-control">
                                            <option value="" disabled>-- Opsi Pilihan --</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Lulus">Lulus</option>
                                            <option value="Pindah">Pindah</option>
                                            <option value="Keluar">Keluar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="detail" role="tabpanel"
                                    aria-labelledby="detail-tab">
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tempat_lahir">Tempat Lahir</label>
                                                    <input type="text" wire:model="tempat_lahir" id="tempat_lahir"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                                    <input type="date" wire:model="tgl_lahir" id="tgl_lahir"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="agama">Agama</label>
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
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea wire:model="alamat" id="alamat" class="form-control" style="height: 100px !important;"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="rt">RT</label>
                                                    <input type="text" wire:model="rt" id="rt"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="rw">RW</label>
                                                    <input type="text" wire:model="rw" id="rw"
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
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="kelurahan_desa">Kelurahan / Desa</label>
                                                    <input type="text" wire:model="kelurahan_desa"
                                                        id="kelurahan_desa" class="form-control">
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
                                                    <label for="kabupaten_kota">Kabupaten / Kota</label>
                                                    <input type="text" wire:model="kabupaten_kota"
                                                        id="kabupaten_kota" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="no_hp">No Hp</label>
                                            <input type="number" wire:model="no_hp" id="no_hp"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="keluarga" role="tabpanel"
                                    aria-labelledby="keluarga-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="status_keluarga">Status Keluarga</label>
                                                <select wire:model="status_keluarga" id="status_keluarga"
                                                    class="form-control">
                                                    <option value="" disabled>-- Opsi Pilihan --</option>
                                                    <option value="Anak Kandung">Anak Kandung</option>
                                                    <option value="Anak Tiri">Anak Tiri</option>
                                                    <option value="Anak Angkat">Anak Angkat</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="anak_ke">Anak Ke</label>
                                                <input type="number" wire:model="anak_ke" id="anak_ke"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nama_ayah">Nama Ayah</label>
                                                <input type="text" wire:model="nama_ayah" id="nama_ayah"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nama_ibu">Nama Ibu</label>
                                                <input type="text" wire:model="nama_ibu" id="nama_ibu"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                                                <input type="text" wire:model="pekerjaan_ayah" id="pekerjaan_ayah"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                                                <input type="text" wire:model="pekerjaan_ibu" id="pekerjaan_ibu"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="alamat_ayah">Alamat Ayah</label>
                                                <textarea wire:model="alamat_ayah" id="alamat_ayah" class="form-control" style="height: 100px !important;"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="alamat_ibu">Alamat Ibu</label>
                                                <textarea wire:model="alamat_ibu" id="alamat_ibu" class="form-control" style="height: 100px !important;"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nohp_ayah">Nomor HP Ayah</label>
                                                <input type="number" wire:model="nohp_ayah" id="nohp_ayah"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nohp_ibu">Nomor HP Ibu</label>
                                                <input type="number" wire:model="nohp_ibu" id="nohp_ibu"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="wali" role="tabpanel"
                                    aria-labelledby="wali-tab">
                                    <div>
                                        <div class="form-group">
                                            <label for="nama_wali">Nama Wali</label>
                                            <input type="text" wire:model="nama_wali" id="nama_wali"
                                                class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="pekerjaan_wali">Pekerjaan Wali</label>
                                            <input type="text" wire:model="pekerjaan_wali" id="pekerjaan_wali"
                                                class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat_wali">Alamat Wali</label>
                                            <textarea wire:model="alamat_wali" id="alamat_wali" class="form-control" style="height: 100px !important;"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="nohp_wali">No Hp Wali</label>
                                            <input type="number" wire:model="nohp_wali" id="nohp_wali"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tahun_masuk">Tahun Masuk</label>
                                        <input type="date" wire:model="tahun_masuk" id="tahun_masuk"
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="tgl_lahir">Tanggal Lahir</label>
                                        <input type="date" wire:model="tgl_lahir" id="tgl_lahir"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa</label>
                                <input type="text" wire:model="nama_siswa" id="nama_siswa" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nis">NIS</label>
                                        <input type="number" wire:model="nis" id="nis" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="nisn">NISN</label>
                                        <input type="number" wire:model="nisn" id="nisn" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="jk">Jenis Kelamin</label>
                                        <select wire:model="jk" id="jk" class="form-control">
                                            <option value="" disabled>-- Opsi Pilihan--</option>
                                            <option value="L">Pria</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label>
                                        <select wire:model="kelas" id="kelas" class="form-control">
                                            <option value="" disabled>-- Opsi Pilihan--</option>
                                            @for ($i = 1; $i <= 13; $i++)
                                                <option value="{{ $i }}">Kelas {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
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
