<!-- Modal -->
<div style="margin-top:60px;" id="installmentupdatemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade col-lg-12">
    <div style="width:1250px" role="document" class="modal-dialog">    
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font:bold 22px book antiqua" id="exampleModalLabel" class="modal-title">
                    <span id="bankAccName"></span>'s Account.
                </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="container" style="margin-top:20px">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="failure"> </div>
                        <div id="installment-failure"> </div>
                        <div id="installment-success"> </div>
                        <div class="modal-body">
                            <div class="row">
                                <span style="text-align:center; color: grey"> Today &nbsp; </span> 
                                <span style="text-align:center; color:#796AEE; font:normal 18px book antiqua"> 
                                    {{ $today }} | {{ $currenttime }}
                                </span>
                            </div> <br><br>
                            <form>                                
                                <div class="form-group-material">
                                    <label class="label-control"> Update the Monthly Installment.</label>
                                    <input type="number" id="installment" name="installment" class="form-control">
                                    <input type="hidden" id="id" name="id">
                                </div>                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <!-- End of audios. -->
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                close
                            </button> 
                            <!-- End of audios. -->
                            <input type="button" class="btn btn-primary" id="modal-installment-update" value="Save Changes">
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