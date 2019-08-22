<?php
/*
Plugin Name: Usuarios: Mostrar roles
Description: Ejemplo para mostrar los roles de usuario.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later

*/



// add top-level administrative menu
function get_roles_add_toplevel_menu() {
	
	add_menu_page(
		esc_html__('Usuarios y roles: mostrar roles', 'myplugin'),
		esc_html__('Mostrar roles', 'myplugin'),
		'manage_options',
		'get_roles',
		'get_roles_display_settings_page',
		'dashicons-admin-generic',
		null
	);
	
}
add_action( 'admin_menu', 'get_roles_add_toplevel_menu' );



// display the plugin settings page
function get_roles_display_settings_page() {
	
	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;
	
	?>
	
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p><?php esc_html_e( 'Este plugin muestra los roles y competencias de los usuarios.', 'myplugin' ); ?></p>
		
		<?php get_roles_display_results(); ?>
		
	</div>
	
<?php

}



// get all roles
function get_roles_get_roles() {
	
	global $wp_roles;
	
	return $wp_roles->roles;
	
}



// display results
function get_roles_display_results() {
	
	$roles = get_roles_get_roles(); 
	
	$roles = array_reverse( $roles );
	
	foreach ( $roles as $key => $value ) {
		
		if ( isset( $value['capabilities'] ) ) {
			
			echo '<h3>'. esc_html__( 'Competencias para ', 'myplugin' ) . $key .'</h3>';
			
			echo '<pre>';
			
			foreach ( $value['capabilities'] as $k => $v ) {
				
				if ( $v == 1 ) echo $k . "\n";
				
			}
			
			echo '</pre>';
			
		}
		
	}
	
}


