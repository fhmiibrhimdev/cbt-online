<div>
    <section class="section custom-section">
        <div class="tw-border-l-4 tw-border-blue-500 tw-bg-blue-100 tw-p-4 tw-mb-4 tw-rounded-md">
            <h4 class="tw-text-blue-700 tw-font-bold tw-mb-2 tw-text-base"> **
                PERATURAN UJIAN **
            </h4>
            <p class="tw-text-blue-700">Selama melaksanakan ULANGAN/UJIAN <b>Siswa
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

        <div class="section-body mt-3">

            <div class="row">
                <div class="col-lg-8">
                    <div class="card card-primary">
                        <h3>Konfirmasi Data</h3>
                        <div class="card-body">
                            <table>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Nama Siswa
                                    </td>
                                    <td class="tw-border tw-tracking-wide">{{ Auth::user()->name }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Pengawas
                                    </td>
                                    <td class="tw-border tw-tracking-wide">{{ $jadwal->nama_guru }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Kelas -
                                        Jurusan</td>
                                    <td class="tw-border tw-tracking-wide">{{ $siswa->level }} -
                                        {{ $siswa->nama_kelas }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Ruang</td>
                                    <td class="tw-border tw-tracking-wide">{{ $siswa->nama_ruang }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Sesi</td>
                                    <td class="tw-border tw-tracking-wide">{{ $siswa->nama_sesi }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Mata
                                        Pelajaran</td>
                                    <td class="tw-border tw-tracking-wide">{{ $jadwal->nama_mapel }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Jenis Ujian
                                    </td>
                                    <td class="tw-border tw-tracking-wide">{{ $jadwal->nama_jenis }}</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Jumlah Soal
                                    </td>
                                    <td class="tw-border tw-tracking-wide">{{ $jadwal->total_soal }} Soal</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Durasi
                                        Ujian</td>
                                    <td class="tw-border tw-tracking-wide">{{ $jadwal->durasi_ujian }} Menit</td>
                                </tr>
                                <tr>
                                    <td class="tw-border tw-tracking-wide" width="30%">Waktu</td>
                                    <td class="tw-border tw-tracking-wide">{{ $siswa->waktu_mulai }} s/d
                                        {{ $siswa->waktu_akhir }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body px-4 tw-text-center">
                            @if ($jadwal->token == '1')
                                <div class="form-group">
                                    <label for="token">MASUKKAN TOKEN</label>
                                    <input type="text" wire:model="token" id="token"
                                        class="form-control tw-rounded-full tw-uppercase tw-text-center">
                                </div>
                            @endif
                            <button wire:click.prevent="checkToken()"
                                class="btn btn-primary form-control tw-rounded-full"><i
                                    class="fas fa-edit tw-text-sm"></i>
                                MULAI</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
