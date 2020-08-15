<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $fillable = [
        'name', 'kampus_id'
    ];

    public function kampus()
    {
        return $this->belongsTo('\App\Models\Kampus');
    }

    public function matkul()
    {
        return $this->hasMany('\App\Models\Matkul');
    }
}
