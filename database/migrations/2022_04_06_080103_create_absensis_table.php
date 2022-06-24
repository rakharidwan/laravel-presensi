<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_karyawan')->references('id')->on('karyawans')->onDelete('cascade');
            $table->time('jam_masuk', $precision = 0)->nullable();
            $table->string('jam_keluar')->nullable();
            $table->enum('keterangan',['HADIR','TELAT','TANPA KETERANGAN','IZIN','SAKIT','CUTI','LIBUR']);
            $table->text('pesan')->nullable();
            $table->text('foto')->nullable();
            $table->text('status_ubah')->default(0);
            $table->text('foto_pulang')->nullable();
            $table->string('keterlambatan')->nullable();

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
        Schema::dropIfExists('absensis');
    }
}
