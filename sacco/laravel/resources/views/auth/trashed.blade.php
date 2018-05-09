@extends('layout.master')

@section('content')

<div class="page charts-page">

	<p id="message"> </p> 

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
    
        @include('layout.accountsBar')

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">System Accounts</h2>
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
              		<li class="breadcrumb-item active">
              			<a>
              			{!! Form::open(['route' => ['restoreAccounts'], 'method' => 'POST']) !!}
              				{!! Form::submit('Restore All Accounts', ['class' => 'btn btn-success btn-sm']) !!}
              			{!! Form::close() !!}
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
                		@if(count($trash))
	                		@foreach($trash as $trashed)
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
					                      		<a class="roles">
					                      			<img style="width:100%; height:100px" src="{{$trashed->userPic}}" alt="..." class="img-fluid rounded-circle">
					                        		<div class="status bg-danger"></div>
					                      		</a>
					                      	</div>
					                      	<div class="client-title">
					                        	<p> {{ $trashed->username }} </p>
					                        	<span> {{ $trashed->jobTitle }} </span>
					                        	{!! Form::open(['route' => ['restoreAccount', $trashed->id], 'method' => 'POST' ]) !!}
					                        		{!! Form::submit('Restore Account.', ['class' => 'btn bg-success btn-sm', 'style' => 'color:lavender' ]) !!}
					                        	{!! Form::close() !!}
					                      	</div>
					                      	<div class="client-info">
						                        <div class="row">
						                          	<div class="col-4"><strong> {{ $trashed->active }} </strong><br><small>Active</small></div>
						                          	<div class="col-4">
							                          	<strong id="trey"> {{ $trashed->role }} </strong><br>
							                          	<small>Role</small>
						                          	</div>
						                          	<div class="col-4"><strong> {{ $trashed->id }} </strong><br><small>Id</small></div>
						                        </div>
					                      	</div>
					                    </div>
		                  			</div>
		                		</div>
	                		@endforeach    
                		@endif             		
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