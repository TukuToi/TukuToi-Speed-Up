<?php
/**
 * This file ensures automatic update notifications to the WordPress Update UI
 * Thanks to https://kaspars.net for the original idea
 * @link https://kaspars.net/blog/automatic-updates-for-plugins-and-themes-hosted-outside-wordpress-extend
 *
 * @since Toolwine SEO 1.5
 */


$tkt_speed_up_api_url = 'https://updates.tukutoi.com';
$tkt_speed_up_plugin_slug = 'tkt-speed-up';

function tkt_speed_up_check_for_plugin_updates($checked_data) {
	global $tkt_speed_up_api_url, $tkt_speed_up_plugin_slug, $wp_version;
	
	//Comment out these two lines during testing.
	if (empty($checked_data->checked))
		return $checked_data;
	
	$tkt_speed_up_args = array(
		'slug' => $tkt_speed_up_plugin_slug,
		'version' => $checked_data->checked[$tkt_speed_up_plugin_slug .'/'. $tkt_speed_up_plugin_slug .'.php'],
	);
	$tkt_speed_up_request_string = array(
			'body' => array(
				'action' => 'basic_check', 
				'request' => serialize($tkt_speed_up_args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	// Start checking for an update
	$tkt_speed_up_raw_response = wp_remote_post($tkt_speed_up_api_url, $tkt_speed_up_request_string);
	
	if (!is_wp_error($tkt_speed_up_raw_response) && ($tkt_speed_up_raw_response['response']['code'] == 200))
		$tkt_speed_up_response = unserialize($tkt_speed_up_raw_response['body']);
	
	if (is_object($tkt_speed_up_response) && !empty($tkt_speed_up_response)) // Feed the update data into WP updater
		$checked_data->response[$tkt_speed_up_plugin_slug .'/'. $tkt_speed_up_plugin_slug .'.php'] = $tkt_speed_up_response;
	
	return $checked_data;
}

function tkt_speed_up_plugin_api_callback($action, $args) {
	global $tkt_speed_up_plugin_slug, $tkt_speed_up_api_url, $wp_version;
	
	if (!isset($args->slug) || ($args->slug != $tkt_speed_up_plugin_slug))
		return false;
	
	// Get the current version
	$tkt_speed_up_plugin_info = get_site_transient('update_plugins');
	$tkt_speed_up_current_version = $tkt_speed_up_plugin_info->checked[$tkt_speed_up_plugin_slug .'/'. $tkt_speed_up_plugin_slug .'.php'];
	$args->version = $tkt_speed_up_current_version;
	
	$tkt_speed_up_request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	$tkt_speed_up_request = wp_remote_post($tkt_speed_up_api_url, $tkt_speed_up_request_string);
	
	if (is_wp_error($tkt_speed_up_request)) {
		$tkt_speed_up_response = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $tkt_speed_up_request->get_error_message());
	} else {
		$tkt_speed_up_response = unserialize($tkt_speed_up_request['body']);
		
		if ($tkt_speed_up_response === false)
			$tkt_speed_up_response = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $tkt_speed_up_request['body']);
	}
	
	return $tkt_speed_up_response;
}


add_filter('pre_set_site_transient_update_plugins', 'tkt_speed_up_check_for_plugin_updates');

// Take over the Plugin info screen
add_filter('plugins_api', 'tkt_speed_up_plugin_api_callback', 10, 3);
