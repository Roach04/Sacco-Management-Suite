<!-- Admin Modal -->
@foreach($users as $ad)
	@if($ad->role == 1)
		<div style="margin-top:60px" id="chartAccountsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	        <div role="document" class="modal-dialog">
	          	<div class="modal-content">
	                <div class="modal-header">
	                  	<h4 id="exampleModalLabel" class="modal-title" style="color:blue; font:normal 22px book antiqua">Hi, {{$ad->username}}.</h4>
	                  	<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
	                </div>
	                <form>
	                    <div class="modal-body">
	                    	<div id="failure"> </div>
		                    <div id="chart-error"> </div>
		                    <div id="chart-success"> </div>
		                    
	                      	<div class="card-body text-center">
	                          	<div class="row">
	                                <span style="text-align:center; color: grey"> Today &nbsp; </span> 
	                                <span style="text-align:center; color:#796AEE; font:normal 18px book antiqua"> 
	                                    {{ $today }} | {{ $currenttime }}
	                                </span>
								</div><br>             						

	                  			<input type="hidden" name="id" class="form-control" id="id"> 
	                  			
	                  			<div class="form-group">
	                  				<label for="subAccountName" class="form-label pull-left"> Sub Account Name </label>
	                  				<input type="text" name="subAccountName" class="form-control" id="subAccountName"> 
	                  			</div>

	                  			<div class="row">
		                  			<div class="col-lg-6 col-md-6 form-group">
		                  				<label for="category" class="form-label pull-left"> Category </label>
		                  				<input type="text" name="category" class="form-control" id="category">
		                  			</div>

		                  			<div class="col-lg-6 col-md-6 form-group">
		                  				<label for="money" class="form-label pull-left"> Total Balance </label>
		                  				<input type="text" name="money" class="form-control" id="money">
		                  			</div>
		                  		</div>

		                  		<div class="form-group">
	                  				<label for="description" class="form-label pull-left"> Description </label>
	                  				<input type="text" name="description" class="form-control" id="description">
	                  			</div>
		                    </div>
	                    </div>
	                    <div class="modal-footer">
	          				<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button> 
	          				<input type="button" class="btn btn-primary" id="modal-chart-accounts" value="Save Changes">  				
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