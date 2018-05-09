@extends('layout.master')

@section('content')
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
	    @include('layout.cashbookBar')
	    <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	            	<h2 class="no-margin-bottom">Cash Book
	            		@if(count($savings) || count($coopopeningbalance) || count($coopRunning) || count($coopAggregate))
	            			<div class="pull-right">
		            			<span style="color:grey"> Opening &nbsp; </span> 
				                <span style="color:#ff7676;"> 
				                    {{ number_format($coopopeningbalance, 2) }} 
				                </span>

				                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

				                <span style="color:grey"> Running &nbsp; </span> 
				                <span style="color:#54e69d;"> 
				                    {{ number_format($coopRunning, 2) }} 
				                </span>

				                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
				                <span style="color:grey"> Balance &nbsp; </span> 
				                <span style="color:#796AEE;"> 
				                    {{ number_format($coopAggregate, 2) }} 
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
	              		Co - op Bank
              		</li>
              		@if(count($savings) || count($equitySumJournal) || count($coopAccount) || count($coopDeposit) || count($coopSumDisburse)|| count($coopSumReimburse))
              			<div class="pull-right">
			                <span style="color: grey"> Cashbook &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($coopAccount, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp; | &nbsp; </span>

			                <span style="color: grey"> Journal &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($equitySumJournal, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp; | &nbsp; </span>

			                <span style="color:grey"> Deposits &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($coopDeposit, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp; | &nbsp; </span>

			                <span style="color:grey"> Disbursements &nbsp; </span> 
			                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
			                    {{ number_format($coopSumDisburse, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp; | &nbsp; </span>
			                <span style="color:grey"> Reimbursements &nbsp; </span> 
			                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
			                    {{ number_format($coopSumReimburse, 0) }} 
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
				                  	<h3 class="h4">Co - op Bank</h3>
				                </div>
				                @if(count($savings) || count($equityJournal) || count($depositsCoop) || count($coopDisburse) || count($memberLoanPayments))
		                			<div class="card-body">
		                  				<table style="text-align:center" class="check table table-hover table-bordered">
						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="8"> Cash Book </th>
						                		</tr>
						                	</thead>
						                	<thead>
						                		<tr>
						                			<th> # </th>
						                			<th> Transaction Date </th>
						                			<th> Details </th>
						                			<th> Deposits / Payments </th>
						                			<th> Debit </th>
						                			<th> Credit </th>						                			
						                			<th> Account / Acc No</th>
						                		</tr>
						                	</thead>
						                	@if(count($savings))
							                	@foreach($savings as $save)
								                	<tbody>
								                		<tr>
								                			<th scope="row">{{ $save->id }}</th>
								                			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
								                			<td>{{ $save->details }}</td>
								                			<td></td>
								                			@if($save->action == 'debit')
								                				<td>{{ number_format($save->debit) }}</td>
								                			@elseif($save->action != 'debit')
								                				<td></td>
								                			@endif

								                			@if($save->action == 'credit')
								                				<td>{{ number_format($save->credit) }}</td>
								                			@elseif($save->action != 'credit')
								                				<td></td>
								                			@endif
								                			<td>{{ $save->accounts }}</td>
								                		</tr>
								                	</tbody>
							                	@endforeach
							                @else
							                	<thead>
							                		<tr class="table-warning">
							                			<th style="text-align:center" colspan="8"> No Cashbook Transactions </th>
							                		</tr>
							                	</thead>
				                			@endif
				                			<!-- Journal -->
				                			<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="8"> Journal </th>
						                		</tr>
						                	</thead>
						                	<tbody>
						                		<tr class="table-warning">
						                			<th style="text-align:center" colspan="8"> No Journal Transactions </th>
						                		</tr>
						                	</tbody>
						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="8"> Member Deposits </th>
						                		</tr>
						                	</thead>
						                	@if(count($depositsCoop))
							                	@foreach($depositsCoop as $deposit)
								                	<tbody>
								                		<tr>
								                			<th scope="row">{{ $deposit['id'] }}</th>
								                			<td>{{ $deposit->created_at->formatlocalized('%a %d %b %y') }}</td>
								                			<td>
								                				{{ $deposit->member['firstname'] }}
								                				&nbsp;
								                				<!-- {{ $deposit->member['surname'] }}
								                				&nbsp; -->
								                				{{ $deposit->member['lastname'] }}
								                			</td>
								                			<td>{{ number_format($deposit->money) }}</td>
								                			<td></td>
								                			<td></td>
								                			<td>{{ $deposit->member['accountNumber'] }}</td>					                			
								                		</tr>
								                	</tbody>
							                	@endforeach
							                @else
							                	<thead>
							                		<tr class="table-info">
							                			<th style="text-align:center" colspan="8"> No Member Deposits </th>
							                		</tr>
							                	</thead>
							                @endif
						                	<!-- Member Loan Disbursements -->
						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="8"> Loan Disbursements </th>
						                		</tr>
						                	</thead>
						                	@if(count($coopDisburse))
							                	@foreach($coopDisburse as $disbursement)
								                	<tbody>
								                		<tr>
								                			<th scope="row">{{ $disbursement['id'] }}</th>
								                			<td>{{ $disbursement->created_at->formatlocalized('%a %d %b %y') }}</td>
								                			<td>
								                				{{ $disbursement->loan->member['firstname'] }}
								                				&nbsp;
								                				{{ $disbursement->loan->member['lastname'] }}
								                			</td>
								                			<td>{{ number_format($disbursement->disburseMoney) }}</td>
								                			<td></td>
								                			<td></td>
								                			<td>{{ $disbursement->loan->member['accountNumber'] }}</td>					                			
								                		</tr>
								                	</tbody>
							                	@endforeach
						                	@else
							                	<thead>
							                		<tr class="table-warning">
							                			<th style="text-align:center" colspan="8"> No Disbursed Loans </th>
							                		</tr>
							                	</thead>
				                			@endif
						                	<!-- Member Loan Payments -->
						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="8"> Loan Reimbursements </th>
						                		</tr>
						                	</thead>
						                	@if(count($memberLoanPayments))
							                	@foreach($memberLoanPayments as $installment)
								                	<tbody>
								                		<tr>
								                			<th scope="row">{{ $installment['id'] }}</th>
								                			<td>{{ $installment->created_at->formatlocalized('%a %d %b %y') }}</td>
								                			<td>
								                				{{ $installment->loan->member['firstname'] }}
								                				&nbsp;
								                				{{ $installment->loan->member['lastname'] }}
								                			</td>
								                			<td>{{ number_format($installment->installment) }}</td>
								                			<td></td>
								                			<td></td>
								                			<td>{{ $installment->loan->member['accountNumber'] }}</td>					                			
								                		</tr>
								                	</tbody>
							                	@endforeach
						                	@else
							                	<thead>
							                		<tr class="table-info">
							                			<th style="text-align:center" colspan="8"> No Disbursed Loans </th>
							                		</tr>
							                	</thead>
				                			@endif
						                </table>
						                <br>
						                <a href="{{ route('pdfcoopCashbook') }}" class="pull-right col-lg-4 col-md-4 btn btn-primary"> Print The Co - op Bank Cashbook. </a>
		                			</div>
	                			@else 
						      		<div class="container">
					                    <p style="color:#796AEE; font-size:26px; text-align:center; padding:50px"> There are No Transactions on Co - op Bank's Cashbook. </p>
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

@include('Modals.chartAccountsModal')

@stop