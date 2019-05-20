<div class="row">
	<div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>
                    <span class="caption-subject"><?= __('Change Password') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create() ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('Current Password', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('password',['label'=>false,'class'=>'form-control current_password','type'=>'password']); ?>
                                    <input type="hidden" name="username" value="admin">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('New Password', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('new_password',['label'=>false,'class'=>'form-control','type'=>'password']); ?>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <?= $this->Form->label('Confirm Password', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('confirm_password',['label'=>false,'class'=>'form-control','type'=>'password']); ?>
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
<!-- <?php 
	$js="
		$(document).on('change','.current_password',function(){
			var current_password=$(this).val();
			$.ajax({
            url: '".$this->Url->build(['controller'=>'users','action'=>'changePassword.json'])."',
            type: 'post',
            data: {current_password: current_password},
            success: function (result) {
                if(result['success'] == 1)
                {
                    
                }
            }
            });
        });
			});
	";
$this->Html->scriptBlock($js,['block'=>'scriptBottom']);
?> -->