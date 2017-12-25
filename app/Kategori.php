<?php

namespace App;

use App\SubKategori;
use App\Transaksi;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    public function transaksis(){
        return $this->belongsTo(Transaksi::class, 'kategori_id', 'kategori_id');
    }

    public function subkategoris(){
        return $this->hasMany(SubKategori::class, 'sup_id', 'kategori_id');
    }
}
