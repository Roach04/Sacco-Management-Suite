@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		<!-- Side Navbar -->
        @include('layout.equityReconcileBar')
        <!-- Side Navbar -->

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	            	<h2 class="no-margin-bottom">Reconcile March
	            		@if(count($savings) || count($equityopeningbalance) || count($equityAggregate))
			            	<div class="pull-right">
			            		<span style="color:grey"> Opening &nbsp; </span> 
				                <span style="color:#ff7676;"> 
				                    {{ number_format($equityopeningbalance, 2) }} 
				                </span>

				                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

				                <span style="color:grey"> Ending &nbsp; </span> 
				                <span style="color:#54e69d;"> 
				                    {{ number_format($equityAggregate, 2) }} 
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
	              		March 
              		</li>
              		@if(count($savings) || count($equitySumJournal) || count($equityAccount) || count($equityDeposit) || count($equityDisburse) || count($equityReimburse))
              			<div class="pull-right">
			                <span style="color:grey"> Cashbook &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($equityAccount, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Journal &nbsp; </span> 
			                <span style="color:#DAA520; font:normal 18px book antiqua"> 
			                    {{ number_format($equitySumJournal, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Deposits &nbsp; </span> 
			                <span style="color:#796AEE; font:normal 18px book antiqua"> 
			                    {{ number_format($equityDeposit, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Disbursements &nbsp; </span> 
			                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
			                    {{ number_format($equityDisburse, 0) }} 
			                </span>

			                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

			                <span style="color:grey"> Reimbursements &nbsp; </span> 
			                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
			                    {{ number_format($equityReimburse, 2) }} 
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
				                  	<h3 class="h4">March 2018</h3>
				                </div>
				                @if(count($savings) || count($equitySumJournal) || count($depositsEquity) || count($loanequitydisbursements) || count($memberLoanEquityPayments))
		                			<div class="card-body">
		                				<form>	
			                				<div class="row">
								            	<label class="col-sm-3 form-control-label">Equity Bank March</label>
								            	<div class="col-sm-9">
							                        <div class="form-group-material">
							                        	<input id="bankEstimate" type="number" name="bankEstimate" class="input-material">

							                          	<label for="bankEstimate" class="label-material"> Provide Bank's Estimate. </label>						                          							                          							                          	
							                        	<br>
							                        	<div id="failure"> </div>
							                        </div>
						                      	</div>
								            </div>
								        </form>   
					                    <div class="form-group row">
					                      	<div class="col-sm-4 offset-sm-3">		
					                            <input type="button" data-equity="{{ $equityAggregate }}" class="btn btn-primary" id="reconcile-equity-march" value="Reconcile Equity Account">
					                      	</div>
					                    </div>
					                    
					                    <div class="line"></div>

					                    <div class="row">
							            	<label class="col-sm-3 form-control-label">Reconcile Account</label>
							            	<div class="container">
							            		<div class="col-sm-9 offset-sm-3">
									                <span style="color:grey"> Difference &nbsp; </span> 
									                <span id="reconcile" style="color:#ff7676; font:normal 18px book antiqua"> </span>
									            </div>
							            	</div>
							            </div>
		                										            
							            <div class="line"></div>

							            <div class="row">
		                					<label class="col-sm-3 form-control-label">Equity Bank March</label>
								          	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
								                <table class="table table-hover table-bordered">
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Cash Book </th>
								                		</tr>
								                	</thead>
								                	<thead>
								                		<tr>
								                			<th style="text-align:center"> Id </th>
								                			<th style="text-align:center"> Transaction Date </th>
								                			<th style="text-align:center"> Details </th> 
								                			<th style="text-align:center"> Deposits / Payments </th> 
								                			<th style="text-align:center"> Debit </th> 
								                			<th style="text-align:center"> Credit </th>
								                			<th style="text-align:center"> Account / Acc No</th>
								                			
								                		</tr>
								                	</thead>
								                	@if(count($savings))
									                	@foreach($savings as $save)
										                	<tbody>
										                		<tr>
										                			<td>{{ $save->id }}</td>
										                			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
										                			<td>{{ $save->details }}</td>
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
								                			<th style="text-align:center" colspan="8"> Journals </th>
								                		</tr>
								                	</thead> 
						                			@if(count($equityJournal))
									                	@foreach($equityJournal as $save)
										                	<tbody>
										                		<tr>
										                			<th scope="row">{{ $save->id }}</th>
										                			<td>{{ $save->created_at->formatlocalized('%a %d %b %y') }}</td>
										                			<td>{{ $save->details }}</td>
										                			<td>{{ number_format($save->actualFigure + $save->overpay) }}</td>
										                			<td></td>
										                			<td></td>
										                			<td>{{ $save->accountName }}</td>
										                		</tr>
										                	</tbody>
									                	@endforeach
								                	@else
									                	<thead>
									                		<tr class="table-warning">
									                			<th style="text-align:center" colspan="8"> No Journal Transactions </th>
									                		</tr>
									                	</thead>
						                			@endif
								                	<!-- Member Deposits -->
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Member Deposits </th>
								                		</tr>
								                	</thead>
								                	@if(count($depositsEquity))
									                	@foreach($depositsEquity as $deposit)
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
									                	<thead>
									                		<tr class="table-info">
									                			<th style="text-align:center" colspan="8"> No Member Deposits </th>
									                		</tr>
									                	</thead>
									                @endif
								                	<!-- Loan Disbursements -->
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Loan Disbursements </th>
								                		</tr>
								                	</thead>
								                	@if(count($loanequitydisbursements))
									                	@foreach($loanequitydisbursements as $disbursement)
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
									                			<th style="text-align:center" colspan="8"> No Loan Disbursements </th>
									                		</tr>
									                	</thead>
									                @endif
								                	<!-- Loan Payments -->
								                	<thead>
								                		<tr class="thead-inverse">
								                			<th style="text-align:center" colspan="8"> Loan Reimbursements </th>
								                		</tr>
								                	</thead>
								                	@if(count($memberLoanEquityPayments))
									                	@foreach($memberLoanEquityPayments as $installment)
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
									                			<th style="text-align:center" colspan="8"> No Loan Reimbursements </th>
									                		</tr>
									                	</thead>
									                @endif
								                </table>
								            </div>
							            	{!! $savings->render() !!}
							            </div>
		                			</div>
	                			@else
					            	<div class="container"> 
					            		<p style="text-align:center; color:red; font-size:24px; padding:50px">
					            			There Are No Transactions From Equity Bank In The Month Of March. 
					            		</p>
					            	</div>
					            @endif
	                		</div>
	                	</div>
	                </div>
	            </div>
	        </section>  
	        <!-- Forms Section-->
	        
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

@include('Modals.savingsUpdateModal')

@stop