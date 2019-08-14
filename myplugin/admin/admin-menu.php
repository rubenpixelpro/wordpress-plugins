<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

function myplugin_add_toplevel_menu() {
	
	add_menu_page(
		'MyPlugin Settings',
		'MyPlugin',
		'manage_options',
		'myplugin',
		'myplugin_display_settings_page',
		'dashicons-admin-generic',
		null
	);
	
}
//add_action( 'admin_menu', 'myplugin_add_toplevel_menu' );

function myplugin_add_sublevel_menu() {
	
	add_submenu_page(
		'options-general.php',
		'MyPlugin Settings',
		'MyPlugin',
		'manage_options',
		'myplugin',
		'myplugin_display_settings_page'
	);
	
}
add_action( 'admin_menu', 'myplugin_add_sublevel_menu' );