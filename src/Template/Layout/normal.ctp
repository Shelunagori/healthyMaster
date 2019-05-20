<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>SSK Food</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->

<link rel="shortcut icon" href="favicon.ico"/>
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<?= $this->Html->css([
"/assets/global/plugins/font-awesome/css/font-awesome.min.css",
"/assets/global/plugins/simple-line-icons/simple-line-icons.min.css",
"/assets/global/plugins/bootstrap/css/bootstrap.min.css",
"/assets/global/plugins/uniform/css/uniform.default.css",
"/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css",
"/assets/global/css/components.css",
"/assets/global/css/plugins.css",
"/assets/admin/layout/css/layout.css",
"/assets/admin/layout/css/custom.css",
]) ?>
<?= $this->Html->css('/assets/global/plugins/bootstrap-toastr/toastr.min.css'); ?>
<!-- END GLOBAL MANDATORY STYLES -->

<style type="text/css">
	#loading{
        background-color: rgba(0, 0, 0, 0.21);
        height: 100%;
        width: 100%;
        position: fixed;
        z-index: 999999;
        margin-top: 0px;
        top: 0px;
        display:none;
    }
    #loading-center{
        width: 100%;
        height: 100%;
        position: relative;
    }
    #loading-center-absolute {
        position: absolute;
        left: 50%;
        top: 50%;
        height: 150px;
        width: 150px;
        margin-top: -75px;
        margin-left: -75px;
    }
</style>
<!-- BEGIN PAGE LEVEL STYLES -->
<?= $this->fetch('PAGE_LEVEL_CSS')?>
<!-- END PAGE LEVEL STYLES -->

</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-over-content ">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<?= $this->fetch('content') ?>
			</div>
		</div>
	</div>

  <?= $this->Html->script([   
  		"/assets/global/plugins/jquery.min.js",
  		"/assets/global/plugins/jquery-migrate.min.js",
  		"/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js",
  		"/assets/global/plugins/bootstrap/js/bootstrap.min.js",
  		"/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js",
  		"/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js",
  		"/assets/global/plugins/jquery.blockui.min.js",
  		"/assets/global/plugins/jquery.cokie.min.js",
  		"/assets/global/plugins/uniform/jquery.uniform.min.js",
  		"/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js",
  		"/assets/global/scripts/metronic.js",
  		"/assets/admin/layout/scripts/layout.js",
  		"/assets/admin/layout/scripts/quick-sidebar.js",
  		"/assets/admin/layout/scripts/demo.js"
     ]); 
?>

		<!-- BEGIN PAGE LEVEL PLUGINS -->	
		<?= $this->Html->script("/assets/global/plugins/bootstrap-toastr/toastr.min.js") ?>
		<?= $this->fetch("PAGE_LEVEL_PLUGINS")?>

		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<?= $this->fetch("PAGE_LEVEL_SCRIPTS")?>
		<!-- END PAGE LEVEL SCRIPTS -->
<script>
	var csrf = <?=json_encode($this->request->getParam('_csrfToken'))?>;
    $.ajaxSetup({
        headers: { 'X-CSRF-Token': csrf },
        error: function(){alert('ajex error')}
    });
    
jQuery(document).ready(function() {    
	Metronic.init(); // init metronic core components
	Layout.init(); // init current layout
	QuickSidebar.init(); // init quick sidebar
	Demo.init(); // init demo features
});

$(window).load(function(){
    var menuSelect=$("a[href='<?php echo $this->request->getAttribute('here');  ?>']");
    menuSelect.parent().addClass('active');
    menuSelect.parents('.sub-menu').show('active');
    menuSelect.parents('li').find('.arrow').addClass('open');
});
</script>

<?= $this->fetch('scriptBottom')?>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>