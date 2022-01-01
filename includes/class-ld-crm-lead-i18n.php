<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://google.com
 * @since      1.0.0
 *
 * @package    Ld_Crm_Lead
 * @subpackage Ld_Crm_Lead/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ld_Crm_Lead
 * @subpackage Ld_Crm_Lead/includes
 * @author     Lovedeep <Lovedeep5.abh@gmail.com>
 */
class Ld_Crm_Lead_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ld-crm-lead',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
