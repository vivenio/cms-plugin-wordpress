<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.vivenio.de
 * @since             1.0.0
 * @package           Vivenio_Integration
 *
 * @wordpress-plugin
 * Plugin Name:       Vivenio Integration
 * Plugin URI:        https://www.vivenio.de
 * Description:       Adds the vivenio event registration to your wordpress page.
 * Version:           1.0.0
 * Author:            Vivenio Team
 * Author URI:        https://www.vivenio.de/de/impressum.html
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vivenio-integration
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
define( 'VIVENIO_INTEGRATION_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vivenio-integration-activator.php
 */
function activate_vivenio_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vivenio-integration-activator.php';
	Vivenio_Integration_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vivenio-integration-deactivator.php
 */
function deactivate_vivenio_integration() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vivenio-integration-deactivator.php';
	Vivenio_Integration_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vivenio_integration' );
register_deactivation_hook( __FILE__, 'deactivate_vivenio_integration' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vivenio-integration.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vivenio_integration() {

	$plugin = new Vivenio_Integration();
	$plugin->run();

}
run_vivenio_integration();
