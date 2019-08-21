<?php
/*
Plugin Name: Ejemplo pre_get_posts
Description: Personalizando el bucle de Wordpres.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later

*/



function custom_loop_pre_get_posts( $query ) {

	if ( ! is_admin() && $query->is_main_query() ) {

		$query->set( 'posts_per_page', 1 );

	}

}
add_action( 'pre_get_posts', 'custom_loop_pre_get_posts' );


