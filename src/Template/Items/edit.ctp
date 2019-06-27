<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<i class="fa fa-plus"></i> Add Item
					</span>
				</div>
				<div class="actions">
				</div>
			</div>
			<div class="portlet-body">
			<?= $this->Form->create($item,['type'=>'file','id'=>'form_sample_3']) ?>
				<div class="row">
					<div class="col-md-3">
						<?php echo $this->Form->control('name',['class'=>'form-control input-sm','placeholder'=>'Item Name']); ?>
						<input type="hidden" name="id" value="<?= $item->id ?>">
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('alias_name',['class'=>'form-control input-sm','placeholder'=>'Alias Name']); ?>
					</div>
					<!-- <div class="col-md-3">
						<?php echo $this->Form->control('unit_id', ['empty'=>'--select--','options' => $unit_option,'class'=>'form-control input-sm attribute']); ?>
					</div> -->
					<div class="col-md-3">
						<?php echo $this->Form->control('item_category_id', ['empty'=>'--select--','options' => $itemCategories,'class'=>'form-control input-sm','required']); ?>
					</div>
					<div class="col-md-3">
						<div class="radio-list">
						<label>Ready To Sale</label>
						<div class="form-control input-sm" style="padding-right: 1px;">
							<label class='radio-inline'><input type='radio' name='ready_to_sale' value='yes' >Yes </label><label class='radio-inline'><input type='radio' name='ready_to_sale' value='no' checked="checked">No </label>
						</div>
					</div>
					</div>

				</div><br/>
				<div class="row">
					
					<!-- <div class="col-md-3">
						<label class="control-label">Maximum Order Limit<span class="required" aria-required="true"></span></label>
						<?php echo $this->Form->control('minimum_quantity_purchase',['class'=>'form-control input-sm order_limit','placeholder'=>'Maximum Order Limit', 'label'=>false]); ?>
						<span id="msg2"></span>
					</div> -->
					<!--<div class="col-md-3">
						<?php
						$gst['Yes']='Yes';
						$gst['No']='No';
						//echo $this->Form->control('gst_apply', ['empty'=>'--select--','options' => $gst,'class'=>'form-control input-sm attribute gst','value'=>$item->gst_apply]); ?> 
					</div>-->
					<div class="col-md-3 gst_show">
						<?php echo $this->Form->control('gst_figure_id', ['empty'=>'--select--','options' => $GstFigures,'class'=>'form-control input-sm attribute','value'=>$item->gst_figure_id]); ?>
					</div>

					<div class="col-md-3">
						 <?= $this->Form->input('image',['class'=>'form-control','type'=>'File']) ?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->control('description', ['class'=>'form-control input-sm','placeholder'=>'Description']); ?>
						<input type="hidden" name="is_virtual" value="real">
					</div>
				</div>
					
				<div class="row">
                        <div class="col-md-12" style="margin-top: 10px;">
                              <table class="table table-striped table-bordered">
                                  <thead>
                                      <tr>
                                          <th>S.No</th>
                                          <th>Quantity Variation</th>
                                          <th>Unit</th>
                                          <th>Minimum Stock</th>
                                          <th>Maximum Order Limit</th>
                                          <th>Ready To Sale</th>
                                          <th>Actions</th>
                                      </tr>
                                  </thead>
                                  <tbody id="main-tbody">
                                  	<?php
                                  	$i=0;
								foreach($variations as $variation){
									$unit=$variation->unit->id;
									$variation_id=$variation->id;
									?>
                                  	<tr>
                                  		<input type="hidden" name="item_variations[<?= $i ?>][id]" value="<?= $variation_id ?>">
                                  		<?php $i++; ?>
					                    <td style="vertical-align: bottom;" class="index"><?= $i ?></td>
					                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('item_variations.0.quantity_variation',['class'=>'form-control quantity_variation','id'=>false,'label'=>false,'required','value'=>@$variation->quantity_variation]); ?>
					                    	 
					                    </td>
					                    <td style="vertical-align: bottom;">
					                    <?php echo $this->Form->control('item_variations.0.unit_id', ['empty'=>'--select--','options' => @$units,'class'=>'form-control unit','label'=>false,'value'=>$unit]); ?>
					                    </td>
					                    <td style="vertical-align: bottom;"> 
					                    	<?php echo $this->Form->control('item_variations.0.minimum_stock',['class'=>'form-control minimum_stock','placeholder'=>'Minimum Stock','label'=>false,'value'=>$variation->minimum_stock]); ?>
					                    </td>
					                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('item_variations.0.minimum_quantity_purchase',['class'=>'form-control minimum_quantity_purchase  order_limit','placeholder'=>'Maximum Order Limit', 'label'=>false,'value'=>$variation->minimum_quantity_purchase]); ?></td>
					                    <td><div class="myRadio" style="display: inline-block;"></div></td>
					                    <td style="vertical-align: bottom;"> <button type="button" id="plus" class="btn btn-sm green"><i class="fa fa-plus"></i></button>
					                      <button type="button" id="minus" class="btn btn-sm red" row_id="<?= $variation_id?>"><i class="fa fa-minus"></i></button></td>
					                </tr>
					            <?php } ?>
					                                  </tbody>
                              </table>
                            </div>
                        </div>
			<?= $this->Form->button(__('Create new item'),['class'=>'btn btn-success']) ?>
			<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
