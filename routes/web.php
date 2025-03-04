<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ExtraserviceController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GalryController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\HistoriController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Karyawan\DashboardController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\LoketController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengecekanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\StepController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TagmetaController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\TipemobilController;
use App\Http\Controllers\WAsenderController;
use App\Models\Booking;
use App\Models\Photocek;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/foto', function () {
    $photos = Photocek::where('created_at', '<=', Carbon::now()->subMonths(
        2
    ))->latest()->get();
    foreach ($photos as $photo) {
        if ($photo->photo == null) {
            # code...
        } else {
            Storage::disk('local')->delete('public/photocek/' . $photo->photo);
            $photo->update(['photo' => null]);
        }
    }
    return "Foto dihapus Sebagian";
});

Route::get('/tes', function () {
    $pesan = 'Halo,
Semoga Anda selalu diberikan kesehatan dan Kebahagiaan.

Kami dari *KILAT PREMIUM WASH* memberitahukan kendaraan :

        *No : BK0000RAB*

PENGERJAAN LAYANAN ANDA SUDAH SELESAI, Silahkan untuk melakukan pengambilan Kendaraan Anda. Terima kasih 🙏🏻

Info lebih lanjut Telp/WhatsApp : *0821 6061 9089*
———————————————————-

www.kilatpremiumwash.com
@kilatpremiumwash';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => '085297161229',
            'message' => $pesan,
            'countryCode' => '62', //optional
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: AhkkPYXHECUUm21uv6eX' //change TOKEN to your actual token
        ),
    ));

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }
    curl_close($curl);

    if (isset($error_msg)) {
        echo $error_msg;
    }
    echo $response;

    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_HEADER, 0);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    // curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    // curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
    // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($curl, CURLOPT_POST, 1);

    // $data_post = [
    //     'id_device' => $id_device,
    //     'api-key' => $api_key,
    //     'no_hp'   => $no_hp,
    //     'pesan'   => $pesan
    // ];
    // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
    // curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    // $response = curl_exec($curl);
    // curl_close($curl);

    // $curl = curl_init();

    // curl_setopt_array($curl, array(
    //     CURLOPT_URL => 'https://wa-kilatwash.candio.co.id/send-message',
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => '',
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => 'POST',
    //     CURLOPT_POSTFIELDS => array('message' => $pesan, 'number' => '081260268381')
    // ));

    // $response = curl_exec($curl);

    // curl_close($curl);
    // echo $response;
});
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
// Route::get('/', function () { return redirect()->route('login');})->name('landing.index');
Route::get('/about', [LandingController::class, 'about'])->name('landing.about');
Route::get('/layanan', [LandingController::class, 'layanan'])->name('landing.layanan');
Route::get('/booking', [LandingController::class, 'booking'])->name('landing.booking');
Route::get('/galery/landing', [LandingController::class, 'galery'])->name('landing.galery');
Route::get('/contact', [LandingController::class, 'contact'])->name('landing.contact');
Route::get('/cek/{kendaraan}', [LandingController::class, 'cek'])->name('landing.cek');
Route::get('/pengerjaan/{id}', [LoketController::class, 'pengerjaan'])->name('pengerjaan.show');
Route::post('/landingbooking/{id}', [LandingController::class, 'bookingorder'])->name('landing.bookingorder');

