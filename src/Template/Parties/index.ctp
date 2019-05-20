<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Party[]|\Cake\Collection\CollectionInterface $parties
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
                        <span class="caption-subject"><?= __('Edit Dealer') ?></span>
                    <?php else : ?>
                        <span class="caption-subject"><?= __('Add Dealer') ?></span>
                    <?php endif ?>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($party) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('name', null, ['class'=>'control-label','required']) ?>
                                    <?= $this->Form->control('name',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('owner_name', null, ['class'=>'control-label','required']) ?>
                                    <?= $this->Form->control('owner_name',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('party_type', null, ['class'=>'control-label']) ?>
                                    <?php $data=['Wholesale Dealer'=>'Wholesale Dealer','Amul'=>'Amul']?>
                                    <?= $this->Form->control('party_type',['label'=>false,'class'=>'form-control select2me input-sm','options'=>$data]); ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('mobile_no', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('mobile_no',['label'=>false,'class'=>'form-control','required','type'=>'number','maxlength'=>10,'placeholder'=>'Mobile No']); ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('address', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('address',['label'=>false,'class'=>'form-control','required']); ?>
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
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Dealer') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.N') ?></th>
                            <th scope="col"><?= __('Name') ?></th>
                            <th scope="col"><?= __('Party') ?></th>
                            <th scope="col"><?= __('Mobile') ?></th>
                            <th scope="col"><?= __('Owner') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $i=1;
                            foreach ($parties as $party): ?>
                        <tr>
                            <td width="2px;"><?= $i; $i++; ?></td>
                            <td><?= h($party->name) ?></td>
                            <td width="2px;"><?= h($party->party_type) ?></td>
                            <td><?= h($party->mobile_no) ?></td>
                            <td><?= h($party->owner_name) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__("<i class='fa fa-pencil' ></i>"), ['action' => 'index', $party->id],['class'=>'btn btn-sm btn-success','escape'=>false]) ?>
                                <?= $this->Form->postLink(__("<i class='fa fa-trash' ></i>"), ['action' => 'delete', $party->id], ['confirm' => __('Are you sure you want to delete # {0}?',$party->id),'class'=>'btn btn-sm btn-danger','escape'=>false]) ?>
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
<?= $this->element('selectpicker')?>
