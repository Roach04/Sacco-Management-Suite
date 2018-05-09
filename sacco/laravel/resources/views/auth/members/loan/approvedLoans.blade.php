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
                        Loan Updates
                    </li>
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<!-- Client Section-->
          	<section class="client no-padding-top" style="margin-top:20px">
            	<div class="container-fluid">
              		<div class="row">
                	   <!-- Client Profile --> 
                       @if(count($approvedLoans))
                            @foreach($approvedLoans as $loan)      
                                <div class="col-lg-4">
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
                                            <h3 class="h4">Approved Loans</h3>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="client-avatar">
                                                <a href=" {{ route('showLoan', [$loan->id]) }} ">
                                                    <img style="width:100%; height:100px" src="{{$loan->member->memberPic}}" alt="..." class="img-fluid rounded-circle">
                                                    <div class="status bg-violet"></div>
                                                </a>
                                            </div>
                                            <div class="client-title">
                                                <span> Loan Amount </span>
                                                	<p> KES &nbsp; <strong>{{ number_format($loan->amount) }}</strong> </p>
                                                    @if($loan->member->accountNumber == $loan['guaranteeOne'])
                                                		<span> Guaranteed Money </span>
                                                		<p> KES &nbsp; <strong> {{ number_format($loan->moneyOne) }} </strong> </p>
                                                	@elseif($loan->member->accountNumber == $loan['guaranteeTwo'])
                                                		<span> Guaranteed Money </span>
                                                    	<p> KES &nbsp; <strong> {{ number_format($loan->moneyTwo) }} </strong> </p>
                                                    @elseif($loan->member->accountNumber == $loan['guaranteeThree'])
                                                    	<span> Guaranteed Money </span>
                                                    	<p> KES &nbsp; <strong> {{ number_format($loan->moneyThree) }} </strong> </p>
                                                    @endif

                                                    @if($loan->disbursements->count())
                                                        @if($loan->created_at->addDays($loan->gracePeriod)->diffInDays() > 0)
                                                        	<span> Grace Period </span>
                                                            <p style="color:#54e69d"> <strong> {{ $loan->created_at->addDays($loan->gracePeriod)->diffInDays() }} Days </strong> </p>
                                                        @elseif($loan->created_at->addDays($loan->gracePeriod)->diffInDays() == 0 && $loan->state == 3)
                                                        	<span> Loan Ageing </span>
                                                        	<p style="color:#ff7676"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months </strong> </p>
                                                         @elseif($loan->created_at->addDays($loan->gracePeriod)->diffInDays() == 0)
                                                        	<span> Loan Ageing </span>
                                                        	<p style="color:#ffc36d"> <strong> {{ $loan->created_at->addMonths($loan->loanDuration)->diffInMonths() }} Months </strong> </p>
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
                                                        <a style="color:white" class="btn btn-info btn-block" > 
                                                            Loan Awating Approval.
                                                        </a>
                                                    @elseif(count($loan) && $loan->state == 1)
                                                        <a style="color:white" class="btn btn-success btn-block" > 
                                                            Active Kes {{ number_format($loan->loan, 0) }}
                                                        </a>
                                                    @elseif(count($loan) && $loan->state == 2)
                                                        <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-warning btn-block"> 
                                                            Mature Loan {{ number_format($loan->loan, 0) }}
                                                        </a>
                                                    @elseif(count($loan) && $loan->state == 3)
                                                        <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-danger btn-block"> 
                                                            Loan Defaulter  {{ number_format($loan->loan, 0) }}
                                                        </a>
                                                    @elseif($member->guaranteeStatus == 1)
                                                        <a style="color:white" class="btn btn-info btn-block"> 
                                                            Your Are a Guarantor
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>   
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
                                        <h3 class="h4">Approved Loans</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <p style="color:#54e69d; font-size:26px; text-align:center"> There are No Approved Loans at this Time. </p>
                                    </div>
                                </div>
                            </div>
                        @endif                         
                        <script>
                            var token = '{{ Session::token() }}';
                        </script>
                        <!-- Client Profile -->
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

@include('Modals.loansModal');

@stop