<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://sakhawat.vercel.app
 * @since      1.0.0
 *
 * @package    Bootstrap_Carousel_Slider
 * @subpackage Bootstrap_Carousel_Slider/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Bootstrap_Carousel_Slider
 * @subpackage Bootstrap_Carousel_Slider/includes
 * @author     SH Shakib <imshshakib2001@gmail.com>
 */
class Bootstrap_Carousel_Slider_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		delete_option( );
	}

}
