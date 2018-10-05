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
class Database {


	public function __construct() {


		add_action( 'admin_init', [ $this, 'create_tbl' ] );
//
		//register_activation_hook( __FILE__, [ $this, 'upgrade_data' ] );
//		add_action( 'admin_init', [ $this, 'upgrade_data' ] );
		//add_action( 'admin_init', [ $this, 'install_data' ] );
//		add_action( 'admin_init', [ $this, 'delete_db' ] );
	}


	/**
	 *
	 */
	function drop_tbl() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wp_irc_log';

		//$q = "SELECT * FROM " . $table_name . " WHERE id > 0  ;";
		$wpdb->query( "DROP TABLE IF EXISTS $table_name ;" );
	}

	function query() {

		global $wpdb;
		$table_name = $wpdb->prefix . 'wp_irc_log';

		$sql = "SELECT * FROM $table_name ;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		return dbDelta( $sql );
	}

	/**
	 *
	 */
	function insert_login( $user_id, $username, $ip, $agent, $refer, $event ) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wp_irc_log';


		$wpdb->insert( $table_name, [
			'user_id'  => $user_id,
			'username' => $username,
			'ip'       => $ip,
			'agent'    => $agent,
			'refer'    => $refer,
			'event'    => $event,
			'time'     => current_time( 'mysql' ),
		] );


	}

	/**
	 *
	 */
	function create_tbl() {

		global $wpdb;
		$table_name = $wpdb->prefix . 'wp_irc_log';

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
					id int(11) NOT NULL AUTO_INCREMENT,
					user_id varchar(100) ,
					username varchar(255),
					ip varchar(100) ,
					agent varchar(100) ,
					refer varchar(100) ,
					event varchar(255) DEFAULT 'login',
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					PRIMARY KEY  (id)
				);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


}

