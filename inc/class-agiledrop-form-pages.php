<?php
if ( !class_exists('Agiledrop_Form_Pages' ) ) {
    class Agiledrop_Form_Pages {

        public function __construct() {
            add_action( 'admin_init', array( $this, 'settings_init' ) );
	        add_action( 'admin_menu', array( $this, 'options_page' ) );
        }

	    public function options_page() {
		    add_menu_page(
			    'Agiledrop Form',
			    'Agilderop Form',
			    'manage_options',
			    'agiledrop_form',
			    array( $this, 'options_page_html' )
		    );
		    add_submenu_page(
		      'agiledrop_form',
                'Messages',
                'Messages',
                'manage_options',
                'edit.php?post_type=agiledrop-message'
            );
	    }

        public function settings_init() {
	        register_setting( 'agiledrop_form', 'agiledrop_form_options' );

	        add_settings_section(
	                'agiledrop_section_mail',
                    false,
                false,
                'agiledrop_form'
            );

	        add_settings_section(
		        'agiledrop_section_settings',
		        false,
		        false,
		        'agiledrop_form'
	        );

	        add_settings_field(
	            'agiledrop_field_mail',
                    __( 'Notify admin about new submit', 'agiledrop-domain' ),
                    array( $this, 'field_mail' ),
                    'agiledrop_form',
                'agiledrop_section_mail',
                [
                        'label_for'             => 'agiledrop_field_mail',
                        'class'                 => 'agiledrop-row',
                        'agiledrop_custom_data' => 'custom'
                ]
            );

	        add_settings_field(
		        'agiledrop_field_title',
		        __( 'Title', 'agiledrop-domain' ),
		        array( $this, 'field_title' ),
		        'agiledrop_form',
		        'agiledrop_section_settings',
		        [
			        'label_for' => 'agiledrop_field_title',
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

	    public function field_title( $args ) {
		    $options = get_option( 'agiledrop_form_options' );
		    ?>
            <input type="text"
                   name="agiledrop_form_options[<?php echo esc_attr( $args['label_for'] );?>]"
                   data-custom="<?php esc_attr( $args['agiledrop_custom_data'] );?>"
                   value="<?php echo $options['agiledrop_field_title']; ?>"
            >
		    <?php
	    }

	    public function options_page_html() {
		    if ( ! current_user_can( 'manage_options' ) ) {
			    return;
		    }

		    if ( isset( $_GET['settings-updated'] ) ) {
			    add_settings_error( 'agiledrop_form_messages', 'agiledrop_form_message', __( 'Settings Saved', 'agiledrop-domain' ), 'updated' );
		    }

		    require_once AGILEDROP_PLUGIN_DIR . '/templates/agiledrop-form-settings.php';
	    }
    }
}
