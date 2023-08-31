<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://xfinitysoft.com
 * @since             1.0.3
 * @package           WC_Review_Discounts
 *
 * @wordpress-plugin
 * Plugin Name:       Review for Discount
 * Description:       <code><strong>Review for Discount</strong></code>allows you both to increase the number of your store reviews and to increase the possibility that your customers make more purchases, by using a very powerful weapon: the discount. Offer a discount in exchange of a review and your users will buy more and more.
 * Version:           1.0.3
 * Author:            XfinitySoft
 * Author URI:        https://xfinitysoft.com/
 * Text Domain:       wc-review-discounts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'XSRL_REVIEW_DISCOUNTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-review-discounts-activator.php
 */
function xsrl_activate_wc_review_discounts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-review-discounts-activator.php';
	if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( __( 'Please install and activate WooCommerce to use Woocommerce Review for Discounts.', 'wc-review-discounts' ), 'Plugin dependency check', array( 'back_link' => true ) );
    }
	XSRL_Review_Discounts_Activator::xsrl_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-review-discounts-deactivator.php
 */
function xsrl_deactivate_wc_review_discounts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-review-discounts-deactivator.php';
	XSRL_Review_Discounts_Deactivator::xsrl_deactivate();
}

register_activation_hook( __FILE__, 'xsrl_activate_wc_review_discounts' );
register_deactivation_hook( __FILE__, 'xsrl_deactivate_wc_review_discounts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-review-discounts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function xsrl_run_wc_review_discounts() {

	$plugin = new XSRL_Review_Discounts();
	$plugin->xsrl_run();
	

}
xsrl_run_wc_review_discounts();
