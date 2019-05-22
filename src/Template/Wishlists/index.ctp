<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wishlist[]|\Cake\Collection\CollectionInterface $wishlists
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Wishlist'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="wishlists index large-9 medium-8 columns content">
    <h3><?= __('Wishlists') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_on') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($wishlists as $wishlist): ?>
            <tr>
                <td><?= $this->Number->format($wishlist->id) ?></td>
                <td><?= $wishlist->has('item') ? $this->Html->link($wishlist->item->name, ['controller' => 'Items', 'action' => 'view', $wishlist->item->id]) : '' ?></td>
                <td><?= $wishlist->has('customer') ? $this->Html->link($wishlist->customer->name, ['controller' => 'Customers', 'action' => 'view', $wishlist->customer->id]) : '' ?></td>
                <td><?= h($wishlist->created_on) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $wishlist->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $wishlist->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $wishlist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wishlist->id)]) ?>
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
