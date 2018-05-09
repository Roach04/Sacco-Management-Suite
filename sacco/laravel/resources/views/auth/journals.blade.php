@extends('layout.master')

@section('content')
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
	    @include('layout.journalsBar')
	    <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">System Journals</h2>
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
	              		Journals
              		</li>
              		@if(count($journals))
              			<div class="pull-right">

			                
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
				                  	<h3 class="h4">Journals</h3>
				                </div>
				                @if(count($journals))
	                			<div class="card-body">
	                  				<table class="table table-hover table-bordered">
	                  					<thead>
	                  						<tr>
	                  							<th>Transaction Date</th>
	                  							<th>Details</th>
	                  							<th>Account Name</th>
	                  							<th>Actual Figure</th>
	                  							<th>Overpay</th>
	                  							<th>Bank</th>
	                  							<th>Duration</th>
	                  						</tr>
	                  					</thead>
	                  					@foreach($journals as $journal)
	                  						<tbody>
	                  							<tr>
	                  								<td>{{$journal->created_at->formatlocalized('%a %d %b %y')}}</td>
	                  								<td>{{$journal->details}}</td>
	                  								<td>{{$journal->accountName}}</td>
	                  								<td>{{number_format($journal->actualFigure)}}</td>
	                  								<td>{{number_format($journal->overpay)}}</td>
	                  								<td>{{$journal->bank}}</td>
	                  								<td>{{$journal->duration}} Month(s)</td>
	                  							</tr>
	                  						</tbody>
	                  					@endforeach
	                  				</table>
					                <br>
					                <a href="{{ route('pdfBalanceSheet') }}" class="pull-right col-lg-4 col-md-4 btn btn-primary"> Print The Journals. </a>
	                			</div>
	                			@else 
						      		<div class="container">
					                    <p style="color:#796AEE; font-size:26px; text-align:center; padding:50px"> No Transaction Captured On The Journal. </p>
					                </div>
						      	@endif
	              			</div>
	            		</div>
	          		</div>
	        	</div>
	      	</section>	      	          	

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