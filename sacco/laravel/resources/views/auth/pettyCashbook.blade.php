@extends('layout.master')

@section('content')
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
	    @include('layout.cashbookBar')
	    <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Cash Book</h2>
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
	              		Petty Cash
              		</li>
              		@if(count($savings) || count($pettycashopeningbalance) || count($pettycashAccount) || count($pettycashAggregate))
              			<div class="pull-right">
			                <span style="color: grey"> Latest Update &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ $last }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Opening &nbsp; </span> 
			                <span style="color:#ff7676; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycashopeningbalance, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Running &nbsp; </span> 
			                <span style="color:#54e69d; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycashAccount, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color:grey"> Balance &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycashAggregate, 2) }} 
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
				                  	<h3 class="h4">Petty Cash</h3>
				                </div>
				                @if(count($savings))
		                			<div class="card-body">
		                  				<table style="text-align:center" class="check table table-hover table-bordered">
						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="8"> Cash Book </th>
						                		</tr>
						                	</thead>
						                	<thead>
						                		<tr>
						                			<th> # </th>
						                			<th> Transaction Date </th>
						                			<th> Details </th>
						                			<th> Debit </th>
						                			<th> Credit </th>						                			
						                			<th> Account </th>
						                		</tr>
						                	</thead>
						                	@foreach($savings as $save)
							                	<tbody>
							                		<tr>
							                			<th scope="row">{{ $save->id }}</th>
							                			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
							                			<td>{{ $save->details }}</td>
							                			@if($save->action == 'debit')
							                				<td>{{ number_format($save->debit) }}</td>
							                			@elseif($save->action != 'debit')
							                				<td></td>
							                			@endif

							                			@if($save->action == 'credit')
							                				<td>{{ number_format($save->credit) }}</td>
							                			@elseif($save->action != 'credit')
							                				<td></td>
							                			@endif
							                			<td>{{ $save->accounts }}</td>
							                		</tr>
							                	</tbody>
						                	@endforeach
						                </table>
						                <br>
						                <a href="{{ route('pdfpettyCashbook') }}" class="pull-right col-lg-4 col-md-4 btn btn-primary"> Print The Petty Cash Cashbook. </a>
		                			</div>
	                			@else 
						      		<div class="container">
					                    <p style="color:#796AEE; font-size:26px; text-align:center; padding:50px"> There are No Transactions on Petty Cash's Cashbook.. </p>
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

@include('Modals.chartAccountsModal')

@stop