<?php
/*
Plugin Name: WP-cron ejemplo
Description: Ejemplo del uso de la API Cron para programar eventos.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// add cron intervals
function wpcron_intervals( $schedules ) {

	// one minute

	$one_minute = array(
					'interval' => 60,
					'display' => 'Un minuto'
				);

	$schedules[ 'one_minute' ] = $one_minute;

	// five minutes

	$five_minutes = array(
					'interval' => 300,
					'display' => 'Cinco minutos'
				);

	$schedules[ 'five_minutes' ] = $five_minutes;

	// return data

	return $schedules;

}
add_filter( 'cron_schedules', 'wpcron_intervals' );





// add cron event
function wpcron_activation() {

	if ( ! wp_next_scheduled( 'example_event' ) ) {

		wp_schedule_event( time(), 'one_minute', 'example_event' );

	}

}
register_activation_hook( __FILE__, 'wpcron_activation' );





// cron event
function wpcron_example_event() {

	if ( ! defined( 'DOING_CRON' ) ) return;

	$option = get_option( 'wpcron_log' );

	if ( ! empty( $option ) && is_array( $option ) ) {

		$option[] = date( 'h:i:s A' );

	} else {

		$option = array( date( 'h:i:s A' ) );

	}

	update_option( 'wpcron_log', $option );

}
add_action( 'example_event', 'wpcron_example_event' );





// remove cron event
function wpcron_deactivation() {

	wp_clear_scheduled_hook( 'example_event' );

	delete_option( 'wpcron_log' );

}
register_deactivation_hook( __FILE__, 'wpcron_deactivation' );










/*

	Ignore code below this line..
	It's used to create the plugin page
*/

// add top-level administrative menu
function wpcron_add_toplevel_menu() {

	add_menu_page(
		'WP-Cron Example',
		'Cron API',
		'manage_options',
		'wpcron-example',
		'wpcron_display_settings_page',
		'dashicons-admin-generic',
		null
	);

}
add_action( 'admin_menu', 'wpcron_add_toplevel_menu' );



// display the plugin settings page
function wpcron_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">

		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<?php echo wpcron_log(); ?>

	</div>

<?php

}



// get cron log
function wpcron_log() {

	$option = get_option( 'wpcron_log' );

	echo '<p>Cron log for <code>example_event</code></p>';

	foreach ( $option as $key => $value ) {

		echo '<p>'. $key .' : '. $value .'</p>';

	}

}


