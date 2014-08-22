<?php $this->setTextSection ('login', 'account'); ?>

<h2><?php echo __ ('Password recovery'); ?></h2>
<!-- errors -->
<?php if (count ($errors) > 0) { ?>
	<div class="errors">
		<?php foreach ($errors as $v) { ?>
			<p class="error">
				<?php echo __($v); ?>
			</p>
		<?php } ?>
	</div>
<?php } ?>
<!-- /errors -->

<!-- errors -->
<?php if (count ($feedback) > 0) { ?>
	<div class="feedbacks">
		<?php foreach ($feedback as $v) { ?>
			<p class="feedback">
				<?php echo __($v); ?>
			</p>
		<?php } ?>
	</div>
<?php } ?>
<!-- /errors -->

<p><?php echo __('Almost there. Please choose a new password.'); ?></p>

<form method="post" action"<?php echo $action; ?>">

	<fieldset>

		<ol>
			<li>
				<label for="password1"><?php echo __('New password'); ?></label>
				<input type="password" name="password1" id="password1" />
			</li>

			<li>
				<label for="password2"><?php echo __('Repeat password'); ?></label>
				<input type="password" name="password2" id="password2" />
			</li>

			<li class="buttons">
				<input type="hidden" name="action" value="changepassword" />
				<button type="submit"><?php echo __('Change password'); ?></button>
			</li>
		</ol>
	</fieldset>

</form>