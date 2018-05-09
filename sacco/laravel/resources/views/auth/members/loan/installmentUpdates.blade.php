@extends('layout.master')

@section('content')
	
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
    
        <div style="width:100%">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Member Installments</h2>
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
	              		Member Updates
              		</li>
              		@if($loan)
              		<div class="pull-right">
		                <span style="color: grey"> Latest Update &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ $last }} 
		                </span>
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Installments &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ number_format($cash, 2) }} 
		                </span>
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Loan &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                	@if($status == 0)
		                		Pending
		                	@elseif($status ==1)
		                		Matured
		                	@elseif($status == 2)
		                		Reimbursement
		                	@elseif($status == 3)
		                		Defaulter
		                	@elseif($status == 4)
		                		Cleared
		                	@endif
		                    <!-- {{ number_format($cash, 2) }} --> 
		                </span>
		            </div>
		            @else
		            <div class="pull-right">
		                <span style="color: grey"> Today &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{$today}}
		                </span>
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Cash &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ number_format($cash, 2) }} 
		                </span>		
		                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
		                <span style="color:grey"> Loan &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                	NILL
		                </span>                
		            </div>
		            @endif
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>

          	@if(count($loan->installments))
          		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding:30px"> 
          			<div class="card-body">
          				<table class="table table-striped">
		                    <thead>
		                      	<tr>
			                        <th>#</th>
			                        <th>Account Number</th>
			                        <th>Bank Name</th>
			                        <th>Bank Account Name</th>
			                        <th>Loan</th>
			                        <th>Member Installment</th>
			                        <th>Months Left</th>
			                        <th>Creation Date</th>
			                        <th>Edit</th>
		                      	</tr>
		                    </thead>
				          	@foreach($installs as $install)
				          		<tbody>
		                			<tr>
				                        <th scope="row">1</th>
				                        <td>{{ $install->loan->member->accountNumber }}</td>
				                        <td>{{ $install->loan->member->bankName }}</td>
				                        <td>{{ $install->loan->member->bankAccountName }}</td>
				                        <td>{{ number_format($install->loan->loan) }}</td>
				                        <td style="font-weight:bold; color:#ffc36d">{{ number_format($install->installment,2) }}</td>
				                        
				                        <td>{{ $install->daysLeft }} Days</td>
				                        
				                        <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($loan->created_at))->formatlocalized('%a %d %b %y') }}</td>
				                        <td> 
				                        	<a id="installationUpdating" data-bankAccountName="{{ $install->loan->member->bankAccountName }}" data-installment="{{ $install->installment }}" data-id="{{ $install->id }}" href="#installmentupdatemodal" data-toggle="modal" class="btn btn-warning"> 
				                        		Updates 
				                        	</a> 
				                        </td>
			                      	</tr>
		                		</tbody>
				          	@endforeach
				        </table>
		            </div>
          		</div>
            @else
            	<div class="container">
                    <p style="color:red; font-size:26px; text-align:center"> This Member Has No Installments. </p>
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

@include('Modals.installmentUpdateModal')

@stop