<?php
if(!is_admin())
return;

require_once (dirname(__FILE__).'/wvpd-options.php');

function wvpd_get_installed_version() {
	return get_option( 'wvpd_version' );
}

function wvpd_get_current_version() {
	return CURRENT_VERSION_OF_WVPD;
}

global $newposttype;
/* Plugin upgrade */
add_action('admin_init','wvpd_plugin_upgrade');

function wvpd_plugin_upgrade() {
	$installed_version = wvpd_get_installed_version();

	if (empty($installed_version)) { 

		$default_roles = array( 8 => 'administrator'	);

		foreach ($default_roles as $level => $name){
			$role = get_role($name);
			if(!empty($role)) $role->add_cap( 'copy_posts' );
		}
			
		add_option('wvpd_copyexcerpt','1');
		add_option('wvpd_copyattachments','1');
		add_option('wvpd_copychildren','0');
		add_option('wvpd_copystatus','1');
		add_option('wvpd_taxonomies_blacklist',array());
		add_option('wvpd_show_row','1');
		add_option('wvpd_show_submitbox','1');
		add_option('wvpd_copy2others','0');
		
	} else if ( $installed_version==wvpd_get_current_version() ) { 

	} else { 
		delete_option('wvpd_admin_user_level');
		delete_option('wvpd_create_user_level');
		delete_option('wvpd_view_user_level');
		delete_option('dp_notice');

		$min_user_level = get_option('wvpd_copy_user_level');

		if (!empty($min_user_level)){
			$default_roles = array(
			1 => 'contributor',
			2 => 'author',
			3 => 'editor',
			8 => 'administrator'
			);

			foreach ($default_roles as $level => $name){
				$role = get_role($name);
				if ($role && $min_user_level <= $level)
				$role->add_cap( 'copy_posts' );
			}
			delete_option('wvpd_copy_user_level');
		}

		add_option('wvpd_copyexcerpt','1');
		add_option('wvpd_copyattachments','0');
		add_option('wvpd_copychildren','0');
		add_option('wvpd_copystatus','0');
		add_option('wvpd_taxonomies_blacklist',array());
		add_option('wvpd_show_row','1');
		add_option('wvpd_show_submitbox','1');
		add_option('wvpd_copy2others','0');
	}

	update_option( 'wvpd_version', wvpd_get_current_version() );

}

if (get_option('wvpd_show_row') == 1){
	add_filter('post_row_actions', 'wvpd_make_duplicate_link_row',10,2);
	add_filter('page_row_actions', 'wvpd_make_duplicate_link_row',10,2);
}

// Add the link to action list for post_row_actions
function wvpd_make_duplicate_link_row($actions, $post) {
	if (wvpd_is_current_user_allowed_to_copy()) {
   	if(get_option('wvpd_copy2others') == 1) {
			$listlabel = __('Copy to listed post types as draft', 'wvpd');
			$copyPosts = __('Copy to listed post types', 'wvpd');
		} else {
			$listlabel = __('Copy to current post types as draft', 'wvpd');
			$copyPosts = __('Copy to current post type', 'wvpd');
		}
	
		$actions['clone'] = '<a href="'.wvpd_get_clone_post_link( $post->ID , 'display', false).'" title="' . esc_attr($copyPosts) . '">' . $copyPosts . '</a>';
		$actions['edit_as_new_draft'] = '<a href="'. wvpd_get_clone_post_link( $post->ID ) .'" title="'
		. esc_attr($listlabel) . '">' . $listlabel . '</a>';
	}
	return $actions; 
}

/* Add a button in the post/page edit screen to create a clone */
if (get_option('wvpd_show_submitbox') == 1){
	add_action( 'post_submitbox_start', 'wvpd_add_wvpd_button' );
}

function wvpd_add_wvpd_button() {
	if ( isset( $_GET['post'] ) && wvpd_is_current_user_allowed_to_copy()) {
		?>
<div id="duplicate-action">
<?php if(get_option('wvpd_copy2others') == 1) {
	$label = __('Copy to listed post types', 'wvpd');
	} else {
	$label = __('Copy to current post types', 'wvpd');
	}
?>
	<a class="submitduplicate duplication"	href="<?php echo wvpd_get_clone_post_link( $_GET['post'] , 'display', false ) ?>">
	<?php echo $label; ?>
	</a>
</div>
<?php
	}
}

/* Connect actions to functions */
add_action('admin_action_wvpd_save_as_new_post', 'wvpd_save_as_new_post');
add_action('admin_action_wvpd_save_as_new_post_draft', 'wvpd_save_as_new_post_draft');


function wvpd_save_as_new_post_draft(){
	wvpd_save_as_new_post('draft');
}

