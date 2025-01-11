@extends('layouts.app')
@section('content')


    <div class="container">

        <div id="custom-search-input">
                <div class="input-group">
                    <form action="/searchStreaming" method="get" style="width:100%">
                        <input id="search" name="search" type="text" class="form-control " placeholder="Search" style="color:whitesmoke;width:97%"  autocomplete="off"/>
                        <button class="btn btn-outline-secondary bg-white border-start-0 border ms-n3" type="submit" style="width:3%">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                            </svg>
                        </button>
                    </form>

                </div>

            </div>

            
        

        @if (count($data[0])!=0)
            <h2 style="color:whiteSmoke">Films</h2>
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

            <h2 style="color:whiteSmoke">Series</h2>
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

            <h2 style="color:whiteSmoke">Artistes</h2>
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