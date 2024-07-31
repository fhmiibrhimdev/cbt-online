<div>
    <section class="section custom-section">
        <div class="section-header">
            <a href="{{ url('ujian/bank-soal') }}" class="btn btn-muted"><i class="fas fa-angle-left"></i></a>
            <h1>Detail Soal</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <div
                    class="tw-tracking-wider tw-text-[#34395e] tw-ml-6 tw-mt-6 tw-mb-5 lg:tw-mb-1 tw-text-base tw-font-semibold tw-flex">
                    <h3>Detail Soal</h3>
                    <div class="ml-auto mr-3">
                        @if ((int) $seluruh_total_seharusnya == $seluruh_total_ditampilkan)
                            <span
                                class="tw-bg-green-50 tw-rounded-md tw-text-sm tw-px-3 tw-py-1.5 tw-text-green-600 tw-tracking-wider">
                                <i class="fas fa-badge-check"></i>
                                BANK SOAL SIAP DIGUNAKAN
                            </span>
                        @else
                            <span
                                class="tw-bg-red-50 tw-rounded-md tw-text-sm tw-px-3 tw-py-1.5 tw-text-red-600 tw-tracking-wider">
                                <i class="fas fa-exclamation-triangle"></i>
                                PEMBUATAN SOAL MASIH KURANG
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="30%" class="">Kode Bank Soal</td>
                                        <td class="text-right tw-tracking-wider tw-font-semibold tw-text-gray-800">
                                            {{ $bank_soal->kode_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mata Pelajaran</td>
                                        <td class="text-right tw-tracking-wider tw-font-semibold tw-text-gray-800">
                                            {{ $bank_soal->nama_mapel }}</td>
                                    </tr>
                                    <tr>
                                        <td>Guru</td>
                                        <td class="text-right tw-tracking-wider tw-font-semibold tw-text-gray-800">
                                            {{ $bank_soal->nama_guru }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kelas</td>
                                        <td class="text-right tw-tracking-wider tw-font-semibold tw-text-gray-800">
                                            @foreach ($bank_soal->getKelas() as $class)
                                                <span
                                                    class="tw-bg-purple-50 tw-rounded-full tw-px-3 tw-py-1 tw-text-purple-600 tw-tracking-wide">{{ $class->kode_kelas }}</span>
                                            @endforeach
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Total Seharusnya</td>
                                        <td class="text-right tw-font-semibold tw-text-gray-800">
                                            {{ $seluruh_total_seharusnya }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Soal Dibuat</td>
                                        <td class="text-right tw-font-semibold tw-text-gray-800">
                                            {{ $seluruh_total_dibuat }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Ditampilkan</td>
                                        <td class="text-right tw-font-semibold tw-text-gray-800">
                                            {{ $seluruh_total_ditampilkan }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Ket.</td>
                                        <td class="text-right tw-font-semibold tw-text-gray-800">
                                            @if ((int) $seluruh_total_seharusnya == $seluruh_total_ditampilkan)
                                                <span
                                                    class="tw-bg-green-50 tw-text-sm tw-rounded-md tw-px-3 tw-py-1.5 tw-text-green-600">SELESAI</span>
                                            @else
                                                <span
                                                    class="tw-bg-red-50 tw-text-sm tw-rounded-md tw-px-3 tw-py-1.5 tw-text-red-600">BELUM
                                                    SELESAI</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body px-4">
                    <div>
                        <button wire:click="jenis('1')"
                            class="btn {{ $selectedJenis === '1' ? 'btn-primary' : 'btn-dropdown' }} tw-tracking-wider">
                            Pilihan Ganda
                        </button>
                        <button wire:click="jenis('2')"
                            class="btn {{ $selectedJenis === '2' ? 'btn-primary' : 'btn-dropdown' }} tw-tracking-wider">
                            Pilihan Ganda Kompleks
                        </button>
                        <button wire:click="jenis('3')"
                            class="btn {{ $selectedJenis === '3' ? 'btn-primary' : 'btn-dropdown' }} tw-tracking-wider">
                            Menjodohkan
                        </button>
                        <button wire:click="jenis('4')"
                            class="btn {{ $selectedJenis === '4' ? 'btn-primary' : 'btn-dropdown' }} tw-tracking-wider">
                            Isian Kompleks
                        </button>
                        <button wire:click="jenis('5')"
                            class="btn {{ $selectedJenis === '5' ? 'btn-primary' : 'btn-dropdown' }} tw-tracking-wider">
                            Essai/Uraian
                        </button>
                    </div>
                    <div>
                        <table class="mt-3">
                            <thead>
                                <tr class="text-center">
                                    <th>Jenis Soal</th>
                                    <th colspan="2">Jumlah Soal</th>
                                    <th>Bobot Nilai</th>
                                    <th>Point Per-nomor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center tw-font-semibold">
                                    <td rowspan="4">
                                        {{ $selectedJenis == '1'
                                            ? 'Pilihan Ganda'
                                            : ($selectedJenis == '2'
                                                ? 'Pilihan Ganda Kompleks'
                                                : ($selectedJenis == '3'
                                                    ? 'Menjodohkan'
                                                    : ($selectedJenis == '4'
                                                        ? 'Isian Kompleks'
                                                        : ($selectedJenis == '5'
                                                            ? 'Essai / Uraian'
                                                            : '')))) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Seharusnya</td>
                                    <td class="text-center tw-font-semibold">{{ $seharusnya }}</td>
                                    <td rowspan="4" class="text-center tw-font-semibold">0</td>
                                    <td rowspan="4" class="text-center tw-font-semibold">0</td>
                                </tr>
                                <tr>
                                    <td>Telah Dibuat</td>
                                    <td class="text-center tw-font-semibold">{{ $total_dibuat }}</td>
                                </tr>
                                <tr>
                                    <td>Ditampilkan</td>
                                    <td class="text-center tw-font-semibold">{{ $ditampilkan }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body px-4">
                    <div class="tw-flex">
                        <p class=" tw-font-semibold tw-text-gray-700 tw-tracking-wider">
                            {{ $selectedJenis == '1'
                                ? "A. Soal Pilihan Ganda (Opsi: $bank_soal->opsi Soal) "
                                : ($selectedJenis == '2'
                                    ? 'B. Pilihan Ganda Kompleks'
                                    : ($selectedJenis == '3'
                                        ? 'C. Menjodohkan'
                                        : ($selectedJenis == '4'
                                            ? 'D. Isian Kompleks'
                                            : ($selectedJenis == '5'
                                                ? 'E. Essai / Uraian'
                                                : '')))) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-columns">
                @forelse ($data as $row)
                    <div class="card">
                        <div class="card-body px-4">
                            <div class="tw-flex tw-relative">
                                <p class="tw-font-semibold">{{ $loop->index + 1 }}. &nbsp;</p>
                                <div class="tw-block tw-flex-1 tw-pr-12 tw-text-justify">
                                    <span class="tw-text-gray-700">{!! $row->soal !!}</span>
                                </div>
                                @if ($row->tampilkan == '1')
                                    <button wire:click.prevent="status({{ $row->id }}, '0')"
                                        class="ml-auto tw-absolute tw-top-0 tw-right-0">
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </button>
                                @else
                                    <button wire:click.prevent="status({{ $row->id }}, '1')"
                                        class="ml-auto tw-absolute tw-top-0 tw-right-0">
                                        <label class="switch">
                                            <input type="checkbox">
                                            <span class="slider round"></span>
                                        </label>
                                    </button>
                                @endif
                            </div>
                            <ul class="ml-3 my-2 tw-flex tw-flex-wrap">
                                @php
                                    $options = [
                                        'A' => 'opsi_a',
                                        'B' => 'opsi_b',
                                        'C' => 'opsi_c',
                                        'D' => 'opsi_d',
                                        'E' => 'opsi_e',
                                    ];
                                    $half = ceil(count($options) / 2);
                                    $isLongOption = false;
                                @endphp

                                @foreach ($options as $key => $option)
                                    @if (!empty($row->$option) && strlen($row->$option) > 21)
                                        @php $isLongOption = true; @endphp
                                    @break
                                @endif
                            @endforeach

                            @if ($isLongOption)
                                <div class="tw-w-full">
                                    @foreach ($options as $key => $option)
                                        @if (!empty($row->$option))
                                            <li class="tw-flex tw-ml-3">{{ $key }}.
                                                &nbsp;{!! $row->$option !!}</li>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div class="tw-w-1/2">
                                    @foreach ($options as $key => $option)
                                        @if (!empty($row->$option))
                                            @if ($loop->iteration <= $half)
                                                <li class="tw-flex tw-ml-3">{{ $key }}.
                                                    &nbsp;{!! $row->$option !!}</li>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>

                                <div class="tw-w-1/2">
                                    @foreach ($options as $key => $option)
                                        @if (!empty($row->$option))
                                            @if ($loop->iteration > $half)
                                                <li class="tw-flex tw-ml-3">{{ $key }}.
                                                    &nbsp;{!! $row->$option !!}</li>
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </ul>

                        <div class="tw-flex mt-2">
                            <p class="tw-text-gray-700 tw-font-semibold">Kunci: {{ $row->jawaban }}</p>
                            <div class="ml-auto tw-flex">
                                <button wire:click.prevent="edit({{ $row->id }})" class="btn btn-primary mr-1"
                                    data-toggle="modal" data-target="#formDataModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if (stripos($row->soal, '<img') !== false)
                                    <i class="mt-1 text-danger">Hapus gambar terlebih dahulu di mode edit!.</i>
                                @else
                                    <button wire:click.prevent="deleteConfirm({{ $row->id }})"
                                        class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="card">
                    <div class="card-body text-center tw-font-semibold tw-text-red-500">
                        <i>Belum ada soal yang dibuat</i>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <button wire:click.prevent="isEditingMode(false)" class="btn-modal" data-toggle="modal" data-backdrop="static"
        data-keyboard="false" data-target="#formDataModal">
        <i class="far fa-plus"></i>
    </button>
</section>

<div class="modal fade" wire:ignore.self id="formDataModal" aria-labelledby="formDataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formDataModalLabel">{{ $isEditing ? 'Edit Data' : 'Add Data' }}</h5>
                <button type="button" wire:click="cancel()" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="soal">Soal</label>
                        <div wire:ignore>
                            <textarea wire:model="soal" id="soal" class="form-control"></textarea>
                        </div> @error('soal')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                    @if (in_array($bank_soal->opsi, ['3', '4', '5']))
                        @foreach (range('A', chr(64 + $bank_soal->opsi)) as $option)
                            <div class="form-group">
                                <label for="opsi_{{ strtolower($option) }}">Opsi {{ $option }}</label>
                                <div wire:ignore>
                                    <textarea wire:model="opsi_{{ strtolower($option) }}" id="opsi_{{ strtolower($option) }}" class="form-control"></textarea>
                                </div>
                                @error('opsi_{{ strtolower($option) }}')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        @endforeach
                    @endif
                    <div class="form-group mt-3">
                        <label for="jawaban">Jawaban</label>
                        <div wire:ignore>
                            <select wire:model="jawaban" id="jawaban" class="form-control">
                                <option value="">-- Opsi Pilihan --</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                            </select>
                        </div> @error('jawaban')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
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

@push('general-css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@push('js-libraries')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@endpush

@push('scripts')
<script>
    window.addEventListener('initSummernote', event => {
        $(document).ready(function() {
            initializeSummernote('#soal', 'soal');
            initializeSummernote('#opsi_a', 'opsi_a');
            initializeSummernote('#opsi_b', 'opsi_b');
            initializeSummernote('#opsi_c', 'opsi_c');
            initializeSummernote('#opsi_d', 'opsi_d');
            initializeSummernote('#opsi_e', 'opsi_e');
        });
    })
</script>
<script>
    function initializeSummernote(selector, wiremodel) {
        $(selector).summernote('destroy')
        $(selector).summernote({
            imageAttributes: {
                icon: '<i class="note-icon-pencil"/>',
                removeEmpty: false,
                disableUpload: false
            },
            popover: {
                image: [
                    ['custom', ['imageAttributes']],
                    ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                    ['float', ['floatLeft', 'floatRight', 'floatNone']],
                    ['remove', ['removeMedia']]
                ],
            },
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            grid: {
                wrapper: "row",
                columns: [
                    "col-md-12",
                    "col-md-6",
                    "col-md-4",
                    "col-md-3",
                    "col-md-24",
                ]
            },
            callbacks: {
                onImageUpload: function(image) {
                    sendFile(image[0], selector);
                },
                onMediaDelete: function(target) {
                    deleteFile(target[0].src)
                },
                onBlur: function() {
                    const contents = $(selector).summernote('code');
                    if (contents === '' || contents === '<br>' || !contents.includes('<p>')) {
                        $(selector).summernote('code', '<p>' + contents + '</p>');
                    }
                    @this.set(wiremodel, contents)
                },
                onPaste: function(e) {
                    e.preventDefault();
                    var clipboardData = (e.originalEvent || e).clipboardData;
                    var text = clipboardData.getData('text/plain');
                    document.execCommand('insertHTML', false, '<p>' + text + '</p>');
                },
                onInit: function() {
                    let currentContent = @this.get(wiremodel);
                    if (!currentContent) {
                        currentContent = '<p>Teks</p>'; // Paragraf default kosong
                    }
                    @this.set(wiremodel, currentContent)
                    $(selector).summernote('code', currentContent);
                }
            },
            icons: {
                grid: "bi bi-grid-3x2"
            },
        });
    }

    function sendFile(file, editor, welEditable) {
        token = "{{ csrf_token() }}"
        data = new FormData();
        data.append("file", file);
        data.append('_token', token);
        $('#loading-image-summernote').show();
        $('#soal').summernote('disable');
        $.ajax({
            data: data,
            type: "POST",
            url: "{{ url('/summernote/file/upload') }}",
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                console.log(url);
                if (url['status'] == "success") {
                    $('#soal').summernote('enable');
                    $('#loading-image-summernote').hide();
                    $('#soal').summernote('editor.saveRange');
                    $('#soal').summernote('editor.restoreRange');
                    $('#soal').summernote('editor.focus');
                    $('#soal').summernote('editor.insertImage', url['image_url']);
                }
                $("img").addClass("img-fluid");
            },
            error: function(data) {
                console.log(data)
                $('#soal').summernote('enable');
                $('#loading-image-summernote').hide();
            }
        });
    }

    function deleteFile(target) {
        token = "{{ csrf_token() }}"
        data = new FormData();
        data.append("target", target);
        data.append('_token', token);
        $('#loading-image-summernote').show();
        $('.summernote').summernote('disable');
        $.ajax({
            data: data,
            type: "POST",
            url: "{{ url('/summernote/file/delete') }}",
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                console.log(result)
                if (result['status'] == "success") {
                    $('.summernote').summernote('enable');
                    $('#loading-image-summernote').hide();
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Gambar berhasil dihapus.',
                        icon: 'success',
                    })
                }
            },
            error: function(data) {
                console.log(data)
                $('.summernote').summernote('enable');
                $('#loading-image-summernote').hide();
            }
        });
    }
</script>
@endpush
