<div class="row">
    <div class="col-md-9">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="font-purple-intense"></i>
                    <span class="caption-subject font-purple-intense ">
                        
                            <i class="fa fa-plus"></i> Edit Promocode
                        
                    </span>
                </div>
                
            </div>
           <div class="portlet-body">
                <?= $this->Form->create($promoCode,['id'=>'form_sample_3']) ?>
                <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Promo Code Type <span class="required" aria-required="true">*</span></label>
                        <select name="promo_code_type" class="form-control select2me" required>

                            <option value=""> Select Promo Code Type </option>
                             <option value="Item Wise" 
                                <?php 
                                if($promoCode->promo_code_type == "Item Wise")
                                    echo "selected";
                                ?>  > Item Wise </option>
                            <option value="Category Wise" 
                            <?php 
                                if($promoCode->promo_code_type == "Category Wise")
                                    echo"selected";
                            ?>  
                            > Category Wise </option>
                            <option value="Free Shipping" 
                            <?php 
                                if($promoCode->promo_code_type == "Free Shipping")
                                 echo "selected";
                            ?>  
                            > Free Shipping </option>
                        
                            <option value="On Cart Value" 
                             <?php 
                                if($promoCode->promo_code_type == "On Cart Value")
                                    echo"selected";
                            ?> 
                            > On Cart Value </option>
                        
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Promo Code Name <span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('code',['placeholder'=>'Promo Code Name','class'=>'form-control input-sm','label'=>false]); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Title<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('title',['placeholder'=>'Title','class'=>'form-control input-sm','label'=>false]); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <div class="radio-list">
                            <label>Type</label>
                                <div class="radio-inline" style="padding-right: 1px;">
                                    <?php 
                                        if($promoCode->amount_type == "percent")
                                        {
                                    ?>
                                    <input type="hidden" name="cash_back_flag" value=""><label for="cash-back-flag-no"><input type="radio" name="amount_type" value="percent" class="radio-task" checked="checked">Percent</label><label for="cash-back-flag-yes"><input type="radio" name="amount_type" value="amount" class="radio-task" >Amount 
                                    <?php }
                                    else{
                                        ?>
                                        <input type="hidden" name="cash_back_flag" value=""><label for="cash-back-flag-no"><input type="radio" name="amount_type" value="percent" class="radio-task">Percent</label><label for="cash-back-flag-yes"><input type="radio" name="amount_type" value="amount" class="radio-task"  checked="checked" >Amount
                                   <?php } ?>


                                    </label>                                </div>
                            </div>
                    </div>
                </div>
                    <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Discount</label>
                        <?php echo $this->Form->control('discount_per',['placeholder'=>'Discount','class'=>'form-control input-sm','label'=>false]); ?>
                    </div></div>
                    <div class="row">
                    <div class="col-md-10">
                        <?php echo $this->Form->control('item_category_id', ['empty'=>'-- select --','options' => $itemCategories,'class'=>'form-control input-sm select select2me select2','required']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Item<span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('item_id',['empty'=>'--Select Item--','options' => $items,'class'=>'form-control input-sm select2me customer_id cstmr chosen-select','label'=>false]); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <?php echo $this->Form->input('is_freeship', array('type'=>'checkbox', 'label'=>'Is Free Ship','id'=>'freeship'));
                        ?>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Cart Value <span class="required" aria-required="true">*</span></label>
                        <?php echo $this->Form->control('cart_value',['placeholder'=>'Cart Value','class'=>'form-control input-sm','label'=>false]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Description<span class="required" aria-required="true">*</span></label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Valid From</label>
                        <?php echo $this->Form->control('valid_from',['readonly','placeholder'=>'Valid From','class'=>'form-control input-sm date-time-range-picker select2','label'=>false]); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <label class=" control-label">Valid To</label>
                        <?php echo $this->Form->control('valid_to',['readonly','placeholder'=>'Valid To','class'=>'form-control input-sm','label'=>false]); ?>
                    </div>
                </div>
                <br/>
                <?= $this->Form->button($this->Html->tag('i', '', ['class'=>'fa fa-plus']) . __(' Submit'),['class'=>'btn btn-success']); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
$(document).ready(function() {
    
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

