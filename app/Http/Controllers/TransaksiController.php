<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Transaksi;
use App\Transformers\TransaksiTransformer;
use Illuminate\Foundation\Http\response;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransaksiController extends ApiController
{
    public function index(){

       $transaksi = Transaksi::with('kategoris', 'subkategoris')->orderBy('id', 'desc')->get();

       return $this->response->collection($transaksi , new TransaksiTransformer);
    }

    public function show($id){

        $transaksi = Transaksi::with('kategoris', 'subkategoris')->orderBy('id', 'desc')->where('id', $id)->first();

        return $this->response->item($transaksi , new TransaksiTransformer);
    }

    public function semuaPemasukan(){

        $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('tipe_transaksi', 0)
        ->orderBy('id', 'desc')->get();

        return $this->response->collection($transaksi , new TransaksiTransformer);

    }

     public function semuaPengeluaran(){

        $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('tipe_transaksi', 1)
        ->orderBy('id', 'desc')->get();

        return $this->response->collection($transaksi , new TransaksiTransformer);

    }

     public function semuaHutang(){
        $transaksi = DB::table('transaksi')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 0)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->orderBy('transaksi.id', 'desc')->get();

        $transaksis = ['data' => $transaksi];
        return $transaksis;

    }

      public function semuaPiutang(){

             $transaksi = DB::table('transaksi')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 1)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label', 'sub_kategori.label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->orderBy('transaksi.id', 'desc')->get();
                 return $transaksi;
    }

    public function totalPemasukan(){
        $transaksi = Transaksi::where('tipe_transaksi', 0)->orderBy('id', 'desc')->sum('jumlah_uang');

         $total = [
            'data' => [
                'total' => $transaksi,
            ]
        ];

        return $total;

        //return $this->response->collection($transaksi , new TransaksiTransformer);
    }

    public function totalPengeluaran(){
        $transaksi = Transaksi::where('tipe_transaksi', 1)->orderBy('id', 'desc')->sum('jumlah_uang');

         $total = [
            'data' => [
                'total' => $transaksi,
            ]
        ];

        return $total;

        //return $this->response->collection($transaksi , new TransaksiTransformer);
    }

    public function inputTransaksi(Request $request){
        $transaksi = new Transaksi;

        $transaksi->kategori_id = $request->input('kategori_id');
        $transaksi->sub_kategori_id = $request->input('sub_kategori_id');
        $transaksi->tipe_transaksi = $request->input('tipe_transaksi');
        $transaksi->jumlah_uang = $request->input('jumlah_uang');
        $transaksi->tanggal_transaksi = $request->input('tanggal_transaksi');
        $transaksi->catatan = $request->input('catatan');

        $transaksi->save();


        return [
                "data" => [
                    "message" => "success",
                    "status_code" => 1,
                    "tanggal_transaksi" => $transaksi->tanggal_transaksi,
                ]
             ];
    }
}
