<?php
/*
Plugin Name: Estructura Widget
Description: Estructura básica de un Widget.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/


// example widget class
class My_Widget extends WP_Widget {

	// set up widget
	public function __construct() {
		
		$options = array( 
			'classname' => 'my_widget',
			'description' => 'My Widget is awesome',
		);
		
		parent::__construct( 'my_widget', 'My Widget', $options );
		
	}
	
	// output widget content
	public function widget( $args, $instance ) {
		
		// outputs the content of the widget
		
	}
	
	// output widget form fields
	public function form( $instance ) {
		
		// outputs the widget form fields in the Admin Area
		
	}
	
	// process widget options
	public function update( $new_instance, $old_instance ) {
		
		// processes the widget options
		
	}
	
}

// register widget
function myplugin_register_widget() {
	
	register_widget( 'My_Widget' );
	
}
add_action( 'widgets_init', 'myplugin_register_widget' );