<table>
              <tbody id="sub-body" class="hidden">
              	
                <tr>
                    <td style="vertical-align: bottom;" class="index"> </td>
                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('item_variations.0.quantity_variation',['class'=>'form-control quantity_variation','id'=>false,'label'=>false,'required']); ?></td>
                    <td style="vertical-align: bottom;">
                    <?php echo $this->Form->control('item_variations.0.unit_id', ['empty'=>'--select--','options' => @$unit_option,'class'=>'form-control unit','label'=>false]); ?>
                    </td>
                    <td style="vertical-align: bottom;"> 
                    	<?php echo $this->Form->control('item_variations.0.minimum_stock',['class'=>'form-control minimum_stock','placeholder'=>'Minimum Stock','label'=>false]); ?>
                    </td>
                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('item_variations.0.minimum_quantity_purchase',['class'=>'form-control minimum_quantity_purchase  order_limit','placeholder'=>'Maximum Order Limit', 'label'=>false]); ?></td>
                    <td><div class="myRadio" style="display: inline-block;"></div></td>
                    <td style="vertical-align: bottom;"> <button type="button" id="plus" class="btn btn-sm green"><i class="fa fa-plus"></i></button>
                      <button type="button" id="minus" class="btn btn-sm red"><i class="fa fa-minus"></i></button></td>
                </tr>
              </tbody>
            </table>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>

