<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CartonTransaction[]|\Cake\Collection\CollectionInterface $cartonTransactions
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>
                    <span class="caption-subject"><?= __('Carton Transactions') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th class="text-capitalize" scope="col"><?= __('id') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('vehicle_no') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('party_id') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('transaction_date') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('status') ?></th>
                            <th class="text-capitalize" scope="col"><?= __('quantity') ?></th>
                            <th scope="col" class="actions text-capitalize"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sr_no = @$_GET['page'] ? $_GET['page'] * 20 : 0; ?>
                        <?php foreach ($cartonTransactions as $key => $cartonTransaction): $sr_no++;?>
                        <tr>
                            <td><?= $this->Number->format($cartonTransaction->id) ?></td>
                            <td><?= h($cartonTransaction->vehicle_no) ?></td>
                            <td><?= $cartonTransaction->has('party') ? h($cartonTransaction->party->name) : '' ?></td>
                            <td><?= h($cartonTransaction->transaction_date) ?></td>
                            <td><?= h($cartonTransaction->status) ?></td>
                            <td><?= $this->Number->format($cartonTransaction->quantity) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__("<i class='fa fa-pencil' ></i>"), ['action' => 'edit', $cartonTransaction->id],['class'=>'btn btn-sm btn-success','escape'=>false]) ?>
                                <?= $this->Form->postLink(__("<i class='fa fa-trash' ></i>"), ['action' => 'delete', $cartonTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $sr_no),'class'=>'btn btn-sm btn-danger','escape'=>false]) ?>
                            </td>
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
