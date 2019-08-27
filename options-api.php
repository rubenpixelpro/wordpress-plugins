<?php
/*
Plugin Name: Options API
Description: Ejemplo para añadir, modificar y eliminar opciones.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// add option
function myplugin_add_option() {

	$option_value = 'Valor de ejemplo';

	add_option( 'myplugin-option-name', $option_value );

}
//add_action( 'admin_init', 'myplugin_add_option' );





// update option
function myplugin_update_option() {
	
	$option_value = array( 'option1' => 'val1', 'option2' => 'val2', 'option3' => 'val3' );

	update_option( 'myplugin-option-name', $option_value );

}
// add_action( 'admin_init', 'myplugin_update_option' );





// delete option
function myplugin_delete_option() {

	delete_option( 'myplugin-option-name' );

}
add_action( 'admin_init', 'myplugin_delete_option' );




