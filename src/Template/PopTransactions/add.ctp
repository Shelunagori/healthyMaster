<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
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
                    <span class="caption-subject"><?= __('Add POP Arrival Transaction') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($popTransaction) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Vehicle No*</label>
                                    <?= $this->Form->control('vehicle_no', ['empty'=>'--Select--','label'=>false,'class'=>'form-control select2me input-sm','options' => $vehicles,'required']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('transaction Date', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('transaction_date',['label'=>false,'type'=>'text','class'=>'form-control date-picker','data-date-format'=>'dd-M-yyyy','id'=>'transaction_date','autocomplete'=>'off','value'=>date('d-M-Y'),'required']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="height: 200px; overflow-y: scroll;">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px">S.No</th>
                                            <th style="width: 100px">Pop Item*</th>
                                            <th style="width: 100px">Party Name*</th>
                                            <th style="width: 100px">Quantity*</th>
                                            <th style="width: 100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="main-tbody">
                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions text-center">
                        <?= $this->Form->button(__('Submit'),['class'=>'btn btn-sm btn-success']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
            <table>
              <tbody id="sub-body" class="hidden">
                <tr>
                    <td class="index"> </td>
                    <td><?= $this->Form->control('poptransaction[0][pop_id]', ['empty'=>'--Select--','label'=>false,'class'=>'form-control pop_id input-sm' ,'options' => $pops,'required']); ?>
                    </td>
                    <td><?= $this->Form->control('poptransaction[0][party_id]', ['empty'=>'--Select--','label'=>false,'class'=>'form-control party_id input-sm' ,'options' => $parties,'required']); ?>
                    </td>
                    <td> <?php echo $this->Form->control('poptransaction[0][quantity]',['class'=>'form-control quantity','id'=>false,'label'=>false,'required','type'=>'number','min'=>'1']); ?></td>
                    <td> <button type="button" id="plus" class="btn btn-sm green"><i class="fa fa-plus"></i></button>
                      <button type="button" id="minus" class="btn btn-sm red"><i class="fa fa-minus"></i></button></td>
                      
                </tr>
              </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->element('datepicker') ?>
<?= $this->element('selectpicker') ?>
<?= $this->element('validate') ?>
<?php
$js="$(document).ready(function(){

      add_row();
    $('#transaction_date').datepicker();

    // $(document).on('change','.quantity',function()
    //   {
    //     var value=$(this).val();
    //     var cb=$(this).parent().parent().find('input:radio:checked').val();
    //       if(cb =='Crate')
    //       {
    //         var crate=$(this).parent().parent().parent().find('.product_id').find('option:selected').attr('crate');
    //         var total_quantity= crate * value;
    //         $(this).parent().parent().find('.total_quantity').val(total_quantity);
    //         $(this).parent().parent().find('.receive_quantity').val(total_quantity);
           
    //       }
    //       else{
    //         var box=$(this).parent().parent().parent().find('.product_id').find('option:selected').attr('box');
    //         var total_quantity= box * value;
    //         $(this).parent().parent().find('.total_quantity').val(total_quantity);
    //         $(this).parent().parent().find('.receive_quantity').val(total_quantity);
    //       }
                  
    //     // });
          
    //   });

   function add_row()
    {

      var tr = $('#sub-body>tr:last').clone();

      $('#main-tbody').append(tr);

           $('#main-tbody').find('tr').each(function()
        {
            $(this).find('.pop_id').attr('autofocus','autofocus');

        });
      rename_row();
    }
   function rename_row()
      {
        var i=0;
        $('#main-tbody').find('tr').each(function()
        {
            i++;

           $(this).find('.index').html(i);
           $(this).find('select.pop_id').attr('name','poptransaction['+i+'][pop_id]').select2();
           $(this).find('select.status').attr('name','poptransaction['+i+'][status]').select2();
           $(this).find('select.party_id').attr('name','poptransaction['+i+'][party_id]').select2();
           $(this).find('.quantity').attr('name','poptransaction['+i+'][quantity]');
          });
       
       }
   
    $(document).on('click','#plus',function(){
           add_row();
      });
       $(document).on('click','#minus',function(){
          var count=$('#main-tbody').children().length;
            if(count >= 2)
            {
              $(this).parent().parent().remove();
              rename_row();
            }
        });
      });
";

$this->Html->scriptBlock($js,['block'=>'scriptBottom']);

?>
