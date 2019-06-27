<style>

@media print{
	.maindiv{
		width:100% !important;
	}	
	.hidden-print{
		display:none;
	}
}
p{
margin-bottom: 0;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    padding: 5px !important;
	font-family:Lato !important;
}
</style>

<style type="text/css" media="print">
@page {
    size: auto;   /* auto is the initial value */
    margin: 0px 0px 0px 0px;  /* this affects the margin in the printer settings */
}
</style>
<div style="border:solid 1px #c7c7c7;background-color: #FFF;padding:10px;width: 100%;font-size:14px;" class="maindiv">	

<div align="center" style="color:#F98630; font-size: 16px;font-weight: bold;">Item Wise</div>
	<div style="border:solid 2px #F98630; margin-bottom:0px;"></div>
		<table width="100%">	
			
			<tbody>
				<tr style="background-color:#fff; color:#000;">
					<td align="left" colspan="5">
						<b>
							Item: <?= $itemsales->item->name ?>
						</b>
					</td>
				</tr>
			</table>
			<table width="100%">
				<thead>
				<tr style="background-color:#F98630; color:#fff;">
					<th style="text-align:right;">#</th>
					<th style="text-align:center;">Variation</th>
					<th style="text-align:center;">QTY</th>
					<th style="text-align:center;">Status</th>
				</tr>
				</thead>
				
				<?php
				foreach($item_wise as $itemsales ){ 
					@$i++; ?>
				<tr style="background-color:#fff;">
					<td align="right"><?= $i ?></td>
					
					<td style="text-align:left;"><?= h($itemsales->item_variation->quantity_variation)." ".$itemsales->unit->short_name ?></td>
					<td style="text-align:center;"><?= h($itemsales->quantity) ?></td>
					<td style="text-align:center;"><?= h($itemsales->status) ?></td>
				
				</tr>

				<?php } ?>
			</tbody>
		</table>
	</div>
