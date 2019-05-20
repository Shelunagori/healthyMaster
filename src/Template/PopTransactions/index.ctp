<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PopTransaction[]|\Cake\Collection\CollectionInterface $popTransactions
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>
                    <span class="caption-subject"><?= __('Pop Transactions') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th class="text-capitalize" scope="col"><?= __('S.No') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('vehicle_id') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('party_id') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('transaction_date') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('Item') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('status') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('quantity') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sr_no = @$_GET['page'] ? $_GET['page'] * 20 : 0; ?>
                        <?php foreach ($popTransactions as $key => $popTransaction): $sr_no++;?>
                        <tr>
                            <td><?= $sr_no ?></td>
                            <td><?= $popTransaction->has('vehicle') ? h($popTransaction->vehicle->name) : '' ?></td>
                            <td><?= $popTransaction->has('party') ? h($popTransaction->party->name) : '' ?></td>
                            <td><?= h($popTransaction->transaction_date) ?></td>
                            <td><?= h($popTransaction->item) ?></td>
                            <td><?= h($popTransaction->status) ?></td>
                            <td><?= $this->Number->format($popTransaction->quantity) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
        </div>
    </div>
</div>