Auth::routes(['reset' => false, 'register' => false, 'verify' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //LOKET
    Route::get('/getProduk', [LoketController::class, 'getProduk'])->name('getProduk');
    Route::get('/orderan/{id}', [LoketController::class, 'orderan'])->name('orderan');
    Route::post('/orderan/{id}', [LoketController::class, 'tambah_orderan'])->name('orderan.store');
    Route::post('/bookingorder', [LoketController::class, 'bookingorder'])->name('bookingorder');
    Route::get('/booking/{id}', [LoketController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}/update', [LoketController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{id}/destroy', [LoketController::class, 'destroy'])->name('booking.destroy');
    Route::get('/pengecekan/{id}', [LoketController::class, 'pengecekan'])->name('pengecekan.home');
    Route::delete('/orderan/{id}', [LoketController::class, 'delete_orderan'])->name('orderan.delete');
    Route::get('/sendwa/{id}', [WAsenderController::class, 'send'])->name('wa.send');
    Route::get('/selesai', [LoketController::class, 'selesai'])->name('selesai');
    Route::get('/serah-terima', [LoketController::class, 'serah_terima'])->name('serahterima');
    Route::get('/serah-terima/{id}/cetak', [LoketController::class, 'cetak'])->name('form.cetak');
    Route::get('/qr-code/{id}', [LoketController::class, 'qrcode'])->name('cetak.qrcode');




    //CEK MOBIL
    Route::post('/cekmasuk/{id}', [PengecekanController::class, 'cekmasuk'])->name('cekmasuk');
    Route::get('/cekmasuk/{id}', [PengecekanController::class, 'qury_cekmasuk'])->name('qurycekmasuk');
    Route::post('/cekkeluar', [PengecekanController::class, 'cekkeluar'])->name('cekkeluar');
    Route::get('/photocek/{id}', [PengecekanController::class, 'show_photocek'])->name('photocek.index');
    Route::Post('/photocek/{id}', [PengecekanController::class, 'post_photo_cek'])->name('photocek.store');
    Route::delete('/photocek/{id}', [PengecekanController::class, 'delete'])->name('photocek.delete');


    // Histori Pekerjaan
    Route::get('/histori/{id}', [HistoriController::class, 'show'])->name('histori.show');
    Route::post('/histori/{id}', [HistoriController::class, 'store'])->name('histori.store');
    Route::delete('/histori/{id}/destroy', [HistoriController::class, 'destroy'])->name('histori.destroy');
    Route::post('/waktu/{id}/update', [HistoriController::class, 'update_waktu'])->name('histori.update_waktu');

    //Kasir
    Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
    Route::post('/kasir/{id}/bayar', [KasirController::class, 'bayar'])->name('kasir.bayar');
    Route::post('/kasir/{id}/diskon', [KasirController::class, 'diskon'])->name('kasir.diskon');
    Route::get('/kasir/{id}/reset_dikon', [KasirController::class, 'reset_dikon'])->name('kasir.diskon.reset');
    Route::get('/invoice/{id}/cetak', [InvoiceController::class, 'cetak'])->name('invoice.cetak');
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{id}', [PengeluaranController::class, 'edit'])->name('pengeluaran.edit');
    Route::post('/pengeluaran/{id}', [PengeluaranController::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy'])->name('pengeluaran.destroy');
    Route::get('/wa-foto/{id}', [WAsenderController::class, 'wa_foto'])->name('wa.foto');
    Route::get('/wa-document/{id}', [WAsenderController::class, 'send_pdf'])->name('wa.pdf');
    Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('pemasukan.index');
    Route::post('/pemasukan', [PemasukanController::class, 'store'])->name('pemasukan.store');
    Route::get('/pemasukan/{id}', [PemasukanController::class, 'edit'])->name('pemasukan.edit');
    Route::post('/pemasukan/{id}', [PemasukanController::class, 'update'])->name('pemasukan.update');
    Route::delete('/pemasukan/{id}', [PemasukanController::class, 'destroy'])->name('pemasukan.destroy');


    //Admin
    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class)->only('index', 'store', 'edit', 'destroy', 'create');
    Route::post('/product/{id}/update', [ProductController::class, 'update'])->name('product.update');
    Route::resource('extraservice', ExtraserviceController::class);
    Route::resource('member', MemberController::class)->only('index', 'store', 'edit', 'update', 'destroy');
    Route::resource('pengguna', PenggunaController::class);
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::get('/admin/booking', [AdminController::class, 'booking'])->name('admin.booking');
    Route::get('/admin/transaksi', [AdminController::class, 'transaksi'])->name('admin.transaksi');
    Route::get('/admin/histori', [AdminController::class, 'histori'])->name('admin.histori');
    Route::resource('tagmeta', TagmetaController::class);
    Route::resource('galery', GalryController::class);
    Route::resource('testimoni', TestimoniController::class)->only('index', 'store', 'edit', 'destroy');
    Route::post('/testimoni/{id}/update', [TestimoniController::class, 'update'])->name('testimoni.update');
    Route::resource('tipemobil', TipemobilController::class)->only('index', 'create', 'store', 'edit', 'destroy');
    Route::post('/tipemobil/{id}/update', [TipemobilController::class, 'update'])->name('tipemobil.update');
    Route::get('/product/step/{id}', [StepController::class, 'step'])->name('product.step');
    Route::post('/product/step/{id}', [StepController::class, 'store'])->name('step.store');
    Route::get('/product/step/{id}/edit', [StepController::class, 'edit'])->name('step.edit');
    Route::put('/product/step/{id}', [StepController::class, 'update'])->name('step.update');
    Route::delete('/product/step/{id}', [StepController::class, 'destroy'])->name('step.destroy');
    Route::get('/product/step/{id}/show', [StepController::class, 'show'])->name('step.show');

    Route::get('/device', [WAsenderController::class, 'index'])->name('device.index');
    Route::post('/device', [WAsenderController::class, 'store'])->name('device.store');
    Route::get('/device/{id}', [WAsenderController::class, 'edit'])->name('device.edit');
    Route::put('/device/{id}', [WAsenderController::class, 'update'])->name('device.update');

    Route::get('/admin/pengeluaran', [AdminController::class, 'pengeluaran_tahunan'])->name('admin.pengeluaran');
    Route::get('/kasir/layanan', [KasirController::class, 'layanan'])->name('kasir.layanan');

    Route::get('/trx-taggal/{taggal}', [AdminController::class, 'trx_tanggal'])->name('trx-tanggal');


    Route::middleware(['superadmin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/reset/transaksi/{id}', [AdminController::class, 'reset_transaksi'])->name('admin.reset.transaksi');
        Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
    });

    Route::middleware(['loket'])->group(function () {
        Route::get('/loket', [LoketController::class, 'index'])->name('loket.home');
    });

    Route::middleware(['pengecekan'])->group(function () {
        Route::get('/pengecekan', [PengecekanController::class, 'index'])->name('pengecekan.index');
    });

    Route::middleware(['pengerjaan'])->group(function () {
        Route::get('/histori', [HistoriController::class, 'index'])->name('histori.index');
    });

    Route::middleware(['kasir'])->group(function () {
        Route::get('/dashboard/kasir', [KasirController::class, 'dashboard'])->name('kasir.dashboard');
        Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/filter', [KasirController::class, 'filter'])->name('kasir.filter');
    });

    Route::middleware(['gudang'])->group(function () {
        Route::get('/gudang', [GudangController::class, 'index'])->name('gudang.index');
        Route::get('/gudang/{id}/edit', [GudangController::class, 'edit'])->name('gudang.edit');
        Route::post('/gudang', [GudangController::class, 'store'])->name('gudang.store');
        Route::post('/gudang/{id}/update', [GudangController::class, 'update'])->name('gudang.update');
        Route::post('/gudang/{id}/delete', [GudangController::class, 'delete_barang'])->name('gudang.delete');
        Route::get('/gudang/barang', [GudangController::class, 'view_masuk'])->name('barang.masuk');
        Route::post('/gudang/barang', [GudangController::class, 'post_masuk'])->name('barang.post');
        Route::post('/gudang/barang/{id}/delete', [GudangController::class, 'delete'])->name('barang.delete');

        Route::get('/gudang/barang/keluar', [GudangController::class, 'view_keluar'])->name('barang.keluar');
        Route::post('/gudang/barang/keluar', [GudangController::class, 'post_keluar'])->name('barang.post.keluar');
        Route::post('/gudang/barang/keluar/{id}/delete', [GudangController::class, 'delete_keluar'])->name('barang.delete.keluar');

        Route::get('/gudang/histori/{id}', [GudangController::class, 'histori'])->name('gudang.histori');

        Route::get('/gudang/barcode', [GudangController::class, 'view_barcode'])->name('barcode.index');
        Route::post('/barcode', [GudangController::class, 'post_barcode'])->name('barcode.post');
    });
});

//INVOICE
Route::get('/invoice/{invoice}', [InvoiceController::class, 'index'])->name('invoice.index');

//Listing tunggu
Route::get('/listing', [ListingController::class, 'index'])->name('listing.index');
