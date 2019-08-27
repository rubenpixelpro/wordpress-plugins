<?php
/*
Plugin Name: Meta boxes
Description: Ejemplo para añadir meta boxes.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// register meta box
function myplugin_add_meta_box() {

	$post_types = array( 'post', 'page' );

	foreach ( $post_types as $post_type ) {

		add_meta_box(
			'myplugin_meta_box',         // Unique ID of meta box
			'MyPlugin Meta Box',         // Title of meta box
			'myplugin_display_meta_box', // Callback function
			$post_type                   // Post type
		);

	}

}
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );



// display meta box
function myplugin_display_meta_box( $post ) {

	$value = get_post_meta( $post->ID, '_myplugin_meta_key', true );

	wp_nonce_field( basename( __FILE__ ), 'myplugin_meta_box_nonce' );

	?>

	<label for="myplugin-meta-box">Options</label>
	<select id="myplugin-meta-box" name="myplugin-meta-box">
		<option value="">Select option...</option>
		<option value="option-1" <?php selected( $value, 'option-1' ); ?>>Option 1</option>
		<option value="option-2" <?php selected( $value, 'option-2' ); ?>>Option 2</option>
		<option value="option-3" <?php selected( $value, 'option-3' ); ?>>Option 3</option>
	</select>

<?php

}



// save meta box
function myplugin_save_meta_box( $post_id ) {

	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );

	$is_valid_nonce = false;

	if ( isset( $_POST[ 'myplugin_meta_box_nonce' ] ) ) {

		if ( wp_verify_nonce( $_POST[ 'myplugin_meta_box_nonce' ], basename( __FILE__ ) ) ) {

			$is_valid_nonce = true;

		}

	}

	if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;

	if ( array_key_exists( 'myplugin-meta-box', $_POST ) ) {

		update_post_meta(
			$post_id,                                            // Post ID
			'_myplugin_meta_key',                                // Meta key
			sanitize_text_field( $_POST[ 'myplugin-meta-box' ] ) // Meta value
		);

	}

}
add_action( 'save_post', 'myplugin_save_meta_box' );


