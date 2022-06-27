<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat extends Model
{
    use HasFactory;
    /*
    $table->string('nama_obat');
            $table->string('kode_obat');
            $table->string('kandungan');
            $table->integer('kuantitas')->unsigned();
            $table->string('tipe_kuantitas');
            $table->integer('harga')->unsigned();
    */
    protected $fillable = [
        'nama_obat',
        'kode_obat',
        'kandungan',
        'kuantitas',
        'tipe_kuantitas',
        'harga'
    ];
}
