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
	              		<a href=" {{ route('memberLoans') }} ">
	              			Members Loans
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		Members Updates
              		</li>
		            <div class="pull-right">
		                <span style="color: grey"> Today &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{$today}}
		                </span>
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Time &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{$currenttime}}
		                </span>		
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Total Installments &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                	{{ number_format($maturity, 2) }}
		                </span>                
		            </div>
		            
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>

          	@if(count($loans))
	          	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:30px"> 
	      			<div class="card-body">
	      				<table class="table table-striped">
		                    <thead>
		                      	<tr>
			                        <th>#</th>
			                        <th>First Name</th>
			                        <th>Last Name</th>
			                        <th>Account Number</th>
			                        <th>Bank Name</th>
			                        <th>Bank Account Name</th>
			                        <th>Loan</th>
			                        <th>Loan Duration</th>
			                        <th>Member Installments</th>
			                        <th>Loan Ageing</th>
			                        <th>Creation Date</th>
			                        <th>Monthly Installment</th>
			                        <th>Installments</th>
			                        @foreach($loans as $loan)
				                        @if(count($loan->installments))
				                        	<th>Updates</th>
				                        @endif
				                    @endforeach
		                      	</tr>
		                    </thead>
		                    @foreach($loans as $loan)
				          		@if(Carbon\Carbon::now() >= $loan->created_at->addDays($loan->gracePeriod))
				          			<tbody class="twiffy">
				                      	<tr>
					                        <th scope="row">{{$loan->id}}</th>
					                        <td>{{ $loan->member->firstname }}</td>
					                        <td>{{ $loan->member->lastname }}</td>
					                        <td>{{ $loan->member->accountNumber }}</td>
					                        <td>{{ $loan->member->bankName }}</td>
					                        <td>{{ $loan->member->bankAccountName }}</td>
					                        <td>{{ number_format($loan->loan) }}</td>
					                        <td>{{ number_format($loan->loanDuration) }} Months</td>
					                        <td style="font-weight:bold; color:#ff7676">{{ number_format($loan->totalInstallments,2) }}</td>
					                        
					                        <td>{{ $loan->created_at->addMonth($loan->loanDuration)->diffInMonths() }} Months</td>
					                        
					                        <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($loan->created_at))->formatlocalized('%a %d %b %y') }}</td>
					                        <td>{{ number_format($loan->monthlyInstallment) }}</td>
					                        <td> 
					                        	<a class="btn btn-danger" data-id="{{ $loan->id }}" data-account="{{ $loan->member->accountNumber }}" data-lname="{{ $loan->member->lastname }}" data-fname="{{ $loan->member->firstname }}" id="modal-default-install" href="#installmentsdefaultmodal" data-toggle="modal"> 
					                        		Insertions
					                        	</a>
					                        </td>

					                        @if(count($loan->installments))
						                        <td> 
						                        	<a href="{{ route('installmentUpdates', [$loan->id]) }}" class="btn btn-primary"> 
						                        		Edit 
						                        	</a> 
						                        </td>
					                        @endif
				                      	</tr>
				                    </tbody> 
				                @endif
				          	@endforeach
		                </table>
		            </div>
		        </div> 
	        @else
	        	<div class="contianer">
        			<p style="text-align:center; color:red; font-size:22px; padding:22px">
        				There are No Members with Default Loans at This Time. 
        			</p>
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

@include('Modals.installmentsdefaultmodal')

@stop