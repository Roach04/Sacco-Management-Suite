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
              		<li class="breadcrumb-item active">
              			<a>
              				Fixed Account
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
                		@if(count($fixed))
	                		@foreach($fixed as $fixx)
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
					                      			<img style="width:100%; height:100px" src="{{$fixx->memberPic}}" alt="..." class="img-fluid rounded-circle">
					                        		<div class="status bg-violet"></div>
					                      		</a>
					                      	</div>
					                      	<div class="client-title">
					                        	<p> {{ $fixx->phoneNumber }} </p>
					                        	<p> {{ $fixx->emailAddress }} </p>
					                        	{!! Form::open(['route' => ['trashMember', $fixx->id], 'method' => 'DELETE' ]) !!}
                                                    {!! Form::submit('Trash Member\'s Account.', ['class' => 'btn bg-violet btn-sm']) !!}
                                                {!! Form::close() !!}
					                      	</div>
					                      	<div class="client-info">
						                        <div class="row">
						                          	<div class="col-4"><strong> {{ $today }} </strong><br><small>Created On</small></div>
						                          	<div class="col-4"><strong> {{ $fixx->idNumber }} </strong><br><small>Id Number</small></div>
						                          	<div class="col-4">
							                          	<strong id="trey"> {{ $fixx->accountType }} </strong><br>
							                          	<small>Account</small>
						                          	</div>
						                        </div>
					                      	</div>
					                    </div>
		                  			</div>
		                		</div>
	                		@endforeach   
	                	@else
	                		<div class="contianer">
	                			<p style="color:red; font-size:22px; padding:22px">
	                				There are No Members with Fixed Accounts at This Time. 
	                			</p>
	                		</div>
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