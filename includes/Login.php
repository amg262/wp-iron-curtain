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


	public function __construct() {

		//add_action( 'wp_head', [ $this, 'that' ] );
		add_action( 'wp_login', [ $this, 'site_login' ], 10, 2 );
		//add_action( 'wp_logout', );

		add_action( 'admin_init', [ $this, 'upgrade_data' ] );
//
		//register_activation_hook( __FILE__, [ $this, 'upgrade_data' ] );
//		add_action( 'admin_init', [ $this, 'upgrade_data' ] );
		add_action( 'admin_init', [ $this, 'install_data' ] );
//		add_action( 'admin_init', [ $this, 'delete_db' ] );
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

		// your code
		require __DIR__ . '/Database.php';

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

		$ins = new Database();
		$ins->insert_login( $raw );
		$this->that();
	}

	function that() {

		echo json_encode( $_SERVER );

		return;
	}

	function site_logout() {

		delete_transient( 'transient_name' );
	}

}

