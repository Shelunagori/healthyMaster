<?php
$js="

$(document).ready(function(){
	var progressTimer;  
    $(document).ajaxStart(function () {
         $('#loading').modal('show');
        clearTimeout(progressTimer);
    }).ajaxStop(function () {
        progressTimer = setTimeout(function () {
             $('#loading').modal('hide');
        }, 10)
    });
});";
$this->Html->scriptBlock($js,['block'=>'scriptBottom']);
?>