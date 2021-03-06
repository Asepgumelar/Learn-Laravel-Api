<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    protected $fillable = [
        'name', 'prodi_id'
    ];
    
    public function prodi()
    {
        return $this->belongsTo('\App\Models\Prodi');
    }
}
