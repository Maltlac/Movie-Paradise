@extends('layouts.app')
@section('content')


    <div class="container">

        <form action="/searchStreaming" method="get" class="form-inline">
            <div class="row g-3">
                <div class="col-sm-7">
                    <input id="search" name="search" type="search" class="form-control " placeholder="Search" style="color:whitesmoke;" autocomplete="off"/>
                  </div>
                  <div class="col-sm">
                    <button class="btn bg-light  " type="submit"><i class="fa fa-search"></i> </button>
                </div>   
            </div>                             
        </form>

            
        

        @if (count($data[0])!=0)
            <h2 style="color:whiteSmoke">Films ({{count($data[0])}}) </h2>
            <div class="owl-carousel owl-theme">
           
                @foreach ($data[0] as $lesFilms2)
                    <div class="item">
                        <a id="imgCardStreaming" href="/film/{{ $lesFilms2->id }}" class="card col-sm-4 ">
                            <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $lesFilms2->image }}" alt="Card image cap">
                        </a>
                    </div>
                @endforeach  
          
                         
            </div> 
        @endif  
        @if (count($data[1])!=0)

            <h2 style="color:whiteSmoke">Series ({{count($data[1])}}) </h2>
            <div class="owl-carousel owl-theme">
            
                
                @foreach ($data[1] as $lesSeries)
                
                    <div class="item">
                        <a id="imgCardStreaming" href="/serie/{{ $lesSeries->id }}" class="card col-sm-4 ">
                            <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $lesSeries->image }}" alt="Card image cap">
                        </a>
                    </div>
                @endforeach               
            </div>   
        @endif  
        @if (count($data[2])!=0)

            <h2 style="color:whiteSmoke">Artistes ({{count($data[2])}}) </h2>
            <div class="owl-carousel owl-theme">
            
                
                @foreach ($data[2] as $Artiste)
                
                    <div class="item">
                        
                        <a id="imgCardStreaming" href="/bio/{{ $Artiste->id }}" class="card col-sm-4 ">
                            <img class="card-img-center " src="https://image.tmdb.org/t/p/w200{{ $Artiste->image }}" alt="Card image cap">
                            {{$Artiste->name}}

                        </a>
                    </div>
                @endforeach               
            </div>   
        @endif   
          
        
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <!-- Owl Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- custom JS code after importing jquery and owl -->
    <script type="text/javascript" >
        
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel();
        });

        $('.owl-carousel').owlCarousel({
            pagination: false,
            margin: 10,
            nav: false,
            axis:"x",
            lazyLoad : true,
            theme:"dark",
            responsive: {
                0: {
                    items: 1
                },
                250: {
                    items: 2
                },
                500: {
                    items: 3
                },
                750: {
                    items: 4
                },
                1000: {
                    items: 5
                }
            }
        })
        var global = new Array();
        var route = "{{ url('autocomplete') }}";
        
        $('#search').typeahead({
            source:  function (term, process) {
            return $.get(route, { term: term }, function (data) {
             return process(data);
                });
            }  
        });

    </script>

@endsection 