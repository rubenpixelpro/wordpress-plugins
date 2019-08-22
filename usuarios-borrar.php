<?php
/*
Plugin Name: Usuarios: Borrar
Description: Ejemplo para borrar usuarios.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// add top-level administrative menu
function delete_user_add_toplevel_menu() {

	add_menu_page(
		esc_html__('Usuarios y roles: borrar usuario', 'myplugin'),
		esc_html__('Borrar usuario', 'myplugin'),
		'manage_options',
		'myplugin',
		'delete_user_display_settings_page',
		'dashicons-admin-generic',
		null
	);

}
add_action( 'admin_menu', 'delete_user_add_toplevel_menu' );



// display the plugin settings page
function delete_user_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post">
			<h3><?php esc_html_e( 'Borrar usuario', 'myplugin' ); ?></h3>
			<p>
				<label for="email">
					<?php esc_html_e( 'Email (required)', 'myplugin' ); ?>
				</label><br />
				<input class="regular-text" type="text" size="40" name="email" id="email">
			</p>

			<input type="hidden" name="myplugin-nonce" value="<?php echo wp_create_nonce( 'myplugin-nonce' ); ?>">
			<input type="submit" class="button button-primary" value="<?php esc_html_e( 'Borrar', 'myplugin' ); ?>">
		</form>
	</div>

<?php

}



// delete user
function delete_user_delete_user() {

	// check if nonce is valid
	if ( isset( $_POST['myplugin-nonce'] ) && wp_verify_nonce( $_POST['myplugin-nonce'], 'myplugin-nonce' ) ) {

		// check if user is allowed
		if ( ! current_user_can( 'manage_options' ) ) wp_die();

		// get user email
		if ( isset( $_POST['email'] ) && ! empty( $_POST['email'] ) ) {

			$email = sanitize_email( $_POST['email'] );

		} else {

			$email = '';

		}

		// get the user id
		$user_id = email_exists( $email );

		// user id exists
		if ( is_numeric( $user_id ) ) {

			// delete the user
			$result = wp_delete_user( $user_id );

			if ( $result ) {

				$result = __( 'El usuario ha sido borrado.', 'myplugin' );

			} else {

				$result = __( 'Error al borrar el usuario.', 'myplugin' );

			}

		} else {

			// user not found
			$result = __( 'Usuario no encontrado.', 'myplugin' );

		}

		// set the redirect url
		$location = admin_url( 'admin.php?page=myplugin&result='. urlencode( $result ) );

		// redirect
		wp_redirect( $location );

		exit;

	}

}
add_action( 'admin_init', 'delete_user_delete_user' );



// create the admin notice
function delete_user_admin_notices() {

	$screen = get_current_screen();

	if ( 'toplevel_page_myplugin' === $screen->id ) {

		if ( isset( $_GET['result'] ) ) {

			if ( strpos( $_GET['result'], 'Error' ) === false ) : ?>

				<div class="notice notice-success is-dismissible">
					<p><strong><?php esc_html_e('Usuario borrado.', 'myplugin'); ?></strong></p>
				</div>

			<?php else : ?>

				<div class="notice notice-warning is-dismissible">
					<p><strong><?php echo esc_html( $_GET['result'] ); ?></strong></p>
				</div>

			<?php endif;

		}

	}

}
add_action( 'admin_notices', 'delete_user_admin_notices' );


