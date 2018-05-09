@extends('layout.master')

@section('content')

<div class="page charts-page">
	
	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
    
       @include('layout.journalsBar')

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
              		<li class="breadcrumb-item active">Create Journals</li>
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
				                  	<h3 class="h4">Journal</h3>
				                </div>
	                			<div class="card-body">

	                				{!! Form::open(['route' => ['storeJournals'], 'method'=>'POST']) !!}
	                								
	                					<div class="row">
					                      	<label class="col-sm-3 form-control-label">Details</label>
					                      	<div class="col-sm-9">
						                        <div class="form-group-material">
						                        	{!! Form::text('details', null, ['class'=> 'input-material'])!!}
						                          	
						                          	{!! Form::label('details', 'Transaction Name / Details.', ['class'=> 'label-material']) !!}
						                          	<br>
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('details'))
								                            {{ $errors->first('details') }}
								                        @endif
								                    </span>
						                        </div>
					                      	</div>
					                    </div>
										<div class="line"></div>

										<div class="row">
					                      	<label class="col-sm-3 form-control-label">Account</label>
					                      	<div class="col-sm-9">
						                        <div class="form-group-material">						                          	
						                          	{!! Form::label('accountName', 'Account Responsible.', ['class'=> 'label-control']) !!}
						                          	
						                            {!! Form::select('accountName', $select, null, ['class'=> 'form-control'])!!}									
						                          	<br>
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('accountName'))
								                            {{ $errors->first('accountName') }}
								                        @endif
								                    </span>
						                        </div>
					                      	</div>
					                    </div>
					                    <div class="line"></div>

					                    <div class="row">
					                      	<label class="col-sm-3 form-control-label">Moneys</label>
					                      	<div class="col-sm-9">
						                        <div class="form-group-material">
						                        	{!! Form::number('actualFigure', null, ['class'=> 'input-material'])!!}
						                          	
						                          	{!! Form::label('actualFigure', 'Current / Actual Figure.', ['class'=> 'label-material']) !!}
						                          	<br>
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('actualFigure'))
								                            {{ $errors->first('actualFigure') }}
								                        @endif
								                    </span>
						                        </div>
					                      	
						                        <div class="form-group-material">
						                        	{!! Form::number('overpay', null, ['class'=> 'input-material'])!!}
						                          	
						                          	{!! Form::label('overpay', 'Overpay.', ['class'=> 'label-material']) !!}
						                          	<br>
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('overpay'))
								                            {{ $errors->first('overpay') }}
								                        @endif
								                    </span>
						                        </div>
					                      	</div>
					                    </div>
										<div class="line"></div>

										<div class="row">
					                      	<label class="col-sm-3 form-control-label">Bank</label>
					                      	<div class="col-sm-9">
						                        <div class="form-group-material">						                          	
						                          	{!! Form::label('bank', 'Bank Repsonsible.', ['class'=> 'label-control']) !!}

						                          	{!! Form::select('bank', [
														
														'Equity Bank' => 'Equity Bank'
													], null, ['class'=> 'form-control'])!!}	
						                          	<br>
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('bank'))
								                            {{ $errors->first('bank') }}
								                        @endif
								                    </span>
						                        </div>
					                      	</div>
					                    </div>
					                    <div class="line"></div>

					                    <div class="row">
					                      	<label class="col-sm-3 form-control-label">Duration</label>
					                      	<div class="col-sm-9">
						                        <div class="form-group-material">
						                        	{!! Form::text('duration', null, ['class'=> 'input-material'])!!}
						                          	
						                          	{!! Form::label('duration', 'Duration.', ['class'=> 'label-material']) !!}
						                          	<br>
						                        	<!-- VALIDATION.. -->
								                    <span style="font:normal 20px book antiqua; color:red">
								                        @if($errors->has('duration'))
								                            {{ $errors->first('duration') }}
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