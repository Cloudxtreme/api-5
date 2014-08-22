<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta content='True' name='HandheldFriendly' />
		<meta name="format-detection" content="telephone=no" />
		<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
		<title>Cloudwalkers app</title>
		<link href="<?php echo BASE_URL; ?>assets/mobile/app/base.css" rel="stylesheet" media="screen">
		<link href="<?php echo BASE_URL; ?>assets/mobile/theme/css/style.css" rel="stylesheet" media="screen">
		<link href="<?php echo BASE_URL; ?>assets/mobile/theme/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo BASE_URL; ?>assets/mobile/theme/css/font-awesome.min.css" rel="stylesheet" media="screen">
		<link href="<?php echo BASE_URL; ?>assets/mobile/theme/css/OpenSans.css" rel="stylesheet" media="screen">
	</head>
	<body>
		
		<div id='app' class="login-view">
			
			<div id='header'>
				
				<h1>Cloudwalkers</h1>
				
			</div>
			<div id='container'>
				
				<?php echo $content; ?>
				
			</div>
		
		</div>

		<!-- Plugins -->
		<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/mobile/plugins/zepto.min.js"></script>
		<!-- App -->
		<script type="text/javascript">

		</script>

	</body>
</html>


