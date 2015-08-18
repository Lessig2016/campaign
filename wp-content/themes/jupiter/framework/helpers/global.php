<?php
if (!defined('THEME_FRAMEWORK')) exit('No direct script access allowed');

/**
 * Helper functions for various parts of the theme
 *
 * @author      Bob Ulusoy
 * @copyright   Artbees LTD (c)
 * @link        http://artbees.net
 * @since       Version 4.2
 * @package     artbees
 */

/**
 * Get template parts from views folder
 * @param string    $slug
 * @param string    $name
 * @return object
 *
 */
if (!function_exists('mk_get_view')) {
    function mk_get_view($slug, $name = '') {
        get_template_part('framework/views/' . $slug . '/' . $name);
    }
}

/**
 * Adds preloaders overlay div when its option is enabled
 * @return HTML
 *
 */
if (!function_exists('mk_preloader_body_overlay')) {
    function mk_preloader_body_overlay() {
        global $mk_options;
        $post_id = global_get_post_id();
        
        if ($post_id) {
            
            $single_preloader = get_post_meta($post_id, 'page_preloader', true);

        }
        $preloader_check = $single_preloader = '';
        if ($single_preloader == 'true') {
            $preloader_check = 'enabled';
        } 
        else {
            if ($mk_options['preloader'] == 'true') {
                $preloader_check = 'enabled';
            }
        }
        if ($preloader_check == 'enabled') {
            echo '<div class="mk-body-loader-overlay"><div style="background-image:url(' . THEME_IMAGES . '/empty.png)"></div></div>';
        }
    }
    
    add_action('theme_after_body_tag_start', 'mk_preloader_body_overlay');
}

/**
 * Populates classes to be added to body tag
 * @return HTML
 *
 */
if (!function_exists('mk_get_body_class')) {
    function mk_get_body_class($post_id) {
        global $mk_options;
        $body_class = array();
        
        $header_style = !empty($mk_options['theme_header_style']) ? $mk_options['theme_header_style'] : 1;
        
        if ($post_id) {
            $enable = get_post_meta($post_id, '_enable_local_backgrounds', true);
            
            if ($enable == 'true') {
                $header_style_meta = get_post_meta($post_id, 'theme_header_style', true);
                $header_style = (isset($header_style_meta) && !empty($header_style_meta)) ? $header_style_meta : $header_style;
            }
        }
        
        if (($mk_options['background_selector_orientation'] == 'boxed_layout') && !($post_id && get_post_meta($post_id, '_enable_local_backgrounds', true) == 'true' && get_post_meta($post_id, 'background_selector_orientation', true) == 'full_width_layout')) {
            
            $body_class[] = 'mk-boxed-enabled';
        } 
        else if ($post_id && get_post_meta($post_id, '_enable_local_backgrounds', true) == 'true' && get_post_meta($post_id, 'background_selector_orientation', true) == 'boxed_layout') {
            
            $body_class[] = 'mk-boxed-enabled';
        }
        
        $body_class[] = ($mk_options['body_size'] == 'true') ? 'mk-background-stretch' : '';
        
        if ($header_style == 4) {
            $vertical_header_logo_align = (isset($mk_options['vertical_header_logo_align']) && !empty($mk_options['vertical_header_logo_align'])) ? $mk_options['vertical_header_logo_align'] : 'center';        
            $header_align = !empty($mk_options['theme_header_align']) ? $mk_options['theme_header_align'] : 'left';

            if ($post_id) {
                $enable = get_post_meta($post_id, '_enable_local_backgrounds', true);
                
                if ($enable == 'true') {
                    $header_align_meta = get_post_meta($post_id, 'theme_header_align', true);
                    $header_align = (isset($header_align_meta) && !empty($header_align_meta)) ? $header_align_meta : $header_align;
                    
                }
            }

            $body_class[] = 'vertical-header-enabled vertical-header-' . $header_align . ' logo-align-' . $vertical_header_logo_align;
        }


        
        return $body_class;
    }
}
