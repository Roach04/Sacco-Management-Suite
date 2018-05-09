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
              		<li class="breadcrumb-item active">Save User</li>

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

	                				{!! Form::open(['route' => ['storeAccount'], 'method' => 'POST', 'class' => 'dropzone', 'id' => 'addImages' ]) !!}
		                				
		                				<!-- pass in the hidden fields. -->
		                				{!! Form::hidden('firstname', $firstname) !!}
		                				{!! Form::hidden('lastname', $lastname) !!}
		                				{!! Form::hidden('phoneNumber', $phoneNumber) !!}
		                				{!! Form::hidden('idNumber', $idNumber) !!}
		                				{!! Form::hidden('jobTitle', $jobTitle) !!}
		                				{!! Form::hidden('emailAddress', $emailAddress) !!}
		                				{!! Form::hidden('username', $username) !!}
		                				{!! Form::hidden('password', $password) !!}
		                				{!! Form::hidden('active', $active) !!}
		                				{!! Form::hidden('role', $role) !!}
		                				{!! Form::hidden('code', $code) !!}

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
@stop