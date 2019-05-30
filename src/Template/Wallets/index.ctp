<div class="row">
		<div class="col-md-12">
			<div class="portlet">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<i class="fa fa-plus"></i> Wallet
					</span>
				</div>
				
			</div>
		<div class="portlet-body"> 
				<!-- 	<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<span>
								<B>Wallet</B>
								</span>
							</div>
					
						</div>
						<div class="row">
						<div class="col-md-12">
						<div class="col-md-3"></div>
						<div class="col-md-2">
						<div class="actions" align>
						<?php echo $this->Html->link('<i class="fa fa-plus"></i> View All','/Wallets/view_all',['escape'=>false,'class'=>'btn btn-default']) ?>
						</div>
						</div><div class="col-md-2">
						<div class="actions">
						<?php echo $this->Html->link('<i class="fa fa-plus"></i> Wallet Amount','/Wallets/wallet',['escape'=>false,'class'=>'btn btn-default']) ?>
						</div>
						</div><div class="col-md-2">
						<div class="actions">
						<?php echo $this->Html->link('<i class="fa fa-plus"></i> Consumed wallet','/Wallets/consumed',['escape'=>false,'class'=>'btn btn-default']) ?>
						</div></div>
						<div class="col-md-3"></div>
						</div>
						</div>
				</div> -->

				<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<tr>
								<th>Sr</th>
								<th>Order No</th>
								<th>Customer</th>
								<th>Plan</th>
								<th>Online Amount</th>
								<th>Delivery Charge</th>
								
							</tr>
						</tr>
					</thead>
					<tbody>
						<?php $sr_no=0; foreach ($wallets as $wallet): ?>
						<tr>
							<td><?= $this->Number->format(++$sr_no) ?></td>
							<td><?= h($wallet->order_no) ?></td>
							<td><?= h($wallet->customer->name) ?></td>
							<td><?= h($wallet->plan->name) ?></td>
							<td><?= h($wallet->order->online_amount) ?></td>
							<td><?= h($wallet->order->delivery_charge) ?></td>
							
							<!-- <td class="actions">
								<?= $this->Html->link(__('View'), ['action' => 'view', $wallet->id]) ?>
								<?php if($status=='open'){ ?>
								<?= $this->Html->link(__('Book Invoice'), ['controller'=>'PurchaseBookings', 'action' => 'add', $wallet->id]) ?>
								<?php } ?>
							</td> -->
							
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
</div>
</div>
</div>
</div>