<div class="row">
    <div class="col-md-10">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">ADD PINCODE
                        
                    </span>
                </div>
                
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($pincode,['id'=>'form_sample_3']) ?>
                <div class="row">
                    <div class="col-md-3">
                        <?= $this->Form->control('id',['type'=>'hidden']); ?>
                        <?php echo $this->Form->control('state_id', ['empty'=>'-- select --','options' => $states,'class'=>'form-control input-sm select select2me select2','required']); ?>
                    </div>
                    <div class="col-md-3">
                        <?php echo $this->Form->control('city_id', ['empty'=>'-- select --','options' => $cities,'class'=>'form-control input-sm select select2me select2','required']); ?>
                    </div>
                    <div class="col-md-3">
                        <label class=" control-label">Pincode </label>
                        <?php echo $this->Form->control('pincode',['placeholder'=>'Pincode','class'=>'form-control input-sm','label'=>false]); ?>
                    </div>
                    <div class="col-md-3">
                        <label>We Deliver</label>
                        <select name="we_deliver" class="form-control input-sm wedeliver">
                            <option value="">--Select--</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div><br>
                <div class="row delivery_reason display-none">
                    <div class="col-md-10">
                        <label>Delivery Reason</label>
                        <textarea name="delivery_reason" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row Yesbox display-none">
                    <div class="col-md-3">
                        <label>Amount</label>
                        <input type="text" name="amount" class="form-control input-sm" value="0">
                    </div>
                    <div class="col-md-3">
                        <label>Delivery Charge</label>
                        <input type="text" name="charge" class="form-control input-sm" value="0">
                    </div>
                    <div class="col-md-3">
                        <label>Type</label>
                        <input type="text" name="type" class="form-control input-sm" value="0">
                    </div>
                </div>
                <br/>
                <?= $this->Form->button($this->Html->tag('i', '') . __(' Submit'),['class'=>'btn btn-success']); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {


    $('.wedeliver').on('change',function(){
       var deliver_value=$(this).val();
       if(deliver_value == "No")
       {
            $('.delivery_reason').show();
            $('.Yesbox').hide();
       }
       if(deliver_value == "Yes")
       {
            $('.delivery_reason').hide();
            $('.Yesbox').show();
       }
    });
    
  //--------- FORM VALIDATION
    var form3 = $('#form_sample_3');
    var error3 = $('.alert-danger', form3);
    var success3 = $('.alert-success', form3);
    form3.validate({
        
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: true, // do not focus the last invalid input
        rules: {
                name:{
                    required: true,                  
                },
                franchise_id:{
                    required: true,
                },
                mobile:{
                    required: true,
                },
                address:{
                    required: true,
                }
            },

        errorPlacement: function (error, element) { // render error placement for each input type
            if (element.parent(".input-group").size() > 0) {
                error.insertAfter(element.parent(".input-group"));
            } else if (element.attr("data-error-container")) { 
                error.appendTo(element.attr("data-error-container"));
            } else if (element.parents('.radio-list').size() > 0) { 
                error.appendTo(element.parents('.radio-list').attr("data-error-container"));
            } else if (element.parents('.radio-inline').size() > 0) { 
                error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
            } else if (element.parents('.checkbox-list').size() > 0) {
                error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
            } else if (element.parents('.checkbox-inline').size() > 0) { 
                error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
            } else {
                error.insertAfter(element); // for other inputs, just perform default behavior
            }
        },

        invalidHandler: function (event, validator) { //display error alert on form submit   
            success3.hide();
            error3.show();
        },

        highlight: function (element) { // hightlight error inputs
           $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group
        },

        submitHandler: function (form) {
            success3.show();
            error3.hide();
            form[0].submit(); // submit the form
        }

    });
    //--     END OF VALIDATION
    
    var $rows = $('#main_tble tbody tr');
    $('#search3').on('keyup',function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();
        var v = $(this).val();
        if(v){ 
            $rows.show().filter(function() {
                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
    
                return !~text.indexOf(val);
            }).hide();
        }else{
            $rows.show();
        }
    });
});
</script>

