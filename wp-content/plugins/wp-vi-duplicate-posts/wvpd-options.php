<?php
if ( is_admin() ){ // admin actions
	add_action( 'admin_menu', 'register_my_custom_wvpd_page' );
	add_action( 'admin_init', 'wvpd_register_settings' );
	add_action( 'admin_init', 'wvpd_css' );
	add_action( 'admin_menu', 'wvpd_admin_js' );
}

function wvpd_css() {
		wp_register_style('wvpd_css', plugins_url('css/style.css',__FILE__ ));
		wp_enqueue_style('wvpd_css');
}
//add Jquery to settings page
function wvpd_admin_js() {
    wp_register_script( 'wvpd_admin_js', plugins_url('/script.js', __FILE__), array('jquery'));
    wp_enqueue_script( 'wvpd_admin_js' );
}
function wvpd_register_settings() { 
	register_setting( 'wvpd_options_set', 'wvpd_copydate');
	register_setting( 'wvpd_options_set', 'wvpd_copyexcerpt');
	register_setting( 'wvpd_options_set', 'wvpd_copyattachments');
	register_setting( 'wvpd_options_set', 'wvpd_copychildren');
	register_setting( 'wvpd_options_set', 'wvpd_copystatus');
	register_setting( 'wvpd_options_set', 'wvpd_blacklist');
	register_setting( 'wvpd_options_set', 'wvpd_taxonomies_blacklist');
	register_setting( 'wvpd_options_set', 'wvpd_title_prefix');
	register_setting( 'wvpd_options_set', 'wvpd_title_suffix');
	register_setting( 'wvpd_options_set', 'wvpd_roles');
	register_setting( 'wvpd_options_set', 'wvpd_show_row');
	register_setting( 'wvpd_options_set', 'wvpd_show_submitbox');
	register_setting( 'wvpd_options_set', 'wvpd_copy2others');
}

/* Register our menu with WordPress menubar */
    function register_my_custom_wvpd_page() {
        // This adds the main menu page
        add_menu_page( __('WP VI Post Duplicator', 'wvpd'), __('WP VI Post Duplicator', 'wvpd'), 'manage_options', 'wvpd' , 'wvpd_options');
    }

