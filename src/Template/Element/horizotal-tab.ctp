<?php
$js="
$(document).ready(function(){
	var i = 0;
	$('#main-tbody').find('tr').each(function() {
        $(this).find('td').each(function(i) {
            $(this).find('input:not('readonly')','select').attr('tabindex', i+1);
        });
    });
});";
$this->Html->scriptBlock($js,['block'=>'scriptBottom']);
?>