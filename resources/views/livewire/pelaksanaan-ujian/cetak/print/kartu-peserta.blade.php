<div>
    <div class="container">
        <div class="row">
            @php
                $classes = ['tw-flex', 'tw-bg-gray-100', 'tw-rounded-md'];

                if ((int) $banyak_aktif + 1 == 7) {
                    $classes[] = 'tw-mt-4';
                } elseif ((int) $banyak_aktif + 1 == 6) {
                    $classes[] = 'tw-mt-7';
                } elseif ((int) $banyak_aktif + 1 == 5) {
                    $classes[] = 'tw-mt-10';
                } elseif ((int) $banyak_aktif + 1 == 4) {
                    $classes[] = 'tw-mt-14';
                } elseif ((int) $banyak_aktif + 1 == 3) {
                    $classes[] = 'tw-mt-2';
                } elseif ((int) $banyak_aktif + 1 == 2) {
                    $classes[] = 'tw-mt-4';
                } elseif ((int) $banyak_aktif + 1 == 1) {
                    $classes[] = 'tw-mt-8';
                }
            @endphp
            @foreach ($data as $row)
                <div class="col-6 d-flex justify-content-center">
                    <div class="{{ implode(' ', $classes) }}">
                        <div class="tw-border tw-border-black tw-p-4 tw-max-w-md tw-bg-white">
                            {{-- {{ $banyak_aktif }} --}}
                            <div
                                class="tw-flex tw-justify-between tw-items-center tw-mb-2 tw-border-b tw-border-black tw-pb-2">
                                <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_aplikasi')->logo_aplikasi) }}"
                                    alt="Logo Left" class="tw-h-14">
                                <div class="tw-text-center px-1">
                                    <h1 class="tw-text-xs">{{ $header_1 }}</h1>
                                    <h2 class="tw-text-xs tw-font-bold tw-text-gray-700">
                                        {{ $header_2 }}</h2>
                                    <h4 class="tw-text-xs">{{ $header_3 }}</h4>
                                    <h4 class="tw-text-xs">{{ $header_4 }}</h4>
                                </div>
                                <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('logo_sekolah')->logo_sekolah) }}"
                                    alt="Logo Right" class="tw-h-14">
                            </div>
                            <div class="tw-text-sm tw-pb-2 tw-mb-2">
                                <table>
                                    <tbody>
                                        @if ($nomor_peserta)
                                            <tr class="tw-text-black">
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="35%">
                                                    Nomor
                                                    Peserta</td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="4%">
                                                    :</td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="50%">
                                                    {{ $row->nomor_peserta }}
                                                </td>
                                                <td></td>
                                            </tr>
                                        @endif
                                        @if ($nama_peserta)
                                            <tr class="tw-text-black">
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="35%">Nama Peserta
                                                </td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="4%">:</td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="50%">
                                                    {{ $row->nama_peserta }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($nis_nisn)
                                            <tr class="tw-text-black">
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="35%">NIS/NISN
                                                </td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="4%">:</td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="50%">
                                                    {{ $row->nis }}/{{ $row->nisn }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr class="tw-text-black">
                                            <td class="tw-border-none tw-p-0 tw-text-xs" width="35%">Kelas</td>
                                            <td class="tw-border-none tw-p-0 tw-text-xs" width="4%">:</td>
                                            <td class="tw-border-none tw-p-0 tw-text-xs" width="50%">
                                                {{ $row->level }} - {{ $row->kode_kelas }}
                                            </td>
                                        </tr>
                                        @if ($ruang_sesi)
                                            <tr class="tw-text-black">
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="35%">Ruang/Sesi
                                                </td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="4%">:</td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="50%">
                                                    {{ $row->kode_ruang }}/{{ $row->kode_sesi }}</td>
                                            </tr>
                                        @endif
                                        @if ($username)
                                            <tr class="tw-text-black">
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="35%">Username
                                                </td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="4%">:</td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="50%">
                                                    {{ $row->username }}
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($password)
                                            <tr class="tw-text-black">
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="35%">Password
                                                </td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="4%">:</td>
                                                <td class="tw-border-none tw-p-0 tw-text-xs" width="50%">
                                                    {{ $row->password }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="tw-flex tw-justify-between tw-items-center tw-mt-2">
                                <div class="tw-flex tw-flex-col tw-items-center tw-border tw-border-black tw-p-2">
                                    <img src="http://localhost:8081/assets/img/siswa.png" alt="Student Photo"
                                        class="tw-h-[70px] tw-w-[60px] tw-border">
                                </div>
                                <div class="tw-text-center tw-text-black">
                                    <p class="tw-text-xs">Jakarta Timur, {{ $tanggal }}</p>
                                    <p class="tw-text-xs tw-font-bold">Kepala Sekolah,</p>
                                    <center>
                                        <img src="{{ Storage::url(\App\Models\ProfileSekolah::first('ttd')->ttd) }}"
                                            alt="Signature" class="tw-h-8 tw-my-2"
                                            style="transform: scale({{ $ukuran_ttd }});">
                                    </center>
                                    <p class="tw-text-xs tw-font-bold">Fahmi Ibrahim</p>
                                    <p class="tw-text-xs">NIP: -</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

@push('scripts')
    <script>
        window.print()
    </script>
@endpush
