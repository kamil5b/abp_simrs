<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class orang extends Model
{
    protected $fillable = [
        'nama_lengkap',
        'nomor_hp',
        'tanggal_lahir',
        'kelamin',
        'alamat'
    ];
    use HasFactory;
}
