<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Wishlist $wishlist
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Wishlist'), ['action' => 'edit', $wishlist->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Wishlist'), ['action' => 'delete', $wishlist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $wishlist->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Wishlists'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Wishlist'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Customers'), ['controller' => 'Customers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Customer'), ['controller' => 'Customers', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="wishlists view large-9 medium-8 columns content">
    <h3><?= h($wishlist->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $wishlist->has('item') ? $this->Html->link($wishlist->item->name, ['controller' => 'Items', 'action' => 'view', $wishlist->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Customer') ?></th>
            <td><?= $wishlist->has('customer') ? $this->Html->link($wishlist->customer->name, ['controller' => 'Customers', 'action' => 'view', $wishlist->customer->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($wishlist->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($wishlist->created_on) ?></td>
        </tr>
    </table>
</div>
