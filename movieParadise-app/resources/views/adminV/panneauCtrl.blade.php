@extends('layouts.app')

@section('content')
<div class="container">
    
 
  
</div>
<div class="container text-center" style=" color: whitesmoke;">
    <h1 class="me-auto">Bienvenue sur le panneau de controle</h1>

    <div class="row">

      <div class="col">
         films :
      </div>

      <div class="col">
        <a href="/ajoutFilm">Ajout films </a>
      </div>

      <div class="col">
        <a href="/gererFilm">Gérer les films </a>
      </div>

    </div>

    <div class="row">

        <div class="col">
          Séries :
        </div>

        <div class="col">
            <a href="/ajoutSerie">Ajout Séries </a>
          </div>

          <div class="col">
            <a href="">Gérer les Séries </a>
          </div>

      </div>

      <div class="row">
        <div class="col">
          profils admin
        </div>

        <div class="col">
            <a href="">Ajout admin </a>
          </div>

          <div class="col">
            <a href="">Gérer les admins </a>
          </div>
      </div>

      <div class="row">
        <div class="col">
          <a href="">Statistique</a>
        </div>
      </div>
    
  </div>
@endsection