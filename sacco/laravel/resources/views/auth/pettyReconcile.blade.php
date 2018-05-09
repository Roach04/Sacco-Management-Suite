@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
        @include('layout.pettyReconcileBar')
        <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Petty Cash</h2>
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
              		@if(count($savings) || count($pettycashopeningbalance) || count($pettycashAccount))
              			<div class="pull-right">
              				<span style="color:grey"> Latest Update &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ $last }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Opening &nbsp; </span> 
			                <span style="color:#ff7676; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycashopeningbalance, 2) }} 
			                </span>		                

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Ending &nbsp; </span> 
			                <span style="color:#54e69d; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycashAccount, 2) }} 
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

          	<!-- Forms Section-->
	      	<section class="forms"> 
	        	<div class="container-fluid">
	          		<div class="row">
	            		<!-- Form Elements -->
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
				                  	<h3 class="h4">Sacco Transactions</h3>
				                </div>
	                			<div class="card-body">
	                				@if(count($savings))
							            <div class="row">
		                					<label class="col-sm-3 form-control-label">Petty Cash Reconciliation</label>
								          	<div style="margin-top:40px" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
								                <table id="table-data" style="text-align:center; width:100%" class="table table-bordered table-hover">
								                	<thead>
								                		<tr>
								                			<th>#</th>
								                			<th style="text-align:center"> Transaction Date </th>
								                			<th style="text-align:center"> Details </th>
								                			<th style="text-align:center"> Debit </th> 
								                			<th style="text-align:center"> Credit </th>
								                			<th style="text-align:center"> Account </th>
								                		</tr>
								                	</thead>
								                	@foreach($savings as $save)
									                	<tbody>
									                		<tr>
									                			<td>{{ $save->id }}</td>
									                			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
									                			<td>{{ $save->details }}</td>
									                			@if($save->action == 'credit')
									                				<td>{{ number_format($save->credit) }}</td>
									                			@elseif($save->action != 'credit')
									                				<td></td>
									                			@endif

									                			@if($save->action == 'debit')
									                				<td>{{ number_format($save->debit) }}</td>
									                			@elseif($save->action != 'debit')
									                				<td></td>
									                			@endif
									                			<td>{{ $save->accounts }}</td>
									                		</tr>
									                	</tbody>
								                	@endforeach
								                </table>
								            </div>
							            </div>
							            {!! $savings->render() !!}
						            @else
						            	<p style="color:red; text-align:center; font-size:24px; padding:50px"> Sacco's Petty Cash Account is Empty. </p>
						            @endif
	                			</div>
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