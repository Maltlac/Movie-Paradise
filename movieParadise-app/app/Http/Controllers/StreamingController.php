<?php

namespace App\Http\Controllers;

use App\Models\film;
use App\Models\series;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

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

    
    public function autocompleteF(Request $request): JsonResponse
    {
        $data = film::select("titre")
                    ->where('titre', 'LIKE', '%'. $request->get('query'). '%')
                    ->get();
         
        return response()->json($data);
    }

    
    public function autocompleteS(Request $request): JsonResponse
    {
        $data = series::select("titre")
                    ->where('titre', 'LIKE', '%'. $request->get('query'). '%')
                    ->get();
         
        return response()->json($data);
    }
}
