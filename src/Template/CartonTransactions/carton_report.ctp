
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Crates Report') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($carton) ?>
                <div class="form-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <?= $this->Form->label('Party Name', null, ['class'=>'control-label']) ?>
                                <?= $this->Form->control('party_id',['label'=>false,'empty'=>'--Select--','class'=>'form-control select2me input-sm','id'=>'party_id','autocomplete'=>'off','options'=>$parties]); ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?= $this->Form->label('Status', null, ['class'=>'control-label']) ?>
                                <?php
                                    $status=['In'=>'In','Out'=>'Out'];
                                ?>
                                <?= $this->Form->control('status', ['empty'=>'--Select--','id'=>'status','label'=>false,'class'=>'form-control select2me input-sm','options'=>$status,'required'=>false]); ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?= $this->Form->label('DMR No.', 'DMR No', ['class'=>'control-label']) ?>
                                <?= $this->Form->control('dmr',['label'=>false,'class'=>'form-control','id'=>'dmr']); ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?= $this->Form->label('From', null, ['class'=>'control-label']) ?>
                                <?= $this->Form->control('date',['label'=>false,'type'=>'text','class'=>'form-control date-picker date','data-date-format'=>'dd-M-yyyy','id'=>'date','autocomplete'=>'off']); ?>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?= $this->Form->label('To', null, ['class'=>'control-label']) ?>
                                <?= $this->Form->control('to',['label'=>false,'type'=>'text','class'=>'form-control date-picker date','data-date-format'=>'dd-M-yyyy','id'=>'to','autocomplete'=>'off']); ?>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="filter" style="margin-top: 25px; ">Filter</button>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col"><?= __('S.No') ?></th>
                            <th scope="col"><?= __('Party') ?></th>
                            <th scope="col"><?= __('Status') ?></th>
                            <th scope="col"><?= __('DMR No') ?></th>
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
                            <td><?= $pop_views['dmr_no']?></td>
                            <td><?= $pop_views['quantity']?></td>
                            <td><?= $pop_views['vehicle_no'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                    	   <strong><td colspan="6">Total Availiable Empty Carton :
                    		<?php foreach($carton_in as $key => $carton_ins):
		                 		foreach($carton_out as $keys => $carton_outs):
		                 			if($carton_ins['quantities'] >= $carton_outs['quantities'])
						 	  			$total_pop=$carton_ins['quantities'] - $carton_outs['quantities'];
						 	  		if($carton_ins['quantities'] <= $carton_outs['quantities'])
						 	  			$total_pop=$carton_outs['quantities'] - $carton_ins['quantities'];
						 	  		echo number_format($total_pop);
		                 		endforeach;
		                 	endforeach; 
             				?></td></strong>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>
<?= $this->element('datepicker') ?>


