<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\SubKategori;
use App\Transaksi;
use App\Transformers\KategoriTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends ApiController
{
    public function kategoriPemasukan(){
       $kategori = DB::table('kategori')
           ->leftJoin('sub_kategori', 'kategori.kategori_id', '=', 'sub_kategori.sup_id')
           ->select('kategori.kategori_id', 'kategori.label as kategori_label', 'kategori.termasuk_hutang_piutang', DB::raw('COUNT(sub_kategori.sup_id) as banyak_sub_kategori'))
           ->where('kategori.tipe_kategori', 0)
           ->groupBy('kategori.kategori_id')
           ->get();

       $kategoris = ['data' => $kategori];
        return $kategoris;
    }

    public function kategoriPengeluaran(){
         $kategori = DB::table('kategori')
           ->leftJoin('sub_kategori', 'kategori.kategori_id', '=', 'sub_kategori.sup_id')
           ->select('kategori.kategori_id', 'kategori.label as kategori_label', 'kategori.termasuk_hutang_piutang', DB::raw('COUNT(sub_kategori.sup_id) as banyak_sub_kategori'))
           ->where('kategori.tipe_kategori', 1)
           ->groupBy('kategori.kategori_id')
           ->get();

       $kategoris = ['data' => $kategori];
        return $kategoris;
    }

    public function subKategori($id){
        $subKategori = SubKategori::where('sup_id', $id)->get();
        $subKategoris = ['data' => $subKategori];
        return $subKategoris;
    }

    public function totalPemasukanPerkategori(){

      $totalPemasukan = DB::table('transaksi')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->select('kategori.kategori_id', 'kategori.kategori_id', 'kategori.label as kategori_label', DB::raw('SUM(transaksi.jumlah_uang) as jumlah_uang'))->where('tipe_transaksi', 0)->orderBy('kategori_id')->groupBy('kategori_id')->get();
        $total = ['data' => $totalPemasukan];
        return $total;
    }

    public function totalPengeluaranPerkategori(){
          $totalPemasukan = DB::table('transaksi')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->select('kategori.kategori_id', 'kategori.kategori_id', 'kategori.label as kategori_label', DB::raw('SUM(transaksi.jumlah_uang) as jumlah_uang'))->where('tipe_transaksi', 1)->orderBy('kategori_id')->groupBy('kategori_id')->get();
        $total = ['data' => $totalPemasukan];
        return $total;
    }

    public function inputKategori (Request $request){

        $input = new Kategori();
        $input->label = $request->input('label');
        $input->termasuk_hutang_piutang = $request->input('termasuk_hutang_piutang');
        $input->tipe_kategori = $request->input('tipe_kategori');

        $input->save();

        return [
                "data" => [
                    "message" => "success",
                    "status_code" => 1,
                    "kategori_label" => $input->label,
                ]
             ];
    }

     public function inputSubKategori (Request $request){

        $input = new SubKategori();
        $input->label = $request->input('label');
        $input->sup_id = $request->input('sup_id');

        $input->save();

        return [
                "data" => [
                    "message" => "success",
                    "status_code" => 1,
                    "sub_kategori_label" => $input->label,
                ]
             ];
    }

  public function updateKategori(Request $request, $id) {
      $kategori = Kategori::find($id);
      $kategori->label = $request->input('label');

      $kategori->update();

     return [
        "data" => [
            "message" => "success",
            "status_code" => 1,
            "updated_at" => $kategori->updated_at,
        ]
     ];
    }

  public function updateSubKategori(Request $request, $id) {
    $kategori = SubKategori::find($id);
    $kategori->label = $request->input('label');

    $kategori->update();

    return [
        "data" => [
            "message" => "success",
            "status_code" => 1,
            "updated_at" => $kategori->updated_at,
        ]
     ];
  }
}