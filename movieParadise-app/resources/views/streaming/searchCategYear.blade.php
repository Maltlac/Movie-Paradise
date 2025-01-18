@extends('layouts.app')
@section('content')


<div  style="display:grid;color:white;  grid-template-columns: auto 80%;">
    <div style="grid-column: 1/2;grid-row: 1">
        <div style="border-color:black;border-size 2px;">
            <h4>Catégories</h4>
            @foreach($listeCateg as $categ)
                <a href="/p/film/categ/{{$categ->id}}/year/tous">{{$categ->nom}} </a> <br>
            @endforeach 
        </div>
    </div>
    
    <div style="grid-column: 2/2;grid-row: 1; margin-right:50px">
        <h2 style="color:whiteSmoke">Votre recherche:</h2>
                  
                @foreach ($search as $filmSerie)
                    <div class="item">
                        @if($p=="film") 
                        <a id="imgCardStreaming" href="/film/{{ $filmSerie->id }}" class="card col-sm-4 ">
                        @endif
                        @if($p=="series") 
                        <a id="imgCardStreaming" href="/serie/{{ $filmSerie->id }}" class="card col-sm-4 ">
                        @endif  
                            <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $filmSerie->image }}" alt="Card image cap">
                        </a>
                    </div>
                @endforeach
                       
    </div>

</div>

@endsection 