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
                                    <option value="all" @if (is_array($id_kelas) && !empty($id_kelas) && array_diff($id_kelas, ['all'])) disabled @endif>Semua Kelas
                                    </option>
                                    @foreach ($kelass as $kelas)
                                        <optgroup label="{{ $kelas->level }}">
                                            <option value="{{ $kelas->id }}">{{ $kelas->level }} -
                                                {{ $kelas->kode_kelas }}</option>
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
