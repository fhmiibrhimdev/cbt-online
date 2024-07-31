<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Example</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Table Example</h3>
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
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center"><i class="fas fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $row)
                                    <tr>
                                        <td class="text-center">{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->email }}</td>
                                        <td class="tw-font-semibold tw-text-xs tw-tracking-wide text-center">
                                            {{ $row->role_name }}
                                        </td>
                                        <td class="text-center">
                                            <button wire:click.prevent="lock({{ $row->id }})" class="btn btn-info"
                                                data-toggle="modal" data-target="#formDataModal">
                                                <i class="fas fa-lock"></i>
                                            </button>
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
                                        <td colspan="3" class="text-center">Not data available in the table</td>
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
                        @php
                            $disabled = $locked ? 'disabled' : '';
                        @endphp

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" wire:model="name" id="name" class="form-control"
                                {{ $disabled }}>
                            @error('name')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="text" wire:model="email" id="email" class="form-control"
                                {{ $disabled }}>
                            @error('email')
                                <small class='text-danger'>{{ $message }}</small>
                            @enderror
                        </div>

                        @if ($locked || !$isEditing)
                            @php
                                $fields = [
                                    'current_password' => 'Current Password',
                                    'password' => 'Password',
                                    'password_confirmation' => 'Password Confirmation',
                                ];
                            @endphp

                            @foreach ($fields as $field => $label)
                                @if (!$locked && $field === 'current_password')
                                    @continue
                                @endif
                                <div class="form-group">
                                    <label for="{{ $field }}">{{ $label }}</label>
                                    <input type="password" wire:model="{{ $field }}" id="{{ $field }}"
                                        class="form-control">
                                    @error($field)
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="cancel()" class="btn btn-secondary tw-bg-gray-300"
                            data-dismiss="modal">Close</button>
                        <button type="submit"
                            wire:click.prevent="{{ $locked ? 'updateLock()' : ($isEditing ? 'update()' : 'store()') }}"
                            wire:loading.attr="disabled" class="btn btn-primary tw-bg-blue-500">
                            Save Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
