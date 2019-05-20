<div class="paginator">
    <center>
    <ul class="pagination pagination-gap"  style="margin:0px !important;">
        <?= $this->Paginator->first('' . __('First')) ?>
        <?= $this->Paginator->prev('' . __('Previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('Next') . '') ?>
        <?= $this->Paginator->last(__('Last') . '') ?>
    </ul>
     <ul style="text-align: right;"><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}')]) ?></ul>
 </center>
</div>