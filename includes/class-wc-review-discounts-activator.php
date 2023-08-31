<?php

/**
 * Fired during plugin activation
 *
 * @link       https://xfinitysoft.com
 * @since      1.0.0
 *
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/includes
 * @author     Xfinity Soft <support@xfinitysoft.com>
 */
class XSRL_Review_Discounts_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function xsrl_activate() {
        $default_settings = Array(
            'enable' => 'on',
            'send_coupons' => '2',
            'delete_auto_coupons' => 'on',
            'single_email_type' => '1',
            'single_email_subject' => 'You have received a coupon from {site_title}',
            'single_email_content' =>"Hi {customer_name},\nwith the latest review you have written {total_reviews} reviews!\nBecause of this, we would like to offer you this coupon as a little gift:\n\n{coupon_description}\n\nSee you on our shop,\n \n {site_title}.",
            'single_email_test' => '',
            'multi_email_type' => '1',
            'multi_email_subject' => 'You have received a coupon from {site_title}',
            'multi_email_content' => "Hi {customer_name},\nwith the latest review you have written {total_reviews} reviews!\nBecause of this, we would like to offer you this coupon as a little gift:\n\n{coupon_description}\n\nSee you on our shop,\n \n {site_title}.",
            'multi_email_test' => '',
            'target_email_type' => '1',
            'target_email_subject' => 'You are getting near to an important goal on {site_title}',
            'target_email_content' => "Hi {customer_name},\nyou need still {remaining_reviews} reviews and you will get a coupon for our shop!\n\nSee you on our shop,\n\n{site_title}.",
            'target_email_test' => '',
        );
        $settings  = get_option('xsrl_settings',array());
        if(empty($settings)){
            update_option('xsrl_settings',$default_settings);
        }
	}

}
