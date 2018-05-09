@extends('layout.master')

@section('content')
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
	    @include('layout.memberUpdatesBar')
	    <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Members Accounts</h2>
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
	              		<a href=" {{ route('memberAccount') }} ">
	              			Members Accounts
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		Member Statement.
              		</li>
              		@if(count($member))
              			<div class="pull-right">
			                <span style="color: grey"> Guaranteed Money &nbsp; </span> 
			                <span style="color:#85b4f2; font:normal 18px book antiqua"> 
			                    {{ number_format($member->guarantorMoney) }} 
			                </span>

			                @if($member->loanStatus == 1)
				                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

				                <span style="color:grey"> Loan &nbsp; </span> 
				                <span style="color:#796AEE; font:normal 18px book antiqua"> 
				                    {{ number_format($sumLoans, 2) }} 
				                </span>
			                @endif

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Runing Balance &nbsp; </span> 
			                <span style="color:#ff7676; font:normal 18px book antiqua"> 
			                    {{ number_format($member->totals, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Totals &nbsp; </span> 
			                <span style="color:#54e69d; font:normal 18px book antiqua"> 
			                    {{ number_format($deposits, 2) }} 
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

          	@if(count($member))
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
					                  	<h3 class="h4">
					                  		<span style="color:#54e69d">
					                  			{{ $member->firstname }} &nbsp; {{ $member->lastname }}'s &nbsp; 
					                  		</span>Member Statement
					                  	</h3>
					                </div>
		                			<div class="card-body">
		                				<div>
						                	<p style="text-align:center"> <strong> Member Deposits </strong> </p>
		                				</div>
		                  				<table class="table table-hover">
						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="10"> Deposits </th>
						                		</tr>
						                		<tr>
						                			<th colspan="2" style="text-align:center"> # </th> 
						                			<th colspan="2" style="text-align:center"> Transaction Date </th>
						                			<th colspan="2" style="text-align:center"> Deposit </th>
						                			<th colspan="2" style="text-align:center"> Bank </th>
						                			<th colspan="2" style="text-align:center"> Account No </th>
						                		</tr>
						                	</thead>
						                	
						                	@foreach($member->account as $account)
						                	<tbody align="center">
						                		<tr>
						                			<td colspan="2"> {{ $account->id }} </td>
						                			<td colspan="2">{{ $account->created_at->formatlocalized('%a %d %b %y') }}</td>
						                			<td colspan="2">{{ number_format($account->money) }}</td>
						                			<td colspan="2">{{ $account->bank }}</td>
						                			<td colspan="2">{{ $member->accountNumber }}</td>
						                		</tr>
						                	</tbody>
						                	@endforeach

						                	<tr class="table-info">
						                		<td colspan="5" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Deposits </strong> </td>
							                	<td colspan="5" style="text-align:center; font-size: 18px; color:#54e69d"> <strong> KES &nbsp; {{ number_format($deposits) }} </strong> </td>
							                </tr>

							                @if(count($loans))
							                	<thead>
							                		<tr class="thead-inverse">
							                			<th style="text-align:center" colspan="10"> Loan </th>
							                		</tr>
							                		<tr>
							                			<th style="text-align:center;" colspan="2"> Loan Type </th>
							                			<th style="text-align:center;" colspan="2"> Loan Amount </th>
							                			<th style="text-align:center;" colspan="2"> 
							                				@foreach($loans as $loan)
								                				@if($today < $loan->created_at->addDays($loan->gracePeriod)->diffInDays())
					                                                Grace Period
					                                            @elseif($today > $loan->created_at->addDays($loan->gracePeriod)->diffInDays())
					                                            	<p style="color:#ffc36d"> Loan Ageing </p>
					                                            @endif
				                                            @endforeach
							                			</th>
							                			<th style="text-align:center;" colspan="2"> Loan Disbursement </th>
							                			<th style="text-align:center;" colspan="2"> Installments Paid </th>
							                		</tr>
							                	</thead>
							                	@foreach($loans as $loan)
							                	<tbody>
							                		<tr>
							                			<td style="text-align:center;" colspan="2">{{ ucfirst($loan->loanType) }} Loan</td>
							                			<td style="text-align:center;" colspan="2">{{ number_format($loan->amount) }}</td>
							                			<td style="text-align:center;" colspan="2">
							                				@if($today < $loan->created_at->addDays($loan->gracePeriod)->diffInDays())
				                                                <p style="color:#54e69d"> <strong> {{ $loan->created_at->addDays($loan->gracePeriod)->diffInDays() }} Days </strong> </p>
				                                            @elseif($today > $loan->created_at->addDays($loan->gracePeriod)->diffInDays())
				                                            	<p style="color:#ffc36d"> <strong> {{ $loan->created_At->addMonths($loan->loanDuration)->diffInMonths() }} </strong> </p>
				                                            @endif
							                			</td>
							                			@if(count($loan->disbursements))
								                			@foreach($loan->disbursements as $disburse)
								                				<td style="text-align:center;" colspan="2">{{ number_format($disburse->disburseMoney) }}</td>	
								                			@endforeach
							                			@else
								                			<td style="text-align:center;" colspan="2"> No Disbursement </td>
								                		@endif
							                			<td style="text-align:center;" colspan="2"> {{ number_format($loan->totalInstallments) }} </td>
							                		</tr>
							                	</tbody>
							                	@endforeach
							                	<tr class="table-info">
							                		<td colspan="5" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Balance </strong> </td>
								                	<td colspan="5" style="text-align:center; font-size: 18px; color:#ff7676"> <strong> KES {{ number_format( $sumLoans, 0) }} </strong> </td>
						                		</tr>

								                @if(count($loan->installments))
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="10"> Installments </th>
								                		</tr>
								                		<tr>
								                			<th> Creation Date </th>
								                			<th> Installment Paid </th>
								                			<th> Months Left </th>
								                			<th> Number of Defaults </th>
								                		</tr>
								                	</thead>

								                	@foreach($member->loan->installments as $installment)
								                	<tbody>
								                		<tr>
								                			<td colspan="2">{{ $installment->created_at->formatlocalized('%a %d %b %y') }}</td>
								                			<td colspan="2">{{ number_format($installment->installment) }}</td>
								                			<td colspan="2">{{ $installment->daysLeft }} Months </td>
								                			<td colspan="2">{{ $installment->defaults }}</td>
								                		</tr>
								                	</tbody>
								                	@endforeach
							                	@endif
							                @else
							                	<thead>
							                		<tr class="thead-inverse">
							                			<th style="text-align:center" colspan="10"> Loan </th>
							                		</tr>
							                	</thead>
							                	<tbody>
							                		<tr class="table-warning">
							                			<th style="text-align:center" colspan="10"> Your Loan Status is &nbsp; <b>CLEAR</b> </th>
							                		</tr>
							                	</tbody>
						                	@endif			                	

						                	@if($member->guaranteeStatus == 1)
							                	<thead>
							                		<tr class="thead-inverse">
							                			<th style="text-align:center" colspan="10"> Guarantor </th>
							                		</tr>
							                		<tr>
							                			<th colspan="2" style="text-align:center;"> Loan Type </th>
							                			<th colspan="2" style="text-align:center;"> Loan Amount </th>
							                			<th colspan="2" style="text-align:center;"> Guaranteed Money</th>
							                			<th colspan="2" style="text-align:center;"> Loan Disbursement</th>
							                			<th colspan="2" style="text-align:center;"> Installments Paid </th>
							                		</tr>
							                	</thead>

							                	@foreach($guaranteed as $guarantee)
							                	<tbody>
							                		<tr>
							                			<td colspan="2" style="text-align:center;">{{ ucfirst($guarantee->loanType) }}</td>
							                			<td colspan="2" style="text-align:center;">{{ number_format($guarantee->loan) }}</td>
							                			@if($member->accountNumber == $guarantee->guaranteeOne)
							                				<td colspan="2" style="text-align:center;">{{ number_format($guarantee->moneyOne) }}</td>
							                			@elseif($member->accountNumber == $guarantee->guaranteeTwo)
							                				<td colspan="2" style="text-align:center;">{{ number_format($guarantee->moneyTwo) }}</td>
							                			@elseif($member->accountNumber == $guarantee->guaranteeThree)
							                				<td colspan="2" style="text-align:center;">{{ number_format($guarantee->moneyThree) }}</td>
							                			@endif
							                			@if(count($guarantee->disbursements))
								                			@foreach($guarantee->disbursements as $disburse)
								                				<td style="text-align:center;" colspan="2">{{ number_format($disburse->disburseMoney) }}</td>	
								                			@endforeach
								                		@else
								                			<td style="text-align:center;" colspan="2"> No Disbursement </td>
								                		@endif
							                			<td colspan="2" style="text-align:center;"> {{ number_format($guarantee->totalInstallments) }} </td>
							                		</tr>
							                	</tbody>
							                	@endforeach
							                	
						                	@elseif($member->guaranteeStatus == 0)
						                		<thead>
							                		<tr class="thead-inverse">
							                			<th style="text-align:center" colspan="10"> Guarantor </th>
							                		</tr>
							                	</thead>
							                	<tbody>
							                		<tr class="table-success">
							                			<th style="text-align:center" colspan="10"> Your Guarantor Status is &nbsp; <b>CLEAR</b> </th>
							                		</tr>
							                	</tbody>
						                	@endif
						                	<tr class="thead-inverse">
					                			<th style="text-align:center" colspan="10"> Balance </th>
					                		</tr>
						                	<tr class="table-info">
						                		<th colspan="5" style="text-align:center; font-size: 18px; color:#796AEE">Running Balance</th>
						                		<th colspan="5" style="text-align:center; font-size: 18px; color:#796AEE">KES &nbsp; {{ number_format($member->totals) }}</th>
						                	</tr>
						                </table>
						                <br>
						                <a href="{{ route('pdfmemberStatement', [$member->id]) }}" class="pull-right col-lg-4 col-md-4 btn btn-primary"> Print Member Statement. </a>
		                			</div>
		              			</div>
		            		</div>
		          		</div>
		        	</div>
		      	</section>
	      	@else 
	      		<div class="container">
                    <p style="color:#796AEE; font-size:26px; text-align:center"> This Member Has No Transactions. </p>
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