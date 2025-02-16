@extends('layouts.app')

@section('content')

<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Title</th>
        </tr>
        @foreach ($data as $data2)
            @foreach($data2 as $post)
            <tr>
                <td><img src="{{ $post['image'] }} " alt="" style="width:100px;"> </td>
                <td>{{ $post['titreFilm'] }} </td>
                <td>{{ $post['infoDivers'] }}</td>
                <td>{{ $post['infoActeur'] }}</td>
                <td>{{ $post['infoReal'] }}</td>
                <td>{{ $post['synopsis'] }}</td>
                <td>{{ $post['date'] }}</td>
                <td>
                    @foreach ($post['seance'] as $item)
                        {{$item["heure"]}}
                    @endforeach
                </td>
            </tr>
            @endforeach
        @endforeach
        
    </table>
</div>
   
{{ $data->links() }}

@endsection