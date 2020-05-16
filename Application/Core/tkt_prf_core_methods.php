<?php
    

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
add_action( 'wp_print_scripts', 'tkt_cleanup_scripts', PHP_INT_MAX );
 
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
add_action( 'wp_print_styles', 'tkt_cleanup_styles', PHP_INT_MAX );
