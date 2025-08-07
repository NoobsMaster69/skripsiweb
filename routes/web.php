<?php

use App\Models\DokRek;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlFtiController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\CplBpmController;
use App\Http\Controllers\CplFebController;
use App\Http\Controllers\CplFtiController;
use App\Http\Controllers\DokRekController;
use App\Http\Controllers\RataMTController;
use App\Http\Controllers\CpProdiController;
use App\Http\Controllers\PlProdiController;
use App\Http\Controllers\RataIpkController;
use App\Http\Controllers\CplDosenController;
use App\Http\Controllers\RekapIpkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterDokController;
use App\Http\Controllers\TargetRekController;
use App\Http\Controllers\KaryaDosenController;
use App\Http\Controllers\PlFtiAdminController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ValidasiKaryaLainnya;
use App\Http\Controllers\DosenDokRekController;
use App\Http\Controllers\KaryaMhsFtiController;
use App\Http\Controllers\ProdiDokRekController;
use App\Http\Controllers\TargetDosenController;
use App\Http\Controllers\TargetFakulController;
use App\Http\Controllers\DokKebijakanController;
use App\Http\Controllers\BukuKurikulumController;
use App\Http\Controllers\DashbordAdminController;
use App\Http\Controllers\DashbordProdiController;
use App\Http\Controllers\RekapCPLadminController;
use App\Http\Controllers\RekapCPLfakulController;
use App\Http\Controllers\RekapCPLprodiController;
use App\Http\Controllers\FakultasDokRekController;
use App\Http\Controllers\MasterCPLadminController;
use App\Http\Controllers\PrestasiMhsFtiController;
use App\Http\Controllers\RekapBPMmhsHkiController;
use App\Http\Controllers\RekapBPMSerkomController;
use App\Http\Controllers\RekapRekognisiController;
use App\Http\Controllers\RekognisiDosenController;
use App\Http\Controllers\ValidasiMhsHkiController;
use App\Http\Controllers\ValidasiSerkomController;
use App\Http\Controllers\AdminSubmissionController;
use App\Http\Controllers\MahasiswaHkiFtiController;
use App\Http\Controllers\MasterDokumentsController;
use App\Http\Controllers\PublikasiMhsFtiController;
use App\Http\Controllers\DashbordFakultasController;
use App\Http\Controllers\DashbordRektoratController;
use App\Http\Controllers\KaryaMhsValidateController;
use App\Http\Controllers\KesesuaianBidangController;
use App\Http\Controllers\RekapBPMPrestasiController;
use App\Http\Controllers\RekapCPLrektoratController;
use App\Http\Controllers\RekapFakulmhsHkiController;
use App\Http\Controllers\RekapFakulSerkomController;
use App\Http\Controllers\RekapProdimhsHkiController;
use App\Http\Controllers\RekapProdiSerkomController;
use App\Http\Controllers\ValidasiPrestasiController;
use App\Http\Controllers\MasterDokumentRekController;
use App\Http\Controllers\RekapBPMmhsAdopsiController;
use App\Http\Controllers\RekapBPMpublikasiController;
use App\Http\Controllers\ValidasiPublikasiController;
use App\Http\Controllers\MahasiswadiadopFtiController;
use App\Http\Controllers\MasterDokumentBukuController;
use App\Http\Controllers\RekapFakulPrestasiController;
use App\Http\Controllers\RekapProdiPrestasiController;
use App\Http\Controllers\RektoratSubmissionController;
use App\Http\Controllers\SertifikasiKompFtiController;
use App\Http\Controllers\MahasiswaLainnyaFtiController;
use App\Http\Controllers\MasterDokumentProdiController;
use App\Http\Controllers\PeninjauanKurikulumController;
use App\Http\Controllers\RekapFakulmhsAdopsiController;
use App\Http\Controllers\RekapFakulpublikasiController;
use App\Http\Controllers\RekapProdimhsAdopsiController;
use App\Http\Controllers\RekapProdipublikasiController;
use App\Http\Controllers\RekapRekognisiFakulController;
use App\Http\Controllers\RekapRekognisiProdiController;
use App\Http\Controllers\RekapRektoratmhsHkiController;
use App\Http\Controllers\RekapRektoratSerkomController;
use App\Http\Controllers\SertifKompetensiFtiController;
use App\Http\Controllers\ValidasiKaryaAdopsiController;
use App\Http\Controllers\Admin\MasterDocumentController;
use App\Http\Controllers\karyaDosenValidAdminController;
use App\Http\Controllers\PrestasiMahasiswaFtiController;
use App\Http\Controllers\ValidateDokKebijakanController;
use App\Http\Controllers\RekapRektoratPrestasiController;
use App\Http\Controllers\ValidateBukuKurikulumController;
use App\Http\Controllers\RekapRekognisiRektoratController;
use App\Http\Controllers\RekapRektoratmhsAdopsiController;
use App\Http\Controllers\RekapRektoratpublikasiController;
use App\Http\Controllers\BukuKurikulumValidAdminController;
use App\Http\Controllers\MasterDokumenPeninjauanController;
use App\Http\Controllers\RekapBPMmhsKaryalainnyaController;
use App\Http\Controllers\MasterDokumentPeninjauanController;
use App\Http\Controllers\RekognisiDosenValidAdminController;
use App\Http\Controllers\RekapFakulmhsKaryalainnyaController;
use App\Http\Controllers\RekapProdimhsKaryalainnyaController;
use App\Http\Controllers\MasterDokumentBukuRektoratController;
use App\Http\Controllers\MasterDokumentBukuKurikulumController;
use App\Http\Controllers\ValidatePeninjauanKurikulumController;
use App\Http\Controllers\MasterDokumentPeninjaunProdiController;
use App\Http\Controllers\RekapRektoratmhsKaryalainnyaController;
use App\Http\Controllers\peninjauanKurikulumValidAdminController;
use App\Http\Controllers\Rektorat\MasterDokumenRektoratController;
use App\Http\Controllers\Admin\SubmissionController as ControllersAdminSubmissionController;
use App\Http\Controllers\MasterDokumenRektoratController as ControllersMasterDokumenRektoratController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


//login
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'loginProses'])->name('loginProses');

//Logout
Route::get('logout', [AuthController::class, 'logout'])->name('logout');


// Route::middleware(['auth', 'role:admin'])
//     ->prefix('admin')
//     ->name('admin.')
//     ->group(function () {
//         Route::resource('master-documents', MasterDocumentController::class)
//             ->except(['show']);
//     });


