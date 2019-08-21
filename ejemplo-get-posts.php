<?php
/*
Plugin Name: Ejemplo get_posts()
Description: Personalizando el bucle de Wordpres.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later

*/



// custom loop shortcode: [get_posts_example]
function custom_loop_shortcode_get_posts( $atts ) {
	
	// get global post variable
	global $post;
	
	// define shortcode variables
	extract( shortcode_atts( array( 
		
		'posts_per_page' => 5,
		'orderby' => 'date',
		
	), $atts ) );
	
	// define get_post parameters
	$args = array( 'posts_per_page' => $posts_per_page, 'orderby' => $orderby );
	
	// get the posts
	$posts = get_posts( $args );
	
	// begin output variable
	$output  = '<h3>Ejemplo get_posts()</h3>';
	$output .= '<ul>';
	
	// loop thru posts
	foreach ( $posts as $post ) {
		
		// prepare post data
		setup_postdata( $post );
		
		// continue output variable
		$output .= '<li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li>';
		
	}
	
	// reset post data
	wp_reset_postdata();
	
	// complete output variable
	$output .= '</ul>';
	
	// return output
	return $output;
	
}
// register shortcode function
add_shortcode( 'get_posts_example', 'custom_loop_shortcode_get_posts' );


