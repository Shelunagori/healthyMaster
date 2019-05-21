<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemVariation[]|\Cake\Collection\CollectionInterface $itemVariations
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Item Variation'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemVariations index large-9 medium-8 columns content">
    <h3><?= __('Item Variations') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('unit_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('minimum_stock') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ready_to_sale') ?></th>
                <th scope="col"><?= $this->Paginator->sort('print_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('sales_rate') ?></th>
                <th scope="col"><?= $this->Paginator->sort('out_of_stock') ?></th>
                <th scope="col"><?= $this->Paginator->sort('minimum_quantity_purchase') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($itemVariations as $itemVariation): ?>
            <tr>
                <td><?= $this->Number->format($itemVariation->id) ?></td>
                <td><?= $this->Number->format($itemVariation->item_id) ?></td>
                <td><?= $itemVariation->has('unit') ? $this->Html->link($itemVariation->unit->name, ['controller' => 'Units', 'action' => 'view', $itemVariation->unit->id]) : '' ?></td>
                <td><?= $this->Number->format($itemVariation->minimum_stock) ?></td>
                <td><?= h($itemVariation->ready_to_sale) ?></td>
                <td><?= $this->Number->format($itemVariation->print_rate) ?></td>
                <td><?= $this->Number->format($itemVariation->sales_rate) ?></td>
                <td><?= $this->Number->format($itemVariation->out_of_stock) ?></td>
                <td><?= $this->Number->format($itemVariation->minimum_quantity_purchase) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $itemVariation->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemVariation->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $itemVariation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemVariation->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
