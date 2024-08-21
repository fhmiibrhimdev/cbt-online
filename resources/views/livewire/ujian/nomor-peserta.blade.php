<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Nomor Peserta</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Nomor Peserta</h3>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group px-4">
                                <label for="id_kelas">Kelas </label>
                                <select wire:model.live="id_kelas" id="id_kelas" class="form-control" multiple>
                                    <option value="" disabled>-- Pilih Kelas --</option>
                                    @foreach ($kelass as $level => $kelasGroup)
                                        <optgroup label="{{ $level }}">
                                            <option value="all_{{ $kelasGroup->first()->id_level }}">
                                                Semua Kelas ( {{ $level }} )
                                            </option>
                                            @foreach ($kelasGroup as $kelasItem)
                                                <option value="{{ $kelasItem->id }}"
                                                    @if (in_array($kelasItem->id, $kelasDisabled)) disabled @endif>
                                                    {{ $level }}-{{ $kelasItem->kode_kelas }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">Aksi Kelas Terpilih</label>
                                <button wire:click="generateNomorPeserta()"
                                    class="btn btn-lg btn-outline-primary form-control"
                                    @if ($id_kelas == []) disabled @endif>
                                    Buat Nomor Otomatis
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="">‎</label>
                                <button wire:click="hapusNomorPeserta()"
                                    class="btn btn-lg btn-outline-danger form-control"
                                    @if ($id_kelas == []) disabled @endif>
                                    Hapus Nomor Peserta
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group mr-3">
                                <label for="">‎</label>
                                <button wire:click="store()" class="btn btn-info form-control"><i
                                        class="fas fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive tw-max-h-96">
                        <table>
                            <thead class="tw-sticky tw-top-0">
                                <tr class="tw-text-gray-700 text-center">
                                    <th width="6%">No</th>
                                    <th width="15%">Username</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>No. Peserta Ujian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswas->groupBy('level') as $siswa)
                                    <tr>
                                        <td class="tw-text-base" colspan="5"> <b>Kelas: {{ $siswa[0]['level'] }}</b>
                                        </td>
                                    </tr>
                                    @foreach ($siswa as $row)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td class="tw-py-3 text-center">{{ $row['email'] }}</td>
                                            <td class="tw-py-3">{{ $row['nama_siswa'] }}</td>
                                            <td class="tw-py-3 text-center">{{ $row['level'] }} -
                                                {{ $row['kode_kelas'] }}
                                            </td>
                                            <td class="tw-py-3 text-center">{{ $row['nomor_peserta'] ?? '' }}</td>
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
                </div>
            </div>
            <button wire:click.prevent="" class="btn-modal" data-toggle="modal" data-backdrop="static"
                data-keyboard="false" data-target="#formDataModal">
                <i class="far fa-edit"></i>
            </button>
        </div>
    </section>
    <div class="modal fade" wire:ignore.self id="formDataModal" aria-labelledby="formDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-body">
                        <p class="mb-3 mt-2 tw-font-semibold tw-text-base tw-text-[#34395e]">Bentuk Format:
                            {{ $kode_jenjang }}-{{ $kode_tahun }}-{{ $kode_provinsi }}-{{ $kode_kota }}-{{ $kode_sekolah }}-XXXX-X
                        </p>
                        <div class="form-group">
                            <label for="kode_jenjang">Kode Jenjang<small class="text-danger"> *(A) </small></label>
                            <select wire:model="kode_jenjang" id="kode_jenjang" class="form-control">
                                @foreach (['0' => '-- Pilih Kode Jenjang --', '1' => 'SD/MI', '2' => 'SMP/MTS', '3' => 'SMA/MA', '4' => 'SMK', 'A' => 'PAKET A', 'B' => 'PAKET B', 'C' => 'PAKET C'] as $value => $label)
                                    <option value="{{ $value }}"
                                        @if ($kode_jenjang == $value) selected @endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kode_tahun">Kode Tahun <small class="text-danger">*(BB)</small></label>
                            <input type="text" wire:model="kode_tahun" id="kode_tahun" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="kode_provinsi">Kode Provinsi <small class="text-danger">*(CC)</small></label>
                            <input type="text" wire:model="kode_provinsi" id="kode_provinsi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="kode_kota">Kode Kota/Kab <small class="text-danger">*(XX)</small></label>
                            <input type="text" wire:model="kode_kota" id="kode_kota" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="kode_sekolah">Kode Sekolah <small class="text-danger">*(YYY)</small></label>
                            <input type="text" wire:model="kode_sekolah" id="kode_sekolah" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button type="submit" wire:click.prevent="update()" wire:loading.attr="disabled"
                            class="btn btn-primary tw-bg-blue-500">Save Data</button>
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
                    @this.set(id, data)
                });
            });
        });
    </script>
@endpush
