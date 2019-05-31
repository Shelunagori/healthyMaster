<style>
.table>thead>tr>th{
	font-size:12px !important;
}
</style>
<div class="row">
	<div class="col-md-12">
	<?= $this->Form->create($itemvariation,['id'=>'form_sample_3']) ?>
	
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<i class="fa fa-plus"></i> Sales Rate Module
					</span>
				</div>
				<div class="actions">
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3" style="width: 200px;">
				</div>
			</div>
			<div class="portlet-body">
				<?php $i=0; foreach ($item_variations as $item_variation): ?>	
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th colspan="7"><?php
								$item_name=$item_variation->item->name;
								$alias_name=$item_variation->item->alias_name;
								?>
								<?= h(@$item_name. ' ('.$alias_name.')') ?></th>
						</tr>
						<tr>
							<th>Sr</th>
							<th>Category</th>
							<th width="100">Unit</th>
							<th>Print Rate</th>
							<th>Online Sale Rate</th>
							<th>Item Discount %</th>
							<th width="100">
								Ready to Sale
								<?php echo  $this->Form->control('rts',['class'=>'form-control input-sm all','options'=>['empty'=>'--All--', 'Yes'=>'Yes','No'=>'No'], 'label'=>false]); ?>
							</th>
							
						</tr>
					</thead>
					<tbody id="main_tbody">
						<tr class="main_tr">
							<td><?php echo ++$i; $i--; ?>
							<?php echo  $this->Form->control('itemVariations['.$i.'][id]',['class'=>'form-control input-sm','value'=>$item_variation->id,'type'=>'hidden']); ?></td>
							
							</td>
							<td><?= h(@$item_variation->item->item_category->name) ?></td>
                            
							<td style="font-size:10px;">
								Rate per <b style="font-size:12px;"><?= $item_variation->quantity_variation." ".h($item_variation->unit->shortname) ?></b>
							</td>
							<td>
								<?php echo  $this->Form->control('itemVariations['.$i.'][print_rate]',['class'=>'form-control input-sm  print_rate','placeholder'=>'Print Rate', 'value'=>$item_variation->print_rate,'label'=>false]); ?></td>
							<td>
								<?php echo  $this->Form->control('itemVariations['.$i.'][sales_rate]',['class'=>'form-control input-sm  sales_rate','placeholder'=>'Print Rate', 'value'=>$item_variation->sales_rate,'label'=>false]); ?></td>

							<td>
								<?php echo  $this->Form->control('itemVariations['.$i.'][discount_per]',['class'=>'form-control input-sm  discount_per','placeholder'=>'Print Rate', 'value'=>$item_variation->discount_per,'label'=>false]); ?></td>								
							</td>
							
							<td>
								<?php echo  $this->Form->control('itemVariations['.$i.'][ready_to_sale]',['class'=>'form-control input-sm single','options'=>['Yes'=>'Yes','No'=>'No'], 'value'=>$item_variation->ready_to_sale,'label'=>false]); ?>
							</td>
						</tr>
						
						
					</tbody>
				</table>
				<?php $i++; endforeach; ?>
				<div align="center">
					<?= $this->Form->button($this->Html->tag('i', '', ['class'=>'fa fa-plus']) . __(' Update Sales Rate'),['class'=>'btn btn-success','id'=>'submitbtn']); ?>
				</div>
			</div>
		</div>
		<?= $this->Form->end() ?>
	</div>
</div>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
<script>
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
</script>


<script>
$(document).ready(function(){
	
	$(".print_rate").die().live("keyup",function(){
		 var print_rate=$(this).val();
		 discount_per=$(this).closest('tr').find('.discount_per').val();
		 t_amount=print_rate*discount_per/100;
		 sale_amt=print_rate-t_amount;
		 $(this).closest('tr').find('.sales_rate').val((sale_amt).toFixed(2));
	});

	$(".discount_per").die().live("keyup",function(){
		 var discount_per=$(this).val();
		 print_rate=$(this).closest('tr').find('.print_rate').val();
		 
		  t_amount=print_rate*discount_per/100;
		 sale_amt=print_rate-t_amount;
		 $(this).closest('tr').find('.sales_rate').val((sale_amt).toFixed(2));
		 $(this).closest('tr').find('.offline_sales_rate').val((sale_amt).toFixed(2));
	});
	
	$(".sales_rate").die().live("keyup",function(){
		 var sales_rate=$(this).val();
		 print_rate=$(this).closest('tr').find('.print_rate').val();
		 //discount_per=$(this).closest('tr').find('.discount_per').val();
		 
		 var diff_amount=print_rate-sales_rate;
		 
		 var discount_per=diff_amount*100/print_rate;
		 
		 
		 $(this).closest('tr').find('.discount_per').val((discount_per).toFixed(2));
	});

	$(".all").die().live('change',function(){
		var raw_attr_name = $('option:selected', this).val();
		$(".single option[value="+raw_attr_name+"]").attr('selected','selected');
	});
		
		
});
</script>