<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    use HasFactory;
    /**
     * $table->unsignedBigInteger('orang_id');
      *      $table->foreign('orang_id')->references('id')->on('orangs');
      *      $table->unsignedBigInteger('user_id');
       *     $table->foreign('user_id')->references('id')->on('users');
       *     $table->integer('gaji_pokok')->unsigned();
     */
    protected $fillable = [
        'orang_id',
        'user_id',
        'gaji_pokok'
    ];
}
