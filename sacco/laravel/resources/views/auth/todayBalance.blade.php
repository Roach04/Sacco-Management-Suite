@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
        @include('layout.yesterdayBalanceBar')
        <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	            	<h2 class="no-margin-bottom">{{ $TodayEnd->formatlocalized('%a %d %b %y') }}
	            		<div class="pull-right">
			                <span style="color:grey"> Opening &nbsp; </span> 
			                <span style="color:#ff7676;"> 
			                    {{ number_format($closingBalanceYesterday, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Closing &nbsp; </span> 
			                <span style="color:#54e69d;"> 
			                    {{ number_format($closingBalanceToday, 2) }} 
			                </span>
			            </div>
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
	              		{{ $TodayEnd->formatlocalized('%B %Y') }} 
              		</li>
              		@if(count($today))
              			<div class="pull-right">
			                <span style="color:grey"> Cashbook &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($cashbookSumToday, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Journal &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($equitySumJournalToday, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Deposits &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($depositsSumToday, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Disbursements &nbsp; </span> 
			                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
			                    {{ number_format($disburseSumToday, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Reimbursements &nbsp; </span> 
			                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
			                    {{ number_format($reimburseSumToday, 0) }} 
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
	                				@if(count($closingBalanceToday) > 0)
							            <div class="row">
		                					<label class="col-sm-3 form-control-label">{{ $TodayEnd->formatlocalized('%A %d') }} Balances</label>
								          	<div style="margin-top:40px" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
								                <table id="table-data" style="text-align:center; width:100%" class="table table-bordered table-hover">
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Cash Book </th>
								                		</tr>
								                	</thead>
								                	<thead>
								                		<tr>
								                			<th>#</th>
								                			<th style="text-align:center"> Transaction Date </th>
								                			<th style="text-align:center"> Details </th>
								                			<th style="text-align:center"> Deposits / Payments </th>
								                			<th style="text-align:center"> Debit </th> 
								                			<th style="text-align:center"> Credit </th>
								                			<th style="text-align:center"> Account / Acc No </th>
								                		</tr>
								                	</thead>
									                @if(count($cashbookToday))
									                	@foreach($cashbookToday as $save)
										                	<tbody>
										                		<tr>
										                			<td>{{ $save->id }}</td>
										                			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
										                			<td>{{ $save->details }}</td>
										                			<td></td>
										                			<td></td>
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
								                	@else
								                		<tbody>
								                			<tr class="table-warning">
								                				<td colspan="8">No Cashbook Transaction as of {{ $TodayEnd->formatlocalized('%a %d %b %y') }}</td>
								                			</tr>
								                		</tbody>
								                	@endif
								                	<!-- Journals -->
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Journal </th>
								                		</tr>
								                	</thead>
								                	@if(count($equityJournalToday))
									                	@foreach($equityJournalToday as $save)
										                	<tbody>
										                		<tr>
										                			<td>{{ $save->id }}</td>
										                			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
										                			<td>{{ $save->details }}</td>
										                			<td></td>
								                					<td>{{ number_format($save->overpay + $save->actualFigure) }}</td>
										                			<td></td>
										                			<td></td>										                			
										                			<td>{{ $save->accountName }}</td>
										                		</tr>
										                	</tbody>
									                	@endforeach
								                	@else
								                		<tbody>
								                			<tr class="table-warning">
								                				<td colspan="8">No Journal Transaction as of {{ $TodayEnd->formatlocalized('%a %d %b %y') }}</td>
								                			</tr>
								                		</tbody>
								                	@endif
								                	<!-- Member Deposits -->
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Member Deposits </th>
								                		</tr>
								                	</thead>
								                	@if(count($depositsToday))
									                	@foreach($depositsToday as $deposit)
										                	<tbody>
										                		<tr>
										                			<th scope="row">{{ $deposit['id'] }}</th>
										                			<td>{{ $deposit->created_at->formatlocalized('%a %d %b %y') }}</td>
										                			<td>
										                				{{ $deposit->member['firstname'] }}
										                				&nbsp;
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
								                		<tbody>
								                			<tr class="table-warning">
								                				<td colspan="8">No Member Deposits as of {{ $TodayEnd->formatlocalized('%a %d %b %y') }}</td>
								                			</tr>
								                		</tbody>
								                	@endif
								                	<!-- Loan Disbursements -->
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Loan Disbursements </th>
								                		</tr>
								                	</thead>
								                	@if(count($disburseToday))
									                	@foreach($disburseToday as $disbursement)
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
								                		<tbody>
								                			<tr class="table-info">
								                				<td colspan="8">No Loan Disbursements as of {{ $TodayEnd->formatlocalized('%a %d %b %y') }}</td>
								                			</tr>
								                		</tbody>
								                	@endif
								                	<!-- Loan Payments -->
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Loan Reimbursements </th>
								                		</tr>
								                	</thead>
								                	@if(count($reimburseToday))
									                	@foreach($reimburseToday as $installment)
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
								                		<tbody>
								                			<tr class="table-danger">
								                				<td colspan="8">No Loan Reimbursements as of {{ $TodayEnd->formatlocalized('%a %d %b %y') }}</td>
								                			</tr>
								                		</tbody>
								                	@endif
								                </table>
								                <a href="{{ route('pdfTodayBalance') }}" class="pull-right col-lg-4 col-md-4 btn btn-info">
								                	Print Today's Balance
								                </a>
								            </div>
							            </div>
							        @else
				                		<div class="container">
						            		<p style="color:red; text-align:center; font-size:24px; padding-left:30px"> There were NO Sacco Transactions as of {{ $TodayEnd->formatlocalized('%a %d %b %y') }}. </p>
						            	</div>
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
@stop