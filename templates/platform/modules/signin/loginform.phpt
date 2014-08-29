<article class="white">

	<div class="title pull-left">Login</div>


	<?php if (!empty ($errors)) { ?>
		<article style="clear: both;">
			<div class="errors">
				<?php foreach ($errors as $v) { ?>
					<p><?php echo __ ($v); ?></p>
				<?php } ?>
			</div>
		</article>
	<?php } ?>

	<form class="form-signin pull-right" method="post" action="<?php echo $action?>">

		<input name="email" id='email' type="email" class="input-block-level" placeholder="E-mail">
		<input name="password" id='password' type="password" class="input-block-level" placeholder="Password">
		<input name="login" type="hidden" value="1" />
		<input class="btn btn-block btn-primary" type="submit" value="Login" />

	</form>


	<div class="clear"></div>

</article>

<article>
	<a href="http://api.cloudwalkers.be/login/lostpassword" class="forgot-link">Forgot password?</a>
</article>