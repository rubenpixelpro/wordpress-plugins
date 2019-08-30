<?php
/*
Plugin Name: REST API: Display Posts
Description: Ejemplo de API REST para mostrar posts.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// add top-level administrative menu
function rest_add_toplevel_menu() {

	add_menu_page(
		'REST API Example: Display Posts',
		'REST API: Display Posts',
		'manage_options',
		'rest-read-posts',
		'rest_display_settings_page',
		'dashicons-admin-generic',
		null
	);

}
add_action( 'admin_menu', 'rest_add_toplevel_menu' );



// display the plugin settings page
function rest_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">

		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p>
			<?php _e( 'Ejemplo de API REST para mostrar posts.' ); ?>
			<?php _e( 'Pulsa el botón para ver los posts.' ); ?>
		</p>

		<input id="rest-button" class="button button-primary" type="submit" value="Ver Posts">
		<div id="rest-container"></div>

	</div>

<?php

}



// enqueue scripts
function rest_enqueue_scripts( $hook ) {

	// check if our page
	if ( 'toplevel_page_rest-read-posts' !== $hook ) return;

	// define script url
	$script_url = plugins_url( '/rest-read-posts.js', __FILE__ );

	// enqueue script
	wp_enqueue_script( 'rest-read-posts', $script_url, array(), null, true );

	// add inline script
	wp_localize_script(
		'rest-read-posts',
		'rest_read_posts',
		array(
			'root'  => esc_url_raw( rest_url() )
		)
	);

}
add_action( 'admin_enqueue_scripts', 'rest_enqueue_scripts' );


