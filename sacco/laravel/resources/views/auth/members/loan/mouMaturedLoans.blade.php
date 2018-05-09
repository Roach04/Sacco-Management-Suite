@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

    	@include('layout.maturedBar')

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Matured Loans</h2>
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
	              		<a href=" {{ route('maturedLoans') }} ">
	              			Matured Loans
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		Loans Updates
              		</li>
		            <div class="pull-right">
		                <span style="color:grey"> Monthly Installments &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ number_format($sumonthly, 2) }}
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color: grey"> Today &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{$today}}
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

          	<section class="client no-padding-top" style="margin-top:20px">
            	<div class="container-fluid">
              		<div class="row">
			          	@if(count($loans))
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
					                  	<h3 class="h4">Institution x</h3>
					                </div>
		                			<div class="card-body">
					      				<table class="table table-hover">
						                    <thead>
						                      	<tr>
							                        <th>#</th>
							                        <th>First Name</th>
							                        <th>Last Name</th>
							                        <th>Bank Name</th>
							                        <th>Bank Account Name</th>
							                        <th>Loan</th>
							                        <th>Loan Duration</th>
							                        <th>Member Installments</th>
							                        <th>Loan Ageing</th>
							                        <th>Creation Date</th>
							                        <th>Monthly Installment</th>
						                      	</tr>
						                    </thead>
						                    @foreach($loans as $loan)
								          		@if($loan->loanEntity != 'individual' && Carbon\Carbon::now() >= $loan->created_at->addDays($loan->gracePeriod))
								          			<tbody class="tbuddy">
								                      	<tr>
									                        <th scope="row">{{ $loan->member->accountNumber }}</th>
									                        <td>{{ $loan->member->firstname }}</td>
									                        <td>{{ $loan->member->lastname }}</td>
									                        <td>{{ $loan->member->bankName }}</td>
									                        <td>{{ $loan->member->bankAccountName }}</td>
									                        <td>{{ number_format($loan->loan) }}</td>
									                        <td>{{ number_format($loan->loanDuration) }} Months</td>
									                        @if($loan->state == 2)
									                        	<td style="font-weight:bold; color:#ffc36d">{{ number_format($loan->totalInstallments,2) }}</td>
									                        @elseif($loan->state == 3)
									                        	<td style="font-weight:bold; color:#ff7676">{{ number_format($loan->totalInstallments,2) }}</td>
									                        @endif
									                        <td>{{ $loan->created_at->addMonth($loan->loanDuration)->diffInMonths() }} Months</td>
									                        
									                        <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($loan->created_at))->formatlocalized('%a %d %b %y') }}</td>
									                        <td>{{ number_format($loan->monthlyInstallment) }}</td>
								                      	</tr>
								                    </tbody> 
								                @endif
								          	@endforeach
						                </table>
						                {!! Form::open([ 'route' => ['storeCorporateLoans'], 'method' => 'POST']) !!}
			                        		{!! Form::submit('Loan Reimbursements.', ['class' => 'col-lg-4 col-sm-4 col-md-4 pull-right btn btn-warning']) !!}
			                        	{!! Form::close() !!}
								    </div>
							    </div> 
							</div>
						@else
				        	<div class="contianer">
			        			<p style="text-align:center; color:#ffc36d; font-size:22px; padding:22px">
			        				There are No Members with Matured Loans at This Time. 
			        			</p>
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

@include('Modals.installmentsModal')

@stop