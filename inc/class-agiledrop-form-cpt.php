<?php
namespace AgiledropForm;

if ( !class_exists( "Agiledrop_Form_Cpt" ) ) {
	class Agiledrop_Form_Cpt {
		public function __construct() {
			add_action( 'init', array( $this, 'register_cpt' ) );
		}

		public function register_cpt(){
			$args = array(
				'labels'            => array(
					'name'          => __( 'Messages', 'agiledrop-domain' ),
					'singular_name' => __( 'Message', 'agiledrop-domain' ),
				),
				'show_ui'           => true,
				'show_in_menu'      => false,
				'capability_type'   => 'post',
				'hierarchical'      => false,
				'supports'          => array( 'title' ),
				'register_meta_box_cb' => array( $this, 'add_custom_meta_box' ),
			);
			register_post_type( 'agiledrop-message', $args );
		}

		public function add_custom_meta_box() {
			add_meta_box(
				'agiledrop_form_data',
				__( 'Form Data', 'agiledrop' ),
				array( $this, 'custom_meta_box_data' ),
				'agiledrop-message',
				'advanced',
				'low'
			);
		}

		public function custom_meta_box_data( $post ) {
			$post_values = get_post_meta( $post->ID );
			foreach ( $post_values as $key => $value ) {
				if ( $key !== '_edit_lock' ) {
					echo '<h3>' . $key . '</h3>';
					echo '<p>' . $value[0] . '</p>';
				}
			}
		}
	}
}