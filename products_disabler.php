<?php
/**
 * Plugin Name: PRODUCTS_DISABLER
 * Plugin URI:  Solcoders.com
 * Description: PRODUCT_DISABLER desc.
 * Version:     1.1.1.0
 * Author:      Solcoders
 * Author URI:  https://www.upwork.com/freelancers/syedhamzahussain
 * Text Domain: PRODUCT_DISABLER
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'PRODUCT_DISABLER_PLUGIN_DIR' ) ) {
	define( 'PRODUCT_DISABLER_PLUGIN_DIR', __DIR__ );
}

if ( ! defined( 'PRODUCT_DISABLER_BASENAME' ) ) {
    define( 'PRODUCT_DISABLER_BASENAME', dirname( __FILE__ ) );
}

if ( ! defined( 'PRODUCT_DISABLER_PLUGIN_DIR_URL' ) ) {
	define( 'PRODUCT_DISABLER_PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'PRODUCT_DISABLER_TEMP_DIR' ) ) {
	define( 'PRODUCT_DISABLER_TEMP_DIR', PRODUCT_DISABLER_PLUGIN_DIR . '/templates' );
}

if ( ! defined( 'PRODUCT_DISABLER_ASSETS_DIR_URL' ) ) {
	define( 'PRODUCT_DISABLER_ASSETS_DIR_URL', PRODUCT_DISABLER_PLUGIN_DIR_URL . 'assets' );
}

require_once PRODUCT_DISABLER_PLUGIN_DIR . '/helpers.php';
require_once PRODUCT_DISABLER_PLUGIN_DIR . '/includes/class-pd-loader.php';
