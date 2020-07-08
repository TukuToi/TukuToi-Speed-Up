<?php
    
//Deregister and dequeue scripts
add_action( 'wp_print_scripts', 'tkt_cleanup_scripts', PHP_INT_MAX );

function tkt_cleanup_scripts() {
	
	global $post;
	
	$options = get_option( 'tkt_prf_options' );
	$scripts_to_remove_array = explode(',', $options["tkt_prf_script_handles_to_remove"]);
	
	$posts_to_exclude_array = explode(',', $options['tkt_prf_single_objects_to_exclude']);
	//if ( is_object($post) && has_block('toolset-blocks/gallery', $post->ID) === false) {

	if (is_object($post) && in_array($post->ID, $posts_to_exclude_array) === true ) {

		$scripts_to_exclude_array = array('toolset-common-es-masonry','views-blocks-frontend','views-pagination-script');
		$scripts_to_remove_array = array_diff($scripts_to_remove_array, $scripts_to_exclude_array); 

	}
	
	$archives_to_exclude_array = explode(',', $options["tkt_prf_archives_to_exclude"]);
	
	if ( is_post_type_archive($archives_to_exclude_array) === true  ) {
		$scripts_to_exclude_array = array('toolset-common-es-masonry','views-blocks-frontend','views-pagination-script');
		$scripts_to_remove_array = array_diff($scripts_to_remove_array, $scripts_to_exclude_array); 
	}

    
 	foreach( $scripts_to_remove_array as $script ) {
		wp_dequeue_script( $script );
		wp_deregister_script( $script );
	}
    
}


//Deregister and dequeue styles
add_action( 'wp_print_styles', 'tkt_cleanup_styles', PHP_INT_MAX );

function tkt_cleanup_styles() {
	$options = get_option( 'tkt_prf_options' );
	$styles_to_remove_array = explode(',', $options["tkt_prf_style_handles_to_remove"]);
	
    if ( !is_admin() ) {
 		foreach( $styles_to_remove_array as $style ) {
	        wp_dequeue_style( $style );
			wp_deregister_style( $style );
		}
    }
}

/**
 * Disable the emoji's
 */
add_action( 'init', 'disable_emojis' );

function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
}

/**
 * Filter function used to remove the tinymce emoji plugin.
 * 
 * @param    array  $plugins  
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	}

	return array();
}

/**
 * Remove emoji CDN hostname from DNS prefetching hints.
 *
 * @param  array  $urls          URLs to print for resource hints.
 * @param  string $relation_type The relation type the URLs are printed for.
 * @return array                 Difference betwen the two arrays.
 */
function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {

	if ( 'dns-prefetch' == $relation_type ) {

		// Strip out any URLs referencing the WordPress.org emoji location
		$emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
		foreach ( $urls as $key => $url ) {
			if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
				unset( $urls[$key] );
			}
		}

	}

	return $urls;
}

//If option "script logging" is checked, log styles and scripts to header as HTML comments

$options = get_option( 'tkt_prf_options');
if (isset($options['tkt_prf_script_styles_log'])){
	add_action( 'wp_head', 'tkt_print_script_styles_head',999);
}

function tkt_prf_log_scripts_styles() {

    $result = [];
    $result['scripts'] = [];
    $result['styles'] = [];

    // Print all loaded Scripts
    global $wp_scripts;

    foreach( $wp_scripts->queue as $script ) :
       $result['scripts'][] =  $script . ",";
    endforeach;

    // Print all loaded Styles (CSS)
    global $wp_styles;

    foreach( $wp_styles->queue as $style ) :
       $result['styles'][] =  $style . ",";
    endforeach;


    return $result;
}

function tkt_print_script_styles_head() {
	foreach (tkt_prf_log_scripts_styles()['scripts'] as $script) {
		echo $script;
	}
	foreach (tkt_prf_log_scripts_styles()['styles'] as $style) {
		echo $style;
	}
}
