<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Transaction'), ['action' => 'edit', $transaction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Transaction'), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Transactions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Transaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Vehicles'), ['controller' => 'Vehicles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vehicle'), ['controller' => 'Vehicles', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parties'), ['controller' => 'Parties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Party'), ['controller' => 'Parties', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="transactions view large-9 medium-8 columns content">
    <h3><?= h($transaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Product') ?></th>
            <td><?= $transaction->has('product') ? $this->Html->link($transaction->product->name, ['controller' => 'Products', 'action' => 'view', $transaction->product->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vehicle') ?></th>
            <td><?= $transaction->has('vehicle') ? $this->Html->link($transaction->vehicle->name, ['controller' => 'Vehicles', 'action' => 'view', $transaction->vehicle->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Batch No') ?></th>
            <td><?= h($transaction->batch_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($transaction->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Party') ?></th>
            <td><?= $transaction->has('party') ? $this->Html->link($transaction->party->name, ['controller' => 'Parties', 'action' => 'view', $transaction->party->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($transaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Mrp') ?></th>
            <td><?= $this->Number->format($transaction->mrp) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($transaction->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Availiable Quantity') ?></th>
            <td><?= $this->Number->format($transaction->availiable_quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($transaction->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited By') ?></th>
            <td><?= $this->Number->format($transaction->edited_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $this->Number->format($transaction->is_deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Dom') ?></th>
            <td><?= h($transaction->dom) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($transaction->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($transaction->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited On') ?></th>
            <td><?= h($transaction->edited_on) ?></td>
        </tr>
    </table>
</div>
