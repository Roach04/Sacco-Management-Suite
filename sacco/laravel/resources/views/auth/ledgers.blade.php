@extends('layout.master')

@section('content')
	
<div class="page charts-page">

	<!-- Main Navbar-->
	@include('layout.navigation')
	<!-- Main Navbar-->
  
  <div class="page-content d-flex align-items-stretch"> 
    <!-- Side Navbar -->
    @include('layout.ledgersBar')
    <!-- Side Navbar -->

    <div class="content-inner">
    	<!-- Page Header-->
      	<header class="page-header">
	        <div class="container-fluid">
	          <h2 class="no-margin-bottom">Ledgers</h2>
	        </div>
      	</header>
      	<!-- Page Header-->

      	<!-- Breadcrumb-->
      	<ul class="breadcrumb">
        	<div class="container-fluid">
          		<li class="breadcrumb-item"><a href=" {{ route('dashboard') }} ">Home</a></li>
          		<li class="breadcrumb-item active">Ledgers</li>
        	</div>
      	</ul>
      	<!-- Breadcrumb-->

      	<section class="tables">   
        	<div class="container-fluid">
          		<div class="row">
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
			                  	<h3 class="h4">All Members</h3>
			                </div>
                			<div class="card-body">
                  				<table class="table table-bordered table-hover table-responsive">
				                    <thead>
				                      	<tr>
					                        <th>#</th>
					                        <th>First Name</th>
					                        <th>Last Name</th>
					                        <th>Gender</th>
					                        <th>Bank</th>
					                        <th>Bank Acc No</th>
					                        <th>Occupation</th>
					                        <th>Acc Type</th>
					                        <th>Marital Status</th>
					                        <th>Mobile Number</th>
					                        <th>ID Number</th>
					                        <th>Email Address</th>
					                        <th>DOB</th>
					                        <th>P.O Box</th>
					                        <th>County</th>
					                        <th>Nationality</th>
					                        <!-- <th>Kin First Name</th>
					                        <th>Kin Last Name</th>
					                        <th>Kin Gender</th>
					                        <th>Kin Occupation</th>
					                        <th>Kin Marital Status</th>
					                        <th>Kin Mobile Number</th>
					                        <th>Kin ID Number</th>
					                        <th>Kin Relationship</th>
					                        <th>Kin Email Address</th>
					                        <th>Kin DOB</th>
					                        <th>Kin P.O Box</th>
					                        <th>Kin County</th>
					                        <th>Kin Nationality</th> -->
					                        
				                      	</tr>
				                    </thead>
				                    @foreach($memberz as $member)
					                    <tbody>
					                      	<tr>
						                        <th scope="row">{{ $member->accountNumber }}</th>
						                        <td>{{ $member->firstname }}</td>
						                        <td>{{ $member->lastname }}</td>
						                        <td>{{ $member->gender }}</td>
						                        <td>{{ $member->bankName }}</td>
						                        <td>{{ $member->bankAccountNumber }}</td>
						                        <td>{{ $member->occupation }}</td>
						                        <td>{{ $member->accountType }}</td>
						                        <td>{{ $member->maritalStatus }}</td>
						                        <td>{{ $member->phoneNumber }}</td>
						                        <td>{{ $member->idNumber }}</td>
						                        <td>{{ $member->emailAddress }}</td>
						                        <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($member->dateOfBirth))->formatlocalized('%a %d %b %y') }}</td>
						                        <td>{{ $member->poBox }}</td>
						                        <td>{{ $member->county }}</td>
						                        <td>{{ $member->nationality }}</td>
						                        <!-- <td>{{ $member->firstnameKin }}</td>
						                        <td>{{ $member->lastnameKin }}</td>
						                        <td>{{ $member->genderKin }}</td>
						                        <td>{{ $member->occupationKin }}</td>
						                        <td>{{ $member->maritalStatusKin }}</td>
						                        <td>{{ $member->phoneNumberKin }}</td>
						                        <td>{{ $member->idNumberKin }}</td>
						                        <td>{{ $member->relationshipKin }}</td>
						                        <td>{{ $member->emailAddressKin }}</td>
						                        <td>{{ Carbon\Carbon::createFromTimestamp(strtotime($member->dateOfBirthKin))->formatlocalized('%a %d %b %y') }}</td>
						                        <td>{{ $member->poBoxKin }}</td>
						                        <td>{{ $member->countyKin }}</td>
						                        <td>{{ $member->nationalityKin }}</td> -->
					                      	</tr>
					                    </tbody>
				                    @endforeach
                  				</table>
                  				{!! $memberz->render() !!}
                  				<a href="{{ route('pdfMembers') }}" class="col-lg-4 col-md-4 pull-right btn btn-success"> Print Members. </a>
                			</div>
              			</div>
            		</div>
            		<!-- <div class="col-lg-6">
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
			                  	<h3 class="h4">Striped table with hover effect</h3>
			                </div>
                			<div class="card-body">
                  				<table class="table table-striped table-hover">
				                    <thead>
				                      	<tr>
					                        <th>#</th>
					                        <th>First Name</th>
					                        <th>Last Name</th>
					                        <th>Username</th>
				                      	</tr>
				                    </thead>
				                    <tbody>
				                      	<tr>
					                        <th scope="row">1</th>
					                        <td>Mark</td>
					                        <td>Otto</td>
					                        <td>@mdo</td>
				                      	</tr>
				                      	<tr>
					                        <th scope="row">2</th>
					                        <td>Jacob</td>
					                        <td>Thornton</td>
					                        <td>@fat</td>
				                      	</tr>
				                      	<tr>
					                        <th scope="row">3</th>
					                        <td>Larry</td>
					                        <td>the Bird</td>
					                        <td>@twitter</td>
				                      	</tr>
				                    </tbody>
                  				</table>
                			</div>
              			</div>
            		</div>
            		<div class="col-lg-6">
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
			                  	<h3 class="h4">Compact Table</h3>
			                </div>
                			<div class="card-body">
                  				<table class="table table-striped table-sm">
				                    <thead>
				                      	<tr>
					                        <th>#</th>
					                        <th>First Name</th>
					                        <th>Last Name</th>
					                        <th>Username</th>
				                      	</tr>
				                    </thead>
				                    <tbody>
				                      	<tr>
					                        <th scope="row">1</th>
					                        <td>Mark</td>
					                        <td>Otto</td>
					                        <td>@mdo</td>
				                      	</tr>
				                      	<tr>
					                        <th scope="row">2</th>
					                        <td>Jacob</td>
					                        <td>Thornton</td>
					                        <td>@fat</td>
				                      	</tr>
				                      	<tr>
					                        <th scope="row">3</th>
					                        <td>Larry</td>
					                        <td>the Bird</td>
					                        <td>@twitter</td>
				                      	</tr>
				                      	<tr>
					                        <th scope="row">4</th>
					                        <td>Mark</td>
					                        <td>Otto</td>
					                        <td>@mdo</td>
				                      	</tr>
				                      	<tr>
					                        <th scope="row">5</th>
					                        <td>Jacob</td>
					                        <td>Thornton</td>
					                        <td>@fat</td>
				                      	</tr>
				                      	<tr>
					                        <th scope="row">6</th>
					                        <td>Larry</td>
					                        <td>the Bird</td>
					                        <td>@twitter</td>                                                                            </td>
				                      	</tr>
				                    </tbody>
                  				</table>
                			</div>
              			</div>
            		</div> -->
          		</div>
        	</div>
      	</section>

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