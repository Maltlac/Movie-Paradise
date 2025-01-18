<?php

namespace App\Models;

use App\Models\saison;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class series extends Model
{
    protected $guarded =[];

    public function SeriesPersonnes(){
        return $this->belongsToMany(Personnes::class)->limit(10);
    }

    public  function SeriesCategories(){
        return $this->belongsToMany(categories::class);
    }

    public function getCommentSerie(){
        return commantaire::where('series_id',$this->id)->get();
    }

}
