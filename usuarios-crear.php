<?php
/*
Plugin Name: Usuarios: Crear
Description: Ejemplo para crear usuarios.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// add top-level administrative menu
function create_user_add_toplevel_menu() {

	add_menu_page(
		esc_html__('Usuarios y roles: crear usuario', 'myplugin'),
		esc_html__('Crear usuario', 'myplugin'),
		'manage_options',
		'myplugin',
		'create_user_display_settings_page',
		'dashicons-admin-generic',
		null
	);

}
add_action( 'admin_menu', 'create_user_add_toplevel_menu' );



// display the plugin settings page
function create_user_display_settings_page() {

	// check if user is allowed access
	if ( ! current_user_can( 'manage_options' ) ) return;

	?>

	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form method="post">
			<h3><?php esc_html_e( 'Crear usuario', 'myplugin' ); ?></h3>
			<p>
				<label for="username"><?php esc_html_e( 'Nombre de usuario', 'myplugin' ); ?></label><br />
				<input class="regular-text" type="text" size="40" name="username" id="username">
			</p>
			<p>
				<label for="email"><?php esc_html_e( 'Email', 'myplugin' ); ?></label><br />
				<input class="regular-text" type="text" size="40" name="email" id="email">
			</p>
			<p>
				<label for="password"><?php esc_html_e( 'Password', 'myplugin' ); ?></label><br />
				<input class="regular-text" type="text" size="40" name="password" id="password">
			</p>

			<p><?php esc_html_e( 'El usuario recibirá esta información vía email.', 'myplugin' ); ?></p>

			<input type="hidden" name="myplugin-nonce" value="<?php echo wp_create_nonce( 'myplugin-nonce' ); ?>">
			<input type="submit" class="button button-primary" value="<?php esc_html_e( 'Crear usuario', 'myplugin' ); ?>">
		</form>
	</div>

<?php

}



// add new user
function create_user_add_user() {

	// check if nonce is valid
	if ( isset( $_POST['myplugin-nonce'] ) && wp_verify_nonce( $_POST['myplugin-nonce'], 'myplugin-nonce' ) ) {

		// check if user is allowed
		if ( ! current_user_can( 'manage_options' ) ) wp_die();

		// get submitted username
		if ( isset( $_POST['username'] ) && ! empty( $_POST['username'] ) ) {

			$username = sanitize_user( $_POST['username'] );

		} else {

			$username = '';

		}

		// get submitted email
		if ( isset( $_POST['email'] ) && ! empty( $_POST['email'] ) ) {

			$email = sanitize_email( $_POST['email'] );

		} else {

			$email = '';

		}

		// get submitted password
		if ( isset( $_POST['password'] ) && ! empty( $_POST['password'] ) ) {

			$password = $_POST['password']; // sanitized by wp_create_user()

		} else {

			$password = wp_generate_password();

		}

		// set user_id variable
		$user_id = '';

		// check if user exists
		$username_exists = username_exists( $username );
		$email_exists = email_exists( $email );

		if ( $username_exists || $email_exists ) {

			$user_id = esc_html__( 'El usuario ya existe.', 'myplugin' );

		}

		// check non-empty values
		if ( empty( $username ) || empty( $email ) ) {

			$user_id = esc_html__( 'Nombre de usuario y correo requeridos.', 'myplugin' );

		}

		// create the user
		if ( empty( $user_id ) ) {

			$user_id = wp_create_user( $username, $password, $email );

			if ( is_wp_error( $user_id ) ) {

				$user_id = $user_id->get_error_message();

			} else {

				// email password
				$subject = __( 'Bienvenido a Wordpress!', 'myplugin' );
				$message = __( 'Puedes acceder con tu nombre de usuario y este password: ', 'myplugin' ) . $password;

				wp_mail( $email, $subject, $message );

			}

		}

		$location = admin_url( 'admin.php?page=myplugin&result='. urlencode( $user_id ) );

		wp_redirect( $location );

		exit;

	}

}
add_action( 'admin_init', 'create_user_add_user' );



// create the admin notice
function create_user_admin_notices() {

	$screen = get_current_screen();

	if ( 'toplevel_page_myplugin' === $screen->id ) {

		if ( isset( $_GET['result'] ) ) {

			if ( is_numeric( $_GET['result'] ) ) : ?>

				<div class="notice notice-success is-dismissible">
					<p><strong><?php esc_html_e('Usuario creado.', 'myplugin'); ?></strong></p>
				</div>

			<?php else : ?>

				<div class="notice notice-warning is-dismissible">
					<p><strong><?php echo esc_html( $_GET['result'] ); ?></strong></p>
				</div>

			<?php endif;

		}

	}

}
add_action( 'admin_notices', 'create_user_admin_notices' );


