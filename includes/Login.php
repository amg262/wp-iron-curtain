<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

namespace Netraa\WPIRC;

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 9/29/18
 * Time: 1:33 AM
 */
class Login {

	private $ins;

	public function __construct() {

		// your code
		require __DIR__ . '/Database.php';

		//add_action( 'wp_head', [ $this, 'that' ] );
		add_action( 'wp_login', [ $this, 'site_login' ], 10, 2 );
		//add_action( 'wp_logout', );
		add_action( 'wp_login_failed', [ $this, 'pippin_login_fail' ] );  // hook failed login

	}


	function url_params() {


	}

	/**
	 *
	 */
	public function exec() {

		if ( $_GET['cloak'] === 'on' ) {
			?>
            <script>swal('boo');</script>
			<?php
		}
	}

	function pippin_login_fail( $username ) {
		$referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
		// if there's a valid referrer, and it's not the default log-in screen
		if ( ! empty( $referrer ) && ! strstr( $referrer, 'wp-login' ) && ! strstr( $referrer, 'wp-admin' ) ) {
			wp_redirect( home_url() . '/?login=failed' );  // let's append some information (login=failed) to the URL for the theme to use
			exit;
		}
	}

	/**
	 *
	 */
	public function run() {

		if ( ( $_GET['cloak'] === 'on' ) ) {

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
			}

		} elseif ( $_GET['cloak'] === 'off' ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}
	}


	function site_login( $user_login, $user ) {
		$ins = new Database();

		$user = new \WP_User( $user );

		$raw = [
			'event' => 'login',
			'user'  => [
				$user->user_login,
				$user->user_pass,
				$user->user_email,
				$user->roles,
				$_SERVER['REMOTE_ADDR'],
				$_SERVER['HTTP_USER_AGENT'],
				$_SERVER['HTTP_REFERER'],
			],
		];

		$ins->insert_login( $user->ID, $user->user_nicename, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $_SERVER['HTTP_REFERER'], 'login' );
		//$this->that();
	}

	function that() {

		echo json_encode( $_SERVER );

		return;
	}

	function site_logout() {

		delete_transient( 'transient_name' );
	}

}

