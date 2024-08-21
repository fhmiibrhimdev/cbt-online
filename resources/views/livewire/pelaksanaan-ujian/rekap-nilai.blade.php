<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Rekap Nilai</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Rekap Nilai</h3>
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
                                    <th width="19%">Bank Soal</th>
                                    <th width="8%" class="text-center">Jenis</th>
                                    <th width="8%" class="text-center">Mapel</th>
                                    <th width="25%">Kelas</th>
                                    <th width="30%">Pelaksanaan</th>
                                    <th width="12%" class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->kode_bank }}</td>
                                        <td class="text-center">{{ $row->kode_jenis }}</td>
                                        <td class="text-center">{{ $row->kode_mapel }}</td>
                                        <td class="tw-w-full">
                                            @foreach ($row->getKelas()->take(2) as $class)
                                                <span
                                                    class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">{{ $class->level }}-{{ $class->kode_kelas }}</span>
                                            @endforeach

                                            @if ($row->getKelas()->count() > 2)
                                                <button id="kelas-toggle" data-id="{{ $row->id }}"
                                                    class="tw-mt-2.5">
                                                    <span
                                                        class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold">...</span>
                                                </button>
                                                <span id="tampilkan-kelas-{{ $row->id }}"
                                                    class="tw-hidden tw-mt-3">
                                                    @foreach ($row->getKelas()->skip(2) as $class)
                                                        <span
                                                            class="tw-bg-purple-50 tw-text-xs tw-tracking-wider tw-text-purple-600 tw-px-2.5 tw-py-1.5 tw-rounded-lg tw-font-semibold mt-1">{{ $class->level }}-{{ $class->kode_kelas }}</span>
                                                    @endforeach
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($row->tgl_mulai)->isoFormat('D MMMM Y') }}
                                            s/d
                                            {{ \Carbon\Carbon::parse($row->tgl_selesai)->isoFormat('D MMMM Y') }}
                                        </td>
                                        <td class="text-center">
                                            @if ($row->status_final == '1')
                                                <a target="_BLANK" href="{{ route('rekap-nilai-detail', $row->id) }}"
                                                    class="btn btn-info">
                                                    DETAIL
                                                </a>
                                            @else
                                                <button wire:click.prevent="rekapNilai({{ $row->id }})"
                                                    class="btn btn-primary" data-toggle="modal"
                                                    data-target="#formDataModal">
                                                    <i class="fas fa-archive"></i> REKAP
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Not data available in the table</td>
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
    </section>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#kelas-toggle', function() {
                var id = $(this).data('id');
                $('#tampilkan-kelas-' + id).removeClass('tw-hidden').addClass('tw-block');
                $(this).addClass('tw-hidden');
            });
        });
    </script>
@endpush
