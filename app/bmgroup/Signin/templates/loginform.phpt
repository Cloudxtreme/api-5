<h2><?php echo __ ('Login'); ?></h2>
<?php if (!empty ($errors)) { ?>
	<div class="errors">
		<?php foreach ($errors as $v) { ?>
			<p><?php echo __ ($v); ?></p>
		<?php } ?>
	</div>
<?php } ?>

<form method="post" action="<?php echo $action?>">
	<fieldset>
		<ol>
			<li>
				<label for="email"><?php echo __('Email'); ?></label>
				<input type="text" name="email" id="email" />
			</li>

			<li>
				<label for="password"><?php echo __('Password'); ?></label>
				<input type="password" name="password" id="password" />

				<p>
					<a href="' . $lostpassword .'"><?php echo ('Forgot your password?'); ?></a>
				</p>
			</li>

			<li class="buttons">
				<button type="submit" name="login" value="1"><?php echo __('Login'); ?></button>
			</li>
		</ol>
	</fieldset>
</form>

<p>
	<a href="<?php echo $register?>"><?php echo __('Don\'t have an account yet? Register now'); ?></a><br />
</p>

<p class="spacy">
	<a href="<?php echo Neuron_URLBuilder::getUrl ('login/thirdparty'); ?>">
		<?php echo __('Back'); ?>
	</a>
</p>