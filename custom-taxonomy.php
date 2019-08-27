<?php
/*
Plugin Name: Custom Taxonomy
Description: Ejemplo para añadir una taxonomía.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// add custom taxonomy
function myplugin_add_custom_taxonomy() {

	/*
		For a list of $args, check out:
		https://developer.wordpress.org/reference/functions/register_taxonomy/

	*/

	$args = array(
		'labels'            => array( 'name' => 'Arte' ),
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
	);

	register_taxonomy( 'arte', 'post', $args );

}
add_action( 'init', 'myplugin_add_custom_taxonomy' );


