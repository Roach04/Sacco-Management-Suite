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
		                <span style="color: grey"> Loan Amount &nbsp; </span> 
		                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
		                    {{ number_format($loan->loan) }} 
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

    		<form>
    			<input type="hidden" value="{{ $loan->id }}" id="dashboard">
    		</form>

          	<!-- Client Section-->
          	<section class="client no-padding-top" style="margin-top:20px">
            	<div class="container-fluid">
              		<div class="row">
			          	@if(count($loan))
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
					                  	<h3 class="h4">{{ ucfirst($loan->loanType) }} Loan</h3>
					                </div>
						          	<div class="card-body">
							          	<form action="{{ route('loanUpdate', [$loan->id]) }}" method="post"> 
							          		{{ csrf_field() }}
							                <div class="row"> 

							                	<input value="{{ $loan->id }}" name="vice" type="hidden" id="vice" class="form-control">

							                	<div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Firstname.</label>
							                        <input readonly="readonly" value="{{ $loan->member->firstname }}" name="firstname" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('firstname'))
								                            {{ $errors->first('firstname') }}
								                        @endif
								                    </span>
							                    </div>

							                    <input type="hidden" id="id" value="{{ $loan->id }}">

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Surname.</label>
							                        <input readonly="readonly" value="{{ $loan->member->surname }}" name="surname" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('surname'))
								                            {{ $errors->first('surname') }}
								                        @endif
								                    </span>
							                    </div>
							                    
							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Lastname.</label>
							                        <input readonly="readonly" value="{{ $loan->member->lastname }}" name="lastname" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('lastname'))
								                            {{ $errors->first('lastname') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Account Number.</label>
							                        <input value="{{ $loan->member->accountNumber }}" readonly="readonly" name="accountNumber" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('accountNumber'))
								                            {{ $errors->first('accountNumber') }}
								                        @endif
								                    </span>
							                    </div> 

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> The Loan.</label>
							                        <input value="{{ $loan->loan }}" name="loan" readonly="readonly" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('loan'))
								                            {{ $errors->first('loan') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Guarantor (Account Number).</label>
							                        <input value="{{ $loan->guaranteeOne }}" name="guaranteeOne" readonly="readonly" type="number" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('guaranteeOne'))
								                            {{ $errors->first('guaranteeOne') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Guarantor (Account Number).</label>
							                        <input value="{{ $loan['guaranteeTwo'] }}" name="guaranteeTwo" readonly="readonly" type="number" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('guaranteeTwo'))
								                            {{ $errors->first('guaranteeTwo') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Guarantor (Account Number).</label>
							                        <input value="{{ $loan['guaranteeThree'] }}" name="guaranteeThree" readonly="readonly" type="number" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('guaranteeThree'))
								                            {{ $errors->first('guaranteeThree') }}
								                        @endif
								                    </span>
							                    </div>


							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Guarantor's Money ({{ $loan->guaranteeOne }}).</label>
							                        <input value="{{ $loan->moneyOne }}" name="moneyOne" readonly="readonly" type="number" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('moneyOne'))
								                            {{ $errors->first('moneyOne') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Guarantor's Money ({{ $loan->guaranteeTwo }}).</label>
							                        <input value="{{ $loan['moneyTwo'] }}" name="moneyTwo" readonly="readonly" type="number" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('moneyTwo'))
								                            {{ $errors->first('moneyTwo') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Guarantor's Money ({{ $loan->guaranteeThree }}).</label>
							                        <input value="{{ $loan['moneyThree'] }}" name="moneyThree" readonly="readonly" type="number" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('moneyThree'))
								                            {{ $errors->first('moneyThree') }}
								                        @endif
								                    </span>
							                    </div>
							                    

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Loan Duration.</label>
							                        <input value="{{ $loan->loanDuration }}" name="loanDuration" readonly="readonly" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('loanDuration'))
								                            {{ $errors->first('loanDuration') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Monthly Installment.</label>
							                        <input value="{{ $loan->monthlyInstallment }}" name="monthlyInstallment" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('monthlyInstallment'))
								                            {{ $errors->first('monthlyInstallment') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Mode of Payment.</label>
							                        <input value="{{ $loan->modeOfPayment }}" name="modeOfPayment" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('modeOfPayment'))
								                            {{ $errors->first('modeOfPayment') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Loan Entity.</label>
							                        <input value="{{ $loan->loanEntity }}" name="loanEntity" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('loanEntity'))
								                            {{ $errors->first('loanEntity') }}
								                        @endif
								                    </span>
							                    </div>

							                    <div class="col-md-3 col-sm-4 form-group-material">
							                        <label class="label-control"> Loan Type.</label>
							                        <input value="{{ $loan->loanType }}" name="loanType" type="text" class="form-control">
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('loanType'))
								                            {{ $errors->first('loanType') }}
								                        @endif
								                    </span>
							                    </div>
							                </div>		                
							                <div class="modal-footer">  
								                <button class="btn btn-primary col-md-3 col-sm-4">
								                	Save Changes.
								                </button>              
								            </div>                    
							            </form>
							            <div style="margin-top:-53px">
							            	@if($loan->disbursements->count())
								            	@if($loan->state == 1)
								            		@if($loan->created_at->addDays($loan->gracePeriod)->diffInDays() == 0)
									            		<a href="" class="btn btn-warning col-md-4 col-sm-4">
									            			Grace Period Complete.
									            		</a> 
								            		@elseif($loan->created_at->addDays($loan->gracePeriod)->diffInDays() > 0)
								            			<a href="" class="btn btn-info col-md-4 col-sm-4">
									            			Awaiting Expiry of the Grace Period.
									            		</a> 
								            		@endif
								            	@elseif($loan->state == 3)
								            		<a href="" class="btn btn-danger col-md-4 col-sm-4">
								            			Loan Defaulter.
								            		</a>
								            	@elseif($loan->state == 0)
										            {!! Form::open([ 'route' => ['loanProcess', $loan->id], 'method' => 'POST' ]) !!}

								                		{!! Form::submit('Process The Loan.', ['class' => 'btn btn-warning col-md-4 col-sm-4'] ) !!}

								                	{!! Form::close() !!}
							                	@endif
							                @else
							                	<a href="" class="btn btn-danger col-md-4 col-sm-4">
							            			No Loan Disbursements.
							            		</a>
							                @endif
					                	</div>
						            </div>
						        </div>
							</div>
			          	@endif
			        </div>
			    </div>
			</section>
          	<!-- Client Section-->

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