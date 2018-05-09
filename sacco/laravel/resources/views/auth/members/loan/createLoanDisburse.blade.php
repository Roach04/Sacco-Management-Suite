@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
    	
  		@include('layout.showLoanBar')

        <div class="content-inner">
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
	              		<a href=" {{ route('loansMember', [$loan->member->id]) }} ">
	              			Member Loans
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		{{ $loan->member->firstname }} &nbsp; {{ $loan->member->lastname }}
              		</li>
              		@if($loan)
              		<div class="pull-right">
              			<span style="color: grey"> Equity Bank &nbsp; </span> 
		                <span style="color:#54e69d; font:normal 18px book antiqua"> 
		                    {{ number_format($equityAccount) }} 
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color: grey"> Loan Amount &nbsp; </span> 
		                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
		                    {{ number_format($loan->amount) }} 
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color: grey"> Loan Disbursed &nbsp; </span> 
		                <span style="color:#85b4f2; font:normal 18px book antiqua"> 
		                    {{ number_format($disbursements) }} 
		                </span>
		                
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Status &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                	@if($loan->state == 0)
		                		Pending
		                	@elseif($loan->state ==1)
		                		Active
		                	@elseif($loan->state == 2)
		                		Mature
		                	@endif
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Cash &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ number_format($loan->member->totals, 2) }} 
		                </span>
		            </div>
		            @endif
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>

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
				                  	<h3 class="h4">Loan Disbursement</h3>
				                </div>
				                {!! Form::open(['route' => ['storeDisbursement', $loan->id], 'method'=>'POST']) !!}
	                			<div class="card-body">
                					<div class="row">
				                      	<label class="col-sm-3 form-control-label">Money Particulars</label>
				                      	<div class="col-sm-9">
					                        <div class="form-group-material">
					                        	{!! Form::text('disburseMoney', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('disburseMoney', 'Disburse Money.', ['class'=> 'label-material']) !!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('disburseMoney'))
							                            {{ $errors->first('disburseMoney') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('chequeNumber', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('chequeNumber', 'Cheque Number.', ['class'=> 'label-material']) !!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('chequeNumber'))
							                            {{ $errors->first('chequeNumber') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>
				                    <div class="line"></div>

				                    <div class="row">
				                      	<label class="col-sm-3 form-control-label">Member Particulars</label>
				                      	<div class="col-sm-9">
					                        <div class="form-group-material">
					                        	{!! Form::text('firstname', $loan->member->firstname, ['class'=> 'input-material', 'readonly'])!!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('firstname'))
							                            {{ $errors->first('firstname') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                        	{!! Form::text('lastname', $loan->member->lastname, ['class'=> 'input-material', 'readonly'])!!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('lastname'))
							                            {{ $errors->first('lastname') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('accountNumber', $loan->member->accountNumber, ['class'=> 'input-material', 'readonly'])!!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('accountNumber'))
							                            {{ $errors->first('accountNumber') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>

				                    <div class="line"></div>

				                    <div class="row">
				                      	<label class="col-sm-3 form-control-label">Bank Particulars</label>
				                      	<div class="col-sm-9">
					                        <div class="form-group-material">
					                        	{!! Form::text('equityBank', 'Equity Bank', ['readonly' => 'readonly', 'class'=> 'input-material', 'readonly'])!!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('equityBank'))
							                            {{ $errors->first('equityBank') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>

				                    <div class="line"></div>
					       
				                    <div class="form-group row">
				                      	<div class="col-sm-4 offset-sm-3">
				                        	{!! Form::reset('Cancel', ['class' => 'btn btn-secondary']) !!}
				                        	
				                        	{!! Form::submit('Disburse The Money', ['class' => 'btn btn-primary']) !!}
				                      	</div>
				                    </div>
				                </div>
				                {!! Form::close() !!}
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