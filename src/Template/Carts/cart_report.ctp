<style>
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
	vertical-align: top !important;
}
.error{
	color:#a94442;
}
#item-list{list-style:none;margin-left: 1px;padding:0;width:91%; margin-top: 10px;    position: absolute;
z-index: 1000;
background-color: #fff;}
#item-list li{padding: 7px; background: #d8d4d41a ; border: 1px solid #bbb9b933;}
#item-list li:hover{background:#d8d4d4;cursor: pointer;}
</style>
<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class=" fa fa-gift"></i>
					<span class="caption-subject">Cart</span>
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
								<label class=" control-label">Customer <span class="required" aria-required="true">*</span></label><!-- 
						<?php echo $this->Form->control('customer_id',['empty'=>'--Select Customer--','options' => $customers,'class'=>'form-control input-sm select2me customer_id cstmr chosen-select','label'=>false]); ?> -->
						<input type="text" name="customer" class="form-control input-sm selectedAutoCompleted autocompleted customer_id cstmr chosen-select" valueType="item_name"  autocomplete="off">
						<input type="hidden" name="customer_id" id="customer_id">
						
						 <div class="suggesstion-box"></div>
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
							<th>Variation</th>
							<th>Quantity</th>
							<th>Rate</th>
							
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;
						foreach ($Carts as $Cart):
						$i++;

						?>
						<tr>
							<td><?= $i ?></td>
							<td><?= h(@$Cart->customer->name) ?></td>
							<!-- <td><?= h(@$Cart->item_variation->name) ?></td> -->
							<td><?= h(@$Cart->item->name) ?></td>
							<td><?= h(@$Cart->item_variation->quantity_variation) ." ".  h(@$Cart->item_variation->unit->shortname) ?></td>
							<td><?= h(@$Cart->quantity) ?></td>
							<td><?= h(@$Cart->item_variation->rate) ?></td>
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
$(document).ready(function() {

	 $(document).on('blur',".autocompleted",function(){ //alert("blur");
        $('.suggesstion-box').delay(1000).fadeOut(500);
    }); 

    $(document).on('keyup',".autocompleted",function(){// alert("keyup");
        var searchType = $(this).attr('valueType');
        var input=$(this).val();
        var master = $(this); 
        if(input.length>0){
            var m_data = new FormData();
            var url ="<?php echo $this->Url->build(["controller" => "Carts", "action" => "ajaxAutocompleted"]); ?>";
           //alert(url);
            m_data.append('input',input); 
            m_data.append('searchType',searchType); 
            $.ajax({
                url: url,
                data: m_data,
                processData: false,
                contentType: false,
                type: 'POST',
                dataType:'text',
                success: function(data)
                { 
                	//alert(data);
                    master.closest('div').find('.suggesstion-box').show();
                    master.closest('div').find('.suggesstion-box').html(data);
                   	master.css("background","#FFF");
                }
            });
        }
    });
});

</script>
<script>
function selectAutoCompleted(ids,value) { 
	
    $('.selectedAutoCompleted').val(value);
    $('#customer_id').val(ids);
    $(".suggesstion-box").hide();     
}
function selectAutoCompleted1(value) {  
    $('.selectedAutoCompleted1').val(value);
    $(".suggesstion-box").hide();     
}
</script>