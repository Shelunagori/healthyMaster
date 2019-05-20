<style type="text/css">
    .error{
            color:  #c54848 !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Pop Report') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($poptransaction) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('Pop', null, ['class'=>'control-label ']) ?>
                                    <?= $this->Form->control('pop_id', ['empty'=>'--Select--','label'=>false,'class'=>'form-control select2me input-sm pop_id','options' => $pops,'required','id'=>'pop_id']); ?>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                   <button class="btn btn-sm yellow" style="margin-top : 26px;"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
               <div class="portlet-body">
                <?php
                if(!@$datas == null)
                { ?>
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col"><?= __('Party Name') ?></th>
                            <th scope="col"><?= __('Status') ?></th>
                            <th scope="col"><?= __('Quantity') ?></th>
                            <th scope="col"><?= __('Vehicle No') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1;
                            
                        ?>
                        <?php foreach($pop_view as $pop_views):?>
                        <tr>
                            <td><?php echo $i; $i++;?></td>
                            <td><?= $pop_views->party->name?></td>
                            <td><?= $pop_views['status']?></td>
                            <td><?= $pop_views['quantity']?></td>
                            <td><?= $pop_views['vehicle_no'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                        	<strong><td colspan="6">Total Availiable Pop :
                        		<?php foreach($pop_in as $key => $pop_ins):
			                 		foreach($pop_out as $keys => $pop_outs):
			                 			if($pop_ins['quantities'] >= $pop_outs['quantities'])
							 	  			$total_pop=$pop_ins['quantities'] - $pop_outs['quantities'];
							 	  		if($pop_ins['quantities'] <= $pop_outs['quantities'])
							 	  			$total_pop=$pop_outs['quantities'] - $pop_ins['quantities'];
							 	  		echo number_format($total_pop);
			                 		endforeach;
			                 	endforeach; 
                 				?></td></strong>
                        </tr>
                    </tbody>
                </table>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>


