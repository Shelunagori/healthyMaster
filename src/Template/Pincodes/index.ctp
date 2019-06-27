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
                    <span class="caption-subject font-purple-intense ">PINCODE
                    </span>
                </div>
                <div class="actions">
                    <?php echo $this->Html->link('<i class="fa fa-plus"></i> Add new','/Pincodes/Add',['escape'=>false,'class'=>'btn btn-default']) ?>&nbsp;
                    <input type="text" class="form-control input-sm pull-right" placeholder="Search..." id="search3" style="width: 200px;">
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-condensed table-hover table-bordered" id="main_tble">
                    <thead>
                        <tr>
                            <th>Sr</th>
                            <th>State</th>
                            <th>City</th>
                            <th>PinCode</th>
                            <th>Amount</th>
                            <th>Charge</th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0;
                        foreach ($pincodes as $pincode): 
                        $i++;
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= h($pincode->state->name) ?></td>
                            <td><?= h($pincode->city->name) ?></td>
                            <td><?= h($pincode->pincode) ?></td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo $pincode->delivery_charge->amount;
                                }
                                else{ echo"-";}
                                ?>
                            </td>
                            <td><?php
                                if($pincode->we_deliver == "Yes")
                                {
                                    echo $pincode->delivery_charge->charge;
                                }
                                else{ echo"-";}
                                ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('<span class="fa fa-pencil"></span>'), ['action' => 'edit', $pincode->id],['class'=>'btn btn-primary  btn-condensed btn-sm','escape'=>false]) ?>
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