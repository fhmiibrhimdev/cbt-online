<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title }} - CBT Online</title>

    <!-- General CSS Files -->
    <link rel="shortcut icon" href="{{ asset('assets/MIDRAGON.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('/assets/stisla/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.2.0/css/all.css" />
    <link rel="stylesheet" href="https://static.fontawesome.com/css/fontawesome-app.css" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/midragon/css/custom.css?v=').time() }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/midragon/css/custom.css') }}">

    @stack('general-css')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/stisla/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/stisla/css/components.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="layout-3" style="font-family: 'Inter', sans-serif">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"
                style="background-image: url('{{ asset('assets/background-cbt.png') }}'); background-size: cover;">
            </div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="{{ url('dashboard') }}"
                    class="navbar-brand sidebar-gone-hide">{{ \App\Models\ProfileSekolah::first('nama_aplikasi')->nama_aplikasi ?? '' }}</a>
                <div class="navbar-nav">
                    <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
                <form class="form-inline ml-auto">
                </form>
                @if (!str_contains(request()->path(), 'siswa/mengerjakan'))
                    <ul class="navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-title">Logged in 5 min ago</div>
                                <a href="/profile" class="dropdown-item has-icon">
                                    <i class="far fa-user"></i> Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="dropdown-item text-danger has-icon"
                                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                                        <i class="far fa-sign-out-alt"></i> Logout
                                    </a>
                                </form>
                            </div>
                        </li>
                    </ul>
                @endif
            </nav>

            <nav class="navbar navbar-secondary navbar-expand-lg">
                <div class="container">
                    <ul class="navbar-nav">
                        @if (request()->is('siswa/ujian') ||
                                str_contains(request()->path(), 'siswa/konfirmasi' || str_contains(request()->path(), 'siswa/mengerjakan')))
                            @if (Auth::user()->hasRole('siswa'))
                                <p class="tw-text-xl tw-text-[#34395e] tw-tracking-wider tw-font-semibold">CBT Tahun
                                    Pelajaran: {{ \App\Models\TahunPelajaran::where('active', '1')->first()->tahun }}
                                    Smt: {{ \App\Models\Semester::where('active', '1')->first()->semester }}</p>
                            @endif
                        @else
                            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                                <a href="/dashboard" class="nav-link">
                                    <i class="far fa-home"></i><span>Dashboard</span>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->hasRole('administrator'))
                            <li
                                class="nav-item dropdown 
                            {{ request()->is('umum/tahun-pelajaran') || request()->is('umum/mata-pelajaran') || request()->is('umum/jurusan') || request()->is('umum/siswa') || request()->is('umum/kelas-rombel') || request()->is('umum/ekstrakurikuler') || request()->is('umum/guru') ? 'active' : '' }}">
                                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown">
                                    <i class="fas fa-users-class"></i><span>Data Umum</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item {{ request()->is('umum/tahun-pelajaran') ? 'active' : '' }}">
                                        <a href="{{ url('/umum/tahun-pelajaran') }}" class="nav-link">Tahun
                                            Pelajaran</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('umum/mata-pelajaran') ? 'active' : '' }}">
                                        <a href="{{ url('/umum/mata-pelajaran') }}" class="nav-link">Mata Pelajaran</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('umum/jurusan') ? 'active' : '' }}">
                                        <a href="{{ url('/umum/jurusan') }}" class="nav-link">Jurusan</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('umum/siswa') ? 'active' : '' }}">
                                        <a href="{{ url('/umum/siswa') }}" class="nav-link">Siswa</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('umum/kelas-rombel') ? 'active' : '' }}">
                                        <a href="{{ url('/umum/kelas-rombel') }}" class="nav-link">Kelas / Rombel</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('umum/ekstrakurikuler') ? 'active' : '' }}">
                                        <a href="{{ url('/umum/ekstrakurikuler') }}"
                                            class="nav-link">Ekstrakurikuler</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('umum/guru') ? 'active' : '' }}">
                                        <a href="{{ url('/umum/guru') }}" class="nav-link">Guru</a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="nav-item dropdown 
                            {{ request()->is('ujian/jenis-ujian') || request()->is('ujian/sesi') || request()->is('ujian/ruang') || request()->is('ujian/atur-ruang') || str_contains(request()->path(), 'ujian/atur-ruang') || request()->is('ujian/nomor-peserta') || request()->is('ujian/bank-soal') || str_contains(request()->path(), 'ujian/bank-soal') || request()->is('ujian/jadwal') || request()->is('ujian/alokasi-waktu') || request()->is('ujian/pengawas') || request()->is('ujian/token') ? 'active' : '' }}">
                                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown">
                                    <i class="far fa-archive"></i><span>Data Ujian</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item {{ request()->is('ujian/jenis-ujian') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/jenis-ujian') }}" class="nav-link">Jenis Ujian</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('ujian/sesi') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/sesi') }}" class="nav-link">Sesi</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('ujian/ruang') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/ruang') }}" class="nav-link">Ruang</a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('ujian/atur-ruang') || str_contains(request()->path(), 'ujian/atur-ruang') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/atur-ruang') }}" class="nav-link">Atur Ruang /
                                            Sesi</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('ujian/nomor-peserta') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/nomor-peserta') }}" class="nav-link">Nomor Peserta</a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('ujian/bank-soal') || str_contains(request()->path(), 'ujian/bank-soal') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/bank-soal') }}" class="nav-link">Bank Soal</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('ujian/jadwal') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/jadwal') }}" class="nav-link">Jadwal</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('ujian/alokasi-waktu') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/alokasi-waktu') }}" class="nav-link">Alokasi Waktu</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('ujian/pengawas') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/pengawas') }}" class="nav-link">Pengawas</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('ujian/token') ? 'active' : '' }}">
                                        <a href="{{ url('ujian/token') }}" class="nav-link">Token</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ request()->is('pengumuman') ? 'active' : '' }}">
                                <a href="{{ url('pengumuman') }}" class="nav-link">
                                    <i class="far fa-bullhorn"></i><span>Pengumuman</span>
                                </a>
                            </li>
                            <li
                                class="nav-item dropdown 
                            {{ request()->is('pelaksanaan-ujian/cetak') || str_contains(request()->path(), 'pelaksanaan-ujian/cetak') || request()->is('pelaksanaan-ujian/status-siswa') || request()->is('pelaksanaan-ujian/hasil-ujian') || request()->is('pelaksanaan-ujian/analisis-soal') || request()->is('pelaksanaan-ujian/rekap') ? 'active' : '' }}">
                                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown">
                                    <i class="far fa-graduation-cap"></i><span>Pelaksanaan Ujian</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li
                                        class="nav-item {{ request()->is('pelaksanaan-ujian/cetak') || str_contains(request()->path(), 'pelaksanaan-ujian/cetak') ? 'active' : '' }}">
                                        <a href="{{ url('pelaksanaan-ujian/cetak') }}" class="nav-link">Cetak</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pelaksanaan-ujian/status-siswa') }}" class="nav-link">Status
                                            Siswa</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pelaksanaan-ujian/hasil-ujian') }}" class="nav-link">Hasil
                                            Ujian</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pelaksanaan-ujian/analisis-soal') }}"
                                            class="nav-link">Analisis
                                            Soal</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('pelaksanaan-ujian/rekap') }}" class="nav-link">Rekap</a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="nav-item dropdown 
                            {{ request()->is('pengaturan/raport') || request()->is('pengaturan/profile-sekolah') || request()->is('pengaturan/administrator') || request()->is('pengaturan/guru') || request()->is('pengaturan/siswa') ? 'active' : '' }}">
                                <a href="#" data-toggle="dropdown" class="nav-link has-dropdown">
                                    <i class="far fa-cogs"></i><span>Pengaturan</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item {{ request()->is('pengaturan/raport') ? 'active' : '' }}">
                                        <a href="{{ url('pengaturan/raport') }}" class="nav-link">Setting
                                            Raport</a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('pengaturan/profile-sekolah') ? 'active' : '' }}">
                                        <a href="{{ url('pengaturan/profile-sekolah') }}" class="nav-link">Profile
                                            Sekolah</a>
                                    </li>
                                    <li
                                        class="nav-item {{ request()->is('pengaturan/administrator') ? 'active' : '' }}">
                                        <a href="{{ url('pengaturan/administrator') }}"
                                            class="nav-link">Administrator</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('pengaturan/guru') ? 'active' : '' }}">
                                        <a href="{{ url('pengaturan/guru') }}" class="nav-link">Guru</a>
                                    </li>
                                    <li class="nav-item {{ request()->is('pengaturan/siswa') ? 'active' : '' }}">
                                        <a href="{{ url('pengaturan/siswa') }}" class="nav-link">Siswa</a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="main-content">
                {{ $slot }}
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2024 <div class="bullet"></div> Created By <a
                        href="http://fahmiibrahimdev.tech/">Fahmi Ibrahim</a>
                </div>
                <div class="footer-right">
                    1.0.1
                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('/assets/midragon/select2/jquery.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/midragon/js/sweetalert2@11.js') }}"></script>
    @stack('js-libraries')

    <!-- Page Specific JS File -->
    <script src="{{ asset('/assets/stisla/js/stisla.js') }}"></script>
    <script>
        window.addEventListener('swal:modal', event => {
            Swal.fire({
                title: event.detail[0].message,
                html: event.detail[0].text,
                icon: event.detail[0].type,
            })
            $("#formDataModal").modal("hide");
            $("#formDataKelompokModal").modal("hide");
            $("#formDataSubKelompokModal").modal("hide");
        })
        window.addEventListener('swal:timer', event => {
            let timerInterval;
            Swal.fire({
                title: event.detail[0].message,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                timer: event.detail[0].timer,
                timerProgressBar: true,
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                willClose: () => {
                    // clearInterval(timerInterval);
                }
            })
        })
        window.addEventListener('swal:confirm', event => {
            Swal.fire({
                title: event.detail[0].message,
                text: event.detail[0].text,
                icon: event.detail[0].type,
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete')
                }
            })
        })
        window.onbeforeunload = function() {
            window.scrollTo(5, 75);
        };
    </script>

    <!-- Template JS File -->
    <script src="{{ asset('/assets/stisla/js/scripts.js') }}"></script>
    <script src="{{ asset('/assets/stisla/js/custom.js') }}"></script>
    @stack('scripts')
</body>

</html>
