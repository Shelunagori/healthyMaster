<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TemporaryOrder $temporaryOrder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Temporary Order'), ['action' => 'edit', $temporaryOrder->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Temporary Order'), ['action' => 'delete', $temporaryOrder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $temporaryOrder->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Temporary Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Temporary Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['controller' => 'Orders', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['controller' => 'Orders', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="temporaryOrders view large-9 medium-8 columns content">
    <h3><?= h($temporaryOrder->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Order') ?></th>
            <td><?= $temporaryOrder->has('order') ? $this->Html->link($temporaryOrder->order->id, ['controller' => 'Orders', 'action' => 'view', $temporaryOrder->order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($temporaryOrder->id) ?></td>
        </tr>
    </table>
</div>
