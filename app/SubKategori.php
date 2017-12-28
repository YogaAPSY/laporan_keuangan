<?php

namespace App;

use App\Kategori;
use App\Transaksi;
use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    protected $table = 'sub_kategori';
    protected $primaryKey = 'sub_kategori_id';

    public function transaksis(){
        return $this->belongsTo(Transaksi::class, 'sub_kategori_id', 'sub_kategori_id');
    }

    public function kategoris(){
        return $this->belongsTo(Kategori::class, 'sup_id', 'kategori_id');
    }
}
