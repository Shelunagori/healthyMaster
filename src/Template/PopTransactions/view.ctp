<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PopTransaction $popTransaction
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pop Transaction'), ['action' => 'edit', $popTransaction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pop Transaction'), ['action' => 'delete', $popTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $popTransaction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pop Transactions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pop Transaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vehicles'), ['controller' => 'Vehicles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vehicle'), ['controller' => 'Vehicles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parties'), ['controller' => 'Parties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Party'), ['controller' => 'Parties', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="popTransactions view large-9 medium-8 columns content">
    <h3><?= h($popTransaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Vehicle') ?></th>
            <td><?= $popTransaction->has('vehicle') ? $this->Html->link($popTransaction->vehicle->name, ['controller' => 'Vehicles', 'action' => 'view', $popTransaction->vehicle->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Party') ?></th>
            <td><?= $popTransaction->has('party') ? $this->Html->link($popTransaction->party->name, ['controller' => 'Parties', 'action' => 'view', $popTransaction->party->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= h($popTransaction->Item) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($popTransaction->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($popTransaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($popTransaction->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($popTransaction->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited By') ?></th>
            <td><?= $this->Number->format($popTransaction->edited_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $this->Number->format($popTransaction->is_deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($popTransaction->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($popTransaction->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited On') ?></th>
            <td><?= h($popTransaction->edited_on) ?></td>
        </tr>
    </table>
</div>
