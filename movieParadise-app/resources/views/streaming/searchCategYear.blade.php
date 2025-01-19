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
        <h2 style="color:whiteSmoke">Votre recherche:</h2> <br>
            <form action="/searchCategVars" method="post">
                @csrf
                Filtrer par sous-catégorie:
                <select name="p" id="pSelect"  style="color: black">
                    @if ($p=="film")
                        <option value="film" selected>Films</option>
                        <option value="series">Series</option>
                    @else
                    <option value="film">Films</option>
                    <option value="series" selected>Series</option>
                    @endif
                    
                    
                </select>
                Filtrer par genre:
                  <select name="categ" id="categSelect" style="color: black">
                    @foreach($listeCateg as $categ)
                        @if($categ->id==$categSearch)
                            <option value="{{$categ->id}}" selected>{{$categ->nom}}</option> 
                        @else
                            <option value="{{$categ->id}}">{{$categ->nom}}</option>
                        @endif          
                    @endforeach
                  </select>
                  Filtrer par année:
                  <select name="year" id="yearSelect" style="color: black">
                        <option value="tous">Tous</option>
                    @foreach($years as $year)
                        @if($year==$yearSelected)
                            <option value="{{$year}}" selected>{{$year}}</option> 
                        @else
                            <option value="{{$year}}">{{$year}}</option>
                        @endif  
                    @endforeach
                  </select>
                  <button class="btn btn-outline-secondary bg-white border-start-0 border ms-n3" type="submit" style="width:20px;height:20px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16" style="margin-top: -16px;margin-left:-7px">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
                  <br><br>
            </form> 
                @if (count($search)>0)
                    @foreach ($search as $filmSerie)
                        <div class="item">
                            @if($p=="film") 
                            <a id="imgCardStreamingCateg" href="/film/{{ $filmSerie->id }}" class="card col-sm-4 ">
                            @endif
                            @if($p=="series") 
                            <a id="imgCardStreamingCateg" href="/serie/{{ $filmSerie->id }}" class="card col-sm-4 ">
                            @endif  
                                <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $filmSerie->image }}" alt="Card image cap">
                            </a>
                        </div>
                    @endforeach
                @else
                    <h3>Aucun résultas</h3>
                @endif
               
                    
    </div>

</div>

@endsection 