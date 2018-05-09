<!-- Admin Modal -->
@foreach($users as $ad)
	@if($ad->role == 1)
		<div style="margin-top:60px" id="savingsupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	        <div role="document" class="modal-dialog">
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
	                                <span style="text-align:center; color: grey"> Today &nbsp; </span> 
	                                <span style="text-align:center; color:#796AEE; font:normal 18px book antiqua"> 
	                                    {{ $today }}
	                                </span>

	                                <span style="color:black"> &nbsp;&nbsp; | &nbsp;&nbsp; </span>

	                                <span style="text-align:center; color: grey"> Bank &nbsp; </span> 
	                                <span style="text-align:center; color:#796AEE; font:normal 18px book antiqua" id="bank"> 
	                                     
	                                </span>
								</div><br>             						

	                  			<input type="hidden" name="id" class="form-control" id="id"> 
	                  			
	                  			<div class="form-group">
	                  				<label for="details" class="form-label pull-left"> Details </label>
	                  				<input type="number" name="details" class="form-control" id="details"> 
	                  			</div>

	                  			<div class="form-group">
	                  				<label for="credit" class="form-label pull-left"> Credit </label>
	                  				<input type="number" name="credit" class="form-control" id="credit"> 
	                  			</div>

	                  			<div class="form-group">
	                  				<label for="debit" class="form-label pull-left"> Debit </label>
	                  				<input type="number" name="debit" class="form-control" id="debit">
	                  			</div>

	                  			<div class="form-group">
	                  				<label for="account" class="form-label pull-left"> Account Name </label>
	                  				<input type="text" name="account" class="form-control" id="account">
	                  			</div>

	                  			<div class="form-group">
	                  				<label for="bank" class="form-label pull-left"> Bank </label>
	                  				<input type="text" name="bank" class="form-control" id="bank">
	                  			</div>
		                    </div>
	                    </div>
	                    <div class="modal-footer">
	          				<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button> 
	          				<input type="button" class="btn btn-primary" id="modal-savings-update" value="Save Changes">  				
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