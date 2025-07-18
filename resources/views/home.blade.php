@extends('layouts.app')

@section('content')
<div class="container">
  <a href="{{route("streaming.index")}} ">Acceder au streaming </a>
  <a href="{{route("ebillet.home")}} ">Réserver un E-billet </a>
</div>
@endsection
