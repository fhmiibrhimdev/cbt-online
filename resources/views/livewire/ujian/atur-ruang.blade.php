<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Atur Ruang</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Atur Ruang</h3>
                {{-- @json($data) --}}
                {{-- @json($siswas) --}}
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group px-4">
                                <label for="id_kelas">Kelas</label>
                                <div wire:ignore>
                                    <select wire:model="id_kelas" id="id_kelas" class="form-control select2">
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach ($kelass as $kelas)
                                            <optgroup label="{{ $kelas->level }}">
                                                <option value="{{ $kelas->id }}">{{ $kelas->level }} -
                                                    {{ $kelas->kode_kelas }}</option>
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if ($id_kelas != '')
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="all_id_ruang">Ruang:</label>
                                    <div wire:ignore>
                                        <select wire:model="id_ruang" id="all_id_ruang" class="form-control select2">
                                            <option value="">-- Pilih Ruang --</option>
                                            @foreach ($ruangs as $ruang)
                                                <option value="{{ $ruang->id }}">{{ $ruang->kode_ruang }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group mr-3">
                                    <label for="all_id_sesi">Sesi:</label>
                                    <div wire:ignore>
                                        <select wire:model="id_sesi" id="all_id_sesi" class="form-control select2">
                                            <option value="">-- Pilih Sesi --</option>
                                            @foreach ($sesis as $sesi)
                                                <option value="{{ $sesi->id }}">{{ $sesi->nama_sesi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="table-responsive tw-max-h-96">
                        <table>
                            <thead class="tw-sticky tw-top-0">
                                <tr class="tw-text-gray-700">
                                    <th width="6%" class="text-center">No</th>
                                    <th width="30%">Nama Siswa</th>
                                    <th width="15%" class="text-center">Kelas</th>
                                    <th>Ruang</th>
                                    <th>Sesi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswas as $siswa)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td>{{ $siswa->nama_siswa }}</td>
                                        <td class="text-center">{{ $siswa->level }} - {{ $siswa->kode_kelas }}</td>
                                        <td>
                                            <div wire:ignore>
                                                <select wire:model="data.{{ $siswa->id }}.id_ruang"
                                                    id="id_ruang_{{ $siswa->id }}" class="form-control">
                                                    <option value="0">-- Pilih Ruang --</option>
                                                    @foreach ($ruangs as $ruang)
                                                        <option value="{{ $ruang->id }}">{{ $ruang->kode_ruang }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div wire:ignore>
                                                <select wire:model="data.{{ $siswa->id }}.id_sesi"
                                                    id="id_sesi_{{ $siswa->id }}" class="form-control">
                                                    <option value="0">-- Pilih Sesi --</option>
                                                    @foreach ($sesis as $sesi)
                                                        <option value="{{ $sesi->id }}">{{ $sesi->nama_sesi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                    @if ($id_kelas != '')
                        <div class="float-right mr-3 mt-3">
                            <button wire:click.prevent="store()" class="btn btn-primary">Save Data</button>
                        </div>
                    @endif
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
                    @this.set(id, data);
                    window.location.href = "{{ url('/ujian/atur-ruang') }}" + "/" + data
                });

                $('#all_id_ruang').select2();
                $('#all_id_ruang').on('change', function(e) {
                    var data = $(this).val();
                    @this.set('id_ruang', data);
                });

                $('#all_id_sesi').select2();
                $('#all_id_sesi').on('change', function(e) {
                    var data = $(this).val();
                    @this.set('id_sesi', data);
                });

                $('[id^=id_ruang_]').each(function() {
                    $(this).select2();
                    $(this).on('change', function(e) {
                        var id = $(this).attr('id').split('_').pop();
                        var data = $(this).val();
                        @this.set('data.' + id + '.id_ruang', data);
                    });
                });

                $('[id^=id_sesi_]').each(function() {
                    $(this).select2();
                    $(this).on('change', function(e) {
                        var data = $(this).val();
                        var id = $(this).attr('id').split('_').pop();
                        @this.set('data.' + id + '.id_sesi', data);
                    });
                });
            });
        });
    </script>
@endpush
