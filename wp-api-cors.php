<?php
/**
 * Plugin Name: JSON REST API CORS
 * Description: Enable <a href="http://www.html5rocks.com/en/tutorials/cors/">CORS</a> for the <a href="https://github.com/WP-API/WP-API">WP JSON REST API</a>. Acronym all the things.
 * Author: Brent Shepherd
 * Author URI: http://brent.io
 * Version: 1.0
 * Plugin URI: https://github.com/thenbrent/WP-API-CORS
 */

if ( ! class_exists( 'WP_API_CORS' ) ) :

/**
 * @class WP_API_CORS
 * @version	1.0
 */
final class WP_API_CORS {

	/**
	 * @var The single instance of the class
	 * @since 1.0
	 */
	protected static $_instance = null;

	/**
	 * Main Instance
	 *
	 * Ensures only one instance of the CORS headers is loaded and can be loaded.
	 *
	 * @since 1.0
	 * @static
	 * @return Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
			self::$_instance->setup_filters();
		}
		return self::$_instance;
	}

	/**
	 * A dummy constructor to prevent loading more than once.
	 *
	 * @see bbPress::instance()
	 * @see bbpress();
	 */
	private function __construct() { /* Do nothing here */ }

	/**
	 * Init WooCommerce when WordPress Initialises.
	 */
	public function setup_filters() {

		error_log( 'In ' . __CLASS__ . ' get_http_origin() = ' . print_r( get_http_origin(), true ) );
		error_log( 'In ' . __CLASS__ . ' $_COOKIE = ' . print_r( $_COOKIE, true ) );
		error_log( 'In ' . __CLASS__ . ' $_SERVER = ' . print_r( $_SERVER, true ) );

		add_filter( 'allowed_http_origin', '__return_true' );

		add_filter( 'wp_headers', array( &$this, 'send_cors_headers' ), 11, 1 );
	}

	/**
	 * Send headers to enable CORS. These are hooked to @see 'wp_headers' filter and therefore, are
	 * only send for front-end requests (i.e. not /wp-admin/ requests).
	 *
	 * @TODO only send these on WP API requests.
	 */
	public static function send_cors_headers( $headers ) {

		$headers['Access-Control-Allow-Origin']      = get_http_origin(); // Can't use wildcard origin for credentials requests, instead set it to the requesting origin
		$headers['Access-Control-Allow-Credentials'] = 'true';

		// Access-Control headers are received during OPTIONS requests
		if ( 'OPTIONS' == $_SERVER['REQUEST_METHOD'] ) {

			if ( isset( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] ) ) {
				$headers['Access-Control-Allow-Methods'] = 'GET, POST, OPTIONS';
			}

			if ( isset( $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'] ) ) {
				$headers['Access-Control-Allow-Headers'] = $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'];
			}

		}

		return $headers;
	}
}
endif;

WP_API_CORS::instance();