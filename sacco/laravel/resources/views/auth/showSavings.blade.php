@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
        <div style="width:100%">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	            	<h2 class="no-margin-bottom">System Users
	            		@if(count($savings) || count($equityopeningbalance) || count($pettycashopeningbalance) || count($coopopeningbalance))
		            		<div class="pull-right">
			            		<span style="color:grey"> Opening Equity Bank &nbsp; </span> 
				                <span style="color:#ff7676;"> 
				                    {{ number_format($equityopeningbalance, 2) }} 
				                </span>

				                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

				                <span style="color:grey"> Opening Co-op Bank &nbsp; </span> 
				                <span style="color:#54e69d;"> 
				                    {{ number_format($coopopeningbalance, 2) }} 
				                </span>

				                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

				                <span style="color:grey"> Opening Petty Cash &nbsp; </span> 
				                <span style="color:#DAA520;"> 
				                    {{ number_format($pettycashopeningbalance, 2) }} 
				                </span>
			                </div>
			            @endif
	            	</h2>
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
	              		Sacco Account Updates
              		</li>
              		@if(count($savings))
              			<div class="pull-right">
			                <span style="color:grey"> Equity Bank Running &nbsp; </span> 
			                <span style="color:#ff7676; font:normal 18px book antiqua"> 
			                    {{ number_format($equityBank, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Co-op Bank Running &nbsp; </span> 
			                <span style="color:#54e69d; font:normal 18px book antiqua"> 
			                    {{ number_format($coopBank, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Petty Cash Running &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycash, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Balance &nbsp; </span> 
			                <span style="color:#796AEE;"> 
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
				                  	<h3 class="h4">Sacco Savings</h3>
				                </div>
				                @if(count($savings))
		                			<div class="card-body">
						                <table style="text-align:center" class="check table table-hover table-bordered">
						                	<thead>
						                		<tr>
						                			<th> # </th>
						                			<th> Transaction Date </th>
						                			<th> Details </th>
						                			<th> Debit </th>
						                			<th> Credit </th>
						                			<th> Account </th>
						                			<th> Bank </th>
						                			<th> Changes </th>
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
							                			@else
							                				<td></td>
							                			@endif

							                			@if($save->action == 'credit')
							                				<td>{{ number_format($save->credit) }}</td>
							                			@else
							                				<td></td>
							                			@endif
							                			<td>{{ $save->accounts }}</td>
							                			<td>{{ $save->bank }}</td>							                			
							                			<td>
							                				<a data-id="{{ $save->id }}" data-account="{{ $save->accounts }}" data-details="{{ $save->details }}" data-bank="{{ $save->bank }}"  data-credit="{{ $save->credit }}" data-debit="{{ $save->debit }}" href="#savingsupdatemodal" data-toggle="modal" class="modal-update-edit btn btn-warning btn-block"> 
							                					<i class="fa fa-fire"> </i>
							                					Update 
							                				</a>
							                			</td>
							                		</tr>
							                	</tbody>
						                	@endforeach
						                </table>
							        </div>
							        {!! $savings->render() !!}
					            @else
					            	<div class="container">
					            		<p style="color:red; font-size:24px; text-align:center; padding:50px"> No Sacco Transactions Recorded At This Time. </p>
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

@include('Modals.savingsUpdateModal')

@stop