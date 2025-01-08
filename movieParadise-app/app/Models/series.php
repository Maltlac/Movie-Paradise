<?php

namespace App\Models;

use App\Models\saison;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class series extends Model
{
    protected $guarded =[];
    use HasFactory;
    public function SeriesPersonnes(){
        return $this->belongsToMany(Personnes::class)->limit(10);
    }

    public  function SeriesCategories(){
        return $this->belongsToMany(categories::class);
    }

    

}
