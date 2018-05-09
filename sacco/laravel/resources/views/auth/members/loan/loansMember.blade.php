@extends('layout.master')

@section('content')
	
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
    	
  		@include('layout.loansBar')

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
	              		<a href=" {{ route('memberLoans') }} ">
	              			Members Loans
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		{{ $member->firstname }} &nbsp; {{ $member->lastname }}
              		</li>
              		@if($loan)
              		<div class="pull-right">
		                <!-- <span style="color: grey"> Latest Update &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ $last }} 
		                </span> -->

		                <span style="color: grey"> Guaranteed Money &nbsp; </span> 
		                <span style="color:#54e69d; font:normal 18px book antiqua"> 
		                    {{ number_format($member->guarantorMoney) }} 
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Loan Amount &nbsp; </span> 
		                <span style="color:#ffc36d; font:normal 18px book antiqua"> 
		                	{{ number_format($activeLoans) }}
		                </span>
		                
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Loan Status &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                	@if($status == 0)
		                		Pending
		                	@elseif($status ==1)
		                		Active
		                	@elseif($status == 2)
		                		Matured
		                	@endif
		                    <!-- {{ number_format($cash, 2) }} --> 
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Cash &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ number_format($cash, 2) }} 
		                </span>
		            </div>
		            @else
		            <div class="pull-right">
		                <span style="color: grey"> Today &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{$today}}
		                </span>

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

		                <span style="color:grey"> Guaranteed Money &nbsp; </span> 
		                <span style="color:#54e69d; font:normal 18px book antiqua"> 
		                	{{ number_format($member->guarantorMoney) }}
		                </span> 
		                	
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Loan Status &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                	{{ number_format($member->loanStatus) }}
		                </span>		                 

		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Cash &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ number_format($cash, 2) }} 
		                </span>	              
		            </div>
		            @endif
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>

          	<!-- Client Section-->
          	<section class="client no-padding-top" style="margin-top:20px">
            	<div class="container-fluid">
              		<div class="row">
			          	@if(count($loan) && $member->guaranteeStatus == 1)
			          		@foreach($loans as $loan)
			          			@if($member->accountNumber == $loan['guaranteeOne'] || $member->accountNumber == $loan['guaranteeTwo'] || $member->accountNumber == $loan['guaranteeThree'])
					          		<div class="col-lg-4">
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
							                  	<h3 class="h4">{{ $loan->member->firstname }} &nbsp; {{ $loan->member->lastname }} </h3>
							                </div>
								          	<div class="card-body text-center">
									          	<div class="client-avatar">
	                                                <img style="width:100%; height:100px" src="{{$loan->member->memberPic}}" alt="..." class="img-fluid rounded-circle">
	                                                <div class="status bg-violet"></div>
		                                        </div>
		                                        <div class="client-title">
		                                            @if($member->accountNumber == $loan['guaranteeOne'])
		                                        		<span> Guaranteed Money </span>
		                                        		<p> KES &nbsp; <strong> {{ number_format($loan->moneyOne) }} </strong> </p>
		                                        	@elseif($member->accountNumber == $loan['guaranteeTwo'])
		                                        		<span> Guaranteed Money </span>
		                                            	<p> KES &nbsp; <strong> {{ number_format($loan->moneyTwo) }} </strong> </p>
		                                            @elseif($member->accountNumber == $loan['guaranteeThree'])
		                                            	<span> Guaranteed Money </span>
		                                            	<p> KES &nbsp; <strong> {{ number_format($loan->moneyThree) }} </strong> </p>
		                                            @endif

		                                            @if($loan->disbursements->count())
			                                            @if($loan->state == 1)
			                                            	<span> Grace Period </span>
			                                                <p style="color:#54e69d"> <strong> {{ $loan->created_at->addDays($loan->gracePeriod)->diffInDays() }} Days </strong> </p>
			                                            @elseif($loan->state == 2)
			                                            	<span> Grace Period </span>
			                                            	<p style="color:#ffc36d"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months</strong> </p>
			                                            @elseif($loan->state == 3)
			                                            	<span> Loan Ageing </span>
			                                            	<p style="color:#ff7676"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months</strong> </p>
			                                            @endif
			                                        @else
			                                        	<span> Loan Disbursements </span>
			                                            <p style="color:#ff7676"> <strong> {{ $loan->disbursements->count() }} </strong> </p>
			                                        @endif
		                                        </div>
		                                        <div class="client-info">
		                                            <div class="row">
		                                                <div class="col-4"><strong> {{ ucfirst($loan->loanType) }} </strong><br><small>Loan Type</small></div> 
		                                                <div class="col-4">
		                                                    <strong id="trey" style="color:#796AEE;"> {{ $loan->loanDuration }} Months</strong><br>
		                                                    <small>Loan Duration</small>
		                                                </div>
		                                                <div class="col-4"><strong> {{ ucfirst($loan->loanEntity) }} </strong><br><small>Loan Entity</small></div>
		                                            </div>
		                                        </div>
		                                        <div class="client-info">
		                                            <div class="row">
		                                                @if(count($loan) && $loan->state == 0)
		                                                    <a style="color:white" class="btn btn-info btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Loan Awating Approval.
		                                                    </a>
		                                                @elseif(count($loan) && $loan->state == 1)
		                                                    <a style="color:white" class="btn btn-primary btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Active Kes {{ number_format($loan->amount, 0) }}
		                                                    </a>
		                                                @elseif($member->guaranteeStatus == 1)
		                                                    <a style="color:white" class="btn btn-info btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Your Are a Guarantor
		                                                    </a>
		                                                @elseif(count($loan) && $loan->state == 2)
		                                                    <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-warning btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Mature Loan {{ number_format($loan->amount, 0) }}
		                                                    </a>
		                                                @elseif(count($loan) && $loan->state == 3)
		                                                    <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-danger btn-block" > 
		                                                        Default Loan {{ number_format($loan->amount, 0) }}
		                                                    </a>
		                                                @endif
		                                            </div>
		                                        </div>
								            </div>
								        </div>
									</div>
								@else
					          		<div class="col-lg-4">
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
							                  	<h3 class="h4">{{ $loan->member->firstname }} &nbsp; {{ $loan->member->lastname }}'s Loan</h3>
							                </div>
								          	<div class="card-body text-center">
									          	<div class="client-avatar">
		                                            <a href=" {{ route('showLoan', [$loan->id]) }} ">
		                                                <img style="width:100%; height:100px" src="{{$member->memberPic}}" alt="..." class="img-fluid rounded-circle">
		                                                <div class="status bg-violet"></div>
		                                            </a>
		                                        </div>
		                                        <div class="client-title">
		                                        	<span> Loan Amount </span>
		                                        	<p> KES &nbsp; <strong>{{ number_format($loan->loan) }}</strong> </p>
		                                            @if($member->accountNumber == $loan['guaranteeOne'])
		                                        		<span> Guaranteed Money </span>
		                                        		<p> KES &nbsp; <strong> {{ number_format($loan->moneyOne) }} </strong> </p>
		                                        	@elseif($member->accountNumber == $loan['guaranteeTwo'])
		                                        		<span> Guaranteed Money </span>
		                                            	<p> KES &nbsp; <strong> {{ number_format($loan->moneyTwo) }} </strong> </p>
		                                            @elseif($member->accountNumber == $loan['guaranteeThree'])
		                                            	<span> Guaranteed Money </span>
		                                            	<p> KES &nbsp; <strong> {{ number_format($loan->moneyThree) }} </strong> </p>
		                                            @endif

		                                            @if($loan->state == 1)
		                                            	<span> Grace Period </span>
		                                                <p style="color:#54e69d"> <strong> {{ $loan->created_at->addDays($loan->gracePeriod)->diffInDays() }} Days </strong> </p>
		                                            @elseif($loan->state == 2)
		                                            	<span> Grace Period </span>
		                                            	<p style="color:#ffc36d"> <strong> {{ $loan->updated_at->addDays($loan->gracePeriod)->diffInDays() }} Days</strong> </p>
		                                            @elseif($loan->state == 3)
		                                            	<span> Loan Ageing </span>
		                                            	<p style="color:#ff7676"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months</strong> </p>
		                                            @endif		                                        
		                                        </div>
		                                        <div class="client-info">
		                                            <div class="row">
		                                                <div class="col-4"><strong> {{ ucfirst($loan->loanType) }} </strong><br><small>Loan Type</small></div> 
		                                                <div class="col-4">
		                                                    <strong id="trey" style="color:#796AEE;"> {{ $loan->loanDuration }} </strong><br>
		                                                    <small>Loan Duration</small>
		                                                </div>
		                                                <div class="col-4"><strong> {{ ucfirst($loan->loanEntity) }} </strong><br><small>Loan Entity</small></div>
		                                            </div>
		                                        </div>
		                                        <div class="client-info">
		                                            <div class="row">
		                                                @if(count($loan) && $loan->state == 0)
		                                                    <a style="color:white" class="btn btn-info btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Loan Awating Approval.
		                                                    </a>
		                                                @elseif(count($loan) && $loan->state == 1)
		                                                    <a style="color:white" class="btn btn-success btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Active Kes {{ number_format($loan->amount, 0) }}
		                                                    </a>
		                                                @elseif(count($loan) && $loan->state == 2)
		                                                    <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-warning btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Mature Loan {{ number_format($loan->amount, 0) }}
		                                                    </a>
	                                                    @elseif(count($loan) && $loan->state == 3)
		                                                    <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-danger btn-block" > 
		                                                        Loan Defaulter  {{ number_format($loan->amount, 0) }}
		                                                    </a>
		                                                @elseif($member->guaranteeStatus == 1)
		                                                    <a style="color:white" class="btn btn-info btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Your Are a Guarantor
		                                                    </a>
		                                                @endif
		                                            </div>
		                                        </div>
								            </div>
								        </div>
									</div>
								@endif
							@endforeach
						@elseif(count($loan) && $member->loanStatus == 1)
							@foreach($loans as $loan)
								<div class="col-lg-4">
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
						                  	<h3 class="h4">{{ $loan->member->firstname }} &nbsp; {{ $loan->member->lastname }}'s Loan</h3>
						                </div>
							          	<div class="card-body text-center">
								          	<div class="client-avatar">
	                                            <a href=" {{ route('showLoan', [$loan->id]) }} ">
	                                                <img style="width:100%; height:100px" src="{{$member->memberPic}}" alt="..." class="img-fluid rounded-circle">
	                                                <div class="status bg-violet"></div>
	                                            </a>
	                                        </div>
	                                        <div class="client-title">
	                                        	@if($member->guaranteeStatus == 1)
		                                        	@if($member->accountNumber == $loan['guaranteeOne'])
		                                        		<span> Guaranteed Money </span>
		                                        		<p> KES &nbsp; <strong> {{ number_format($loan->moneyOne) }} </strong> </p>
		                                        	@elseif($member->accountNumber == $loan['guaranteeTwo'])
		                                        		<span> Guaranteed Money </span>
		                                            	<p> KES &nbsp; <strong> {{ number_format($loan->moneyTwo) }} </strong> </p>
		                                            @elseif($member->accountNumber == $loan['guaranteeThree'])
		                                            	<span> Guaranteed Money </span>
		                                            	<p> KES &nbsp; <strong> {{ number_format($loan->moneyThree) }} </strong> </p>
		                                            @endif
		                                        @else
		                                        	<span> Guaranteed Money </span>
		                                           	<p> KES &nbsp; <strong> 0 </strong> </p>
		                                        @endif

	                                        	@if($loan->disbursements->count())
		                                            @if($loan->state == 0)
		                                            	<span> Grace Period </span>
		                                                <p style="color:#85b4f2"> <strong> {{ $loan->created_at->addDays($loan->gracePeriod)->diffInDays() }} Days </strong> </p>
		                                            @elseif($loan->state == 1)
		                                            	<span> Grace Period </span>
		                                                <p style="color:#54e69d"> <strong> {{ $loan->created_at->addDays($loan->gracePeriod)->diffInDays() }} Days </strong> </p>
		                                            @elseif($loan->state == 2)
		                                            	<span> Loan Ageing </span>
		                                            	<p style="color:#ffc36d"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months</strong> </p>
		                                            @elseif($loan->state == 3)
		                                            	<span> Loan Ageing </span>
		                                            	<p style="color:#ff7676"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months</strong> </p>
		                                            @endif
		                                        @else
		                                        	<span> Loan Disbursements </span>
		                                            <p style="color:#ff7676"> <strong> {{ $loan->disbursements->count() }} </strong> </p>
		                                        @endif
	                                        </div>
	                                        <div class="client-info">
	                                            <div class="row">
	                                                <div class="col-4"><strong> {{ ucfirst($loan->loanType) }} </strong><br><small>Loan Type</small></div> 
	                                                <div class="col-4">
	                                                    <strong id="trey" style="color:#796AEE;"> {{ $loan->loanDuration }} Months </strong><br>
	                                                    <small>Loan Duration</small>
	                                                </div>
	                                                <div class="col-4"><strong> {{ ucfirst($loan->loanEntity) }} </strong><br><small>Loan Entity</small></div>
	                                            </div>
	                                        </div>
	                                        <div class="client-info">
	                                            <div class="row">
	                                                @if(count($loan) && $loan->state == 0)
	                                                    <a style="color:white" class="btn btn-info btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
	                                                        Loan Awating Approval.
	                                                    </a>
	                                                @elseif(count($loan) && $loan->state == 1)
	                                                    <a style="color:white" class="btn btn-success btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
	                                                        Approved Kes {{ number_format($loan->amount, 0) }}
	                                                    </a>
	                                                @elseif($member->guaranteeStatus == 1)
	                                                    <a style="color:white" class="btn btn-info btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
	                                                        Your Are a Guarantor
	                                                    </a>
	                                                @elseif(count($loan) && $loan->state == 2)
	                                                    <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-warning btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
	                                                        Mature Loan {{ number_format($loan->amount, 0) }}
	                                                    </a>
	                                                @elseif(count($loan) && $loan->state == 3)
	                                                    <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-danger btn-block" > 
	                                                        Default Loan {{ number_format($loan->amount, 0) }}
	                                                    </a>
	                                                @endif
	                                            </div>
	                                        </div>
							            </div>
							        </div>
								</div>
							@endforeach
						@elseif($member->guaranteeStatus == 1)
							@foreach($loans as $loan)
								@if($member->accountNumber == $loan['guaranteeOne'] || $member->accountNumber == $loan['guaranteeTwo'] || $member->accountNumber == $loan['guaranteeThree'])
									<div class="col-lg-4">
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
							                  	<h3 class="h4">{{ $loan->member->firstname }} &nbsp; {{ $loan->member->lastname }} </h3>
							                </div>
								          	<div class="card-body text-center">
									          	<div class="client-avatar">
	                                                <img style="width:100%; height:100px" src="{{$loan->member->memberPic}}" alt="..." class="img-fluid rounded-circle">
	                                                <div class="status bg-violet"></div>
		                                        </div>
		                                        <div class="client-title">
		                                        	@if($member->accountNumber == $loan['guaranteeOne'])
		                                        		<span> Guaranteed Money </span>
		                                        		<p> KES &nbsp; <strong> {{ number_format($loan->moneyOne) }} </strong> </p>
		                                        	@elseif($member->accountNumber == $loan['guaranteeTwo'])
		                                        		<span> Guaranteed Money </span>
		                                            	<p> KES &nbsp; <strong> {{ number_format($loan->moneyTwo) }} </strong> </p>
		                                            @elseif($member->accountNumber == $loan['guaranteeThree'])
		                                            	<span> Guaranteed Money </span>
		                                            	<p> KES &nbsp; <strong> {{ number_format($loan->moneyThree) }} </strong> </p>
		                                            @endif

		                                            @if($loan->state == 1)
		                                            	<span> Grace Period </span>
		                                                <p style="color:#54e69d"> <strong> {{ $loan->created_at->addDays($loan->gracePeriod)->diffInDays() }} Days </strong> </p>
		                                            @elseif($loan->state == 2)
		                                            	<span> Loan Ageing </span>
		                                            	<p style="color:#ffc36d"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months</strong> </p>
		                                            @elseif($loan->state == 3)
		                                            	<span> Loan Ageing </span>
		                                            	<p style="color:#ff7676"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months</strong> </p>
		                                            @endif
		                                        </div>
		                                        <div class="client-info">
		                                            <div class="row">
		                                                <div class="col-4"><strong> {{ ucfirst($loan->loanType) }} </strong><br><small>Loan Type</small></div> 
		                                                <div class="col-4">
		                                                    <strong id="trey" style="color:#796AEE;"> {{ $loan->checkNumber }} </strong><br>
		                                                    <small>Check No</small>
		                                                </div>
		                                                <div class="col-4"><strong> {{ ucfirst($loan->loanEntity) }} </strong><br><small>Loan Entity</small></div>
		                                            </div>
		                                        </div>
		                                        <div class="client-info">
		                                            <div class="row">
		                                                @if(count($loan) && $loan->state == 1)
		                                                    <a style="color:white" class="btn btn-info btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Active &nbsp; KES {{ number_format($loan->loan) }}
		                                                    </a>
		                                                @elseif(count($loan) && $loan->state == 2)
		                                                    <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-warning btn-block" id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}"> 
		                                                        Mature Loan {{ number_format($loan->loan, 0) }}
		                                                    </a>
		                                                @elseif(count($loan) && $loan->state == 3)
		                                                    <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-danger btn-block" > 
		                                                        Default Loan {{ number_format($loan->loan, 0) }}
		                                                    </a>
		                                                @endif
		                                            </div>
		                                        </div>
								            </div>
								        </div>
									</div>
								@endif
							@endforeach
						@else                 
	                        <div class="col-lg-12">
	                            <div class="client card">
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
			                            <h3 class="h4">Status</h3>
			                        </div>
	                                <div class="card-body text-center">
	                                	<p style="color:red; font-size:26px; text-align:center"> This Member is Clear At This Time. </p>
	                                </div>
	                            </div>
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
@stop