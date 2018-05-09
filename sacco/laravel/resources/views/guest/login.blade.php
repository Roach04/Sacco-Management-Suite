@extends('layout.master')

@section('content')

<div class="login-page" style="margin-top:-20px">
  	<div class="container d-flex align-items-center">
    	<div class="form-holder has-shadow">
      		<div class="row">
            	<!-- Logo & Information Panel-->
            	<div class="col-lg-6">
	              	<div class="info d-flex align-items-center">
		                <div class="content">
		                  	<div class="logo">
		                    	<span style="font:bold 60px bradley hand itc; color:lavender">Paa Tech</span>
		                  	</div>
		                  	<p style="color:lavender"> A Sacco Management Suite.</p>
		                </div>
	              	</div>
            	</div>

	            <!-- Form Panel    -->
	            <div class="col-lg-6 bg-white">
	                <div class="form d-flex align-items-center">
	                    <div class="content">
	                    {!! Form::open(['route' => ['access'], 'method' => 'post']) !!}
	                    	<div class="form-group">
	                    		{!! Form::text('emailAddress', null,['class' => 'input-material']) !!}
		                      	
		                      	{!! Form::label('emailAddress', 'Email Address',['class' => 'label-material']) !!}
			                    <br>
			                    <!-- Validation. -->
								<span style="font:20px book antiqua; color:#BF360C" class="col-sm-offset-3">
									@if($errors-> has('emailAddress'))
										{{ $errors-> first('emailAddress')}}
									@endif
								</span>
		                    </div>
		                    <div class="form-group">
		                    	{!! Form::password('password',['class' => 'input-material']) !!}

		                      	{!! Form::label('password', 'Password',['class' => 'label-material']) !!}
			                    <br>
			                    <!-- Validation. -->
								<span style="font:20px book antiqua; color:#BF360C" class="col-sm-offset-3">
									@if($errors-> has('password'))
										{{ $errors-> first('password')}}
									@endif
								</span>
		                    </div>
		                    {!! Form::submit('Login',['class' => 'btn btn-primary pull-left']) !!}
	                    {!! Form::close() !!}
	                    	<div class="clearfix"> </div>
	                    	<br>
			                <a href=" {{ route('forgotPass') }} " class="forgot-pass pull-left">
			                  	Forgot Password?
			                </a><br>
	                	</div>
	              	</div>
	            </div>
      		</div>
    	</div>
  	</div>
  	<div class="copyrights text-center">
    	<p>Powered by <a target="_blank" href="https://paatech.co.ke" class="external">Paatech</a></p>
  	</div>
</div>

@stop