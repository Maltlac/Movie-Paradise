@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Selectionner une ville</h1>
  <div class="mdl-more gd small-crop">
    <ul>
        @foreach ($links as $lien)
            <li class="mdl-more-li"><a href="{{$lien["lien"]}}">{{$lien["dep"]}} </a></li>
        @endforeach
    </ul>
  </div>
</div>
@endsection
