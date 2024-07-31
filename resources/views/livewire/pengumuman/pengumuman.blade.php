<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Pengumuman</h1>
        </div>

        <div class="section-body">

            <div class="row">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="tw-flex tw-ml-6 tw-mt-6">
                            <h3 class="tw-tracking-wider tw-text-[#34395e] tw-text-base tw-font-semibold">
                                Running Text</h3>
                            <div class="ml-auto">
                                <button wire:click="update()" class="btn btn-primary mr-4">Save Data</button>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <div class="tw-border-l-4 tw-border-blue-500 tw-bg-blue-100 tw-p-4 tw-mb-4 tw-rounded-lg ">
                                <h4 class="tw-text-blue-700 tw-font-bold tw-mb-2"><i
                                        class="fas fa-exclamation-circle"></i> Informasi
                                </h4>
                                <p class="tw-text-blue-700 tw-leading-tight"><span class="tw-font-bold">Running
                                        Text</span> akan muncul di bagian bawah
                                    layar siswa.</p>
                            </div>
                            <table>
                                @for ($i = 1; $i <= 5; $i++)
                                    <tr>
                                        <td class="tw-border-none tw-px-0" width="5%">{{ $i }}</td>
                                        <td class="tw-border-none tw-px-0">
                                            <textarea wire:model="text.{{ $i }}" class="form-control" style="height: 65px !important;"></textarea>
                                            @error('text.{{ $i }}')
                                                <small class='text-danger'>{{ $message }}</small>
                                            @enderror
                                        </td>
                                    </tr>
                                @endfor
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card">
                        <div class="tw-flex tw-ml-6 tw-mt-6">
                            <h3 class="tw-tracking-wider tw-text-[#34395e] tw-text-base tw-font-semibold">
                                Tulis Info / Pengumuman</h3>
                            <div class="ml-auto">
                                <button wire:click="store()" class="btn btn-primary mr-4">Save Data</button>
                            </div>
                        </div>
                        <div class="card-body px-4">
                            <div class="form-group">
                                <label for="kepada">Kepada</label>
                                {{-- <pre>@json($kepada, JSON_PRETTY_PRINT)</pre> --}}
                                <select name="kepada" id="kepada" class="form-control" multiple>
                                    <option value="">-- Opsi Pilihan --</option>
                                    <option value="guru">Semua Guru</option>
                                    @if ($showSiswaOption)
                                        <option value="siswa">Semua Siswa</option>
                                    @endif
                                    @if ($showKelasOptions)
                                        @foreach ($kelases as $kelas)
                                            <option value="{{ $kelas->id }}">{{ $kelas->kode_kelas }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="text_posts">Text </label>
                                <div wire:ignore>
                                    <textarea wire:model="text_posts" id="text_posts" class="form-control summernote" spellcheck="false"></textarea>
                                </div>
                                @error('text_posts')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h3 class="mb-4">Semua Pengumuman</h3>
            </div>
            @foreach ($posts as $post)
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="px-4">
                                    <div class="tw-flex">
                                        <div>
                                            <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                                                alt="profile" class="tw-rounded-full tw-w-12 tw-h-12">
                                        </div>
                                        <div class="ml-3 tw-mt-1">
                                            <p class="tw-tracking-wider tw-text-[#34395e] tw-text-sm tw-font-semibold">
                                                {{ $post->name }} </p>
                                            <p class="tw-text-xs tw-tracking-normal tw-mt-1">
                                                {{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                                        </div>
                                        @if ($post->id_user == Auth::user()->id)
                                            <div class="ml-auto">
                                                <button wire:click.prevent="deleteConfirm({{ $post->id }}, 'post')"
                                                    class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <div
                                        class="tw-mt-4 tw-text-sm tw-leading-normal tw-tracking-normal tw-text-gray-700">
                                        {!! $post->text !!}
                                    </div>
                                </div>
                            </div>
                            <hr class="tw-bg-gray-50 tw-border-1">
                            <div class="px-4 py-3">
                                <button wire:click.prevent="toggleComments({{ $post->id }})"
                                    class="hover:tw-bg-gray-100 hover:tw-rounded-md tw-text-gray-600 tw-px-2 tw-py-1 tw-tracking-normal tw-font-semibold"><i
                                        class="far fa-comment tw-text-sm"></i> {{ $post->comments_count }}
                                    komentar</button>
                                <div class="tw-flex tw-ml-1 tw-mt-3">
                                    <div class="ml-2 tw-mt-[-5px]">
                                        <p class="tw-tracking-normal tw-text-[#34395e] tw-text-[13px] tw-font-semibold">
                                        </p>
                                        <p class="tw-text-[13px] tw-text-gray-700 tw-leading-normal tw-tracking-normal">

                                        </p>
                                    </div>
                                </div>
                                @if (in_array($post->id, $postIdWithComments))
                                    @foreach ($comments[$post->id] ?? [] as $comment)
                                        <div
                                            class="tw-flex tw-ml-1 @if ($loop->index + 1 == 1) tw-mt-0
                                        @else
                                            tw-mt-5 @endif tw-mb-3">
                                            <img src="{{ url('/assets/users-empty.jpeg') }}" alt="profile"
                                                class="tw-rounded-full tw-w-8 tw-h-8">
                                            <div class="ml-3 tw-mt-[-5px]">
                                                <p
                                                    class="tw-tracking-wide tw-text-[#34395e] tw-text-[13px] tw-font-semibold">
                                                    {{ $comment->name }}
                                                    <span class="tw-text-[13px] tw-font-normal tw-text-gray-500">
                                                        •
                                                        {{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                                    </span>
                                                </p>
                                                <p
                                                    class="tw-text-sm tw-text-gray-700 tw-leading-normal tw-tracking-normal">
                                                    {{ $comment->text }} <br>
                                                    @if ($comment->id_user == Auth::user()->id)
                                                        <span
                                                            wire:click="deleteConfirm({{ $comment->id }}, 'comment')"
                                                            class="tw-select-none tw-text-xs text-danger hover:tw-underline">Delete</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="tw-flex">
                                    <img src="{{ url('/assets/users-empty.jpeg') }}"
                                        class="tw-rounded-full tw-w-8 tw-h-8 mr-3 ml-1 tw-mt-1">
                                    <input type="text" wire:model="comment" class="form-control tw-rounded-full">
                                    <button wire:click.prevent="storeComment({{ $post->id }})"
                                        wire:loading.attr="disabled" class="tw-mt-[-5px]">
                                        <i
                                            class="fas fa-paper-plane tw-text-lg hover:tw-text-gray-900 tw-text-gray-400 ml-3"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>

@push('general-css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="{{ asset('assets/midragon/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('js-libraries')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('/assets/midragon/select2/select2.full.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        window.addEventListener('initSelect2', event => {
            $(document).ready(function() {
                $('#kepada').select2();
                $('#kepada').on('change', function(e) {
                    var id = $(this).attr('id');
                    var data = $(this).select2("val");
                    @this.set(id, data);
                });
            });
        })
        window.addEventListener('initSummernote', event => {
            $(document).ready(function() {
                initializeSummernote('#text_posts', 'text_posts');
            });
        })
    </script>
    <script>
        function initializeSummernote(selector, wiremodel) {
            $(selector).summernote('destroy')
            $(selector).summernote({
                height: 275, // set editor height
                focus: true,
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
            $('.summernote').summernote('disable');
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
                        $('.summernote').summernote('enable');
                        $('#loading-image-summernote').hide();
                        $('.summernote').summernote('editor.saveRange');
                        $('.summernote').summernote('editor.restoreRange');
                        $('.summernote').summernote('editor.focus');
                        $('.summernote').summernote('editor.insertImage', url['image_url']);
                    }
                    $("img").addClass("img-fluid");
                },
                error: function(data) {
                    console.log(data)
                    $('.summernote').summernote('enable');
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
