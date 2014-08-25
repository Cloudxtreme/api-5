<form method="post" action="<?php echo $action?>">

	<?php if (isset ($_GET['invitation'])) { ?>
		<h3>
			You are invited!
		</h3>

		<p>If you have an existing Cloudwalkers account, login to accept your invitation.</p>
		<p><strong>If you are new to Cloudwalkers, <a href="<?php echo \Neuron\URLBuilder::getURL ('register'); ?>">register here</a>.</strong></p>
	<?php } ?>

	<h3 class="form-title">Login to your account</h3>

	<?php if (!empty ($errors)) { ?>
		<?php foreach ($errors as $v) { ?>
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert"></button>
				<span><p><?php echo __ ($v); ?></p></span>
			</div>
		<?php } ?>
	<?php } ?>

	<div class="control-group">
		<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
		<label class="control-label visible-ie8 visible-ie9">Username</label>
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-user"></i>
				<input class="m-wrap placeholder-no-fix" type="text" placeholder="Username" name="email"/>
			</div>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label visible-ie8 visible-ie9">Password</label>
		<div class="controls">
			<div class="input-icon left">
				<i class="icon-lock"></i>
				<input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password"/>
			</div>
		</div>
	</div>

	<div class="form-actions">
		<!--
		<label class="checkbox">
		<input type="checkbox" name="remember" value="1"/> Remember me
		</label>
		-->
		<button type="submit" class="btn green pull-right" name="login" value="1">
		Login <i class="m-icon-swapright m-icon-white"></i>
		</button>            
	</div>

	<div class="forget-password">
		<h4>Forgot your password ?</h4>
		<p>
			Don't panic, click <a href="<?php echo $lostpassword; ?>" class="" id="forget-password">here</a>
			to reset your password.
		</p>
	</div>

	<!--
	<div class="create-account">
		<p>
			Don't have an account yet ?&nbsp; 
			<a href="<?php echo $register?>" id="register-btn" class="">Create an account</a>
		</p>
	</div>
	-->

</form>