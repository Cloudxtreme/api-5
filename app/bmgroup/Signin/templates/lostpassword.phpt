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

<?php if (count ($feedback) == 0) { ?>

	<form method="post">
		<fieldset>
			<ol>
				<li>
					<label for="email"><?php echo __('Email'); ?></label>
					<input type="text" name="email" id="email" />
				</li>

				<li class="buttons">
					<button type="submit" name="login" value="1"><?php echo __('Recover password'); ?></button>
				</li>
			</ol>
		</fieldset>
	</form>

	<p><?php echo __('Please note that this method only works if you have confirmed your email address.'); ?></p>

<?php } else { ?>

	<p><a href="<?php echo Neuron_URLBuilder::getURL ('login'); ?>">Return to login screen</a></p>

<?php } ?>