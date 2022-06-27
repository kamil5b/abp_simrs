<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peralatan extends Model
{
    use HasFactory;
    /*
    $table->string('nama_peralatan');
            $table->string('kode_peralatan');
            $table->string('lokasi');
            $table->boolean('dipakai');
    */
    protected $fillable = [
        'nama_peralatan',
        'kode_peralatan',
        'lokasi',
        'dipakai'
    ];
}
