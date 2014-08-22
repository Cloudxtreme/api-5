<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
	<head>
		<meta charset="utf-8" />
		<title>Cloudwalkers | Login Page</title>
		<meta content="width=device-width, initial-scale=1.0" name="viewport" />
		<meta content="" name="description" />
		<meta content="" name="author" />

		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="<?php echo BASE_URL; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo BASE_URL; ?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo BASE_URL; ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo BASE_URL; ?>assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo BASE_URL; ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo BASE_URL; ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo BASE_URL; ?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
		<link href="<?php echo BASE_URL; ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
		<!-- END GLOBAL MANDATORY STYLES -->

		<!-- BEGIN PAGE LEVEL STYLES -->
		<link href="<?php echo BASE_URL; ?>assets/css/pages/login.css" rel="stylesheet" type="text/css"/>
		<!-- END PAGE LEVEL STYLES -->
		<link rel="shortcut icon" href="favicon.ico" />

	</head>
	<!-- END HEAD -->

	<!-- BEGIN BODY -->
	<body class="login">
		<!-- BEGIN LOGO -->
		<div class="logo">
			<img src="<?php echo BASE_URL; ?>assets/img/logo-big.png" alt="" /> 
		</div>

		<!-- END LOGO -->
		<!-- BEGIN LOGIN -->
		<div class="content">

			<!--
			<div id="navigation">
				<ul>
					<?php if (!$loggedin) { ?>
						<li>
							<a href="<?php echo \Neuron\URLBuilder::getURL ('login'); ?>">Login</a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo \Neuron\URLBuilder::getURL ('logout'); ?>">Logout</a>
						</li>
					<?php } ?>
				</ul>
			</div>
			-->

			<div id="content">
				<?php echo $content; ?>
			</div>

		</div>
		<!-- END LOGIN -->
		
		<!-- BEGIN COPYRIGHT -->
		<div class="copyright">
			2014 &copy; Cloudwalkers
		</div>

		<!-- BEGIN CORE PLUGINS -->
		<script src="<?php echo BASE_URL; ?>assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URL; ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
		<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
		<script src="<?php echo BASE_URL; ?>assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URL; ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
		<!--[if lt IE 9]>
		<script src="assets/plugins/excanvas.min.js"></script>
		<script src="assets/plugins/respond.min.js"></script>
		<![endif]-->
		<script src="<?php echo BASE_URL; ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URL; ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URL; ?>assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URL; ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
		<!-- END CORE PLUGINS -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<script src="<?php echo BASE_URL; ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js" type="text/javascript"></script>
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<script src="<?php echo BASE_URL; ?>assets/scripts/app.js" type="text/javascript"></script>

		<script>
			jQuery(document).ready(function() {
			  App.init();
			  //Login.init();
			});
		</script>

	</body>

</html>