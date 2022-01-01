<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://google.com
 * @since             1.0.0
 * @package           Ld_Crm_Lead
 *
 * @wordpress-plugin
 * Plugin Name:       CRM LEAD
 * Plugin URI:        https://google.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Lovedeep
 * Author URI:        https://google.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ld-crm-lead
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'LD_CRM_LEAD_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ld-crm-lead-activator.php
 */
function activate_ld_crm_lead() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ld-crm-lead-activator.php';
	Ld_Crm_Lead_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ld-crm-lead-deactivator.php
 */
function deactivate_ld_crm_lead() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ld-crm-lead-deactivator.php';
	Ld_Crm_Lead_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ld_crm_lead' );
register_deactivation_hook( __FILE__, 'deactivate_ld_crm_lead' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ld-crm-lead.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ld_crm_lead() {

	$plugin = new Ld_Crm_Lead();
	$plugin->run();

}
run_ld_crm_lead();
