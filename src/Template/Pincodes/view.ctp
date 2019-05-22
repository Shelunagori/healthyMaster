<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pincode $pincode
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pincode'), ['action' => 'edit', $pincode->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pincode'), ['action' => 'delete', $pincode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pincode->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pincodes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pincode'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pincodes view large-9 medium-8 columns content">
    <h3><?= h($pincode->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('City') ?></th>
            <td><?= $pincode->has('city') ? $this->Html->link($pincode->city->name, ['controller' => 'Cities', 'action' => 'view', $pincode->city->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($pincode->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State Id') ?></th>
            <td><?= $this->Number->format($pincode->state_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pincode') ?></th>
            <td><?= $this->Number->format($pincode->pincode) ?></td>
        </tr>
    </table>
</div>
