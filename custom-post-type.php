<?php
/*
Plugin Name: Custom post type
Description: Ejemplo para añadir un tipo de post personalizado.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// add custom post type
function myplugin_add_custom_post_type() {

	/*
		For a list of $args, check out:
		https://developer.wordpress.org/reference/functions/register_post_type/

	*/

	$args = array(
		'labels'             => array( 'name' => 'Peliculas' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'peliculas' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

	register_post_type( 'peliculas', $args );

}
add_action( 'init', 'myplugin_add_custom_post_type' );


