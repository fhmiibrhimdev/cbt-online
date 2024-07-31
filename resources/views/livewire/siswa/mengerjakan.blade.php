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
                </h3>
                <div class="card-body px-4">
                    @if (count($soals) > 0)
                        <div
                            class="tw-border-4 tw-border-gray-300 tw-h-auto tw-p-4 tw-text-gray-800 tw-tracking-wide
                            @if ($size == 'lg') tw-text-lg 
                            @elseif($size == '2xl') 
                                tw-text-2xl  
                            @else 
                                tw-text-sm @endif">
                            {!! $soals['data'][$currentQuestionIndex]['soal'] !!}
                            <div class="tw-space-y-2 tw-mt-4">
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
                            class="tw-absolute tw--top-2 tw--right-0 tw-w-6 tw-h-6 tw-text-xs tw-font-bold tw-text-black 
                            @if ($soal['ragu']) tw-bg-yellow-400 
                            @elseif ($soal['jawaban_siswa']) 
                                tw-bg-green-400 
                            @else 
                                tw-bg-white @endif
                            tw-border-2 tw-border-gray-600 tw-rounded-full tw-flex tw-items-center tw-justify-center">
                            {{ $soal['jawaban_siswa'] ?? '' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


@push('general-css')
    <style>
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
@endpush

@push('scripts')
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
@endpush
