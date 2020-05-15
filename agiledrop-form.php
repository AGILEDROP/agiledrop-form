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

require "vendor/autoload.php";

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
use AgiledropForm\Agiledrop_Form_Enqueues;
new Agiledrop_Form_Enqueues();

/**
 * Plugin pages
 */
use AgiledropForm\Agiledrop_Form_Pages;
new Agiledrop_Form_Pages();

/**
 * Plugin settings fields.
 */
use AgiledropForm\Agiledrop_Form_Settings_Fields;
new Agiledrop_Form_Settings_Fields();

/**
 * Plugin other fields.
 */
use AgiledropForm\Agiledrop_Form_Fields;
new Agiledrop_Form_Fields();

/**
 * Plugin CPT
 */
use AgiledropForm\Agiledrop_Form_Cpt;
new Agiledrop_Form_Cpt();
/**
 * Process form
 */
use AgiledropForm\Agiledrop_Form_Processings;
new Agiledrop_Form_Processings();

/**
 * Text domain
 */
add_action( 'init', 'agiledrop_form_load_textdomain' );
function agiledrop_form_load_textdomain() {
	load_plugin_textdomain( 'agiledrop-domain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}


