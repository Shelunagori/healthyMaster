<?= $this->Html->script('/assets/global/plugins/jquery-validation/js/jquery.validate.min.js',['block'=>'scriptBottom']) ?>
<?php
$js="
	$(document).ready(function(){

	    $('form').not('.filter_form').validate();

	});
";
$this->Html->scriptBlock($js,['block'=>'scriptBottom']);
?>