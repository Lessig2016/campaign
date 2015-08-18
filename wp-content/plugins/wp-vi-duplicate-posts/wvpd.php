<?php
/*
* Plugin Name: WP VI Post Duplicator
* Plugin URI: http://www.vivacityinfotech.net
* Description: "WP VI Post Duplicator" plugin for copy a post/page or custom post. You can also copy post to another custom post type..
* Version: 1.0
* Author: Vivacity Infotech Pvt. Ltd.
* Author URI: http://www.vivacityinfotech.net
* Domain Path: /languages/
* Text Domain: wvpd
*/
/*
Copyright 2014  Vivacity InfoTech Pvt. Ltd.  (email : support@vivacityinfotech.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Multi Language Support */
 add_action('init', 'load_wvpd_trans');
 function load_wvpd_trans()
   {
       load_plugin_textdomain('wvpd', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
   }

define('CURRENT_VERSION_OF_WVPD', '1.0' );

add_filter("plugin_action_links_".plugin_basename(__FILE__), "wvpd_plugin_actions", 10, 4);

function wvpd_plugin_actions( $actions, $plugin_file, $plugin_data, $context ) {
	array_unshift($actions, "<a href=\"".menu_page_url('wvpd', false)."\">".__("Settings" , "wvpd")."</a>");
	return $actions;
}

require_once (dirname(__FILE__).'/wvpd-common.php');

if (is_admin()){
	require_once (dirname(__FILE__).'/wvpd-admin.php');
}
?>