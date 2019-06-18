
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Used Promo Code') ?></span>
                </div>
            </div>
            <!-- <div class="portlet-body">
                <?= $this->Form->create($stockReport) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?= $this->Form->label('Product', null, ['class'=>'control-label']) ?>
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
                                <?= $this->Form->label('From', null, ['class'=>'control-label']) ?>
                                <?= $this->Form->control('date',['label'=>false,'type'=>'text','class'=>'form-control date-picker date','data-date-format'=>'dd-M-yyyy','id'=>'date','autocomplete'=>'off']); ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?= $this->Form->label('To', null, ['class'=>'control-label']) ?>
                                <?= $this->Form->control('to',['label'=>false,'type'=>'text','class'=>'form-control date-picker date','data-date-format'=>'dd-M-yyyy','id'=>'to','autocomplete'=>'off']); ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="filter" style="margin-top:25px; ">Filter</button>
                    </div>
                </div>
            </div> -->
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col">Order</th>
                            <th scope="col">Customer</th>
                            <th scope="col">Code</th>
                            <th scope="col">Code Type</th>
                            <th scope="col">Discount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($used_promo as $used_promos):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= $used_promos->order_no?></td>
                            <td><?= $used_promos->customer->name?></td>
                            <td><?= $used_promos->promo_code->code?></td>
                            <td><?= $used_promos->promo_code->promo_code_type?></td>
                            <td><?= $used_promos->promo_code->discount_per." ".$used_promos->promo_code->amount_type?></td>
                        </tr>
                        <?php endforeach;  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>
<?= $this->element('datepicker') ?>


