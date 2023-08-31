<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://xfinitysoft.com
 * @since      1.0.1
 *
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/includes
 * @author     Xfinity Soft <support@xfinitysoft.com>
 */
class XSRL_Review_Discounts {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WC_Review_Discounts_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wc_review_discounts    The string used to uniquely identify this plugin.
	 */
	protected $wc_review_discounts;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WC_REVIEW_DISCOUNTS_VERSION' ) ) {
			$this->version = XSRL_REVIEW_DISCOUNTS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->wc_review_discounts = 'xs-revio-lite';

		$this->xsrl_load_dependencies();
		$this->xsrl_set_locale();
		$this->xsrl_define_admin_hooks();
		$this->xsrl_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WC_Review_Discounts_Loader. Orchestrates the hooks of the plugin.
	 * - WC_Review_Discounts_i18n. Defines internationalization functionality.
	 * - WC_Review_Discounts_Admin. Defines all hooks for the admin area.
	 * - WC_Review_Discounts_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function xsrl_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-review-discounts-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-review-discounts-i18n.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wc-review-discounts-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wc-review-discounts-public.php';

		$this->loader = new XSRL_Review_Discounts_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WC_Review_Discounts_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function xsrl_set_locale() {

		$plugin_i18n = new XSRL_Review_Discounts_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'xsrl_load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function xsrl_define_admin_hooks() {

		$plugin_admin = new XSRL_Review_Discounts_Admin( $this->xsrl_get_wc_review_discounts(), $this->xsrl_get_version() );
		$this->loader->add_action( 'admin_menu', $plugin_admin ,'xsrl_add_menu');
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'xsrl_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'xsrl_enqueue_scripts' );
		include_once(ABSPATH.'wp-admin/includes/plugin.php');
		if (!function_exists('is_plugin_active') || !is_plugin_active('wc-review-discounts/wc-review-discounts.php')) { 
			$this->loader->add_action( 'init', $plugin_admin, 'xsrl_inital_setting');
					$this->loader->add_action( 'add_meta_boxes',$plugin_admin,'xsrl_metabox',10,2);
			$this->loader->add_action( 'save_post',$plugin_admin,'xsrl_save_meta_data',10,3);
			$this->loader->add_filter( 'manage_xswc-review-discount_posts_columns',$plugin_admin, 'xsrl_review_discount_columns' );
			$this->loader->add_action( 'manage_xswc-review-discount_posts_custom_column' , $plugin_admin,'custom_xsrl_review_discount_column', 10, 2 );
			$this->loader->add_action( 'wp_ajax_send_test_email',$plugin_admin,'xsrl_send_test_email');
			$this->loader->add_action('wp_ajax_xs_send_mail',$plugin_admin,'xs_send_mail');
		}
		

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function xsrl_define_public_hooks() {

		$plugin_public = new XSRL_Review_Discounts_Public( $this->xsrl_get_wc_review_discounts(), $this->xsrl_get_version() );
		include_once(ABSPATH.'wp-admin/includes/plugin.php');
		if (!function_exists('is_plugin_active') || !is_plugin_active('wc-review-discounts/wc-review-discounts.php')) { 
			$this->loader->add_action( 'comment_post',  $plugin_public, 'xsrl_after_review_email', 10, 3);
			$this->loader->add_action('woocommerce_thankyou', $plugin_public, 'xsrl_after_order_email', 10, 1);
		}


	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function xsrl_run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function xsrl_get_wc_review_discounts() {
		return $this->wc_review_discounts;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WC_Review_Discounts_Loader    Orchestrates the hooks of the plugin.
	 */
	public function xsrl_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function xsrl_get_version() {
		return $this->version;
	}

}
