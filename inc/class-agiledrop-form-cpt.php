<?php
if ( !class_exists( "Agiledrop_Form_Cpt" ) ) {
	class Agiledrop_Form_Cpt {
		public function __construct() {
			add_action( 'init', array( $this, 'register_cpt' ) );
			add_filter( 'manage_agiledrop-message_posts_columns', array( $this, 'create_columns' ) );
			add_action( 'manage_agiledrop-message_posts_custom_column', array( $this, 'set_column' ) );
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
				__( 'Participant', 'agiledrop' ),
				array( $this, 'custom_meta_box_data' ),
				'agiledrop-message',
				'advanced',
				'low'
			);
		}

		public function custom_meta_box_data( $post ) {
			$post_values = get_post_meta( $post->ID );
			echo "<h3>Participant</h3><p>";
			echo $post_values['name'][0];
			echo "</p><h3>Email</h3><p>";
			echo $post_values['email'][0];
			echo "</p><h3>Location</h3><p>";
			echo $post_values['location'][0];
			echo "</p><h3>Status</h3><p>";
			echo $post_values['status'][0];
			echo "</p><h3>Job interest</h3><p>";
			echo $post_values['job'][0];
			echo "</p><h3>Allowed data processing</h3><p>";
			echo $post_values['data'][0];
			echo "</p>";
		}


		public function create_columns( $columns ) {
			$columns['name']     = __( 'Participant', 'agiledrop-domain' );
			$columns['email']    = __( 'Email', 'agiledrop-domain' );
			$columns['location'] = __( 'Location', 'agiledrop-domain' );
			$columns['status']   = __( 'Status', 'agiledrop-domain' );
			$columns['job']      = __( 'Job', 'agiledrop-domain' );
			$columns['data']     = __( 'Data', 'agiledrop-domain' );
			return $columns;
		}

		public function set_column( $column ) {
			global $post;
			switch( $column ){
				case 'name':
					echo get_post_meta( $post->ID, 'name', true );
					break;
				case 'email':
					echo get_post_meta( $post->ID, 'email', true );
					break;
				case 'location':
					echo get_post_meta( $post->ID, 'location', true );
					break;
				case 'status':
					echo get_post_meta( $post->ID, 'status', true );
					break;
				case 'job':
					echo get_post_meta( $post->ID, 'job', true );
					break;
				case 'data':
					echo get_post_meta( $post->ID, 'data', true );
					break;
			}
		}
	}
}