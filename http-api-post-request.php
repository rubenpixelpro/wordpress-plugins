<?php
/*
Plugin Name: HTTP API: POST Request
Description: Ejemplo para hacer una petición POST.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// example: POST request
function http_post_request( $url ) {

	$url = esc_url_raw( $url );

	$body = array(
		'name'    => 'Pat Smith',
		'email'   => 'user@example.com',
		'subject' => 'Message from Contact Form',
		'comment' => 'Hello, it is nice to meet you.'
	);

	$args = array( 'body' => $body, );

	return wp_safe_remote_post( $url, $args );

}



// example: POST response
function http_post_response() {
	$url = 'http://httpbin.org/post';
	$response = http_post_request( $url );

	$code    = wp_remote_retrieve_response_code( $response );
	$message = wp_remote_retrieve_response_message( $response );
	$body    = wp_remote_retrieve_body( $response );
	$headers = wp_remote_retrieve_headers( $response );

	$header_date   = wp_remote_retrieve_header( $response, 'date' );
	$header_type   = wp_remote_retrieve_header( $response, 'content-type' );
	$header_server = wp_remote_retrieve_header( $response, 'server' );

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
	$output .= '<div>Response Date: ' . $header_date   .'</div>';
	$output .= '<div>Content Type: '  . $header_type   .'</div>';
	$output .= '<div>Server: '        . $header_server .'</div>';
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
function http_post_add_toplevel_menu() {

	add_menu_page(
		'HTTP API: POST Request',
		'HTTP API: POST',
		'manage_options',
		'http_post',
		'http_post_display_settings_page',
		'dashicons-admin-generic',
		null
	);

}
add_action( 'admin_menu', 'http_post_add_toplevel_menu' );



// display the plugin settings page
function http_post_display_settings_page() {

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

		<?php echo http_post_response(); ?>

	</div>

<?php

}


