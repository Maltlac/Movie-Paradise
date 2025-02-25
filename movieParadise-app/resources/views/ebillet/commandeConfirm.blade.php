@extends('layouts.app')
@section('content')
<link href="/css/commande.css" rel="stylesheet">

<section class="h-100 h-custom" >
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-lg-8 col-xl-6">
          <div class="card border-top border-bottom border-3" style="border-color: #f37a27 !important;">
            <div class="card-body p-5">
  
              <p class="lead fw-bold mb-5" style="color: #f37a27;">Reccap commande, {{$formdata['name']}}</p>
                
              <div class="row">
                <div class="col mb-3">
                  <p class="small text-muted mb-1">Séance</p>
                  <p>{{$formdata['seance']}}</p>
                </div>
                <div class="col mb-3">
                    <p class="small text-muted mb-1">Film</p>
                    <p>{{$formdata['titreFilm']}}</p>
                  </div>
                <div class="col mb-3">
                  <p class="small text-muted mb-1">Order No.</p>
                  <p>{{$formdata['id']}}</p>
                </div>
              </div>
  
              <div class="mx-n5 px-5 py-4" style="background-color: #f2f2f2;">
                <div class="row">
                  <div class="col-md-8 col-lg-9">
                    <p>billets etudiant x {{$formdata['ticket3']}}</p>
                  </div>
                  <div class="col-md-4 col-lg-3">
                    <p>{{intval($formdata['ticket3'])*7.80 }} €</p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-8 col-lg-9">
                    <p class="mb-0">billets plein tarif x {{$formdata['ticket1']}} </p>
                  </div>
                  <div class="col-md-4 col-lg-3">
                    <p class="mb-0">{{intval($formdata['ticket1'])*11.20 }} €</p>
                  </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-8 col-lg-9">
                      <p class="mb-0">billets moins de 18 ans x {{$formdata['ticket2']}} </p>
                    </div>
                    <div class="col-md-4 col-lg-3">
                      <p class="mb-0">{{intval($formdata['ticket2'])*5.80 }} €</p>
                    </div>
                </div>
              </div>
  
              <div class="row my-4">
                <div class="col-md-4 offset-md-8 col-lg-3 offset-lg-9">
                  <p class="lead fw-bold mb-0" style="color: #f37a27;">{{$formdata['total']}} </p>
                </div>
              </div>
  
              
  
              <p class="mt-4 pt-2 mb-0">Besoin d'aide ? <a href="/contact" style="color: #f37a27;">Contacter nous</a></p>
  
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection