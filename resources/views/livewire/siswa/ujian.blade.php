<div>
    <section class="section custom-section">

        <div class="section-body">
            <div class="card">
                <h3>INFO ULANGAN/UJIAN</h3>
                <div class="card-body px-4">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <h3 class="tw-uppercase">{{ Auth::user()->name }}</h3>
                                <div class="card-body">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="tw-py-2 tw-px-4">No. Peserta</td>
                                                <td class="tw-py-2 tw-px-4 tw-text-right tw-font-semibold ">
                                                    {{ $siswa->nomor_peserta }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="tw-py-2 tw-px-4">Ruang</td>
                                                <td class="tw-py-2 tw-px-4 tw-text-right tw-font-semibold ">
                                                    {{ $siswa->nama_ruang }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tw-py-2 tw-px-4">Sesi</td>
                                                <td class="tw-py-2 tw-px-4 tw-text-right tw-font-semibold ">
                                                    {{ $siswa->nama_sesi }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tw-py-2 tw-px-4">Dari</td>
                                                <td class="tw-py-2 tw-px-4 tw-text-right tw-font-semibold ">
                                                    {{ $siswa->waktu_mulai }}</td>
                                            </tr>
                                            <tr>
                                                <td class="tw-py-2 tw-px-4">Sampai</td>
                                                <td class="tw-py-2 tw-px-4 tw-text-right tw-font-semibold ">
                                                    {{ $siswa->waktu_akhir }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="tw-border-l-4 tw-border-blue-500 tw-bg-blue-100 tw-p-4 tw-mb-4 tw-rounded-lg">
                                <h4 class="tw-text-blue-700 tw-font-bold tw-mb-2 tw-text-base tw-text-center"> **
                                    PERATURAN UJIAN **
                                </h4>
                                <p class="tw-text-blue-700 tw-mt-5 tw-mb-2">Selama melaksanakan ULANGAN/UJIAN <b>Siswa
                                        DILARANG</b>:
                                </p>
                                <ul class="tw-list-disc tw-ml-8 tw-text-blue-800">
                                    <li>Meninggalkan ruang ujian tanpa izin pengawas</li>
                                    <li>Logout/Keluar dari aplikasi tanpa izin dari pengawas</li>
                                    <li>Saling memberitahukan jawaban sesama peserta</li>
                                    <li>Membawa makanan dan minuman</li>
                                    <li>Membawa handphone ke ruangan ujian</li>
                                    <li>Membuka buku catatan atau referensi lain tanpa izin</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div
                    class="tw-flex tw-tracking-wider tw-text-[#34395e] tw-ml-6 tw-mt-6 lg:tw-mb-1 tw-text-base tw-font-semibold">
                    <h3>
                        JADWAL UJIAN HARI INI </h3>
                    <p class="ml-auto mr-4" id="clock"></p>
                </div>
                <div class="card-body px-4">
                    <div class="row">
                        @foreach ($jadwals as $jadwal)
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="px-3">
                                        <h3
                                            class="tw-tracking-wider tw-text-[#34395e] tw-mt-4 tw-text-base tw-font-semibold">
                                            {{ $jadwal->nama_mapel }}</h3>
                                        <p class="tw-text-[13px] tw-text-font-semibold tw-uppercase">
                                            {{ $jadwal->nama_jenis }}</p>
                                    </div>
                                    <div class="card-body py-0">
                                        <table class="tw-mt-4 tw-mb-3">
                                            <tbody>

                                                <tr>
                                                    <td class="tw-border-none tw-py-3" width="40%">Ujian Dimulai</td>
                                                    <td class="tw-text-right tw-font-semibold tw-border-none">
                                                        <span
                                                            class="tw-text-[13px] tw-bg-blue-50 tw-text-blue-600 tw-tracking-wider tw-px-3 tw-py-1 tw-rounded-full">
                                                            {{ $jadwal->tgl_mulai }} {{ $siswa->waktu_mulai }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="tw-border-none">Ujian Ditutup</td>
                                                    <td class="tw-border-none tw-text-right tw-font-semibold">
                                                        <span
                                                            class="tw-text-[13px] tw-bg-blue-50 tw-text-blue-600 tw-tracking-wider tw-px-3 tw-py-1 tw-rounded-full">
                                                            {{ $jadwal->tgl_selesai }} {{ $siswa->waktu_akhir }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="tw-border-none">Durasi Ujian</td>
                                                    <td class="tw-border-none tw-text-right tw-font-semibold">
                                                        <span
                                                            class="tw-text-[13px] tw-bg-purple-50 tw-text-purple-600 tw-tracking-wider tw-px-3 tw-py-1 tw-rounded-full">
                                                            {{ $jadwal->total_soal }} Soal /
                                                            {{ $jadwal->durasi_ujian }}
                                                            Menit
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @php
                                            // Ambil tanggal dan waktu saat ini
                                            $currentDateTime = now(); // atau date('Y-m-d H:i:s')

                                            // Gabungkan tanggal dan waktu dari siswa
                                            $startDateTime = \Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i',
                                                $jadwal->tgl_mulai . ' ' . $siswa->waktu_mulai,
                                            );
                                            $endDateTime = \Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i',
                                                $jadwal->tgl_selesai . ' ' . $siswa->waktu_akhir,
                                            );

                                            // Periksa apakah waktu saat ini berada dalam rentang yang ditentukan
                                            $isWithinTimeRange = $currentDateTime->between(
                                                $startDateTime,
                                                $endDateTime,
                                            );
                                        @endphp

                                        @if ($isWithinTimeRange && ($jadwal->status_ujian == '0' || $jadwal->status_ujian == ''))
                                            <a href="{{ url('/siswa/konfirmasi/' . Crypt::encryptString($jadwal->id)) }}"
                                                class="btn btn-primary tw-rounded-none form-control tw-mt-4">
                                                <i class="fas fa-edit"></i> MULAI
                                            </a>
                                        @elseif ($jadwal->status_ujian == '1')
                                            <a class="btn btn-success tw-rounded-none form-control tw-mt-4 disabled">
                                                <i class="fas fa-exclamation-triangle"></i> SELESAI
                                            </a>
                                        @else
                                            <a class="btn btn-danger tw-rounded-none form-control tw-mt-4 disabled">
                                                <i class="fas fa-exclamation-triangle"></i> SUDAH BERAKHIR
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        function updateClock() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            const timeString = `${hours}:${minutes}:${seconds}`;
            document.getElementById('clock').textContent = timeString;
        }

        // Update the clock immediately
        updateClock();

        // Update the clock every second
        setInterval(updateClock, 1000);
    </script>
@endpush
