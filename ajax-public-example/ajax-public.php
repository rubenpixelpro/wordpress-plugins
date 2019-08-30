<?php
/*
Plugin Name: Ajax: Public
Description: Ejemplo para usar Ajax en las páginas públicas.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// enqueue scripts
function ajax_public_enqueue_scripts( $hook ) {

	// define script url
	$script_url = plugins_url( '/ajax-public.js', __FILE__ );

	// enqueue script
	wp_enqueue_script( 'ajax-public', $script_url, array( 'jquery' ) );

	// create nonce
	$nonce = wp_create_nonce( 'ajax_public' );

	// define ajax url
	$ajax_url = admin_url( 'admin-ajax.php' );

	// define script
	$script = array( 'nonce' => $nonce, 'ajaxurl' => $ajax_url );

	// localize script
	wp_localize_script( 'ajax-public', 'ajax_public', $script );

}
add_action( 'wp_enqueue_scripts', 'ajax_public_enqueue_scripts' );









// process ajax request
function ajax_public_handler() {

	// check nonce
	check_ajax_referer( 'ajax_public', 'nonce' );

	// define author id
	$author_id = isset( $_POST['author_id'] ) ? $_POST['author_id'] : false;

	// define user description
	$description = get_user_meta( $author_id, 'description', true );

	// output results
	echo esc_html( $description );

	// end processing
	wp_die();

}
// ajax hook for logged-in users: wp_ajax_{action}
add_action( 'wp_ajax_public_hook', 'ajax_public_handler' );

// ajax hook for non-logged-in users: wp_ajax_nopriv_{action}
add_action( 'wp_ajax_nopriv_public_hook', 'ajax_public_handler' );










// display markup
function ajax_public_display_markup( $content ) {

	if ( ! is_single() ) return $content;

	$id = get_the_author_meta( 'ID' );

	$url = get_author_posts_url( $id );

	$markup  = '<p class="ajax-learn-more">';

	$markup .= '<a href="'. $url .'" data-id="'. $id .'">';

	$markup .= 'Sobre el autor...</a></p>';

	$markup .= '<div class="ajax-response"></div>';

	return $content . $markup;

}
add_action( 'the_content', 'ajax_public_display_markup' );


