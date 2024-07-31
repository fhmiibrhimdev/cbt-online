<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Atur Pengawas</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Pengawas Ujian</h3>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="px-4">
                                {{-- @json($jadwal) --}}
                                <div class="form-group">
                                    <label for="id_jenis_ujian">Jenis Ujian</label>
                                    <div wire:ignore>
                                        <select wire:model="id_jenis_ujian" id="id_jenis_ujian" class="form-control">
                                            <option value="" disabled>-- Pilih Jenis Ujian --</option>
                                            @foreach ($ujians as $ujian)
                                                <option value="{{ $ujian->id }}"
                                                    @if ((int) $ujian->id == (int) $id_jenis_ujian) selected @endif>
                                                    {{ $ujian->nama_jenis }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4 tw-mt-7">
                            <div class="float-right mr-4">
                                <button wire:click="store()" class="btn btn-md btn-primary ml-auto"><i
                                        class="fas fa-save"></i>
                                    Save Data</button>
                            </div>
                        </div>
                    </div>
                    {{-- <pre>{{ print_r($selectedGurus, true) }}</pre> --}}
                    {{-- <pre><code>{{ json_encode($selectedGurus, JSON_PRETTY_PRINT) }}</code></pre> --}}

                    <div class="table-responsive">
                        @forelse ($data as $jadwalItem)
                            @php
                                \Carbon\Carbon::setLocale('id');
                                $currentDate = \Carbon\Carbon::parse($jadwalItem['tgl_mulai'])->isoFormat(
                                    'dddd, D MMMM Y',
                                );
                                $isFirstRow = true;
                                $rowCount = 0;
                                foreach ($sesis as $row) {
                                    if (in_array($row->id_kelas, $jadwalItem['id_kelas'])) {
                                        $rowCount++;
                                    }
                                }

                                $groupedByRoomAndSession = $sesis
                                    ->filter(function ($row) use ($jadwalItem) {
                                        return in_array($row->id_kelas, $jadwalItem['id_kelas']);
                                    })
                                    ->groupBy('nama_ruang')
                                    ->map(function ($items) {
                                        return $items->groupBy('nama_sesi');
                                    });
                            @endphp

                            <table>
                                <thead class="tw-sticky tw-top-0">
                                    <tr class="tw-text-gray-700">
                                        <th width="15%">Hari/Tanggal</th>
                                        <th class="text-center" width="8%">Ruang</th>
                                        <th class="text-center" width="8%">Sesi</th>
                                        <th width="30%">Mata Pelajaran</th>
                                        <th>Pengawas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="tw-bg-gray-50 tw-py-3 tw-font-semibold tw-tracking-wider"
                                            colspan="5">
                                            Kode Bank:
                                            <span
                                                class="tw-text-gray-500 tw-font-medium">{{ $jadwalItem['kode_bank'] }}</span>
                                        </td>
                                    </tr>
                                    @foreach ($groupedByRoomAndSession as $roomName => $sessions)
                                        @php
                                            $isFirstRoomRow = true;
                                            $roomRowCount = collect($sessions)->flatten(1)->count();
                                        @endphp
                                        @foreach ($sessions as $sessionName => $rows)
                                            @php
                                                $isFirstSessionRow = true;
                                                $sessionRowCount = $rows->count();
                                            @endphp
                                            @foreach ($rows as $row)
                                                <tr>
                                                    @if ($isFirstRow)
                                                        <td rowspan="{{ $rowCount }}">
                                                            {{ $currentDate }}
                                                        </td>
                                                        @php $isFirstRow = false; @endphp
                                                    @endif
                                                    @if ($isFirstRoomRow)
                                                        <td class="text-center" rowspan="{{ $roomRowCount }}">
                                                            {{ $roomName }}
                                                        </td>
                                                        @php $isFirstRoomRow = false; @endphp
                                                    @endif
                                                    @if ($isFirstSessionRow)
                                                        <td class="text-center" rowspan="{{ $sessionRowCount }}">
                                                            {{ $sessionName }}
                                                        </td>
                                                        <td>{{ $jadwalItem['nama_mapel'] }}</td>
                                                        <td>
                                                            <select
                                                                wire:model="selectedGurus.{{ $jadwalItem['id'] }}.{{ $row->id_ruang }}.{{ $row->id_sesi }}"
                                                                id="id_guru_{{ $jadwalItem['id'] }}_{{ $row->id_ruang }}_{{ $row->id_sesi }}"
                                                                class="form-control" multiple>
                                                                <option value=""></option>
                                                                @foreach ($gurus as $guru)
                                                                    <option value="{{ $guru->id }}">
                                                                        {{ $guru->nama_guru }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        @php $isFirstSessionRow = false; @endphp
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        @empty
                            <table>
                                <thead class="tw-sticky tw-top-0">
                                    <tr class="tw-text-gray-700">
                                        <th width="15%">Hari/Tanggal</th>
                                        <th width="10%">Ruang</th>
                                        <th width="10%">Sesi</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Pengawas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center">No data available in the table</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforelse

                    </div>
                    <div class="mt-5 px-3">
                        {{-- {{ $data->links() }} --}}
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
        $(document).ready(function() {
            $('#kelas-toggle').on('click', function() {
                var id = $(this).data('id');
                $('#tampilkan-kelas-' + id).removeClass('tw-hidden').addClass('tw-block');
                $(this).addClass('tw-hidden');
            });
        });
    </script>
    <script>
        window.addEventListener('initSelect2', event => {
            $(document).ready(function() {
                $('#id_jenis_ujian').select2();
                $('#id_jenis_ujian').on('change', function(e) {
                    var data = $('#id_jenis_ujian').select2("val");
                    @this.set('id_jenis_ujian', data);
                });

                $('[id^=id_guru_]').each(function() {
                    $(this).select2(); // Inisialisasi Select2

                    // Tambahkan event listener untuk perubahan nilai
                    $(this).on('change', function(e) {
                        // Ambil ID dari elemen select
                        let idParts = $(this).attr('id').split('_');
                        let jadwalId = idParts[2];
                        let ruangId = idParts[3];
                        let sesiId = idParts[4];

                        // Ambil nilai yang dipilih
                        let data = $(this).val();

                        // Kirim nilai ke Livewire component
                        @this.set('selectedGurus.' + jadwalId + '.' + ruangId + '.' +
                            sesiId, data);
                    });
                });
            });
        })
    </script>
@endpush
