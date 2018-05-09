@extends('layout.master')

@section('content')

<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
    
        <div style="width:100%">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Matured Loans</h2>
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
	              		<a href=" {{ route('maturedLoans') }} ">
	              			Matured Loans
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		Pay Installments
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

          	@if(count($loaners))
          		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:30px"> 
          			<div class="card-body">
          				<table class="table table-striped">
		                    <thead>
		                      	<tr>
			                        <th>#</th>
			                        <th>First Name</th>
			                        <th>Last Name</th>
			                        <th>Account Number</th>
			                        <th>Bank Name</th>
			                        <th>Bank Account Name</th>
			                        <th>Loan</th>
			                        <th>Member Installments</th>
			                        <th>Loan Duration</th>
			                        <th>Creation Date</th>
			                        <th>Monthly Installment</th>
			                        <th>Installments</th>
			                        @if(!$count == 0)
			                        	<th>Updates</th>
			                        @endif
		                      	</tr>
		                    </thead>
		                    @foreach($loaners as $loaner)
			                    <tbody>
			                      	<tr>
				                        <th scope="row">1</th>
				                        <td>{{ $loaner->firstname }}</td>
				                        <td>{{ $loaner->lastname }}</td>
				                        <td>{{ $loaner->accountNumber }}</td>
				                        <td>{{ $loaner->bankName }}</td>
				                        <td>{{ $loaner->bankAccountName }}</td>
				                        <td>{{ number_format($loaner->loan->loan) }}</td>
				                        <td style="font-weight:bold; color:#ffc36d">{{ number_format($loaner->loan->totalInstallments, 2) }}</td>
				                        
				                        <td>{{ $daysPass }} Days</td>
				                        
				                        <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($loaner->loan->created_at))->diffForHumans() }}</td>
				                        <td>{{ number_format($loaner->loan->monthlyInstallment) }}</td>
				                        <td> 
				                        	<a id="modal-installments" data-toggle="modal" data-id="{{$loaner->loan->id}}" data-account="{{ $loaner->accountNumber }}" data-fname="{{$loaner->firstname}}" data-lname="{{ $loaner->lastname }}" href="#installmentsmodal" class="btn btn-warning"> 
				                        		Insertions 
				                        	</a> 
				                        </td>
				                        @if(!$count == 0)
					                        <td> 
					                        	<a href="{{ route('installmentUpdates', [$loaner->id]) }}" class="btn btn-primary"> 
					                        		Updates 
					                        	</a> 
					                        </td>
				                        @endif
			                      	</tr>
			                    </tbody>
		                    @endforeach
		                </table>
		            </div>
          		</div>
          	@else
          		<div class="container">
                    <p style="color:red; font-size:26px; text-align:center"> There Are No Mature Loans. </p>
                </div>
          	@endif

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

@include('Modals.installmentsModal')

@stop