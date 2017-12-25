<?php
namespace App\Transformers;

use App\Transaksi;
use League\Fractal\TransformerAbstract;

class KategoriTransformer extends TransformerAbstract
{
    public function transform(Transaksi $transaksi)
    {
        $kategoriss = "";
        $piutang = "";
        foreach ($transaksi->kategoris as $kategori) {
            $kategoriss = $kategori->label;
            $piutang = $kategori->termasuk_hutang_piutang;
        }

        return [
            'kategori_id' => $transaksi->kategori_id,
            'kategori_label' => $kategoriss,
            'jumlah_uang' => $transaksi->jumlah_uang
        ];
    }
}
