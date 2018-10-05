<?php
/**
 * WP-Bom
 *
 *
 * @package   WPIRC
 * @author    amg262
 * @license   GPL-3.0
 * @link      https://.com
 * @copyright 2018 amg262 (Pty) Ltd
 *
 * @wordpress-plugin
 * Plugin Name:       WPIRC
 * Plugin URI:        https://.com
 * Description:       React boilerplate for WordPress plugins
 * Version:           1.0.0
 * Author:            amg262
 * Author URI:        https://gopangolin.com
 * Text Domain:       wp-iron-curtain
 * License:           GPL-3.0
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path:       /languages
 */


namespace Netraa\WPIRC;

// If this file is called directly, abort.
use Symfony\Component\VarDumper\Cloner\Data;

if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 *
 */
define( "DEFAULT_LOG", __DIR__ . "/assets/default.log" );

/**
 *
 */
define( 'WP_IRC_TBL', 'wp_irc_login' );
/**
 *
 */
define( 'WP_IRC_', 'wp_irc_' );
/**
 *
 */
const WP_IRC_LOCAL = 'http://wp.local';

/**
 *
 */
const WP_IRC_JS = 'wp-irc.js';
/**
 *
 */
const WP_IRC_JS_MIN = 'wp-irc.min.js';
/**
 *
 */
const WP_IRC_CSS = 'wp-irc.css';
/**
 *
 */
const WP_IRC_MIN_CSS = 'wp-irc.min.css';
/**
 *
 */
const PATHS = [
	'local'       => WP_IRC_LOCAL,
	'dir'         => __DIR__,
	'wp-irc'      => '/wp-iron-curtain.php',
	'assets'      => [
		'assets' => '/assets/',
		'css'    => '/assets/css/',
		'js'     => '/assets/js/',
		'images' => '/assets/images/',
	],
	'app'         => __DIR__ . '/app/',
	'acf'         => __DIR__ . '/acf/',
	'acfphp'      => __DIR__ . '/acf/acf.php',
	'data'        => __DIR__ . '/data/',
	'dist'        => [
		'dist'   => '/dist/',
		'css'    => '/dist/css/',
		'js'     => '/dist/js/',
		'images' => '/dist/images/',
	],
	'includes'    => __DIR__ . '/includes/',
	'test'        => __DIR__ . '/test/',
	'logs'        => __DIR__ . '/logs/',
	'wpirc-core'  => __DIR__ . '/wp-bom-core.php',
	'gulp'        => __DIR__ . '/gulpfile.js',
	'stylesheets' => [ 'admin.css', 'shortcode.css', 'widget.css', 'wp-irc.css' ],
	'scripts'     => [ 'admin', 'shortcode', 'widget', 'wp-irc' ],

];
/**
 *
 */
const DIST_JS = __DIR__ . '/dist/';


/*
 * Autoloader
 *
 * @param string $class The fully-qualified class name.
 * @return void
 *
 *  * @since 1.0.0
 */
try {
	spl_autoload_register( /**
	 * @param $class
	 */
		function ( $class ) {

			// project-specific namespace prefix
			$prefix = __NAMESPACE__;

			// base directory for the namespace prefix
			$base_dir = __DIR__ . '/includes/';

			// does the class use the namespace prefix?
			$len = strlen( $prefix );
			if ( strncmp( $prefix, $class, $len ) !== 0 ) {
				// no, move to the next registered autoloader
				return;
			}

			// get the relative class name
			$relative_class = substr( $class, $len );

			// replace the namespace prefix with the base directory, replace namespace
			// separators with directory separators in the relative class name, append
			// with .php
			$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

			// if the file exists, require it
			if ( file_exists( $file ) ) {
				require $file;
			}
		} );
} catch ( \Exception $e ) {
}

/**
 * Initialize Plugin
 *
 * @since 1.0.0
 */
function init() {

	//echo json_encode( $_SERVER );
	$settings = new Settings();

	$admin    = Admin::get_instance();

	$plugin = Plugin::get_instance();
	$short  = Shortcode::get_instance();
	$widget = new Widget();

	$log = new Login();


}

add_action( 'plugins_loaded', 'Netraa\\WPIRC\\init' );


/**
 * Register the widget
 *
 * @since 1.0.0
 */
function widget_init() {

	return register_widget( new Widget );
}

add_action( 'widgets_init', 'Netraa\\WPIRC\\widget_init' );
//create_tbl
/**
 * Register activation and deactivation hooks
 */
register_activation_hook( __FILE__, [ 'Netraa\\WPIRC\\Plugin', 'activate' ] );
register_deactivation_hook( __FILE__, [ 'Netraa\\WPIRC\\Plugin', 'deactivate' ] );

add_action( 'init', 'Netraa\\WPIRC\\load_assets' );

/**
 *
 */
function load_assets() {
	wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
	wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );
	wp_register_script( 'wpirc_min_js', plugins_url( PATHS['dist']['js'] . WP_IRC_JS_MIN ), [ 'jquery' ] );
	wp_register_script( 'wpirc_js', plugins_url( PATHS['assets']['js'] . WP_IRC_JS, __FILE__ ), [ 'jquery' ] );
	wp_register_style( 'wpirc_min_css', plugins_url( PATHS['dist']['css'] . WP_IRC_MIN_CSS, __FILE__ ) );
	wp_register_style( 'wpirc_css', plugins_url( PATHS['assets']['css'] . WP_IRC_CSS, __FILE__ ) );
	wp_enqueue_script( 'wpirc_min_js' );
	wp_enqueue_style( 'wpirc_min_css' );
	//} else {
	wp_enqueue_script( 'wpirc_js' );
	wp_enqueue_style( 'wpirc_css' );


}