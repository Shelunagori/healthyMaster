<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datepicker/css/datepicker3.css',['block' => 'PAGE_LEVEL_CSS']);?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',['block' => 'PAGE_LEVEL_CSS']);?>
<?php echo $this->Html->css('/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css',['block' => 'PAGE_LEVEL_CSS']);?>



<?php echo $this->Html->script('/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', ['block' => 'PAGE_LEVEL_PLUGINS']); ?>
<?php echo $this->Html->script('/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['block' => 'PAGE_LEVEL_PLUGINS']); ?>


<?php echo $this->Html->script('/assets/admin/pages/scripts/components-pickers.js', ['block' => 'PAGE_LEVEL_PLUGINS']); ?>
<?php 
$js="
$(document).ready(function(){
	ComponentsPickers.init();
});";
$this->Html->scriptBlock($js,['block'=>'scriptBottom']);
?>