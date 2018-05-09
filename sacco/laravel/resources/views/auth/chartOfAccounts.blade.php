@extends('layout.master')

@section('content')
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
	    @include('layout.chartOfAccountsBar')
	    <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">System Users</h2>
	            </div>
          	</header>
          	<!-- Page Header-->

          	<!-- Breadcrumb-->
          	<ul class="breadcrumb">
            	<div class="container-fluid">
              		<li class="breadcrumb-item">
	              		<a href=" {{ route('dashboard') }} ">
	              			Home
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		<a href=" {{ route('sysAccounts') }} ">
	              			System Accounts
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		Chart Of Accounts
              		</li>
              		@if(count($savings))
              			<div class="pull-right">
			                <span style="color: grey"> Co-op Opening &nbsp; </span> 
			                <span style="color:#54e69d; font:normal 18px book antiqua"> 
			                    {{ number_format($coopopeningbalance) }} 
			                </span>
			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color: grey"> Equity Opening &nbsp; </span> 
			                <span style="color:#ff7676; font:normal 18px book antiqua"> 
			                    {{ number_format($equityopeningbalance) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color: grey"> Petty Cash Opening &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycashopeningbalance) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color:grey"> Balance &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($cash, 2) }} 
			                </span>
			            </div>
              		@else
              			<div class="pull-right">
			                <span style="color: grey"> Today &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{$today}}
			                    <span style="color:black"> | </span>
			                    {{ $currenttime }}
			                </span>
			                
			            </div>
              		@endif
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>

          	@if(count($charts))
		        <section class="tables">   
		        	<div class="container-fluid">
		          		<div class="row">
		            		<div class="col-lg-12">
		              			<div class="card">
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
					                  	<h3 class="h4">Chart Of Accounts</h3>
					                </div>
		                			<div class="card-body">
		                  				<table style="width:100%" class="table table-hover table-bordered">
							          		<thead>
							          			<tr>	
							          				<th> # </th>
							          				<th> Account Name </th>
							          				<th> Category </th>
							          				<th> Description </th>
							          				<th> Statement </th>
							          				<th> Balance Total </th>
							          			</tr>
							          		</thead>
							          		@foreach($charts as $chart)
								          		<tbody class="chartbody">
								          			<tr>
								          				<th scope="row">
								          					{{ $chart->id }}
								          					<br><br> &nbsp;&nbsp;&nbsp;&nbsp;
									          				
					          								@foreach($chart->subcharts as $sub) 
					          									{{ $sub->id }} <br><br> &nbsp;&nbsp;&nbsp;&nbsp;
					          								@endforeach
								          				</th>
								          				<td> 
								          					<a id="chartAccounts" data-id="{{ $chart->id }}" data-toggle="modal" href="#chartAccountsModal">
								          						{{ $chart->accountName }} 
								          					</a>
								          					<br><br> &nbsp;&nbsp;&nbsp;&nbsp;
									          				
					          								@foreach($chart->subcharts as $sub) 
					          									{{ $sub->subAccountName }} <br><br> &nbsp;&nbsp;&nbsp;&nbsp;
					          								@endforeach	
								          				</td>
								          				<td> 
								          					{{ $chart->category }} 
								          					<br><br> &nbsp;&nbsp;&nbsp;&nbsp;
									          				
					          								@foreach($chart->subcharts as $sub) 
					          									{{ $sub->category }} <br><br> &nbsp;&nbsp;&nbsp;&nbsp;
					          								@endforeach	
								          				</td>
								          				<td> 
								          					{{ $chart->description }} 
								          					<br><br> &nbsp;&nbsp;&nbsp;&nbsp;
									          				
					          								@foreach($chart->subcharts as $sub) 
					          									{{ $sub->description }} <br><br> &nbsp;&nbsp;&nbsp;&nbsp;
					          								@endforeach	
								          				</td>
								          				<td> 
								          					<a href="{{ route('chartStatement', [$chart->id]) }}">
								          						{{ $chart->accountName }} 
								          					</a>
								          					<br><br> &nbsp;&nbsp;&nbsp;&nbsp;
									          				
					          								@foreach($chart->subcharts as $sub) 
					          									<a href="{{ route('subchartStatement', [$sub->id]) }}">
					          										{{ $sub->subAccountName }} 
					          									</a> <br><br> &nbsp;&nbsp;&nbsp;&nbsp;
					          								@endforeach	
								          				</td>
								          				<td> 
							          						{{ number_format($chart->money, 2) }}
							          						<br><br> &nbsp;&nbsp;&nbsp;&nbsp;
					          								@foreach($chart->subcharts as $sub) 
					          									{{ number_format($sub->money, 2) }} <br><br> &nbsp;&nbsp;&nbsp;&nbsp;
					          								@endforeach	
								          				</td>
								          			</tr>
								          		</tbody>
							          		@endforeach
							          	</table>
		                			</div>
		              			</div>
		            		</div>
		          		</div>
		        	</div>
		      	</section>
	      	@else 
	      		<div class="container">
                    <p style="color:#796AEE; font-size:26px; text-align:center"> There are No Charts of Accounts. </p>
                </div>
	      	@endif          	

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

@include('Modals.chartAccountsModal')

@stop