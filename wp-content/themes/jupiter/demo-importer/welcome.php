<?php

$register = new mk_artbees_products();
$theme_name = ucfirst(THEME_NAME);
 ?>

<div class="wp-register-welcome">
	<div class="register-welcome">
		<h1>Welcome to <?php echo $theme_name; ?> WordPress Theme</h1>
		<p>
			Congratulations! Now that you have installed <?php echo $theme_name; ?>, there are some steps you need to take to get the most out of <?php echo $theme_name; ?> WordPress Theme.
		</p>
		<div class="welcome-step step-1">
			<h3 class="step-title"><span>Step 1.</span> Register <?php echo $theme_name; ?></h3>
			<p>Click the button below to register <?php echo $theme_name; ?> so that you can take full advantage of the theme and our support service.</p>
			<a href="<?php echo $register->register_product_url(); ?>" class="button register-button button-primary">Register <?php echo $theme_name; ?></a>
		</div>
		<div class="welcome-step step-2">
			<h3 class="step-title"><span>Step 2.</span> Download and install templates</h3>
			<p>Click the button below to download and install the templates you wish to use.</p>
			<a href="http://artbees.net/themes/template" target="_blank" class="button button-primary">Visit Template Collection</a>
		</div>
		<div class="welcome-step step-3">
			<h3 class="step-title"><span>Step 3.</span> Learn how to use <?php echo $theme_name; ?></h3>
			<p>Click the button below to learn all about using <?php echo $theme_name; ?>.  We have a full library of support articles & docs, FAQs and video tutorials to help you learn and use <?php echo $theme_name; ?>'s features and benefits.</p>
			<a href="http://artbees.net/themes/support/jupiter" target="_blank" class="button button-primary">Visit Support</a>
		</div>
		<div class="welcome-step step-2">
			<h3 class="step-title"><span>Step 4.</span> Ask our experts</h3>
			<p>Click the button below to reach our support team if you have any problems with the operation of your <?php echo $theme_name; ?> Theme.</p>
			<a href="http://artbees.net/themes/support" target="_blank" class="button button-primary">Get Help</a>
		</div>
		<!-- <div class="version-changelog">
			Your current version of <?php echo $theme_name; ?> 
			<h3>version <span>4.7</span></h3>
			<hr/>
			<strong>Change log</strong>
			<ul>
				<li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
				<li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
				<li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
				<li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
				<li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>
			</ul>
		</div> -->
	</div>
</div>