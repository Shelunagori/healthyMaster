<?php $curent_date=date('d-m-Y');?>
<div class="col-md-12">
		
			
				<div class="caption" >
					<i class="font-purple-intense"></i>
					<span class="caption-subject font-purple-intense ">
						<h4><i class="fa fa-book"></i> Today's Order Summary</h4></span>
				</div>
		
		
		<div class="row">
			<div class="portlet light bordered">
				<div class="portlet-title">
				<div class="col-lg-12 col-md-3 col-sm-3 col-xs-3">
				<form method="GET" >
				<table width="100%" class="table table-condensed">
					<tbody>
						<tr>
							<td width="2%">
							<?php if(!empty($from_date)){ ?>
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo @date('d-m-Y', strtotime($from_date));  ?>"  data-date-format="dd-mm-yyyy">
							<?php }else{ ?>
								<input type="text" name="From" class="form-control input-sm date-picker" placeholder="Transaction From" value="<?php echo date('d-m-Y');  ?>"  data-date-format="dd-mm-yyyy">
							<?php } ?>	
							</td>	
							<td width="2%">
							<?php if(!empty($to_date)){ ?>
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo @date('d-m-Y', strtotime($to_date));  ?>"  data-date-format="dd-mm-yyyy" >
							<?php }else{ ?>
								<input type="text" name="To" class="form-control input-sm date-picker" placeholder="Transaction To" value="<?php echo date('d-m-Y');  ?>"  data-date-format="dd-mm-yyyy" >
							<?php } ?>	
							</td>
							
							<td width="10%">
								<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-filter"></i> Filter</button>
							</td>
							
						</tr>
					</tbody>
				</table>
			</form>
			</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<div class="dashboard-stat blue-madison">
							<div class="caption">
								<i class="icon-bar-chart font-green-sharp hide"></i>
								<?php echo $this->Html->link('<i class="m-icon-swapright m-icon-white"></i><b> Online Order</b>','/Orders/index?
									status=process&From='.$from_date.'&To='.$to_date,array('escape'=>false,'class'=>'more')); ?>
							</div>
							
							<div class="portlet-body">
								<div class="desc" >
									<table class="table table-condensed" style="color:white;">
											<thead>
											<tr>
												<th></th>
												<td>Order</td>
												<td>Amount</td>
											</tr>										
											</thead>
											<tbody>
											<tr>
												<td><b>In Process</b></td>
												<td><?php echo $inProcessOrder->count;?></td>
												<td><?php if($inProcessOrder->total_amount) { echo '<i class="fa fa-rupee"> </i>' .' '.  $inProcessOrder->total_amount; } else { echo  '0';}?></td>
											</tr>
											<tr>
												<td><b>Delivered</b></td>
												<td><?php echo $deliveredOrder->count; ?></td>
												<td><?php if($deliveredOrder->total_amount) { echo '<i class="fa fa-rupee"> </i>' .' '.  $deliveredOrder->total_amount; } else { echo  '0';}?></td>
											</tr>
											<tr>
												<td><b>Cancel</b></td>
												<td><?php echo $cancelOrder->count;?></td>
												<td><?php if($cancelOrder->total_amount) { echo '<i class="fa fa-rupee"> </i>' .' '.  $cancelOrder->total_amount; } else { echo  '0';}?></td>
											</tr>
											</tbody>
											<tfoot>
											<tr>
												<td><b>Total</b></td>
												<td><?php echo $totalOrder->count;?></td>
												<td><?php if($totalOrder->total_amount) { echo '<i class="fa fa-rupee"> </i>' .' '.  $totalOrder->total_amount; } else { echo  '0';}?></td>
											</tr>
											</tfoot>
									</table>	
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<div class="dashboard-stat purple-soft">
							<div class="caption">
								<i class="icon-bar-chart font-green-sharp hide"></i>
								<?php echo $this->Html->link('<i class="m-icon-swapright m-icon-white"></i><b> Payment Details</b>','/WalkinSales/invoiceReports?
									&From='.$from_date.'&To='.$to_date,array('escape'=>false,'class'=>'more')); ?>
							</div>
							
							<div class="portlet-body">
								<div class="desc" >
									<table class="table table-condensed" style="color:white;">
											<thead>
											<tr>
												<td>Payment Type</td>
												<td>Amount</td>
											</tr>										
											</thead>
											<tbody>
											<tr>
												<td><b>Wallet Payment</b></td>
												<td><?php if($wallet_amount->total_amount) { echo '<i class="fa fa-rupee"> </i>' .' '. $wallet_amount->total_amount; } else { echo  '0';}?></td>
												</tr>
											<tr>
												<td><b>Online Payment</b></td>
												<td><?php if($online_amount->total_amount) { echo '<i class="fa fa-rupee"> </i>' .' '. $online_amount->total_amount; } else { echo  '0';} ?></td></tr>
											<tr>
												<td><b>Cash Payment</b></td>
												<td><?php if($pay_amount->total_amount) { echo '<i class="fa fa-rupee"> </i>' .' '. $pay_amount->total_amount; } else { echo  '0';} ?></td></tr>
											</tbody>
											<tfoot>
											<tr>
												<td><b>Total Sale</b></td>
												<td><?php if($total_sale_amount->total_amount) { echo '<i class="fa fa-rupee"> </i>' .' '.  $total_sale_amount->total_amount; } else { echo  '0';} ?></td></tr>
											</tfoot>
									</table>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</div>