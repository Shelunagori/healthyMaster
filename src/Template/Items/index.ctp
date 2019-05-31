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
						<i class="fa fa-plus"></i> Items
					</span>
				</div>
				<div class="actions">
					<?php echo $this->Html->link('<i class="fa fa-plus"></i> Add New','/Items/Add',['escape'=>false,'class'=>'btn btn-default']) ?> 
					
					<?php if($status=='freeze'){
						$class1="btn btn-xs blue";
						$class2="btn btn-default";
					}elseif($status=='unfreeze' or $status==''){
						$class1="btn btn-default";
						$class2="btn btn-xs blue";
					}
					 ?>
						<?php echo $this->Html->link('Unfreeze',['controller'=>'Items','action' => 'index/unfreeze'],['escape'=>false,'class'=>$class2]); ?>
						<?php echo $this->Html->link('Freeze',['controller'=>'Items','action' => 'index/freeze'],['escape'=>false,'class'=>$class1]); ?>&nbsp;
						 
						<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3" style="width: 200px;">
				
				</div>
			</div>
			<div class="portlet-body">
				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Name</th>
							<th>Alias Name</th>
							<th>Item Category</th>
							<th>Freeze</th>
							<th>Image</th>
							<th scope="col" class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($items as $item): 
							@$i++;
							?>
						<tr>
							<td><?= h($i) ?></td>
							<?php 
							$name=$item->name;
							$alias_name=$item->alias_name;
							if(!empty($alias_name)){ ?>
								<td><?php echo $name.' ('.$alias_name.')'; ?></td>
							<?php }else{ ?>
								<td><?= h($name) ?></td>
							<?php } ?>
							<td><?= $item->alias_name?></td>
							<td><?= h($item->item_category->name) ?></td>
							
							<td><?= h($item->freeze) ?></td>
							<td><img style="height:2%;" src="/healthyMaster/webroot/img/item_images/<?= $item->image ?>" ></td>
							<td class="actions">
								<?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id]) ?>
								<?php if($status=='unfreeze' or $status==''){ ?>
								<?= $this->Form->postLink(__('Freeze'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?>
								<?php } ?>
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