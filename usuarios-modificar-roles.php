<?php
/*
Plugin Name: Usuarios: Modificar roles
Description: Ejemplo para modificar roles.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later

*/



// add top-level administrative menu
function users_roles_examples_add_toplevel_menu() {

	add_menu_page(
		esc_html__('Usuarios y roles: modificar roles', 'myplugin'),
		esc_html__('Modificar roles', 'myplugin'),
		'manage_options',
		'users_roles_examples',
		'users_roles_examples_display_settings_page',
		'dashicons-admin-generic',
		null
	);

}
add_action( 'admin_menu', 'users_roles_examples_add_toplevel_menu' );



// display the plugin settings page
function users_roles_examples_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p><?php esc_html_e( 'Este plugin muestra los roles y competencias de los usuarios.', 'myplugin' ); ?></p>

		<?php users_roles_examples_display_results(); ?>

	</div>

<?php

}



// get all roles
function users_roles_examples_get_roles() {

	global $wp_roles;

	return $wp_roles->roles;

}



// display results
function users_roles_examples_display_results() {

	$roles = users_roles_examples_get_roles();

	$roles = array_reverse( $roles );

	foreach ( $roles as $role ) {

		if ( isset( $role['name'] ) ) {

			$role_name = strtolower( $role['name'] );

			$all_caps = users_roles_examples_get_role( $role_name );

		}

		if ( $all_caps ) {

			echo '<h3>'. $role_name .' '. esc_html__( 'capabilities', 'myplugin' ) .'</h3>';

			$caps = $all_caps->capabilities;

			foreach ( $caps as $key => $value ) {

				echo '<pre>';

				if ( $value == 1 ) echo $key . "\n";

				echo '</pre>';

			}

		}

	}

}



// get user role
function users_roles_examples_get_role( $role_name ) {

	return get_role( $role_name );

}



// add user role ( see note below )
function users_roles_examples_add_role() {

	add_role(

		'reviewer',
		__( 'Reviewer' ),
		array(
			'read'         => true,
			'edit_posts'   => true,
			'upload_files' => true,

		)

	);

}
add_action( 'init', 'users_roles_examples_add_role' );



// remove user role ( see note below )
function users_roles_examples_remove_role() {

	remove_role( 'reviewer' );

}
add_action( 'init', 'users_roles_examples_remove_role' );










/*

	NOTE:

	The plugin functions myplugin_add_role() and myplugin_remove_role()
	are registered with the "init" hook, which fires on every page load.

	The WP add_role() and remove_role() functions write to the database,
	which is resource intensive.

	So it is better for performance to run myplugin_add_role() and
	myplugin_remove_role() only on plugin activation, using the hook
	"register_activation_hook".

	The function below shows an example of how to do this.

	USAGE:

		Add a role on plugin activation

			1. Remove the two slashes from myplugin_add_role()
			2. Remove the add_action() for myplugin_add_role()

		Remove a role on plugin activation

			1. Remove the two slashes from myplugin_remove_role()
			2. Remove the add_action() for myplugin_remove_role()


	More info @ https://developer.wordpress.org/reference/functions/add_role/

*/

// modify roles on plugin activation
function users_roles_examples_modify_roles_on_plugin_activation() {

	// myplugin_add_role();
	// myplugin_remove_role()

}
register_activation_hook( __FILE__, 'users_roles_examples_modify_roles_on_plugin_activation' );


