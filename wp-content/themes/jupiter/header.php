<!DOCTYPE html>
<html xmlns="http<?php
echo (is_ssl()) ? 's' : ''; ?>://www.w3.org/1999/xhtml" <?php
language_attributes(); ?>>

<head>
<script src="//cdn.optimizely.com/js/3323910293.js"></script>
<?php wp_head(); ?>

<meta property="og:url" content="https://lessig2016.us/"/>
<meta property="og:image" content="https://lessig2016.us/wp-content/uploads/2015/08/facebook-og-image.jpg"/>
<meta property="og:title" content="Lessig 2016 | Referendum for Citizen Equality"/>
<meta property="og:description" content="We need a government that works — one not corrupted by the influence of money, one capable of representing us. We don’t have that government now because the system is rigged. Here is my plan to fix it"/>

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
