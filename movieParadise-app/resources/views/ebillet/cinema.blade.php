@extends('layouts.app')

@section('content')

<div class="container bg-light rounded shadow-sm border border-dark">
    <table class="table table-striped">
        @foreach($data as $post)
        <tr scope="row" style="height:175px" class="media position-relative">
            <td><img src="{{ $post['image'] }} " alt="" style="width:150px;" > </td>
            <td><a href="{{route("seance.cinema",$post['lien'])}}"  class="text-reset stretched-link" >{{ $post['nom'] }}</a> <br> {{ $post['adresse'] }} </td>
            <td> Nomnbre de salle : <br>{{ $post['salle'] }}</td>
        </tr>
        @endforeach
    </table>
    {{ $data->links() }}
</div>
   


@endsection