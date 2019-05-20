<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pop $pop
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Pop'), ['action' => 'edit', $pop->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Pop'), ['action' => 'delete', $pop->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pop->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Pops'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Pop'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="pops view large-9 medium-8 columns content">
    <h3><?= h($pop->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($pop->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($pop->id) ?></td>
        </tr>
    </table>
</div>
