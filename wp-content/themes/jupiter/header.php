<!DOCTYPE html>
<html xmlns="http<?php
echo (is_ssl()) ? 's' : ''; ?>://www.w3.org/1999/xhtml" <?php
language_attributes(); ?>>

<head>
<?php wp_head(); ?>

<?php if ( strpos($_SERVER['REQUEST_URI'], 'nhlaunch') !== FALSE ) { ?>
  <meta property="og:type" content="video">
  <meta property="og:title" content="Larry Lessig Announces His Candidacy for President">
  <meta property="og:image" content="https://i.ytimg.com/vi/_dyXstfmbSk/maxresdefault.jpg">
  <meta property="og:url" content="https://lessig2016.us/nhlaunch">
  <meta property="og:video:url" content="https://www.youtube.com/embed/_dyXstfmbSk">
  <meta property="og:video:secure_url" content="https://www.youtube.com/embed/_dyXstfmbSk">
  <meta property="og:video:type" content="text/html">
  <meta property="og:video:width" content="1280">
  <meta property="og:video:height" content="720">
  <meta property="og:video:url" content="http://www.youtube.com/v/_dyXstfmbSk?version=3&amp;autohide=1">
  <meta property="og:video:secure_url" content="https://www.youtube.com/v/_dyXstfmbSk?version=3&amp;autohide=1">
  <meta property="og:video:type" content="application/x-shockwave-flash">
  <meta property="og:video:width" content="1280">
  <meta property="og:video:height" content="720">
<?php } elseif ( !empty( $_GET['team'] ) ) { ?>
  <meta property="og:url" content="https://lessigforpresident.com/take-action/recruit/?team=<?php echo $_GET['team'];?>"/>
  <meta property="og:image" content="https://lessigforpresident.com/wp-content/uploads/2015/08/facebook-og-image.jpg" />
  <meta property="og:title" content="Lessig 2016 | Referendum for Citizen Equality"/>
  <meta property="og:description" content="We need a government that works — one not corrupted by the influence of money, one capable of representing us. We don’t have that government now because the system is rigged. Here is my plan to fix it."/>
<?php $team_parts = explode( '-', $_GET['team']);
  if( !empty( $team_parts[1] ) && !empty( $team_parts[2] ) ){
    echo '<meta property="og:title" content="' . $team_parts[1] . ' ' . $team_parts[2] . '\'s Pledge Page " />';
  }
} else { ?>
<meta property="og:url" content="https://lessig2016.us/"/>
<meta property="og:image" content="https://lessig2016.us/wp-content/uploads/2015/08/facebook-og-image.jpg"/>
<meta property="og:title" content="Lessig 2016 | Referendum for Citizen Equality"/>
<meta property="og:description" content="We need a government that works — one not corrupted by the influence of money, one capable of representing us. We don’t have that government now because the system is rigged. Here is my plan to fix it."/>
<?php } ?>

<!-- Start Visual Website Optimizer Asynchronous Code -->
<script type='text/javascript'>
var _vwo_code=(function(){
var account_id=189053,
settings_tolerance=2000,
library_tolerance=2500,
use_existing_jquery=false,
// DO NOT EDIT BELOW THIS LINE
f=false,d=document;return{use_existing_jquery:function(){return use_existing_jquery;},library_tolerance:function(){return library_tolerance;},finish:function(){if(!f){f=true;var a=d.getElementById('_vis_opt_path_hides');if(a)a.parentNode.removeChild(a);}},finished:function(){return f;},load:function(a){var b=d.createElement('script');b.src=a;b.type='text/javascript';b.innerText;b.onerror=function(){_vwo_code.finish();};d.getElementsByTagName('head')[0].appendChild(b);},init:function(){settings_timer=setTimeout('_vwo_code.finish()',settings_tolerance);this.load('//dev.visualwebsiteoptimizer.com/j.php?a='+account_id+'&u='+encodeURIComponent(d.URL)+'&r='+Math.random());var a=d.createElement('style'),b='body{opacity:0 !important;filter:alpha(opacity=0) !important;background:none !important;}',h=d.getElementsByTagName('head')[0];a.setAttribute('id','_vis_opt_path_hides');a.setAttribute('type','text/css');if(a.styleSheet)a.styleSheet.cssText=b;else a.appendChild(d.createTextNode(b));h.appendChild(a);return settings_timer;}};}());_vwo_settings_timer=_vwo_code.init();
</script>
<!-- End Visual Website Optimizer Asynchronous Code -->
</head>


<?php
global $mk_options;

$post_id = global_get_post_id();

global $app_modules;
$app_modules[] = array(
    'name' => 'theme_header',
    'params' => array(
        'id' => 'mk-header',
        'height' => $mk_options['header_height'],
        'stickyHeight' => $mk_options['header_scroll_height'],
        'stickyOffset' => $sticky_header_offset,
        'hasToolbar' => $toolbar_toggle
    )
);

if ($post_id) {
    $show_header = get_post_meta($post_id, '_template', true);
}

if ($header_style == 4) {
    $vertical_header_logo_align = (isset($mk_options['vertical_header_logo_align']) && !empty($mk_options['vertical_header_logo_align'])) ? $mk_options['vertical_header_logo_align'] : 'center';
} 
else {
    $header_sticky_style_css = 'sticky-style-' . $sticky_header_style;
    if ($sticky_header_style == 'lazy') {
        $header_sticky_style_css = 'sticky-style-fixed';
    }
}

?>

<body <?php
body_class(mk_get_body_class($post_id)); ?> data-backText="<?php
_e('Back', 'mk_framework'); ?>" data-vm-anim="<?php
echo $mk_options['vertical_menu_anim']; ?>" <?php
echo get_schema_markup('body'); ?>
data-adminbar="<?php
echo is_admin_bar_showing() ?>">

<?php
do_action('theme_after_body_tag_start');
?>

<div id="mk-boxed-layout">
<div id="mk-theme-container">

<div id="header-holder"></div>
<header id="header">
	<ul class="fast-donate">
		<li class="option" onClick="location.href='/donate/';">$5</li>
		<li class="option" onClick="location.href='/donate/';">$25</li>
		<li class="option" onClick="location.href='/donate/';">$100</li>
		<li class="option custom"><label>
			$<input type="text" name="hello" />
		</label></li>
		<li class="submit">
			<button type="button" onClick="location.href='/donate/';">Donate</button>
		</li>
	</ul>

	<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">= LESSIG</a>

	<a id="header-hamburger"></a>
	<?php
	wp_nav_menu(array(
		'menu' => 'Header-menu',
		'menu_class' => 'nav-menu',
		'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s<li><a href="#more" class="do-open-megamenu">More</a></li></ul>'
	));
	?>

	<div id="header-nav" class="megawide-nav">
		<div class="mk-grid">
			<a href="#close-menu" class="do-hide-megamenu"></a>

			<?php wp_nav_menu(array(
				'menu' => 'Megamenu',
				'menu_class' => 'nav-menu',
			)); ?>

			<div class="clearboth"></div>
		</div>
	</div>
</header>