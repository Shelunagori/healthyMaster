<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vehicle[]|\Cake\Collection\CollectionInterface $vehicles
 */
?>
<style>
    .error{
            color:  #c54848 !important;
    }
</style>
<div class="row">
    <div class="col-md-6 col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <?php if($id): ?>
                        <span class="caption-subject"><?= __('Add Vehicle') ?></span>
                    <?php else: ?>
                        <span class="caption-subject"><?= __('Add Vehicle') ?></span>
                    <?php endif ?>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($vehicle) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('vehicle_no', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('vehicle_no',['label'=>false,'class'=>'form-control','required']); ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('driver_name', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('driver_name',['label'=>false,'class'=>'form-control','required']); ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('capacity', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('capacity',['label'=>false,'class'=>'form-control','required']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-center">
                        <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Vehicles') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.N') ?></th>
                            <th scope="col"><?= __('Driver') ?></th>
                            <th scope="col"><?= __('Number') ?></th>
                            <th scope="col"><?= __('Capacity') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i=1;
                            foreach ($vehicles as $vehicle): ?>
                        <tr>
                            <td><?= $i; $i++; ?></td>
                            <td><?= h($vehicle->driver_name) ?></td>
                            <td><?= h($vehicle->vehicle_no) ?></td>
                            <td><?= h($vehicle->capacity) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__("<i class='fa fa-pencil' ></i>"), ['action' => 'index', $vehicle->id],['class'=>'btn btn-sm btn-success','escape'=>false]) ?>
                                <?= $this->Form->postLink(__("<i class='fa fa-trash' ></i>"), ['action' => 'delete', $vehicle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vehicle->id),'class'=>'btn btn-sm btn-danger','escape'=>false]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->element('validate')?>
