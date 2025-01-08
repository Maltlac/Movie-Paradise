<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personnes extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function acteursFilms(){
        return $this->belongsToMany(film::class);
    }

    public function acteursSeries(){
        return $this->belongsToMany(series::class);
    }

    public function realisateurFilms(){
        return $this->belongsTo(film::class);
    }
}
