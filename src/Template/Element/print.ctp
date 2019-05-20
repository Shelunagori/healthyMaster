<?php

$js ="
    $(document).ready(function() {
        function pp(div)
        {
            
        }
        $(document).on('click','".$button."',function(){
            var style = \"<link rel='stylesheet' href='/school_cms/assets/global/plugins/bootstrap/css/bootstrap.min.css'/>\";
            var pageTitle = 'Page Title',
            stylesheet = '',
            win = window.open('', 'Print', 'width=800,height=600');
            win.document.write('<html><head><title>' + pageTitle + '</title>' + style + '</head><body>' + $('".$id."').html() + '</body></html>');
            win.document.close();
            win.print();
            win.close();
            return false;
        });
    });
";
$this->Html->scriptBlock($js, ['block' => 'scriptBottom']);
?>