function wvpd_save_as_new_post($status = ''){
	if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'wvpd_save_as_new_post' == $_REQUEST['action'] ) ) ) {
		wp_die(__('No post to duplicate has been supplied!', 'wvpd'));
	}

	$id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	$post = get_post($id);

	if (isset($post) && $post!=null) {
		if(get_option('wvpd_copy2others') == 1) {
		$mypostypestring = get_post_meta($post->ID, 'mycpt', true);
		$mypostypes = explode(',', $mypostypestring);
			foreach ($mypostypes as $mypostype){
		 		$newpostype = $mypostype;
		 		$new_id = wvpd_create_duplicate($post, $status , $newpostype);
			}	
		}
		else {
			$new_id = wvpd_create_duplicate($post, $status);
		}
		if ($status == ''){
			wp_redirect( admin_url( 'edit.php?post_type='.$post->post_type) );
		} else {
			// Redirect to the edit screen for the new draft post
			wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_id ) );
		}
		exit;

	} else {
		$post_type_obj = get_post_type_object( $post->post_type );
		wp_die(esc_attr(__('Copy creation failed, could not find original:', 'wvpd')) . ' ' . htmlspecialchars($id));
	}
}

// ==================add custom meta ===============
if(get_option('wvpd_copy2others') == 1) {
add_action( 'add_meta_boxes', 'my_add_custom_box' );
}
function my_add_custom_box($postType) {
	$types = get_post_types( '', 'names' );
	if(in_array($postType, $types)){
		add_meta_box('myid',	__( 'Title', 'wvpd' ),'my_meta_box', $postType );
	}
}
function my_meta_box( $post ) { ?>
    <p>
        <label for="checkbox_post_type"> <?php _e('Choose Post-types for which you want to make copy of this post:','wvpd') ?> </label>
         <br>
         <?php 
         $args = array('public' => true,);
			$output = 'objects'; // names or objects, note names is the default
			$operator = 'and'; // 'and' or 'or'

			$post_types = get_post_types( $args, $output, $operator ); 

   foreach ($post_types as $post_type) {
   
    $mypostypenw = get_post_meta($post->ID, 'mycpt', true);
     	 
     	 $exposts = explode(',', $mypostypenw);
     	 foreach($exposts as $expost) {
     	 	 
     	    if( ($expost) == ($post_type->name)) {
     	       $field_id_checked = 'checked'; 
     	    } else {
     	     $field_id_checked = '';
   }
   }
    
          if( $post_type->name != 'attachment'){
   
            ?>
            <label for="<?php echo esc_html($post_type->name); ?>">
            <input type="checkbox" value="<?php echo esc_attr($post_type->name); ?>"  name="myCPT[]" id="<?php echo esc_html($post_type->name); ?>" <?php foreach($exposts as $expost) {
     	 	 $expost;
     	    if( ($expost) == ($post_type->name)) {
     	    echo $field_id_checked = 'checked="checked"'; 
     	    } else {
     	    echo $field_id_checked = '';
   }
   }  ?> />
            <?php echo esc_html($post_type->labels->name); ?></label>
            
            <br>
            <?php 
                }
            } ?>
       </p>
    <?php     
}

add_action( 'save_post', 'save_custom_details' );
function save_custom_details( ) {
   global $post;
       if(isset( $_POST['myCPT'] ))
    {
       $custom = $_POST['myCPT']; 
       $string = '';
       foreach ($custom as $custometa) {
       	//$custometa .= ",".$custometa;
       		// $string = implode(",",$custometa);
       		 $string .= ",$custometa";
       		}
        $string = substr($string, 1);
            // print_r($post->ID);
           // $custom_meta = get_post_meta($post->ID, 'mycpt', true);
             update_post_meta($post->ID, 'mycpt',$string);
      }
      else {
					$string = '';
					update_post_meta($post->ID, 'mycpt',$string);     	
      	  }  
}
// ==================End add custom meta ===============

/**
 * Get the currently registered user
 */
function wvpd_get_current_user() {
	if (function_exists('wp_get_current_user')) {
		return wp_get_current_user();
	} else if (function_exists('get_currentuserinfo')) {
		global $userdata;
		get_currentuserinfo();
		return $userdata;
	} else {
		$user_login = $_COOKIE[USER_COOKIE];
		$sql = $wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_login=%s", $user_login);
		$current_user = $wpdb->get_results($sql);			
		return $current_user;
	}
}

function wvpd_copy_post_taxonomies($new_id, $post ) {
		$mypostypestring = get_post_meta($post->ID, 'mycpt', true);
		$mypostypes = explode(',', $mypostypestring);
		foreach ($mypostypes as $mypostype){
			global $wpdb;
			if (isset($wpdb->terms)) {
	
				global $newposttype;
				//$newposttype = 'post';
				
				wp_set_object_terms( $new_id, NULL, 'category' );
				$post_taxonomies = get_object_taxonomies($mypostype);
				$taxonomies_blacklist = get_option('wvpd_taxonomies_blacklist');
				if ($taxonomies_blacklist == "") $taxonomies_blacklist = array();
				$taxonomies = array_diff($post_taxonomies, $taxonomies_blacklist);
					foreach ($taxonomies as $taxonomy) {
						$post_terms = wp_get_object_terms($post->ID, $taxonomy, array( 'orderby' => 'term_order' ));
						$terms = array();
						for ($i=0; $i<count($post_terms); $i++) {
							$terms[] = $post_terms[$i]->slug;
						}
						wp_set_object_terms($new_id, $terms, $taxonomy);
					}
			}
		}
}

