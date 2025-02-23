@extends('layouts.app')
@section('content')
@php
    setlocale(LC_TIME, "fr_FR", "French");
@endphp


    
    <div class="container">
        <h2 style="color:whiteSmoke">Votre recherche:</h2> <br>
            <form action="/searchCategVars" method="get">
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
                   
                        <div class="table-responsive-md w-75 ">
                            <table class="table table-light" style="    border-collapse: separate; border-spacing:0 20px;">
                                <tbody>
                                    @foreach ($search as $filmSerie)
                                        <tr class="">
                                            <td scope="row">
                                                @if($p=="film") 
                                                <a id="imgCardStreamingCateg" href="/film/{{ $filmSerie->id }}" class="card col-sm-4 stretched-link ">
                                                @endif
                                                @if($p=="series") 
                                                <a id="imgCardStreamingCateg" href="/serie/{{ $filmSerie->id }}" class="btn  card col-sm-4 stretched-link">
                                                @endif  
                                                    <img class="img-thumbnail " src="https://image.tmdb.org/t/p/w200{{ $filmSerie->image }}" >
                                                </a>
                                            </td>
                                            <td>
                                                <h4>{{$filmSerie->titre}} </h4>
                                                <p>Date de sortie :  {{strftime("%d %B %G", strtotime($filmSerie->dateSortie)) }} </p>
                                                <p>Synopsis:  {{$filmSerie->resume}} </p>
                                                
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$search->links()}}
                        </div>
                   
                    
                @else
                    <h3>Aucun résultas</h3>
                @endif

                
               
                    
    </div>


@endsection 