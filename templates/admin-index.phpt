<?php empty( $nav[2] ) ? $nav[2] = '' : $nav[2]; ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Cloudwalkers Admin</title>

		<link href="<?php echo BASE_URL; ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo BASE_URL; ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
		<link href="<?php echo BASE_URL; ?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

		<script src="<?php echo BASE_URL; ?>assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
		<script src="<?php echo BASE_URL; ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	</head>

	<body>
		<div class="container">
			<p>&nbsp;</p>
			<div class="masthead">

				<div class="navbar">
					<div class="navbar-inner">
						<div class="container">
							<a class="brand" href="#"><span class="label label-warning">beta</span> | Admin Panel </a>
							<ul class="nav">
								<li <?php echo( empty($nav[2] ) ? 'class=active' : '' ); ?> > <a href="<?php echo \Neuron\URLBuilder::getURL ('admin'); ?>"><i class="icon-home"></i> Home </a> </li>
								<li <?php echo( $nav[2] == 'streams' ? 'class=active' : '' ); ?> > <a href="<?php echo \Neuron\URLBuilder::getURL ('admin/streams'); ?>"><i class="icon-time"></i> Watch streams </a> </li>
								<li <?php echo( $nav[2] == 'accounts' ? 'class=active' : '' ); ?> > <a href="<?php echo \Neuron\URLBuilder::getURL ('admin/accounts'); ?>"><i class="icon-user"></i> Accounts Management </a> </li>
								<li <?php echo( $nav[2] == 'accounts' ? 'class=active' : '' ); ?> > <a href="<?php echo \Neuron\URLBuilder::getURL ('admin/performance'); ?>"><i class="icon-time"></i> Performance </a> </li>
							</ul>
						</div>
					</div>
				</div>

			</div>




			<div id="content">
				<h2><?php echo $title; ?></h2>
				<?php echo $content; ?>
			</div>
		</div>




	</body>
</html>