function wvpd_options() {

	if ( current_user_can( 'edit_users' ) && (isset($_GET['settings-updated'])  && $_GET['settings-updated'] == true)){
		global $wp_roles;
		$roles = $wp_roles->get_names();

		$dp_roles = get_option('wvpd_roles');
		if ( $dp_roles == "" ) $dp_roles = array();

		foreach ($roles as $name => $display_name){
			$role = get_role($name);

			// role should have at least edit_posts capability
			if ( !$role->has_cap('edit_posts') ) continue;

			/* If the role doesn't have the capability and it was selected, add it. */
			if ( !$role->has_cap( 'copy_posts' )  && in_array($name, $dp_roles) )
			$role->add_cap( 'copy_posts' );

			/* If the role has the capability and it wasn't selected, remove it. */
			elseif ( $role->has_cap( 'copy_posts' ) && !in_array($name, $dp_roles) )
			$role->remove_cap( 'copy_posts' );
		}
	}

?>
<div class="wrap">
   <div class="top">
  <h3> <?php _e( "WP VI Post Duplicator") ?> <small><?php _e("By","wvpd") ?> <a href="http://www.vivacityinfotech.net" target="_blank">Vivacity Infotech Pvt. Ltd.</a>
  </h3>
    </div> <!-- ------End of top-----------  -->
<div class="inner_wrap">
<?php settings_errors(); ?>
	<div class="left">

	<form method="post" action="options.php">
	<h3 class="title"><?php _e("Copy these options","wvpd") ?></h3>
		<div id="" class="togglediv">
<?php settings_fields('wvpd_options_set'); ?>

		<table class="form-table admintbl">
			<tr>
				<th><label><?php _e("Excerpt", 'wvpd'); ?></label>
				</th>
				<td><input type="checkbox" name="wvpd_copyexcerpt"
					value="1" <?php  if(get_option('wvpd_copyexcerpt') == 1) echo 'checked="checked"'; ?>"/>
					<span class="description"><?php _e("Enable checkbox for copy the excerpt.", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			<tr>
				<th><label><?php _e("Attachments", 'wvpd'); ?></label>
				</th>
				<td><input type="checkbox" name="wvpd_copyattachments"
					value="1" <?php  if(get_option('wvpd_copyattachments') == 1) echo 'checked="checked"'; ?>"/>
					<span class="description"><?php _e("Enable checkbox for copy the attachments.", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			<tr>
				<th><label><?php _e("Status", 'wvpd'); ?></label>
				</th>
				<td><input type="checkbox" name="wvpd_copystatus"
					value="1" <?php  if(get_option('wvpd_copystatus') == 1) echo 'checked="checked"'; ?>"/>
					<span class="description"><?php _e("Enable checkbox for copy the original post status:draft/published/pending when cloning from the post list.", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			<tr>
				<th><label><?php _e("Original Data", 'wvpd'); ?></label>
				</th>
				<td><input type="checkbox" name="wvpd_copydate" value="1" <?php  if(get_option('wvpd_copydate') == 1) echo 'checked="checked"'; ?>"/>
					<span class="description"><?php _e("Enable the checkbox for copy original date.</br>
					if checkbox is unchecked, new copy will have its publication data set to current time.", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			<tr>
				<th><label><?php _e("Children", 'wvpd'); ?></label>
				</th>
				<td><input type="checkbox" name="wvpd_copychildren"
					value="1" <?php  if(get_option('wvpd_copychildren') == 1) echo 'checked="checked"'; ?>"/>
					<span class="description"><?php _e("Enable checkbox for copy the children.", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			</table>
			</div>
		<h3 class="title"><?php _e("Do not copy these options","wvpd") ?></h3>
		<div id="" class="togglediv">
		<table class="form-table admintbl">
			<tr>
				<th><label><?php _e("Do not copy these meta fields", 'wvpd'); ?></label>
				</th>
				<td><input type="text" name="wvpd_blacklist"
					value="<?php echo get_option('wvpd_blacklist'); ?>" /><br> <span
					class="description"><?php _e("Comma-separated list of meta fields that must not be copied", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			<tr>
				<th><label><?php _e("Do not copy these taxonomies", 'wvpd'); ?></label>
				</th>
				<td><div>
						<?php $taxonomies=get_taxonomies(array('public' => true),'objects');
						$taxonomies_blacklist = get_option('wvpd_taxonomies_blacklist');
						if ($taxonomies_blacklist == "") $taxonomies_blacklist = array();
						foreach ($taxonomies as $taxonomy ) : ?>
						<label style="display: block;"> <input type="checkbox"
							name="wvpd_taxonomies_blacklist[]"
							value="<?php echo $taxonomy->name?>"
							<?php if(in_array($taxonomy->name,$taxonomies_blacklist)) echo 'checked="checked"'?> />
							<?php echo $taxonomy->labels->name?> </label>
							<?php endforeach; ?>
					</div><span class="description"><?php _e("Select the taxonomies you don't want to be copied", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			</table>
			</div>
		<h3 class="title"><?php _e("Title settings","wvpd") ?></h3>
		<div id="" class="togglediv">
		<table class="form-table admintbl">
			<tr>
				<th><label><?php _e("Title prefix", 'wvpd'); ?></label>
				</th>
				<td><input type="text" name="wvpd_title_prefix"
					value="<?php echo get_option('wvpd_title_prefix'); ?>" /><br>
					<span class="description"><?php _e("Add text before the original title, e.g. \"Copy of\" (Leave blank for no prefix)", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			<tr>
				<th><label><?php _e("Title suffix", 'wvpd'); ?></label>
				</th>
				<td><input type="text" name="wvpd_title_suffix"
					value="<?php echo get_option('wvpd_title_suffix'); ?>" /><br>
					<span class="description"><?php _e("Add text after the original title, e.g. \"duplicate\" (Leave blank for no suffix)", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			</table>
		</div>
		<h3 class="title"><?php _e("Roles settings","wvpd") ?></h3>
		<div id="" class="togglediv">
		<table class="form-table admintbl">
			<tr>
				<th><label><?php _e("Roles settings", 'wvpd'); ?></label>
				</th>
				<td><div>
						<?php	global $wp_roles;
						$roles = $wp_roles->get_names();
						foreach ($roles as $name => $display_name): $role = get_role($name);
						if ( !$role->has_cap('edit_posts') ) continue; ?>
						<label style="display: block;">
						<input type="checkbox" name="wvpd_roles[]" value="<?php echo $name ?>"
							<?php if($role->has_cap('copy_posts')) echo 'checked="checked"'?> />
							<?php echo translate_user_role($display_name); ?> </label>
							<?php endforeach; ?>
					</div> <span class="description"><?php _e("Warning: users will be able to copy all posts, even those of other users", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			</table>
			</div>
		<h3 class="title"><?php _e("Display settings","wvpd") ?></h3>
		<div id="" class="togglediv">
		<table class="form-table admintbl">
			<tr>
				<th><label><?php _e("Enable for copy post/page into another post-types", 'wvpd'); ?></label>
				</th>	
				<td><input type="checkbox" id="wvpd_copy2others" name="wvpd_copy2others" value="1" <?php if(get_option('wvpd_copy2others') == 1) echo 'checked="checked"'; ?> />	<span class="description"><?php _e("By default its creates copy to current post-type.
Enable checkbox for copy post/page into another post-types, in post/page edit screen you will get checkboxes for post-types. ", 'wvpd'); ?>
				</span>
				</td>
			</tr>
			<!-- ------Start Post type Settings--------- -->		
			<tr>
				<th><label><?php _e("Show links in", 'wvpd'); ?></label>
				</th>
				<td><label style="display: block">
					 <input type="checkbox" name="wvpd_show_row" value="1" <?php  if(get_option('wvpd_show_row') == 1) echo 'checked="checked"'; ?>"/>
						<?php _e("Post list", 'wvpd'); ?> </label>
						<label style="display: block">
						<input type="checkbox" name="wvpd_show_submitbox" value="1" <?php  if(get_option('wvpd_show_submitbox') == 1) echo 'checked="checked"'; ?>"/>
						<?php _e("Edit screen", 'wvpd'); ?> </label>
				</td>
			</tr>
		</table>
		</div>
		<p class="submit">
			<input type="submit" class="button-primary"
				value="<?php _e('Save Changes', 'wvpd') ?>" />
		</p>

	</form>
		</div> <!-- --------End of left div--------- -->
	
	 <div class="right">
	<center>
<div class="bottom">
		    <h3 id="download-comments-wvpd" class="title"><?php _e( 'Download Free Plugins', 'wvpd' ); ?></h3>
		     
     <div id="downloadtbl-comments-wvpd" class="togglediv">  
	<h3 class="company">
<p> Vivacity InfoTech Pvt. Ltd. is an ISO 9001:2008 Certified Company is a Global IT Services company with expertise in outsourced product development and custom software development with focusing on software development, IT consulting, customized development.We have 200+ satisfied clients worldwide.</p>	
<?php _e( 'Our Top 5 Latest Plugins', 'wvpd' ); ?>:
</h3>
<ul class="">
<li><a target="_blank" href="https://wordpress.org/plugins/woocommerce-social-buttons/">Woocommerce Social Buttons</a></li>
<li><a target="_blank" href="https://wordpress.org/plugins/vi-random-posts-widget/">Vi Random Post Widget</a></li>
<li><a target="_blank" href="http://wordpress.org/plugins/wp-infinite-scroll-posts/">WP EasyScroll Posts</a></li>
<li><a target="_blank" href="https://wordpress.org/plugins/buddypress-social-icons/">BuddyPress Social Icons</a></li>
<li><a target="_blank" href="http://wordpress.org/plugins/wp-fb-share-like-button/">WP Facebook Like Button</a></li>
</ul>
  </div> 
</div>		
<div class="bottom">
		    <h3 id="donatehere-comments-wvpd" class="title"><?php _e( 'Donate Here', 'wvpd' ); ?></h3>
     <div id="donateheretbl-comments-wvpd" class="togglediv">  
     <p><?php _e( 'If you want to donate , please click on below image.', 'wvpd' ); ?></p>
	<a href="http://bit.ly/1icl56K" target="_blank"><img class="donate" src="<?php echo plugins_url( 'assets/paypal.gif' , __FILE__ ); ?>" width="150" height="50" title="<?php _e( 'Donate Here', 'wvpd' ); ?>"></a>		
  </div> 
</div>	
<div class="bottom">
		    <h3 id="donatehere-comments-wvpd" class="title"><?php _e( 'Woocommerce Frontend Plugin', 'wvpd' ); ?></h3>
     <div id="donateheretbl-comments-wvpd" class="togglediv">  
     <p><?php _e( 'If you want to purchase , please click on below image.', 'wvpd' ); ?></p>
	<a href="http://bit.ly/1HZGRBg" target="_blank"><img class="donate" src="<?php echo plugins_url( 'assets/woo_frontend_banner.png' , __FILE__ ); ?>" width="336" height="280" title="<?php _e( 'Donate Here', 'wvpd' ); ?>"></a>		
  </div> 
</div>
<div class="bottom">
		    <h3 id="donatehere-comments-wvpd" class="title"><?php _e( 'Blue Frog Template', 'wvpd' ); ?></h3>
     <div id="donateheretbl-comments-wvpd" class="togglediv">  
     <p><?php _e( 'If you want to purchase , please click on below image.', 'wvpd' ); ?></p>
	<a href="http://bit.ly/1Gwp4Vv" target="_blank"><img class="donate" src="<?php echo plugins_url( 'assets/blue_frog_banner.png' , __FILE__ ); ?>" width="336" height="280" title="<?php _e( 'Donate Here', 'wvpd' ); ?>"></a>		
  </div> 
</div>


	</center>
</div> <!-- --------End of right div---------- -->
</div> <!-- --------End of inner_wrap--------- -->
</div> <!-- ---------End of wrap-------------- -->
<script type="text/javascript" >
jQuery(document).ready(function($){
    //alert('Hello World!');
  jQuery("#donatehere-comments-wvpd").click(function(){
      jQuery("#donateheretbl-comments-wvpd").animate({
        height:'toggle'
      });
  }); 
   jQuery("#download-comments-wvpd").click(function(){
      jQuery("#downloadtbl-comments-wvpd").animate({
        height:'toggle'
      });
  }); 
  jQuery("#aboutauthor-comments-wvpd").click(function(){
      jQuery("#aboutauthortbl-comments-wvpd").animate({
        height:'toggle'
      });
  });
 
});

</script>
<?php } ?>