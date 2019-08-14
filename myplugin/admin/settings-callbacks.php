<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}



// callback: text field
function myplugin_callback_field_text( $args ) {

	echo 'Esto será un campo de texto.';

}

// callback: radio field
function myplugin_callback_field_radio( $args ) {

	echo 'Esto será un radio button.';

}

// callback: textarea field
function myplugin_callback_field_textarea( $args ) {

	echo 'Esto será un textarea.';

}

// callback: checkbox field
function myplugin_callback_field_checkbox( $args ) {

	echo 'Esto será un checkbox.';

}

// callback: select field
function myplugin_callback_field_select( $args ) {

	echo 'Esto será un select.';

}


function myplugin_callback_validate_options( $input ) {

	return $input;

}

function myplugin_callback_section_login() {

	echo '<p>Ajustes para personalizar el login de WP.</p>';

}

function myplugin_callback_section_admin() {

	echo '<p>Ajustes para personalizar el área de administración.</p>';

}
