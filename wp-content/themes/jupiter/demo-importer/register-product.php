<?php
$mk_artbees_products = new mk_artbees_products();
$theme_name = ucfirst(THEME_NAME);
$apikey = get_option( 'artbees_api_key', '' );
$is_apikey = false;
$message = $error = "";

if($apikey!="")
	$is_apikey = true;

if(isset($_POST['apikey'])){
	if($_POST['apikey']=="" && $apikey!=""){
		delete_option( 'artbees_api_key' );
		$apikey = "";
		$is_apikey = false;
		$message = 'your api key is revoked.';
	} else {
		$result = $mk_artbees_products->verify_artbees_apikey($_POST['apikey']);
		if($result['is_verified']){
			update_option( 'artbees_api_key', $_POST['apikey'], 'yes' );
			$apikey = $_POST['apikey'];
			$is_apikey = true;
			$message = 'Your API key  is verified.';
		} else {
			delete_option( 'artbees_api_key' );
			$apikey = "";
			$is_apikey = false;
			$error = 'Your API key could not be verified. Please enter a valid api key.';
		}
	}
} else if( !$mk_artbees_products->is_verified_artbees_customer() ){
	delete_option( 'artbees_api_key' );
	$apikey = "";
	$is_apikey = false;
}

?>

<div class="wp-register-product">
	<div class="product-register">
		<h1>Register <?php echo $theme_name; ?></h1>
		<p>To use the maximum power of <?php echo $theme_name; ?> and some critical features you need to Register this product first. It is an easy and quick process.</p>
		<form action="<?php echo admin_url('themes.php?page=register-product'); ?>" method="POST">
			<div class="register-form <?php if($is_apikey) { echo "is-keyAdded"; } if($error!="") { echo "is-error"; } ?>">
				
				
				<label for="apikey">Artbees API Key</label>
				<div class="form-input">
					<div class="register-product__message success-msg"><?php echo $message; ?></div>
					<div class="register-product__message error-msg"><?php echo $error; ?> <a href="#">Help</a></div>
					<div class="input-holder">
						<input type="text" name="apikey" size="30" value="<?php echo $apikey; ?>" id="apikey" spellcheck="true" autocomplete="on" placeholder="e.g. a3e2c32d74f4afad7afcce3114e38c0937a0f31f54">
						<?php if(!$is_apikey) { ?>
						<br>
						<p><a target="_blank" href="http://artbees.net/themes/dashboard/register-product/">Click here</a> to get an API key</p>
						<?php } ?>
					</div>
					<div class="button-holder">
						<?php if($is_apikey) { ?>
							<input type="submit" value="Revoke this API Key" href="#" class="button button-primary button-revoke" id="revoke_button"/>
						<?php } else { ?>
							<input type="submit" value="Register" href="#" class="button button-primary button-register"/>
						<?php } ?>
					</div>
				</div>
				</div>
		</form>
	</div>
	<hr/>
	<div class="how-to">
		<h3>How to Register</h3>
		<div class="how-to-video-list">
			<div class="video-item">
				<a target="_blank" href="https://www.youtube.com/watch?v=NXOiSp6HMOs">
					<img src="<?php echo THEME_DIR_URI; ?>/demo-importer/images/register-product-tuts-video.jpg" alt="">
					<i class="ic-play"></i>
				</a>
			</div>
		</div>
		<ul class="disc">
				<li><a target="_blank" href="http://artbees.net/themes/faq/why-i-need-to-register-my-theme/">Why I need to register my theme?</a></li>
				<li><a target="_blank" href="http://artbees.net/themes/faq/how-can-i-verify-my-api-key/">How can I verify my API Key?</a></li>
				<li><a target="_blank" href="http://artbees.net/themes/faq/why-my-api-key-inactive/">Why my API key is inactive?</a></li>
				<li><a target="_blank" href="http://artbees.net/themes/faq/what-are-the-benefits-of-registration/">What are the benefits of registration?</a></li>
				<li><a target="_blank" href="http://artbees.net/themes/faq/how-can-i-obtain-my-purchase-code/">How can I obtain my Purchase code?</a></li>
				<li><a target="_blank" href="http://artbees.net/themes/faq/i-get-this-error-when-registering-my-theme-duplicated-purchase-key-detected/">I get this error when registering my theme: Duplicated Purchase Key detected?</a></li>
		</ul>
	</div>
</div>
<script type="text/javascript">
	jQuery("#revoke_button").click(function(){
		if(confirm("Are you sure?")){
			jQuery("#apikey").val("");
		}
	});

</script>