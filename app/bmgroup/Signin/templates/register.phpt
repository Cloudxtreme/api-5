<?php $this->setTextSection ('register', 'account'); ?>

<div class="registration-page">
	<div class="column-container two">

		<div class="column">
			<h2><?php echo __('Register the old way'); ?></h2>

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
							<label for="name"><?php echo __ ('Name'); ?></label>
							<input type="text" name="name" id="name" value="<?php echo $name?>" />
						</li>

						<li>
							<label for="firstname"><?php echo __ ('First name'); ?></label>
							<input type="text" name="firstname" id="firstname" value="<?php echo $firstname?>" />
						</li>

						<li>
							<label for="email"><?php echo __ ('Email'); ?></label>
							<input type="text" name="email" id="email" value="<?php echo $email?>" />
						</li>

						<li>
							<label for="password"><?php echo __ ('Password'); ?></label>
							<input type="password" name="password" id="password" />
						</li>

						<li>
							<label for="password2"><?php echo __ ('Confirm password'); ?></label>
							<input type="password" name="password2" id="password2" />
						</li>

						<li class="buttons">
							<button type="submit" name="register" value="1"><?php echo __ ('Register account'); ?></button>
						</li>
					</ol>
				</fieldset>
			</form>

			<p>
				<a href="<?php echo $login?>"><?php echo __ ('Already have an account? Login now'); ?></a>
			</p>
		</div>

		<div class="column">

			<h2><?php echo __('Register using your Social Media account '); ?></h2>
			<ul class="social-accounts">
				<?php foreach ($accounts as $v) { ?>
					<li class="<?php echo $v->getName (); ?>">
						<a href="<?php echo $v->getAuthURL();?>">
							<span><?php echo $v->getName ()?></span>
						</a>
					</li>
				<?php } ?>
			</ul>
			<div class="clearer"></div>

		</div>
	</div>

	<div class="clearer"></div>
</div>