<style type="text/css">
    .error{
            color:  #c54848 !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Available Report') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($transaction) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('Product', null, ['class'=>'control-label ']) ?>
                                    <select name='product_id' class="form-control select2me input-sm product_id" id="product_id" required>
                                      <option>--Select--</option>
                                      <?php foreach($products as $key => $product):?>
                                        <option crate="<?= $product['box_in_crate'];?>" box="<?= $product['piece_in_box'];?>" total="<?= $product['total'] ?>" value="<?= $product['id'] ?>" price="<?= $product['price']?>"><?= $product['name']; ?> (<?= $product['weight']; ?>)
                                      <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                   <button class="btn btn-sm yellow" style="margin-top : 26px;"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="portlet-body">
                <?php
                if(!@$data == null)
                { ?>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col"><?= __('Available Quantity') ?></th>
                            <th scope="col"><?= __('DOM') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($data as $transaction):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?php
                                foreach ($crate as $crates) {
                                    $reminder=$transaction->amount_sum % $crates['box_in_crate'];
                                    if($reminder==0)
                                    {
                                        echo "Box =".$transaction->amount_sum."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                       echo "Crate = ".number_format($transaction->amount_sum / $crates['box_in_crate']);
                                    }
                                    else
                                    {
                                        echo "Box = ".$transaction->amount_sum."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                       echo "Crate = ".number_format($transaction->amount_sum / $crates['box_in_crate']).".".$reminder;
                                    }
                                } ?>
                                 </td>
                            <td><?= $transaction->dom ?></td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>


