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
	              			Chart Of Accounts
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		{{ $subchart->subAccountName }}
              		</li>
              		@if(count($subchart))
              			<div class="pull-right">
			                <span style="color: grey"> Latest Update &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ $subchart->updated_at->formatlocalized('%a %d %b %y') }} 
			                </span>
			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color: grey"> Cash &nbsp; </span> 
			                <span style="color:#54e69d; font:normal 18px book antiqua"> 
			                    {{ number_format($subchart->detail) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color:grey"> Balance &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($subchart->money, 2) }} 
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

          	@if(count($subchart))
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
					                  	<h3 class="h4">{{ $subchart->subAccountName }} Account</h3>
					                </div>
		                			<div class="card-body">
		                  				<table class="table table-bordered table-hover">
		                  					@if(count($savings))
		                  					<thead>
		                  						<tr>
		                  							<th>Transaction Date</th>
		                  							<th>Details</th>
		                  							<th>Debit</th>
		                  							<th>Credit</th>
		                  							<th>Bank</th>
		                  						</tr>
		                  					</thead>
		                  					@foreach($savings as $saving)
		                  						<tbody>
		                  							<tr>
		                  								<td>{{ $saving->created_at->formatlocalized('%a %d %b %y') }}</td>
		                  								<td>{{ $saving->details }}</td>
		                  								@if($saving->action == 'credit')
		                  									<td>{{ number_format($saving->credit) }}</td>
		                  								@else
		                  									<td></td>
		                  								@endif

		                  								@if($saving->action == 'debit')
		                  									<td>{{ number_format($saving->debit) }}</td>
		                  								@else
		                  									<td></td>
		                  								@endif
		                  								<td>{{ $saving->bank }}</td>
		                  							</tr>
		                  						</tbody>
		                  					@endforeach
			                  				@else
			                  					<tbody class="table-warning">
			                  						<tr colspan="4" style="text-align:center">
			                  							<td> This Account has No Cashbook Transactions.</td>
			                  						</tr>
			                  					</tbody>
			                  				@endif
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