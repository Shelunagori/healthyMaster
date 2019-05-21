<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemVariation $itemVariation
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $itemVariation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $itemVariation->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Item Variations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="itemVariations form large-9 medium-8 columns content">
    <?= $this->Form->create($itemVariation) ?>
    <fieldset>
        <legend><?= __('Edit Item Variation') ?></legend>
        <?php
            echo $this->Form->control('item_id');
            echo $this->Form->control('unit_id', ['options' => $units]);
            echo $this->Form->control('minimum_stock');
            echo $this->Form->control('ready_to_sale');
            echo $this->Form->control('print_rate');
            echo $this->Form->control('sales_rate');
            echo $this->Form->control('out_of_stock');
            echo $this->Form->control('minimum_quantity_purchase');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
