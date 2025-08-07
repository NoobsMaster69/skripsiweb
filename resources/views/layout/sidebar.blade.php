<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fas fa-folder"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Luaran <br> Akademik </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    {{-- <li class="nav-item {{ $menuDashboard ?? '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li> --}}
    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Divider -->
    {{-- --------------------------------------------------------------------------------------------------------------------------------------------- --}}
    <!-- Heading -->
    {{-- MENU BPM/ADMIN --}}
    @if (Auth::user()->jabatan == 'admin')
        <div class="sidebar-heading">
            Menu Admin
        </div>

        <li class="nav-item {{ $menuDashboard ?? '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">

        <!-- Nav Item - Penetapan Collapse Menu -->
        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterDokumen"
                aria-expanded="true" aria-controls="collapseMasterDokumen">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Master Dokumen</span>
            </a>
            <div id="collapseMasterDokumen" class="collapse" aria-labelledby="headingMasterDokumen"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master Dokumen</h6>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('master-dokumen') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Master Dokumen Buku Kebijakan
                    </a>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('master-dokumen-buku') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Master Dokumen Buku Kurikulum
                    </a>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('master-dokumen-peninjauan') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Master Dokumen Peninjauan Kurikulum
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterCPL"
                aria-expanded="true" aria-controls="collapseMasterCPL">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Master CPL Admin</span>
            </a>
            <div id="collapseMasterCPL" class="collapse" aria-labelledby="headingMasterCPL"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master CPL Admin</h6>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('master-cpl') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Master CPL Admin
                    </a>
                </div>
            </div>
        </li>

        {{-- <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDashboard"
                aria-expanded="true" aria-controls="collapseDashboard">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Dashboard</span>
            </a>
            <div id="collapseDashboard" class="collapse" aria-labelledby="headingDashboard"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Dashboard</h6>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('rekapCpl.dashboard') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Dashboard
                    </a>
                </div>
            </div>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePenetapan"
                aria-expanded="true" aria-controls="collapsePenetapan">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Penetapan</span>
            </a>
            <div id="collapsePenetapan" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Validasi Dok Kebijakan</h6>
                    <a class="collapse-item text-wrap" href="{{ route('dok-kebijakan') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Validasi Dokumen Kebijakan
                    </a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pelaksanaan Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelaksanaan"
                aria-expanded="false" aria-controls="collapsePelaksanaan">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pelaksanaan</span>
            </a>
            <div id="collapsePelaksanaan" class="collapse" aria-labelledby="headingPenetapan"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Pelaksanaan</h1>

                    <!-- Submenu - Pendidikan -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsePendidikan" aria-expanded="false" aria-controls="collapsePendidikan">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Pendidikan</span>
                    </a>
                    <div id="collapsePendidikan" class="collapse ml-3" aria-labelledby="headingPendidikan"
                        data-parent="#collapsePenetapan">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item text-wrap" href="{{ route('cpl-bpm') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Rekap Pemenuhan Capaian Pembelajaran
                            </a>

                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('RataIpk') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Rata-Rata IPK</a>
                            <!-- Garis pemisah -->
                            {{-- <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                        <a class="collapse-item text-wrap" href="{{ route('validasi_Karyamhs') }}"
                            style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                            Validasi Karya Mahasiswa</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapsevalidasikaryamhs" aria-expanded="false"
                aria-controls="collapsevalidasikaryamhs">
                <i class="fas fa-fw fa-cog"></i>
                <span>Validasi Karya MHS</span>
            </a>
            <div id="collapsevalidasikaryamhs" class="collapse" aria-labelledby="headingvalidasikaryamhs"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Validasi karya mahasiswa</h1>

                    <!-- Submenu - Pendidikan -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsevalidasikaryamhs1" aria-expanded="false"
                        aria-controls="collapsevalidasikaryamhs1">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Karya mahasiswa</span>
                    </a>
                    <div id="collapsevalidasikaryamhs1" class="collapse ml-3"
                        aria-labelledby="headingvalidasikaryamhs1" data-parent="#collapsevalidasikaryamhs1">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('valid-prestasimhs') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Prestasi mahasiswa
                            </a>
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('valid-serkom') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Sertifikasi kompetensi mahasiswa
                            </a>
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('valid-mhsHki') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Mahasiswa yang mendapatkan HKI
                            </a>
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('valid-publikasi') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Publikasi mahasiswa
                            </a>
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('valid-karyaAdopsi') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Karya mahasiswa yang diadopsi masyarakat
                            </a>
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('valid-karyalainnya') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Karya mahasiswa lainnya
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapsevalidasikaryadosen" aria-expanded="false"
                aria-controls="collapsevalidasikaryadosen">
                <i class="fas fa-fw fa-cog"></i>
                <span>Validasi Karya Dosen</span>
            </a>
            <div id="collapsevalidasikaryadosen" class="collapse" aria-labelledby="headingvalidasikaryadosen"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Validasi Karya Dosen</h1>

                    <!-- Submenu - Karya Dosen -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsevalidasikaryadosen1" aria-expanded="false"
                        aria-controls="collapsevalidasikaryadosen1">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Karya Dosen</span>
                    </a>
                    <div id="collapsevalidasikaryadosen1" class="collapse ml-3"
                        aria-labelledby="headingvalidasikaryadosen1" data-parent="#collapsevalidasikaryadosen">
                        <!-- ✅ perbaikan di sini -->
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('karyaDosenValid') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Karya Dosen yang mendapatkan HKI
                            </a>
                        </div>
                    </div>
                    <!-- Submenu - Rekognisi -->
                    <a class="collapse-item collapsed mt-2" href="#" data-toggle="collapse"
                        data-target="#collapsevalidasikaryaRekognisi" aria-expanded="false"
                        aria-controls="collapsevalidasikaryaRekognisi">
                        <i class="fas fa-fw fa-award"></i>
                        <span>Rekognisi Dosen</span>
                    </a>

                    <div id="collapsevalidasikaryaRekognisi" class="collapse ml-3"
                        aria-labelledby="headingvalidasikaryaRekognisi" data-parent="#collapsevalidasikaryadosen">
                        <!-- ✅ perbaikan di sini -->
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('rekognisiDosenValid') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Karya Rekognisi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </li>

        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRekapCpl1"
                aria-expanded="true" aria-controls="collapseRekapCpl1">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Rekap CPL Admin</span>
            </a>
            <div id="collapseRekapCpl1" class="collapse" aria-labelledby="headingRekapCpl1"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master CPL Admin</h6>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('rekapCPL.admin') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap CPL Admin
                    </a>
                </div>
            </div>
        </li>

        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseREKAPBPM"
                aria-expanded="true" aria-controls="collapseREKAPBPM">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Rekap Luaran</span>
            </a>
            <div id="collapseREKAPBPM" class="collapse" aria-labelledby="headingREKAPBPM"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Rekap Prestasi</h6>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapBPM.prestasi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap Prestasi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapBPM.serkom') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Sertifikasi Kompetensi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapBPM.mhsHki') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Mahasiswa yang mendapatkan HKI
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapBPM.publikasi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Publikasi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapBPM.mhsAdopsi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Karya Mahasiswa yang diadopsi oleh masyarakat
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapBPM.mhsKaryaLainnya') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Karya Mahasiswa Lainnya
                    </a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRekognisiDos"
                aria-expanded="false" aria-controls="collapseRekognisiDos">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Rekap Rekognisi</span>
            </a>
            <div id="collapseRekognisiDos" class="collapse" aria-labelledby="headingRekognisiDos"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Rekap Rekognisi</h1>

                    <a class="collapse-item text-wrap" href="{{ route('rekapRekognisi.index') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap Rekognisi
                    </a>
                </div>
            </div>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRekapIpk"
                aria-expanded="false" aria-controls="collapseRekapIpk">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Rekap IPK</span>
            </a>
            <div id="collapseRekapIpk" class="collapse" aria-labelledby="headingRekapIpk"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Rekap IPK</h1>

                    <a class="collapse-item text-wrap" href="{{ route('rekapIPK.index') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap IPK
                    </a>
                </div>
            </div>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProfilLulus"
                aria-expanded="false" aria-controls="collapseProfilLulus">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Profil Lulus</span>
            </a>
            <div id="collapseProfilLulus" class="collapse" aria-labelledby="headingProfilLulus"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">View Profil Lulus</h1>

                    <a class="collapse-item text-wrap" href="{{ route('admin.pl.index') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        View Profil Lulus
                    </a>
                </div>
            </div>
        </li>
    @endif







    {{-- --------------------------------------------------------------------------------------------------------------------------------------------- --}}



    <!-- BAGIAN MENUU ADMIN == REKTORAT  -->
    @if (Auth::user()->jabatan == 'rektorat')
        <!-- Divider -->

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu Rektorat
        </div>
        <li class="nav-item {{ $menuDashboard ?? '' }}">
            <a class="nav-link" href="{{ route('rektorat.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMasterdok"
                aria-expanded="true" aria-controls="collapseMasterdok">
                <i class="fas fa-fw fa-wrench"></i>
                <span>View Dok kebijakan</span>
            </a>
            <div id="collapseMasterdok" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">View dan Download</h6>
                    <a class="collapse-item" href="{{ route('rektorat.master-dokumen.index') }}">View Dok
                        Kebijakan</a>
                </div>
            </div>
        </li>
        <!-- Nav Item - Penetapan Collapse Menu -->
        <li class="nav-item {{ $menuRek1 ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePenetapan1"
                aria-expanded="true" aria-controls="collapsePenetapan1">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Penetapan Rektor</span>
            </a>
            <div id="collapsePenetapan1" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Penetapan</h6>
                    <a class="collapse-item" href="{{ route('dok-rek.index') }}">Dokumen Kebijakan</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pelaksanaan Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelaksanaan1"
                aria-expanded="false" aria-controls="collapsePelaksanaan1">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pelaksanaan Rektorat</span>
            </a>

            <div id="collapsePelaksanaan1" class="collapse" aria-labelledby="headingPelaksanaan1"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pelaksanaan</h6>

                    <!-- Submenu - Pendidikan -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsePendidikan1" aria-expanded="false" aria-controls="collapsePendidikan1">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Pendidikan</span>
                    </a>

                    <div id="collapsePendidikan1" class="collapse" aria-labelledby="headingPendidikan1"
                        data-parent="#collapsePelaksanaan1">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('rekapCPL.rektorat') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Rekap CPL Rektorat
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRekognisiDos"
                aria-expanded="false" aria-controls="collapseRekognisiDos">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Rekap Rekognisi</span>
            </a>
            <div id="collapseRekognisiDos" class="collapse" aria-labelledby="headingRekognisiDos"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Rekap Rekognisi</h1>

                    <a class="collapse-item text-wrap" href="{{ route('rekapRekognisiRektorat.index') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap Rekognisi
                    </a>
                </div>
            </div>
        </li>


        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseREKAPBPM"
                aria-expanded="true" aria-controls="collapseREKAPBPM">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Rekap Luaran</span>
            </a>
            <div id="collapseREKAPBPM" class="collapse" aria-labelledby="headingREKAPBPM"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Rekap Prestasi</h6>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapRektorat.prestasi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap Prestasi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapRektorat.serkom') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Sertifikasi Kompetensi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapRektorat.mhsHki') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Mahasiswa yang mendapatkan HKI
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapRektorat.publikasi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Publikasi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapRektorat.mhsAdopsi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Karya Mahasiswa yang diadopsi oleh masyarakat
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapRektorat.mhsKaryaLainnya') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Karya Mahasiswa Lainnya
                    </a>
                </div>
            </div>

        </li>
    @endif



    {{-- ----------------------------------------------------------------------------------------------------------------------------------------------- --}}




    <!-- BAGIAN MENUU ADMIN == FAKULTAS  -->
    @if (Auth::user()->jabatan == 'fakultas')
        <!-- Divider -->

        <!-- Heading Fakultas-->
        <div class="sidebar-heading">
            Menu Fakultas
        </div>
        <li class="nav-item {{ $menuDashboard ?? '' }}">
            <a class="nav-link" href="{{ route('fakultas.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Nav Item - Penetapan Collapse Menu Fakultas -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePenetapan2"
                aria-expanded="true" aria-controls="collapsePenetapan2">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>View Dok Kebijakan</span>
            </a>
            <div id="collapsePenetapan2" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Penetapan </h6>
                    <a class="collapse-item" href="{{ route('fakultas.dokrek.index') }}">Dokumen Kebijakan</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pelaksanaan Collapse Menu Fakultas -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelaksanaan2"
                aria-expanded="false" aria-controls="collapsePelaksanaan2">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pelaksanaan</span>
            </a>
            <div id="collapsePelaksanaan2" class="collapse" aria-labelledby="headingPelaksanaan2"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Pelaksanaan Fakultas</h1>

                    <!-- Submenu - Pendidikan -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsePendidikan2" aria-expanded="false" aria-controls="collapsePendidikan2">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Pendidikan</span>
                    </a>
                    <!-- Tambahkan div dengan ID yang sesuai dengan data-target -->
                    <div id="collapsePendidikan2" class="collapse pl-3">
                        <a class="collapse-item text-wrap" href="{{ route('rekapCPL.fakul') }}">
                            Rekap CPL Fakultas
                        </a>
                    </div>
                </div>
            </div>
        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelaksanaan12"
                aria-expanded="false" aria-controls="collapsePelaksanaan12">
                <i class="fas fa-fw fa-cog"></i>
                <span>Validasi Pelaksanaan</span>
            </a>
            <div id="collapsePelaksanaan12" class="collapse" aria-labelledby="headingPelaksanaan12"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Validasi Pelaksanaan</h1>

                    <!-- Submenu - Pendidikan -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsePendidikan" aria-expanded="false" aria-controls="collapsePendidikan">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Pendidikan</span>
                    </a>
                    <div id="collapsePendidikan" class="collapse ml-3" aria-labelledby="headingPendidikan"
                        data-parent="#collapsePelaksanaan12"> <!-- ✅ diperbaiki dari #collapsePenetapan -->
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>

                            <a class="collapse-item text-wrap" href="{{ route('bukuKurikulumValid') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Validasi Buku Kurikulum
                            </a>

                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>

                            <a class="collapse-item text-wrap" href="{{ route('peninjauanKurikulumValid') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Validasi Buku Peninjauan Kurikulum
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </li>


        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseREKAPFAKUL"
                aria-expanded="true" aria-controls="collapseREKAPFAKUL">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Rekap Luaran</span>
            </a>
            <div id="collapseREKAPFAKUL" class="collapse" aria-labelledby="headingREKAPFAKUL"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Rekap Prestasi</h6>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapFakul.prestasi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap Prestasi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapFakul.serkom') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Sertifikasi Kompetensi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapFakul.mhsHki') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Mahasiswa yang mendapatkan HKI
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapFakul.publikasi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Publikasi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapFakul.mhsAdopsi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Karya Mahasiswa yang diadopsi oleh masyarakat
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapFakul.mhsKaryaLainnya') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Karya Mahasiswa Lainnya
                    </a>
                </div>
            </div>

        </li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapseRekognisiDosProd" aria-expanded="false"
                aria-controls="collapseRekognisiDosProd">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Rekap Rekognisi</span>
            </a>
            <div id="collapseRekognisiDosProd" class="collapse" aria-labelledby="headingRekognisiDosProd"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Rekap Rekognisi</h1>

                    <a class="collapse-item text-wrap" href="{{ route('rekapRekognisiFakul.index') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap Rekognisi
                    </a>
                </div>
            </div>
        </li>


        {{-- <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapseRekapCplFakul1" aria-expanded="true" aria-controls="collapseRekapFakul1">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Rekap CPL Fakultas</span>
            </a>
            <div id="collapseRekapCplFakul1" class="collapse" aria-labelledby="headingRekapFakul1"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master Fakultas</h6>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('rekapCPL.fakul') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap CPL Fakultas
                    </a>
                </div>
            </div>
        </li> --}}
    @endif




    {{-- ---------------------------------------------------------------------------------------------------------------------------------------------- --}}




    <!-- BAGIAN MENUU ADMIN == PRODI FTI  -->
    @if (Auth::user()->jabatan == 'prodi')
        <!-- Divider -->

        <!-- Heading Prodi -->
        <div class="sidebar-heading">
            Menu Prodi
        </div>
        <li class="nav-item {{ $menuDashboard ?? '' }}">
            <a class="nav-link" href="{{ route('prodi.dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapseMasterDokumenProdi" aria-expanded="true"
                aria-controls="collapseMasterDokumenProdi">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>View Dok Kebijakan</span>
            </a>
            <div id="collapseMasterDokumenProdi" class="collapse" aria-labelledby="headingMasterDokumenProdi"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master Dokumen</h6>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('prodi.master-dokumen-buku') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Master Dokumen Buku Kurikulum
                    </a>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('prodi.master-dokumen-peninjauan') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Master Dokumen Peninjauan Kurikulum
                    </a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Penetapan Collapse Menu Prodi -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePenetapan3"
                aria-expanded="true" aria-controls="collapsePenetapan3">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>View Dok Kebijakan</span>
            </a>
            <div id="collapsePenetapan3" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Penetapan Prodi</h6>
                    <a class="collapse-item" href="{{ route('prodi.dokrek.index') }}">Dokumen Kebijakan</a>
                </div>
            </div>
        </li>



        <!-- Nav Item - Pelaksanaan Collapse Menu Prodi -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelaksanaan3"
                aria-expanded="false" aria-controls="collapsePelaksanaan3">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pelaksanaan</span>
            </a>
            <div id="collapsePelaksanaan3" class="collapse" aria-labelledby="headingPenetapan3"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header" style="margin-bottom: 10px; padding: 8px 15px; display: block;">
                        Pelaksanaan Prodi</h1>

                    <!-- Submenu - Pendidikan -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsePendidikan3" aria-expanded="false" aria-controls="collapsePendidikan3"
                        style="margin-bottom: 10px; padding: 8px 15px; display: block;">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Pendidikan </span>
                    </a>
                    <div id="collapsePendidikan3" class="collapse ml-3" aria-labelledby="headingPendidikan3"
                        data-parent="#collapsePendidikan3">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="{{ route('prodi-fti') }}">Profil Lulusan</a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="{{ route('plprodi-fti') }}">Capaian Prodi</a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="{{ route('buku-kurikulumfti') }}">Buku Kurikulum Prodi</a>


                            <!-- Garis pemisah -->
                            {{-- <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('cp-prodi-fti') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Pemenuhan Capaian Pembelajaran
                            </a> --}}


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="{{ route('peninjauan-kurikulum.index') }}">Peninjauan
                                Kurikulum</a>


                            <!-- Garis pemisah -->
                            {{-- <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div> --}}
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            {{-- <a class="collapse-item" href="dokumen-kebijakan.html">SKKM</a> --}}


                            <!-- Garis pemisah -->
                            {{-- <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                        <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                            style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                            Kelulusan Tepat Waktu (Masa Studi)
                        </a> --}}


                            <!-- Garis pemisah -->
                            {{-- <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                        <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                            style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                            Pelacakan dan Perekaman Data Lulusan
                        </a> --}}


                            <!-- Garis pemisah -->
                            {{-- <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                        <a class="collapse-item text-wrap" href="{{ route('RataMT-fti') }}"
                            style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                            Rata-Rata Masa Tunggu
                        </a> --}}


                            <!-- Garis pemisah -->
                            {{-- <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                        <a class="collapse-item text-wrap" href="{{ route('kesesuaian-fti') }}"
                            style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                            Kesesuaian Bidang Kerja dengan bidang prodi
                        </a> --}}


                            <!-- Garis pemisah -->
                            {{-- <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                        <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                            style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                            Jangkauan Operasi Kerja Lulusan
                        </a> --}}
                        </div>
                    </div>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapseKaryamahasiswa1" aria-expanded="false"
                        aria-controls="collapseKaryamahasiswa1"
                        style="margin-bottom: 10px; padding: 8px 15px; display: block;">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Karya Mahasiswa</span>
                    </a>

                    <div id="collapseKaryamahasiswa1" class="collapse ml-3" aria-labelledby="headingKaryamahasiswa1"
                        data-parent="#collapsePelaksanaan3">

                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="{{ route('prestasi-mahasiswa-fti') }}">Prestasi
                                Mahasiswa</a>

                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('Sertifikasi-komp-fti') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Sertifikasi Kompetensi Mahasiswa
                            </a>

                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('mahasiswa-hki-fti') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Mahasiswa yang mendapatkan HKI
                            </a>

                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('publikasi-mahasiswa-fti') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Publikasi Mahasiswa
                            </a>

                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('mahasiswa-diadopsi-fti') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Karya mahasiswa yang diadopsi masyarakat
                            </a>

                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('mahasiswa-lainnya-fti') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Karya mahasiswa lainnya
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </li>

        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseREKAPPRODI"
                aria-expanded="true" aria-controls="collapseREKAPPRODI">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Rekap Luaran</span>
            </a>
            <div id="collapseREKAPPRODI" class="collapse" aria-labelledby="headingREKAPPRODI"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Rekap Prestasi</h6>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapProdi.prestasi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap Prestasi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapProdi.serkom') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Sertifikasi Kompetensi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapProdi.mhsHki') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Mahasiswa yang mendapatkan HKI
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapProdi.publikasi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Publikasi Mahasiswa
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapProdi.mhsAdopsi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Karya Mahasiswa yang diadopsi oleh masyarakat
                    </a>
                    <hr class="my-2">
                    <a class="collapse-item text-wrap mb-2" href="{{ route('rekapProdi.mhsKaryaLainnya') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Karya Mahasiswa Lainnya
                    </a>
                </div>
            </div>

        </li>

        <li class="nav-item {{ $menuMasterDok ?? '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapseRekapCplFakul1" aria-expanded="true" aria-controls="collapseRekapFakul1">
                <i class="fas fa-fw fa-folder-open"></i>
                <span>Rekap CPL </span>
            </a>
            <div id="collapseRekapCplFakul1" class="collapse" aria-labelledby="headingRekapFakul1"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Master </h6>
                    <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                    <a class="collapse-item text-wrap" href="{{ route('rekapCPL.prodi') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap CPL
                    </a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse"
                data-target="#collapseRekognisiDosProd" aria-expanded="false"
                aria-controls="collapseRekognisiDosProd">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Rekap Rekognisi</span>
            </a>
            <div id="collapseRekognisiDosProd" class="collapse" aria-labelledby="headingRekognisiDosProd"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Rekap Rekognisi</h1>

                    <a class="collapse-item text-wrap" href="{{ route('rekapRekognisiProdi.index') }}"
                        style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                        Rekap Rekognisi
                    </a>
                </div>
            </div>
        </li>
    @endif

    {{-- -------------------------------------------------------------------------------------------------------------------------------------------------- --}}
    <!-- BAGIAN MENUU ADMIN == PRODI FEB  -->
    @if (Auth::user()->jabatan == 'prodi')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading Prodi -->
        <div class="sidebar-heading">
            Menu Prodi FEB
        </div>
        <!-- Nav Item - Penetapan Collapse Menu Prodi -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePenetapan03"
                aria-expanded="true" aria-controls="collapsePenetapan03">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Penetapan Prodi</span>
            </a>
            <div id="collapsePenetapan03" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Penetapan Prodi</h6>
                    <a class="collapse-item" href="utilities-color.html">Dokumen Kebijakan</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pelaksanaan Collapse Menu Prodi -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelaksanaan03"
                aria-expanded="false" aria-controls="collapsePelaksanaan03">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pelaksanaan Prodi</span>
            </a>
            <div id="collapsePelaksanaan03" class="collapse" aria-labelledby="headingPenetapan03"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Pelaksanaan Prodi</h1>

                    <!-- Submenu - Pendidikan -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsePendidikan03" aria-expanded="false"
                        aria-controls="collapsePendidikan03">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Pendidikan </span>
                    </a>
                    <div id="collapsePendidikan03" class="collapse ml-3" aria-labelledby="headingPendidikan03"
                        data-parent="#collapsePendidikan03">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="{{ route('prodi-feb') }}">Profil dan CPL Prodi</a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="dokumen-kebijakan.html">Buku Kurikulum Prodi</a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Pemenuhan Capaian Pembelajaran
                            </a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="dokumen-kebijakan.html">Peninjauan Kurikulum</a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="dokumen-kebijakan.html">Prestasi Mahasiswa</a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Sertifikasi Kompetensi Mahasiswa
                            </a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="dokumen-kebijakan.html">Publikasi Mahasiswa</a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Karya Mahasiswa Lainnya
                            </a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            {{-- <h1 class="collapse-header">Pendidikan</h1> --}}
                            <a class="collapse-item" href="dokumen-kebijakan.html">SKKM</a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Kelulusan Tepat Waktu (Masa Studi)
                            </a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Pelacakan dan Perekaman Data Lulusan
                            </a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="#"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Rata-Rata Masa Tunggu
                            </a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Kesesuaian Bidang Kerja dengan bidang prodi
                            </a>


                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="dokumen-kebijakan.html"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Jangkauan Operasi Kerja Lulusan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    @endif
    {{-- ---------------------------------------------------------------------------------------------------------------------------------------------- --}}

    <!-- BAGIAN MENUU ADMIN == MENU DOSEN  -->
    @if (Auth::user()->jabatan == 'dosen')
        <!-- Divider Dosen -->

        <!-- Heading Dosen -->
        <div class="sidebar-heading">
            Menu Dosen
        </div>
        <!-- Nav Item - Penetapan Collapse Menu Dosen -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePenetapan4"
                aria-expanded="true" aria-controls="collapsePenetapan4">
                <i class="fas fa-fw fa-wrench"></i>
                <span>View Penetapan </span>
            </a>
            <div id="collapsePenetapan4" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Penetapan Dosen</h6>
                    <a class="collapse-item" href="{{ route('dosen.dokrek.index') }}">Dokumen Kebijakan</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Pelaksanaan Collapse Menu Dosen -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePelaksanaan4"
                aria-expanded="false" aria-controls="collapsePelaksanaan4">
                <i class="fas fa-fw fa-cog"></i>
                <span>Pelaksanaan</span>
            </a>
            <div id="collapsePelaksanaan4" class="collapse" aria-labelledby="headingPenetapan4"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h1 class="collapse-header">Pelaksanaan Dosen</h1>

                    <!-- Submenu - Pendidikan -->
                    <a class="collapse-item collapsed" href="#" data-toggle="collapse"
                        data-target="#collapsePendidikan4" aria-expanded="false" aria-controls="collapsePendidikan4">
                        <i class="fas fa-fw fa-book"></i>
                        <span>Pendidikan Dosen</span>
                    </a>
                    <div id="collapsePendidikan4" class="collapse ml-3" aria-labelledby="headingPendidikan4"
                        data-parent="#collapsePendidikan4">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item text-wrap" href="{{ route('cpl-dosen') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">
                                Pemenuhan Capaian Pembelajaran
                            </a>
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item" href="{{ route('dosen.rekognisi.index') }}">Rekognisi Dosen</a>
                            <!-- Garis pemisah -->
                            <div style="border-top: 1px solid #e2e2e2; margin: 0.5rem 0;"></div>
                            <a class="collapse-item" href="{{ route('karya-dosen.index') }}"
                                style="white-space: normal; word-break: break-word; font-size: 0.860rem; width: 160px;">Karya
                                Dosen yang mendapatkan HKI</a>
                        </div>
                    </div>
                </div>
            </div>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDosenPel1"
                aria-expanded="true" aria-controls="collapseDosenPel1">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Pelaksanaan Pendidikan</span>
            </a>
            <div id="collapseDosenPel1" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pelaksanaan Pendidikan</h6>
                    <a class="collapse-item" href="#">Pelaksanaan Pendidikan</a>
                </div>
            </div>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDosenPel2"
                aria-expanded="true" aria-controls="collapseDosenPel2">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Pelaksanaan Penelitian</span>
            </a>
            <div id="collapseDosenPel2" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pelaksanaan Penelitian</h6>
                    <a class="collapse-item" href="#">Pelaksanaan Penelitian</a>
                </div>
            </div>
        </li> --}}
        {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDosenPel3"
                aria-expanded="true" aria-controls="collapseDosenPel3">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Pelaksanaan Pengabdian</span>
            </a>
            <div id="collapseDosenPel3" class="collapse" aria-labelledby="headingUtilities"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pelaksanaan Pengabdian</h6>
                    <a class="collapse-item" href="#">Pelaksanaan Pengabdian</a>
                </div>
            </div>
        </li> --}}
    @endif

    {{-- ----------------------------------------------------------------------------------------------------------------------------------------------- --}}
    @if (Auth::user()->jabatan == 'admin')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Data User
        </div>

        <!-- Nav Item - Charts -->
        <li class="nav-item {{ $menuAdminUser ?? '' }}">
            <a class="nav-link" href="{{ route('user') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Data User</span></a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Logout
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center justify-content-center" href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt me-2" style="font-size: 1.25rem;"></i>
            <span style="font-size: 1.1rem;">Logout</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
