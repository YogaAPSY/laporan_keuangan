<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Transaksi;
use App\Transformers\TransaksiTransformer;
use Carbon\Carbon;
use Illuminate\Foundation\Http\response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TransaksiController extends ApiController
{
    public function index($project){
        $expiresAt = Carbon::now()->addMonth(1);
        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];

        $transaksi = Transaksi::with('kategoris', 'subkategoris', 'projects')
            ->where('project_id', $project)->orderBy('id', 'desc')
            ->whereBetween('tanggal_transaksi', [$startDate , $endDate])->get();
       } else {
            $transaksi = Transaksi::with('kategoris', 'subkategoris', 'projects')
            ->where('project_id', $project)->orderBy('id', 'desc')->get();
       }

       return $this->response->collection($transaksi , new TransaksiTransformer);
    }

    public function transaksiPerpage($project){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('project_id', $project)->orderBy('id', 'desc')->whereBetween('tanggal_transaksi', [$startDate , $endDate])->paginate(25);
       } else {
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('project_id', $project)->orderBy('id', 'desc')->paginate(25);
       }

       return $this->response->paginator($transaksi , new TransaksiTransformer);
    }

    public function show($id){

        $transaksi = Transaksi::with('kategoris', 'subkategoris', 'projects')->orderBy('id', 'desc')->where('id', $id)->first();

        return $this->response->item($transaksi , new TransaksiTransformer);
    }

    public function semuaPemasukan($project){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
            $transaksi = Transaksi::with('kategoris', 'subkategoris', 'projects')->where('tipe_transaksi', 0)
            ->where('project_id', $project)->orderBy('id', 'desc')->whereBetween('tanggal_transaksi', [$startDate , $endDate])->paginate(25);
       } else {
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('tipe_transaksi', 0)->where('project_id', $project)->orderBy('id', 'desc')->paginate(25);
       }
        return $this->response->paginator($transaksi , new TransaksiTransformer);

    }

     public function semuaPengeluaran($project){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
            $transaksi = Transaksi::with('kategoris', 'subkategoris', 'projects')->where('tipe_transaksi', 1)
            ->where('project_id', $project)->orderBy('id', 'desc')->whereBetween('tanggal_transaksi', [$startDate , $endDate])->paginate(25);
       } else {
            $transaksi = Transaksi::with('kategoris', 'subkategoris')->where('tipe_transaksi', 1)
            ->where('project_id', $project)->orderBy('id', 'desc')->paginate(25);
       }
        return $this->response->paginator($transaksi , new TransaksiTransformer);

    }

     public function semuaHutang($project){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
        $transaksi = DB::table('transaksi')->leftJoin('project', 'transaksi.project_id', '=', 'project.project_id')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 0)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label','project.label as project_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->Where('transaksi.project_id', '=', $project)->whereBetween('transaksi.tanggal_transaksi', [$startDate , $endDate])->orderBy('transaksi.id', 'desc')->paginate(25);
       } else {
             $transaksi = DB::table('transaksi')->leftJoin('project', 'transaksi.project_id', '=', 'project.project_id')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 0)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label','project.label as project_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->Where('transaksi.project_id', '=', $project)->orderBy('transaksi.id', 'desc')->paginate(25);
       }

        $transaksis = ['data' => $transaksi];
        return $transaksis;

    }

      public function semuaPiutang($project){

        if(isset($_GET['start_date']) && isset($_GET['end_date'])){
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];
          $transaksi = DB::table('transaksi')->leftJoin('project', 'transaksi.project_id', '=', 'project.project_id')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 1)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label','project.label as project_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->Where('transaksi.project_id', '=', $project)->whereBetween('transaksi.tanggal_transaksi', [$startDate , $endDate])->orderBy('transaksi.id', 'desc')->paginate(25);
       } else {
             $transaksi = DB::table('transaksi')->leftJoin('project', 'transaksi.project_id', '=', 'project.project_id')->leftJoin('kategori', 'transaksi.kategori_id', '=', 'kategori.kategori_id')->leftJoin('sub_kategori', 'transaksi.sub_kategori_id', '=', 'sub_kategori.sub_kategori_id' ,'or', 'transaksi.sub_kategori_id', '=', 0)->where('transaksi.tipe_transaksi', '=', 0)->select('transaksi.id', 'transaksi.tanggal_transaksi','transaksi.kategori_id', 'transaksi.sub_kategori_id', 'kategori.label as kategori_label','project.label as project_label', 'sub_kategori.label as sub_kategori_label', 'transaksi.jumlah_uang', 'transaksi.catatan', 'transaksi.tipe_transaksi', 'kategori.termasuk_hutang_piutang')->Where('kategori.termasuk_hutang_piutang', '=', 1)->Where('transaksi.project_id', '=', $project)->orderBy('transaksi.id', 'desc')->paginate(25);
       }

        $transaksis = ['data' => $transaksi];
        return $transaksis;
    }

    public function totalPemasukan($project){
        $transaksi = Transaksi::where('tipe_transaksi', 0)->where('project_id', $project)->orderBy('id', 'desc')->sum('jumlah_uang');

         $total = [
            'data' => [
                'total' => $transaksi,
            ]
        ];

        return $total;

        //return $this->response->collection($transaksi , new TransaksiTransformer);
    }

    public function totalPengeluaran($project){
        $transaksi = Transaksi::where('tipe_transaksi', 1)->where('project_id', $project)->orderBy('id', 'desc')->sum('jumlah_uang');

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
        $total_id = 0;

        $id = Transaksi::orderBy('id', 'desc')->first();

        $total_id = 1;
        if(isset($id)){
            $total_id = $id->id + 1;
        }

        $transaksi->kategori_id = $request->input('kategori_id');
        $transaksi->sub_kategori_id = $request->input('sub_kategori_id');
        $transaksi->project_id = $request->input('project_id');
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

        return [
            "data" => [
                "gambar" => $transaksiGambar,
            ]
        ];

    }

    public function updateTransaksi($id, Request $request){
        $transaksi = Transaksi::find($id);

        $transaksi->kategori_id = $request->input('kategori_id');
        $transaksi->sub_kategori_id = $request->input('sub_kategori_id');
        $transaksi->tipe_transaksi = $request->input('tipe_transaksi');
        $transaksi->jumlah_uang = $request->input('jumlah_uang');
        $transaksi->tanggal_transaksi = $request->input('tanggal_transaksi');
        $transaksi->catatan = $request->input('catatan');
        $transaksi->update();

       return [
        "data" => [
            "message" => "success",
            "status_code" => 1,
            "updated_at" => $transaksi->updated_at,
        ]
     ];
    }

    public function updateGambarTransaksi(Request $request, $id){

        $transaksi = Transaksi::find($id);

        File::delete($transaksi->bukti_transaksi);

        $transaksi->bukti_transaksi = $request->file('bukti_transaksi');

        $ext = $transaksi->bukti_transaksi->getClientOriginalExtension();

        if($request->file('bukti_transaksi')->isValid()){
            $foto_name = date('YmdHis') . "_transaksi_" . $id . ".$ext";
            $upload_path = 'image';
            $transaksi->bukti_transaksi = $request->file('bukti_transaksi')->move($upload_path, $foto_name);
        }

       $transaksi->save();

       return [
        "data" => [
            "message" => "success",
            "status_code" => 1,
            "updated_at" => $transaksi->updated_at,
        ]
     ];
    }
}
