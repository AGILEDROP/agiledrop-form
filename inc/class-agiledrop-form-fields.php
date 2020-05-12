<?php
if ( ! class_exists( 'Agiledrop_Form_Fields' ) ) {
	class Agiledrop_Form_Fields{
		public function __construct() {
			add_action( 'admin_init', array( $this, 'fields_init' ) );
		}
		public function fields_init() {
			add_settings_field(
				'agiledrop_field_type',
				__( 'Select input type', 'agiledrop-domain' ),
				array( $this, 'field_type' ),
				'agiledrop_form_fields',
				'agiledrop_section_fields',
				[
					'label_for'    => 'agiledrop_field_type',
					'class'        => 'agiledrop-row',
					'agiledrop_field_data' => 'custom'
				]
			);
			add_settings_field(
				'agiledrop_field_name',
				__( 'Add name of input', 'agiledrop-domain' ),
				array( $this, 'field_name' ),
				'agiledrop_form_fields',
				'agiledrop_section_fields',
				[
					'label_for'    => 'agiledrop_field_name',
					'class'        => 'agiledrop-row',
					'agiledrop_field_data' => 'custom'
				]
			);
			add_settings_field(
				'agiledrop_field_placeholder',
				__( 'Add placeholder', 'agiledrop-domain' ),
				array( $this, 'field_placeholder' ),
				'agiledrop_form_fields',
				'agiledrop_section_fields',
				[
					'label_for'    => 'agiledrop_field_placeholder',
					'class'        => 'agiledrop-row',
					'agiledrop_field_data' => 'custom'
				]
			);
		}

		public function field_type( $args ) {
			$options = get_option( 'agiledrop_form_fields_options' );
			?>
			<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
			        data-custom="<?php echo esc_attr( $args['agiledrop_field_data'] ); ?>"
			        name="agiledrop_form_fields_options[type]"
			>
				<option value="text" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'text', false ) ) : ( '' ); ?>>
					<?php esc_html_e( 'Text', 'agiledrop-domain' ); ?>
				</option>
				<option value="email" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'email', false ) ) : ( '' ); ?>>
					<?php esc_html_e( 'Email', 'agiledrop-domain' ); ?>
				</option>
			</select>
			<?php
		}

		public function field_name( $args ) {
			?>
            <input type="text"
                   name="agiledrop_form_fields_options[name]"
                   data-custom="<?php esc_attr( $args['agiledrop_field_data'] );?> required"
            >
			<?php
		}

		public function field_placeholder( $args ) {
		    ?>
            <input type="text"
                   name="agiledrop_form_fields_options[placeholder]"
                   data-custom="<?php esc_attr( $args['agiledrop_field_data'] );?>"
            >
            <?php
		}
	}
}