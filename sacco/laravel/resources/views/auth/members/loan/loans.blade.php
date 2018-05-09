@extends('layout.master')

@section('content')
	
<div class="page charts-page">

	<p id="message"> </p> 

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
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<!-- Client Section-->
          	<section class="client no-padding-top" style="margin-top:20px">
            	<div class="container-fluid">
              		<div class="row">
                	   <!-- Client Profile -->
                        @if(count($members))
                            @foreach($members as $member)                       
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
                                        <div class="card-body text-center">
                                            <div class="client-avatar">
                                                <a href=" {{ route('loansMember', [$member->id]) }} ">
                                                    <img style="width:100%; height:100px" src="{{$member->memberPic}}" alt="..." class="img-fluid rounded-circle">
                                                    <div class="status bg-violet"></div>
                                                </a>
                                            </div>
                                            <div class="client-title">
                                                <p> {{ $member->phoneNumber }} </p>
                                                <p> {{ $member->firstname }} &nbsp; {{ $member->lastname }} </p>
                                                {!! Form::open(['route' => ['trashMember', $member->id], 'method' => 'DELETE' ]) !!}
                                                    {!! Form::submit('Trash Member\'s Account.', ['class' => 'btn bg-violet btn-sm']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                            <div class="client-info">
                                                <div class="row">
                                                    <div class="col-4"><strong> {{ $member->user->username }} </strong><br><small>Created By</small></div> 
                                                    <div class="col-4">
                                                        <strong id="trey" style="color:#796AEE;"> {{ $member->accountType }} </strong><br>
                                                        <small>Account</small>
                                                    </div>
                                                    <div class="col-4"><strong> {{ $member->accountNumber }} </strong><br><small>Acc No</small></div>
                                                </div>
                                            </div>
                                            <div class="client-info">
                                                <div class="row">
                                                    @if($member->totals != 0)
                                                        <a id="create-loans" href="#loansmodal" data-toggle="modal" data-id="{{ $member->id }}" data-fname="{{ $member->firstname }}" data-lname="{{ $member->lastname }}" class="btn btn-warning btn-block" > Create Loans.</a>
                                                    @elseif($member->totals == 0)
                                                        <a style="color:white" class="btn btn-info btn-block"> 
                                                            Your Deposits are NILL.
                                                        </a>
                                                    @endif

                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                        @else
                            <div class="container">
                                <p style="color:red; text-align:center"> There are No Registered Members at this Time. </p>
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