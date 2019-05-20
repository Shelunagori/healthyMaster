<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 */
?>
<style type="text/css">
    .radio-list{ padding-left: 20px; }
    .error{
            color:  #c54848 !important;
    }
    .action{
      width: 91px;
    }
</style>
<div class="row">
    <div class="col-md-12 col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Add From Vendor') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($transaction) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('Vehicle', null, ['class'=>'control-label select2']) ?>
                                    <?= $this->Form->control('vehicle_no', ['empty'=>'--Select--','label'=>false,'class'=>'form-control select input-sm select2me','options' => $vehicles,'required']); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('transaction Date', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('transaction_date',['label'=>false,'type'=>'text','class'=>'form-control date-picker','data-date-format'=>'dd-M-yyyy','id'=>'transaction_date','autocomplete'=>'off','required','value'=>date('d-M-Y')]); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="height: 200px; overflow-y: scroll;">
                              <table class="table table-striped table-bordered">
                                  <thead>
                                      <tr>
                                          <th style="width: 50px">S.No</th>
                                          <th style="width: 100px">Party Name</th>
                                          <th style="width: 20px">Product</th>
                                          <th style="width: 20px">Batch No</th>
                                          <th style="width: 10px">MRP</th>
                                          <th style="width: 200px">Quantity*</th>
                                          <th style="width: 50px">Actions</th>
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
                    <td style="vertical-align: bottom;" class="index"> </td>
                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('transaction.0.party_id',['empty'=>'--Select--','class'=>'form-control party_id input-sm','id'=>false,'label'=>false,'options'=>$parties,'required']); ?></td>
                    <td style="vertical-align: bottom;"><select name='transaction.0.product_id' class="form-control product_id input-sm" id="product_id">
                          <option>--Select--</option>
                          <?php foreach($products as $key => $product):?>
                            <option crate="<?= $product['box_in_crate'];?>" box="<?= $product['piece_in_box'];?>" value="<?= $product['id'];?>" price="<?= $product['price'] ?>"><?= $product['name']; ?> (<?= $product['weight']; ?>)
                          <?php endforeach ?>
                        </select>
                    </td>
                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('transaction.0.batch_no',['class'=>'form-control batch_no','id'=>false,'label'=>false,'required']); ?></td>
                    <td style="vertical-align: bottom;"> <?php echo $this->Form->control('transaction.0.mrp',['class'=>'form-control mrp','id'=>false,'label'=>false,'required','readonly']); ?></td>
                    <td style="vertical-align: bottom;"> 
                      <div class="myRadio radio-list" style="display: inline-block; float: left; padding-right: 15px;"></div>
                          <?php echo $this->Form->control('transaction.0.total_quantity',['class'=>'input-xsmall quantity input-sm','label'=>false,'required','type'=>'number','min'=>'1']); ?>
                      <input type="hidden" name="transaction.0.quantity" id="quantity" class="total_quantity">
                    </td>
                    <td style="vertical-align: bottom;" class="action"> <button type="button" id="plus" class="btn btn-sm green"><i class="fa fa-plus"></i></button>
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

  function h_tab()
  {
    var i = 0;
    $('#main-tbody').find('tr').each(function() {
          $(this).find('td').each(function() {
              $(this).find('input:not([readonly],[type=radio])','.btn','select').attr('tabindex', ++i);
              $(this).find('.btn').attr('tabindex', ++i);
          });
      });
  }
    var radio = '<label class=\'radio-inline\'>\\
                <input type=\'radio\' name=\'crate\' class=\'quantities\' value=\'Crate\' checked>CRT </label>\\
                <label class=\'radio-inline\'>\\
                <input type=\'radio\' name=\'crate\' class=\'quantities\' value=\'Box\' >Box </label>';

    $('.myRadio').html(radio);

    add_row();
    
    $(document).on('change','.product_id',function(){
        var product=$(this).find('option:selected').attr('price');
        $(this).parent().parent().find('.mrp').val(product);
      });

      // $('.select').select2();
    $('#transaction_date').datepicker();
    $(document).on('change','.quantity',function()
      {
        var value=$(this).val();
        var cb=$(this).parent().parent().find('input:radio:checked').val();
          if(cb =='Crate')
          {
            var crate=$(this).parent().parent().parent().find('.product_id').find('option:selected').attr('crate');
            var total_quantity= crate * value;
            $(this).parent().parent().find('.total_quantity').val(total_quantity);
            $(this).parent().parent().find('.receive_quantity').val(total_quantity);
           
          }
          else{
            $(this).parent().parent().find('.total_quantity').val(value);
            $(this).parent().parent().find('.receive_quantity').val(value);
          }
                  
        // });
          
      });
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
           $(this).find('.batch_no').attr('name','transaction['+i+'][batch_no]');
           $(this).find('select.product_id').attr('name','transaction['+i+'][product_id]').select2();
           $(this).find('.mrp').attr('name','transaction['+i+'][mrp]');
           $(this).find('.quantities').attr('name','transaction['+i+'][crate]');
           $(this).find('.quantity').attr('name','transaction['+i+'][total_quantity]');
           $(this).find('.total_quantity').attr('name','transaction['+i+'][quantity]');
           $(this).find('select.party_id').attr('name','transaction['+i+'][party_id]').select2();
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
