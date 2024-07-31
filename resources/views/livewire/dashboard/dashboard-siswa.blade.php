<div>
    <section class="section custom-section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <h3>Menu Utama</h3>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-lg-2 tw-text-center">
                            <a href="{{ url('/siswa/jadwal-pelajaran') }}" class="tw-no-underline tw-tracking-wider">
                                <i class="far fa-calendar-exclamation tw-text-5xl tw-mb-3 text-primary"></i>
                                <p class="tw-font-semibold tw-text-[#34395e]">Jadwal Pelajaran</p>
                            </a>
                        </div>
                        <div class="col-lg-2 tw-text-center">
                            <a href="{{ url('/siswa/materi') }}" class="tw-no-underline tw-tracking-wider">
                                <i class="far fa-books tw-text-5xl tw-mb-3 tw-text-purple-600"></i>
                                <p class="tw-font-semibold tw-text-[#34395e]">Materi</p>
                            </a>
                        </div>
                        <div class="col-lg-2 tw-text-center">
                            <a href="{{ url('/siswa/tugas') }}" class="tw-no-underline tw-tracking-wider">
                                <i class="far fa-tasks tw-text-5xl tw-mb-3 tw-text-blue-600"></i>
                                <p class="tw-font-semibold tw-text-[#34395e]">Tugas</p>
                            </a>
                        </div>
                        <div class="col-lg-2 tw-text-center">
                            <a href="{{ url('/siswa/ujian') }}" class="tw-no-underline tw-tracking-wider">
                                <i class="far fa-users-class tw-text-5xl tw-mb-3 tw-text-red-600"></i>
                                <p class="tw-font-semibold tw-text-[#34395e]">Ujian / Ulangan</p>
                            </a>
                        </div>
                        <div class="col-lg-2 tw-text-center">
                            <a href="{{ url('/siswa/hasil') }}" class="tw-no-underline tw-tracking-wider">
                                <i class="far fa-diploma tw-text-5xl tw-mb-3 tw-text-green-600"></i>
                                <p class="tw-font-semibold tw-text-[#34395e]">Nilai Hasil</p>
                            </a>
                        </div>
                        <div class="col-lg-2 tw-text-center">
                            <a href="{{ url('/siswa/absensi') }}" class="tw-no-underline tw-tracking-wider">
                                <i class="far fa-chalkboard-teacher tw-text-5xl tw-mb-3 tw-text-teal-600"></i>
                                <p class="tw-font-semibold tw-text-[#34395e]">Absensi</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
