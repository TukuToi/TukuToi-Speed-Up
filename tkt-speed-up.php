<?php
/**
 * Plugin Name: TukuToi Speed Up
 * Description: Optimize any WordPress Website
 * Plugin URI: https://www.tukutoi.com
 * Author: TukuToi
 * Author URI: https://www.tukutoi.com
 * Version: 2.0.1
 * License: GPL2
 * Text Domain: tkt-speed-up
 */

//Security check
if ( ! defined( 'WPINC' ) ) {
	die;
} 

//Returns main plugin dir/url WITH trailing slash.
define('TKT_PRF_MAIN_DIR', dirname(__FILE__).'/');
define('TKT_PRF_MAIN_URL', plugin_dir_url( __FILE__ ));

//If no other TukuToi Plugin is active
if (!defined('TKT_COMMON_LOADED'))
	require_once(TKT_PRF_MAIN_DIR.'tkt-common/tkt_common.php');

//Require core methods
if ( !is_admin() ) 
	require_once( TKT_PRF_MAIN_DIR . 'application/core/tkt_prf_core_methods.php');

//Add main menu
require_once( TKT_PRF_MAIN_DIR . 'application/admin/tkt_prf_menus.php');

//register tkt_settings_init to the admin_init action hook
require_once( TKT_PRF_MAIN_DIR . 'application/admin/tkt_prf_options.php');

//include TukuToi Update mechanism
include_once(TKT_PRF_MAIN_DIR.'update.php');