@extends('layouts.app')
@section('content')

  
  <div class="container bg-light rounded shadow-sm border border-dark">
      <div class="row">
        <div class="col-sm text-center">
          <h1>Selectionner un département : </h1>

        </div>
        
      </div>
        @php
          $i=0;
        @endphp

        @foreach ($links as $lien)
          @if ($i==0)
            <div class="row">
          @endif

            <div class="col-sm">
              <a href="{{$lien["lien"]}}" class="text-reset" >{{$lien["dep"]}} </a>
            </div>

          @if ($i==3)
            </div>
            @php
            $i=0;
            @endphp
          @else
              @php
                  $i++;
              @endphp
          @endif
        @endforeach
  </div>
@endsection
