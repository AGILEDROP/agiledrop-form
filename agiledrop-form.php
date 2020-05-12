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

/**
 * Define constants
 */
define( 'AGILEDROP_PLUGIN', __FILE__ );
define( 'AGILEDROP_PLUGIN_DIR', untrailingslashit( dirname( AGILEDROP_PLUGIN ) ) );

/**
 * Add Settings link on plugins page
 */
add_filter( 'plugin_action_links_agiledrop-form/agiledrop-form.php', 'agiledrop_form_settings_link' );
function agiledrop_form_settings_link( $links ) {
	$url = esc_url( add_query_arg('page',	'agiledrop_form', get_admin_url() . 'admin.php' ) );
	$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';
	array_push( $links, $settings_link );
	return $links;
}

/**
 * Plugin enqueues
 */
require AGILEDROP_PLUGIN_DIR . '/inc/class-agiledrop-form-enqueues.php';
new Agiledrop_Form_Enqueues();

/**
 * Plugin pages
 */
require AGILEDROP_PLUGIN_DIR . '/inc/class-agiledrop-form-pages.php';
new Agiledrop_Form_Pages();
/**
 * Plugin settings fields.
 */
require_once AGILEDROP_PLUGIN_DIR . '/inc/class-agiledrop-form-settings-fields.php';
new Agiledrop_Form_Settings_Fields();
/**
 * Plugin other fields.
 */
require_once AGILEDROP_PLUGIN_DIR . '/inc/class-agiledrop-form-fields.php';
new Agiledrop_Form_Fields();
/**
 * Plugin CPT
 */
require AGILEDROP_PLUGIN_DIR . '/inc/class-agiledrop-form-cpt.php';
new Agiledrop_Form_Cpt();

/**
 * Process form
 */
require AGILEDROP_PLUGIN_DIR . '/inc/class-agiledrop-form-processing.php';
new Agiledrop_Form_Processings();






