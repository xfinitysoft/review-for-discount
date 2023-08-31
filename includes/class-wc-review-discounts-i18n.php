<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://xfinitysoft.com
 * @since      1.0.0
 *
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/includes
 * @author     Xfinity Soft <support@xfinitysoft.com>
 */
class XSRL_Review_Discounts_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function xsrl_load_plugin_textdomain() {

		load_plugin_textdomain(
			'wc-review-discounts',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
