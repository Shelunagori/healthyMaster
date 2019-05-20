<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction[]|\Cake\Collection\CollectionInterface $transactions
 */
?>
<div class="row">
    <div class="col-md-12 col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject"><?= __('Transactions') ?></span>
                </div>
            </div>
            <div class="portlet-body">
                <form>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <?= $this->Form->label('Product', null, ['class'=>'control-label']) ?>
                                    <select name='product_id' class="form-control select2me input-sm product_id" id="product_id">
                                      <option value="">--Select--</option>
                                      <?php foreach($products as $key => $product):?>
                                        <option crate="<?= $product['box_in_crate'];?>" box="<?= $product['piece_in_box'];?>" total="<?= $product['total'] ?>" value="<?= $product['id'] ?>" price="<?= $product['price']?>"><?= $product['name']; ?> (<?= $product['weight']; ?>)</option>
                                      <?php endforeach ?>
                                    </select>
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
                                    <?= $this->Form->label('Party', null, ['class'=>'control-label']) ?>
                                     <?= $this->Form->control('party_id', ['empty'=>'--Select--','id'=>'party_id','label'=>false,'class'=>'form-control select2me input-sm','options'=>$parties,'value'=>@$_GET['party_id']]); ?>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <?= $this->Form->label('From', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('from_date', ['id'=>'from_date','label'=>false,'class'=>'form-control date-picker','data-date-format'=>'dd-M-yyyy','autocomplete'=>'off']); ?>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <?= $this->Form->label('To', null, ['class'=>'control-label']) ?>
                                    <?= $this->Form->control('to_date', ['id'=>'to_date','label'=>false,'class'=>'form-control date-picker','data-date-format'=>'dd-M-yyyy','autocomplete'=>'off']); ?>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <button class="btn btn-sm yellow" id="filter" style="margin-top : 30px;"><i class="fa fa-search"></i>Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">
                    <thead>
                        <tr>
                            <th scope="col" width="5%"><?= $this->Paginator->sort('S.N') ?></th>
                            <th scope="col" width="20%"><?=$this->Paginator->sort('Party Name') ?></th>
                            <th scope="col" width="20%"><?=$this->Paginator->sort('Product') ?></th>
                            <th scope="col" width="5%"><?=$this->Paginator->sort('Quantity') ?></th>
                            <th scope="col" width="5%"><?=$this->Paginator->sort('Status') ?></th>
                            <th scope="col" width="10%"><?=$this->Paginator->sort('MRP') ?></th>
                            <th scope="col" width="15%"><?=$this->Paginator->sort('Vehicle') ?></th>
                            <th scope="col" width="15%"><?=$this->Paginator->sort('Transaction Date') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i=0;
                        foreach ($transactions as $transaction): 
                            ?>
                        <tr>
                            <td><?= ++$i;?></td>
                            <td><?= $transaction->has('party') ? h($transaction->party->name) : '' ?></td>
                            <td><?= $transaction->has('product') ? h($transaction->product->name)."(".($transaction->product->weight).")" : '' ?></td>
                            <td><?= $this->Number->format($transaction->quantity) ?></td>
                            <td><?= h($transaction->status) ?></td>
                            <td><?= "Rs.".$this->Number->format($transaction->mrp) ?></td>
                            <td><?=h($transaction->vehicle_no) ?></td>
                            <td><?= h($transaction->transaction_date) ?></td><!-- 
                            <td class="actions">
                                <?= $this->Html->link(__("<i class='fa fa-pencil' ></i>"), ['action' => 'edit', $transaction->id],['class'=>'btn btn-sm btn-success','escape'=>false]) ?>
                                <?= $this->Form->postLink(__("<i class='fa fa-trash' ></i>"), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id),'class'=>'btn btn-sm btn-danger','escape'=>false]) ?>
                            </td> -->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
        </div>
    </div>
</div>
<?= $this->element('datepicker')?>
<?= $this->element('selectpicker')?>