<script>
$(document).ready(function() {
	/* var gst_apply = $('.gst').val();
	if(gst_apply=='Yes'){
		$('.gst_show').show();
	}else{
		$('.gst_show').hide();
	}
	
$('.gst').on('change',function(){
	var gst_apply=$(this).val();
	if(gst_apply=='Yes'){
		$('.gst_show').show();
	}else{
		$('.gst_show').hide();
	}
}); */
	
	
	rename_row();

	 var radio = "<label class='radio-inline'><input type='radio' name='item_variations[0][ready_to_sale]' class='ready' value='yes'>Yes </label><label class='radio-inline'><input type='radio' name='item_variations[0][ready_to_sale]' class='ready' value='no' checked>No </label>";

   

	 $('.myRadio').html(radio);
	 $(document).on('click','#plus',function(){

           add_row();
      });
        $(document).on('click','#minus',function(){

           var count=$('#main-tbody').children().length;
           var url="<?php echo $this->Url->build(["controller" => "ItemVariations", "action" => "delete"]); ?>";
            if(count >= 2)
            {
                var id = $(this).attr('row_id');
                if(id)
                {
                    var confirms = confirm('Are you sure you want to delete ?');
                    if(confirms)
                    {
                        $.ajax({
                            url: url,
                            type: 'post',
                            data: {id: id},
                            success: function (success) {
                                if(success == 1)
                                {
                                    
                                    $(this).parent().parent().remove();
                                    rename_row(); 
                                }
                                else
                                {
                                    alert('Not Deleted');
                                }
                            }
                        });
                    }
                }
                else
                {
                    $(this).parent().parent().remove();
                    rename_row();
                }
            }
        }); 
	function add_row()
    {

      var tr = $('#sub-body>tr:last').clone();
      $('#main-tbody').append(tr);
      $('#main-tbody>tr:last').find('.myRadio').html(radio); 
      rename_row();
    }
   function rename_row()
      {
        var i=0;
        var a=1;
        $('#main-tbody').find('tr').each(function()
        {
            
            $(this).find('.index').html(a);
            $(this).find('.quantity_variation').attr('name','item_variations['+i+'][quantity_variation]');
            $(this).find('.unit').attr('name','item_variations['+i+'][unit_id]');
            $(this).find('.ready').attr('name','item_variations['+i+'][ready_to_sale]');
            $(this).find('.minimum_stock').attr('name','item_variations['+i+'][minimum_stock]');
            $(this).find('.minimum_quantity_purchase').attr('name','item_variations['+i+'][minimum_quantity_purchase]');
			i++;
			a++
          });
          
       }

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
				unit_id:{
					required: true,
				},
				image:{
					required: false,
				},
				alias_name:{
					required: false,
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
	//--	 END OF VALIDATION
	
	$(".attribute").die().live('change',function(){
		var unt_attr_name = $('option:selected', this).attr('unit_name');	
			$("#msg").html('Minimum Stock in '+ unt_attr_name);
			if(unt_attr_name=='kg'){
				var data=$("#data_fetch").html();
				$(".set").html(data);
			}else{
				var data=$("#data_fetch2").html();
				$(".set").html(data);
			}
 	});
	$(".order_limit").die().live('keyup',function(){
	var unt_attr_name = $('.attribute option:selected').attr('unit_name');
	var limit = $(".order_limit").val();
	var final_value = $(this).val();
		if(unt_attr_name=='kg'){
				var quantity_factor = $(".qunt_factor option:selected").val();
				var total = quantity_factor*limit;
				$("#msg2").html(final_value +' '+ unt_attr_name);
			}else{
				$("#msg2").html(final_value +' '+ unt_attr_name);
			}
	});

	$(".virt").die().live('click',function(){
		var virtual = $(this).val();
			if(virtual=='yes'){
				var data=$("#fetch").html();
 				$(".set2").html(data);
				$('.virtual_box').select2();
			}else{
				$(".set2").html('');
			}
 	});
});
</script>
<?php
	$factor_select[]= ['value'=>0.10,'text'=>'100 gm'];
	$factor_select[]= ['value'=>0.25,'text'=>'250 gm'];
	$factor_select[]= ['value'=>0.50,'text'=>'500 gm'];
	$factor_select[]= ['value'=>1,'text'=>'1 kg'];
	$factor_select[]= ['value'=>2,'text'=>'2 kg'];
?>
<div id="data_fetch" style="display:none;">
	<?php echo $this->Form->control('minimum_quantity_factor', ['options' => $factor_select,'class'=>'form-control input-sm qunt_factor']); ?>
</div>

<div id="data_fetch2" style="display:none;">
	<?php echo $this->Form->control('minimum_quantity_factor', ['class'=>'form-control input-sm qunt_factor', 'placeholder'=>'Minimum Quantity Factor']); ?>
</div>

<div id="fetch" style="display:none;">
	<?php echo $this->Form->control('parent_item_id', ['options' => $item_fetchs, 'class'=>'form-control input-sm virtual_box']); ?>
</div>