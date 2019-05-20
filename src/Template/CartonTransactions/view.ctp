<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CartonTransaction $cartonTransaction
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Carton Transaction'), ['action' => 'edit', $cartonTransaction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Carton Transaction'), ['action' => 'delete', $cartonTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cartonTransaction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Carton Transactions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Carton Transaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parties'), ['controller' => 'Parties', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Party'), ['controller' => 'Parties', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="cartonTransactions view large-9 medium-8 columns content">
    <h3><?= h($cartonTransaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Vehicle No') ?></th>
            <td><?= h($cartonTransaction->vehicle_no) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Party') ?></th>
            <td><?= $cartonTransaction->has('party') ? $this->Html->link($cartonTransaction->party->name, ['controller' => 'Parties', 'action' => 'view', $cartonTransaction->party->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($cartonTransaction->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($cartonTransaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($cartonTransaction->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($cartonTransaction->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited By') ?></th>
            <td><?= $this->Number->format($cartonTransaction->edited_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Deleted') ?></th>
            <td><?= $this->Number->format($cartonTransaction->is_deleted) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($cartonTransaction->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created On') ?></th>
            <td><?= h($cartonTransaction->created_on) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Edited On') ?></th>
            <td><?= h($cartonTransaction->edited_on) ?></td>
        </tr>
    </table>
</div>
