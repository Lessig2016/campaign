<?php
function wvpd_is_current_user_allowed_to_copy() {
	return current_user_can('copy_posts');
}

function wvpd_get_copy_user_level() {
	return get_option( 'wvpd_copy_user_level' );
}

function wvpd_get_clone_post_link( $id = 0, $context = 'display', $draft = true ) {
	if ( !wvpd_is_current_user_allowed_to_copy() )
	return;

	if ( !$post = get_post( $id ) )
	return;
	
	global $newposttype;
	$newposttype = 'post';

	if ($draft)
	$action_name = "wvpd_save_as_new_post_draft";
	else
	$action_name = "wvpd_save_as_new_post";

	if ( 'display' == $context )
	$action = '?action='.$action_name.'&amp;post='.$post->ID;
	else
	$action = '?action='.$action_name.'&post='.$post->ID;

	$post_type_object = get_post_type_object( $newposttype );
	if ( !$post_type_object )
	return;

	return apply_filters( 'wvpd_get_clone_post_link', admin_url( "admin.php". $action ), $post->ID, $context );
}

function wvpd_clone_post_link( $link = null, $before = '', $after = '', $id = 0 ) {
	if ( !$post = get_post( $id ) )
	return;

	if ( !$url = wvpd_get_clone_post_link( $post->ID ) )
	return;

	if ( null === $link )
	$link = __('Copy to a new draft', 'wvpd');

	$post_type_obj = get_post_type_object( $newposttype );
	$link = '<a class="post-clone-link" href="' . $url . '" title="'
	. esc_attr(__("Copy to a new draft", 'wvpd'))
	.'">' . $link . '</a>';
	echo $before . apply_filters( 'wvpd_clone_post_link', $link, $post->ID ) . $after;
}

function wvpd_get_original($id = 0 , $output = OBJECT){
	if ( !$post = get_post( $id ) )
	return;
	$original_ID = get_post_meta( $post->ID, '_dp_original');
	if (empty($original_ID)) return null;
	$original_post = get_post($original_ID[0],  $output);
	return $original_post;
}
?>