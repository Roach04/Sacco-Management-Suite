@extends('layout.master')

@section('content')
	
<div class="page charts-page">
	
	<!-- Main Navbar-->
	@include('layout.navigation')
	<!-- Main Navbar-->

  	<div class="page-content d-flex align-items-stretch"> 
    	
    	<!-- Side Navbar -->
        @include('layout.chartsBar')
        <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Charts</h2>
	            </div>
          	</header>
          	<!-- Page Header-->

          	<!-- Breadcrumb-->
          	<ul class="breadcrumb">
            	<div class="container-fluid">
              		<li class="breadcrumb-item"><a href=" {{ route('dashboard') }} ">Home</a></li>
              		<li class="breadcrumb-item active">Charts</li>
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<!-- Charts Section-->
          	<section class="charts">
	            <div class="container-fluid">
	              	<div class="row">
	                	<!-- Line Charts-->
		                <div class="col-lg-8">
		                  	<div class="line-chart-example card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
			                        	<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
			                        		<a href="#" class="dropdown-item remove"> 
			                        			<i class="fa fa-times"></i>Close
			                        		</a>
			                        		<a href="#" class="dropdown-item edit"> 
			                        			<i class="fa fa-gear"></i>Edit
			                        		</a>
			                        	</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Sacco's Account</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="lineChartExample"></canvas>
			                    </div>
		                  	</div>
		                </div>
		                
	                	<div class="col-lg-4">
		                  	<div class="line-chart-example card no-margin-bottom">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
				                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
				                        	<a href="#" class="dropdown-item remove"> 
				                        		<i class="fa fa-times"></i>Close
				                        	</a>
				                        	<a href="#" class="dropdown-item edit"> 
				                        		<i class="fa fa-gear"></i>Edit
				                        	</a>
				                        </div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Credit & Debit </h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="lineChartExample1"></canvas>
			                    </div>
		                  	</div>
			                <div class="line-chart-example card">
			                    <div class="card-close">
			                      	<div class="dropdown">
			                        	<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
				                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
				                        	<a href="#" class="dropdown-item remove"> 
				                        		<i class="fa fa-times"></i>Close
				                        	</a>
				                        	<a href="#" class="dropdown-item edit"> 
				                        		<i class="fa fa-gear"></i>Edit
				                        	</a>
				                        </div>
			                      	</div>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="lineChartExample2"></canvas>
			                    </div>
			                </div>
	                	</div>
	                	<!-- Line Charts-->

	                	<!-- Bar Charts-->
	                	<div class="col-lg-4">
	                  		<div class="bar-chart-example card no-margin-bottom">
	                    		<div class="card-close">
	                      			<div class="dropdown">
	                        			<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
				                        <div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
				                        	<a href="#" class="dropdown-item remove"> 
				                        		<i class="fa fa-times"></i>Close
				                        	</a>
				                        	<a href="#" class="dropdown-item edit"> 
				                        		<i class="fa fa-gear"></i>Edit
				                        	</a>
				                        </div>
	                      			</div>
	                    		</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Members' Loans</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="doughnutChartExample"></canvas>
			                    </div>
	                  		</div>
	                	</div>
		                <div class="col-lg-8">
		                  	<div class="bar-chart-example card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
		                        		<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
		                        			<a href="#" class="dropdown-item remove"> 
		                        				<i class="fa fa-times"></i>Close
		                        			</a>
		                        			<a href="#" class="dropdown-item edit"> 
		                        				<i class="fa fa-gear"></i>Edit
		                        			</a>
		                        		</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Members' Loans</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="lineChartLoans"></canvas>
			                    </div>
		                  	</div>
		                </div>
		                <!-- Bar Charts-->

		                <!-- Doughnut Chart 
		                <div class="col-lg-6">
		                  	<div class="pie-chart-example card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
		                        		<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
		                        			<a href="#" class="dropdown-item remove"> 
		                        				<i class="fa fa-times"></i>Close
		                        			</a>
		                        			<a href="#" class="dropdown-item edit"> 
		                        				<i class="fa fa-gear"></i>Edit
		                        			</a>
		                        		</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Doughnut  Chart Example</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="doughnutChartExample"></canvas>
			                    </div>
		                  	</div>
		                </div>
		                <!-- Doughnut Chart -->

		                <!-- Pie Chart 
		                <div class="col-lg-6">
		                  	<div class="pie-chart-example card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
		                        		<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
		                        			<a href="#" class="dropdown-item remove"> 
		                        				<i class="fa fa-times"></i>Close
		                        			</a>
		                        			<a href="#" class="dropdown-item edit"> 
		                        				<i class="fa fa-gear"></i>Edit
		                        			</a>
		                        		</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Pie  Chart Example</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="pieChartExample"></canvas>
			                    </div>
		                  	</div>
		                </div>
		                <!-- Pie Chart -->

		                <!-- Polar Chart
		                <div class="col-lg-6">
		                  	<div class="polar-chart-example card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
		                        		<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
		                        			<a href="#" class="dropdown-item remove"> 
		                        				<i class="fa fa-times"></i>Close
		                        			</a>
		                        			<a href="#" class="dropdown-item edit"> 
		                        				<i class="fa fa-gear"></i>Edit
		                        			</a>
		                        		</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Polar Chart Example</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="polarChartExample"></canvas>
			                    </div>
		                  	</div>
		                </div>
		                <!-- Polar Chart-->

		                <!-- Radar Chart
		                <div class="col-lg-6">
		                  	<div class="radar-chart-example card">
		                    	<div class="card-close">
		                      		<div class="dropdown">
		                        		<button type="button" id="closeCard" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
		                        		<div aria-labelledby="closeCard" class="dropdown-menu has-shadow">
		                        			<a href="#" class="dropdown-item remove"> 
		                        				<i class="fa fa-times"></i>Close
		                        			</a>
		                        			<a href="#" class="dropdown-item edit"> 
		                        				<i class="fa fa-gear"></i>Edit
		                        			</a>
		                        		</div>
		                      		</div>
		                    	</div>
			                    <div class="card-header d-flex align-items-center">
			                      	<h3 class="h4">Radar Chart Example</h3>
			                    </div>
			                    <div class="card-body">
			                      	<canvas id="radarChartExample"></canvas>
			                    </div>
		                  	</div>
		                </div>
		                <!-- Radar Chart-->

	              	</div>
	            </div>
          	</section>
          	<!-- Charts Section-->

          	<!-- Page Footer-->
          	<footer class="main-footer">
	            <div class="container-fluid">
	              	<div class="row">
	                	<div class="col-sm-6">
	                  		<p>Paa Tech. &copy; <?php  echo date("Y")?> </p>
	                	</div>
		                <div class="col-sm-6 text-right">
		                  	<p>Powered by <a href="https://paatech.co.ke" class="external">Paa Tech.</a></p>
		                </div>
	              	</div>
	            </div>
         	</footer>
          	<!-- Page Footer-->

        </div>
  	</div>
</div>

@stop