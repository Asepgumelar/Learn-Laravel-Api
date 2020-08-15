<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'name',
        'avatar',
        'prodi_id'
    ];

    public function prodi()
    {
        return $this->belongsTo('\App\Models\Prodi');
    }
}
