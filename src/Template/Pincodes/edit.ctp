<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pincode $pincode
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pincode->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pincode->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Pincodes'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Cities'), ['controller' => 'Cities', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New City'), ['controller' => 'Cities', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="pincodes form large-9 medium-8 columns content">
    <?= $this->Form->create($pincode) ?>
    <fieldset>
        <legend><?= __('Edit Pincode') ?></legend>
        <?php
            echo $this->Form->control('state_id');
            echo $this->Form->control('city_id', ['options' => $cities]);
            echo $this->Form->control('pincode');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
