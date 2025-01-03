<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acteurs extends Model
{
    public function acteursFilms(){
        return $this->belongsToMany(film::class);
    }
}
