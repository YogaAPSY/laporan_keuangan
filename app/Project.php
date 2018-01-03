<?php

namespace App;

use App\Transaksi;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';

    protected $primaryKey = 'project_id';

    public function transaksis(){
        return $this->belongsTo(Transaksi::class, 'project_id', 'project_id');
    }
}
