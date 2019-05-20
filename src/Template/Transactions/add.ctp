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
                    <span class="caption-subject"><?= __('Add Transaction') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= $this->Form->create($transaction) ?>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('vehicle_id', null, ['class'=>'control-label ']) ?>
                                    <?= $this->Form->control('vehicle_id', ['empty'=>'--Select--','label'=>false,'class'=>'form-control','options' => $vehicles]); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <?= $this->Form->label('transaction Date', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('transaction_date',['label'=>false,'type'=>'text','class'=>'form-control date-picker','data-date-format'=>'dd-M-yyyy','id'=>'transaction_date']); ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Product</th>
                                        <th>Batch No</th>
                                        <th>MRP</th>
                                        <th>Quantity</th>
                                        <th>Party</th>
                                        <th>DOM</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="main-tbody">
                   
                                </tbody>
                            </table>
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
                    <td><?= $this->Form->control('transaction.0.product_id', ['empty'=>'--Select--','label'=>false,'class'=>'form-control product_id','options' => $products,'style'=>'width:100px']); ?></td>
                    <td> <?php echo $this->Form->control('transaction.0.batch_no',['class'=>'form-control batch_no','id'=>false,'label'=>false,'style'=>'width:100px']); ?></td>
                    <td> <?php echo $this->Form->control('transaction.0.mrp',['class'=>'form-control mrp','id'=>false,'label'=>false,'style'=>'width:100px']); ?></td>
                    <td> <?php echo $this->Form->control('transaction.0.quantity',['class'=>'form-control quantity','id'=>false,'label'=>false,'style'=>'width:100px']); ?></td>
                    <td> <?php echo $this->Form->control('transaction.0.party_id',['empty'=>'--select--','class'=>'form-control party_id','id'=>false,'label'=>false,'options'=>$parties,'style'=>'width:100px']); ?></td>
                    <td> <?php echo $this->Form->control('transaction.0.dom',['class'=>'form-control  dom date-picker','data-date-format'=>'dd-M-yyyy','id'=>false,'label'=>false,'style'=>'width:100px']); ?></td>
                    <td> <button type="button" id="plus" class="mdc-fab mdc-fab--extended ">+
                          </button>
                      <button type="button" id="minus">-</button></td>
                </tr>
              </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->element('datepicker') ?>
<?= $this->element('selectpicker') ?>
<?php
$js="$(document).ready(function(){
      add_row();
    $('#transaction_date').datepicker();
    function add_row()
    {

      var tr = $('#sub-body>tr:last').clone();
      $('#main-tbody').append(tr);
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
           $(this).find('.quantity').attr('name','transaction['+i+'][quantity]');
           $(this).find('select.party_id').attr('name','transaction['+i+'][party_id]').select2();
           $(this).find('.dom').attr('name','transaction['+i+'][dom]').datepicker();
          });
       
       }
   
    $(document).on('click','#plus',function(){
           add_row();
      });
       $(document).on('click','#minus',function(){
          $(this).parent().parent().remove();
          rename_row();
        });
      });
";

$this->Html->scriptBlock($js,['block'=>'scriptBottom']);

?>
