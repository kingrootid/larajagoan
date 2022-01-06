<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Warga extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'status_perkawinan',
        'status_warga',
        'ktp'
    ];
}
