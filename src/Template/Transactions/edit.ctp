<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 */
?>
<div class="row">
    <div class="col-md-12 col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Edit Transaction') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($transaction) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('product_id', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('product_id', ['empty'=>'--Select--','label'=>false,'class'=>'form-control select2me input-sm','options' => $products]); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->control('vehicle_no', ['class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('batch_no', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('batch_no',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('dom', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('dom',['label'=>false,'type'=>'text','class'=>'form-control date-picker','data-date-format'=>'dd-M-yyyy','id'=>'dom']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('mrp', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('mrp',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('transaction_date', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('transaction_date',['label'=>false,'type'=>'text','class'=>'form-control date-picker','data-date-format'=>'dd-M-yyyy','id'=>'transaction_date']); ?>
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
                            </div><!-- 
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('availiable_quantity', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('availiable_quantity',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div> -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('party_id', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('party_id', ['empty'=>'--Select--','label'=>false,'class'=>'form-control select2me input-sm','options' => $parties]); ?>
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
</div>
<?= $this->element('datepicker') ?>
<?= $this->element('selectpicker') ?>
