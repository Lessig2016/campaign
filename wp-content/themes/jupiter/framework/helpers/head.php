<?php
if (!defined('THEME_FRAMEWORK')) exit('No direct script access allowed');

/**
 * Contains various outputs to header.php
 *
 * @author      Bob Ulusoy
 * @copyright   Artbees LTD (c)
 * @link        http://artbees.net
 * @since       Version 4.2
 * @package     artbees
 */

/**
 * output header meta tags
 */
if (!function_exists('mk_apple_touch_icons')) {
    function mk_head_meta_tags() {
        echo "\n";
        echo '<meta charset="' . get_bloginfo('charset') . '" />' . "\n";
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />' . "\n";
        echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />' . "\n";
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>' . "\n";
        echo '<meta name="format-detection" content="telephone=no">' . "\n";
    }
    add_action('wp_head', 'mk_head_meta_tags', 1);
}

/**
 * outputs custom fav icons and apple touch icons into head tag
 */
if (!function_exists('mk_apple_touch_icons')) {
    function mk_apple_touch_icons() {
        global $mk_options;
        
        echo "\n";
        
        if ($mk_options['custom_favicon']):
            echo '<link rel="shortcut icon" href="' . $mk_options['custom_favicon'] . '"  />' . "\n";
        else:
            echo '<link rel="shortcut icon" href="' . THEME_IMAGES . '/favicon.png"  />' . "\n";
        endif;
        
        if ($mk_options['iphone_icon']):
            echo '<link rel="apple-touch-icon-precomposed" href="' . $mk_options['iphone_icon'] . '">' . "\n";
        endif;
        
        if ($mk_options['iphone_icon_retina']):
            echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . $mk_options['iphone_icon_retina'] . '">' . "\n";
        endif;
        
        if ($mk_options['ipad_icon']):
            echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . $mk_options['ipad_icon'] . '">' . "\n";
        endif;
        
        if ($mk_options['ipad_icon_retina']):
            echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . $mk_options['ipad_icon_retina'] . '">' . "\n";
        endif;
    }
    add_action('wp_head', 'mk_apple_touch_icons', 2);
}

/**
 * outputs custom fav icons and apple touch icons into head tag
 */
if (!function_exists('mk_ie_compatibility_media')) {
    function mk_ie_compatibility_media() {
        global $mk_options;
        
        echo "\n";
        echo '<!--[if lt IE 9]>';
        echo '<script src="<?php echo THEME_JS;?>/html5shiv.js" type="text/javascript"></script>' . "\n";
        echo '<link rel="stylesheet" href="' . THEME_STYLES . '/stylesheet/css/ie.css" />' . "\n";
        echo '<![endif]-->' . "\n";
        echo '<!--[if IE 9]>' . "\n";
        echo '<script src="' . THEME_JS . '/ie/placeholder.js" type="text/javascript"></script>' . "\n";
        echo '<![endif]-->' . "\n";
    }
    add_action('wp_head', 'mk_ie_compatibility_media', 3);
}

/**
 * outputs custom fav icons and apple touch icons into head tag
 */
if (!function_exists('mk_dynamic_js_vars')) {
    function mk_dynamic_js_vars() {
        global $mk_options;
        
        $post_id = global_get_post_id();
        
        echo '<script type="text/javascript">' . "\n";
        echo 'var abb = {};' . "\n";
        echo 'var php = {};' . "\n";
        
        echo 'var mk_header_parallax, mk_banner_parallax, mk_page_parallax, mk_footer_parallax, mk_body_parallax;' . "\n";
        
        echo 'var mk_images_dir = "' . THEME_IMAGES . '",' . "\n";
        echo 'mk_theme_js_path = "' . THEME_JS . '",' . "\n";
        echo 'mk_theme_dir = "' . THEME_DIR_URI . '",' . "\n";
        echo 'mk_captcha_placeholder = "' . __('Enter Captcha', 'mk_framework') . '",' . "\n";
        echo 'mk_captcha_invalid_txt = "' . __('Invalid. Try again.', 'mk_framework') . '",' . "\n";
        echo 'mk_captcha_correct_txt = "' . __('Captcha correct.', 'mk_framework') . '",' . "\n";
        echo 'mk_responsive_nav_width = ' . $mk_options['responsive_nav_width'] . ',' . "\n";
        
        echo 'mk_check_rtl = ' . ((is_rtl()) ? "false" : "true") . ',' . "\n";
        
        echo 'mk_grid_width = ' . $mk_options['grid_width'] . ',' . "\n";
        echo 'mk_ajax_search_option = "' . $mk_options['header_search_location'] . '",' . "\n";
        echo 'mk_preloader_txt_color = "' . (($mk_options['preloader_txt_color']) ? $mk_options['preloader_txt_color'] : '#444') . '",' . "\n";
        echo 'mk_preloader_bg_color = "' . (($mk_options['preloader_bg_color']) ? $mk_options['preloader_bg_color'] : '#fff') . '",' . "\n";
        echo 'mk_accent_color = "' . $mk_options['skin_color'] . '",' . "\n";
        echo 'mk_go_to_top =  "' . (($mk_options['go_to_top']) ? $mk_options['go_to_top'] : 'false' ) . '",' . "\n";
        
        $mk_preloader_bar_color = (isset($mk_options['preloader_bar_color']) && !empty($mk_options['preloader_bar_color'])) ? $mk_options['preloader_bar_color'] : $mk_options['skin_color'];

        echo 'mk_preloader_bar_color = "' . $mk_preloader_bar_color . '",' . "\n";
        
        echo 'mk_preloader_logo = "' . $mk_options['preloader_logo'] . '";' . "\n";
        if ($post_id):
            echo 'var mk_header_parallax = ' . (get_post_meta($post_id, 'header_parallax', true) ? get_post_meta($post_id, 'header_parallax', true) : "false") . ',' . "\n";
            echo 'mk_banner_parallax = ' . (get_post_meta($post_id, 'banner_parallax', true) ? get_post_meta($post_id, 'banner_parallax', true) : "false") . ',' . "\n";
            echo 'mk_page_parallax = ' . (get_post_meta($post_id, 'page_parallax', true) ? get_post_meta($post_id, 'page_parallax', true) : "false") . ',' . "\n";
            echo 'mk_footer_parallax = ' . (get_post_meta($post_id, 'footer_parallax', true) ? get_post_meta($post_id, 'footer_parallax', true) : "false") . ',' . "\n";
            echo 'mk_body_parallax = ' . (get_post_meta($post_id, 'body_parallax', true) ? get_post_meta($post_id, 'body_parallax', true) : "false") . ',' . "\n";
            echo 'mk_no_more_posts = "' . __('No More Posts', 'mk_framework') . '";' . "\n";
        endif;
        
        echo 'function is_touch_device() {
              return ("ontouchstart" in document.documentElement);
          }' . "\n";
        
        echo '</script>' . "\n";
    }
    add_action('wp_head', 'mk_dynamic_js_vars', 3);
}

/*
Adds debugging information to front-end
*/
if (!function_exists('mk_theme_debugging_info')) {
    function mk_theme_debugging_info() {
        $theme_data = wp_get_theme();
        echo '<meta name="generator" content="' . wp_get_theme() . ' ' . $theme_data['Version'] . '" />' . "\n";
    }
    add_action('wp_head', 'mk_theme_debugging_info', 999);
}

