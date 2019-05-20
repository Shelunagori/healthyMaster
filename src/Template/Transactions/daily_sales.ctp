
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Daily Sales & Stock Statement') ?></span>
                </div>
            </div
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col"><?= __('Product') ?></th>
                            <th scope="col"><?= __('MRP') ?></th>
                            <th scope="col"><?= __('Mfg Date') ?></th>
                            <th scope="col"><?= __('Batch No') ?></th>
                            <th scope="col"><?= __('Expire(In days)') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                            foreach ($data as $transaction):
                        ?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= $transaction->product->name ?></td>
                            <td><?= $transaction->mrp?></td>
                            <td><?= $transaction->dom?>
                                 </td>
                            <td><?= $transaction->batch_no?></td>
                            <td><?php
                                    $now = time(); // or your date as well
                                    $your_date = strtotime($transaction->expiry_date);
                                    $datediff =$your_date - $now;

                                    echo round($datediff / (60 * 60 * 24));?></td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>
<?= $this->element('datepicker') ?>


