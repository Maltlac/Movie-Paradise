<?php

namespace App\Models;

use App\Models\saison;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kyslik\ColumnSortable\Sortable;

class series extends Model
{
    protected $guarded =[];
    public $sortable = ['id', 'titre', 'dateSortie'];
    use Sortable;

    public function SeriesPersonnes(){
        return $this->belongsToMany(Personnes::class)->limit(10);
    }

    public  function SeriesCategories(){
        return $this->belongsToMany(categories::class);
    }

    public function getCommentSerie(){
        return commantaire::where('series_id',$this->id)->get();
    }

    public function SeriesActeurs(){
        return $this->belongsToMany(Personnes::class);
    }

    public function SeriesPersonnesDel(){
        return $this->belongsToMany(Personnes::class);
    }
    public static function nbSeries(){
        return series::count();
    }
}
