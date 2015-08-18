<?php
function mk_theme_enqueue_scripts() {
    if (!is_admin() && !(in_array($GLOBALS['pagenow'], array(
        'wp-login.php',
        'wp-register.php'
    )))) {
        global $mk_options;
        
        $output = '';
        
        $theme_data = wp_get_theme("Jupiter");
        
        remove_action('bbp_enqueue_scripts', 'enqueue_styles');
        
        // Head scripts for very early operations only
        // TODO minify when grows enough to care
        wp_enqueue_script('head-scripts', THEME_JS . '/head-scripts.js', array(
            'jquery'
        ) , $theme_data['Version'], false);
        
        /* Register Scripts */
        wp_enqueue_script('jquery-ui-tabs');
        wp_register_script('jquery-icarousel', THEME_JS . '/icarousel.packed.js', array(
            'jquery'
        ) , $theme_data['Version'], true);
        wp_register_script('jquery-raphael', THEME_JS . '/jquery.raphael-min.js', array(
            'jquery'
        ) , $theme_data['Version'], false);
        wp_register_script('instafeed', THEME_JS . '/instafeed.min.js', array(
            'jquery'
        ) , false, true);
        
        if (is_singular()) {
            wp_enqueue_script('comment-reply');
        }
        
        if ($mk_options['minify-js'] == 'true') {
            wp_enqueue_script('theme-scripts-min', THEME_JS . '/min/scripts-vendors-ck.js', array(
                'jquery'
            ) , $theme_data['Version'], true);
        } 
        else {
            wp_enqueue_script('theme-scripts', THEME_JS . '/scripts-vendors.js', array(
                'jquery'
            ) , $theme_data['Version'], true);
        }
        
        if ($mk_options["disable_smoothscroll"] == "true") {
            wp_enqueue_script('smoothscroll', THEME_JS . '/smoothscroll.js', array() , $theme_data['Version'], true);
        }
        
        // wp_enqueue_script( 'requirejs', THEME_JS .'/require.js', array( 'jquery' ), $theme_data['Version'], true );
        
        if ($mk_options['minify-css'] == 'true') {
            wp_enqueue_style('theme-styles', THEME_STYLES . '/theme-styles.min.css', false, $theme_data['Version'], 'all');
            wp_enqueue_style('theme-icons', THEME_STYLES . '/theme-icons.min.css', false, $theme_data['Version'], 'all');
        } 
        else {
            wp_enqueue_style('theme-styles', THEME_STYLES . '/styles.css', false, $theme_data['Version'], 'all');
            wp_enqueue_style('theme-icons', THEME_STYLES . '/theme-icons.css', false, $theme_data['Version'], 'all');
        }
        
        if ($mk_options['special_fonts_type_1'] == 'google' && !empty($mk_options['special_fonts_list_1'])) {
            $subset_1 = !empty($mk_options['google_font_subset_1']) ? (':&subset=' . $mk_options['google_font_subset_1']) : '';
            wp_enqueue_style('google-font-api-special-1', 'http' . ((is_ssl()) ? 's' : '') . '://fonts.googleapis.com/css?family=' . $mk_options['special_fonts_list_1'] . ':100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic,100,200,300,400,500,600,700,800,900' . $subset_1, false, false, 'all');
        }
        
        if ($mk_options['special_fonts_type_2'] == 'google' && !empty($mk_options['special_fonts_list_2'])) {
            $subset_2 = !empty($mk_options['google_font_subset_2']) ? ('&subset=' . $mk_options['google_font_subset_2']) : '';
            wp_enqueue_style('google-font-api-special-2', 'http' . ((is_ssl()) ? 's' : '') . '://fonts.googleapis.com/css?family=' . $mk_options['special_fonts_list_2'] . ':100italic,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic,100,200,300,400,500,600,700,800,900' . $subset_2, false, false, 'all');
        }
        
        if (is_singular()) wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'mk_theme_enqueue_scripts', 10);

if (!function_exists('mk_enqueue_font_icons')) {
function mk_enqueue_font_icons() {
    
    /* Adding font icons in HTML document to prevent issues when using CDN */
    $styles_dir = THEME_DIR_URI . '/stylesheet';
    $output = "
		@font-face {
			font-family: 'Pe-icon-line';
			src:url('{$styles_dir}/pe-line-icons/Pe-icon-line.eot?lqevop');
			src:url('{$styles_dir}/pe-line-icons/Pe-icon-line.eot?#iefixlqevop') format('embedded-opentype'),
				url('{$styles_dir}/pe-line-icons/Pe-icon-line.woff?lqevop') format('woff'),
				url('{$styles_dir}/pe-line-icons/Pe-icon-line.ttf?lqevop') format('truetype'),
				url('{$styles_dir}/pe-line-icons/Pe-icon-line.svg?lqevop#Pe-icon-line') format('svg');
			font-weight: normal;
			font-style: normal;
		}
		@font-face {
		  font-family: 'FontAwesome';
		  src:url('{$styles_dir}/awesome-icons/fontawesome-webfont.eot?v=4.2');
		  src:url('{$styles_dir}/awesome-icons/fontawesome-webfont.eot?#iefix&v=4.2') format('embedded-opentype'),
		  url('{$styles_dir}/awesome-icons/fontawesome-webfont.woff?v=4.2') format('woff'),
		  url('{$styles_dir}/awesome-icons/fontawesome-webfont.ttf?v=4.2') format('truetype');
		  font-weight: normal;
		  font-style: normal;
		}
		@font-face {
			font-family: 'Icomoon';
			src: url('{$styles_dir}/icomoon/fonts-icomoon.eot');
			src: url('{$styles_dir}/icomoon/fonts-icomoon.eot?#iefix') format('embedded-opentype'), 
			url('{$styles_dir}/icomoon/fonts-icomoon.woff') format('woff'), 
			url('{$styles_dir}/icomoon/fonts-icomoon.ttf') format('truetype'), 
			url('{$styles_dir}/icomoon/fonts-icomoon.svg#Icomoon') format('svg');
			font-weight: normal;
			font-style: normal;
		} 
		@font-face {
		  font-family: 'themeIcons';
		  src: url('{$styles_dir}/theme-icons/theme-icons.eot?wsvj4f');
		  src: url('{$styles_dir}/theme-icons/theme-icons.eot?#iefixwsvj4f') format('embedded-opentype'), 
		  url('{$styles_dir}/theme-icons/theme-icons.woff?wsvj4f') format('woff'), 
		  url('.{$styles_dir}/theme-icons/theme-icons.ttf?wsvj4f') format('truetype'), 
		  url('{$styles_dir}/theme-icons/theme-icons.svg?wsvj4f#icomoon') format('svg');
		  font-weight: normal;
		  font-style: normal;
		}

		@font-face {
			font-family: 'star';
			src: url('{$styles_dir}/woocommerce-fonts/star.eot');
			src: url('{$styles_dir}/woocommerce-fonts/star.eot?#iefix') format('embedded-opentype'), 
			url('{$styles_dir}/woocommerce-fonts/star.woff') format('woff'), 
			url('{$styles_dir}/woocommerce-fonts/star.ttf') format('truetype'), 
			url('{$styles_dir}/woocommerce-fonts/star.svg#star') format('svg');
			font-weight: normal;
			font-style: normal;
		}
		@font-face {
			font-family: 'WooCommerce';
			src: url('{$styles_dir}/woocommerce-fonts/WooCommerce.eot');
			src: url('{$styles_dir}/woocommerce-fonts/WooCommerce.eot?#iefix') format('embedded-opentype'), 
			url('{$styles_dir}/woocommerce-fonts/WooCommerce.woff') format('woff'), 
			url('{$styles_dir}/woocommerce-fonts/WooCommerce.ttf') format('truetype'), 
			url('{$styles_dir}/woocommerce-fonts/WooCommerce.svg#WooCommerce') format('svg');
			font-weight: normal;
			font-style: normal;
		}";
		return $output;
}
}




/**
 * Register our module scripts early and later lazy load them when module is ininitialized
 * by including in its file wp_enqueue_script('module-name');
 *
 * @package jupiter
 */
add_action('wp_enqueue_scripts', 'api_modules', 10);

function api_modules()
{
	wp_register_script( 'api-vimeo', 'http' . ((is_ssl())? 's' : '') . '://a.vimeocdn.com/js/froogaloop2.min.js', array(), false, false);
	wp_register_script( 'api-youtube', 'http' . ((is_ssl())? 's' : '') . '://www.youtube.com/player_api', array(), false, false);
}


function mk_preloader_script() {
global $mk_options;

	$single_preloader = '';
	$preloader_check = 'disabled';
	
	if(global_get_post_id()) {
		$single_preloader = get_post_meta( global_get_post_id(), 'page_preloader', true );
	}

	if($single_preloader == 'true') {
		$preloader_check = 'enabled';
	} else {
		if($mk_options['preloader'] == 'true') {
			$preloader_check = 'enabled';
		}
	}

	if($preloader_check == 'enabled') {
		wp_enqueue_script( 'queryloasder2', THEME_JS .'/min/jquery.queryloader2.js', array( 'jquery' ), false, false );	
	}
	
}

add_action( 'wp_enqueue_scripts', 'mk_preloader_script', 1 );

