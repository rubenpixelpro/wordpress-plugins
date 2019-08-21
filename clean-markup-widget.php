<?php
/*
Plugin Name: Clean markup Widget
Description: Widget para añadir HTML.
Author:      Rubén Córcoles
Version:     1.0
License:     GPLv2 or later
*/



// widget example: clean markup
class Clean_Markup_Widget extends WP_Widget {

	public function __construct() {

		$id = 'clean_markup_widget';

		$title = esc_html__('Clean Markup Widget', 'custom-widget');

		$options = array(
			'classname' => 'clean-markup-widget',
			'description' => esc_html__('Añade HTML que no sea modificado por WordPress.', 'custom-widget')
		);

		parent::__construct( $id, $title, $options );

	}

	public function widget( $args, $instance ) {

		// extract( $args );

		$markup = '';

		if ( isset( $instance['markup'] ) ) {

			echo wp_kses_post( $instance['markup'] );

		}

	}

	public function update( $new_instance, $old_instance ) {

		$instance = array();

		if ( isset( $new_instance['markup'] ) && ! empty( $new_instance['markup'] ) ) {

			$instance['markup'] = $new_instance['markup'];

		}

		return $instance;

	}

	public function form( $instance ) {

		$id = $this->get_field_id( 'markup' );

		$for = $this->get_field_id( 'markup' );

		$name = $this->get_field_name( 'markup' );

		$label = __( 'Markup/text:', 'custom-widget' );

		$markup = '<p>'. __( 'Clean markup.', 'custom-widget' ) .'</p>';

		if ( isset( $instance['markup'] ) && ! empty( $instance['markup'] ) ) {

			$markup = $instance['markup'];

		}

		?>

		<p>
			<label for="<?php echo esc_attr( $for ); ?>"><?php echo esc_html( $label ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>"><?php echo esc_textarea( $markup ); ?></textarea>
		</p>

<?php }

}

// register widget
function myplugin_register_widgets() {

	register_widget( 'Clean_Markup_Widget' );

}
add_action( 'widgets_init', 'myplugin_register_widgets' );


