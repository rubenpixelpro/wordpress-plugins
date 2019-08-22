<?php
/*
Plugin Name: Usuarios: current_user_can()
Description: Ejemplo para comprobar competencias.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
Plugin Name: Users and Roles: No Restrictions
Description: Example demonstrating how to manage users and roles.
Plugin URI:  https://plugin-planet.com/
Author:      Jeff Starr
Version:     1.0
*/



// generate delete link
function no_restrictions_get_delete_link( $content ) {
	
	/* 
		Here is the point of this demo: 
		current_user_can() checks the user for proper capabilities.
		Without this check, any user could delete posts.
	*/
	if ( ! current_user_can( 'edit_others_posts' ) ) return;
	
	
	
	/*
		This code adds a "Delete Post" link to the post content.
	*/
	if ( is_single() && in_the_loop() && is_main_query() ) {

		$url = add_query_arg( array( 'action' => 'wporg_frontend_delete', 'post' => get_the_ID() ), home_url() );

		return $content .' <a href="'. esc_url( $url ) .'">'. esc_html__( 'Borrar Post', 'wporg' ) . '</a>';

	}

	return null;

}
add_filter( 'the_content', 'no_restrictions_get_delete_link' );



// handle the request
function no_restrictions_maybe_delete_post() {
	
	/* 
		This is the key to this demo: 
		current_user_can() checks the user for proper capabilities.
		Without this check, any user could delete posts.
	*/
	if ( ! current_user_can( 'edit_others_posts' ) ) return;
	
	
	
	/*
		This code handles the request and deletes the specified post.
	*/
	if ( isset( $_GET['action'] ) && $_GET['action'] === 'wporg_frontend_delete' ) {

		$post_id = ( isset( $_GET['post'] ) ) ? ( $_GET['post'] ) : ( null );

		$post = get_post( ( int ) $post_id );

		if ( empty( $post ) ) return;

		wp_trash_post( $post_id );

		$redirect = admin_url( 'edit.php' );

		wp_safe_redirect( $redirect );

		die;

	}

}
add_action( 'init', 'no_restrictions_maybe_delete_post' );


