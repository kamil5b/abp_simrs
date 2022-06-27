<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap')->index();
            $table->string('nomor_hp')->unique();
            $table->date('tanggal_lahir');
            $table->enum('kelamin', array('Pria', 'Wanita'));
            $table->string('alamat');
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
        Schema::dropIfExists('orangs');
    }
}
