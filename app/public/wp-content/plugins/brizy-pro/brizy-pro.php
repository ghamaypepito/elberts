<?php
/**
 * Plugin Name: Brizy Pro
 * Description: Extended functionality for the Brizy WordPress builder plugin.
 * Plugin URI: https://brizy.io/
 * Author: Brizy.io
 * Author URI: https://brizy.io/
 * Version: 0.0.34
 * Text Domain: brizy-pro
 * License: To be announced
 * Domain Path: /languages
 */

define( 'BRIZY_PRO_DEVELOPMENT', false );
define( 'BRIZY_PRO_VERSION', '0.0.34' );
define( 'BRIZY_PRO_EDITOR_VERSION', '22-wp' );
define( 'BRIZY_PRO_FILE', __FILE__ );
define( 'BRIZY_REQUIRED_VERSION', '1.0.112' );
define( 'BRIZY_PRO_PLUGIN_BASE', plugin_basename( BRIZY_PRO_FILE ) );
define( 'BRIZY_PRO_PLUGIN_PATH', dirname( BRIZY_PRO_FILE ) );
define( 'BRIZY_PRO_PLUGIN_URL', rtrim( plugin_dir_url( BRIZY_PRO_FILE ), "/" ) );

include_once rtrim( BRIZY_PRO_PLUGIN_PATH, "/" ) . '/autoload.php';
include_once rtrim( BRIZY_PRO_PLUGIN_PATH, "/" ) . '/whitelabel/main.php';

function brizy_pro_load_plugin_textdomain() {
	load_plugin_textdomain( 'brizy-pro', false, plugin_basename( dirname( BRIZY_PRO_FILE ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'brizy_pro_load_plugin_textdomain' );

add_action( 'plugins_loaded', 'brizy_pro_load' );
add_action( 'upgrader_process_complete', 'brizypro_upgrade_completed', 10, 2 );
register_activation_hook( BRIZY_PRO_FILE, 'brizypro_install' );

function brizy_pro_load() {
	$mainInstance = new BrizyPro_Main();
	$mainInstance->run();
}

function brizypro_upgrade_completed( $upgrader_object, $options ) {
	if ( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
		foreach ( $options['plugins'] as $plugin ) {
			if ( $plugin == BRIZY_PRO_PLUGIN_BASE ) {
				add_option( 'brizypro-regenerate-permalinks', 1 );
			}
		}
	}
}

function brizypro_install() {

	if ( defined( 'BRIZY_VERSION' ) ) {
		Brizy_Editor::get()->registerCustomPostTemplates();
	}

	$mainInstance = new BrizyPro_Main();
	$mainInstance->registerCustomPosts();

	add_option( 'brizypro-regenerate-permalinks', 1 );
}
