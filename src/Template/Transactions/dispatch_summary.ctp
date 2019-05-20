
<style>
table {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 5px;
}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
}
</style>
<table class="" style="width: 100%;" id="sample_editable_1" border="1" width="100%">
    <thead>
        <tr>
            <th><?= __('S.N') ?></th>
            <th><?= __('Invoice No') ?></th>
            <th><?= __('Party Name') ?></th>
            <th><?= __('Dispatch Quantity') ?></th>
            <th><?= __('MRP') ?></th>
            <th><?= __('Vehicle No') ?></th>
            <th><?= __('Date of Dispatch') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $i=0;
        foreach ($transactions as $transaction): 
            ?>
        <tr>
            <td><?= ++$i;?></td>
            <td ><?= $transaction->bill_no ?></td>
            <td ><?= $transaction->has('party') ? h($transaction->party->name) : '' ?></td>
            <td ><?= $this->Number->format($transaction->quantity) ?></td>
            <td><?= "Rs.".$this->Number->format($transaction->mrp) ?></td>
            <td ><?=h($transaction->vehicle_no) ?></td>
            <td ><?= h($transaction->transaction_date) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>