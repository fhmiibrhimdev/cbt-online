<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Pengaturan Siswa</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="tw-flex tw-ml-6 tw-mt-6 tw-mb-5 lg:tw-mb-1">
                    <h3 class="tw-tracking-wider tw-text-[#34395e]  tw-text-base tw-font-semibold">Table Pengaturan Siswa
                    </h3>
                    <div class="ml-auto">
                        <button wire:click.prevent="statusAll('1')" class="btn btn-primary ml-auto mr-2"
                            @disabled(count($data) == 0)><i class="fas fa-check mr-2"></i>AKTIFKAN
                            SEMUA</button>
                        <button wire:click.prevent="statusAll('0')" class="btn btn-danger ml-auto mr-3"
                            @disabled(count($data) == 0)><i class="fas fa-ban mr-2"></i>NONAKTIFKAN
                            SEMUA</button>
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
                                    <th width="10%" class="text-center">Status</th>
                                    <th width="30%">Email</th>
                                    <th width="60%">Name User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td class="text-center">
                                            <div class="mt-1">
                                                @if ($row->active == '1')
                                                    <button wire:click.prevent="status({{ $row->id }}, '0')">
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </button>
                                                @else
                                                    <button wire:click.prevent="status({{ $row->id }}, '1')">
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $row->email }}</td>
                                        <td>{{ $row->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Not data available in the table</td>
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
    </section>
</div>