// Using our action hooks to copy taxonomies
add_action('dp_wvpd', 'wvpd_copy_post_taxonomies', 10, 2);
add_action('dp_duplicate_page', 'wvpd_copy_post_taxonomies', 10, 2);

function wvpd_copy_post_meta_info($new_id, $post) {
		 $mypostypestring = get_post_meta($post->ID, 'mycpt', true);
$mypostypes = explode(',', $mypostypestring);
foreach ($mypostypes as $mypostype){
	$post_meta_keys = get_post_custom_keys($post->ID);
	if (empty($post_meta_keys)) return;
	$meta_blacklist = explode(",",get_option('wvpd_blacklist'));
	if ($meta_blacklist == "") $meta_blacklist = array();
	$meta_keys = array_diff($post_meta_keys, $meta_blacklist);

	foreach ($meta_keys as $meta_key) {
		$meta_values = get_post_custom_values($meta_key, $post->ID);
		foreach ($meta_values as $meta_value) {
			$meta_value = maybe_unserialize($meta_value);
			add_post_meta($new_id, $meta_key, $meta_value);
		}
	}
}
}
// action hooks to copy meta fields
add_action('dp_wvpd', 'wvpd_copy_post_meta_info', 10, 2);
add_action('dp_duplicate_page', 'wvpd_copy_post_meta_info', 10, 2);

function wvpd_copy_children($new_id, $post){
		 $mypostypestring = get_post_meta($post->ID, 'mycpt', true);
$mypostypes = explode(',', $mypostypestring);
foreach ($mypostypes as $mypostype){
	
	$copy_attachments = get_option('wvpd_copyattachments');
	$copy_children = get_option('wvpd_copychildren');

	// get children
	$children = get_posts(array( 'post_type' => 'any', 'numberposts' => -1, 'post_status' => 'any', 'post_parent' => $post->ID ));
	// clone old attachments
	foreach($children as $child){
		if ($copy_attachments == 0 && $child->post_type == 'attachment') continue;
		if ($copy_children == 0 && $child->post_type != 'attachment') continue;
		wvpd_create_duplicate($child, '', $new_id);
	}
}
}
// action hooks to copy attachments
add_action('dp_wvpd', 'wvpd_copy_children', 10, 2);
add_action('dp_duplicate_page', 'wvpd_copy_children', 10, 2);

function wvpd_create_duplicate($post, $status = '',$newpostype , $parent_id = '' ) {

if(!empty($newpostype)){
		$newpostype=$newpostype;	
	}
else {
	   $newpostype = $post->post_type;
	}

print_r($newposttype);
 $mypostypestr = get_post_meta($post->ID, 'mycpt', true);
 $mypostypestrnws = explode(',', $mypostypestr);
 $length  = count($mypostypestrnws);

	if ($post->post_type == 'revision') return;

	if ($post->post_type != 'attachment'){
		$prefix = get_option('wvpd_title_prefix');
		$suffix = get_option('wvpd_title_suffix');
		if (!empty($prefix)) $prefix.= " ";
		if (!empty($suffix)) $suffix = " ".$suffix;
		if (get_option('wvpd_copystatus') == 0) $status = 'draft';
	}
	$new_post_author = wvpd_get_current_user();
	
  $new_post = array(
	'menu_order' => $post->menu_order,
	'comment_status' => $post->comment_status,
	'ping_status' => $post->ping_status,
	'post_author' => $new_post_author->ID,
	'post_content' => $post->post_content,
	'post_excerpt' => (get_option('wvpd_copyexcerpt') == '1') ? $post->post_excerpt : "",
	'post_mime_type' => $post->post_mime_type,
	'post_parent' => $new_post_parent = empty($parent_id)? $post->post_parent : $parent_id,
	'post_password' => $post->post_password,
	'post_status' => $new_post_status = (empty($status))? $post->post_status: $status,
	'post_title' => $prefix.$post->post_title.$suffix,
	'post_type' => $newpostype
	
	);

	if(get_option('wvpd_copydate') == 1){
		$new_post['post_date'] = $new_post_date =  $post->post_date ;
		$new_post['post_date_gmt'] = get_gmt_from_date($new_post_date);
	}

	$new_post_id = wp_insert_post($new_post);

	// If the copy is published or scheduled, we have to set a proper slug.
	if ($new_post_status == 'publish' || $new_post_status == 'future'){
		$post_name = wp_unique_post_slug($post->post_name, $new_post_id, $new_post_status, $newpostype, $new_post_parent);

		$new_post = array();
		$new_post['ID'] = $new_post_id;
		$new_post['post_name'] = $post_name;

		// Update the post into the database
		wp_update_post( $new_post );
	}

	if ($post->post_type == 'page' || (function_exists('is_post_type_hierarchical') && is_post_type_hierarchical( $post->post_type )))
	do_action( 'dp_duplicate_page', $new_post_id, $post );
	else
	do_action( 'dp_wvpd', $new_post_id, $post );

	delete_post_meta($new_post_id, '_dp_original');
	add_post_meta($new_post_id, '_dp_original', $post->ID);

	return $new_post_id;

}
?>