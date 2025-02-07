@extends('layouts.app')
@section('content')
@vite('resources/js/adminScript.js')
<link rel="stylesheet" href="{{ asset('public/build/assets/styleAdmin-71647c9a.css') }}">
<div class="container">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="panel">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <form class="form-horizontal" method="GET" action="/gererFilm">
                                        
                                    
                                <div class="form-group">
                                    <div class="pull-left">
                                        <input type="search" name="search" value="{{ request()->input('search') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Search">
                                    <button type="submit" class="btn btn-primary">Search</button>  
                                    </div>
                                    
                                    
                                    <div class="form-horizontal pull-right">
                                        <label>Show : </label>
                                        <select id="pagination" name="pagination">
                                            <option value="5" @if($items == 5) selected @endif >5</option>
                                            <option value="10" @if($items == 10) selected @endif >10</option>
                                            <option value="15" @if($items == 15) selected @endif >15</option>
                                            <option value="20" @if($items == 20) selected @endif >20</option>
                                            <option value="25" @if($items == 25) selected @endif >25</option>
                                        </select>
                                    </div>  
                                    
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>action</th>
                                <th>@sortablelink('id','#')</th>
                                <th>@sortablelink('titre')</th>
                                <th>@sortablelink('dateSortie','Date de sortie')</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($films as $data)
                            <tr>
                                <td>
                                    <ul class="action-list">
                                        <li><a href="#" class="btn btn-primary"><i class="fa fa-pencil-alt"></i></a></li>
                                        <li><a href="#" class="btn btn-danger"><i class="fa fa-times"></i></a></li>
                                    </ul>
                                </td>
                                <td>{{ $data->id }}</td>
                                <td>{{ $data->titre }}</td>
                                <td>{{ $data->dateSortie }}</td>
                                <td><a href="#" class="btn btn-sm btn-success"><i class="fa fa-search"></i></a></td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                            
                            @if ($films->hasPages())
                            <ul class="pagination hidden-xs pull-right">
                                {!! $films->appends(Request::except('page'))->render() !!}

                            </ul>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('pagination').onchange = function() { 
        window.location = "{!! $films->url(1) !!}&items=" + this.value; 
    }; 
</script>
@endsection


