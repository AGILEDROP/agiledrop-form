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
                'agiledrop_messages',
                false
            );
	    }

        public function settings_init() {
	        register_setting( 'agiledrop_form', 'agiledrop_form_options' );

	        add_settings_section(
		        'agiledrop_section_title',
		        false,
		        array( $this, 'section_title' ),
		        'agiledrop_form'
	        );


	        add_settings_field(
		        'agiledrop_field_title',
		        __( 'Title', 'agiledrop-domain' ),
		        array( $this, 'field_title' ),
		        'agiledrop_form',
		        'agiledrop_section_title',
		        [
			        'label_for' => 'agiledrop_field_title',
			        'class' => 'agiledrop-row',
			        'agiledrop_custom_data' => 'custom',
		        ]
	        );
        }

	    public function section_title( $args ) {
		    ?>
            <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Insert the title of the form.', 'agiledrop-domain' ); ?></p>
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
