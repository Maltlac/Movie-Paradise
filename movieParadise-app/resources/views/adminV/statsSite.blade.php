@extends('layouts.app')
@section('content')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@vite(['resources\css\statAdmin.css'])
<div class="container">
    
    <div class="row">

	<div class=" col-md-2">
		<div class="counter-box">
			<i class="fa  fa-user"></i>
			<span class="counter">{{$countDb['users']}} </span>
			<p>Users</p>
		</div>
	</div>
	<div class=" col-md-2">
		<div class="counter-box">
			<i class="fa fa-film" aria-hidden="true"></i>
			<span class="counter">{{$countDb['film']}}</span>
			<p>Films</p>
		</div>
	</div>
	<div class=" col-md-2">
		<div class="counter-box">
			<i class="fa fa-television" aria-hidden="true"></i>
			<span class="counter">{{$countDb['series']}}</span>
			<p>Series</p>
		</div>
	</div>
	<div class=" col-md-2">
		<div class="counter-box">
			<i class="fa fa-caret-square-o-right" aria-hidden="true"></i>
			<span class="counter">{{$countDb['episode']}}</span>
			<p>Episodes</p>
		</div>
	</div>
    <div class=" col-md-2">
		<div class="counter-box">
			<i class="fa fa-users" aria-hidden="true"></i>
			<span class="counter">{{$countDb['artiste']}}</span>
			<p>Artistes</p>
		</div>
	</div>
    <div class="col-md-2">
		<div class="counter-box">
			<i class="fa fa-filter" ></i>
			<span class="counter">{{$countDb['categ']}}</span>
			<p>Categories</p>
		</div>
	</div>
  </div>	
  <br>
  <br>
    <div class="chart-container"  style="width:50%; display:flex">
        
        
        <canvas id="myChartF"  height="100px" style="display: inline;"></canvas>
        &nbsp;
        <canvas id="myChartU"  height="100px" style="display: inline;"></canvas>
    </div>

    <br>
    <div class="chart-container"  style="width:50%; display:flex">
        <canvas id="myChartS"  height="100px" style="display: inline;"></canvas>
        &nbsp;
        <canvas id="myChartA"  height="100px" style="display: inline;"></canvas>
    </div>
 
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.counter').each(function () {
        $(this).prop('Counter',0).animate({
        Counter: $(this).text()
        }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
        });
        });
        $('body').on('click', '#edit-filmGraph', function () {
            configF.type="bar"
            console.log(configF.type)
            
          
       });
    }); 


        

//// graph film
    var labels =  {{ Js::from($labelsF) }};
    var users =  {{ Js::from($dataF) }};
  const dataF = {
        labels: labels,
        datasets: [{
        label: 'Films',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: users,
        }]
  };

  const configF = {
    type: 'line',
    data: dataF,
    options: {}
  };

  const myChartF = new Chart(
    document.getElementById('myChartF'),
    
    configF
  );

  /////graph user
  var labels =  {{ Js::from($labelsU) }};
  var users =  {{ Js::from($dataU) }};
  const dataU = {
    labels: labels,
    datasets: [{
      label: 'Users',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: users,
    }]
  };

  const configU = {
    type: 'line',
    data: dataU,
    options: {}
  };

  const myChartU = new Chart(
    document.getElementById('myChartU'),
    configU
  );
  
  /////////graph Serie
  var labels =  {{ Js::from($labelsS) }};
  var users =  {{ Js::from($dataS) }};
  const dataS = {
    labels: labels,
    datasets: [{
      label: 'Series',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: users,
    }]
  };

  const configS = {
    type: 'line',
    data: dataS,
    options: {}
  };

  const myChartS = new Chart(
    document.getElementById('myChartS'),
    configS
  );

  ////////grap artiste
  var labels =  {{ Js::from($labelsA) }};
  var users =  {{ Js::from($dataA) }};
  const dataA = {
    labels: labels,
    datasets: [{
      label: 'Artiste',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: users,
    }]
  };

  const configA = {
    type: 'line',
    data: dataA,
    options: {},
  };

  const myChartA = new Chart(
    document.getElementById('myChartA'),
    configA
  );


</script>
@endsection



