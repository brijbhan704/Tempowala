@extends('layout.app')

@section('content')
<div class="right_col" role="main">
  <!-- top tiles -->
  <div class="row tile_count">
    <div class="col-md-3 col-sm-3 col-xs-9 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
      <div class="count">{{$user}}</div>
      <!-- <span class="count_bottom"><i class="green">4% </i> From last Week</span> -->
    </div>    
    <div class="col-md-3 col-sm-3 col-xs-9 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Bookings</span>
      <div class="count green">0</div>
      <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Year</span> -->
    </div>
    <div class="col-md-3 col-sm-3 col-xs-9 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Vistors</span>
      <div class="count">0</div>
      <!-- <span class="count_bottom"></span> -->
    </div>
    <div class="col-md-3 col-sm-3 col-xs-9 tile_stats_count">
      <span class="count_top"><i class="fa fa-user"></i> Total Vehicles</span>
      <div class="count green">0</div>
      <!-- <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Year</span> -->
    </div>

  </div>
  
  <!-- /top tiles -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
          <div class="x_panel">
            <div class="x_title">
              <h2>Total Booking by Month</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="dashboard-widget-content">
                
                <canvas id="mybooking"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
          <div class="x_panel">
            <div class="x_title">
              <h2>Total Sales by Month</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="dashboard-widget-content">
                
                <canvas id="mysales"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    
    $(document).ready(function(){
        if ($('#mysales').length ){ 
			  
			  var ctx = document.getElementById("mysales");
			  var mybarChart = new Chart(ctx, {
				type: 'bar',
				data: {
				  labels: {!! json_encode($monthArr) !!},
				  datasets: [{
					label: '# of Sales',
					backgroundColor: "#26B99A",
					data: {!! json_encode($priceArr) !!}
				  }]
				},

				options: {
				  scales: {
					yAxes: [{
					  ticks: {
						beginAtZero: true
					  }
					}]
				  }
				}
			  });
			  
			}
			
			
			
			
			if ($('#mybooking').length ){ 
			  
			  var ctx = document.getElementById("mybooking");
			  var mybarChart = new Chart(ctx, {
				type: 'bar',
				data: {
				  labels: {!! json_encode($monthBookArr) !!},
				  datasets: [{
					label: '# of Booking',
					backgroundColor: "#26B99A",
					data: {!! json_encode($priceBookArr) !!}
				  }]
				},

				options: {
				  scales: {
					yAxes: [{
					  ticks: {
						beginAtZero: true
					  }
					}]
				  }
				}
			  });
			  
			}
			  
    })
    
    
</script>

@endsection
