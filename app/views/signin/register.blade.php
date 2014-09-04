@extends('layouts.auth')

@section('content')

<?php // $this->setTextSection ('register', 'account'); ?>

<!-- BEGIN REGISTRATION FORM -->
<form class="form-vertical register-form" action="<?php // echo $action ?>" method="post">

    <?php /* if (isset ($_GET['invitation'])) { ?>
        <h3>
            You are invited!
        </h3>

        <p>If you already have a Cloudwalkers account, don't bother with this registration form and head straight to the <a href="<?php echo \Neuron\URLBuilder::getURL ('login'); ?>">login form</a>.</p>
    <?php } ?>

    <h3 class="">Sign Up</h3>

    <?php if (!empty ($errors)) { ?>
        <?php foreach ($errors as $v) { ?>
            <div class="alert alert-error">
                <button class="close" data-dismiss="alert"></button>
                <span><p><?php echo __ ($v); ?></p></span>
            </div>
        <?php } ?>
    <?php } */ ?>

    <p>Enter your account details below:</p>
    <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-envelope"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" value="<?php echo $_SESSION['invitation_email']; ?>"/>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Name</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-user"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="Name" name="name"/>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">First name</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-user"></i>
                <input class="m-wrap placeholder-no-fix" type="text" placeholder="First name" name="firstname"/>
            </div>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-lock"></i>
                <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="Password" name="password"/>
            </div>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <div class="controls">
            <div class="input-icon left">
                <i class="icon-ok"></i>
                <input class="m-wrap placeholder-no-fix" type="password" placeholder="Re-type Your Password" name="password2"/>
            </div>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <label class="checkbox">
                <input type="checkbox" name="tnc"/> I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
            </label>
            <div id="register_tnc_error"></div>
        </div>
    </div>
    <div class="form-actions">
        <a href="<?php // echo \Neuron\URLBuilder::getURL ('login'); ?>" id="register-back-btn" type="button" class="btn">
            <i class="m-icon-swapleft"></i>
            <?php /* if (isset ($_GET['invitation'])) { ?>To login<?php } else { ?>Back<?php } */ ?>
        </a>
        <button type="submit" id="register-submit-btn" class="btn green pull-right" name="register" value="1">
            Sign Up <i class="m-icon-swapright m-icon-white"></i>
        </button>
    </div>
</form>
<!-- END REGISTRATION FORM -->

<?php /*
<!--
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
	</div>

	<div class="clearer"></div>
</div>
-->

*/ ?>

@stop