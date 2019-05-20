<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CartonTransaction $cartonTransaction
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>
                    <span class="caption-subject"><?= __('Edit Carton Transaction') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($cartonTransaction) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('vehicle_no', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('vehicle_no',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('party_id', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('party_id', ['empty'=>'--Select--','label'=>false,'class'=>'form-control select2me input-sm','options' => $parties]); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('transaction_date', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('transaction_date',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('status', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('status',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('quantity', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('quantity',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-center">
                        <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success btn-lg']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
