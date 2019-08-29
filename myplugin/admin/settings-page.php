<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


function myplugin_display_settings_page() {
	
	if ( ! current_user_can( 'manage_options' ) ) return;
	
	?>
	
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<form action="options.php" method="post">
			
			<?php
			
			settings_fields( 'myplugin_options' );
			
			do_settings_sections( 'myplugin' );
			
			submit_button();
			
			?>
			
		</form>
	</div>
	
	<?php
	
}

function myplugin_admin_notices() {

	$screen = get_current_screen();
	
	// return if not myplugin settings page
	if ( $screen->id !== 'toplevel_page_myplugin' ) return;
	
	// check if settings updated
	if ( isset( $_GET[ 'settings-updated' ] ) ) {
		
		// if settings updated successfully
		if ( 'true' === $_GET[ 'settings-updated' ] ) : 
		
		?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php _e( 'Enhorabuena!!!!', 'myplugin' ); ?></strong></p>
			</div>
			
		<?php 
		
		// if there is an error
		else : 
		?>
			<div class="notice notice-error is-dismissible">
				<p><strong><?php _e( 'Houston, tenemos un problema.', 'myplugin' ); ?></strong></p>
			</div>
			
		<?php 
		endif;
	}

}
add_action( 'admin_notices', 'myplugin_admin_notices' );



