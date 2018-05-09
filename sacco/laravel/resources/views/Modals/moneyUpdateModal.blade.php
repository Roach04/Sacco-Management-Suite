<!-- Admin Modal -->
@foreach($users as $ad)
	@if($ad->role == 1)
		<div style="margin-top:60px" id="moneyupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
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
	                                <span style="text-align:center; color: grey"> &nbsp;&nbsp; Today &nbsp; </span> 
	                                <span style="text-align:center; color:#796AEE; font:normal 18px book antiqua"> 
	                                    {{ $today }} | {{ $currenttime }}
	                                </span>
								</div><br><br>             						

	                  			<input type="hidden" name="id" class="form-control" id="id"> 

	                  			<input type="hidden" name="memberId" class="form-control" id="memberId"> 
	                  			
	                  			<div class="form-group">
	                  				<label for="credit" class="form-label pull-left"> Update Credit </label>
	                  				<input type="number" name="credit" class="form-control" id="credit"> 
	                  			</div>
		                    </div>
	                    </div>
	                    <div class="modal-footer">
	          				<button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button> 
	          				<input type="button" class="btn btn-primary" id="money-update" value="Save Changes">  				
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