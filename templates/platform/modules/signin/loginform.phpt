	<?php if (!empty ($errors)) { ?>
		
		<article class="clear">
			<div class="errors">
				<?php foreach ($errors as $v) { ?>
					<p><?php echo __ ($v); ?></p>
				<?php } ?>
			</div>
		</article>
		
	<?php } ?>
		
		<article>

			<h1 class="pull-left">Login</h1>
			
			<form class="form-signin pull-right" method="post" action="http://stagingapi.cloudwalkers.be/login/form?display=platform">
		
				<input name="email" id='email' type="email" class="input-block-level" placeholder="E-mail">
				<input name="password" id='password' type="password" class="input-block-level" placeholder="Password">
				<input name="login" type="hidden" value="1" />
				<input type="submit" value="Login" />
		
			</form>

			<div class="clear"></div>

		</article>

		<article>
			<a href="/login/lostpassword" class="forgot-link">Forgot password?</a>
		</article>