<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kampus extends Model
{
    protected $fillable = [
        'name'
    ];


    public function prodi() 
    {
        return $this->hasMany('\App\Models\Prodi');
    }
}
