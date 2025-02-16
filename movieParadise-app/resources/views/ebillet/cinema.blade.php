@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Title</th>
        </tr>
        @foreach($data as $post)
        <tr>
            <td><img src="{{ $post['image'] }} " alt="" style="width:100px;"> </td>
            <td><a href="{{route("seance.cinema",$post['lien'])}}">{{ $post['nom'] }}</a> </td>
            <td>{{ $post['adresse'] }}</td>
            <td>{{ $post['salle'] }}</td>
        </tr>
        @endforeach
    </table>
</div>
   
{{ $data->links() }}

@endsection