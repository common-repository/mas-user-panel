<?php
/**
 * Plugin Name: Mas User Panel
 * Description: A frontend user panel for wordpress.
 * Author: Masoud Mahdian
 * Version: 1.3.1
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: mas-user-panel
 * Domain Path: /languages
 * Requires at least: 5.6
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Invalid request.' );
}

// plugin directory paths
define( 'MUP_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'MUP_INC_PATH', plugin_dir_path( __FILE__ ) . 'includes/' );
define( 'MUP_ADMIN_PATH', plugin_dir_path( __FILE__ ) . 'admin/' );
define( 'MUP_USER_PATH', plugin_dir_path( __FILE__ ) . 'user/' );

// plugin urls
define( 'MUP_ADMIN_URL', plugin_dir_url( __FILE__ ) . 'admin/' );
define( 'MUP_USER_URL', plugin_dir_url( __FILE__ ) . 'user/' );

// load text domain
function mup_load_text_domain() {
    load_plugin_textdomain( 'mas-user-panel', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

add_action( 'plugins_loaded', 'mup_load_text_domain' );

// includes functions
require_once MUP_INC_PATH . 'options.php';
require_once MUP_INC_PATH . 'functions.php';
require_once MUP_INC_PATH . 'register-field-settings.php';
require_once MUP_INC_PATH . 'register-setting-html-fields.php';
require_once MUP_INC_PATH . 'register-form-html-fields.php';

// includes classes
require_once MUP_INC_PATH . 'classes/includes.php';