//MENU ADMIN-BPM
Route::middleware('checkLogin')->group(
    function () {
        // Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/admin/dashboard', [DashbordAdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/rektorat/dashboard', [DashbordRektoratController::class, 'dashboard'])->name('rektorat.dashboard');
        Route::get('/prodi/dashboard', [DashbordProdiController::class, 'dashboard'])->name('prodi.dashboard');
        Route::get('/fakultas/dashboard', [DashbordFakultasController::class, 'dashboard'])->name('fakultas.dashboard');

        // MASTER DOKUMEN ADMIN-BPM
        Route::prefix('master-dokumen')->group(function () {
            Route::get('/', [MasterDokumentsController::class, 'index'])->name('master-dokumen');
            Route::get('/create', [MasterDokumentsController::class, 'create'])->name('master-dokumenCreate');
            Route::post('/', [MasterDokumentsController::class, 'store'])->name('master-dokumen.store');
            Route::get('/{id}/edit', [MasterDokumentsController::class, 'edit'])->name('master-dokumen.edit');
            Route::put('/{id}', [MasterDokumentsController::class, 'update'])->name('master-dokumen.update');
            Route::delete('/{id}', [MasterDokumentsController::class, 'destroy'])->name('master-dokumen.destroy');
            Route::get('/{id}', [MasterDokumentsController::class, 'show'])->name('master-dokumen.show');

            // Route untuk AJAX dan file operations
            Route::get('/{id}/detail', [MasterDokumentsController::class, 'getDetail'])->name('master-dokumen.detail');
            Route::get('/{id}/view', [MasterDokumentsController::class, 'viewFile'])->name('master-dokumen.view');
            Route::get('/{id}/download', [MasterDokumentsController::class, 'downloadFile'])->name('master-dokumen.download');
        });

        //rekap prestasi BPM
        Route::get('/admin/rekap/prestasi', [RekapBPMPrestasiController::class, 'index'])->name('rekapBPM.prestasi');
        Route::get('/admin/rekap/prestasi/export/excel', [RekapBPMPrestasiController::class, 'exportExcel'])
            ->name('rekapBPM.prestasi.export');
        Route::get('/admin/rekap/prestasi/export/pdf', [RekapBPMPrestasiController::class, 'exportPdf'])
            ->name('rekapBPM.prestasi.export.pdf');
        Route::get('/admin/rekap/prestasi/grafik', [RekapBPMPrestasiController::class, 'grafikFilter'])->name('rekapBPM.prestasi.grafik');





        Route::get('/admin/rekap/serkom', [RekapBPMSerkomController::class, 'index'])->name('rekapBPM.serkom');
        Route::get('/admin/rekap/serkom/export/excel', [RekapBPMSerkomController::class, 'exportExcel'])->name('rekapBPM.serkom.export.excel');
        Route::get('/admin/rekap/serkom/export/pdf', [RekapBPMSerkomController::class, 'exportPDF'])->name('rekapBPM.serkom.export.pdf');
        Route::get('/admin/rekap/serkom/grafik', [RekapBPMSerkomController::class, 'grafik'])->name('rekapBPM.serkom.grafik');



        Route::get('/admin/rekap/mhsHki', [RekapBPMmhsHkiController::class, 'index'])->name('rekapBPM.mhsHki');
        Route::get('/admin/rekap/mhsHki/export/excel', [RekapBPMmhsHkiController::class, 'exportExcel'])->name('rekapBPM.mhsHki.export.excel');
        Route::get('/admin/rekap/mhsHki/export/pdf', [RekapBPMmhsHkiController::class, 'exportPDF'])->name('rekapBPM.mhsHki.export.pdf');
        Route::get('/admin/rekap/hki-mahasiswa/grafik', [RekapBPMmhsHkiController::class, 'grafik'])->name('rekapBPM.hki.grafik');



        Route::get('/admin/rekap/publikasi', [RekapBPMpublikasiController::class, 'index'])->name('rekapBPM.publikasi');
        Route::get('/admin/rekap/publikasi/export/excel', [RekapBPMpublikasiController::class, 'exportExcel'])->name('rekapBPM.publikasi.export.excel');
        Route::get('/admin/rekap/publikasi/export/pdf', [RekapBPMpublikasiController::class, 'exportPDF'])->name('rekapBPM.publikasi.export.pdf');
        Route::get('/admin/rekap/publikasi-mahasiswa/grafik', [RekapBPMpublikasiController::class, 'grafik'])->name('rekapBPM.publikasi.grafik');



        Route::get('/admin/rekap/mhsAdopsi', [RekapBPMmhsAdopsiController::class, 'index'])->name('rekapBPM.mhsAdopsi');
        Route::get('/admin/rekap/mhsAdopsi/export/excel', [RekapBPMmhsAdopsiController::class, 'exportExcel'])->name('rekapBPM.mhsAdopsi.export.excel');
        Route::get('/admin/rekap/mhsAdopsi/export/pdf', [RekapBPMmhsAdopsiController::class, 'exportPDF'])->name('rekapBPM.mhsAdopsi.export.pdf');
        Route::get('/admin/rekap/adopsi-mahasiswa/grafik', [RekapBPMmhsAdopsiController::class, 'grafik'])->name('rekapBPM.adopsi.grafik');


        Route::get('/admin/rekap/mhsKaryaLainnya', [RekapBPMmhsKaryalainnyaController::class, 'index'])->name('rekapBPM.mhsKaryaLainnya');
        Route::get('/admin/rekap/mhsKaryaLainnya/export/excel', [RekapBPMmhsKaryalainnyaController::class, 'exportExcel'])->name('rekapBPM.mhsKaryaLainnya.export.excel');
        Route::get('/admin/rekap/mhsKaryaLainnya/export/pdf', [RekapBPMmhsKaryalainnyaController::class, 'exportPDF'])->name('rekapBPM.mhsKaryaLainnya.export.pdf');
        Route::get('/admin/rekap/karya-mahasiswa-lainnya/grafik', [RekapBPMmhsKaryalainnyaController::class, 'grafik'])->name('rekapBPM.karyalainnya.grafik');



        Route::get('/admin/rekap/Cpl', [RekapCPLadminController::class, 'index'])->name('rekapCPL.admin');
        Route::get('/rektorat/rekap/Cpl', [RekapCPLrektoratController::class, 'index'])->name('rekapCPL.rektorat');
        Route::get('/rektorat/rekap/Cpl/export/excel', [RekapCPLrektoratController::class, 'exportExcel'])->name('rekapCPL.rektorat.export.excel');
        Route::get('/rektorat/rekap/Cpl/export/pdf', [RekapCPLrektoratController::class, 'exportPDF'])->name('rekapCPL.rektorat.export.pdf');




        Route::get('/admin/rekap/cpl/grafik', [RekapCPLadminController::class, 'grafik'])->name('rekapCpl.grafik');
        Route::get('/prodi/rekap/cpl/grafik', [RekapCPLprodiController::class, 'grafik'])->name('rekapCplProdi.grafik');
        Route::get('/rektorat/rekap/cpl/grafik', [RekapCPLrektoratController::class, 'grafik'])->name('rekapCplRektorat.grafik');
        Route::get('/fakultas/rekap/cpl/grafik', [RekapCPLfakulController::class, 'grafik'])->name('rekapCplFakultas.grafik');


        Route::get('/admin/rekapRekognisi/rekognisi', [RekapRekognisiController::class, 'index'])->name('rekapRekognisi.index');
        Route::get('/admin/rekapRekognisi/rekognisi/export/excel', [RekapRekognisiController::class, 'exportExcel'])
            ->name('rekapRekognisi.export');
        Route::get('/admin/rekapRekognisi/rekognisi/export/pdf', [RekapRekognisiController::class, 'exportPdf'])
            ->name('rekapRekognisi.export.pdf');

        Route::get('/rekognisi/grafik', [RekapRekognisiController::class, 'grafik'])->name('rekapRekognisi.grafik');



        Route::get('/rektorat/rekapRekognisi/rekognisi', [RekapRekognisiRektoratController::class, 'index'])->name('rekapRekognisiRektorat.index');
        Route::get('/rektorat/rekapRekognisiRektorat/rekognisi/export/excel', [RekapRekognisiRektoratController::class, 'exportExcel'])
            ->name('rekapRekognisiRektorat.export');
        Route::get('/rektorat/rekapRekognisiRektorat/rekognisi/export/pdf', [RekapRekognisiRektoratController::class, 'exportPdf'])
            ->name('rekapRekognisiRektorat.export.pdf');

        Route::get('/rektorat/rekognisi/grafik', [RekapRekognisiRektoratController::class, 'grafik'])->name('rekapRekognisiRektorat.grafik');




        Route::get('/prodi/rekapRekognisi/rekognisi', [RekapRekognisiProdiController::class, 'index'])->name('rekapRekognisiProdi.index');
        Route::get('/prodi/rekapRekognisi/rekognisi/export/excel', [RekapRekognisiProdiController::class, 'exportExcel'])
            ->name('rekapRekognisiProdi.export');
        Route::get('/prodi/rekapRekognisi/rekognisi/export/pdf', [RekapRekognisiProdiController::class, 'exportPdf'])
            ->name('rekapRekognisiProdi.export.pdf');
        Route::get('/prodi/rekognisi/grafik', [RekapRekognisiProdiController::class, 'grafik'])->name('rekapRekognisiProdi.grafik');




        Route::get('/fakultas/rekapRekognisi/rekognisi', [RekapRekognisiFakulController::class, 'index'])->name('rekapRekognisiFakul.index');
        Route::get('/fakultas/rekapRekognisi/rekognisi/export/excel', [RekapRekognisiFakulController::class, 'exportExcel'])
            ->name('rekapRekognisiFakul.export');
        Route::get('/fakultas/rekapRekognisi/rekognisi/export/pdf', [RekapRekognisiFakulController::class, 'exportPdf'])
            ->name('rekapRekognisiFakul.export.pdf');
        Route::get('/fakultas/rekognisi/grafik', [RekapRekognisiFakulController::class, 'grafik'])->name('rekapRekognisiFakultas.grafik');



        Route::get('/admin/rekapIPK/rekap', [RekapIpkController::class, 'index'])->name('rekapIPK.index');
        Route::get('/admin/rekapIPK/rekap/export/excel', [RekapIpkController::class, 'exportExcel'])
            ->name('rekapIPK.export.excel');
        Route::get('/admin/rekapIPK/rekap/export/pdf', [RekapIpkController::class, 'exportPdf'])
            ->name('rekapIPK.export.pdf');



        // MASTER DOKUMEN ADMIN-BPM
        Route::get('master-dokumen-buku', [MasterDokumentBukuKurikulumController::class, 'index'])->name('master-dokumen-buku');
        Route::get('master-dokumen-buku/create', [MasterDokumentBukuKurikulumController::class, 'create'])->name('master-dokumen-bukuCreate');
        Route::post('master-dokumen-buku', [MasterDokumentBukuKurikulumController::class, 'store'])->name('master-dokumen-buku.store');


        // ROUTES DENGAN PARAMETER SPESIFIK HARUS DIDAHULUKAN
        Route::get('master-dokumen-buku/{id}/edit', [MasterDokumentBukuKurikulumController::class, 'edit'])->name('master-dokumen-buku.edit');
        Route::get('master-dokumen-buku/{id}/view', [MasterDokumentBukuKurikulumController::class, 'viewFile'])
            ->name('master-dokumen-buku-kurikulum.view');

        Route::get('master-dokumen-buku/{id}/download', [MasterDokumentBukuKurikulumController::class, 'downloadFile'])
            ->name('master-dokumen-buku-kurikulum.download');

        Route::get('master-dokumen-buku/{id}/detail', [MasterDokumentBukuKurikulumController::class, 'getDetail'])->name('master-dokumen-buku.detail');
        // ROUTES GENERIC HARUS DI AKHIR
        Route::put('master-dokumen-buku/{id}', [MasterDokumentBukuKurikulumController::class, 'update'])->name('master-dokumen-buku.update');
        Route::delete('master-dokumen-buku/{id}', [MasterDokumentBukuKurikulumController::class, 'destroy'])->name('master-dokumen-buku.destroy');
        Route::get('master-dokumen-buku/{id}', [MasterDokumentBukuKurikulumController::class, 'show'])->name('master-dokumen-buku.show');



        Route::get('master-dokumen-peninjauan', [MasterDokumentPeninjauanController::class, 'index'])->name('master-dokumen-peninjauan');
        // Route create - form tambah dokumen baru
        Route::get('master-dokumen-peninjauan/create', [MasterDokumentPeninjauanController::class, 'create'])->name('master-dokumen-peninjauan.create');

        // Route store - simpan dokumen baru
        Route::post('master-dokumen-peninjauan', [MasterDokumentPeninjauanController::class, 'store'])->name('master-dokumen-peninjauan.store');

        // ROUTES DENGAN PARAMETER SPESIFIK - HARUS DIDAHULUKAN SEBELUM ROUTE GENERIC

        // Route edit - form edit dokumen
        Route::get('master-dokumen-peninjauan/{id}/edit', [MasterDokumentPeninjauanController::class, 'edit'])->name('master-dokumen-peninjauan.edit');

        // Route view - melihat file dokumen
        Route::get('master-dokumen-peninjauan/{id}/view', [MasterDokumentPeninjauanController::class, 'viewFile'])->name('master-dokumen-peninjauan.view');

        // Route download - unduh file dokumen
        Route::get('master-dokumen-peninjauan/{id}/download', [MasterDokumentPeninjauanController::class, 'downloadFile'])->name('master-dokumen-peninjauan.download');

        // Route detail - mendapatkan detail dokumen (API)
        Route::get('master-dokumen-peninjauan/{id}/detail', [MasterDokumentPeninjauanController::class, 'getDetail'])->name('master-dokumen-peninjauan.detail');

        // ROUTES GENERIC - HARUS DI AKHIR

        // Route update - update dokumen
        Route::put('master-dokumen-peninjauan/{id}', [MasterDokumentPeninjauanController::class, 'update'])->name('master-dokumen-peninjauan.update');

        // Route destroy - hapus dokumen
        Route::delete('master-dokumen-peninjauan/{id}', [MasterDokumentPeninjauanController::class, 'destroy'])->name('master-dokumen-peninjauan.destroy');

        // Route show - detail dokumen
        Route::get('master-dokumen-peninjauan/{id}', [MasterDokumentPeninjauanController::class, 'show'])->name('master-dokumen-peninjauan.show');


        //CEMENUHAN CAPAIAN PEMBELAJARAN ADMIN
        Route::controller(CplBpmController::class)->group(function () {
            // Read
            Route::get('/cpl-bpm', 'index')->name('cpl-bpm');

            // Create
            Route::get('/cpl-bpm/create', 'create')->name('cpl-bpm.create');
            Route::post('/cpl-bpm', 'store')->name('cpl-bpmStore');

            // Update
            Route::get('/cpl-bpm/{cplBpm}/edit', 'edit')->name('cpl-bpm.edit');
            Route::put('/cpl-bpm/{cplBpm}', 'update')->name('cpl-bpm.update');
            Route::delete('/cpl-bpm/{id}', [CplBpmController::class, 'destroy'])->name('cpl-bpm.destroy');



            // Export routes
            Route::get('cpl-bpm/export/excel', [CplBpmController::class, 'exportExcel'])->name('cpl-bpm.export-excel');
            Route::get('cpl-bpm/export/pdf', [CplBpmController::class, 'exportPdf'])->name('cpl-bpm.export-pdf');
        });

        Route::controller(MasterCPLadminController::class)->group(function () {
            // Read
            Route::get('/master-cpl', 'index')->name('master-cpl');

            // Create
            Route::get('/master-cpl/create', 'create')->name('master-cpl.create');
            Route::post('/master-cpl', 'store')->name('master-cplStore');

            // Export routes - PINDAHKAN KE ATAS SEBELUM ROUTES DENGAN PARAMETER
            Route::get('/master-cpl/export/excel', 'exportExcel')->name('master-cpl.export-excel');
            Route::get('/master-cpl/export/pdf', 'exportPdf')->name('master-cpl.export-pdf');

            // Update
            Route::get('/master-cpl/{masterCpl}/edit', 'edit')->name('master-cpl.edit');
            Route::put('/master-cpl/{masterCpl}', 'update')->name('master-cpl.update');

            // Delete
            Route::delete('/master-cpl/{masterCpl}', 'destroy')->name('master-cpl.destroy');
        });

        // RATA-RATA IPK ADMIN BPM
        Route::get('RataIpk', [RataIpkController::class, 'index'])->name('RataIpk');
        Route::get('RataIpk/create', [RataIpkController::class, 'create'])->name('RataIpk.create');
        Route::get('RataIpk/export/excel', [RataIpkController::class, 'exportExcel'])->name('RataIpk.exportExcel');
        Route::get('RataIpk/export/pdf', [RataIpkController::class, 'exportPDF'])->name('RataIpk.exportPDF');
        Route::get('RataIpk/{id}', [RataIpkController::class, 'show'])->name('RataIpk.show');
        Route::get('RataIpk/{id}/edit', [RataIpkController::class, 'edit'])->name('RataIpk.edit');
        Route::post('RataIpk', [RataIpkController::class, 'store'])->name('RataIpk.store');
        Route::put('RataIpk/{id}', [RataIpkController::class, 'update'])->name('RataIpk.update');
        Route::delete('RataIpk/{id}', [RataIpkController::class, 'destroy'])->name('RataIpk.destroy');



        Route::get('karyaDosenValid', [karyaDosenValidAdminController::class, 'index'])->name('karyaDosenValid');
        Route::get('karyaDosenValid/validate/{id}', [karyaDosenValidAdminController::class, 'validateDokumen'])->name('validasi-karyaDosenValid');
        Route::post('karyaDosenValid/proses-validasi/{id}', [karyaDosenValidAdminController::class, 'validasiKaryaDosen'])->name('karyaDosenValid.validasi');


        // Route baru dengan nama dan URI yang sudah diganti
        Route::get('rekognisiDosenValid', [RekognisiDosenValidAdminController::class, 'index'])->name('rekognisiDosenValid');

        Route::get('rekognisiDosenValid/validate/{id}', [RekognisiDosenValidAdminController::class, 'validateDokumen'])->name('validasi-rekognisiDosenValid');

        Route::post('rekognisiDosenValid/proses-validasi/{id}', [RekognisiDosenValidAdminController::class, 'validasiRekognisiDosen'])->name('rekognisiDosenValid.validasi');

        //MENU ADMIN VALIDASI KARYA MAHASISWA
        // Route::get('validasi_Karyamhs', [KaryaMhsValidateController::class, 'index'])->name('validasi_Karyamhs');
        Route::get('karyaMhs-valid', [KaryaMhsValidateController::class, 'validateDokumen'])->name('karyaMhs-valid');

        // ----------------------------------------------------------------------------------------------------------

        //MENU REKROTAT

        //MENU DOKUMEN KEBIJAKAN REKTORAT
        // MENU REKTORAT
        // Resource routes

        // Halaman index utama
        Route::get('dok-rek', [DokRekController::class, 'index'])->name('dok-rek.index');

        // Resource routes (tanpa index agar tidak bentrok)
        Route::resource('dok-rek', DokRekController::class)->except(['index', 'destroy']);

        // Hapus manual (dipisah agar tidak bentrok dan bisa dikontrol sendiri)
        Route::delete('dok-rek/delete/{dokRek}', [DokRekController::class, 'destroy'])->name('dok-rek.customDestroy');

        // Halaman create (jika ingin custom route name, opsional)
        Route::get('dok-rek-create', [DokRekController::class, 'create'])->name('dok-rekCreate');

        // Pencarian/filter
        Route::post('dok-rek/search', [DokRekController::class, 'search'])->name('dok-rek.search');

        // Update status
        Route::post('dok-rek/{dokRek}/update-status', [DokRekController::class, 'updateStatus'])->name('dok-rek.updateStatus');

        // Export
        Route::get('dok-rek/export/excel', [DokRekController::class, 'exportExcel'])->name('dok-rek.exportExcel');
        Route::get('dok-rek/export/pdf', [DokRekController::class, 'exportPdf'])->name('dok-rek.exportPdf');

        // Validasi dokumen oleh admin (halaman)
        Route::get('dok-rek/validate/{id}', [DokRekController::class, 'validateDokumen'])->name('valid-rek');

        // Validasi cepat (approve / reject)
        Route::post('dok-rek/{dokRek}/approve', [DokRekController::class, 'approve'])->name('dok-rek.approve');
        Route::post('dok-rek/{dokRek}/reject', [DokRekController::class, 'reject'])->name('dok-rek.reject');

        // Sinkronisasi data
        Route::post('dok-rek/sync', [DokRekController::class, 'sync'])->name('dok-rek.sync');


        //Dok penetapan Admin
        // Route::get('dok-kebijakan', [DokKebijakanController::class, 'index'])->name('dok-kebijakan');
        // Route::get('dok-kebijakan/create', [DokKebijakanController::class,  'create'])->name('dok-kebijakanCreate');
        // Route::post('dok-kebijakan/store', [DokKebijakanController::class,  'store'])->name('dok-kebijakanStore');
        Route::get('dok-kebijakan', [DokKebijakanController::class, 'index'])->name('dok-kebijakan');
        Route::get('dok-kebijakan/validate/{id}', [DokKebijakanController::class, 'validateDokumen'])->name('validasi-dok-kebijakan');
        Route::post('dok-kebijakan/proses-validasi/{id}', [DokKebijakanController::class, 'validasiDok'])->name('dok-kebijakan.validasi');

        // Route::get('validasi-prestasi', [ValidasiPrestasiController::class, 'index'])->name('validasi-prestasi');

        Route::prefix('rektorat/master-dokumen')->name('rektorat.master-dokumen.')->group(function () {
            Route::get('/', [App\Http\Controllers\MasterDokumenRektoratController::class, 'index'])->name('index');
            Route::get('/{id}/view', [App\Http\Controllers\MasterDokumentsController::class, 'viewFile'])->name('view');
            Route::get('/{id}/download', [App\Http\Controllers\MasterDokumentsController::class, 'downloadFile'])->name('download');
        });

        Route::get('bukuKurikulumValid', [BukuKurikulumValidAdminController::class, 'index'])->name('bukuKurikulumValid');
        Route::get('dok-bukuKurikulumValid/validate/{id}', [BukuKurikulumValidAdminController::class, 'validateDokumen'])->name('validasi-bukuKurikulumValid');
        Route::post('dok-bukuKurikulumValid/proses-validasi/{id}', [BukuKurikulumValidAdminController::class, 'validasiBukAdmin'])->name('bukuKurikulumValid.validasi');


        Route::get('peninjauanKurikulumValid', [peninjauanKurikulumValidAdminController::class, 'index'])->name('peninjauanKurikulumValid');
        Route::get('peninjauanKurikulumValid/validate/{id}', [peninjauanKurikulumValidAdminController::class, 'validateDokumen'])->name('validasi-peninjauanKurikulumValid');
        Route::post('peninjauanKurikulumValid/proses-validasi/{id}', [peninjauanKurikulumValidAdminController::class, 'validasiPeninjauanAdmin'])->name('peninjauanKurikulumValid.validasi');

        //PEMENUHAN CAPAIAN PEMBELAJARAN
        // Grup route untuk Pemenuhan capaian pembelajaran Rektorat
        Route::controller(TargetRekController::class)->group(function () {
            // Read
            Route::get('/target-rek', 'index')->name('target-rek');

            // Create
            Route::get('/target-rek/create', 'create')->name('target-rek.create');
            Route::post('/target-rek', 'store')->name('target-rekStore');

            // Update
            Route::get('/target-rek/{targetRek}/edit', 'edit')->name('target-rek.edit');
            Route::put('/target-rek/{targetRek}', 'update')->name('target-rek.update');

            // Delete
            // Di dalam grup route:
            Route::delete('/target-rek/{targetRek}', [TargetRekController::class, 'destroy'])->name('target-rek.destroy'); // Hapus titik koma ganda

            // Export routes
            Route::get('target-rek/export/excel', [TargetRekController::class, 'exportExcel'])->name('target-rek.export-excel');
            Route::get('target-rek/export/pdf', [TargetRekController::class, 'exportPdf'])->name('target-rek.export-pdf');
        });

        //MENU FAKULTAS
        // Grup route untuk Fakultas buku kurikulum
        // Route::get('valid-buku-Kurikulum', [ValidateBukuKurikulumController::class, 'index'])->name('valid-buku-Kurikulum');
        // Route::get('/valid-buku-kurikulum', [ValidateBukuKurikulumController::class, 'validBukuKurikulum'])->name('valid-bukuKurikulum');
        // Route::get('valid-bukuKurikulum/validate/', [ValidateBukuKurikulumController::class, 'validateDokumen'])->name('valid-bukuKurikulum');


        Route::get('/fakultas/dok-rek', [FakultasDokRekController::class, 'index'])->name('fakultas.dokrek.index');

        Route::get('/admin/rekap/Cpl', [RekapCPLadminController::class, 'index'])->name('rekapCPL.admin');
        Route::get('/admin/rekap/Cpl/export-excel', [RekapCPLadminController::class, 'exportExcel'])->name('rekapCPL.admin.exportExcel');
        Route::get('/admin/rekap/Cpl/export-pdf', [RekapCPLadminController::class, 'exportPdf'])->name('rekapCPL.admin.exportPdf');


        Route::get('/fakultas/rekap/Cpl', [RekapCPLfakulController::class, 'index'])->name('rekapCPL.fakul');
        Route::get('/fakultas/rekap/Cpl/export/excel', [RekapCPLfakulController::class, 'exportExcel'])->name('rekapCPL.fakultas.export.excel');
        Route::get('/fakultas/rekap/Cpl/export/pdf', [RekapCPLfakulController::class, 'exportPDF'])->name('rekapCPL.fakultas.export.pdf');




        //Pemenuhan pencapaian pembelajaran fakultas
        // MENU FAKULTAS
        //Dok pendidikan Fakultas
        // Route::get('target-fakul', [TargetFakulController::class, 'index'])->name('target-fakul');
        // Route::get('target-fakul/create', [TargetFakulController::class, 'create'])->name('target-fakul.create');

        Route::controller(TargetFakulController::class)->group(function () {
            // Read
            Route::get('/target-fakul', 'index')->name('target-fakul');

            // Create
            Route::get('/target-fakul/create', 'create')->name('target-fakul.create');
            Route::post('/target-fakul', 'store')->name('dok-rekStore');

            // Update
            Route::get('/target-fakul/{targetFakul}/edit', 'edit')->name('target-fakul.edit');
            Route::put('/target-fakul/{targetFakul}', 'update')->name('target-fakul.update');

            // Delete
            // Di dalam grup route:
            Route::delete('/target-fakul/{targetFakul}', [TargetFakulController::class, 'destroy'])->name('target-fakul.destroy'); // Hapus titik koma ganda

            // Export routes
            Route::get('target-fakul/export/excel', [TargetFakulController::class, 'exportExcel'])->name('target-fakul.export-excel');
            Route::get('target-fakul/export/pdf', [TargetFakulController::class, 'exportPdf'])->name('target-fakul.export-pdf');
        });

        Route::get('/rektorat/rekap/prestasi', [RekapRektoratPrestasiController::class, 'index'])->name('rekapRektorat.prestasi');
        Route::get('/rektorat/rekap/prestasi/export/excel', [RekapRektoratPrestasiController::class, 'exportExcel'])
            ->name('rekapRektorat.prestasi.export');
        Route::get('/rektorat/rekap/prestasi/export/pdf', [RekapRektoratPrestasiController::class, 'exportPdf'])
            ->name('rekapRektorat.prestasi.export.pdf');
        Route::get('/rektorat/rekap/prestasi/grafik', [RekapRektoratPrestasiController::class, 'grafikFilter'])->name('rekapRektorat.prestasi.grafik');




        Route::get('/rektorat/rekap/serkom', [RekapRektoratSerkomController::class, 'index'])->name('rekapRektorat.serkom');
        Route::get('/rektorat/rekap/serkom/export/excel', [RekapRektoratSerkomController::class, 'exportExcel'])->name('rekapRektorat.serkom.export.excel');
        Route::get('/rektorat/rekap/serkom/export/pdf', [RekapRektoratSerkomController::class, 'exportPDF'])->name('rekapRektorat.serkom.export.pdf');
        Route::get('/rektorat/rekap/serkom/grafik', [RekapRektoratSerkomController::class, 'grafik'])->name('rekapRektorat.serkom.grafik');


        Route::get('/rektorat/rekap/mhsHki', [RekapRektoratmhsHkiController::class, 'index'])->name('rekapRektorat.mhsHki');
        Route::get('/rektorat/rekap/mhsHki/export/excel', [RekapRektoratmhsHkiController::class, 'exportExcel'])->name('rekapRektorat.mhsHki.export.excel');
        Route::get('/rektorat/rekap/mhsHki/export/pdf', [RekapRektoratmhsHkiController::class, 'exportPDF'])->name('rekapRektorat.mhsHki.export.pdf');
        Route::get('/rektorat/rekap/hki-mahasiswa/grafik', [RekapRektoratmhsHkiController::class, 'grafik'])->name('rekapRektorat.hki.grafik');



        Route::get('/rektorat/rekap/publikasi', [RekapRektoratpublikasiController::class, 'index'])->name('rekapRektorat.publikasi');
        Route::get('/rektorat/rekap/publikasi/export/excel', [RekapRektoratpublikasiController::class, 'exportExcel'])->name('rekapRektorat.publikasi.export.excel');
        Route::get('/rektorat/rekap/publikasi/export/pdf', [RekapRektoratpublikasiController::class, 'exportPDF'])->name('rekapRektorat.publikasi.export.pdf');
        Route::get('/rektorat/rekap/publikasi-mahasiswa/grafik', [RekapRektoratpublikasiController::class, 'grafik'])->name('rekapRektorat.publikasi.grafik');


        Route::get('/rektorat/rekap/mhsAdopsi', [RekapRektoratmhsAdopsiController::class, 'index'])->name('rekapRektorat.mhsAdopsi');
        Route::get('/rektorat/rekap/mhsAdopsi/export/excel', [RekapRektoratmhsAdopsiController::class, 'exportExcel'])->name('rekapRektorat.mhsAdopsi.export.excel');
        Route::get('/rektorat/rekap/mhsAdopsi/export/pdf', [RekapRektoratmhsAdopsiController::class, 'exportPDF'])->name('rekapRektorat.mhsAdopsi.export.pdf');
        Route::get('/rektorat/rekap/adopsi-mahasiswa/grafik', [RekapRektoratmhsAdopsiController::class, 'grafik'])->name('rekapRektorat.adopsi.grafik');


        Route::get('/rektorat/rekap/mhsKaryaLainnya', [RekapRektoratmhsKaryalainnyaController::class, 'index'])->name('rekapRektorat.mhsKaryaLainnya');
        Route::get('/rektorat/rekap/mhsKaryaLainnya/export/excel', [RekapRektoratmhsKaryalainnyaController::class, 'exportExcel'])->name('rekapRektorat.mhsKaryaLainnya.export.excel');
        Route::get('/rektorat/rekap/mhsKaryaLainnya/export/pdf', [RekapRektoratmhsKaryalainnyaController::class, 'exportPDF'])->name('rekapRektorat.mhsKaryaLainnya.export.pdf');
        Route::get('/rektorat/rekap/karya-mahasiswa-lainnya/grafik', [RekapRektoratmhsKaryalainnyaController::class, 'grafik'])->name('rekapRektorat.karyalainnya.grafik');



        //VALIDASI PENINJAUAN KURIKULUM FAKULTAS
        // Route::get('valid-peninjauanKurikulum', [ValidatePeninjauanKurikulumController::class, 'index'])->name('valid-peninjauan-Kurikulum');
        // Route::get('valid-peninjauanKurikulum/validate/', [ValidatePeninjauanKurikulumController::class, 'validateDokumen'])->name('valid-peninjauanKurikulum');

        //rekap prestasi BPM
        Route::get('/fakultas/rekap/prestasi', [RekapFakulPrestasiController::class, 'index'])->name('rekapFakul.prestasi');
        Route::get('/fakultas/rekap/prestasi/export/excel', [RekapFakulPrestasiController::class, 'exportExcel'])
            ->name('rekapFakul.prestasi.export.excel');
        Route::get('/fakultas/rekap/prestasi/export/pdf', [RekapFakulPrestasiController::class, 'exportPdf'])
            ->name('rekapFakul.prestasi.export.pdf');
        Route::get('/fakultas/rekap/prestasi/grafik', [RekapFakulPrestasiController::class, 'grafikFilter'])->name('rekapFakul.prestasi.grafik');



        Route::get('/fakultas/rekap/serkom', [RekapFakulSerkomController::class, 'index'])->name('rekapFakul.serkom');
        Route::get('/fakultas/rekap/serkom/export/excel', [RekapFakulSerkomController::class, 'exportExcel'])->name('rekapFakul.serkom.export.excel');
        Route::get('/fakultas/rekap/serkom/export/pdf', [RekapFakulSerkomController::class, 'exportPDF'])->name('rekapFakul.serkom.export.pdf');
        Route::get('/fakultas/rekap/serkom/grafik', [RekapFakulSerkomController::class, 'grafik'])->name('rekapFakul.serkom.grafik');




        Route::get('/fakultas/rekap/mhsHki', [RekapFakulmhsHkiController::class, 'index'])->name('rekapFakul.mhsHki');
        Route::get('/fakultas/rekap/mhsHki/export/excel', [RekapFakulmhsHkiController::class, 'exportExcel'])->name('rekapFakul.mhsHki.export.excel');
        Route::get('/fakultas/rekap/mhsHki/export/pdf', [RekapFakulmhsHkiController::class, 'exportPDF'])->name('rekapFakul.mhsHki.export.pdf');
        Route::get('/fakultas/rekap/hki-mahasiswa/grafik', [RekapFakulmhsHkiController::class, 'grafik'])->name('rekapFakul.hki.grafik');




        Route::get('/fakultas/rekap/publikasi', [RekapFakulpublikasiController::class, 'index'])->name('rekapFakul.publikasi');
        Route::get('/fakultas/rekap/publikasi/export/excel', [RekapFakulpublikasiController::class, 'exportExcel'])->name('rekapFakul.publikasi.export.excel');
        Route::get('/fakultas/rekap/publikasi/export/pdf', [RekapFakulpublikasiController::class, 'exportPDF'])->name('rekapFakul.publikasi.export.pdf');
        Route::get('/fakultas/rekap/publikasi-mahasiswa/grafik', [RekapFakulpublikasiController::class, 'grafik'])->name('rekapFakul.publikasi.grafik');




        Route::get('/fakultas/rekap/mhsAdopsi', [RekapFakulmhsAdopsiController::class, 'index'])->name('rekapFakul.mhsAdopsi');
        Route::get('/fakultas/rekap/mhsAdopsi/export/excel', [RekapFakulmhsAdopsiController::class, 'exportExcel'])->name('rekapFakul.mhsAdopsi.export.excel');
        Route::get('/fakultas/rekap/mhsAdopsi/export/pdf', [RekapFakulmhsAdopsiController::class, 'exportPDF'])->name('rekapFakul.mhsAdopsi.export.pdf');
        Route::get('/fakultas/rekap/adopsi-mahasiswa/grafik', [RekapFakulmhsAdopsiController::class, 'grafik'])->name('rekapFakul.adopsi.grafik');


        Route::get('/fakultas/rekap/mhsKaryaLainnya', [RekapFakulmhsKaryalainnyaController::class, 'index'])->name('rekapFakul.mhsKaryaLainnya');
        Route::get('/fakultas/rekap/mhsKaryaLainnya/export/excel', [RekapFakulmhsKaryaLainnyaController::class, 'exportExcel'])->name('rekapFakul.mhsKaryaLainnya.export.excel');
        Route::get('/fakultas/rekap/mhsKaryaLainnya/export/pdf', [RekapFakulmhsKaryaLainnyaController::class, 'exportPDF'])->name('rekapFakul.mhsKaryaLainnya.export.pdf');
        Route::get('/fakultas/rekap/karya-mahasiswa-lainnya/grafik', [RekapFakulmhsKaryaLainnyaController::class, 'grafik'])->name('rekapFakul.karyalainnya.grafik');






        // -----------------------------------------------------------------------------------------------------------------------------------------------------------



        //MENU PRODI FTI
        //MASTER DOKUMEN BUKU KURIKULUM DAN MASTER PENINJAUAN KURIKULUM

        Route::get('prodi/master-dokumen-buku', [MasterDokumentBukuRektoratController::class, 'indexProdi'])->name('prodi.master-dokumen-buku');
        // Untuk file view
        Route::get('prodi/master-dokumen-buku/{id}/view', [MasterDokumentBukuRektoratController::class, 'viewFile'])->name('master-dokumen-buku.view');

        // Untuk file download
        Route::get('prodi/master-dokumen-buku/{id}/download', [MasterDokumentBukuRektoratController::class, 'downloadFile'])->name('master-dokumen-buku.download');

        Route::get('/prodi/dok-rek', [ProdiDokRekController::class, 'index'])->name('prodi.dokrek.index');


        Route::prefix('peninjauan-kurikulum')->group(function () {
            Route::get('/', [PeninjauanKurikulumController::class, 'index'])->name('peninjauan-kurikulum.index');
            Route::get('/create', [PeninjauanKurikulumController::class, 'create'])->name('peninjauan-kurikulum.create');
            Route::post('/', [PeninjauanKurikulumController::class, 'store'])->name('peninjauan-kurikulum.store');
            Route::get('/{peninjauanKurikulum}/edit', [PeninjauanKurikulumController::class, 'edit'])->name('peninjauan-kurikulum.edit');
            Route::put('/{peninjauanKurikulum}', [PeninjauanKurikulumController::class, 'update'])->name('peninjauan-kurikulum.update');
            Route::delete('/{peninjauanKurikulum}', [PeninjauanKurikulumController::class, 'destroy'])->name('peninjauan-kurikulum.destroy');

            // Export
            Route::get('/export/excel', [PeninjauanKurikulumController::class, 'exportExcel'])->name('peninjauan-kurikulum.export.excel');
            Route::get('/export/pdf', [PeninjauanKurikulumController::class, 'exportPdf'])->name('peninjauan-kurikulum.export.pdf');
        });



        //Profil Lulusan
        Route::prefix('prodi-fti')->group(function () {
            Route::get('/', [PlFtiController::class, 'index'])->name('prodi-fti');
            Route::get('/create', [PlFtiController::class, 'create'])->name('prodi-plCreate');
            Route::post('/store', [PlFtiController::class, 'store'])->name('prodi-plStore');
            Route::get('/edit/{id}', [PlFtiController::class, 'edit'])->name('prodi-plEdit');
            Route::put('/update/{id}', [PlFtiController::class, 'update'])->name('prodi-plUpdate');
            Route::delete('/destroy/{id}', [PlFtiController::class, 'destroy'])->name('prodi-plDestroy');

            Route::get('/export/excel', [PlFtiController::class, 'exportExcel'])->name('plfti.exportExcel');
            Route::get('/prodi-fti/export/pdf', [PlFtiController::class, 'exportPdf'])->name('prodi-fti.export.pdf');
        });

        Route::get('/admin/profil-lulusan', [PlFtiAdminController::class, 'index'])->name('admin.pl.index');
        Route::get('/admin/profil-lulusan/export/excel', [PlFtiAdminController::class, 'exportExcel'])->name('admin.pl.export.excel');
        Route::get('/admin/profil-lulusan/export/pdf', [PlFtiAdminController::class, 'exportPdf'])->name('admin.pl.export.pdf');




        //CPL Prodi
        Route::get('plprodi-fti', [CplFtiController::class, 'index'])->name('plprodi-fti');

        Route::get('/plprodi-fti/sikap', [PlProdiController::class, 'index'])->name('viewSikap-fti');
        Route::get('/plprodi-fti/ku', [PlProdiController::class, 'indexku'])->name('viewKU-fti');
        Route::get('/plprodi-fti/kk', [PlProdiController::class, 'indexkk'])->name('viewKK-fti');
        Route::get('/plprodi-fti/pengetahuan', [PlProdiController::class, 'indexpengetahuan'])->name('viewPengetahuan-fti');


        Route::get('/plprodi-fti/sikap/create', [PlProdiController::class, 'createSikap'])->name('sikapCreate');
        Route::get('/plprodi-fti/ku/create', [PlProdiController::class, 'createKU'])->name('kuCreate');
        Route::get('/plprodi-fti/kk/create', [PlProdiController::class, 'createKK'])->name('kkCreate');
        Route::get('/plprodi-fti/pengetahuan/create', [PlProdiController::class, 'createPengetahuan'])->name('peCreate');

        Route::post('/plprodi-fti/sikap/store', [PlProdiController::class, 'storeSikap'])->name('sikapStore');
        Route::post('/plprodi-fti/ku/store', [PlProdiController::class, 'storeku'])->name('kuStore');
        Route::post('/plprodi-fti/kk/store', [PlProdiController::class, 'storekk'])->name('kkStore');
        Route::post('/plprodi-fti/pengetahuan/store', [PlProdiController::class, 'storepengetahuan'])->name('pengetahuanStore');

        Route::get('/prodi-fti/export/sikap/excel', [PlProdiController::class, 'exportSikapExcel'])->name('exportSikap.excel');
        Route::get('/prodi-fti/export/sikap/pdf', [PlProdiController::class, 'exportSikapPdf'])->name('exportSikap.pdf');
        Route::get('/prodi-fti/sikap/edit/{id}', [PlProdiController::class, 'editSikap'])->name('sikapEdit');
        Route::put('/prodi-fti/sikap/update/{id}', [PlProdiController::class, 'updateSikap'])->name('sikapUpdate');

        Route::get('/plprodi-fti/ku/{id}/edit', [PlProdiController::class, 'editKU'])->name('kuEdit');
        Route::put('/plprodi-fti/ku/{id}/update', [PlProdiController::class, 'updateKU'])->name('kuUpdate');


        Route::get('/plprodi-fti/ku/export-pdf', [PlProdiController::class, 'exportKUPdf'])->name('exportKU.pdf');
        Route::get('/plprodi-fti/ku/export-excel', [PlProdiController::class, 'exportKUExcel'])->name('exportKU.excel');

        Route::get('/plprodi-fti/kk/{id}/edit', [PlProdiController::class, 'editKK'])->name('kkEdit');
        Route::put('/plprodi-fti/kk/{id}/update', [PlProdiController::class, 'updateKK'])->name('kkUpdate');

        Route::get('/plprodi-fti/kk/export-pdf', [PlProdiController::class, 'exportKKPdf'])->name('exportKK.pdf');
        Route::get('/plprodi-fti/kk/export-excel', [PlProdiController::class, 'exportKKExcel'])->name('exportKK.excel');

        Route::get('/plprodi-fti/pengetahuan/export-pdf', [PlProdiController::class, 'exportpengetahuanPdf'])->name('exportPengetahuan.pdf');
        Route::get('/plprodi-fti/pengetahuan/export-excel', [PlProdiController::class, 'exportpengetahuanExcel'])->name('exportPengetahuan.excel');
        Route::get('/pengetahuan/{id}/edit', [PlProdiController::class, 'editPengetahuan'])->name('pengetahuanEdit');
        Route::put('/pengetahuan/{id}', [PlProdiController::class, 'updatePengetahuan'])->name('pengetahuanUpdate');

        Route::delete('/plprodi-fti/sikap/{id}/delete', [PlProdiController::class, 'destroySikap'])->name('sikapDestroy');
        Route::delete('/plprodi-fti/ku/{id}/delete', [PlProdiController::class, 'destroyKU'])->name('kuDestroy');
        Route::delete('/plprodi-fti/kk/{id}/delete', [PlProdiController::class, 'destroyKK'])->name('kkDestroy');

        Route::delete('/plprodi-fti/pengetahuan/{id}/delete', [PlProdiController::class, 'destroyPengetahuan'])->name('pengetahuanDestroy');



        //Buku Kurikulum Prodi
        //MENU BUKU KURIKULUM FTI
        // Route::get('buku-kurikulumfti', [BukuKurikulumController::class, 'index'])->name('buku-kurikulumfti');
        // Route::get('buku-kurikulumfti/create', [BukuKurikulumController::class, 'create'])->name('buku-kurikulumftiCreate');


        Route::prefix('buku-kurikulumfti')->group(function () {
            Route::get('/', [BukuKurikulumController::class, 'index'])->name('buku-kurikulumfti');
            Route::get('/create', [BukuKurikulumController::class, 'create'])->name('buku-kurikulumfti.create');
            Route::post('/', [BukuKurikulumController::class, 'store'])->name('buku-kurikulumfti.store');
            Route::get('/{bukuKurikulum}/edit', [BukuKurikulumController::class, 'edit'])->name('buku-kurikulumfti.edit');
            Route::put('/{bukuKurikulum}', [BukuKurikulumController::class, 'update'])->name('buku-kurikulumfti.update');
            Route::delete('/{bukuKurikulum}', [BukuKurikulumController::class, 'destroy'])->name('buku-kurikulumfti.destroy');
            Route::get('/export/excel', [BukuKurikulumController::class, 'exportExcel'])->name('buku-kurikulumfti.export.excel');
            Route::get('/export/pdf', [BukuKurikulumController::class, 'exportPdf'])->name('buku-kurikulumfti.export.pdf');
        });


        Route::get('prodi/master-dokumen-peninjauan', [MasterDokumentPeninjauanController::class, 'indexProdi'])->name('prodi.master-dokumen-peninjauan');


        //VALIDASI KARYA MAHASISWA
        //prestasi mahasiswa
        Route::get('valid-prestasimhs/', [ValidasiPrestasiController::class, 'index'])->name('valid-prestasimhs');
        Route::get('valid-prestasimhs/validate/{id}', [ValidasiPrestasiController::class, 'validateDokumen'])->name('validasi-prestasimhs');
        Route::post('valid-prestasimhs/proses-validasi/{id}', [ValidasiPrestasiController::class, 'validasiPrestasi'])->name('valid-prestasimhs.validasi');


        //VALIDASI KARYA MAHASISWA
        Route::get('valid-serkom', [ValidasiSerkomController::class, 'index'])->name('valid-serkom');
        Route::get('valid-serkom/validate/{id}', [ValidasiSerkomController::class, 'validateDokumen'])->name('validasi-serkom');
        Route::post('valid-serkom/proses-validasi/{id}', [ValidasiSerkomController::class, 'validasiSerkom'])->name('valid-serkom.validasi');




        //VALIDASI Data Karya Mahasiswa
        Route::get('valid-mhsHki', [ValidasiMhsHkiController::class, 'index'])->name('valid-mhsHki');
        Route::get('valid-mhsHki/validate/{id}', [ValidasiMhsHkiController::class, 'validateDokumen'])->name('validasi-mhsHki');
        Route::post('valid-mhsHki/proses-validasi/{id}', [ValidasiMhsHkiController::class, 'validasiHKI'])->name('valid-mhsHki.validasi');




        //Publikasi Mahasiswa
        Route::get('valid-publikasi', [ValidasiPublikasiController::class, 'index'])->name('valid-publikasi');
        Route::get('valid-publikasi/validate/{id}', [ValidasiPublikasiController::class, 'validateDokumen'])->name('validasi-publikasi');
        Route::post('valid-publikasi/proses-validasi/{id}', [ValidasiPublikasiController::class, 'validasiPublikasi'])->name('valid-publikasi.validasi');


        //KARYA YG DIADOPSI MASYARAKAT
        Route::get('valid-karyaAdopsi', [ValidasiKaryaAdopsiController::class, 'index'])->name('valid-karyaAdopsi');
        Route::get('valid-karyaAdopsi/validate/{id}', [ValidasiKaryaAdopsiController::class, 'validateDokumen'])->name('validasi-karyaAdopsi');
        Route::post('valid-karyaAdopsi/proses-validasi/{id}', [ValidasiKaryaAdopsiController::class, 'validasiMahasiswaAdop'])->name('valid-karyaAdopsi.validasi');

        //KARYA MAHASISWA LAINNYA
        Route::get('valid-karyalainnya', [ValidasiKaryaLainnya::class, 'index'])->name('valid-karyalainnya');
        Route::get('valid-karyalainnya/validate/{id}', [ValidasiKaryaLainnya::class, 'validateDokumen'])->name('validasi-karyalainnya');
        Route::post('valid-karyalainnya/proses-validasi/{id}', [ValidasiKaryaLainnya::class, 'validasiKaryalainnya'])->name('valid-karyalainnya.validasi');



        //MENU MEMENUHAN CAPAIAN PEMBELAJARAN FTI
        //Memenuhi pencapaian pembelajaran
        Route::controller(CpProdiController::class)->group(function () {
            // Read
            Route::get('/cp-prodi-fti', 'index')->name('cp-prodi-fti');

            // Create
            Route::get('/cp-prodifti/create', 'create')->name('cp-prodiftiCreate');
            Route::post('/cp-prodi-fti', 'store')->name('cp-prodi-ftiStore');

            // Update
            Route::get('/cp-prodi-fti/{cplProdi}/edit', 'edit')->name('cp-prodi-fti.edit');
            Route::put('/cp-prodi-fti/{cplProdi}', 'update')->name('cp-prodi-fti.update');

            Route::delete('/cp-prodi-fti/{cplProdi}', 'destroy')->name('cp-prodi-fti.destroy');


            // Export routes
            Route::get('cp-prodi-fti/export/excel', [CpProdiController::class, 'exportExcel'])->name('cp-prodi-fti.export-excel');
            Route::get('cp-prodi-fti/export/pdf', [CpProdiController::class, 'exportPdf'])->name('cp-prodi-fti.export-pdf');
        });


        //MENU PENINJAUAN KURIKULUM FTI
        //Peninjauan Kurikulum
        Route::get('peninjauan-fti', [PeninjauanKurikulumController::class, 'index'])->name('peninjauan-fti');
        Route::get('peninjauan-fti/create', [PeninjauanKurikulumController::class, 'create'])->name('peninjauan-ftiCreate');


        // MENU SERTIFIKASI KOMPETENSI MAHASISWA FTI
        //setifikasi kompetensi mahasiswa FTI
        Route::resource('karya-mahasiswa-fti', KaryaMhsFtiController::class, ['parameters' => ['karya-mahasiswa-fti' => 'karyaMahasiswa']]);

        Route::get('/karya-mahasiswa-fti/export/excel', [KaryaMhsFtiController::class, 'exportExcel'])->name('karya-mahasiswa-fti.export-excel');
        Route::get('/karya-mahasiswa-fti/export/pdf', [KaryaMhsFtiController::class, 'exportPdf'])->name('karya-mahasiswa-fti.export-pdf');

        //setifikasi kompetensi mahasiswa FTI
        // Tambahkan route alias
        // Route::get('/prestasi-mahasiswa-fti', [PrestasiMhsFtiController::class, 'index'])->name('prestasi-mahasiswa-fti');



        Route::controller(PrestasiMhsFtiController::class)->group(function () {
            // Read
            Route::get('/prestasi-mahasiswa-fti', 'index')->name('prestasi-mahasiswa-fti');

            // Create
            Route::get('/prestasi-mahasiswa-fti/create', 'create')->name('prestasi-mahasiswa-fti.create');
            Route::post('/prestasi-mahasiswa-fti', 'store')->name('prestasi-mahasiswa-fti.store');

            // Update
            Route::get('/prestasi-mahasiswa-fti/{prestasiMahasiswa}/edit', 'edit')->name('prestasi-mahasiswa-fti.edit');
            Route::put('/prestasi-mahasiswa-fti/{prestasiMahasiswa}', 'update')->name('prestasi-mahasiswa-fti.update');

            // Delete
            // Di dalam grup route:
            Route::delete('/prestasi-mahasiswa-fti/{prestasiMahasiswa}', [PrestasiMhsFtiController::class, 'destroy'])->name('prestasi-mahasiswa-fti.destroy'); // Hapus titik koma ganda

            // Export routes
            Route::get('prestasi-mahasiswa-fti/export/excel', [PrestasiMhsFtiController::class, 'exportExcel'])->name('prestasi-mahasiswa-fti.export-excel');
            Route::get('prestasi-mahasiswa-fti/export/pdf', [PrestasiMhsFtiController::class, 'exportPdf'])->name('prestasi-mahasiswa-fti.export-pdf');

            //rekap
            Route::get('/rekap-prestasi-mahasiswa-fti', [PrestasiMhsFtiController::class, 'rekap'])->name('prestasi-mahasiswa-fti.rekap');
            Route::get('/totalrekap-prestasi-mahasiswa-fti', [PrestasiMhsFtiController::class, 'totalrekap'])->name('prestasi-mahasiswa-fti.totalrekap');
        });

        Route::controller(PublikasiMhsFtiController::class)->group(function () {
            // Read
            Route::get('/publikasi-mahasiswa-fti', 'index')->name('publikasi-mahasiswa-fti');

            // Create
            Route::get('/publikasi-mahasiswa-fti/create', 'create')->name('publikasi-mahasiswa-fti.create');
            Route::post('/publikasi-mahasiswa-fti', 'store')->name('publikasi-mahasiswa-fti.store');

            // Update
            Route::get('/publikasi-mahasiswa-fti/{publikasiMahasiswa}/edit', 'edit')->name('publikasi-mahasiswa-fti.edit');
            Route::put('/publikasi-mahasiswa-fti/{publikasiMahasiswa}', 'update')->name('publikasi-mahasiswa-fti.update');

            // Delete
            // Di dalam grup route:
            Route::delete('/publikasi-mahasiswa-fti/{publikasiMahasiswa}', [PublikasiMhsFtiController::class, 'destroy'])->name('publikasi-mahasiswa-fti.destroy'); // Hapus titik koma ganda

            // Export routes
            Route::get('publikasi-mahasiswa-fti/export/excel', [PublikasiMhsFtiController::class, 'exportExcel'])->name('publikasi-mahasiswa-fti.export-excel');
            Route::get('publikasi-mahasiswa-fti/export/pdf', [PublikasiMhsFtiController::class, 'exportPdf'])->name('publikasi-mahasiswa-fti.export-pdf');
        });

        Route::controller(MahasiswaHkiFtiController::class)->group(function () {
            // Read
            Route::get('/mahasiswa-hki-fti', 'index')->name('mahasiswa-hki-fti');

            // Create
            Route::get('/mahasiswa-hki-fti/create', 'create')->name('mahasiswa-hki-fti.create');
            Route::post('/mahasiswa-hki-fti', 'store')->name('mahasiswa-hki-fti.store');

            // Update
            Route::get('/mahasiswa-hki-fti/{mahasiswaHki}/edit', 'edit')->name('mahasiswa-hki-fti.edit');
            Route::put('/mahasiswa-hki-fti/{mahasiswaHki}', 'update')->name('mahasiswa-hki-fti.update');

            // Delete
            // Di dalam grup route:
            Route::delete('/mahasiswa-hki-fti/{mahasiswaHki}', [MahasiswaHkiFtiController::class, 'destroy'])->name('mahasiswa-hki-fti.destroy'); // Hapus titik koma ganda

            // Export routes
            Route::get('mahasiswa-hki-fti/export/excel', [MahasiswaHkiFtiController::class, 'exportExcel'])->name('mahasiswa-hki-fti.export-excel');
            Route::get('mahasiswa-hki-fti/export/pdf', [MahasiswaHkiFtiController::class, 'exportPdf'])->name('mahasiswa-hki-fti.export-pdf');
        });

        Route::controller(MahasiswadiadopFtiController::class)->group(function () {
            // Read
            Route::get('/mahasiswa-diadopsi-fti', 'index')->name('mahasiswa-diadopsi-fti');

            // Create
            Route::get('/mahasiswa-diadopsi-fti/create', 'create')->name('mahasiswa-diadopsi-fti.create');
            Route::post('/mahasiswa-diadopsi-fti', 'store')->name('mahasiswa-diadopsi-fti.store');

            // Update
            Route::get('/mahasiswa-diadopsi-fti/{mahasiswadiadopsi}/edit', 'edit')->name('mahasiswa-diadopsi-fti.edit');
            Route::put('/mahasiswa-diadopsi-fti/{mahasiswadiadopsi}', 'update')->name('mahasiswa-diadopsi-fti.update');

            // Delete
            // Di dalam grup route:
            Route::delete('/mahasiswa-diadopsi-fti/{mahasiswadiadopsi}', [MahasiswadiadopFtiController::class, 'destroy'])->name('mahasiswa-diadopsi-fti.destroy'); // Hapus titik koma ganda

            // Export routes
            Route::get('mahasiswa-diadopsi-fti/export/excel', [MahasiswadiadopFtiController::class, 'exportExcel'])->name('mahasiswa-diadopsi-fti.export-excel');
            Route::get('mahasiswa-diadopsi-fti/export/pdf', [MahasiswadiadopFtiController::class, 'exportPdf'])->name('mahasiswa-diadopsi-fti.export-pdf');
        });

        Route::controller(MahasiswaLainnyaFtiController::class)->group(function () {
            // Read
            Route::get('/mahasiswa-lainnya-fti', 'index')->name('mahasiswa-lainnya-fti');

            // Create
            Route::get('/mahasiswa-lainnya-fti/create', 'create')->name('mahasiswa-lainnya-fti.create');
            Route::post('/mahasiswa-lainnya-fti', 'store')->name('mahasiswa-lainnya-fti.store');

            // Update
            Route::get('/mahasiswa-lainnya-fti/{mahasiswaLainnya}/edit', 'edit')->name('mahasiswa-lainnya-fti.edit');
            Route::put('/mahasiswa-lainnya-fti/{mahasiswaLainnya}', [MahasiswaLainnyaFtiController::class, 'update'])->name('mahasiswa-lainnya-fti.update');


            // Delete
            // Di dalam grup route:
            Route::delete('/mahasiswa-lainnya-fti/{mahasiswalainnya}', [MahasiswaLainnyaFtiController::class, 'destroy'])->name('mahasiswa-lainnya-fti.destroy'); // Hapus titik koma ganda

            // Export routes
            Route::get('mahasiswa-lainnya-fti/export/excel', [MahasiswaLainnyaFtiController::class, 'exportExcel'])->name('mahasiswa-lainnya-fti.export-excel');
            Route::get('mahasiswa-lainnya-fti/export/pdf', [MahasiswaLainnyaFtiController::class, 'exportPdf'])->name('mahasiswa-lainnya-fti.export-pdf');
        });

        Route::controller(SertifikasikompFtiController::class)->group(function () {
            // Read
            Route::get('/Sertifikasi-komp-fti', 'index')->name('Sertifikasi-komp-fti');

            // Create
            Route::get('/Sertifikasi-komp-fti/create', 'create')->name('Sertifikasi-komp-fti.create');
            Route::post('/Sertifikasi-komp-fti', 'store')->name('Sertifikasi-komp-fti.store');

            // Update
            Route::get('/Sertifikasi-komp-fti/{sertifikasiKomp}/edit', 'edit')->name('Sertifikasi-komp-fti.edit');
            Route::put('/Sertifikasi-komp-fti/{sertifikasiKomp}', 'update')->name('Sertifikasi-komp-fti.update');

            // Delete
            // Di dalam grup route:
            Route::delete('/Sertifikasi-komp-fti/{sertifikasiKomp}', [SertifikasikompFtiController::class, 'destroy'])->name('Sertifikasi-komp-fti.destroy'); // Hapus titik koma ganda

            // Export routes
            Route::get('Sertifikasi-komp-fti/export/excel', [SertifikasikompFtiController::class, 'exportExcel'])->name('Sertifikasi-komp-fti.export-excel');
            Route::get('Sertifikasi-komp-fti/export/pdf', [SertifikasikompFtiController::class, 'exportPdf'])->name('Sertifikasi-komp-fti.export-pdf');
        });


        //Rata-rata Masa tunggu
        Route::get('RataMT-fti', [RataMTController::class, 'index'])->name('RataMT-fti');
        Route::get('RataMT-fti/create', [RataMTController::class, 'create'])->name('RataMT-ftiCreate');


        //Rata-rata Masa tunggu
        Route::get('kesesuaian-fti', [KesesuaianBidangController::class, 'index'])->name('kesesuaian-fti');
        Route::get('kesesuaian-fti/Create', [KesesuaianBidangController::class, 'create'])->name('kesesuaian-ftiCreate');


        //rekap cpl
        Route::get('/prodi/rekap/Cpl', [RekapCPLprodiController::class, 'index'])->name('rekapCPL.prodi');
        Route::get('/prodi/rekap/Cpl/export/excel', [RekapCPLprodiController::class, 'exportExcel'])->name('rekapCPL.prodi.export.excel');
        Route::get('/prodi/rekap/Cpl/export/pdf', [RekapCPLprodiController::class, 'exportPDF'])->name('rekapCPL.prodi.export.pdf');




        Route::get('/prodi/rekap/prestasi', [RekapProdiPrestasiController::class, 'index'])->name('rekapProdi.prestasi');
        Route::get('/prodi/rekap/prestasi/export/excel', [RekapProdiPrestasiController::class, 'exportExcel'])
            ->name('rekapProdi.prestasi.export');
        Route::get('/prodi/rekap/prestasi/export/pdf', [RekapProdiPrestasiController::class, 'exportPdf'])
            ->name('rekapProdi.prestasi.export.pdf');
        Route::get('/prodi/rekap/prestasi/grafik', [RekapProdiPrestasiController::class, 'grafikFilter'])->name('rekapProdi.prestasi.grafik');

        Route::get('/prodi/rekap/serkom', [RekapProdiSerkomController::class, 'index'])->name('rekapProdi.serkom');
        Route::get('/prodi/rekap/serkom/export/excel', [RekapProdiSerkomController::class, 'exportExcel'])->name('rekapProdi.serkom.export.excel');
        Route::get('/prodi/rekap/serkom/export/pdf', [RekapProdiSerkomController::class, 'exportPDF'])->name('rekapProdi.serkom.export.pdf');
        Route::get('/prodi/rekap/serkom/grafik', [RekapProdiSerkomController::class, 'grafik'])->name('rekapProdi.serkom.grafik');


        Route::get('/prodi/rekap/mhsHki', [RekapProdimhsHkiController::class, 'index'])->name('rekapProdi.mhsHki');
        Route::get('/prodi/rekap/mhsHki/export/excel', [RekapProdimhsHkiController::class, 'exportExcel'])->name('rekapProdi.mhsHki.export.excel');
        Route::get('/prodi/rekap/mhsHki/export/pdf', [RekapProdimhsHkiController::class, 'exportPDF'])->name('rekapProdi.mhsHki.export.pdf');
        Route::get('/prodi/rekap/hki-mahasiswa/grafik', [RekapProdimhsHkiController::class, 'grafik'])->name('rekapProdi.hki.grafik');


        Route::get('/prodi/rekap/publikasi', [RekapProdipublikasiController::class, 'index'])->name('rekapProdi.publikasi');
        Route::get('/prodi/rekap/publikasi/export/excel', [RekapProdipublikasiController::class, 'exportExcel'])->name('rekapProdi.publikasi.export.excel');
        Route::get('/prodi/rekap/publikasi/export/pdf', [RekapProdipublikasiController::class, 'exportPDF'])->name('rekapProdi.publikasi.export.pdf');
        Route::get('/prodi/rekap/publikasi-mahasiswa/grafik', [RekapProdipublikasiController::class, 'grafik'])->name('rekapProdi.publikasi.grafik');

        Route::get('/prodi/rekap/mhsAdopsi', [RekapProdimhsAdopsiController::class, 'index'])->name('rekapProdi.mhsAdopsi');
        Route::get('/prodi/admin/rekap/mhsAdopsi/export/excel', [RekapProdimhsAdopsiController::class, 'exportExcel'])->name('rekapProdi.mhsAdopsi.export.excel');
        Route::get('/prodi/admin/rekap/mhsAdopsi/export/pdf', [RekapProdimhsAdopsiController::class, 'exportPDF'])->name('rekapProdi.mhsAdopsi.export.pdf');
        Route::get('/prodi/rekap/adopsi-mahasiswa/grafik', [RekapProdimhsAdopsiController::class, 'grafik'])->name('rekapProdi.adopsi.grafik');


        Route::get('/prodi/rekap/mhsKaryaLainnya', [RekapProdimhsKaryalainnyaController::class, 'index'])->name('rekapProdi.mhsKaryaLainnya');
        Route::get('/prodi/rekap/mhsKaryaLainnya/export/excel', [RekapProdimhsKaryalainnyaController::class, 'exportExcel'])->name('rekapProdi.mhsKaryaLainnya.exportExcel');
        Route::get('/prodi/rekap/mhsKaryaLainnya/export/pdf', [RekapProdimhsKaryalainnyaController::class, 'exportPDF'])->name('rekapProdi.mhsKaryaLainnya.export.pdf');
        Route::get('/prodi/rekap/karya-mahasiswa-lainnya/grafik', [RekapProdimhsKaryalainnyaController::class, 'grafik'])->name('rekapProdi.karyalainnya.grafik');



        // Route utama untuk rekap publikasi
        Route::get('/fakultas/rekap/publikasi', [RekapFakulpublikasiController::class, 'index'])->name('rekapFakul.publikasi');

        // Route untuk detail publikasi (untuk modal)
        Route::get('/fakultas/rekap/publikasi/{id}', [RekapFakulpublikasiController::class, 'show'])->name('rekapFakul.publikasi.show');

        // Route untuk export single record
        Route::get('/fakultas/rekap/publikasi/{id}/export', [RekapFakulpublikasiController::class, 'exportSingle'])->name('rekapFakul.publikasi.export');




        //Menu Prodi FEB
        // MENU PRODI FEB

        //Pelaksanaan Prodi FEB
        Route::get('prodi-feb', [CplFebController::class, 'index'])->name('prodi-feb');



        //MENU DOSEN
        // MENU DOSEN
        // CAPAIAN-PEMBELAJARAN

        Route::get('/dosen/dok-rek', [DosenDokRekController::class, 'index'])->name('dosen.dokrek.index');

        Route::resource('dosen/rekognisi', RekognisiDosenController::class)
            ->except(['show'])
            ->names('dosen.rekognisi');



        // Tambahkan di bawah resource route kamu
        Route::get('dosen/rekognisi/export-excel', [RekognisiDosenController::class, 'exportExcel'])->name('dosen.rekognisi.export-excel');

        Route::get('/rekognisi/export-pdf', [RekognisiDosenController::class, 'exportPdf'])->name('dosen.rekognisi.export-pdf');
        Route::delete('/dosen/rekognisi/{id}', [RekognisiDosenController::class, 'destroy'])->name('dosen.rekognisi.destroy');
        Route::delete('/dosen/rekognisi/{id}', [RekognisiDosenController::class, 'destroy'])->name('dosen.rekognisi.destroy');






        // MENU SERTIFIKASI KOMPETENSI MAHASISWA FTI
        //setifikasi kompetensi mahasiswa FTI
        // Route::get('karya-dosen', [KaryaDosenController::class, 'index'])->name('karya-dosen');
        // Route::get('karya-dosen/create', [KaryaDosenController::class, 'create'])->name('karya-dosen.create');
        // Route::post('karya-dosen', [KaryaDosenController::class, 'store'])->name('karya-dosen.store');

        Route::get('karya-dosen', [KaryaDosenController::class, 'index'])->name('karya-dosen.index');
        Route::get('karya-dosen/create', [KaryaDosenController::class, 'create'])->name('karya-dosen.create');
        Route::post('karya-dosen', [KaryaDosenController::class, 'store'])->name('karya-dosen.store');
        Route::get('karya-dosen/{id}', [KaryaDosenController::class, 'show'])->name('karya-dosen.show');
        Route::get('karya-dosen/{id}/edit', [KaryaDosenController::class, 'edit'])->name('karya-dosen.edit');
        Route::put('karya-dosen/{id}', [KaryaDosenController::class, 'update'])->name('karya-dosen.update');
        Route::delete('karya-dosen/{id}', [KaryaDosenController::class, 'destroy'])->name('karya-dosen.destroy');

        // Route tambahan untuk export dan download
        Route::get('karya-dosen/export/excel', [KaryaDosenController::class, 'exportExcel'])->name('karya-dosen.export-excel');
        Route::get('karya-dosen/export/pdf', [KaryaDosenController::class, 'exportPDF'])->name('karya-dosen.export-pdf');
        Route::get('karya-dosen/{id}/download', [KaryaDosenController::class, 'downloadFile'])->name('karya-dosen.download');


        // MENU SERTIFIKASI KOMPETENSI MAHASISWA FTI
        //setifikasi kompetensi mahasiswa FTI
        Route::get('karya-mahasiswa-fti', [KaryaMhsFtiController::class, 'index'])->name('karya-mahasiswa-fti');
        Route::get('karya-mahasiswa-fti/create', [KaryaMhsFtiController::class, 'create'])->name('karya-mahasiswa-fti-Create');


        // MENU DOSEN - CAPAIAN PEMBELAJARAN DOSEN
        Route::get('/cpl-dosen', [CplDosenController::class, 'index'])->name('cpl-dosen');
        Route::get('/cpl-dosen/create', [CplDosenController::class, 'create'])->name('cpl-dosen.create');
        Route::post('/cpl-dosen', [CplDosenController::class, 'store'])->name('cpl-dosen.store');

        Route::get('/cpl-dosen/{cplDosen}/edit', [CplDosenController::class, 'edit'])->name('cpl-dosen.edit');
        Route::put('/cpl-dosen/{cplDosen}', [CplDosenController::class, 'update'])->name('cpl-dosen.update');
        Route::delete('/cpl-dosen/{id}', [CplDosenController::class, 'destroy'])->name('cpl-dosen.destroy');


        // File/dokumen
        Route::get('/cpl-dosen/download/{cplDosen}', [CplDosenController::class, 'downloadDocument'])->name('cpl-dosen.download');
        Route::delete('/cpl-dosen/{cplDosen}/delete-document', [CplDosenController::class, 'deleteDocument'])->name('cpl-dosen.delete-document');

        // Export
        Route::get('cpl-dosen/view/{cplDosen}', [CplDosenController::class, 'viewDocument'])->name('cpl-dosen.view');
        Route::get('/cpl-dosen/export/excel', [CplDosenController::class, 'exportExcel'])->name('cpl-dosen.export-excel');
        Route::get('/cpl-dosen/export/pdf', [CplDosenController::class, 'exportPdf'])->name('cpl-dosen.export-pdf');
        Route::get('/cpl-dosen/download/{cplDosen}', [CplDosenController::class, 'downloadDocument'])->name('cpl-dosen.download');


        //Menu Pelaksaaan Penelitian

        // MENU ADMIN USER

        //MENU user
        Route::get('user', [UserController::class, 'index'])->name('user');
        Route::get('user/create', [UserController::class, 'create'])->name('userCreate');
        Route::post('user/store', [UserController::class, 'store'])->name('userStore');
        Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('userEdit');
        Route::post('user/update/{id}', [UserController::class, 'update'])->name('userUpdate');
        Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('userDestroy');
        Route::get('user/excel', [UserController::class, 'excel'])->name('userExcel');
        Route::get('user/pdf', [UserController::class, 'pdf'])->name('userPdf');
    }

);
