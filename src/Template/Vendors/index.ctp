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
					<span class="caption-subject font-purple-intense ">VENDORS
					</span>
				</div>
				<div class="actions">
					<?php echo $this->Html->link('<i class="fa fa-plus"></i> Add new','/Vendors/Add',['escape'=>false,'class'=>'btn btn-default']) ?>
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3" style="width: 200px;">
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Vendor Name</th>
							<th>Mobile No.</th>
							<th>Email</th>
							<th>Address</th>
							<th>City</th>
							<th>State</th>
							<th>GST No</th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach ($vendors as $vendor):
						$i++;

						?>
						<tr>
							<td><?= $i ?></td>
							<td><?= h($vendor->name) ?></td>
							<td><?= h($vendor->mobile) ?></td>
							<td><?= h($vendor->email) ?></td>
							<td><?= h($vendor->address) ?></td>
							<td><?= h($vendor->city->name) ?></td>
							<td><?= h($vendor->state->name) ?></td>
							<td><?= h($vendor->gst_no) ?></td>
							<td class="actions">
								 <?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $vendor->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
							</td>
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