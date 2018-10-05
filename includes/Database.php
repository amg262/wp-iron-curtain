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

		add_action( 'admin_init', [ $this, 'upgrade_data' ] );
//
		//register_activation_hook( __FILE__, [ $this, 'upgrade_data' ] );
//		add_action( 'admin_init', [ $this, 'upgrade_data' ] );
		//add_action( 'admin_init', [ $this, 'install_data' ] );
//		add_action( 'admin_init', [ $this, 'delete_db' ] );
	}


	/**
	 *
	 */
	function insert_login( $data ) {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wp_irc_login';

// Write to default log

// Write to another log
		//define("UPLOAD_LOG", "/afs/ir/your-home-directory/logs/upload.log");
		//$result = $this->write_log("User attempted to send file larger than 2 megabytes", UPLOAD_LOG);
		/**
		 * Define the array of defaults
		 */
		$defaults = [
			'event' => 'login',
			'user'  => '',
			'agent' => '',

		];
		/**
		 * Parse incoming $args into an array and merge it with $defaults
		 */
		$args = wp_parse_args( $data, $defaults );


		$wpdb->insert( $table_name, [
			'event'  => $args['event'],
			'user'   => json_encode( $args['user'] ),
			'time'   => current_time( 'mysql' ),
			'active' => - 1,
		] );


	}

	/**
	 * write_log($message[, $logfile])
	 *
	 * Author(s): thanosb, ddonahue
	 * Date: May 11, 2008
	 *
	 * Writes the values of certain variables along with a message in a log file.
	 *
	 * Parameters:
	 *  $message:   Message to be logged
	 *  $logfile:   Path of log file to write to.  Optional.  Default is DEFAULT_LOG.
	 *
	 * Returns array:
	 *  $result[status]:   True on success, false on failure
	 *  $result[message]:  Error message
	 */


// Filename of log to use when none is given to write_log

	/**
	 *
	 */
	function drop_tbl() {

		global $wpdb;

		$table_name = $wpdb->prefix . 'wp_irc';

		//$q = "SELECT * FROM " . $table_name . " WHERE id > 0  ;";
		$wpdb->query( "DROP TABLE IF EXISTS $table_name ;" );
	}

	function query() {

		global $wpdb;
		$table_name = $wpdb->prefix . 'wp_irc_login';

		$sql = "SELECT * FROM $table_name ;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		return dbDelta( $sql );
	}

	/**
	 *
	 */
	function create_tbl() {

		global $wpdb;
		$table_name = $wpdb->prefix . 'wp_irc_login';

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
					id int(11) NOT NULL AUTO_INCREMENT,
					user longtext ,
					agent longtext ,
					event varchar(255) DEFAULT 'login',
					active tinyint(1) DEFAULT -1,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					PRIMARY KEY  (id)
				);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	public function upgrade_data() {

		global $wpdb;
		$tbl = $wpdb->prefix . 'wp_irc_login';
		$sql = "CREATE TABLE IF NOT EXISTS $tbl (
					id int(11) NOT NULL AUTO_INCREMENT,
					post_id int(11),
					type varchar(255),
					data text ,
					time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
					active tinyint(1) DEFAULT -1,
					PRIMARY KEY  (id)
				);";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


}

