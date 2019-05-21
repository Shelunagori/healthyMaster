<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemVariation $itemVariation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item Variation'), ['action' => 'edit', $itemVariation->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item Variation'), ['action' => 'delete', $itemVariation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemVariation->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Item Variations'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item Variation'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="itemVariations view large-9 medium-8 columns content">
    <h3><?= h($itemVariation->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Unit') ?></th>
            <td><?= $itemVariation->has('unit') ? $this->Html->link($itemVariation->unit->name, ['controller' => 'Units', 'action' => 'view', $itemVariation->unit->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ready To Sale') ?></th>
            <td><?= h($itemVariation->ready_to_sale) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($itemVariation->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Item Id') ?></th>
            <td><?= $this->Number->format($itemVariation->item_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Minimum Stock') ?></th>
            <td><?= $this->Number->format($itemVariation->minimum_stock) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Print Rate') ?></th>
            <td><?= $this->Number->format($itemVariation->print_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sales Rate') ?></th>
            <td><?= $this->Number->format($itemVariation->sales_rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Out Of Stock') ?></th>
            <td><?= $this->Number->format($itemVariation->out_of_stock) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Minimum Quantity Purchase') ?></th>
            <td><?= $this->Number->format($itemVariation->minimum_quantity_purchase) ?></td>
        </tr>
    </table>
</div>
