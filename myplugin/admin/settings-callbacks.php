<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

// callback: text field
function myplugin_callback_field_text( $args ) {

	$options = get_option( 'myplugin_options', myplugin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	echo '<input id="myplugin_options_'. $id .'" name="myplugin_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="myplugin_options_'. $id .'">'. $label .'</label>';

}

// callback: radio field
function myplugin_callback_field_radio( $args ) {

	$options = get_option( 'myplugin_options', myplugin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	$radio_options = array(

		'enable'  => 'Estilos activados',
		'disable' => 'Estilos desactivados'

	);

	foreach ( $radio_options as $value => $label ) {

		$checked = checked( $selected_option === $value, true, false );

		echo '<label><input name="myplugin_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';

	}

}

// callback: textarea field
function myplugin_callback_field_textarea( $args ) {

	$options = get_option( 'myplugin_options', myplugin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$allowed_tags = wp_kses_allowed_html( 'post' );

	$value = isset( $options[$id] ) ? wp_kses( stripslashes_deep( $options[$id] ), $allowed_tags ) : '';

	echo '<textarea id="myplugin_options_'. $id .'" name="myplugin_options['. $id .']" rows="5" cols="50">'. $value .'</textarea><br />';
	echo '<label for="myplugin_options_'. $id .'">'. $label .'</label>';

}

// callback: checkbox field
function myplugin_callback_field_checkbox( $args ) {

	$options = get_option( 'myplugin_options', myplugin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$checked = isset( $options[$id] ) ? checked( $options[$id], 1, false ) : '';

	echo '<input id="myplugin_options_'. $id .'" name="myplugin_options['. $id .']" type="checkbox" value="1"'. $checked .'> ';
	echo '<label for="myplugin_options_'. $id .'">'. $label .'</label>';

}

// callback: select field
function myplugin_callback_field_select( $args ) {

	$options = get_option( 'myplugin_options', myplugin_options_default() );

	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';

	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';

	$select_options = array(

		'default'   => 'Default',
		'light'     => 'Light',
		'blue'      => 'Blue',
		'coffee'    => 'Coffee',
		'ectoplasm' => 'Ectoplasm',
		'midnight'  => 'Midnight',
		'ocean'     => 'Ocean',
		'sunrise'   => 'Sunrise',

	);

	echo '<select id="myplugin_options_'. $id .'" name="myplugin_options['. $id .']">';

	foreach ( $select_options as $value => $option ) {

		$selected = selected( $selected_option === $value, true, false );

		echo '<option value="'. $value .'"'. $selected .'>'. $option .'</option>';

	}

	echo '</select> <label for="myplugin_options_'. $id .'">'. $label .'</label>';

}


function myplugin_callback_validate_options( $input ) {

	if ( isset( $input['custom_url'] ) ) {
		
		$input['custom_url'] = esc_url( $input['custom_url'] );
		
	}

	if ( isset( $input['custom_title'] ) ) {
		
		$input['custom_title'] = sanitize_text_field( $input['custom_title'] );
		
	}

	$radio_options = array(
		'enable'  => 'Estilos activados',
		'disable' => 'Estilos desactivados'
	);
	if ( ! isset( $input['custom_style'] ) ) {
		
		$input['custom_style'] = null;
		
	}
	if ( ! array_key_exists( $input['custom_style'], $radio_options ) ) {
		
		$input['custom_style'] = null;
		
	}

	if ( isset( $input['custom_message'] ) ) {
		
		$input['custom_message'] = wp_kses_post( $input['custom_message'] );
		
	}

	if ( isset( $input['custom_footer'] ) ) {
		
		$input['custom_footer'] = sanitize_text_field( $input['custom_footer'] );
		
	}

	if ( ! isset( $input['custom_toolbar'] ) ) {
		
		$input['custom_toolbar'] = null;
		
	}
	$input['custom_toolbar'] = ($input['custom_toolbar'] == 1 ? 1 : 0);

	$select_options = array(
		'default'   => 'Default',
		'light'     => 'Light',
		'blue'      => 'Blue',
		'coffee'    => 'Coffee',
		'ectoplasm' => 'Ectoplasm',
		'midnight'  => 'Midnight',
		'ocean'     => 'Ocean',
		'sunrise'   => 'Sunrise',
	);
	if ( ! isset( $input['custom_scheme'] ) ) {
		
		$input['custom_scheme'] = null;
		
	}
	if ( ! array_key_exists( $input['custom_scheme'], $select_options ) ) {
		
		$input['custom_scheme'] = null;
	
	}

	return $input;

}

function myplugin_callback_section_login() {

	echo '<p>Ajustes para personalizar el login de WP.</p>';

}

function myplugin_callback_section_admin() {

	echo '<p>Ajustes para personalizar el área de administración.</p>';

}
