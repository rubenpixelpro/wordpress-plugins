<?php

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


function myplugin_register_settings() {

	register_setting(
		'myplugin_options',
		'myplugin_options',
		'myplugin_callback_validate_options'
	);

	add_settings_section(
		'myplugin_section_login',
		'Personaliza la página de Login',
		'myplugin_callback_section_login',
		'myplugin'
	);

	add_settings_section(
		'myplugin_section_admin',
		'Personaliza el área de administración',
		'myplugin_callback_section_admin',
		'myplugin'
	);

	// Opciones para login
	add_settings_field(
		'custom_url',
		'Custom URL',
		'myplugin_callback_field_text',
		'myplugin',
		'myplugin_section_login',
		[ 'id' => 'custom_url', 'label' => 'URL para el enlace del logo' ]
	);

	add_settings_field(
		'custom_title',
		'Custom Title',
		'myplugin_callback_field_text',
		'myplugin',
		'myplugin_section_login',
		[ 'id' => 'custom_title', 'label' => 'Título para el enlace del logo' ]
	);

	add_settings_field(
		'custom_style',
		'Custom Style',
		'myplugin_callback_field_radio',
		'myplugin',
		'myplugin_section_login',
		[ 'id' => 'custom_style', 'label' => 'CSS para la pantalla de login' ]
	);

	add_settings_field(
		'custom_message',
		'Custom Message',
		'myplugin_callback_field_textarea',
		'myplugin',
		'myplugin_section_login',
		[ 'id' => 'custom_message', 'label' => 'Mensaje de bienvenida' ]
	);

	// Opciones para administración
	add_settings_field(
		'custom_footer',
		'Custom Footer',
		'myplugin_callback_field_text',
		'myplugin',
		'myplugin_section_admin',
		[ 'id' => 'custom_footer', 'label' => 'Texto del footer' ]
	);

	add_settings_field(
		'custom_toolbar',
		'Custom Toolbar',
		'myplugin_callback_field_checkbox',
		'myplugin',
		'myplugin_section_admin',
		[ 'id' => 'custom_toolbar', 'label' => 'Personaliza la barra de herramientas' ]
	);

	add_settings_field(
		'custom_scheme',
		'Custom Scheme',
		'myplugin_callback_field_select',
		'myplugin',
		'myplugin_section_admin',
		[ 'id' => 'custom_scheme', 'label' => 'Esquema de colores' ]
	);
	
}
add_action( 'admin_init', 'myplugin_register_settings' );