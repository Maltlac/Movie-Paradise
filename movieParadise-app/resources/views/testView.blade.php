@extends('layouts.app')
@section('content')
<!-- Boostrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<div  style="background-color: blanchedalmond">

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true" >

        <!-- Les indicateurs (slide actif) du carousel -->
        <div class="carousel-indicators" >

            @foreach ($film->chunk(2) as $film_chunk)

            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}" @if(!$loop->index) class="active" @endif aria-current="true" aria-label="Slide {{ $loop->iteration }}"></button>
            @endforeach
        
        </div>
    
        <!-- Les slides du carousel -->
<div class="carousel-inner">

    <!-- On parcourt les parties (chunks) de la table "users" -->
    @foreach ($film->chunk(4) as $lesFilms2)

    <!-- On ajoute la classe "active" sur le premier slide (chunk) -->
    <div class="carousel-item @if($loop->first) active @endif">

        <!-- La row -->
        <div class="row" >

            <!-- On affiche chaque "user" dans une colonne responsive -->
            @foreach ($lesFilms2 as $lesFilms)
            <div class="col-md-2  " >
                <a href="/film/{{ $lesFilms->id }}">
                    <div class="p-3 mb-3 rounded bg-light " >
                        <p class="mb-0" >{{ $lesFilms->titre }}</p>
                        <span class="text-secondary" >{{ $lesFilms->duree }}</span>
                    </div>
                </a>
            </div>
            @endforeach

        </div>

    </div>
    @endforeach

</div>
<!-- Les boutons suivant et pécédent -->
<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
</button>

<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
</button>

</div>

@endsection