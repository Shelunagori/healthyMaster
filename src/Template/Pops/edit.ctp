<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pop $pop
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>
                    <span class="caption-subject"><?= __('Edit Pop') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($pop) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('name', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('name',['label'=>false,'class'=>'form-control']); ?>
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
