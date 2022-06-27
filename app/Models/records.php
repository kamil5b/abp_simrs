<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class records extends Model
{
    use HasFactory;
    /*
    $table->unsignedBigInteger('pasien_id');
            $table->foreign('pasien_id')->references('id')->on('pasiens');
            $table->unsignedBigInteger('dokter_id');
            $table->foreign('dokter_id')->references('id')->on('dokters');
            $table->string('encode_record');
    */
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'encode_record'
    ];
}
