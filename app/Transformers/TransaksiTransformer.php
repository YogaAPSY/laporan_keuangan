<?php
namespace App\Transformers;

use App\Transaksi;
use League\Fractal\TransformerAbstract;

class TransaksiTransformer extends TransformerAbstract
{
    public function transform(Transaksi $transaksi)
    {
        $kategoriss = "";
        $piutang = "";
        foreach ($transaksi->kategoris as $kategori) {
            $kategoriss = $kategori->label;
            $piutang = $kategori->termasuk_hutang_piutang;
        }

        $subkategoriss = "";
        foreach ($transaksi->subkategoris as $subkategori) {
            $subkategoriss = $subkategori->label;
        }

        $projectss = "";
        foreach ($transaksi->projects as $project) {
            $projectss = $project->label;
        }
        return [
            'id' => $transaksi->id,
            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
            'jumlah_uang' => $transaksi->jumlah_uang,
            'catatan' => $transaksi->catatan,
            'tipe_transaksi' => $transaksi->tipe_transaksi,
            'kategori_id' => $transaksi->kategori_id,
            'kategori_label' => $kategoriss,
            'termasuk_hutang_piutang' => $piutang,
            'sub_kategori_id' => $transaksi->sub_kategori_id,
            'sub_kategori_label' => $subkategoriss,
            'project_id' => $transaksi->project_id,
            'project_label' => $projectss
        ];
    }
}
