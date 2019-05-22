
<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">Wishlist</span>
				</div>
				<div class="actions">
					<input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3"  style="width: 200px;">
				</div>
			</div>
			<div class="portlet-body">
				<form method="post">
						<table width="50%" class="table table-condensed">
					<tbody>
						<tr>
							<td width="5%">
								<label>Customer</label>
								<?php echo $this->Form->input('customer_id', ['empty'=>'--Customers--','options' => $Customers,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Customer']); ?>
							</td>
							
							<td width="5%">
								<label>Item</label>
								<?php echo $this->Form->input('item_id', ['empty'=>'--Items--','options' => $items,'label' => false,'class' => 'form-control input-sm select2me','placeholder'=>'Category']); ?>
							</td>
							
							<td width="5%">
								<label>From</label>
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From"  data-date-format="dd-mm-yyyy">
							</td>	
							<td width="5%">
								<label>To</label>
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To"   data-date-format="dd-mm-yyyy" >
							</td>
							<td width="10%">
								<button type="submit" class="btn btn-success btn-sm" style="margin-top: 23px !important;"><i class="fa fa-filter"></i> Filter</button>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
				<div>
					<table class="table table-condensed table-hover table-bordered" id="main_tble">
					<thead>
						<tr>
							<th>Sr</th>
							<th>Customer</th>
							<!-- <th>Item Variation</th> -->
							<th>Item</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach ($Wishlists as $wishlist):
						$i++;

						?>
						<tr>
							<td><?= $i ?></td>
							<td><?= h(@$wishlist->customer->name) ?></td>
							<!-- <td><?= h(@$wishlist->item_variation->name) ?></td> -->
							<td><?= h(@$wishlist->item->name) ?></td>
							
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
	</div>