<?php
/*

Plugin Name: HTTP API: GET Request
Description: Ejemplo para hacer una petición GET.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// example: GET request
function http_get_request( $url ) {

	$url = esc_url_raw( $url );

	$args = array( 'user-agent' => 'Plugin Demo: HTTP API; '. home_url() );

	return wp_safe_remote_get( $url, $args );

}



// example: GET response
function http_get_response() {
	$url = 'https://api.github.com/';
	$response = http_get_request( $url );

	$code    = wp_remote_retrieve_response_code( $response );
	$message = wp_remote_retrieve_response_message( $response );
	$body    = wp_remote_retrieve_body( $response );
	$headers = wp_remote_retrieve_headers( $response );

	$header_date  = wp_remote_retrieve_header( $response, 'date' );
	$header_type  = wp_remote_retrieve_header( $response, 'content-type' );
	$header_cache = wp_remote_retrieve_header( $response, 'cache-control' );

	$output  = '<h2><code>'. $url .'</code></h2>';
	$output .= '<h3>Status</h3>';
	$output .= '<div>Response Code: '    . $code    .'</div>';
	$output .= '<div>Response Message: ' . $message .'</div>';
	$output .= '<h3>Body</h3>';
	$output .= '<pre>';
	ob_start();
	var_dump( $body );
	$output .= ob_get_clean();
	$output .= '</pre>';
	$output .= '<h3>Headers</h3>';
	$output .= '<div>Response Date: ' . $header_date  .'</div>';
	$output .= '<div>Content Type: '  . $header_type  .'</div>';
	$output .= '<div>Cache Control: ' . $header_cache .'</div>';
	$output .= '<pre>';
	ob_start();
	var_dump( $headers );
	$output .= ob_get_clean();
	$output .= '</pre>';

	return $output;

}






/*

	Ignore code below this line..
	It's used to create the plugin page
	
*/

// add top-level administrative menu
function http_get_add_toplevel_menu() {

	add_menu_page(
		'HTTP API: GET Request',
		'HTTP API: GET',
		'manage_options',
		'http_get',
		'http_get_display_settings_page',
		'dashicons-admin-generic',
		null
	);

}
add_action( 'admin_menu', 'http_get_add_toplevel_menu' );



// display the plugin settings page
function http_get_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<style>
		pre {
			width: 95%; overflow: auto; margin: 20px 0; padding: 20px;
			color: #fff; background-color: #424242;
		}
	</style>

	<div class="wrap">

		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<?php echo http_get_response(); ?>

	</div>

<?php

}



