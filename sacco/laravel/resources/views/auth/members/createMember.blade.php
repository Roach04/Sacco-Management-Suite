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
	              		<a>
	              			Add New Members
	              		</a>
              		</li>
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
				                  	<h3 class="h4">Enter User Details</h3>
				                </div>
				                {!! Form::open(['route' => ['saveMember'], 'method'=>'POST']) !!}
	                			<div class="card-body">
                					<div class="row">
				                      	<label class="col-sm-3 form-control-label">Member Names</label>
				                      	<div class="col-sm-9">
					                        <div class="form-group-material">
					                        	{!! Form::text('firstname', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('firstname', 'Firstname.', ['class'=> 'label-material']) !!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('firstname'))
							                            {{ $errors->first('firstname') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('surname', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('surname', 'Surname.', ['class'=> 'label-material']) !!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('surname'))
							                            {{ $errors->first('surname') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('lastname', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('lastname', 'Lastname.', ['class'=> 'label-material']) !!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('lastname'))
							                            {{ $errors->first('lastname') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>
				                    <div class="line"></div>
				                    <div class="row">
				                      	<label class="col-sm-3 form-control-label">Personal Use</label>
				                      	<div class="col-sm-9">
				                      		<div class="form-group-material">
				                      			{!! Form::label('accountType', 'Account Type.', ['class'=> 'label-control']) !!}

					                        	{!! Form::select('accountType', [
													'fixed'   => 'Fixed Deposit Account',
													'savings' => 'Savings Account',
													'assets'  => 'Assets Account'
												], null, ['class'=> 'form-control'])!!}					                          	
					                        	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('accountType'))
							                            {{ $errors->first('accountType') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                        	{!! Form::number('phoneNumber', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('phoneNumber', 'Phone Number.', ['class'=> 'label-material']) !!}
					                        	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('phoneNumber'))
							                            {{ $errors->first('phoneNumber') }}
							                        @endif
							                    </span>
					                        </div>
					                        
					                        <div class="form-group-material">
					                          	{!! Form::number('idNumber', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('idNumber', 'Id Number.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('idNumber'))
							                            {{ $errors->first('idNumber') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::date('dateOfBirth', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('dateOfBirth', 'Date Of Birth.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('dateOfBirth'))
							                            {{ $errors->first('dateOfBirth') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>
				                    <div class="line"></div>

				                    <div class="row">
				                      	<label class="col-sm-3 form-control-label">Personal Status</label>
				                      	<div class="col-sm-9">
				                      		<div class="form-group-material">
				                      			{!! Form::label('maritalStatus', 'Marital Status.', ['class'=> 'label-control']) !!}

					                        	{!! Form::select('maritalStatus', [
													'single'  => 'Single',
													'married' => 'Married',
													'widow'   => 'Widow'
												], null, ['class'=> 'form-control'])!!}					                          	
					                        	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('maritalStatus'))
							                            {{ $errors->first('maritalStatus') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                        	{!! Form::text('occupation', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('occupation', 'Occupation.', ['class'=> 'label-material']) !!}
					                        	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('occupation'))
							                            {{ $errors->first('occupation') }}
							                        @endif
							                    </span>
					                        </div>
					                        
					                        <div class="form-group-material">			                          	
					                          	{!! Form::label('gender', 'Gender.', ['class'=> 'label-control']) !!}
					                          	<br>
					                          	Male &nbsp; &nbsp;&nbsp;&nbsp; {!! Form::radio('gender', 'male', ['class' => 'form-control']) !!}<br><br>
												Female &nbsp;{!! Form::radio('gender', 'female', ['class' => 'form-control']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('gender'))
							                            {{ $errors->first('gender') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('bankName', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('bankName', 'Bank Name.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('bankName'))
							                            {{ $errors->first('bankName') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('bankAccountName', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('bankAccountName', 'Bank Account Name.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('bankAccountName'))
							                            {{ $errors->first('bankAccountName') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('bankAccountNumber', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('bankAccountNumber', 'Bank Account Number.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('bankAccountNumber'))
							                            {{ $errors->first('bankAccountNumber') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>
				                    <div class="line"></div>
				                    
				                    <div class="row">
				                      	<label class="col-sm-3 form-control-label">Member Contacts</label>
				                      	<div class="col-sm-9">
				                      		<div class="form-group-material">
					                          	{!! Form::text('poBox', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('poBox', 'Po Box.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('poBox'))
							                            {{ $errors->first('poBox') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material {{ $errors->has('emailAddress') ? 'has-error' : '' }}">
					                        	{!! Form::text('emailAddress', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('emailAddress', 'Email Address.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('emailAddress'))
							                            {{ $errors->first('emailAddress') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material {{ $errors->has('county') ? 'has-error' : '' }}">
					                          	{!! Form::text('county', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('county', 'County.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('county'))
							                            {{ $errors->first('county') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material {{ $errors->has('password') ? 'has-error' : '' }}">
					                        	{!! Form::text('nationality', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('nationality', 'Nationality.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('nationality'))
							                            {{ $errors->first('nationality') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>
		                		</div>
	              			</div>
	            		</div>

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
				                  	<h3 class="h4">Enter Next Of Kin Details</h3>
				                </div>
	                			<div class="card-body">
                					<div class="row">
				                      	<label class="col-sm-3 form-control-label">Next of Kin Names</label>
				                      	<div class="col-sm-9">
					                        <div class="form-group-material">
					                        	{!! Form::text('firstnameKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('firstnameKin', 'Firstname.', ['class'=> 'label-material']) !!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('firstnameKin'))
							                            {{ $errors->first('firstnameKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('surnameKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('surnameKin', 'Surname.', ['class'=> 'label-material']) !!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('surnameKin'))
							                            {{ $errors->first('surnameKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('lastnameKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('lastnameKin', 'Lastname.', ['class'=> 'label-material']) !!}
					                          	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('lastnameKin'))
							                            {{ $errors->first('lastnameKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::number('idNumberKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('idNumberKin', 'Id Number.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('idNumberKin'))
							                            {{ $errors->first('idNumberKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::date('dateOfBirthKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('dateOfBirthKin', 'Date Of Birth.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('dateOfBirthKin'))
							                            {{ $errors->first('dateOfBirthKin') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>
				                    <div class="line"></div>

				                    <div class="row">
				                      	<label class="col-sm-3 form-control-label">Next of Kin Status</label>
				                      	<div class="col-sm-9">
				                      		<div class="form-group-material">
				                      			{!! Form::label('maritalStatusKin', 'Marital Status.', ['class'=> 'label-control']) !!}

					                        	{!! Form::select('maritalStatusKin', [
													'single'  => 'Single',
													'married' => 'Married',
													'widow'   => 'Widow'
												], null, ['class'=> 'form-control'])!!}					                          	
					                        	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('maritalStatusKin'))
							                            {{ $errors->first('maritalStatusKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                        	{!! Form::text('occupationKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('occupationKin', 'Occupation.', ['class'=> 'label-material']) !!}
					                        	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('occupationKin'))
							                            {{ $errors->first('occupationKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        
					                        <div class="form-group-material">			                          	
					                          	{!! Form::label('genderKin', 'Gender.', ['class'=> 'label-control']) !!}
					                          	<br>
					                          	Male &nbsp; &nbsp;&nbsp;&nbsp; {!! Form::radio('genderKin', 'male', ['class' => 'form-control']) !!}<br><br>
												Female &nbsp;{!! Form::radio('genderKin', 'female', ['class' => 'form-control']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('genderKin'))
							                            {{ $errors->first('genderKin') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>
				                    <div class="line"></div>
				                    
				                    <div class="row">
				                      	<label class="col-sm-3 form-control-label">Next of Kin Contacts</label>
				                      	<div class="col-sm-9">
				                      		<div class="form-group-material">
					                        	{!! Form::text('relationshipKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('relationshipKin', 'Relationship with Kin.', ['class'=> 'label-material']) !!}
					                        	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('relationshipKin'))
							                            {{ $errors->first('relationshipKin') }}
							                        @endif
							                    </span>
					                        </div>
				                      		<div class="form-group-material">
					                        	{!! Form::number('phoneNumberKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('phoneNumberKin', 'Phone Number.', ['class'=> 'label-material']) !!}
					                        	<br>
					                        	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('phoneNumberKin'))
							                            {{ $errors->first('phoneNumberKin') }}
							                        @endif
							                    </span>
					                        </div>
				                      		<div class="form-group-material">
					                          	{!! Form::text('poBoxKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('poBoxKin', 'Po Box.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('poBoxKin'))
							                            {{ $errors->first('poBoxKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                        	{!! Form::text('emailAddressKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('emailAddressKin', 'Email Address.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('emailAddressKin'))
							                            {{ $errors->first('emailAddressKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                          	{!! Form::text('countyKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('countyKin', 'County.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('countyKin'))
							                            {{ $errors->first('countyKin') }}
							                        @endif
							                    </span>
					                        </div>
					                        <div class="form-group-material">
					                        	{!! Form::text('nationalityKin', null, ['class'=> 'input-material'])!!}
					                          	
					                          	{!! Form::label('nationalityKin', 'Nationality.', ['class'=> 'label-material']) !!}
					                          	<br>
					                          	<!-- VALIDATION.. -->
							                    <span style="font:normal 20px book antiqua; color:red">
							                        @if($errors->has('nationalityKin'))
							                            {{ $errors->first('nationalityKin') }}
							                        @endif
							                    </span>
					                        </div>
				                      	</div>
				                    </div>
				                    <div class="line"></div>
					       

				                    <div class="form-group row">
				                      	<div class="col-sm-4 offset-sm-3">
				                        	{!! Form::reset('Cancel', ['class' => 'btn btn-secondary']) !!}
				                        	
				                        	{!! Form::submit('Save and Continue', ['class' => 'btn btn-primary']) !!}
				                      	</div>
				                    </div>
		                		</div>
	              			</div>
	            		</div>
	            		{!! Form::close() !!}
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
</div>
@stop