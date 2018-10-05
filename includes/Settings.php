<?php

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */

namespace Netraa\WPIRC;

use WP_Post;

class Settings {

	private $settings_api;

	function __construct() {

		$this->settings_api = new \Netraa\WPIRC\SettingsAPI();

		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();

		//var_dump( get_option( 'wpirc_basics' ) );
	}

	function get_settings_sections() {

		$sections = [
			[
				'id'    => 'wp_irc_settings',
				'title' => __( 'Basic Settings', 'wpirc' ),
			],
			[
				'id'    => 'wp_irc_logins',
				'title' => __( 'Advanced Settings', 'wpirc' ),
			],
			[
				'id'    => 'wcb_others',
				'title' => __( 'Other Settings', 'wpuf' ),
			],
		];

		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		foreach ( get_post_types() as $type ) {

			//echo json_encode( $type );
		}

		$args = [
			'posts_per_page'   => - 1,
			'post_type'        => 'part',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		];

		$posts_array = get_posts( $args );

		foreach ( $posts_array as $post ) {
			$post  = new WP_Post( $post );
			$arr[] = [ $post->post_title => $post->post_title ];
		}


		require __DIR__ . '/Database.php';

		$db              = new Database();
		$set             = $db->query();
		echo json_encode( $set ),

		$settings_fields = [
			'wp_irc_settings' => [

				[
					'name'              => 'failed_logins',
					'label'             => __( 'Failed Logins for Ban', 'wpirc' ),
					'desc'              => __( 'Number field with validation callback `intval`', 'wpirc' ),
					'type'              => 'number',
					'default'           => 'Title',
					'sanitize_callback' => 'intval',
				],
				[
					'name'  => 'Warning Text',
					'label' => __( 'Login Warning Text', 'wpirc' ),
					'desc'  => __( 'Textarea description', 'wpirc' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'Day No. Parameter',
					'label' => __( 'Day No. Parameter', 'wpirc' ),
					'desc'  => __( 'Checkbox Label', 'wpirc' ),
					'type'  => 'checkbox',
				],

				[
					'name'  => 'Secret Key',
					'label' => __( 'Secret Key', 'wpirc' ),
					'desc'  => __( 'Checkbox Label', 'wpirc' ),
					'type'  => 'checkbox',
				],
				[
					'name'  => 'Enable Cloak on Log Out',
					'label' => __( 'Secret Key', 'wpirc' ),
					'desc'  => __( 'Checkbox Label', 'wpirc' ),
					'type'  => 'checkbox',
				],
				[
					'name'              => 'Secret Parameter',
					'label'             => __( 'Secret Key ', 'wpirc' ),
					'desc'              => __( '&sk=*this-field*', 'wpirc' ),
					'type'              => 'text',
					'default'           => '',
					'sanitize_callback' => 'intval',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'wpirc' ),
					'desc'    => __( 'A radio button', 'wpirc' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'wpirc' ),
					'desc'    => __( 'Multi checkbox description', 'wpirc' ),
					'type'    => 'multicheck',
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wpirc' ),
					'desc'    => __( 'Dropdown description', 'wpirc' ),
					'type'    => 'select',
					'default' => 'no',
					'options' => [
						//json_encode( $arr )
						//'yes' => 'Yes',
						//'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wpirc' ),
					'desc'    => __( 'Password description', 'wpirc' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'wpirc' ),
					'desc'    => __( 'File description', 'wpirc' ),
					'type'    => 'file',
					'default' => '',
					'options' => [
						'button_label' => 'Choose Image',
					],
				],

				[
					'name'    => 'color',
					'label'   => __( 'Color', 'wpirc' ),
					'desc'    => __( 'Color description', 'wpirc' ),
					'type'    => 'color',
					'default' => '',
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wpirc' ),
					'desc'    => __( 'Password description', 'wpirc' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'wysiwyg',
					'label'   => __( 'Advanced Editor', 'wpirc' ),
					'desc'    => __( 'WP_Editor description', 'wpirc' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'wpirc' ),
					'desc'    => __( 'Multi checkbox description', 'wpirc' ),
					'type'    => 'multicheck',
					'default' => [ 'one' => 'one', 'four' => 'four' ],
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wpirc' ),
					'desc'    => __( 'Dropdown description', 'wpirc' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wpirc' ),
					'desc'    => __( 'Password description', 'wpirc' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'wpirc' ),
					'desc'    => __( 'File description', 'wpirc' ),
					'type'    => 'file',
					'default' => '',
				],
				[
					'name'    => 'text',
					'label'   => __( 'Text Input', 'wpirc' ),
					'desc'    => __( 'Text input description', 'wpirc' ),
					'type'    => 'text',
					'default' => 'Title',
				],
				[
					'name'  => 'textarea',
					'label' => __( 'Textarea Input', 'wpirc' ),
					'desc'  => __( 'Textarea description', 'wpirc' ),
					'type'  => 'textarea',
				],
				[
					'name'  => 'checkbox',
					'label' => __( 'Checkbox', 'wpirc' ),
					'desc'  => __( 'Checkbox Label', 'wpirc' ),
					'type'  => 'checkbox',
				],
				[
					'name'    => 'radio',
					'label'   => __( 'Radio Button', 'wpirc' ),
					'desc'    => __( 'A radio button', 'wpirc' ),
					'type'    => 'radio',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'multicheck',
					'label'   => __( 'Multile checkbox', 'wpirc' ),
					'desc'    => __( 'Multi checkbox description', 'wpirc' ),
					'type'    => 'multicheck',
					'options' => [
						'one'   => 'One',
						'two'   => 'Two',
						'three' => 'Three',
						'four'  => 'Four',
					],
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wpirc' ),
					'desc'    => __( 'Dropdown description', 'wpirc' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'password',
					'label'   => __( 'Password', 'wpirc' ),
					'desc'    => __( 'Password description', 'wpirc' ),
					'type'    => 'password',
					'default' => '',
				],
				[
					'name'    => 'file',
					'label'   => __( 'File', 'wpirc' ),
					'desc'    => __( 'File description', 'wpirc' ),
					'type'    => 'file',
					'default' => '',
				],
			],
			'wp_irc_logins'   => [

			],
		];

		return $settings_fields;
	}

	function admin_menu() {

		echo '';
		add_options_page( 'Iron Curtain', 'Iron Curtain', 'manage_options', 'wp-irc-settings', [
			$this,
			'plugin_page',
		] );
	}

	function plugin_page() {

		echo '<div class="wrap">';

		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();

		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {

		$pages         = get_pages();
		$pages_options = [];
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}

		return $pages_options;
	}

}
