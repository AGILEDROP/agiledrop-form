<?php
if ( ! class_exists( 'Agiledrop_Form_Settings_Fields' ) ) {
	class Agiledrop_Form_Settings_Fields {
		public function __construct() {
			add_action( 'admin_init', array( $this, 'fields_init' ) );
		}

		public function fields_init() {
			add_settings_field(
				'agiledrop_field_mail_option',
				__( 'Forward form submit to mail', 'agiledrop-domain' ),
				array( $this, 'field_mail' ),
				'agiledrop_form',
				'agiledrop_section_settings',
				[
					'label_for'             => 'agiledrop_field_mail_option',
					'class'                 => 'agiledrop-row',
					'agiledrop_custom_data' => 'custom'
				]
			);
			add_settings_field(
				'agiledrop_field_user_email',
				__( 'Select user email', 'agiledrop-domain' ),
				array( $this, 'field_user_email' ),
				'agiledrop_form',
				'agiledrop_section_settings',
				[
					'label_for'             => 'agiledrop_field_user_email',
					'class'                 => 'agiledrop-row',
					'agiledrop_custom_data' => 'custom'
				]
			);
			add_settings_field(
				'agiledrop_field_form_name',
				__( 'Name of the form', 'agiledrop-domain' ),
				array( $this, 'field_form_name' ),
				'agiledrop_form',
				'agiledrop_section_settings',
				[
					'label_for' => 'agiledrop_field_form_name',
					'class' => 'agiledrop-row',
					'agiledrop_custom_data' => 'custom',
				]
			);
		}

		public function field_mail( $args ) {
			$options = get_option( 'agiledrop_form_options' );
			?>
			<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
			        data-custom="<?php echo esc_attr( $args['agiledrop_custom_data'] ); ?>"
			        name="agiledrop_form_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			>
				<option value="yes" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'yes', false ) ) : ( '' ); ?>>
					<?php esc_html_e( 'Yes', 'agiledrop-domain' ); ?>
				</option>
				<option value="no" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], 'no', false ) ) : ( '' ); ?>>
					<?php esc_html_e( 'No', 'agiledrop-domain' ); ?>
				</option>
			</select>
			<?php
		}

		public function field_user_email( $args ) {
			$options = get_option( 'agiledrop_form_options' );
			$all_users = get_users( array( 'role__not_in' => 'administrator' ) );
			?>
			<select id="<?php echo esc_attr( $args['label_for'] ); ?>"
			        data-custom="<?php echo esc_attr( $args['agiledrop_custom_data'] ); ?>"
			        name="agiledrop_form_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
			>
				<?php foreach ( $all_users as $user ) {?>
					<option value="<?php echo $user->user_email; ?>" <?php echo isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], $user->user_email, false ) ) : ( '' ); ?>>
						<?php echo esc_html( $user->user_email ); ?>
					</option>
				<?php }?>
			</select>
			<?php
		}

		public function field_form_name( $args ) {
			$options = get_option( 'agiledrop_form_options' );
			?>
			<input type="text"
			       name="agiledrop_form_options[<?php echo esc_attr( $args['label_for'] );?>]"
			       data-custom="<?php esc_attr( $args['agiledrop_custom_data'] );?>"
			       value="<?php echo $options['agiledrop_field_form_name']; ?>"
			>
			<?php
		}

	}
}