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
    $api->post('login', 'App\Http\Controllers\ProjectController@login');
    $api->get('transaksi/semua/{project}', 'App\Http\Controllers\TransaksiController@index');
    $api->get('transaksi/perpage/{project}', 'App\Http\Controllers\TransaksiController@transaksiPerpage');
    $api->get('transaksi/pemasukan/{project}', 'App\Http\Controllers\TransaksiController@semuaPemasukan');
    $api->get('transaksi/pengeluaran/{project}', 'App\Http\Controllers\TransaksiController@semuaPengeluaran');
    $api->get('transaksi/hutang/{project}', 'App\Http\Controllers\TransaksiController@semuaHutang');
    $api->get('transaksi/piutang/{project}', 'App\Http\Controllers\TransaksiController@semuaPiutang');
    $api->get('transaksi/{id}', 'App\Http\Controllers\TransaksiController@show');
    $api->get('transaksi/pemasukan/total/{project}', 'App\Http\Controllers\TransaksiController@totalPemasukan');
    $api->get('transaksi/pengeluaran/total/{project}', 'App\Http\Controllers\TransaksiController@totalPengeluaran');
     $api->get('transaksi/gambar/{id}', 'App\Http\Controllers\TransaksiController@requestGambar');
    $api->post('transaksi', 'App\Http\Controllers\TransaksiController@inputTransaksi');
    $api->put('transaksi/ubah/{id}', 'App\Http\Controllers\TransaksiController@updateTransaksi');
     $api->post('transaksi/gambar/update/{id}', 'App\Http\Controllers\TransaksiController@updateGambarTransaksi');

    $api->post('project/input', 'App\Http\Controllers\ProjectController@inputProject');
    $api->get('project', 'App\Http\Controllers\ProjectController@index');

    $api->get('kategori/pemasukan', 'App\Http\Controllers\KategoriController@kategoriPemasukan');
     $api->get('kategori/{id}/sub', 'App\Http\Controllers\KategoriController@subKategori');
    $api->get('kategori/pengeluaran', 'App\Http\Controllers\KategoriController@kategoriPengeluaran');
    $api->get('kategori/pemasukan/total/{project}', 'App\Http\Controllers\KategoriController@totalPemasukanPerkategori');
    $api->get('kategori/pengeluaran/total/{project}', 'App\Http\Controllers\KategoriController@totalPengeluaranPerkategori');
    $api->post('kategori', 'App\Http\Controllers\KategoriController@inputKategori');
    $api->post('kategori/sub', 'App\Http\Controllers\KategoriController@inputSubKategori');
    $api->put('kategori/{id}/ubah', 'App\Http\Controllers\KategoriController@updateKategori');
    $api->put('kategori/sub/{id}/ubah', 'App\Http\Controllers\KategoriController@updateSubKategori');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
