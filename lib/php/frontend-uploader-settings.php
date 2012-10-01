<?php
/**
 *
 */

class Frontend_Uploader_Settings {

	private $settings_api;

	function __construct() {
		$this->settings_api = new WeDevs_Settings_API;

		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );

	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();
	}

	function admin_menu() {
		add_options_page( __( 'Frontend Uploader Settings', 'frontend-uploader' ) , __( 'Frontend Uploader Settings', 'frontend-uploader' ), 'manage_options', 'fu_settings', array( $this, 'plugin_page' ) );
	}

	function get_settings_sections() {
		$sections = array(
			array(
				'id' => 'basic_settings',
				'title' => __( 'Basic Settings', 'frontend-uploader' ),
			),
		);
		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {
		$settings_fields = array(
			'basic_settings' => array(
				array(
					'name' => 'notify_admin',
					'label' => __( 'Notify site admins', 'frontend-uploader' ),
					'desc' => __( 'Yes', 'frontend-uploader' ),
					'type' => 'checkbox'
				),
				array(
					'name' => 'admin_notification',
					'label' => __( 'Admin Notification', 'frontend-uploader' ),
					'desc' => __( 'Message that admin will get on new file upload', 'frontend-uploader' ),
					'type' => 'textarea'
				),
			),
		);

		return $settings_fields;
	}

	function plugin_page() {
		echo '<div class="wrap">';
		settings_errors();

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
		$pages = get_pages();
		$pages_options = array();
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[$page->ID] = $page->post_title;
			}
		}

		return $pages_options;
	}

}

$frontend_uploader_settings = new Frontend_Uploader_Settings;