@extends('layout.master')

@section('content')
	
<div class="page charts-page">

	<!-- Main Navbar-->
	@include('layout.navigation')
	<!-- Main Navbar-->
  
  <div class="page-content d-flex align-items-stretch"> 

    <div style="width:100%">
    	<!-- Page Header-->
      	<header class="page-header">
	        <div class="container-fluid">
	          <h2 class="no-margin-bottom">Ledgers</h2>
	        </div>
      	</header>
      	<!-- Page Header-->

      	<!-- Breadcrumb-->
      	<ul class="breadcrumb">
        	<div class="container-fluid">
          		<li class="breadcrumb-item"><a href=" {{ route('dashboard') }} ">Home</a></li>
          		<li class="breadcrumb-item"><a href=" {{ route('ledgers') }} ">Ledgers</a></li>
          		<li class="breadcrumb-item active">Loan Reimbursements</li>
        	</div>
      	</ul>
      	<!-- Breadcrumb-->

      	<section class="tables">   
        	<div class="container-fluid">
          		<div class="row">
          			@if(count($reimburses))
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
				                  	<h3 class="h4">Loan Reimbursements</h3>
				                </div>
	                			<div class="card-body">
	                  				<table class="table table-hover table-bordered">
					                    <thead>
					                      	<tr>
						                        <th>#</th>
	                							<th>Transaction Date</th>
	                							<th>Details</th>
	                							<th>Disbursed Money</th>
	                							<th>Cheque Number</th>
	                							<th>Bank</th>
					                      	</tr>
					                    </thead>
					                    @foreach($reimburses as $reimburse)
					                    <tbody>
					                      	<tr>
						                        <td>{{ $reimburse->id }}</td>
                								<td>{{ Carbon\Carbon::createFromTimestamp(strtotime($reimburse->created_at))->formatlocalized('%a %d %b %y') }}</td>
                								<td>...</td>
                								<td>{{ number_format($reimburse->installment) }}</td>
                								<td>...</td>
                								<td>{{ $reimburse->bank }}</td>
					                      	</tr>
					                    </tbody>
					                    @endforeach
	                  				</table>
	                  				<a href="{{ route('pdfLoanDisburse') }}" class="col-lg-4 col-md-4 pull-right btn btn-primary"> Print Loan Reimbursements. </a>
	                			</div>
	              			</div>
	            		</div>
            		@else 
            			<div class="container">
		                    <p style="color:red; font-size:26px; text-align:center"> No Active Loan Reimbursements At This Time. </p>
		                </div>
            		@endif
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