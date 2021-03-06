<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('tranksaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tanggal_transaksi',,30);
            $table->double('jumlah_uang', 50,2);
            $table->text('catatan');
            $table->integer('tipe_tranksaksi');


            $table->integer('kategori_id')->unsigned();
            $table->foreign('kategori_id')->refrences('kategori_id')->on('kategori');

            $table->integer('sub_kategori_id')->unsigned();
            $table->foreign('sub_kategori_id')->refrences('sub_kategori_id')->on('sub_kategori');

            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->refrences('project_id')->on('project');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
