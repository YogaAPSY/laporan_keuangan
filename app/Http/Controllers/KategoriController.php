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
        $subKategori = SubKategori::where('sub_kategori_id', $id)->get();
        $subKategoris = ['data' => $subKategori];
        return $subKategoris;
    }

    public function totalPemasukanPerkategori(){
        $totalPemasukan = Transaksi::where('tipe_transaksi', 0)->orderBy('kategori_id')->get();

        return $this->response->collection($totalPemasukan , new KategoriTransformer);
    }

    public function totalPengeluaranPerkategori(){
        $totalPemasukan = Transaksi::where('tipe_transaksi', 1)->orderBy('kategori_id')->get();

        return $this->response->collection($totalPemasukan , new KategoriTransformer);
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
}