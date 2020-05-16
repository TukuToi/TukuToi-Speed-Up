<?php
/**
 * Plugin Name: TukuToi Performance
 * Description: Optimize any WordPress Website
 * Plugin URI: http://tukutoi.com
 * Author: TukuToi
 * Author URI: http://tukutoi.com
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: tkt-performance
 */

//Security check
if ( ! defined( 'ABSPATH' ) ) exit; 

define('TKT_PRF_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
define('TKT_PRF_FOLDER', 'TukuToi-Performance');
define('TKT_ADMIN_MENU_ICON', 'data:image/svg+xml;base64,'. base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1008.52 835.08"><path fill="black" d="M1800.48,797.83Q1685.31,683,1570.31,568.06c-9.69-9.69-19-19.79-27.89-30.26C1385.26,352,1100.6,339.05,928.62,511.43c-94.12,94.34-134.82,209.23-121.35,342,9.92,97.68,50.77,181.69,120.65,250.32,87.31,85.75,193.25,126.3,315.91,120.67,102.35-4.69,191.18-42.88,265.63-112.87,26.71-25.1,50.16-53.61,76-79.65q107.16-107.84,215.16-214.84c2.86-2.84,6.6-4.81,12.63-9.1C1806.87,802.93,1803.36,800.7,1800.48,797.83ZM1165.29,1052.3c-113.09-27.12-191.44-125.58-193.76-242.73-2.21-111.42,77.09-214.53,187.27-243.2,112-29.15,218.38,22.64,268.84,99.6l-142.16,141.7,142.86,142.19C1381.17,1024.15,1276.15,1078.88,1165.29,1052.3Zm381.14-171.21c-40.56.18-74.45-33.65-74.41-74.3a74.38,74.38,0,0,1,74.43-74.07c40.86.09,74.06,33.66,73.83,74.64C1620.05,847.6,1586.68,880.91,1546.43,881.09Z" transform="translate(-804.76 -389.88)"/><path d="M1540.45,772.44c-18.93.47-34.43,16.22-34.47,35a35.14,35.14,0,0,0,35.41,35,35,35,0,1,0-.94-70.06Z" transform="translate(-804.76 -389.88)"/></svg>'));


//Require core methods
if ( !is_admin() ) 
	require_once( plugin_dir_path( __FILE__ ) . '/Application/Core/tkt_prf_core_methods.php');

//Register srcipts for later usage
add_action( 'admin_init', 'tkt_prf_register_styles_and_scripts' );

//Add main menu
require_once( TKT_PRF_PLUGIN_DIR . '/Application/Menus/tkt_prf_menus.php');
add_action( 'admin_menu', 'tkt_prf_add_main_menu' );

//register tkt_settings_init to the admin_init action hook
add_action( 'admin_init', 'tkt_prf_settings_init' );

//Require Addon methods
require_once( plugin_dir_path( __FILE__ ) . '/Application/Addon/yqb_addon_methods.php');

//Add Submenus
//add_action( 'admin_menu', 'tkt_prf_add_sub_menu' );


function tkt_prf_register_styles_and_scripts() {
	//Main style sheet
    wp_register_style( 'yqbStyle', plugins_url( TKT_PRF_FOLDER.'/Assets/style.css' ) );
}
/**
 * Function to enque style when needed
 */
function tkt_prf_enqueue_styles() {
    wp_enqueue_style( 'yqbStyle' );
}
