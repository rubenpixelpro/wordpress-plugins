<?php
/*
Plugin Name: Database ejemplos
Description: Consultas a la base de datos de Wordpress.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// Example 1: select a variable
function database_examples_get_user_count() {

	global $wpdb;

	$query = "SELECT COUNT( * ) FROM $wpdb->users";

	$results = $wpdb->get_var( $query );


	// display the results

	if ( null !== $results ) {

		echo '<div>Número de usuarios: '. $results .'</div>';

	} else {

		echo '<div>No hay resultados.</div>';

	}

}



// Example 2: select a variable
function database_examples_sum_custom_fields() {

	global $wpdb;

	$meta_key = 'minutos';

	$query = "SELECT sum( meta_value ) FROM $wpdb->postmeta WHERE meta_key = %s";

	$prepared_query = $wpdb->prepare( $query, $meta_key );

	$results = $wpdb->get_var( $prepared_query );


	// display the results

	if ( null !== $results ) {

		echo '<div>Minutos totales: '. $results .'</div>';

	} else {

		echo '<div>No hay resultados.</div>';

	}

}



// Example 3: select a row
function database_examples_get_primary_admin() {

	global $wpdb;

	$user_id = 1;

	$query = "SELECT * FROM $wpdb->users WHERE ID = %d";

	$prepared_query = $wpdb->prepare( $query, $user_id );

	$user = $wpdb->get_row( $prepared_query );

	// display the results
	if ( null !== $user ) {

		echo '<div>Usuario administrador:</div>';
		echo '<pre>';
		var_dump( $user );
		echo '</pre>';

		echo '<div>ID: '. $user->ID .'</div>';
		echo '<div>Login: '. $user->user_login .'</div>';
		echo '<div>Email: '. $user->user_email .'</div>';

	} else {

		echo '<div>No hay resultados.</div>';

	}
}


// Example 4: select a column
function database_examples_get_all_user_ids() {

	global $wpdb;

	$query = "SELECT ID FROM $wpdb->users";

	$results = $wpdb->get_col( $query );


	// display the results

	if ( null !== $results ) {

		echo '<div>IDs de todos los usuarios:</div>';
		echo '<pre>';
		var_dump( $results );
		echo '</pre>';

	} else {

		echo '<div>No hay resultados.</div>';

	}

}



// Example 5: select generic results
function database_examples_get_draft_posts() {

	global $wpdb;
	$post_author = 1;
	$query = "SELECT ID, post_title
				FROM $wpdb->posts
				WHERE post_status = 'draft'
				AND post_type = 'post'
				AND post_author = %s";

	$prepared_query = $wpdb->prepare( $query, $post_author );
	$draft_posts = $wpdb->get_results( $prepared_query );

	// display the results
	if ( null !== $draft_posts ) {
		echo '<div>Borradores:</div>';
		echo '<pre>';
		var_dump( $draft_posts );
		echo '</pre>';
		echo '<p>Títulos de borradores:</p>';

		foreach ( $draft_posts as $draft_post) {
			echo '<div>'. $draft_post->post_title .'</div>';
		}
	} else {
		echo '<div>No hay resultados.</div>';
	}
}



// Example 6: running general queries
function database_examples_add_custom_field() {

	global $wpdb;

	$post_id = 1;

	$meta_key = 'color-favorito';

	$meta_value = 'Azul';

	$query = "INSERT INTO $wpdb->postmeta( post_id, meta_key, meta_value )
						VALUES ( %d, %s, %s )";

	$prepared_query = $wpdb->prepare( $query, $post_id, $meta_key, $meta_value );

	$result = $wpdb->query( $prepared_query );


	// display the results

	echo '<div>Añadir custom field: ';

	if ( false === $result ) echo 'Se produjo un error.';

	elseif ( 0 === $result ) echo 'No hay resultados.';

	else echo 'Custom field añadido.';

	echo '</div>';

}










/*
	
	Ignore code below this line..
	It's used to create the plugin page
	
	
*/

// add top-level administrative menu
function database_examples_add_toplevel_menu() {

	add_menu_page(
		esc_html__('Database Ejemplos', 'myplugin'),
		esc_html__('Database Ejemplos', 'myplugin'),
		'manage_options',
		'database_examples',
		'database_examples_display_settings_page',
		'dashicons-admin-generic',
		null
	);

}
add_action( 'admin_menu', 'database_examples_add_toplevel_menu' );



// display the plugin settings page
function database_examples_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">

		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<p><?php esc_html_e( 'Consultas a la base de datos de Wordpress.', 'myplugin' ); ?></p>

		<h2><?php esc_html_e( 'Seleccionar una variable', 'myplugin' ); ?></h2>
		<?php database_examples_get_user_count(); ?>
		<?php database_examples_sum_custom_fields(); ?>

		<h2><?php esc_html_e( 'Seleccionar una fila', 'myplugin' ); ?></h2>
		<?php database_examples_get_primary_admin(); ?>

		<h2><?php esc_html_e( 'Seleccionar una columna', 'myplugin' ); ?></h2>
		<?php database_examples_get_all_user_ids(); ?>

		<h2><?php esc_html_e( 'Seleccionar resultados genéricos', 'myplugin' ); ?></h2>
		<?php database_examples_get_draft_posts(); ?>

		<h2><?php esc_html_e( 'Ejecutar consultas en general', 'myplugin' ); ?></h2>
		<?php database_examples_add_custom_field(); ?>
		
	</div>

<?php

}


