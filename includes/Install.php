<?php
/**
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/**
 * Created by PhpStorm.
 * User: mint
 * Date: 9/29/18
 * Time: 1:33 AM
 */
class Install {


	public function __construct() {

		add_action( 'admin_init', [ $this, 'upgrade_data' ]);
//
		//register_activation_hook( __FILE__, [ $this, 'upgrade_data' ] );
//		add_action( 'admin_init', [ $this, 'upgrade_data' ] );
		add_action( 'admin_init', [ $this, 'install_data' ] );
//		add_action( 'admin_init', [ $this, 'delete_db' ] );
	}



	function delete_options() {

		if ( get_option( 'wcb_options' ) === false ) {
			delete_option( 'wcb_options' );
		}
	}


	/**
	 *
	 */
	function install_data() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wp_irc';

		$wpdb->insert( $table_name, [
			'url' => 3,
			'outcome'    => 'part',
			'user_data'    => 'yo',
			'user_agent'    => current_time( 'mysql' ),
			'is_flag' => 3,
			'time'    => current_time( 'mysql' ),
			'active'  => - 1,
		] );
	}


	/**
	 *
	 */
	function delete_db() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wp_irc';

		//$q = "SELECT * FROM " . $table_name . " WHERE id > 0  ;";
		$wpdb->query( "DROP TABLE IF EXISTS $table_name ;" );
	}


	/**
	 *
	 */
	function upgrade_data( $table, $sql = false ) {

		global $wpdb;
		$table_name = $wpdb->prefix . 'wp_irc';

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
					id int(11) NOT NULL AUTO_INCREMENT,
					url varchar(255),
					outcome varchar(255) ,
					user_data text ,
					user_agent text ,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					is_flag tinyint(1) DEFAULT 0,
					active tinyint(1) DEFAULT 0,
					PRIMARY KEY  (id)
				);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
}

