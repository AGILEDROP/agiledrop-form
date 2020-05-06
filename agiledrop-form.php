<?php
/**
 * Plugin Name: Agiledrop Form
 * Plugin URI: http://www.agiledrop.com
 * Description: Simple form
 * Version: 1.0.0
 * Author: Agiledrop
 * Author URI: http://www.agiledrop.com
 * License: GPL2
 */

add_action( 'wp_enqueue_scripts', 'agiledrop_register_script' );

function agiledrop_register_script() {
	wp_enqueue_script( 'agiledrop-form-js', plugins_url() . '/agiledrop-form/agiledrop-form.js', array( 'jquery') );
}

add_shortcode( 'agiledrop_form', 'agiledrop_display_form' );

function agiledrop_display_form( ) {
	ob_start();?>
	<form class="form" id="agiledrop-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
		<div class="form__group">
			<label class="form__required" for="name">Ime in Priimek</label>
			<input type="text" class="form__input" id="name" name="name"  value="<?php echo $_POST['name'];?>" required>
			<p id="name-error" class="form__error">sdfsd</p>
		</div>
		<div class="form__group">
			<label class="form__required" for="email">E-naslov</label>
			<input type="email" class="form__input" id="email" name="email" value="<?php echo $_POST['email'];?>" required>
			<p id="email-error" class="form__error"></p>
		</div>
		<div class="form__group">
			<label class="form__required" for="location">Lokacija</label>
			<select class="form__select" id="location" name="location" required>
				<option value="MB">Maribor</option>
				<option value="LJ">Ljubljana</option>
				<option value="NM">Novo Mesto</option>
				<option value="CE">Celje</option>
			</select>
			<p id="location-error" class="form__error"></p>
		</div>
		<div class="form__group">
			<strong>Status</strong><br>
			<label class="form__radio" for="zaposlen">
				<input type="radio" id="zaposlen" name="status" value="zaposlen" <?php if (isset($_POST['status']) && $_POST['status']=="zaposlen") echo "checked";?>>
				Zaposlen
				<span class="checkmark"></span>
			</label>
			<label class="form__radio" for="brezposeln">
				<input type="radio" id="brezposeln" name="status" value="brezposeln" <?php if (isset($_POST['status']) && $_POST['status']=="brezposeln") echo "checked";?>>
				Brezposeln
				<span class="checkmark"></span>
			</label>
			<label class="form__radio" for="student">
				<input type="radio" id="student" name="status" value="student" <?php if (isset($_POST['status']) && $_POST['status']=="student") echo "checked";?>>
				Študent
				<span class="checkmark"></span>
			</label>
		</div>
		<div class="form__group">
			<label class="form__checkbox" for="zaposlitev">
				Zanima me zaposlitev v podjetju Agiledrop
				<input type="checkbox" id="zaposlitev" name="zaposlitev">
				<span class="checkmark"></span>
			</label>
			<label class="form__checkbox form__required" for="obdelava-podatkov">
				Strinjam se z obdelavo podatkov
				<input type="checkbox" id="obdelava-podatkov" name="obdelava-podatkov">
				<span class="checkmark"></span>
			</label>
		</div>
		<p id="form-status"></p>
		<button type="submit" class="form__button">Pošlji</button>
	</form>
	<?php
	return ob_get_clean();
}
add_action( 'wp_ajax_nopriv_agiledrop_save_form', 'agiledrop_form_save' );
add_action( 'wp_ajax_agiledrop_save_form', 'agiledrop_form_save' );
function agiledrop_form_save( ) {
	$name = wp_strip_all_tags( $_POST['name'] );
	$email = wp_strip_all_tags( $_POST['email'] );
	$location = wp_strip_all_tags( $_POST['location'] );
	$status = "";
	if ( isset( $_POST['status'] ) ) {
		$status = $_POST['status'];
	}
	$job = "Ne zanima me zaposlitev.";
	if ( $_POST['job'] == true ) {
		$job = "Zanima me zaposlitev.";
	}
	$data = 'Ne dovolim uporabo podatkov.';
	if ( $_POST['dataProcessing'] == true ){
		$data = 'Dovolim uporabo podatkov.';
	}
	$args = array(
		'post_title'    => 'Prijava na drupal tečaj',
		'post_type'     => 'agiledrop-message',
		'post_status'   => 'publish',
		'meta_input'    => array(
			'name'      => $name,
			'email'     => $email,
			'location'  => $location,
			'status'    => $status,
			'job'       => $job,
			'data'      => $data,
		)
	);
	wp_insert_post( $args );
}

add_action( 'admin_menu', 'agiledrop_register_menu_page' );

function agiledrop_register_menu_page() {
	add_menu_page(
		__( 'Agiledrop', 'agiledrop-domain' ),
		__( 'Agiledrop Form', 'agiledrop-domain' ),
		'manage_options',
		'agiledrop-form',
		false
	);
}

add_action( 'init', 'agiledrop_register_cpt' );

function agiledrop_register_cpt(){
	$args = array(
		'labels'            => array(
			'name'          => __( 'Messages', 'agiledrop-domain' ),
			'singular_name' => __( 'Message', 'agiledrop-domain' ),
		),
		'show_ui'           => true,
		'show_in_menu'      => 'agiledrop-form',
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'supports'          => array( 'title' ),
		'register_meta_box_cb' => 'agiledrop_add_meta_box',
	);

	register_post_type( 'agiledrop-message', $args );
}

add_filter( 'manage_agiledrop-message_posts_columns', 'agiledrop_create_columns' );

function agiledrop_create_columns( $columns ) {
	$columns['name']     = __( 'Participant', 'agiledrop-domain' );
	$columns['email']    = __( 'Email', 'agiledrop-domain' );
	$columns['location'] = __( 'Location', 'agiledrop-domain' );
	$columns['status']   = __( 'Status', 'agiledrop-domain' );
	$columns['job']      = __( 'Job', 'agiledrop-domain' );
	$columns['data']     = __( 'Data', 'agiledrop-domain' );
	return $columns;
}

add_action( 'manage_agiledrop-message_posts_custom_column', 'agiledrop_set_column' );

function agiledrop_set_column( $column ) {
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

function agiledrop_add_meta_box() {
	add_meta_box(
		'agiledrop_form_data',
		__( 'Participant', 'agiledrop' ),
		'agiledrop_box_data',
		'agiledrop-message',
		'advanced',
		'low'
	);
}
function agiledrop_box_data( $post ) {
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