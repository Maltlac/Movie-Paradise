<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\film;
use App\Models\series;
use App\Models\Personnes;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\Console\Input\Input;


class StreamingController extends Controller
{
    public function index()
    {
        $film=film::inRandomOrder()->limit(20)->get();
        $serie=series::inRandomOrder()->limit(20)->get();
        $categ=categories::all();
        $lastAdd=film::latest()->take(10)->get()->toArray();
        $lastAdd2=series::latest()->take(10)->get()->toArray();
        $merge = array_merge($lastAdd2,$lastAdd);
        shuffle($merge);
        return view('/streaming/voirTout',[
            'film'=>$film,
            'serie'=>$serie,
            'categ'=>$categ,
            'lastAdd'=>$merge,
        ]);
    }

    
    public function search(Request $request)
    {
          $search = $request->get('titre');
      
          $result = film::where('titre', 'LIKE', '%'. $search. '%')->get('titre');

          $result2 = series::where('titre', 'LIKE', '%'. $search. '%')->get('titre');

          $result3 = Personnes::where('name', 'LIKE', '%'. $search. '%')->get('name');
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

     public function searchStreaming(Request $request)
    {
        $request=$request['search'];
        $result = array();
        
        $result[] = film::where('titre', 'LIKE', '%'. $request. '%')->get();

        $result[] = series::where('titre', 'LIKE', '%'. $request. '%')->get();

        $result[] = Personnes::where('name', 'LIKE', '%'. $request. '%')->get();
       // dd($result);
        return view('streaming/search',[
            'data'=>$result,
        ]);

    }
}
