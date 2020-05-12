<?php

if ( !class_exists( "Agiledrop_Form_Processing" ) ) {
	class Agiledrop_Form_Processings {
		public function __construct() {
			add_shortcode( 'agiledrop_form', array( $this, 'generate_form' ) );
			add_action( 'wp_ajax_nopriv_agiledrop_save_form', array( $this, 'form_save' ) );
			add_action( 'wp_ajax_agiledrop_save_form', array( $this, 'form_save' ) );
		}

		public function generate_form() {
		    $fields = get_option( 'agiledrop_form_fields_options' );
            if ( ! $fields ) {
	            echo "Create form fields first";
            }
            else {
                ob_start();?>
                <form class="form" id="agiledrop-form" action="agiledrop_save_form" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
                    <?php foreach ( $fields as $field ) :?>
                        <div class="form__group">
                            <label for="<?php echo $field['id']?>"><?php echo $field['name']; ?></label>
                            <input type="<?php echo $field['type']?>" name="<?php echo $field['id']?>" placeholder="<?php echo $field['placeholder'];?>">
                        </div>
                    <?php endforeach; ?>
                    <p id="form-status"></p>
	                <?php wp_nonce_field( 'handle_agiledrop_form', 'agiledrop_form_nonce' )?>
                    <button type="submit" class="form__button">Pošlji</button>
                </form>
                <?php return ob_get_clean();
            }
        }

        private function sanitize_fields( $fields ) {
	        foreach ( $fields as $key => $value ) {
		        $fields[$key]['value'] = wp_strip_all_tags( $value['value'] );
		        if ( empty( $fields[$key]['value'] ) ) {
			        $message = $fields[$key]['name'] . ' is empty.';
			        die( json_encode( array( 'message' => $message ) ) );
		        }
	        }
	        return $fields;
        }

        private function prepare_meta( $fields ) {
		    $meta_input = [];
		    foreach ( $fields as $field ) {
		        $meta_input[$field['name']] = $field['value'];
		    }
		    return $meta_input;
        }

		public function form_save( ) {
			if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'handle_agiledrop_form' ) ) {
				die( json_encode( array( 'message' => 'Nonce did not verify' ) ) );
			} else {
			    if ( isset( $_POST['fields'] ) && ! empty( $_POST['fields'] ) ) {
                    $fields = $_POST['fields'];
                    array_splice( $fields, -2 );
                    $fields = $this->sanitize_fields( $fields );
                    $meta_input = $this->prepare_meta( $fields );

                    $options = get_option( 'agiledrop_form_options' );

                    $args = array(
                        'post_title'    => $options['agiledrop_field_form_name'],
                        'post_type'     => 'agiledrop-message',
                        'post_status'   => 'publish',
                        'meta_input'    => $meta_input
                    );

                    wp_insert_post( $args );

                    if ( $options['agiledrop_field_mail_option'] === 'yes' ) {
                        $email = $options['agiledrop_field_user_email'];
                        $this->send_mail( $options['agiledrop_field_form_name'], $email );
                    }
			    }
			    else {
				    die( json_encode( array( 'message' => 'Something went wrong, please try later.' ) ) );
			    }
			}
		}

		private function send_mail( $title, $email ) {
            $subject = 'New submit on ' . $title;
            $message = "Review form submit ";
            $headers = 'From: ' . get_bloginfo( 'admin_email' );
            wp_mail( $email, $subject, $message, $headers );
		}

	}


}