@extends('layouts.app')
<?php  setlocale(LC_TIME, "fr_FR", "French");?>
@section('content')
<div class="container" style=" color: whitesmoke;">
   <h1>{{ $serie->titre}}  </h1>
   <h2>{{$saison->titre }}: épisode{{$episode->numeroEpisode }}  </h2>
   <h3>{{$episode->titre}} </h3>
   <img class="card-img-center" src="https://image.tmdb.org/t/p/w300{{ $episode->image }}" alt="Card image cap">

    <div>Date de sortie: {{strftime("%d %B %G", strtotime($episode->dateSortie)) }}</div> <br>
    <div>Synopsis: {{ $episode->resume }}</div>


</div>
@endsection
