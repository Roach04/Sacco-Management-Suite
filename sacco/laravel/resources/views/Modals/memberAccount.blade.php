<!-- Modal -->
<div style="margin-top:45px" id="memberaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
    <div role="document" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font:normal 18px book antiqua" id="exampleModalLabel" class="modal-title">
                    <span style="color:#796AEE; font:normal 18px book antiqua" id="firstname"></span> <span style="color:#796AEE; font:normal 18px book antiqua" id="lastname"> </span>'s Account.
                </h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            
            <div class="modal-body">
                <div class="row">
                    <div class="container">
                        <div class="pull-left">
                            <span style="color: grey"> Today &nbsp; </span> 
                            <span style="color:#796AEE; font:normal 18px book antiqua"> 
                                {{ $today }} <span style="color:black"> | </span> {{ $currenttime }}
                            </span>
                        </div>

                        <div class="pull-right">
                            <span style="color: grey"> Created On &nbsp; </span> 
                            <span id="createdAt" style="color:#796AEE; font:normal 18px book antiqua"> </span> 
                            &nbsp; <span style="color:black"> | </span> &nbsp;
                            <span style="color: grey"> Last Update &nbsp; </span> <span id="updatedAt" style="color:#796AEE; font:normal 18px book antiqua"> </span>
                        </div>
                    </div>
                </div>
                <br><br>
                <form> 
                    <p style="font:bold 28px book antiqua"> Member Details. </p><br>
                    <div class="row"> 
                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Firstname.</label>
                            <input id="first" name="firstname" type="text" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Surname.</label>
                            <input id="sur" name="surname" type="text" class="form-control">
                        </div>
                        
                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Lastname.</label>
                            <input id="last" name="lastname" type="text" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Account Type.</label>
                            <input id="type" name="accountType" type="text" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Phone Number.</label>
                            <input id="phone" name="phoneNumber" type="number" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> ID Number.</label>
                            <input id="idNo" name="idNumber" type="number" class="form-control">
                        </div>
                        
                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Date Of Birth.</label>
                            <input id="birth" name="dateOfBirth" type="date" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Po Box.</label>
                            <input id="box" name="poBox" type="text" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Email Address.</label>
                            <input id="mail" name="emailAddress" type="text" class="form-control">
                        </div>
                        
                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> County.</label>
                            <input id="county" name="county" type="text" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Nationality.</label>
                            <input id="nation" name="nationality" type="text" class="form-control">
                        </div> 
                    </div>
  
                    <div style="width: 100%; height: 1px; border-bottom: 1px dashed #eee; margin: 30px 0;"></div>

                    <p style="font:bold 28px book antiqua"> Next of Kin. </p><br>
                    <div class="row"> 
                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Firstname.</label>
                            <input id="firstKin" name="firstnameKin" type="text" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Surname.</label>
                            <input id="surKin" name="surnameKin" type="text" class="form-control">
                        </div>
                        
                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Lastname.</label>
                            <input id="lastKin" name="lastnameKin" type="text" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Phone Number.</label>
                            <input id="phoneKin" name="phoneNumberKin" type="number" class="form-control">
                        </div>

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> ID Number.</label>
                            <input id="idNoKin" name="idNumberKin" type="number" class="form-control">
                        </div>
                        
                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Date Of Birth.</label>
                            <input id="birthKin" name="dateOfBirthKin" type="date" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Relationship with Kin.</label>
                            <input id="relateKin" name="relationshipKin" type="text" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Po Box.</label>
                            <input id="boxKin" name="poBoxKin" type="text" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Email Address.</label>
                            <input id="mailKin" name="emailAddressKin" type="text" class="form-control">
                        </div>
                        
                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> County.</label>
                            <input id="countyKin" name="countyKin" type="text" class="form-control">
                        </div> 

                        <div class="col-md-3 col-sm-4 form-group-material">
                            <label class="label-control"> Nationality.</label>
                            <input id="nationKin" name="nationalityKin" type="text" class="form-control">
                        </div> 
                    </div> 
                    <div id="member-success"> </div> 
                    <div id="member-failure"> </div>                    
                </form>
            </div>

            <div class="modal-footer" >
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>  
                <input type="button" class="btn btn-primary" id="modal-member" value="Save Changes">              
            </div>
            
        </div>
    </div>
</div>
<script>
    var token = '{{ Session::token() }}';
</script>
<!-- Modal -->