<!-- Admin Modal -->
@foreach($users as $ad)
	@if($ad->role == 1)
		<div style="margin-top:60px" id="savingsmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	        <div role="document" class="modal-dialog modal-lg">
	          	<div class="modal-content">
	                <div class="modal-header">
	                  	<h4 id="exampleModalLabel" class="modal-title" style="color:blue; font:normal 22px book antiqua">Hi, {{$ad->username}}.</h4>
	                  	<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
	                </div>
	                <form>
	                    <div class="modal-body">
	                    	<div id="failure"> </div>
		                    <div id="money-failure"> </div>
		                    <div id="money-success"> </div>
		                    
	                      	<div class="card-body text-center">
	                          	<div class="row">
	                                <span style="text-align:center; color: grey"> &nbsp;&nbsp; Today &nbsp; </span> 
	                                <span style="text-align:center; color:#796AEE; font:normal 18px book antiqua"> 
	                                    {{ $today }} | {{ $currenttime }}
	                                </span>
								</div> <br> 

								<table class="table table-responsive table-bordered table-hover">
									<thead>
										<tr>
											<th> Account </th>
											<th> Debit   </th>
											<th> Credit  </th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<div class="form-group">
					                  				<select class="form-control" name="bills" id="bills">
					                  					<option value="Nill"> Nill </option>
					                  					<option value="Insuarance Expense"> Insuarance Expense </option>
					                  					<option value="Rent and Rates"> Rent and Rates </option>
					                  					<option value="Repairs and Maintenance"> Repairs and Maintenance </option>
					                  					<option value="Staff Training"> Staff Training </option>
					                  					<option value="Travelling and Entertainment"> Travelling and Entertainment </option>
					                  					<option value="Telephone"> Telephone </option>
					                  					<option value="Utilities"> Utilities </option>
					                  					<option value="Vehicle Expense"> Vehicle Expense </option>
					                  					<option value="Advertizing and Promotion"> Advertizing and Promotion </option>
					                  					<option value="Office Expense"> Office Expense </option>
					                  				</select>
					                  			</div>
											</td>
											<td>
												<div class="form-group">
					                  				<input type="number" name="credit" class="form-control" id="credit"> 
					                  			</div>
											</td>
											<td>
												<div class="form-group">
					                  				<input type="number" name="debit" class="form-control" id="debit">
					                  			</div>
											</td>
										</tr>
										<tr>
											<td>
												<div class="form-group">
					                  				<input type="number" name="credit" class="form-control" id="account"> 
					                  			</div>
											</td>
											<td>
												<div class="form-group">
					                  				<input type="number" name="credit" class="form-control" id="credit"> 
					                  			</div>
											</td>
											<td>
												<div class="form-group">
					                  				<input type="number" name="debit" class="form-control" id="debit">
					                  			</div>
											</td>
										</tr>
									</tbody>
								</table>           						

	                  			<div class="form-group">
	                  				<label for="registrationFee" class="form-label pull-left"> Credit </label>
	                  				<input type="number" name="credit" class="form-control" id="credit"> 
	                  			</div>

	                  			<div class="form-group">
	                  				<label for="jobTitle" class="form-label pull-left"> Debit </label>
	                  				<input type="number" name="debit" class="form-control" id="debit">
	                  			</div>

	                  			<div class="form-group">
	                  				<label for="bills" class="form-label pull-left"> Expenses </label>
	                  				<select class="form-control" name="bills" id="bills">
	                  					<option value="Nill"> Nill </option>
	                  					<option value="Insuarance Expense"> Insuarance Expense </option>
	                  					<option value="Rent and Rates"> Rent and Rates </option>
	                  					<option value="Repairs and Maintenance"> Repairs and Maintenance </option>
	                  					<option value="Staff Training"> Staff Training </option>
	                  					<option value="Travelling and Entertainment"> Travelling and Entertainment </option>
	                  					<option value="Telephone"> Telephone </option>
	                  					<option value="Utilities"> Utilities </option>
	                  					<option value="Vehicle Expense"> Vehicle Expense </option>
	                  					<option value="Advertizing and Promotion"> Advertizing and Promotion </option>
	                  					<option value="Office Expense"> Office Expense </option>
	                  				</select>
	                  			</div>
		                    </div>
	                    </div>
	                    <div class="modal-footer">
	          				<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button> 
	          				<input type="button" class="btn btn-primary" id="modal-savings" value="Save Changes">  				
	          			</div>
	      			</form>
	          	</div>
	        </div>
		</div>
	@endif
@endforeach

<script>
    var token = '{{ Session::token() }}';
</script>
<!-- Admin Modal -->