<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Token Ujian</h1>
        </div>

        <div class="section-body">
            <div class="tw-border-l-4 tw-border-blue-500 tw-bg-blue-100 tw-p-4 tw-mb-4 tw-rounded-lg">
                <h4 class="tw-text-blue-700 tw-font-bold tw-mb-2"><i class="fas fa-exclamation-circle"></i> Informasi
                </h4>
                <ul>
                    <li class="tw-list-disc ml-3 tw-text-gray-700">Jika mengklik <button class="btn btn-sm btn-primary"><i
                                class="fas fa-sync"></i> GENERATE NEW TOKEN</button> segera beritahukan
                        guru/admin lain yang sedang login agar merefresh token untuk mendapatkan token terbaru.</li>
                    <li class="tw-list-disc ml-3 tw-text-gray-700">Token akan digenerate otomatis jika pilihan Otomatis:
                        YA dan ada jadwal ujian pada hari ini.
                    </li>
                    <li class="tw-list-disc ml-3 tw-text-gray-700">Jika token otomatis diaktifkan harus tetap berada di
                        halaman token</li>
                    <li class="tw-list-disc ml-3 tw-text-gray-700">Jika token otomatis maka guru yang sedang login harus
                        merefresh token untuk melihat token terbaru</li>
                </ul>
                <p></p>
            </div>
            <div class="card">
                <div class="tw-flex tw-ml-6 tw-mt-6 tw-mb-5 lg:tw-mb-1">
                    <h3 class="tw-tracking-wider tw-text-[#34395e]  tw-text-base tw-font-semibold">
                        Generate Token</h3>
                    <button wire:click.prevent="generateNewToken()" class="btn btn-primary ml-auto mr-4"><i
                            class="fas fa-sync"></i> GENERATE NEW TOKEN</button>
                </div>
                <div class="card-body px-4">
                    <div class="row mt-3">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body px-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="auto">Otomatis?</label>
                                                <select wire:model="auto" id="auto" class="form-control">
                                                    <option value="T">TIDAK</option>
                                                    <option value="Y">Ya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="jarak">Interval (menit)</label>
                                                <input type="number" wire:model="jarak" id="jarak"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="float-right">
                                        <button class="btn btn-primary" wire:click="save">SIMPAN</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body px-4 text-center tw-text-gray-700 tw-leading-loose">
                                    <div class="mt-3 mb-3">
                                        <p>TOKEN SAAT INI</p>
                                        <p class="tw-text-4xl tw-font-bold">{{ $currentToken }}</p>
                                        <span>Token akan dibuat otomatis dalam <b id="countdown"></b></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        function toggleJarak() {
            var data = $('#auto').val();
            $(document).ready(function() {
                $('#jarak').prop('disabled', data === 'T');
            });
        }

        document.addEventListener('livewire:init', () => {
            window.addEventListener('start-interval', event => {
                const updatedAt = new Date(event.detail[0].updatedAt);
                const interval = event.detail[0].interval;
                startCountdown(interval, updatedAt);
            });
            window.addEventListener('init-toggle-jarak', event => {
                toggleJarak();
            });
        })

        $(document).ready(function() {
            toggleJarak();

            $('#auto').on('change', function() {
                toggleJarak();
            });
        });

        function startCountdown(interval, updatedAt) {
            let countdownElement = document.getElementById('countdown');
            const now = new Date();
            const elapsed = (now - updatedAt) / 1000; // elapsed time in seconds
            let countdownTime = interval / 1000 - elapsed;

            function updateCountdown() {
                if (countdownTime <= 0) {
                    Livewire.dispatch('startAutoRefresh');
                    return;
                }

                let minutes = Math.floor(countdownTime / 60);
                let seconds = Math.floor(countdownTime % 60);

                countdownElement.innerText =
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                countdownTime--;
                setTimeout(updateCountdown, 1000);
            }

            updateCountdown();
        }
    </script>
@endpush
