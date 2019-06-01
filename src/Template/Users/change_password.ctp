<?php echo $this->Html->script('/assets/plugins/jquery/jquery-2.2.3.min.js'); ?>
<style>
#Content{ width:90% !important; margin-left: 5%;}
input:focus {background-color:#FFF !important;}
input[type="password"]:focus {background-color:#FFF !important;}
div.error { display: block !important; } 
label { font-weight:100 !important;}
fieldset
{
    border-radius: 7px;
    box-shadow: 0 3px 9px rgba(0,0,0,0.25), 0 2px 5px rgba(0,0,0,0.22);
}
</style>

<section class="content">
<div class="col-md-12"></div>
      <div class="row">
        <div class="col-md-12">
         <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Change Password</h3>
            </div>
            
            <?php  echo $this->Form->create("Users", ['id'=>"UserRegisterForm"]); ?>
            <div class="box-body">
                <div class="col-md-offset-3 col-md-6">
              
                <div class="">
                    <div class="form-group ">
                      <label>Current Password</label>
                      <input type="password" class="form-control" name="old_password" id="old_password" value=""  placeholder="Current Password">
                    </div>
                </div>
                <div class="">
                    <div class="form-group  ">
                      <label>New Password</label>
                      <input type="password" class="form-control" name="password" id="password" value=""  placeholder="New Password">
                    </div>
                </div>
                <div class="">
                     <div class="form-group  ">
                      <label>Confirm New Password</label>
                      <input type="password" class="form-control" name="cpassword" id="cpassword" value=""  placeholder="Confirm New Password">
                    </div>              
                </div>
              <div class="col-md-12">
                <hr></hr>
                <center>
                    <button type="submit" class="btn btn-info">Update Password</button>
                </center>   
              </div>                
                        
                </div>              
            </div>
            </form>
          </div>            
        </div>
       </div>
   </section>
<div class="loader-wrapper" style="width: 100%;height: 100%;  display: none;  position: fixed; top: 0px; left: 0px;    background: rgba(0,0,0,0.25); display: none; z-index: 1000;" id="loader-1">
<div id="loader"></div>
</div>
 <?php echo $this->Html->script(['jquery.validate']);?>   
<script>
 
$('#UserRegisterForm').validate({
    rules: {
        "old_password": {
            required: true
        },
        "password": {
            required: true
        },
        "cpassword": {
            required: true,
            equalTo: "#password"
        }
    },
    messages: {
        "old_password": {
            required: "Please enter current password."
        },
        "password": {
            required: "Please enter password."
        },
        "cpassword": {
            required: "Please enter confirm password.",
            equalTo: "Confirm password should be equal to password."
        }
    },
    ignore: ":hidden:not(select)",
    submitHandler: function (form) {
        $("#loader-1").show();
        form[0].submit(); 
    }
    
});

</script>  
