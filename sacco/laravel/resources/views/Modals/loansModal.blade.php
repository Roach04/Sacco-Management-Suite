<!-- Admin Modal -->
@foreach($users as $ad)
	@if($ad->role == 1)
		<section class="forms"> 
			<div class="container-fluid">
  				<div class="row">
					<div style="margin-top:60px" id="loansmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
				        <div role="document" class="modal-dialog modal-lg">
				          	<div class="modal-content">
				                <div class="modal-header">
				                  	<h4 id="exampleModalLabel" class="modal-title" style="color:blue; font:normal 22px book antiqua">Hi, {{$ad->username}}.</h4>
				                  	<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
				                </div>
				                <div class="col-lg-12" style="padding:20px">
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
						                  	<h3 class="h4">Loan Application</h3>
						                </div>
			                			<div class="modal-body">
			                				<div class="card-body">
			                					<div class="row pull-right">
					                                <span style="text-align:center; color: #666"> Today &nbsp; </span> 
					                                <span style="text-align:center; color:#796AEE; font:normal 18px book antiqua"> 
					                                    {{ $today }} | {{ $currenttime }}
					                                </span>
												</div> <br><br>

			                					<form>
						                  			<input type="hidden" name="id" class="form-control" id="id">  
						                  			
						                  			<div class="row">
								                      	<label class="col-sm-3 form-control-label">Loan Details</label>
								                      	<div class="col-sm-9">
									                        <div class="form-group-material">
									                        	<input type="number" name="loan" class="input-material" id="loan">
									                        	<label for="loan" class="label-material"> Loan </label>
									                        </div>
								                      	
									                        <div class="form-group-material">
									                        	<input type="number" name="loanDuration" class="input-material" id="loanDuration">
									                        	<label for="loanDuration" class="label-material"> Loan Duration (In Months) </label>
									                        </div>
								                      	</div>
							                    	</div>

							                    	<div class="line"></div>

						                  			<div class="row">
								                      	<label class="col-sm-3 form-control-label">Guarantors Details (Account Numbers)</label>
								                      	<div class="col-sm-9">
									                        <div class="form-group-material">
									                        	<input type="number" name="guaranteeOne" class="input-material" id="guaranteeOne">
									                        	<label for="guaranteeOne" class="label-material"> One. </label>
									                        </div>

									                        <div class="form-group-material">
									                        	<input type="number" name="guaranteeTwo" class="input-material" id="guaranteeTwo">
									                        	<label for="guaranteeTwo" class="label-material"> Two. </label>
									                        </div>

									                        <div class="form-group-material">
									                        	<input type="number" name="guaranteeThree" class="input-material" id="guaranteeThree">
									                        	<label for="guaranteeThree" class="label-material"> Three. </label>
									                        </div>
								                      	</div>
							                    	</div>

							                    	<div class="line"></div>

							                    	<div class="row">
								                      	<label class="col-sm-3 form-control-label">Guarantors Money (Cash)</label>
								                      	<div class="col-sm-9">
									                        <div class="form-group-material">
									                        	<input type="number" name="moneyOne" class="input-material" id="moneyOne">
									                        	<label for="moneyOne" class="label-material"> One. </label>
									                        </div>

									                        <div class="form-group-material">
									                        	<input type="number" name="moneyTwo" class="input-material" id="moneyTwo">
									                        	<label for="moneyTwo" class="label-material"> Two. </label>
									                        </div>

									                        <div class="form-group-material">
									                        	<input type="number" name="moneyThree" class="input-material" id="moneyThree">
									                        	<label for="moneyThree" class="label-material"> Three. </label>
									                        </div>
								                      	</div>
							                    	</div>

						                  			<div class="line"></div>

						                  			<div class="row">
								                      	<label class="col-sm-3 form-control-label">Payment Details</label>
								                      	<div class="col-sm-9">
									                        <div class="form-group-material">
									                        	<input type="text" name="modeOfPayment" class="input-material" id="modeOfPayment">
									                        	<label for="modeOfPayment" class="label-material"> Mode of Payment </label>
									                        </div>
								                      	
									                        <div class="form-group-material">
									                        	<input type="number" name="monthlyInstallment" class="input-material" id="monthlyInstallment">
									                        	<label for="monthlyInstallment" class="label-material"> Expected Monthly Installments </label>
									                        </div>
								                      	</div>
							                    	</div>

							                    	<div class="line"></div>

						                  			<div class="row">
								                      	<label class="col-sm-3 form-control-label">Loan Entity & Type</label>
								                      	<div class="col-sm-9">
									                        <div class="form-group-material">
									                        	<label for="loanEntity" class="label-material"> Loan Entity </label>
									                        	<select type="text" name="loanEntity" class="form-control" id="loanEntity">
								                  					<option value="individual"> Individual </option>
								                  					<option value="institution x"> Institution x </option>
								                  					<option value="institution y"> Institution y </option>
								                  				</select>
									                        </div>
								                      	
									                        <div class="form-group-material">
								                  				<label for="loanType" class="form-label pull-left"> Loan Type </label>
								                  				<select type="text" name="loanType" class="form-control" id="loanType">
								                  					<option value="development"> Development Loan </option>
								                  					<option value="comfort"> Comfort Loan </option>
								                  					<option value="schoolFees"> School Fees Loan </option>
								                  					<option value="normal"> Normal Loan </option>
								                  					<option value="insurance"> Insurance Loan </option>
								                  					<option value="emergency"> Emergency Loan </option>
								                  				</select>
								                  			</div>
								                      	</div>
							                    	</div><br><br>

								                    <div id="failure"> </div>
								                    <div id="loan-failure"> </div>
								                    <div id="loan-success"> </div>
							                    
								                    <div class="modal-footer">
								          				<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button> 
								          				<input type="button" class="btn btn-primary" id="modal-loans" value="Save Changes">  				
								          			</div>
							      				</form>
							      			</div>
			                			</div>
			                		</div>
					            </div>   
				          	</div>
				        </div>
					</div>
				</div>
		    </div>
		</section>
	@endif
@endforeach

<script>
    var token = '{{ Session::token() }}';
</script>
<!-- Admin Modal -->