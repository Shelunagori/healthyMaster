<div class="row">
	<div class="col-md-5 col-sm-5">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						Customer Detail
					</span>
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<h3><?= ucfirst($customers->name) ?></h3>
					<div class="col-md-8">
						<label class=" control-label">Mobile : <?= $customers->mobile?></label>
					</div>
					<div class="col-md-8">
						<label class=" control-label">Email : <?= $customers->email?></label>
					</div>
					<div class="col-md-8">
						<label class=" control-label">Address : 
						<?php
							foreach ($customer_address as $customeradd) {
							echo $customeradd->house_no.','.$customeradd->address.','.$customeradd->locality.'  ';
							}
						?></label>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-7 col-sm-7">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">Order Detail</span>
				</div>
			</div>
			<div class="portlet-body">
				<div style="overflow-y: scroll;height: 170px;">
					<table class="table table-condensed  table-bordered" id="main_tble" >
						<thead>

							<tr>
								<th>Sr</th>
								<th>Order</th>
								<th>Point</th>
								<th>Date</th>
								<th>Total</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($orders as $Order){
							@$t++;
								?>
								<tr>
									<td><?= $t ?></td>
									<td>
										<?php echo $this->Html->link($Order->order_no,['controller'=>'Orders','action' => 'view', $Order->id, 'print'],['target'=>'_blank']); ?>
									</td>
									<td>
										<?php if($points!=null)
												{
													foreach ($points as $point) {
														echo $point->used_point;
													}
													
												}
										?>
									</td>
									<td>
										<?= h(date('d-M-Y', strtotime(@$Order->order_date))) ?>
									</td>
									<td>
										<?= h(@$Order->total_amount) ?>
									</td>
									
									<td>
										<?= h(@$Order->status) ?>
									</td>
								</tr>
							<?php } ?>														 
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-8">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">Cart/Wishlist</span>
				</div>
			</div>
			<div class="portlet-body">
				<div style="overflow-y: scroll;height: 170px;">
					<div class="col-md-5">
						<table class="table table-condensed  table-bordered" id="main_tble" >
							<thead>
								<tr><h4 align="left">Cart</h4></tr>
								<tr>
									<th>Item</th>
									<th width="10%">Variation</th>
									<th>quantity</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($carts as $cart){
								@$t++;
									?>
									<tr>
										<td>
											<?= h(@$cart->item->name) ?>
										</td>
										<td>
											<?= h(@$cart->item_variation->quantity_variation) .' '.$cart->item_variation->unit->shortname?>
										</td>
										</td>
										<td>
											<?= h(@$cart->quantity) ?>
										</td>
										
										<td>
											<?= h(@$cart->amount) ?>
										</td>
									</tr>
								<?php } ?>														 
							</tbody>
						</table>
					</div>
					<div class="col-md-3" style="margin-left: 170px;">
						<table class="table table-condensed  table-bordered" id="main_tble" >
							<thead>
								<tr><h4 align="left">Wishlist</h4></tr>
								<tr>
									<th>Item</th>
									<th>Variation</th>
									<th>Amount</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach($wishlists as $wishlist){
									?>
									<tr>
										<td>
											<?= h(@$wishlist->item->name) ?>
										</td>
										<td>
											<?= h(@$wishlist->item_variation->quantity_variation).' '.$wishlist->item_variation->unit->shortname ?>
										</td>
										<td>
											<?= h(@$wishlist->item_variation->sales_rate) ?>
										</td>
									</tr>
								<?php } ?>														 
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-4">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">Reedeem Points</span>
				</div>
			</div>
			<div class="portlet-body">
				<div style="overflow-y: scroll;height: 170px;">
					<div class="col-md-7">
						<h3>Total Earn :<?php
							foreach($customers->jain_cash_points as $jain_cash_data){
								echo $jain_cash_data->total_point;
							}
								?>
						</h3>
					</div>
					<div class="col-md-7">
						<h3>Total Used :<?php
							foreach($customers->jain_cash_points as $jain_cash_data){
								echo $jain_cash_data->total_used_point;
							}
								?>
						</h3>
					</div>
				</div>
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
				unit_id:{
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
	</script>