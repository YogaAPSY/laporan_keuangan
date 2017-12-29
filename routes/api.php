<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1',function ($api) {
    $api->get('transaksi/semua', 'App\Http\Controllers\TransaksiController@index');
    $api->get('transaksi/perpage', 'App\Http\Controllers\TransaksiController@transaksiPerpage');
    $api->get('transaksi/pemasukan', 'App\Http\Controllers\TransaksiController@semuaPemasukan');
    $api->get('transaksi/pengeluaran', 'App\Http\Controllers\TransaksiController@semuaPengeluaran');
    $api->get('transaksi/hutang', 'App\Http\Controllers\TransaksiController@semuaHutang');
    $api->get('transaksi/piutang', 'App\Http\Controllers\TransaksiController@semuaPiutang');
    $api->get('transaksi/{id}', 'App\Http\Controllers\TransaksiController@show');
    $api->get('transaksi/pemasukan/total', 'App\Http\Controllers\TransaksiController@totalPemasukan');
    $api->get('transaksi/pengeluaran/total', 'App\Http\Controllers\TransaksiController@totalPengeluaran');
     $api->get('transaksi/gambar/{id}', 'App\Http\Controllers\TransaksiController@requestGambar');
    $api->post('transaksi', 'App\Http\Controllers\TransaksiController@inputTransaksi');
    $api->put('transaksi/ubah/{id}', 'App\Http\Controllers\TransaksiController@updateTransaksi');
     $api->post('transaksi/gambar/update/{id}', 'App\Http\Controllers\TransaksiController@updateGambarTransaksi');

    $api->get('kategori/pemasukan', 'App\Http\Controllers\KategoriController@kategoriPemasukan');
     $api->get('kategori/{id}/sub', 'App\Http\Controllers\KategoriController@subKategori');
    $api->get('kategori/pengeluaran', 'App\Http\Controllers\KategoriController@kategoriPengeluaran');
    $api->get('kategori/pemasukan/total', 'App\Http\Controllers\KategoriController@totalPemasukanPerkategori');
    $api->get('kategori/pengeluaran/total', 'App\Http\Controllers\KategoriController@totalPengeluaranPerkategori');
    $api->post('kategori', 'App\Http\Controllers\KategoriController@inputKategori');
    $api->post('kategori/sub', 'App\Http\Controllers\KategoriController@inputSubKategori');
    $api->put('kategori/{id}/ubah', 'App\Http\Controllers\KategoriController@updateKategori');
    $api->put('kategori/sub/{id}/ubah', 'App\Http\Controllers\KategoriController@updateSubKategori');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
