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
	              <h2 class="no-margin-bottom">Defaulted Loans</h2>
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
		            <div class="pull-right">
		                <span style="color: grey"> Today &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{$today}}
		                </span>
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Time &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{$currenttime}}
		                </span>		
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Total Installments &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                	{{ number_format($maturity, 2) }}
		                </span>                
		            </div>
		            
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>

			<!-- Client Section-->
          	<section class="client no-padding-top" style="margin-top:20px" id="activeLoans">
            	<div class="container-fluid">
              		<div class="row">
                	    <!-- Client Profile -->          
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
                                    <h3 class="h4">Defaulted Loans</h3>
                                </div>
                                <div class="card-body text-center">
                                    @if(count($defaulters))
                                        @foreach($defaulters as $loan)
                                            <div class="client-avatar">
                                                <a >
                                                    <img style="width:100%; height:100px" src="{{$loan->member->memberPic}}" alt="..." class="img-fluid rounded-circle">
                                                    <div class="status bg-violet"></div>
                                                </a>
                                            </div>
                                            <div class="client-title">
                                                <p> {{ $loan->member->phoneNumber }} </p>
                                                <p> {{ $loan->member->emailAddress }} </p>
                                                {!! Form::open(['route' => ['trashMember', $loan->member->id], 'method' => 'DELETE' ]) !!}
                                                    {!! Form::submit('Trash Member\'s Account.', ['class' => 'btn bg-violet btn-sm']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                            <div class="client-info">
                                                <div class="row">
                                                    <div class="col-4"><strong> {{ $loan->member->user->username }} </strong><br><small>Created By</small></div> 
                                                    <div class="col-4">
                                                        <strong id="trey" style="color:#796AEE;"> {{ $loan->member->accountType }} </strong><br>
                                                        <small>Account</small>
                                                    </div>
                                                    <div class="col-4"><strong> {{ $loan->member->id }} </strong><br><small>Id</small></div>
                                                </div>
                                            </div>
                                            <div class="client-info">
                                                <div class="row">
                                                    @if($loan->member->guaranteeStatus != 1 && $loan->member->loanStatus != 1)
                                                        <a id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $loan->member->id }}" data-fname="{{ $loan->member->firstname }}" data-lname="{{ $loan->member->lastname }}" class="btn btn-warning btn-block" > Create Loans.</a>
                                                    @elseif(count($loan) && $loan->state == 0)
                                                        <a style="color:white" class="btn btn-info btn-block" > 
                                                            Loan Awating Approval.
                                                        </a>
                                                    @elseif(count($loan) && $loan->state == 1)
                                                        <a style="color:white" class="btn btn-success btn-block" > 
                                                            Active Kes {{ number_format($loan->loan, 0) }}
                                                        </a>
                                                    @elseif(count($loan) && $loan->state == 2)
                                                        <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-warning btn-block" > 
                                                            Mature Loan {{ number_format($loan->loan, 0) }}
                                                        </a>
                                                    @elseif(count($loan) && $loan->state == 3)
                                                        <a style="font:bold 18px book antiqua; color:lavender" class="btn btn-danger btn-block" > 
                                                            Default Loan {{ number_format($loan->loan, 0) }}
                                                        </a>
                                                    @elseif($loan->member->guaranteeStatus == 1)
                                                        <a style="color:white" class="btn btn-info btn-block" > 
                                                            Your Are a Guarantor
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach 
                                    @else
                                        <div class="container">
                                            <p style="color:red; font-size:26px; text-align:center"> There are No Loan Defaulters at this Time. </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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
	
@stop