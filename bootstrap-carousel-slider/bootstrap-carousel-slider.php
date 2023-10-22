<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://sakhawat.vercel.app
 * @since             1.0.0
 * @package           Bootstrap_Carousel_Slider
 *
 * @wordpress-plugin
 * Plugin Name:       Bootstrap Carousel Slider
 * Plugin URI:        https://sakhawat.vercel.app
 * Description:       Bootstrap carousel slider for WordPress plugin.
 * Version:           1.0.0
 * Author:            SH Shakib
 * Author URI:        https://sakhawat.vercel.app/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bootstrap-carousel-slider
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
define( 'BOOTSTRAP_CAROUSEL_SLIDER_VERSION', '1.0.0' );
define( 'BOOTSTRAP_CAROUSEL_PATH', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bootstrap-carousel-slider-activator.php
 */
function activate_bootstrap_carousel_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bootstrap-carousel-slider-activator.php';
	Bootstrap_Carousel_Slider_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bootstrap-carousel-slider-deactivator.php
 */
function deactivate_bootstrap_carousel_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bootstrap-carousel-slider-deactivator.php';
	Bootstrap_Carousel_Slider_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bootstrap_carousel_slider' );
register_deactivation_hook( __FILE__, 'deactivate_bootstrap_carousel_slider' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bootstrap-carousel-slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bootstrap_carousel_slider() {

	$plugin = new Bootstrap_Carousel_Slider();
	$plugin->run();

}
run_bootstrap_carousel_slider();
