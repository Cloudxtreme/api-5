<?php $this->setTextSection ('login', 'account'); ?>

<!-- BEGIN FORGOT PASSWORD FORM -->
<form class="form-vertical forget-form" action="<?php echo $action; ?>" method="post">
	<h3 class="">Forget Password ?</h3>

	<?php if (!empty ($errors)) { ?>
		<?php foreach ($errors as $v) { ?>
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert"></button>
				<span><p><?php echo ($v); ?></p></span>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if (!empty ($feedback)) { ?>
		<?php foreach ($feedback as $v) { ?>
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert"></button>
				<span><p><?php echo ($v); ?></p></span>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if (count ($feedback) == 0) { ?>

		<p>Enter your e-mail address below to reset your password.</p>
		<div class="control-group">
			<div class="controls">
				<div class="input-icon left">
					<i class="icon-envelope"></i>
					<input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />
				</div>
			</div>
		</div>
		<div class="form-actions">
			<a href="<?php echo $login; ?>" id="register-back-btn" type="button" class="btn">
			<i class="m-icon-swapleft"></i>  Back
			</a>
			<button type="submit" class="btn green pull-right">
			Submit <i class="m-icon-swapright m-icon-white"></i>
			</button>            
		</div>

	<?php } else { ?>

		<p><a href="<?php echo \Neuron\URLBuilder::getURL ('login'); ?>">Return to login screen</a></p>

	<?php } ?>
</form>
<!-- END FORGOT PASSWORD FORM -->