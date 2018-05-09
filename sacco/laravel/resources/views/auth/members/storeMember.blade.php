@extends('layout.master')

@section('content')


<div class="page charts-page">
	
	@include('layout.navigation')

	<div class="page-content d-flex align-items-stretch"> 
    
       @include('layout.membersBar')

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Member Accounts</h2>
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
	              		<a href=" {{ route('memberAccount') }} ">
	              			Member Accounts
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">Save a New Member</li>

              		<li id="show-here" class="breadcrumb-item active"></li>
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

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
				                  	<h3 class="h4">Finish Up</h3>
				                </div>
	                			<div class="card-body col-md-12" style="text-align:center"> <br><br>

	                				{!! Form::open(['route' => ['storeMember'], 'method' => 'POST', 'class' => 'dropzone', 'id' => 'addImages' ]) !!}
		                				
		                				<!-- pass in the hidden fields. -->
		                				{!! Form::hidden('firstname', $firstname) !!}
		                				{!! Form::hidden('surname', $surname) !!}
		                				{!! Form::hidden('lastname', $lastname) !!}
		                				{!! Form::hidden('accountType', $accountType) !!}
		                				{!! Form::hidden('maritalStatus', $maritalStatus) !!}
		                				{!! Form::hidden('occupation', $occupation) !!}
		                				{!! Form::hidden('gender', $gender) !!}
		                				{!! Form::hidden('bankName', $bankName) !!}
		                				{!! Form::hidden('bankAccountName', $bankAccountName) !!}
		                				{!! Form::hidden('bankAccountNumber', $bankAccountNumber) !!}
		                				{!! Form::hidden('phoneNumber', $phoneNumber) !!}
		                				{!! Form::hidden('idNumber', $idNumber) !!}
		                				{!! Form::hidden('dateOfBirth', $dateOfBirth) !!}
		                				{!! Form::hidden('emailAddress', $emailAddress) !!}
		                				{!! Form::hidden('poBox', $poBox) !!}
		                				{!! Form::hidden('county', $county) !!}
		                				{!! Form::hidden('nationality', $nationality) !!}

		                				{!! Form::hidden('firstnameKin', $firstnameKin) !!}
		                				{!! Form::hidden('surnameKin', $surnameKin) !!}
		                				{!! Form::hidden('lastnameKin', $lastnameKin) !!}
		                				{!! Form::hidden('maritalStatusKin', $maritalStatusKin) !!}
		                				{!! Form::hidden('occupationKin', $occupationKin) !!}
		                				{!! Form::hidden('genderKin', $genderKin) !!}
		                				{!! Form::hidden('relationshipKin', $relationshipKin) !!}
		                				{!! Form::hidden('phoneNumberKin', $phoneNumberKin) !!}
		                				{!! Form::hidden('idNumberKin', $idNumberKin) !!}
		                				{!! Form::hidden('dateOfBirthKin', $dateOfBirthKin) !!}
		                				{!! Form::hidden('emailAddressKin', $emailAddressKin) !!}
		                				{!! Form::hidden('poBoxKin', $poBoxKin) !!}
		                				{!! Form::hidden('countyKin', $countyKin) !!}
		                				{!! Form::hidden('nationalityKin', $nationalityKin) !!}
		                				

		                			{!! Form::close() !!}
		                		</div>
	              			</div>
	            		</div>
	            		<!-- Form Elements -->
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

    <script type="text/javascript">
	    $(function() {

	        var myDropzone = new Dropzone("#addImages"); // this will create instance of Dropzone on the #dz element

	        myDropzone.on("addedfile", function(file) {

	            location.href = 'http://sacco.dev/dashboard';  // this will redirect you when the file is added to dropzone
	        });
	    });
	</script>
</div>


	
	<!-- {{ $firstname }} <br>
	{{ $surname }} <br>
	{{ $lastname }} <br>
	{{ $phoneNumber }} <br>
	{{ $idNumber }} <br>
	{{ $dateOfBirth }} <br>
	{{ $emailAddress }} <br>
	{{ $poBox }} <br>
	{{ $county }} <br>
	{{ $nationality }} <br>

	<p> Next of Kin </p>

	{{ $firstnameKin }} <br>
	{{ $surnameKin }} <br>
	{{ $lastnameKin }} <br>
	{{ $phoneNumberKin }} <br>
	{{ $idNumberKin }} <br>
	{{ $dateOfBirthKin }} <br>
	{{ $emailAddressKin }} <br>
	{{ $poBoxKin }} <br>
	{{ $countyKin }} <br>
	{{ $nationalityKin }} <br> --> 

@stop