<?php

namespace App;

use App\Kategori;
use App\SubKategori;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    public function kategoris(){
        return $this->hasMany(Kategori::class, 'kategori_id', 'kategori_id');
    }

    public function subkategoris(){
        return $this->hasMany(SubKategori::class, 'sub_kategori_id', 'sub_kategori_id');
    }
}
