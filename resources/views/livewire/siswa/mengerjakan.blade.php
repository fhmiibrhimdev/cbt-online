<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>SOAL NO. {{ $currentQuestionIndex + 1 }}</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3 class="tw-text-base">Ukuran font soal:
                    <button class="tw-text-blue-900 tw-ml-3 tw-text-base" wire:click="changeSize('base')">A</button>
                    <button class="tw-text-blue-900 tw-ml-3 tw-text-lg" wire:click="changeSize('lg')">A</button>
                    <button class="tw-text-blue-900 tw-ml-3 tw-text-2xl" wire:click="changeSize('2xl')">A</button>
                    <button id="toggle-btn" class="btn btn-info mr-4 float-right tw-rounded-full tw-px-4"><i
                            class="fas fa-th mr-2"></i>DAFTAR
                        SOAL</button>
                    <span id="countdown-timer"
                        class="tw-text-sm tw-border-2 tw-border-red-300 tw-py-1.5 mr-4 float-right tw-rounded-full tw-px-4"
                        data-end-time="{{ $siswa->waktu_akhir }}">Sisa
                        Waktu:
                        ..:..:..</span>
                    <a href="" class="btn btn-primary mr-4 float-right tw-rounded-full tw-px-4"><i
                            class="fas fa-sync mr-2"></i>
                        Refresh Halaman</a>
                </h3>
                <div class="card-body px-4">
                    @if (count($soals) > 0)
                        <div
                            class="tw-border-4 tw-border-gray-300 tw-h-auto tw-px-4 tw-py-0 tw-text-gray-800 tw-tracking-wide
                            @if ($size == 'lg') tw-text-lg 
                            @elseif($size == '2xl') tw-text-2xl  
                            @else tw-text-sm @endif">
                            <div class="tw-mt-4">
                                {!! $soals['data'][$currentQuestionIndex]['soal'] !!}
                            </div>
                            @if ($soals['data'][$currentQuestionIndex]['jenis_soal'] == '1')
                                <div class="tw-space-y-2 tw-mt-4 tw-mb-6" wire:key="{{ rand() }}">
                                    @foreach (['A', 'B', 'C', 'D', 'E'] as $option)
                                        <label class="tw-flex tw-items-center">
                                            <input type="radio" name="opsi" class="tw-hidden tw-peer"
                                                value="{{ $option }}" wire:model="opsi"
                                                wire:change="selectOption('{{ $option }}')"
                                                {{ $this->opsi == $option ? 'checked' : '' }} />
                                            <span
                                                class="tw-mr-2 tw-w-8 tw-h-8 tw-flex tw-items-center tw-justify-center tw-rounded-full tw-border-4 tw-font-bold 
                                            {{ $this->opsi == $option ? 'tw-border-blue-500 tw-bg-blue-500 tw-text-white' : 'tw-border-gray-300 tw-text-gray-400' }}">
                                                {{ $option }}
                                            </span>
                                            <p>{!! $soals['data'][$this->currentQuestionIndex]['opsi_alias_' . strtolower($option)] !!}
                                            </p>
                                        </label>
                                    @endforeach
                                </div>
                            @elseif ($soals['data'][$currentQuestionIndex]['jenis_soal'] == '2')
                                {{-- @json($pg_kompleks) --}}
                                @foreach (json_decode($soals['data'][$currentQuestionIndex]['opsi_a']) as $key => $opsi_kompleks)
                                    <div class="tw-space-y-2">
                                        <input type="checkbox" id="pg_kompleks_{{ $key }}"
                                            wire:model.blur="pg_kompleks" value="{{ $key }}"
                                            class="tw-mr-1.5 tw-border tw-border-gray-300 tw-p-2.5 tw-rounded-sm tw-shadow-inner tw-shadow-gray-200 checked:tw-shadow-none">
                                        <label for="pg_kompleks_{{ $key }}">{!! $opsi_kompleks !!}</label>
                                    </div>
                                @endforeach
                                <div class="mb-4"></div>
                            @elseif ($soals['data'][$currentQuestionIndex]['jenis_soal'] == '3')
                                <div wire:ignore id="jawaban-jodohkan" class="mt-3"></div>
                            @elseif ($soals['data'][$currentQuestionIndex]['jenis_soal'] == '4')
                                <div class="form-group mt-3" wire:key="{{ rand() }}">
                                    <input type="text" wire:model.blur="isian_singkat" class="form-control">
                                </div>
                            @elseif ($soals['data'][$currentQuestionIndex]['jenis_soal'] == '5')
                                <div class="form-group mt-3" wire:ignore>
                                    <textarea id="essai" class="form-control"></textarea>
                                </div>
                            @endif

                        </div>
                    @else
                        <div class="tw-p-4 tw-text-center">
                            <p>Tidak ada soal yang tersedia.</p>
                        </div>
                    @endif
                    <div class="tw-justify-between tw-flex tw-mt-10">
                        <button class="btn btn-lg btn-primary" wire:click="previousQuestion"
                            @if ($currentQuestionIndex == 0) disabled @endif><i class="fas fa-chevron-left mr-2"></i>
                            SOAL
                            SEBELUMNYA</button>
                        <button class="btn btn-lg btn-warning ">
                            <div wire:key="{{ rand() }}">
                                <input type="checkbox"
                                    wire:click="selectRagu({{ $soals['data'][$currentQuestionIndex]['ragu'] ? '0' : '1' }})"
                                    {{ $soals['data'][$currentQuestionIndex]['ragu'] ? 'checked' : '' }} />
                                RAGU RAGU
                            </div>
                        </button>
                        @if ($currentQuestionIndex < count($soals['data']) - 1)
                            <button class="btn btn-lg btn-primary" wire:click="nextQuestion">
                                <span class="mr-2">SOAL BERIKUTNYA</span>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @else
                            <button class="btn btn-lg btn-info" wire:click="confirmFinish">
                                <span class="mr-2">SELESAI</span>
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Panel -->
    <div id="panel" class="tw-z-[999] tw-panel tw-w-64 tw-bg-white tw-h-full tw-overflow-y-auto tw-shadow-lg">
        <div class="tw-p-4">
            <h3 class="mb-3 tw-tracking-wider tw-text-[#34395e] tw-text-base tw-font-semibold">NOMOR SOAL</h3>
            <div class="tw-grid tw-grid-cols-4 tw-gap-y-4 tw-gap-x-2">
                @foreach ($soals['data'] as $index => $soal)
                    <div class="tw-relative">
                        <button wire:click="goToQuestion({{ $index }})"
                            class="tw-w-10 tw-h-10 tw-font-semibold tw-text-black {{ $index == $currentQuestionIndex ? 'tw-bg-sky-600 tw-text-white' : 'tw-bg-gray-50 tw-border-2 tw-border-gray-600' }}">{{ $index + 1 }}</button>
                        <span
                            class="tw-absolute tw--top-2 tw--right-0 tw-w-6 tw-h-6 tw-text-xs tw-font-bold tw-text-white 
                            @if ($soal['ragu']) tw-bg-yellow-400 
                            @elseif ($soal['jawaban_siswa'] === '' || $soal['jawaban_siswa'] === '[]' || $soal['jawaban_siswa'] === '<p>...</p>') 
                                tw-bg-white
                            @elseif ($soal['jawaban_siswa'])
                            tw-bg-green-400 
                            @else @endif
                            tw-border-2 tw-border-gray-600 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                            @if ($soal['jenis_soal'] == '1')
                                {{ $soal['jawaban_siswa'] ?? '' }}
                            @else
                                @if ($soal['jawaban_siswa'] == '')
                                @else
                                    <i class="fas fa-check text-white"></i>
                                @endif
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@push('general-css')
    <style>
        body {
            user-select: none;
            /* CSS untuk mencegah pemilihan teks */
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .tw-panel {
            transition: transform 0.3s ease;
            transform: translateX(100%);
            position: fixed;
            right: 0;
            top: 0;
            height: 100%;
            z-index: 1000;
        }

        .tw-show-panel {
            transform: translateX(0);
        }

        .tw-move-button {
            transition: transform 0.3s ease;
            transform: translateX(-235px);
            /* Menggeser button ke kanan */
        }
    </style>
    <link href="{{ asset('assets/summernote/summernote-lite.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/katex/katex.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/summernote/fieldsLinker.css') }}">
@endpush

@push('js-libraries')
    <script src="{{ asset('assets/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('assets/summernote/summernote-math.js') }}"></script>
    <script src="{{ asset('assets/katex/katex.min.js') }}"></script>
    <script src="{{ asset('assets/summernote/ResizeSensor.js') }}"></script>
    <script src="{{ asset('assets/summernote/linker-list.js?v=asdsa') }}"></script>
@endpush

@push('scripts')
    <script type="module">
        import devtools from '../../assets/devtools.js';
        if (devtools.isOpen) {
            setTimeout(() => {
                Swal.fire({
                    title: 'Terdeteksi!',
                    icon: 'warning',
                    html: 'Dilarang keras membuka Inspect Element! <br/> Tutup Inspect Element dan refresh halaman!',
                })
                $('.main-content').html('');
            }, 5);
        }
        window.addEventListener('devtoolschange', event => {
            if (event.detail.isOpen) {
                setTimeout(() => {
                    Swal.fire({
                        title: 'Terdeteksi!',
                        icon: 'warning',
                        html: 'Dilarang keras membuka Inspect Element! <br/> Tutup Inspect Element dan refresh halaman!',
                    })
                    $('.main-content').html('');
                }, 5);
            }
        });
    </script>
    <script>
        const detectZoom = () => {
            const zoomLevel = Math.round(window.devicePixelRatio * 100);
            if (zoomLevel !== 100) {
                Swal.fire({
                    title: 'Terdeteksi!',
                    icon: 'error',
                    html: 'Dilarang mengubah zoom halaman, segera kembalikan zoom halaman ke 100% di tombol kanan pojok atas',
                })
                $('.main-content').html('');
            } else {
                Swal.fire({
                    title: 'Peraturan Ujian',
                    icon: 'info',
                    html: 'Kerjakan soal dengan serius, tidak boleh nyontek!<br>Nyontek bisa terdeksi disistem',
                    // showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.value) {
                        openFullscreen();
                    }
                });
            }
        };
        $(document).ready(function() {
            detectZoom();
            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Peringatan',
                    icon: 'info',
                    html: 'Tidak boleh melakukan kecurangan!, terdeteksi oleh sistem anda klik kanan.',
                    // showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Iya',
                    allowOutsideClick: false
                })
            });
            document.addEventListener('keydown', function(e) {
                if (
                    (e.ctrlKey && (
                        e.key === 'c' ||
                        e.key === 'v' ||
                        e.key === 'x' ||
                        e.key === 'u' ||
                        e.key === 's' ||
                        e.key === 'p' ||
                        e.key === 'a' ||
                        e.key === 'n' ||
                        (e.shiftKey && e.key === 'n') ||
                        (e.shiftKey && e.key === 'c')
                    )) ||
                    (e.key === 'F12' ||
                        e.key === 'F11' ||
                        e.key === 'Escape' ||
                        (e.ctrlKey && e.key === 'n'))
                ) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Peringatan',
                        icon: 'info',
                        html: 'Tidak boleh melakukan kecurangan!, terdeteksi oleh sistem.',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Iya',
                        allowOutsideClick: false
                    })
                }
                if (e.ctrlKey && e.shiftKey && e.key === 'c') {
                    console.log('Ctrl + Shift + C detected');
                    e.preventDefault();
                }
                if (e.ctrlKey && (e.key === '+' || e.key === '-' || e.key === '=')) {
                    e.preventDefault();
                }
            });
            document.addEventListener('wheel', function(e) {
                if (e.ctrlKey) {
                    e.preventDefault(); // Mencegah zoom
                }
            }, {
                passive: false
            });
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'visible') {
                    Swal.fire({
                        title: 'Peringatan Keras!',
                        html: 'Dilarang curang dalam ujian <b>membuka tab baru</b>, Anda akan dikenakan sanksi jika terus melanggar!',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                    });
                    $('.main-content').html('');
                }
            });
        });

        function openFullscreen() {
            if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else if (document.documentElement.mozRequestFullScreen) {
                /* Firefox */
                document.documentElement.mozRequestFullScreen();
            } else if (document.documentElement.webkitRequestFullscreen) {
                /* Chrome, Safari & Opera */
                document.documentElement.webkitRequestFullscreen();
            } else if (document.documentElement.msRequestFullscreen) {
                /* IE/Edge */
                window.top.document.body.msRequestFullscreen();
            }
        }
    </script>
    <script>
        window.addEventListener('initSummernoteJDH', event => {
            $(document).ready(function() {
                let konten = $('#jawaban-jodohkan')
                konten.html('')
                initJawaban = @this.get('jawaban_jodohkan')
                // console.log(initJawaban)
                if (initJawaban == "") {
                    jawaban = {
                        jawaban: [],
                        model: '1',
                        type: '2'
                    }
                } else {
                    jawaban = initJawaban

                    if (typeof jawaban == "string") {
                        jawaban = JSON.parse(initJawaban)
                    } else {
                        jawaban = initJawaban
                    }
                    // console.log(jawaban)

                    processLinks(jawaban);

                    function processLinks(jawaban) {
                        // Fungsi untuk mendeteksi format
                        function detectFormat(links) {
                            if (Array.isArray(links)) {
                                return 'arrayOfArrays';
                            } else if (typeof links === 'object' && links !== null) {
                                return 'objectOfArrays';
                            }
                            return 'unknown';
                        }

                        // Fungsi untuk memeriksa apakah ada link yang valid
                        function hasValidLinks(links) {
                            if (Array.isArray(links)) {
                                return links.some(value => Array.isArray(value) && value.length > 0);
                            } else if (typeof links === 'object' && links !== null) {
                                return Object.values(links).some(value => Array.isArray(value) && value
                                    .length > 0);
                            }
                            return false;
                        }

                        const format = detectFormat(jawaban.links);

                        if (!hasValidLinks(jawaban.links) || jawaban == "") {
                            if (format === 'arrayOfArrays') {
                                jawaban.jawaban.forEach((row, index) => {
                                    if (index > 0) {
                                        for (let i = 1; i < row.length; i++) {
                                            row[i] = "0";
                                        }
                                    }
                                });

                                jawaban.links = jawaban.links.reduce((acc, value, index) => {
                                    if (value && Array.isArray(value)) {
                                        acc[(index + 1).toString()] = value.map(() =>
                                            ""); // Set semua nilai menjadi string kosong
                                    } else {
                                        acc[(index + 1).toString()] = [""];
                                    }
                                    return acc;
                                }, {});
                            } else if (format === 'objectOfArrays') {
                                jawaban.jawaban.forEach((row, index) => {
                                    if (index > 0) {
                                        for (let i = 1; i < row.length; i++) {
                                            row[i] = "0";
                                        }
                                    }
                                });

                                jawaban.links = Object.keys(jawaban.links).reduce((acc, key) => {
                                    const value = jawaban.links[key];
                                    if (Array.isArray(value)) {
                                        acc[key] = value.map(() =>
                                            ""); // Set semua nilai menjadi string kosong
                                    } else {
                                        acc[key] = [""];
                                    }
                                    return acc;
                                }, {});
                            } else {
                                jawaban = initJawaban
                            }
                        }
                    }
                }
                konten.linkerList({
                    data: jawaban,
                    viewMode: '2',
                    callback: function(id, data, hasLinks) {
                        @this.set('jawaban_jodohkan', data)
                    }
                });
            });
        })
    </script>
    <script>
        window.addEventListener('confirm:ujian', event => {
            Swal.fire({
                title: event.detail[0].message,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('finishUjian')
                }
            })
        })

        window.addEventListener('swal:finish', event => {
            Swal.fire({
                title: event.detail[0].message,
                text: event.detail[0].text,
                icon: event.detail[0].type,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/siswa/ujian';
                }

                window.location.href = '/siswa/ujian';
            })
        })

        $(document).on('click', '#toggle-btn', function(e) {
            e.preventDefault();
            $('#panel').toggleClass('tw-show-panel');
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('#panel, #toggle-btn').length) {
                $('#panel').removeClass('tw-show-panel');
                $('#toggle-btn').removeClass('tw-move-button');
            }
        });

        document.addEventListener('livewire:init', () => {
            $('input[name="opsi"]').on('change', function() {
                if (this.checked) {
                    $('input[name="opsi"]').not(this).prop('checked', false);
                    @this.set('opsi', this.value)
                }
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            const $countdownTimer = $('#countdown-timer');
            const endTime = $countdownTimer.data('end-time'); // waktu akhir dari server

            // Mengambil tanggal hari ini dan menggabungkan dengan waktu akhir
            const today = new Date();
            const endDate = new Date(today.getFullYear(), today.getMonth(), today.getDate(), ...endTime.split(':'))
                .getTime(); // konversi ke timestamp

            function updateCountdown() {
                const now = new Date().getTime();
                const distance = endDate - now;

                // Kalkulasi waktu yang tersisa
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Update elemen HTML
                $countdownTimer.text(
                    `Sisa Waktu: ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`
                );

                // Jika waktu habis, tampilkan SweetAlert dan hentikan interval
                if (distance < 0) {
                    clearInterval(x);
                    $countdownTimer.text('Waktu Habis');
                    Swal.fire({
                        icon: 'warning',
                        title: 'Waktu Habis!',
                        text: 'Waktu untuk ujian telah habis.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Redirect atau lakukan aksi lainnya setelah SweetAlert ditutup
                        window.location.href = '/siswa/ujian';
                    });
                }
            }

            // Update countdown setiap 1 detik
            const x = setInterval(updateCountdown, 1000);
        });
    </script>
    <script>
        window.addEventListener('initSummernote', event => {
            $(document).ready(function() {
                initializeSummernote('#essai', 'essai');
            });
        })

        function initializeSummernote(selector, wiremodel) {
            $(selector).summernote('destroy');
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
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    // ['height', ['height']],
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
                    onBlur: function() {
                        const contents = $(selector).summernote('code');
                        if (contents === '' || contents === '<br>' || !contents.includes('<p>')) {
                            $(selector).summernote('code', '<p>' + contents + '</p>');
                        }
                        // console.log(wiremodel)
                        @this.set(wiremodel, contents);
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
                            currentContent = '<p>...</p>'; // Default empty paragraph
                        }
                        @this.set(wiremodel, currentContent);
                        $(selector).summernote('code', currentContent);
                    }
                },
                icons: {
                    grid: "bi bi-grid-3x2"
                },
            });
        }
    </script>
@endpush
