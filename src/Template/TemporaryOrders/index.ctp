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
                        <i class="fa fa-plus"></i> Temporary Orders
                    </span>
                    <?php
                    echo $this->Html->link('Print',array(),['escape'=>false,'class'=>'btn  blue hidden-print fa fa-print','onclick'=>'javascript:window.print();','style'=>'margin-left : 800px;']);
    
                    ?>
                </div>
               
            </div>
            <div class="portlet-body">
        <?php 
            foreach ($temps as $temp) {
               
                ?>

        <table width="100%" style="margin-top: 20px;">    
            
            <tbody>
                <tr style="background-color:#fff; color:#000;">
                    <td align="left" colspan="5">
                        <b>
                            Order No.: <?= $temp->order->order_no ?>
                        </b>
                       <?php 
                       $temp_id=$temp->id;
                       echo $this->Html->link('Ready To Pack',['controller'=>'Orders','action' =>'readyPacked', $temp->order_id,$temp_id]); 
                       echo $temp->order_id;?>
                    </td>
                </tr>
                
                <tr style="background-color:#fff; color:#000;">
                    <td align="left" colspan="5">
                    <b>Address: </b><?= h(ucwords(@$temp->order->customer_address->name)) ?><br><?= h(@$temp->order->customer_address->house_no) ?> &nbsp;<?= h(ucfirst(@$temp->order->customer_address->address)) ?>,&nbsp;<br/><?= h(ucwords(@$temp->order->customer_address->locality)) ?><br><b>Mobile:</b> <?= h(@$temp->order->customer_address->mobile) ?> 
                    </td>
                </tr>
            </table>
            <table width="100%">
                <thead>
                <tr style="background-color:#F98630; color:#fff;">
                    <th style="text-align:right;">#</th>
                    <th style="text-align:center;">Image</th>
                    <th style="text-align:left;">Item Name</th>
                    <th style="text-align:left;">Variation</th>
                    <th style="text-align:center;">QTY</th>
                    <th style="text-align:center;">Actual QTY</th>
                    <th style="text-align:center;">Rate</th>
                    <th style="text-align:center;">Amount</th>
                </tr>
                </thead>
                
                <?php
                foreach($temp->order->order_details as $order_detail ){ 
                    @$i++;
                    $show_variation=$order_detail->item_variation->quantity_variation.' '.$order_detail->item_variation->unit->shortname;
                    $quantity=$order_detail->quantity;
                    $actual_quantity=$order_detail->actual_quantity;
                    $minimum_quantity_factor=$order_detail->item->minimum_quantity_factor;
                    $unit_name=$order_detail->item_variation->unit->unit_name;
                    $image=$order_detail->item->image;
                    $item_name=$order_detail->item->name;
                    $sales_rate=$order_detail->rate;
                    $alias_name=$order_detail->item->alias_name;
                    $show_quantity=$quantity;
                    if(!empty($actual_quantity)){
                    $show_actual_quantity=$actual_quantity;
                    }
                    else{
                    $show_actual_quantity='-';
                    }
                    $amount=$order_detail->amount;
                    @$total_rate+=$amount;
                    if(!empty($alias_name)){
                        $show_item=$item_name.' ('.$alias_name.')';
                    }else{
                        $show_item=$item_name;
                    } ?>
                <tr style="background-color:#fff;">
                    <td align="right"><?= $i ?></td>
                    <td align="center">
                        <?php echo $this->Html->image('/img/item_images/'.$image, ['height' => '40px', 'width'=>'40px', 'class'=>'img-rounded img-responsive']); ?>
                    </td>
                    <td style="text-align:left;"><?= h($show_item) ?></td>
                    <td style="text-align:left;"><?= h($show_variation) ?></td>
                    <td style="text-align:center;"><?= h($show_quantity) ?></td>
                    <td style="text-align:center;"><?= h($show_actual_quantity) ?></td>
                    <td style="text-align:center;"><?= h($sales_rate) ?></td>
                    <td style="text-align:center;"><?= h($amount) ?></td>
                </tr>
                <?php } ?>
                <?php
                $amount_from_promo_code=$temp->order->amount_from_promo_code;
                $delivery_charge=$temp->order->delivery_charge;
                $amount_from_jain_cash=$temp->order->amount_from_jain_cash;
                $online_amount=$temp->order->online_amount;
                $amount_from_wallet=$temp->order->amount_from_wallet;
                $pay_amount=$temp->order->pay_amount;
                $status=$temp->order->status;
                $grand_total=@$total_rate+$delivery_charge;
                $discount_per=$temp->order->discount_percent;
                ?>
                <tr style="background-color:#fff; border-top:1px solid #000">
                    <td colspan="6">&nbsp;</td><td align="right"><b>Amount</b></td>
                    <td align="center"><b><?= h(@$temp->order->total_amount) ?></b></td>
                </tr>
                
                
                <tr style="background-color:#fff;">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>Delivery Charge</b></td>
                    <td align="center"><b><?= h($delivery_charge) ?></b></td>
                </tr>
                
                <?php if(!empty($discount_per)){ ?>
                <tr style="background-color:#fff; border-top:1px solid #000">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>Discount</b></td>
                    <td align="center"><b><?= h($discount_per) ?><?php echo '%'; ?></b></td>
                </tr>
                <?php } ?>
                
                <tr style="background-color:#F5F5F5; border-top:1px solid #000; border-bottom:1px solid #000">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>Total Amount</b></td>
                    <td align="center"><b><?= h(@$order->grand_total) ?></b></td>
                </tr>
            
                <?php if($temp->order->order_type=="Bulkorder"){ ?>
                <tr style="background-color:#fff; border-top:1px solid #000">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>CGST</b></td>
                    <td align="center"><b><?= h(0) ?></b></td>
                </tr>
                <tr style="background-color:#fff; border-top:1px solid #000">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>SGST</b></td>
                    <td align="center"><b><?= h(0) ?></b></td>
                </tr>
                <?php } ?>
                
                
                <?php if(!empty($amount_from_jain_cash)){ ?>
                <tr style="background-color:#fff; border-top:1px solid #000">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>Redeem Points</b></td>
                    <td align="center"><b><?= h($amount_from_jain_cash) ?></b></td>
                </tr>
                <?php } ?>
                
                <?php if(!empty($online_amount)){ ?>
                <tr style="background-color:#fff;">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>Online Payment</b></td>
                    <td align="center"><b><?= h($online_amount) ?></b></td>
                </tr>
                <?php } ?>
                
                <?php if(!empty($amount_from_wallet)){ ?>
                <tr style="background-color:#fff;">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>Payment From Wallet </b></td>
                    <td align="center"><b><?= h($amount_from_wallet) ?></b></td>
                </tr>
                <?php } ?>
                
                <?php if(!empty($amount_from_promo_code)){ ?>
                <tr style="background-color:#fff;">
                    <td colspan="6">&nbsp;</td>
                    <td align="right"><b>Promo code</b></td>
                    <td align="center"><b><?= h($amount_from_promo_code)?></b></td>
                </tr>
                <?php } ?>
            
                <tr style="background-color:#F5F5F5; border-top:1px solid #000; border-bottom:1px solid #000">
                    <td colspan="6">&nbsp;</td>
                    <td align="right">
                        <b>
                        <?php if(($status=='Delivered') || ($status==' Delivered')){ ?>
                            Total Paid Amount
                        <?php }else{ ?>
                            Due Amount
                        <?php } ?>
                        </b></td>
                    <td align="center"><b><?= h($pay_amount) ?></b></td>
                </tr>
            </tbody>
            
        </table>
    <?php } ?>
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