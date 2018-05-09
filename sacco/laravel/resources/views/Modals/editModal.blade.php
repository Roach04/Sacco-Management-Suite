<!-- Modal -->
<div style="margin-top:60px;" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade col-lg-12">
    <div style="width:1250px" role="document" class="modal-dialog">    
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font:bold 22px book antiqua" id="exampleModalLabel" class="modal-title">
                    <span id="fname"></span> <span id="lname"> </span>'s Account.
                </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="container" style="margin-top:20px">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="failure"> </div>
                        <div id="money-failure"> </div>
                        <div id="money-success"> </div>
                        <div class="modal-body">
                            <div class="row">
                                <span style="text-align:center; color: grey"> &nbsp;&nbsp; Today &nbsp; </span> 
                                <span style="text-align:center; color:#796AEE; font:normal 18px book antiqua"> 
                                    {{ $today }} | {{ $currenttime }}
                                </span>
                            </div><br>

                            <form>                                
                                <div class="form-group-material">
                                    <label class="label-control"> Member's Deposit.</label>
                                    <input id="money" name="money" type="number" class="form-control">
                                </div>
                                <div class="form-group-material">
                                    <label class="label-control"> Name of The Bank.</label>
                                    <select class="form-control" id="bank" name="bank">
                                        <option value="Co-op Bank"> Co-op Bank </option>
                                        <option value="Equity Bank"> Equity Bank </option>
                                    </select>
                                </div>                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <!-- End of audios. -->
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                close
                            </button> 
                            <!-- End of audios. -->
                            <input type="button" class="btn btn-primary" id="modal-money" value="Save Changes">
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<script>
    var token = '{{ Session::token() }}';
</script>
<!-- Modal -->