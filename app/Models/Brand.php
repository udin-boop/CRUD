<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'negara_asal',
        'tahun_berdiri',
        'tanggal_berdiri',
    ];
}
