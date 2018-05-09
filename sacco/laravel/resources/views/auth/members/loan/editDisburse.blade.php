@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
        <div style="width:100%">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Members Loans</h2>
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
	              		<a href=" {{ route('loansMember', [$loan->member->id]) }} ">
	              			Member Loans
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		{{ $loan->member->firstname }} &nbsp; {{ $loan->member->lastname }}
              		</li>
              		@if($loan)
              		<div class="pull-right">
              			<span style="color: grey"> Equity Bank &nbsp; </span> 
		                <span style="color:#54e69d; font:normal 18px book antiqua"> 
		                    {{ number_format($equityAccount) }} 
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color: grey"> Loan Amount &nbsp; </span> 
		                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
		                    {{ number_format($loan->amount) }} 
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color: grey"> Loan Disbursed &nbsp; </span> 
		                <span style="color:#85b4f2; font:normal 18px book antiqua"> 
		                    {{ number_format($disbursements) }} 
		                </span>
		                
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Status &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                	@if($loan->state == 0)
		                		Pending
		                	@elseif($loan->state ==1)
		                		Active
		                	@elseif($loan->state == 2)
		                		Mature
		                	@endif
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Cash &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ number_format($loan->member->totals, 2) }} 
		                </span>
		            </div>
		            @endif
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>
          	
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
				                  	<h3 class="h4">Disbursements</h3>
				                </div>
	                			<div class="card-body">
	                				@if(count($disburses))
		                				<table class="table table-bordered table-hover">
		                					<thead>
		                						<tr>
		                							<th>#</th>
		                							<th>Transaction Date</th>
		                							<th>Details</th>
		                							<th>Disbursed Money</th>
		                							<th>Cheque Number</th>
		                							<th>Bank</th>
		                							<th>Loan Duration</th>
		                							<th>Grace Period</th>
		                							<th>Changes</th>
		                						</tr>
		                					</thead>
		                					@foreach($disburses as $disburse)
		                						<tbody>
		                							<tr>
		                								<td>{{ $disburse->id }}</td>
		                								<td>{{ Carbon\Carbon::createFromTimestamp(strtotime($disburse->created_at))->formatlocalized('%a %d %b %y') }}</td>
		                								<td>{{ $disburse->firstname }} {{ $disburse->lastname }}</td>
		                								<td>{{ number_format($disburse->disburseMoney) }}</td>
		                								<td>{{ $disburse->chequeNumber }}</td>
		                								<td>{{ $disburse->bank }}</td>
		                								<td>{{ $disburse->loanDuration }} Months</td>
		                								<td>{{ $disburse->gracePeriod }} Days</td>
		                								<td>
		                									<a data-loanDuration="{{ $disburse->loanDuration }}" data-bank="{{ $disburse->bank }}" data-chequeNumber="{{ $disburse->chequeNumber }}" data-disburseMoney="{{ $disburse->disburseMoney }}" data-id="{{ $disburse->id }}" href="#disbursementsupdatemodal" data-toggle="modal" id="update-disbursements" class="btn btn-primary btn-block">
		                										<i class="fa fa-fire"> </i>
		                										Update
		                									</a>
		                								</td>
		                							</tr>
		                						</tbody>
		                					@endforeach
		                				</table>
	                				@else
		                				<div class="container">
			                                <p style="color:#ffc36d; font-size:26px; text-align:center"> There are No Disbursements For This Loan at This Time. </p>
			                            </div>
		                            @endif
		                            <script>
			                            var token = '{{ Session::token() }}';
			                        </script>
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

@include('Modals.DisbursementsUpdateModal')

@stop