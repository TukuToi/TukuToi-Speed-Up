<?php 

//Callback fo adding sub menu pages
function tkt_prf_add_sub_menu() {
	// $sub_pages 		= array();
	// $sub_pages[] 	= add_submenu_page( 'yt-query-builder', 'Main Dashboard', 'Main Dashboard', 'manage_options', 'yt-query-builder', 'tkt_prf_main_menu_page' );
	// $sub_pages[] 	= add_submenu_page( 'yt-query-builder', 'Feedback Requested', 'Feedback Requested', 'manage_options', 'feedback-requested', 'tkt_prf_sub_menu_page' );
	// $sub_pages[] 	= add_submenu_page( 'yt-query-builder', 'Bugs', 'Bugs', 'manage_options', 'bugs', 'tkt_prf_sub_menu_page_bugs' );
	// $sub_pages[] 	= add_submenu_page( 'yt-query-builder', 'Releases', 'Releases', 'manage_options', 'releases', 'tkt_prf_sub_menu_page_releases' );
	// foreach ($sub_pages as $sub_page) {
	// 	add_action( "admin_print_styles-{$sub_page}", 'tkt_prf_enqueue_styles' );
	// 	add_action( "admin_print_scripts-{$sub_page}", 'tkt_prf_enqueue_sub_scripts' );
	// }
}

//Initiate Settings options
function tkt_prf_settings_init() {

	// register a new setting
 	register_setting( 'tktprf', 'tkt_prf_options' );
 
 	// register a new section
	add_settings_section(
		'tkt_prf_section_developers',
		'',//__( 'The Matrix has you.', 'wporg' )
		'',//wporg_section_developers_cb
		'tktprf'
	);

	//Array of options/settings
	$settings_array = array(
		"tkt_prf_style_handles_to_remove" => "All styles to remove",
	    "tkt_prf_script_handles_to_remove" => "All scripts to remove",
	    "tkt_prf_archives_to_exclude" => "Archives to exclude from optimization (Post or tax type slug)",
	    "tkt_prf_single_objects_to_exclude" => "Pages or Posts or else single objects to exclude (Numeric ID)"
	    //Add meta box by post to exclude specific scriptts or stypes onthere
	);

	//Why create as many functions as there are options? Just use foreach($settings_array) to create each settings field
	foreach ($settings_array as $option => $name) {
		add_settings_field(
			$option, // as of WP 4.6 this value is used only internally
			 // use $args' label_for to populate the id inside the callback
			__( $name, 'tktprf' ),
			$option . '_cb',
			'tktprf',
			'tkt_prf_section_developers',
			[
				'label_for' => $option,
				'class' => 'tkt_prf_row',
				'tkt_prf_custom_data' => 'custom',
			]
		);

	}

}

//Register callbacks for our options - I am sure there should be a way to NOT register EACH callback manually, something like a foreach above, however, not yet clear how to do this best.

function tkt_prf_section_developers_cb( $args ) {
	?>
 	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'tktprf' ); ?></p>
 	<?php
}

function tkt_prf_archives_to_exclude_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
 	$options = get_option( 'tkt_prf_options' );
 	// output the field
 	?><span class="description"><?php esc_html_e( 'Add comma separated Archive Types to exclude from optimization', 'tktprf' ); ?>
 		</span>
 		<input type="text" class="tkt-option-input" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['tkt_prf_custom_data'] ); ?>" name="tkt_prf_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $options["tkt_prf_archives_to_exclude"] ? $options["tkt_prf_archives_to_exclude"] : ''?>">
  	<?php
}

function tkt_prf_script_handles_to_remove_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
 	$options = get_option( 'tkt_prf_options' );
 	// output the field
 	?><span class="description"><?php esc_html_e( 'Add comma separated handles of scripts to remove', 'tktprf' ); ?>
 		</span>
 		<input type="text" class="tkt-option-input" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['tkt_prf_custom_data'] ); ?>" name="tkt_prf_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $options["tkt_prf_script_handles_to_remove"] ? $options["tkt_prf_script_handles_to_remove"] : ''?>">	
 	<?php
}

function tkt_prf_single_objects_to_exclude_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
 	$options = get_option( 'tkt_prf_options' );
 	// output the field
 	?><span class="description"><?php esc_html_e( 'Add post ID of each page, post or else single object that should be excluded from optimization', 'tktprf' ); ?>
 		</span>
 		<input type="text" class="tkt-option-input" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['tkt_prf_custom_data'] ); ?>" name="tkt_prf_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $options["tkt_prf_single_objects_to_exclude"] ? $options["tkt_prf_single_objects_to_exclude"] : ''?>">		
 	<?php	
}

function tkt_prf_style_handles_to_remove_cb( $args ) {
	// get the value of the setting we've registered with register_setting()
 	$options = get_option( 'tkt_prf_options' );
 	// output the field
 	?><span class="description"><?php esc_html_e( 'Add comma separated handles of styles to remove', 'tktprf' ); ?>
 		</span>
 		<input type="text" class="tkt-option-input" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['tkt_prf_custom_data'] ); ?>" name="tkt_prf_options[<?php echo esc_attr( $args['label_for'] ); ?>]" value="<?php echo $options["tkt_prf_style_handles_to_remove"] ? $options["tkt_prf_style_handles_to_remove"] : ''?>">
 	<?php
}

//Gather settings for usage in query engines
//possible options @see $settings_array
function tkt_all_options($option){
	$option_set = get_option( 'tkt_prf_options' )[$option];
	return $option_set;
}

//Add main menu help tab
function tkt_prf_admin_active_add_help_tab () {
    // $screen = get_current_screen();
    // // Add my_help_tab if current screen is My Admin Page
    // $screen->add_help_tab( array(
    //     'id'	=> 'yt-query-builder-menus-help-tab',
    //     'title'	=> __('Menus'),
    //     'content'	=> '<div class="main-dashboard-inner"><li><strong>YT Query Builder</strong>, or <strong>Main Dashboard</strong> can be used to alter Plugin Settings.</li>
				// 		<li><strong>Feedback Requested</strong> produces a list of all Employees who\'s feedback is requested in 6 or more YT tickets.</li>
				// 		<li><strong>Bugs</strong> produces a list of known Bugs for WPML and Toolset, and quickly see which related escalated Ticket, if resolved, would resolve the most issues, or quickly see potential Duplicates</li>
				// 		<li><strong>Custom Queries</strong> shows the Custom Queries you created using  <strong>Main Dashboard</strong></li></div>',
    // ) );
    // $screen->add_help_tab( array(
    //     'id'	=> 'yt-query-builder-slow-help-tab',
    //     'title'	=> __('Performance'),
    //     'content'	=> '<div class="main-dashboard-inner"><p>Scanning processes take time. When visiting YouTrack Query Builder Menus let the program time to finish loading. It may require several minutes.</p></div>',
    // ) );
}
