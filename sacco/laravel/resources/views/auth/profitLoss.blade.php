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
	              		Profit & Loss
              		</li>
              		@if(count($savings))
              			<div class="pull-right">
			                <span style="color:grey"> Co - op &nbsp; </span> 
			                <span style="color:#54e69d; font:normal 18px book antiqua"> 
			                    {{ number_format($coopAccount, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Equity &nbsp; </span> 
			                <span style="color:#ff7676; font:normal 18px book antiqua"> 
			                    {{ number_format($equityAccount, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Petty Cash &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($pettycashAccount, 2) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
			                <span style="color:grey"> Cash &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($coopAccount + $equityAccount + $pettycashAccount, 2) }} 
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
				                  	<h3 class="h4">Profit & Loss</h3>
				                </div>
				                @if(count($savings))
		                			<div class="card-body">
		                				<div>
						                	<p style="text-align:center"> <strong> Ordinary Income / Expense </strong> </p>
		                				</div>
		                  				<table class="check table table-hover">
						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="4"> Income </th>
						                		</tr>
						                		<tr>
						                			<th> # </th> 
						                			<th> Details </th>
						                			<th> Account </th>
						                			<th> Money </th>
						                		</tr>
						                	</thead>
						                	@foreach($credits as $saving)
							                	<tbody>
							                		<tr>
							                			<td>{{ $saving->id }}</td>
							                			<td>{{ $saving->details }}</td>
							                			<td>{{ $saving->accounts }}</td>
							                			<td>{{ number_format($saving->credit) }}</td>
							                		</tr>
							                	</tbody>
						                	@endforeach
						                	<td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Income </strong> </td>
							                <td colspan="2" style="text-align:center; font-size: 18px; color:#54e69d"> <strong> KES &nbsp; {{ number_format($sumcredit) }} </strong> </td>

						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="4"> Expense </th>
						                		</tr>
						                		<tr>
						                			<th> # </th> 
						                			<th> Details </th>
						                			<th> Account </th>
						                			<th> Money </th>
						                		</tr>
						                	</thead>
						                	<!-- Savings -->
						                	@foreach($debits as $saving)
							                	<tbody>
							                		<tr>
							                			<td>{{ $saving->id }}</td>
							                			<td>{{ $saving->details }}</td>
							                			<td>{{ $saving->accounts }}</td>
							                			<td>{{ number_format($saving->debit) }}</td>
							                		</tr>
							                	</tbody>
							                @endforeach
							                <!-- Journals -->
							                @foreach($journals as $journal)
							                	<tbody>
							                		<tr>
							                			<td>{{ $journal->id }}</td>
							                			<td>{{ $journal->details }}</td>
							                			<td>{{ $journal->accountName }}</td>
							                			<td>{{ number_format($journal->actualFigure + $journal->overpay) }}</td>
							                		</tr>
							                	</tbody>
							                @endforeach
						                	<td colspan="2" style="text-align:center; font-size: 18px; color:#796AEE"> <strong> Total Expense </strong> </td>
							                <td colspan="2" style="text-align:center; font-size: 18px; color:#ff7676"> <strong> KES &nbsp; {{ number_format($sumdebit + $sumJournal) }} </strong> </td>
						                	<thead>
						                		<tr class="thead-inverse">
						                			<th style="text-align:center" colspan="4"> Totals </th>
						                		</tr>
						                	</thead>
						                	<tbody class="table-warning">
						                		<tr>
						                			@if($sumcredit > $sumdebit)
							                			<td colspan="4" style="text-align:center; font-size: 18px; color:#54e69d"> 
							                				<strong>
							                					KES &nbsp; {{ number_format($sumcredit - ($sumdebit + $sumJournal), 2) }}
							                				</strong>
							                			</td>
							                		@elseif($sumcredit < $sumdebit)
							                			<td colspan="4" style="text-align:center; font-size: 18px; color:#ff7676"> 
							                				<strong>
							                					KES &nbsp; {{ number_format($sumcredit - ($sumdebit + $sumJournal), 2) }}
							                				</strong>
							                			</td>
							                		@elseif($sumdebit == $sumcredit)
							                			<td colspan="4" style="text-align:center; font-size: 18px; color:#796AEE"> 
							                				<strong>
							                					KES &nbsp; {{ number_format($sumcredit - ($sumdebit + $sumJournal), 2) }}
							                				</strong>
							                			</td>
							                		@endif
						                		</tr>
						                	</tbody>
						                </table>
						                <br>
						                <a href="{{ route('pdfProfitLoss') }}" class="pull-right col-lg-4 col-md-4 btn btn-primary"> Print Profit & Loss. </a>
		                			</div>
	                			@else 
						      		<div class="container">
					                    <p style="color:#796AEE; font-size:26px; text-align:center; padding:50px"> No Transactions Captured On The Profit & Loss Report. </p>
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