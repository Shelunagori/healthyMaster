<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <div class="col-md-12 col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Products') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.N') ?></th>
                            <th scope="col"><?= __('Name') ?></th>
                            <th scope="col"><?= __('Weight') ?></th>
                            <th scope="col"><?= __('Self Life') ?></th>
                            <th scope="col"><?= __('Price') ?></th>
                            <th scope="col"><?= __('Product Code') ?></th>
                            <th scope="col"><?= __('Piece In Box') ?></th>
                            <th scope="col"><?= __('Box In Crate') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i=1;
                            foreach ($products as $product): ?>
                        <tr style="height:20px;">
                            <td ><?= $i; $i++;?></td>
                            <td><?= h($product->name) ?></td>
                            <td><?= h($product->weight) ?></td>
                            <td><?= $this->Number->format($product->self_life) ?></td>
                            <td><?= $this->Number->format($product->price) ?></td>
                            <td><?= h($product->product_code) ?></td>
                            <td><?= $this->Number->format($product->piece_in_box) ?></td>
                            <td><?= $this->Number->format($product->box_in_crate) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__("<i class='fa fa-pencil' ></i>"), ['action' => 'edit', $product->id],['class'=>'btn btn-sm btn-success','escape'=>false]) ?>
                                <?= $this->Form->postLink(__("<i class='fa fa-trash' ></i>"), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?'),'class'=>'btn btn-sm btn-danger','escape'=>false]) ?>
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
