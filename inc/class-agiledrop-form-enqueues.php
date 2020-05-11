<?php

if ( ! class_exists( "Agiledrop_Form_Enqueues" ) ) {
	class Agiledrop_Form_Enqueues {

		public function __construct() {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_script' ) );
		}

		public function register_script() {
			wp_enqueue_script( 'agiledrop-form-js', plugin_dir_url(__DIR__ ) . '/dist/agiledrop-form.js', array( 'jquery') );
		}
	}
}