@extends('layout.master')

@section('content')
	
<div class="page charts-page">

	@include('layout.navigation')

  	<div class="page-content d-flex align-items-stretch"> 
    
        @include('layout.loansBar')

        <div class="content-inner">
          	<!-- Page Header-->
         	<header class="page-header">
	            <div class="container-fluid">
	              <h2 class="no-margin-bottom">Members Loans</h2>
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
                        <a href=" {{ route('memberLoans') }} ">
                            Members Loans
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        Loan Calculator
                    </li>
            	</div>
          	</ul>
          	<!-- Breadcrumb-->

          	<!-- Client Section-->
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
				                  	<h3 class="h4">Calculator</h3>
				                </div>
				                
	                			<div class="card-body">
	                				<form>	
		                				<div class="row">
							            	<label class="col-sm-3 form-control-label">Loan Calculator</label>
							            	<div class="col-sm-9">
						                        <div class="form-group-material">
						                        	<input id="loan" type="number" name="loan" class="input-material">

						                          	<label for="loan" class="label-material"> Principle Loan. </label>						                          							                          							                          	
						                        	<br>
						                        	<div id="failureLoan"> </div>
						                        </div>
						                        <div class="form-group-material">
						                        	<input id="rate" type="text" name="rate" class="input-material">

						                          	<label for="rate" class="label-material"> Interest Rate. </label>						                          							                          							                          	
						                        	<br>
						                        	<div id="failureRate"> </div>
						                        </div>
						                        <div class="form-group-material">
						                        	<input id="duration" type="number" name="duration" class="input-material">

						                          	<label for="duration" class="label-material"> Loan Duration. </label>						                          							                          							                          	
						                        	<br>
						                        	<div id="failureDuration"> </div>
						                        </div>
					                      	</div>
							            </div>
							        </form>   
				                    <div class="form-group row">
				                      	<div class="col-sm-4 offset-sm-3">		
				                            <input type="button" class="btn btn-primary" id="calculate-loan" value="Calculate The Loan">
				                      	</div>
				                    </div>
				                    <br>
						            <div id="failure"> </div>

				                    <div class="line"></div>

				                    <div class="row">
						            	<label class="col-sm-3 form-control-label">Calculate</label>
						            	<div class="container">
						            		<div class="col-sm-9 offset-sm-3">
								                <span style="color:grey"> Loan &nbsp; </span> 
								                <span id="loanCalc" style="color:#796AEE; font:normal 18px book antiqua"> </span>
								            
								            	<span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
								            
								                <span style="color:grey"> Amount &nbsp; </span> 
								                <span id="amountCalc" style="color:#54e69d; font:normal 18px book antiqua"> </span>
								            
								            	<span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

								                <span style="color:grey"> Interest &nbsp; </span> 
								                <span id="interestCalc" style="color:#796AEE; font:normal 18px book antiqua"> </span>

								                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>
								            									            
								                <span style="color:grey"> Loan Duration &nbsp; </span> 
								                <span id="durationCalc" style="color:#54e69d; font:normal 18px book antiqua"> </span>
								            </div>
						            	</div>
						            </div>
	                										            
						            <div class="line"></div>

						            <div class="row">
						            	<table class="table table-hover table-bordered">
						            		<thead>
						            			<tr>
						            				<th>Months</th>
						            				<th>Loan</th>
						            				<th>Total Payment</th>
						            				<th>Principal Payment</th>
						            				<th>Interest Rate</th>
						            			</tr>
						            		</thead>
						            		<tbody>
						            			<tr>
						            				<td id="tbduration"></td>
						            				<td id="tbloan"></td>
						            				<td id="tbTotalAmount"></td>
						            				<td id="tbTotalPayment"></td>
						            				<td id="tbinterest"></td>
						            			</tr>
						            		</tbody>
						            	</table>
						            </div>
							               
	                			</div>
	                		</div>
	                	</div>
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