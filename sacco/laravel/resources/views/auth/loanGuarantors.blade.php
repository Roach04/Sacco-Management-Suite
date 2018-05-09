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
          		<li class="breadcrumb-item active">Active Loans</li>
          		@if($loan)
          			<div class="pull-right">
		                <span style="color: grey"> Loan Creation &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ Carbon\Carbon::createFromTimestamp(strtotime($loan->created_at))->formatlocalized('%a %d %b %y') }} 
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Duration &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ $loan->loanDuration }} Months
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Loan &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ number_format($loan->loan) }} 
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Loan Ageing &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ $loan->created_at->addMonth($loan->loanDuration)->diffInMonths() }} Months.
		                </span>
		            </div>
          		@endif
        	</div>
      	</ul>
      	<!-- Breadcrumb-->

      	<section class="tables">   
        	<div class="container-fluid">
          		<div class="row">
          			@if(count($loanStatus))
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
				                  	<h3 class="h4">Active Loans Ledger</h3>
				                </div>
	                			<div class="card-body">
	                  				<table class="table table-hover">
					                    <thead>
					                      	<tr>
						                        <th>#</th>
						                        <th>First Name</th>
						                        <th>Last Name</th>
						                        <th>Mobile Number</th>
						                        <th>ID Number</th>
						                        <th>Email Address</th>
						                        <th>Loan Status</th>
						                        <th>Guarantee Status</th>
						                        <th>Total Deposits</th>
						                        <th>Guaranteed Money</th>
						                        <th>Remainder</th>
					                      	</tr>
					                    </thead>
					                    @foreach($guaranteeStatus as $member)
						                    @if($member->accountNumber == $guarantees['guaranteesOne'] || $member->accountNumber == $guarantees['guaranteesTwo'] || $member->accountNumber == $guarantees['guaranteesThree'])
						                    <tbody>
						                      	<tr>
						                      		<th scope="row">{{ $member->accountNumber }}</th>
							                        <td>{{ $member->firstname }}</td>
							                        <td>{{ $member->lastname }}</td>
							                        <td>{{ $member->phoneNumber }}</td>
							                        <td>{{ $member->idNumber }}</td>
							                        <td>{{ $member->emailAddress }}</td>
							                        @if($member->loanStatus == 0)
							                        	<td> Free </td>
							                        @elseif($member->loanStatus == 1)
							                        	<td> Active </td>
							                        @elseif($member->loanStatus == 2)
							                        	<td> Cleared </td>
							                        @endif

							                        @if($member->guaranteeStatus == 0)
							                        	<td> Free </td>
							                        @elseif($member->guaranteeStatus == 1)
							                        	<td> Guarantor </td>
							                        @elseif($member->guaranteeStatus == 2)
							                        	<td> Cleared </td>
							                        @endif
							                        <td>{{ number_format($member->totals + $member->guarantorMoney) }}</td>
							                        <td>{{ number_format($member->guarantorMoney) }}</td>
							                        <td>{{ number_format($member->totals) }}</td>
						                      	</tr>
						                    </tbody>
						                    @endif
					                    @endforeach
	                  				</table>
	                  				<a href="{{ route('pdfLoanGuarantors', [$loan->id]) }}" class="col-lg-4 col-md-4 pull-right btn btn-success"> Print Loan Guarantors. </a>
	                			</div>
	              			</div>
	            		</div>
            		@else 
            			<div class="container">
		                    <p style="color:red; font-size:26px; text-align:center"> No Active Loans At This Time. </p>
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