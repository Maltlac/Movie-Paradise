<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\Personnes;
use App\Models\series;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;


class StreamingController extends Controller
{
    public function index()
    {
        $film=film::inRandomOrder()->limit(20)->get();
        $serie=series::inRandomOrder()->limit(20)->get();
        return view('/streaming/voirTout',[
            'film'=>$film,
            'serie'=>$serie,
        ]);
    }

    
    public function search(Request $request)
    {
          $search = $request->get('titre');
      
          $result = film::where('titre', 'LIKE', '%'. $search. '%')->get();

          $result2 = series::where('titre', 'LIKE', '%'. $search. '%')->get();

          $result3 = Personnes::where('name', 'LIKE', '%'. $search. '%')->get();
          $data = array();
          foreach ($result as $hsl)
              {
                  $data[] = $hsl->titre;
              }
            foreach ($result2 as $hsl)
              {
                  $data[] = $hsl->titre;
              }
              foreach ($result3 as $hsl)
              {
                  $data[] = $hsl->name;
              }
          return response()->json($data);
            
    } 

}
