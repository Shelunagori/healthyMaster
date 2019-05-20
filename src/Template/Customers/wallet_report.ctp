<style>
.table>thead>tr>th{
	font-size:12px !important;
}
</style>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<i class="fa fa-plus"></i> Customers Wallet Report
					</span>
				</div>
				<div class="actions">
					<?php echo $this->Html->link('<i class="fa fa-plus"></i> Add new','/Customers/Add',['escape'=>false,'class'=>'btn btn-default']) ?>&nbsp;
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3" style="width: 200px;">
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Name</th>
							<th>Order Count</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$k=0;
						foreach ($wallet_customers as $data):
						$customer_id=$data->customer_id;
						$amount=$remainings[$customer_id]; 
						if($amount==0){
							continue;
						}
						$k++;
						$name=$data->customer->name;
						$mobile=$data->customer->mobile;
						$show_name=$name.'('.$mobile.')';
						?>
						<tr>
							<td><?= $k ?></td>
							<td><?= h($show_name) ?></td>
							<td><?= h($amount) ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			
		</div>
	</div>
</div>
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