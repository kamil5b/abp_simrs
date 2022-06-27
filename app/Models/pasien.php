<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    protected $fillable = [
        'orang_id'
    ];
    use HasFactory;
}
