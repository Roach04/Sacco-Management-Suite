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
	              <h2 class="no-margin-bottom">System Users</h2>
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
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<!-- Client Section-->
          	<section class="client no-padding-top" style="margin-top:20px">
            	<div class="container-fluid">
              		<div class="row">
                	
                		<!-- Client Profile -->
	            		@foreach($users as $user)              			
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
	                    			@if($user->role == 1)
	                    				<div class="card-body text-center">
					                      	<div class="client-avatar">
					                      		<a href="#savingsmodal" data-toggle="modal" >
					                      			<img style="width:100%; height:100px" src="{{$user->userPic}}" alt="..." class="img-fluid rounded-circle">
					                        		<div class="status bg-blue"></div>
					                      		</a>
					                      	</div>
					                      	<div class="client-title">
					                        	<p> {{ $user->username }} </p>
					                        	<span> {{ $user->jobTitle }} </span>
					                        	<a href="{{ route('showSavings', [$user->id]) }}" class="btn btn-primary btn-sm">
					                        		Show Savings.
					                        	</a>
					                      	</div>
					                      	<div class="client-info">
						                        <div class="row">
						                          	<div class="col-4"><strong> {{ $user->active }} </strong><br><small>Active</small></div>
						                          	<div class="col-4">
							                          	<strong id="trey"> {{ $user->role }} </strong><br>
							                          	<small>Role</small>
						                          	</div>
						                          	<div class="col-4"><strong> {{ $user->id }} </strong><br><small>Id</small></div>
						                        </div>
					                      	</div>
					                    </div>
	                    			@else
	                    				<div class="card-body text-center">
					                      	<div class="client-avatar">
					                      		<a href="#myModal" data-active=" {{ $user->active }} " data-job=" {{ $user->jobTitle }} " data-image="{{ $user->userPic }}" data-uname="{{ $user->username }}" data-id="{{ $user->id }}" class="roles">
					                      			<img style="width:100%; height:100px" src="{{$user->userPic}}" alt="..." class="img-fluid rounded-circle">
					                        		<div class="status bg-green"></div>
					                      		</a>
					                      	</div>
					                      	<div class="client-title">
					                        	<p> {{ $user->username }} </p>
					                        	<span> {{ $user->jobTitle }} </span>
					                        	{!! Form::open(['route' => ['trashAccount', $user->id], 'method' => 'DELETE' ]) !!}
					                        		{!! Form::submit('Trash Account.', ['class' => 'btn bg-green btn-sm']) !!}
					                        	{!! Form::close() !!}
					                      	</div>
					                      	<div class="client-info">
						                        <div class="row">
						                          	<div class="col-4"><strong> {{ $user->active }} </strong><br><small>Active</small></div>
						                          	<div class="col-4">
							                          	<strong id="trey"> {{ $user->role }} </strong><br>
							                          	<small>Role</small>
						                          	</div>
						                          	<div class="col-4"><strong> {{ $user->id }} </strong><br><small>Id</small></div>
						                        </div>
					                      	</div>
					                    </div>
	                    			@endif
	                  			</div>
	                		</div>
		                @endforeach	
	                	<script>
	                		var token = '{{ Session::token() }}';
							var url = '{{ route("storeRoles") }}';
						</script>
                		<!-- Client Profile -->

                		<!-- Modal -->
	          			<div style="margin-top:45px" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
		                    <div role="document" class="modal-dialog">
		                      	<div class="modal-content">
			                        <div class="modal-header">
			                          	<h4 id="exampleModalLabel" class="modal-title">Assign Roles.</h4>
			                          	<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
			                        </div>
			                        <form>
				                        <div class="modal-body">
				                          	<div class="card-body text-center">
						                      	<!-- <div class="client-avatar">

						                      		<img style="width:100%; height:100px" id="image" src="" alt="..." class="img-fluid rounded-circle">
						                        	 <div class="status bg-green"></div> 
						                      	</div> -->
						                      	<div class="client-title">
						                      		<div class="form-group">
						                      			<label for="username" class="form-label pull-left"> Id </label>
					                      				<input type="text" class="form-control" id="id" readonly="readonly" > 
					                      			</div>

					                      			<div class="form-group">
					                      				<label for="username" class="form-label pull-left"> Username </label>
					                      				<input type="text" class="form-control" id="username" readonly="readonly" > 
					                      			</div>

					                      			<div class="form-group">
					                      				<label for="jobTitle" class="form-label pull-left"> Job Title </label>
					                      				<input type="text" class="form-control" id="jobTitle" readonly="readonly" >
					                      			</div>

					                      			<div class="form-group">
					                      				<label for="roles" class="form-label pull-left"> Assign Roles </label>
					                      				<select class="form-control" name="roles" id="roles" data-role="roles">
					                      					<option class="form-control" value="1"> Tier One. </option>
					                      					<option class="form-control" value="2"> Tier Two. </option>
					                      					<option class="form-control" value="3"> Tier Three. </option>
					                      				</select>
					                      			</div>
						                      	</div>
						                    </div>
						                    <div id="whitaker" style="width:100%; font:normal 18px book antiqua; text-align:center"> </div>
				                        </div>

				                        <div class="modal-footer" >
		                      				<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
		                      				<input type="button" class="btn btn-primary" id="modal-save" value="Save Changes">    				
		                      			</div>
			                        </form>
		                      	</div>
		                    </div>
	          			</div>
	          			<!-- Modal -->

	          			@include('Modals.savingsModal')
	          			
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