<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<style type="text/css">
    .error{
            color:  #c54848 !important;
    }
</style>
<div class="row">
    <div class="col-md-12 col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Add Product') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($product) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('name', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('name',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('weight', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('weight',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('self_life', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('self_life',['label'=>false,'class'=>'form-control','placeholder'=>'Days','min'=>0]); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('price', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('price',['label'=>false,'class'=>'form-control','placeholder'=>'Rs.','min'=>'1']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('product_code', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('product_code',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('piece_in_box', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('piece_in_box',['label'=>false,'class'=>'form-control']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('box_in_crate', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('box_in_crate',['label'=>false,'class'=>'form-control']); ?>
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
<?= $this->element('validate') ?>
