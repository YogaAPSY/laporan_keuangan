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

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->orderBy('id', 'desc')->whereBetween('tanggal_transaksi', [$startDate , $endDate])->get();
       } else {
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->orderBy('id', 'desc')->get();
       }

       return $this->response->collection($transaksi , new TransaksiTransformer);
    }

    public function show($id){

        $transaksi = Transaksi::with('kategoris', 'subkategoris')->orderBy('id', 'desc')->where('id', $id)->first();

        return $this->response->item($transaksi , new TransaksiTransformer);
    }

    public function semuaPemasukan(){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('tipe_transaksi', 0)
            ->orderBy('id', 'desc')->whereBetween('tanggal_transaksi', [$startDate , $endDate])->get();
       } else {
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('tipe_transaksi', 0)
            ->orderBy('id', 'desc')->get();
       }
        return $this->response->collection($transaksi , new TransaksiTransformer);

    }

     public function semuaPengeluaran(){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('tipe_transaksi', 1)
            ->orderBy('id', 'desc')->whereBetween('tanggal_transaksi', [$startDate , $endDate])->get();
       } else {
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('tipe_transaksi', 1)
            ->orderBy('id', 'desc')->get();
       }
        return $this->response->collection($transaksi , new TransaksiTransformer);

        return $this->response->collection($transaksi , new TransaksiTransformer);

    }

     public function semuaHutang(){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
        $transaksi = DB::table('transaksi')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 0)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->whereBetween('transaksi.tanggal_transaksi', [$startDate , $endDate])->orderBy('transaksi.id', 'desc')->get();
       } else {
        $transaksi = DB::table('transaksi')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 0)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->orderBy('transaksi.id', 'desc')->get();
       }

        $transaksis = ['data' => $transaksi];
        return $transaksis;

    }

      public function semuaPiutang(){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
        $transaksi = DB::table('transaksi')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 1)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->whereBetween('transaksi.tanggal_transaksi', [$startDate , $endDate])->orderBy('transaksi.id', 'desc')->get();
       } else {
        $transaksi = DB::table('transaksi')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 0)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->orderBy('transaksi.id', 'desc')->get();
       }

        $transaksis = ['data' => $transaksi];
        return $transaksis;
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
        $id = Transaksi::orderBy('id', 'desc')->first();
        $total_id = $id->id + 1;
        $transaksi->kategori_id = $request->input('kategori_id');
        $transaksi->sub_kategori_id = $request->input('sub_kategori_id');
        $transaksi->tipe_transaksi = $request->input('tipe_transaksi');
        $transaksi->jumlah_uang = $request->input('jumlah_uang');
        $transaksi->tanggal_transaksi = $request->input('tanggal_transaksi');
        $transaksi->catatan = $request->input('catatan');
        $transaksi->bukti_transaksi = $request->file('bukti_transaksi');

        $ext = $transaksi->bukti_transaksi->getClientOriginalExtension();

        if($request->file('bukti_transaksi')->isValid()){
            $foto_name = date('YmdHis') . "_transaksi_" . $total_id . ".$ext";
            $upload_path = 'image';
            $transaksi->bukti_transaksi = $request->file('bukti_transaksi')->move($upload_path, $foto_name);
        }

        $transaksi->save();


        return [
                "data" => [
                    "message" => "success",
                    "status_code" => 1,
                    "tanggal_transaksi" => $transaksi->tanggal_transaksi,
                ]
             ];
    }

    public function requestGambar($id){
        $transaksi = Transaksi::where('id', $id)->first();
        $asset = asset($transaksi->bukti_transaksi);
        $transaksiGambar = url($asset);

        return $transaksiGambar;
    }
}
