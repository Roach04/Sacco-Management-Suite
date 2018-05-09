@extends('layout.master')

@section('content')

<div class="page charts-page">
	
	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
    
       @include('layout.accountsBar')

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Accounts</h2>
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
	              		<a href=" {{ route('sysAccounts') }} ">
	              			System Accounts
	              		</a>
              		</li>
              		<li class="breadcrumb-item active">New User</li>
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
	                			<div class="card-body">

	                				{!! Form::open(['route' => ['saveAccount'], 'method'=>'POST']) !!}
	                					<div class="row">
					                      	<label class="col-sm-3 form-control-label">Your Names</label>
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
						                          	{!! Form::text('jobTitle', null, ['class'=> 'input-material'])!!}
						                          	
						                          	{!! Form::label('jobTitle', 'Job Title.', ['class'=> 'label-material']) !!}
						                          	<br>
						                          	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('jobTitle'))
								                            {{ $errors->first('jobTitle') }}
								                        @endif
								                    </span>
						                        </div>

					                      	</div>
					                    </div>
					                    <div class="line"></div>
					                    
					                    <div class="row">
					                      	<label class="col-sm-3 form-control-label">System Use</label>
					                      	<div class="col-sm-9">
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
						                        <div class="form-group-material {{ $errors->has('username') ? 'has-error' : '' }}">
						                          	{!! Form::text('username', null, ['class'=> 'input-material'])!!}
						                          	
						                          	{!! Form::label('username', 'Username.', ['class'=> 'label-material']) !!}
						                          	<br>
						                          	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('username'))
								                            {{ $errors->first('username') }}
								                        @endif
								                    </span>
						                        </div>
					                      	</div>
					                    </div>
					                    <div class="line"></div>
					                    <div class="row">
					                      	<label class="col-sm-3 form-control-label">Passwords</label>
					                      	<div class="col-sm-9">
						                        <div class="form-group-material {{ $errors->has('password') ? 'has-error' : '' }}">
						                        	{!! Form::password('password',['class'=> 'input-material'])!!}
						                          	
						                          	{!! Form::label('password', 'Password.', ['class'=> 'label-material']) !!}
						                          	<br>
						                          	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('password'))
								                            {{ $errors->first('password') }}
								                        @endif
								                    </span>
						                        </div>
						                        <div class="form-group-material">
						                          	{!! Form::password('confirmPassword',['class'=> 'input-material'])!!}
						                          	
						                          	{!! Form::label('confirmPassword', 'Confirm Password.', ['class'=> 'label-material']) !!}
						                          	<br>
						                          	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('confirmPassword'))
								                            {{ $errors->first('confirmPassword') }}
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
</div>

@stop