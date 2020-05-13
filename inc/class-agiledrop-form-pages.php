<?php
if ( !class_exists('Agiledrop_Form_Pages' ) ) {
    class Agiledrop_Form_Pages {

        public function __construct() {
            add_action( 'admin_init', array( $this, 'settings_init' ) );
	        add_action( 'admin_menu', array( $this, 'options_page' ) );
	        //Add default option
            add_option( 'agiledrop_form_fields_options' );
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
	        register_setting( 'agiledrop_form_fields', 'agiledrop_form_fields_options', array( $this, 'save_fields' ) );

	        add_settings_section(
		        'agiledrop_section_settings',
		        false,
		        false,
		        'agiledrop_form'
	        );

	        add_settings_section(
	                'agiledrop_section_fields',
                    false,
                       false,
                'agiledrop_form_fields'
            );
        }

        public function save_fields( $args ) {
            $existing_fields = get_option( 'agiledrop_form_fields_options' );
			//using when deleting field
            if ( isset( $args['delete'] ) ) {
				array_pop( $args );
				return $args;
			}
            $new_field[] = $args;

            if ( empty( $existing_fields ) ) {
                $new_field[0]['id'] = 'field-1';
                $new_field[0]['id_value'] = 1;
                return $new_field;
            }

            $last = end( $existing_fields );
            $last_id = $last['id_value'];
            $last_id++;
            $new_field[0]['id'] = 'field-'.$last_id;
            $new_field[0]['id_value'] = $last_id;

            return array_merge( $existing_fields, $new_field );
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
