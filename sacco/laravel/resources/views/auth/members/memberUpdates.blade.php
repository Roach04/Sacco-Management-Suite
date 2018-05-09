@extends('layout.master')

@section('content')
	
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 

  		@include('layout.memberUpdatesBar')
    
        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Members Accounts</h2>
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
	              			Members Accounts
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">
	              		Members Updates
              		</li>
              		@if($accounts)
              		<div class="pull-right">
		                <span style="color: grey"> Latest Update &nbsp; </span> 
		                <span style="color:#796AEE; font:normal 18px book antiqua"> 
		                    {{ $last }} 
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
		                    <span style="color:black"> | </span>
		                    {{ $currenttime }}
		                </span>
		                
		            </div>
		            @endif
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<br><br>

          	<div style="padding:30px">
	          	<form action="{{ route('memberUpdate', [$member->id]) }}" method="post"> 
	          		{{ csrf_field() }}
	                <div class="row"> 
	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Firstname.</label>
	                        <input value="{{ $member->firstname }}" name="firstname" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('firstname'))
		                            {{ $errors->first('firstname') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Surname.</label>
	                        <input value="{{ $member->surname }}" name="surname" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('surname'))
		                            {{ $errors->first('surname') }}
		                        @endif
		                    </span>
	                    </div>
	                    
	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Lastname.</label>
	                        <input value="{{ $member->lastname }}" name="lastname" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('lastname'))
		                            {{ $errors->first('lastname') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Account Number.</label>
	                        <input value="{{ $member->accountNumber }}" readonly="readonly" name="accountNumber" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('accountNumber'))
		                            {{ $errors->first('accountNumber') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Account Type.</label>
	                        <input value="{{ $member->accountType }}" name="accountType" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('accountType'))
		                            {{ $errors->first('accountType') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Marital Status.</label>
	                        <input value="{{ $member->maritalStatus }}" name="maritalStatus" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('maritalStatus'))
		                            {{ $errors->first('maritalStatus') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Occupation.</label>
	                        <input value="{{ $member->occupation }}" name="occupation" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('occupation'))
		                            {{ $errors->first('occupation') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Gender.</label>
	                        <input value="{{ $member->gender }}" name="gender" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('gender'))
		                            {{ $errors->first('gender') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Bank Name.</label>
	                        <input value="{{ $member->bankName }}" name="bankName" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('bankName'))
		                            {{ $errors->first('bankName') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Bank Account Name.</label>
	                        <input value="{{ $member->bankAccountName }}" name="bankAccountName" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('bankAccountName'))
		                            {{ $errors->first('bankAccountName') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Bank Account Number.</label>
	                        <input value="{{ $member->bankAccountNumber }}" name="bankAccountNumber" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('bankAccountNumber'))
		                            {{ $errors->first('bankAccountNumber') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Phone Number.</label>
	                        <input value="{{ $member->phoneNumber }}" name="phoneNumber" type="number" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('phoneNumber'))
		                            {{ $errors->first('phoneNumber') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> ID Number.</label>
	                        <input value="{{ $member->idNumber }}" name="idNumber" type="number" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('idNumber'))
		                            {{ $errors->first('idNumber') }}
		                        @endif
		                    </span>
	                    </div>
	                    
	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Date Of Birth.</label>
	                        <input value="{{ $member->dateOfBirth }}" name="dateOfBirth" type="date" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('dateOfBirth'))
		                            {{ $errors->first('dateOfBirth') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Po Box.</label>
	                        <input value="{{ $member->poBox }}" name="poBox" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('poBox'))
		                            {{ $errors->first('poBox') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Email Address.</label>
	                        <input value="{{ $member->emailAddress }}" name="emailAddress" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('emailAddress'))
		                            {{ $errors->first('emailAddress') }}
		                        @endif
		                    </span>
	                    </div>
	                    
	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> County.</label>
	                        <input value="{{ $member->county }}" name="county" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('county'))
		                            {{ $errors->first('county') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Nationality.</label>
	                        <input value="{{ $member->nationality }}" name="nationality" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('nationality'))
		                            {{ $errors->first('nationality') }}
		                        @endif
		                    </span>
	                    </div> 
	                </div>

	                <div style="width: 100%; height: 1px; border-bottom: 1px dashed #eee; margin: 30px 0;"></div>

	                <p style="font:bold 28px book antiqua"> Next of Kin. </p><br>
	                <div class="row"> 
	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Firstname.</label>
	                        <input value="{{ $member->firstnameKin }}" name="firstnameKin" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('firstnameKin'))
		                            {{ $errors->first('firstnameKin') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Surname.</label>
	                        <input value="{{ $member->surnameKin }}" name="surnameKin" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('surnameKin'))
		                            {{ $errors->first('surnameKin') }}
		                        @endif
		                    </span>
	                    </div>
	                    
	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Lastname.</label>
	                        <input value="{{ $member->lastnameKin }}" name="lastnameKin" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('lastnameKin'))
		                            {{ $errors->first('lastnameKin') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Marital Status.</label>
	                        <input value="{{ $member->maritalStatusKin }}" name="maritalStatusKin" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('maritalStatusKin'))
		                            {{ $errors->first('maritalStatusKin') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Occupation.</label>
	                        <input value="{{ $member->occupation }}" name="occupationKin" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('occupationKin'))
		                            {{ $errors->first('occupationKin') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Gender.</label>
	                        <input value="{{ $member->genderKin }}" name="genderKin" type="text" class="form-control">
                        	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('genderKin'))
		                            {{ $errors->first('genderKin') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Phone Number.</label>
	                        <input value="{{ $member->phoneNumberKin }}" name="phoneNumberKin" type="number" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('phoneNumberKin'))
		                            {{ $errors->first('phoneNumberKin') }}
		                        @endif
		                    </span>
	                    </div>

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> ID Number.</label>
	                        <input value="{{ $member->idNumberKin }}" name="idNumberKin" type="number" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('idNumberKin'))
		                            {{ $errors->first('idNumberKin') }}
		                        @endif
		                    </span>
	                    </div>
	                    
	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Date Of Birth.</label>
	                        <input value="{{ $member->dateOfBirthKin }}" name="dateOfBirthKin" type="date" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('dateOfBirthKin'))
		                            {{ $errors->first('dateOfBirthKin') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Relationship with Kin.</label>
	                        <input value="{{ $member->relationshipKin }}" name="relationshipKin" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('relationshipKin'))
		                            {{ $errors->first('relationshipKin') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Po Box.</label>
	                        <input value="{{ $member->poBoxKin }}" name="poBoxKin" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('poBoxKin'))
		                            {{ $errors->first('poBoxKin') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Email Address.</label>
	                        <input value="{{ $member->emailAddressKin }}" name="emailAddressKin" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('emailAddressKin'))
		                            {{ $errors->first('nationality') }}
		                        @endif
		                    </span>
	                    </div>
	                    
	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> County.</label>
	                        <input value="{{ $member->countyKin }}" name="countyKin" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('countyKin'))
		                            {{ $errors->first('countyKin') }}
		                        @endif
		                    </span>
	                    </div> 

	                    <div class="col-md-3 col-sm-4 form-group-material">
	                        <label class="label-control"> Nationality.</label>
	                        <input value="{{ $member->nationalityKin }}" name="nationalityKin" type="text" class="form-control">
	                    	<!-- VALIDATION.. -->
		                    <span style="font:normal 20px book antiqua; color:red">
		                        @if($errors->has('nationalityKin'))
		                            {{ $errors->first('nationalityKin') }}
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
            </div>

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