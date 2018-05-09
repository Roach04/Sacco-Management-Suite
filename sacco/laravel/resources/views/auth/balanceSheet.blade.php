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
	              <h2 class="no-margin-bottom">System Reports</h2>
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
	              		Balance Sheet
              		</li>
              		@if(count($savings))
              			<div class="pull-right">

			                <span style="color:grey"> Co - op &nbsp; </span> 
			                <span style="color:#54e69d; font:normal 18px book antiqua"> 
			                    {{ number_format($coopAggregate, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Equity &nbsp; </span> 
			                <span style="color:#ff7676; font:normal 18px book antiqua"> 
			                    {{ number_format($equityAggregate, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Petty Cash &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycashAccount, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color:grey"> Cash &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($coopAggregate + $equityAggregate + $pettycashAccount, 2) }} 
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
				                  	<h3 class="h4">Balance Sheet</h3>
				                </div>
				                @if(count($savings))
	                			<div class="card-body">
	                  				<table class="check table table-hover">
					                	<thead>
					                		<tr class="thead-inverse">
					                			<th style="text-align:center" colspan="4"> Assets </th>
					                		</tr>
					                	</thead>

					                	<thead>
						                	<tr>
					                			<th colspan="2"> Fixed Assets </th>
					                			<th colspan="2"> Money </th> 
					                		</tr>
				                		</thead>
					                	@foreach($charts as $chart)
					                		@if($chart->category != 'bank' && $chart->category == 'Fixed Asset' && $chart->detail > 0)
							                	<tbody>				                	
							                		<tr>
							                			<td colspan="2">{{ $chart->accountName }}</td>
							                			<td colspan="2">{{ number_format($chart->detail) }}</td>
							                		</tr>
							                	</tbody>
							                @endif

							                @foreach($chart->subcharts as $subchart)
						                		@if($subchart->category != 'bank' && $subchart->category == 'Fixed Asset' && $subchart->detail > 0)
								                	<tbody>				                	
								                		<tr>
								                			<td colspan="2">{{ $subchart->subAccountName }}</td>
								                			<td colspan="2">{{ number_format($subchart->detail) }}</td>
								                		</tr>
								                	</tbody>
								                @endif
						                	@endforeach
					                	@endforeach
					                	<tr>
				                			<td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Fixed Assets </strong> </td>
					                		<td colspan="2" style="text-align:center; font-size: 18px; color:#54e69d"> <strong> KES &nbsp; {{ number_format(abs($fixedassetsummation)) }} </strong> </td>
				                		</tr>
				                		<thead>
				                			<tr>
					                			<th colspan="2"> Current Assets </th>
					                			<th></th>
					                		</tr>
				                		</thead>
					                	<tbody>
					                		<tr>
						                		<td colspan="2">Member Loans</td>
						                		<td colspan="2">{{ number_format($memberLoans) }}</td>
						                	</tr>
						                	@foreach($charts as $chart)
						                	<tr>
						                		@if($chart->category == 'Income')
						                			<td colspan="2">{{ $chart->accountName }}</td>
						                			<td colspan="2">{{ number_format($chart->detail) }}</td>
						                		@elseif($chart->category == 'Account Receivable')
						                			<td colspan="2">{{ $chart->accountName }}</td>
						                			<td colspan="2">{{ number_format($chart->detail) }}</td>
						                		@endif

						                		@foreach($chart->subcharts as $subchart)
						                			@if($subchart->category == 'Income')
							                			<td colspan="2">{{ $subchart->accountName }}</td>
							                			<td colspan="2">{{ number_format($subchart->detail) }}</td>
							                		@elseif($subchart->category == 'Account Receivable')
							                			<td colspan="2">{{ $subchart->accountName }}</td>
							                			<td colspan="2">{{ $subchart->detail }}</td>
							                		@endif
						                		@endforeach
						                	</tr>
						                	@endforeach
						                	<tr>
						                		<td colspan="2">Co - op Bank</td>
						                		<td colspan="2">{{ number_format($coopAggregate) }}</td>
						                	</tr>
						                	<tr>
						                		<td colspan="2">Equity Bank</td>
						                		<td colspan="2">{{ number_format($equityAggregate) }}</td>
						                	</tr>
						                	<tr>
						                		<td colspan="2">Petty Cash</td>
						                		<td colspan="2">{{ number_format($pettycashAccount) }}</td>
						                	</tr>
						                </tbody>
						                <tr>
					                		<td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Current Assets </strong> </td>
						                	<td colspan="2" style="text-align:center; font-size: 18px; color:#54e69d"> <strong> KES &nbsp; {{ number_format(abs($memberLoans + $income + $reimbursementsChart + $coopAggregate + $equityAggregate + $pettycashAccount)) }} </strong> </td>
						                </tr>
						                <tbody>
							                <tr>
							                	<th colspan="2" style="text-align:center; font-size: 20px; color:#54e69d">Total Assets</th>
							                	<td colspan="2" style="text-align:center; font-size: 20px; color:#796AEE"> <strong> KES &nbsp; {{ number_format(abs($fixedassetsummation + $reimbursementsChart + $memberLoans + $income + $coopAggregate + $equityAggregate + $pettycashAccount)) }} </strong> </td>
							                </tr>
						                </tbody>
					                	<thead>
					                		<tr class="thead-inverse">
					                			<th style="text-align:center" colspan="4"> Liabilities </th>
					                		</tr>
					                		<tr>
					                			<th colspan="4"> Liabilities </th>						                			
					                		</tr>
					                		<!-- <tr>
					                			<th colspan="4"> Current Liabilities </th> 
					                		</tr> -->
					                	</thead>
					                	<tbody>
					                		@foreach($charts as $chart)
					                			<tr>
					                				@if($chart->category == 'expense' || $chart->category == 'utility' && $chart->detail > 0)
						                				<td colspan="2">{{ $chart->accountName }}</td>
						                				<td colspan="2">{{ number_format($chart->detail) }}</td>
					                				@endif

					                				@foreach($chart->subcharts as $subchart)
					                					@if($subchart->category == 'expense' || $chart->category == 'utility' || $subchart->category == 'utility' && $subchart->detail > 0)
							                				<td colspan="2">{{ $subchart->accountName }}</td>
							                				<td colspan="2">{{ $subchart->detail }}</td>
						                				@endif
					                				@endforeach
					                			</tr>
					                		@endforeach
						                	<tr>
						                		<th>Member Deposits</th>							                		
						                		<td colspan="2">
						                			{{ number_format($memberDeposits) }}
						                		</td>
						                	</tr>
						                	<tr>
						                		<th>Loan Disbursements</th>							                		
						                		<td colspan="2">
						                			{{ number_format($loanDisbursements) }}
						                		</td>
						                	</tr>
					                	</tbody>
					                	<tr>
					                		<td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Liabilities </strong> </td>
						                	<td colspan="2" style="text-align:center; font-size: 18px; color:#ff7676"> <strong> KES &nbsp; {{ number_format(abs($memberDeposits + $expensesummation + $loanDisbursements)) }} </strong> </td>
					                	</tr>
					                </table>
					                <br>
					                <a href="{{ route('pdfBalanceSheet') }}" class="pull-right col-lg-4 col-md-4 btn btn-primary"> Print Balance Sheet. </a>
	                			</div>
	                			@else 
						      		<div class="container">
					                    <p style="color:#796AEE; font-size:26px; text-align:center; padding:50px"> No Transaction Captured On The Balance Sheet Report. </p>
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