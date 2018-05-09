<!-- Admin Modal -->
@foreach($users as $ad)
	@if($ad->role == 1)
		<div style="margin-top:60px" id="disbursementsupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
	        <div role="document" class="modal-dialog">
	          	<div class="modal-content">
	                <div class="modal-header">
	                  	<h4 id="exampleModalLabel" class="modal-title" style="color:blue; font:normal 22px book antiqua">Hi, {{$ad->username}}.</h4>
	                  	<button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
	                </div>
	                <form>
	                    <div class="modal-body">
	                    	<div id="failure"> </div>
		                    <div id="disburse-failure"> </div>
		                    <div id="disburse-success"> </div>
		                    
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
	                  				<label for="disburseMoney" class="form-label pull-left"> Disbursed Money </label>
	                  				<input type="number" name="disburseMoney" class="form-control" id="disburseMoney"> 
	                  			</div>

	                  			<div class="form-group">
	                  				<label for="chequeNo" class="form-label pull-left"> Cheque Number </label>
	                  				<input type="number" name="chequeNo" class="form-control" id="chequeNo">
	                  			</div>

	                  			<div class="form-group">
	                  				<label for="duration" class="form-label pull-left"> Loan Duration </label>
	                  				<input type="number" name="duration" class="form-control" id="duration">
	                  			</div>
		                    </div>
	                    </div>
	                    <div class="modal-footer">
	          				<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button> 
	          				<input type="button" class="btn btn-primary" id="modal-disbursements-update" value="Save Changes">  				
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