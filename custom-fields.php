<?php
/*
Plugin Name: Custom Fields
Description: Ejemplo para trabajar con custom fields.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// add custom field for each post
function myplugin_add_custom_field( $content ) {

	$calendar = cal_to_jd( CAL_GREGORIAN, date( 'm' ), date( 'd' ), date( 'Y' ) );
	$weekday = jddayofweek( $calendar, 1 );

	return add_post_meta( get_the_ID(), 'dia', $weekday, true );

}
//add_filter( 'the_content', 'myplugin_add_custom_field' );


// update custom field for each post
function myplugin_update_custom_field( $content ) {

	return update_post_meta( get_the_ID(), 'estado', 'muy feliz', 'feliz' );

}
//add_filter( 'the_content', 'myplugin_update_custom_field' );




// delete custom field for each post
function myplugin_delete_custom_field( $content ) {

	return delete_post_meta( get_the_ID(), 'dia' );

}
add_filter( 'the_content', 'myplugin_delete_custom_field' );


// display all custom fields for each post
function myplugin_display_all_custom_fields( $content ) {

	$custom_fields = '<h3>Custom Fields</h3>';

	$all_custom_fields = get_post_custom();

	foreach ( $all_custom_fields as $key => $array ) {

		foreach ( $array as $value ) {

			 if ( '_' !== substr( $key, 0, 1 ) )

			$custom_fields .= '<div>'. $key .' => '. $value .'</div>';

		}

	}

	return $content . $custom_fields;

}
add_filter( 'the_content', 'myplugin_display_all_custom_fields' );


// display specific custom field for each post
function myplugin_display_specific_custom_field( $content ) {

	$current_mood = get_post_meta( get_the_ID(), 'estado', true );

	$append_output  = '<div>';
	$append_output .= esc_html__( 'Estoy ' );
	$append_output .= sanitize_text_field( $current_mood );
	$append_output .= '</div>';

	return $content . $append_output;

}
//add_filter( 'the_content', 'myplugin_display_specific_custom_field' );

