<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Tahun Pelajaran</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <h3>Tahun Pelajaran</h3>
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
                                            <th width="12%" class="text-center">No</th>
                                            <th width="50%">Tahun Pelajaran</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center"><i class="fas fa-cog"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tahun_pelajarans as $tahun_pelajaran)
                                        <tr>
                                            <td class="text-center">{{ $loop->index + 1 }}</td>
                                            <td>{{ $tahun_pelajaran->tahun }}</td>
                                            <td class="text-center">
                                                @if ($tahun_pelajaran->active == "1")
                                                <i class="fas fa-check text-success"></i> AKTIF
                                                @else
                                                <button wire:click.prevent="active({{ $tahun_pelajaran->id }}, 'tahun_pelajaran')" class="btn btn-sm btn-info">
                                                    AKTIFKAN
                                                </button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button wire:click.prevent="edit({{ $tahun_pelajaran->id }})" class="btn btn-primary" data-toggle="modal" data-target="#formDataModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button wire:click.prevent="deleteConfirm({{ $tahun_pelajaran->id }})" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
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
                                {{ $tahun_pelajarans->links() }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <h3>Semester</h3>
                        <div class="card-body">
                            <div class="table-responsive tw-max-h-96">
                                <table>
                                    <thead class="tw-sticky tw-top-0">
                                        <tr class="tw-text-gray-700">
                                            <th>Semester</th>
                                            <th class="text-center"><i class="fas fa-cog"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($semesters as $semester)
                                        <tr>
                                            <td>{{ $semester->semester }}</td>
                                            <td class="text-center">
                                            @if ($semester->active == "1")
                                                <i class="fas fa-check text-success"></i> AKTIF
                                            @else
                                            <button wire:click.prevent="active({{ $semester->id }}, 'semester')" class="btn btn-sm btn-info">
                                                AKTIFKAN
                                            </button>
                                            @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Not data available in the table</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                            <label for="tahun">Tahun</label>
                            <input type="text" wire:model="tahun" id="tahun" class="form-control">
                            @error('tahun') <small class='text-danger'>{{ $message }}</small> @enderror
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
