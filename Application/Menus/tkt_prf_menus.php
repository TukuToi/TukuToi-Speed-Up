<?php



//Callback fo adding main menu page
function tkt_prf_add_main_menu() {

	$page = add_menu_page( 'TukuToi Performance', 'TukuToi Performance', 'manage_options', 'tktprf-performance', 'tkt_prf_main_menu_page', TKT_ADMIN_MENU_ICON);
	add_action( "admin_print_styles-{$page}", 'tkt_prf_enqueue_styles' );
	
	// 	add_action('load-'.$page, 'ytqb_admin_active_add_help_tab');
}

// function yqb_sub_menu_page() {
// 	require_once( plugin_dir_path( __FILE__ ) . 'feedback_required_table.php');
// 	require_once( dirname( __DIR__ , 2 ). '/Application/Core Engine/yqb_query_engine.php');
// 	yqb_render_feedback_required_query_results();
// }

/**
 * top level menu:
 * callback functions
 */
function tkt_prf_main_menu_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
 		return;
 	}
 	else{

			// add error/update messages
		 	// check if the user have submitted the settings
		 	// wordpress will add the "settings-updated" $_GET parameter to the url
		 	if ( isset( $_GET['settings-updated'] ) ) {
		 		// add settings saved message with the class of "updated"
		 		add_settings_error( 'tkt_prf_messages', 'tkt_prf_message', __( 'Settings Saved', 'tktprf' ), 'updated' );
		 	}
		 
		 	// show error/update messages
		 	
		 	?>

			<div class="wrap">
				<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
				<hr>
				<div>
					<h2>Settings</h2>
					<div class="main-dashboard-inner">
						<form action="options.php" method="post">
				 			<?php
						 	// output security fields for the registered setting "wporg"
						 	settings_fields( 'tktprf' );
						 	// output setting sections and their fields
						 	// (sections are registered for "wporg", each field is registered to a specific section)
						 	do_settings_sections( 'tktprf' );
						 	// output save settings button
						 	submit_button( 'Save Settings' );
					 		?>
			 			</form>
			 		</div>
				</div>
				<hr>
				<div>
					<h2>Feedback?</h2>
					<div class="main-dashboard-inner">
						<p>Please email to <a href="mailto:s.mail.beda@gmail.com">Beda Schmid</a></p>
					</div>
				</div>
			</div>
		 	
		 	
		 	<?php
	}
}
