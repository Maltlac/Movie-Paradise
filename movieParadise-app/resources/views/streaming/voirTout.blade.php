@extends('layouts.app')
@section('content')
    <div class="container">
        <div>

            <div id="carouselFilms" class="carousel slide row">

                    <!-- Les indicateurs (slide actif) du carousel -->
                <div class="carousel-indicators hide" >

                    @foreach ($film->chunk(5) as $film_chunk)

                    <button type="button" data-bs-target="#carouselFilms" data-bs-slide-to="{{ $loop->index }}" @if(!$loop->index) class="active" @endif aria-current="true" aria-label="Slide {{ $loop->iteration }}"></button>
                    @endforeach
                    
                </div>
                
                    <!-- Les slides du carousel -->
                <div class="carousel-inner">

                <!-- On parcourt les parties (chunks) de la table "users" -->
                @foreach ($film->chunk(5) as $lesFilms2)

                <!-- On ajoute la classe "active" sur le premier slide (chunk) -->
                <div class="carousel-item @if($loop->first) active @endif ">

                    <!-- La row -->
                    <div >

                        <!-- On affiche chaque "user" dans une colonne responsive -->
                        @foreach ($lesFilms2 as $lesFilms)
                        <a id="imgCardStreaming" href="/film/{{ $lesFilms->id }}" class="card col-sm-4 ">
                            <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $lesFilms->image }}" alt="Card image cap">
                        </a>

                        @endforeach

                    </div>

                </div>
                @endforeach

            </div>
            <!-- Les boutons suivant et pécédent -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselFilms" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"  style="background-color:black; z-index:2"></span>
                <span class="visually-hidden" >Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselFilms" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true" style="background-color:black; z-index:2"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>
    </div>

@endsection