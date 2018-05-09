@extends('layout.master')

@section('content')
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
        <div style="width:100%">
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
	              		Trial Balance
              		</li>
              		@if(count($balances))
              			<div class="pull-right">
			                <span style="color: grey"> Latest Update &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ $last }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

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
				                  	<h3 class="h4">Trial Balance</h3>
				                </div>
	                			@if(count($balances))
					      			<div class="card-body">
					      				<table class="table table-hover table-bordered">
						                    <thead>
						                		<tr>
						                			<th> Account </th>
						                			<th> Debit </th>
						                			<th> Credit </th>
						                			<th> Assets </th>
						                			<th> Liabilities </th>
						                		</tr>
						                	</thead>

						                	@foreach($charts as $chart)
						                		@if($chart->detail > 0)
						                			<tbody>
								                		<tr>
								                			<td>{{ $chart->accountName }}</td>
								                			@if($chart->category == 'expense' || $chart->category == 'utility' || $chart->category == 'Fixed Asset' || $chart->category == 'Account Receivable')
								                				<td>{{ number_format($chart->detail) }}</td>
								                			@else
								                				<td></td>
								                			@endif

								                			@if($chart->category == 'Income')
								                				<td>{{ number_format($chart->detail) }}</td>
								                			@else
								                				<td></td>
								                			@endif
								                			<td></td>
								                			<td></td>
								                		</tr>
								                	</tbody>
						                		@endif

						                		<!-- SUBCHARTS -->
						                		@foreach($chart->subcharts as $subchart)
						                			<tbody>
								                		<tr>
								                			<td>{{ $subchart->subAccountName }}</td>
								                			@if($subchart->category == 'expense' || $chart->category == 'utility' || $subchart->category == 'Fixed Asset')
								                				<td>{{ number_format($subchart->detail) }}</td>
								                			@else
								                				<td></td>
								                			@endif

								                			@if($subchart->category == 'Income')
								                				<td>{{ number_format($subchart->detail) }}</td>
								                			@else
								                				<td></td>
								                			@endif
								                			<td></td>
								                			<td></td>
								                		</tr>
								                	</tbody>
						                		@endforeach
						                	@endforeach
						                	<tbody>
						                		<tr class="table-inverse">
						                			<th style="font-size:18px; font-weight:bold; text-align:center" colspan="8">Members</th>
						                		</tr>
						                		<tr>
						                			<td>Loans</td>
						                			<td></td>
						                			<td></td>
						                			<td>{{ number_format($memberLoans) }}</td>
						                			<td></td>
						                		</tr>
						                		<tr>
						                			<td>Deposits</td>
						                			<td></td>
						                			<td></td>
						                			<td></td>
						                			<td>{{ number_format($memberDeposits) }}</td>
						                		</tr>
						                		<tr>
						                			<td>Disbursements</td>
						                			<td></td>
						                			<td></td>
						                			<td></td>
						                			<td>{{ number_format($loanDisbursements) }}</td>
						                		</tr>
						                		<tr>
						                			<td>Reimbursements</td>
						                			<td></td>
						                			<td></td>
						                			<td>{{ number_format($memberInstallments) }}</td>
						                			<td></td>
						                		</tr>
						                	</tbody>
						                	<tbody>
						                		<tr class="table-inverse">
						                			<th style="font-size:18px; font-weight:bold; text-align:center" colspan="8">Banks</th>
						                		</tr>
						                		<tr>
						                			<td>Co - op Bank</td>
						                			<td></td>
						                			<td></td>
						                			<td>{{ number_format($coopAggregate) }}</td>
						                			<td></td>
						                		</tr>
						                	</tbody>
						                	<tbody>
						                		<tr>
						                			<td>Equity Bank</td>
						                			<td></td>
						                			<td></td>
						                			<td>{{ number_format($equityAggregate) }}</td>
						                			<td></td>
						                		</tr>
						                	</tbody>
						                	<tbody>
						                		<tr>
						                			<td>Petty Cash</td>
						                			<td></td>
						                			<td></td>
						                			<td>{{ number_format($pettycashAccount) }}</td>
						                			<td></td>
						                		</tr>
						                	</tbody>
						                	<tr>
						                		<tr class="table-inverse">
						                			<th style="font-size:18px; font-weight:bold; text-align:center;" colspan="8">Totals</th>
						                		</tr>
						                		<tr>
								                	<td style="font-size:18px; font-weight:bold; text-align:center; color:#54e69d" colspan="8">{{ number_format($chartsummations,2) }}</td>
						                		</tr>
						                	</tr>
						                </table>
						                <a href="{{ route('pdfTrialBalance') }}" class="pull-right col-lg-4 col-md-4 btn btn-primary">
						                	Print Trial Balance
						                </a>
						            </div>
					            @else 
						      		<div class="container">
					                    <p style="color:#796AEE; font-size:26px; text-align:center; padding:50px"> No Transaction Captured On The Trial Balance Report. </p>
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

	      	{!! $balances->render() !!}
        </div>
    </div>
</div>
@stop