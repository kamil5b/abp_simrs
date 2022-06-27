<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kamar extends Model
{
    use HasFactory;
    /*
    *$table->unsignedBigInteger('no_ruangan')->unique();
            $table->unsignedBigInteger('pasien_id')->nullable();
            $table->foreign('pasien_id')->references('id')->on('pasiens');
            $table->string('diagnosa')->nullable();
    */
    protected $fillable = [
        'no_ruangan',
        'pasien_id',
        'diagnosa'
    ];
}
