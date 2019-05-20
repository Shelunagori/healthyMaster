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
                    <span class="caption-subject"><?= __('Add Empty Crates Transaction') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($cartonTransaction) ?>
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
                                    <label>DMR Number</label>
                                    <?= $this->Form->control('dmr_no', ['label'=>false,'class'=>'form-control','required']); ?>
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
                                          <th style="width: 100px">Party Name*</th>
                                          <th style="width: 100px">Status</th>
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
                        <?= $this->Form->button(__('Submit'),['class'=>'btn btn-success']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
            <table>
              <tbody id="sub-body" class="hidden">
                <tr>
                    <td class="index"> </td>
                    <td><?= $this->Form->control('cartontransaction[0][party_id]', ['empty'=>'--Select--','label'=>false,'class'=>'form-control party_id input-sm' ,'options' => $parties,'required']); ?>
                    </td>
                    <td><input type="text" name='cartontransaction[0][status]' class="form-control status" id="status" value="In" readonly>
                    </td>
                    <td> <?php echo $this->Form->control('cartontransaction[0][quantity]',['class'=>'form-control quantity','id'=>false,'type'=>'number','min'=>'1','label'=>false,'required']); ?></td>
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

        function h_tab()
      {
        var i = 0;
        $('#main-tbody').find('tr').each(function() {
              $(this).find('td').each(function() {
                  $(this).find('input:not([readonly])','select').attr('tabindex', ++i);
                  $(this).find('.btn').attr('tabindex', ++i);
              });
          });
      }

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
            $(this).find('.party_id').attr('autofocus','autofocus');

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
           $(this).find('.status').attr('name','cartontransaction['+i+'][status]');
           $(this).find('select.party_id').attr('name','cartontransaction['+i+'][party_id]').select2();
           $(this).find('.quantity').attr('name','cartontransaction['+i+'][quantity]');
          });
          h_tab();
       
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
