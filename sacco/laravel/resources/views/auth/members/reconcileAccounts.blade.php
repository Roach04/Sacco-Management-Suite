@extends('layout.master')

@section('content')

<div class="charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
        @include('layout.reconcileAccountsBar')
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
	              			Member Accounts
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		Member Account Reconciliation
              		</li>
              		@if(count($accounts))
              			<div class="pull-right">
			                <span style="color: grey"> Latest Update &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ $last }} 
			                </span>
			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color:grey"> Cash &nbsp; </span> 
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
				                  	<h3 class="h4">Member Deposits</h3>
				                </div>
	                			<div class="card-body">
						            <div class="row">
	                					<label class="col-sm-3 form-control-label">Money In The System</label>
		                				@if(count($accounts))
								          	<div style="margin-top:40px" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
								                <table id="table-data" style="text-align:center; width:100%" class="table table-hover">
								                	<thead>
								                		<tr>
								                			<th style="text-align:center"> Id </th>
								                			<th style="text-align:center"> Account </th>
								                			<th style="text-align:center"> Updated At </th>
								                		</tr>
								                	</thead>
								                	@foreach($accounts as $account)
									                	<tbody>
									                		<tr>
									                			<td>{{ $account->id }}</td>
									                			<td style="color:#796AEE;">{{ number_format($account->money) }}</td>
									                			<td>{{ $account->updated_at->formatlocalized('%a %d %b %y') }}</td>
									                		</tr>
									                	</tbody>
								                	@endforeach
								                </table>
								                <div class="pull-right" style="margin-top:20px">
									            	<a href="#" class="btn btn-primary"> 
									            		Print Transactions Above
									            	</a>
									            </div>
								            </div>
							            	{!! $accounts->render() !!}
							            @else
							            	<p style="color:red; font-size:24px; padding-left:30px"> Member's Account is Empty. </p>
							            @endif
						            </div>
	                			</div>
	                		</div>
	                	</div>
	                </div>
	            </div>
	        </section>




          	
        </div>
    </div>
</div>

@include('Modals.savingsUpdateModal')

@stop