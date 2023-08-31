<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://xfinitysoft.com
 * @since      1.0.0
 *
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/public
 * @author     Xfinity Soft <support@xfinitysoft.com>
 */
class XSRL_Review_Discounts_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wc_review_discounts    The ID of this plugin.
	 */
	private $wc_review_discounts;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wc_review_discounts       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wc_review_discounts, $version ) {

		$this->wc_review_discounts = $wc_review_discounts;
		$this->version = $version;

	}

    /**
    *
    *
    *
    */
    public function xsrl_after_review_email( $comment_ID, $comment_approved,$comment_data ) {
        $option = get_option('xsrl_settings',true);
        if(isset($option['enable']) && $option['enable'] == 'on' && $comment_data['comment_type'] == 'review'){
            if(isset($option['send_coupons']) && $option['send_coupons'] == 1 && $comment_approved == 1){
               $this->xsrl_send_email($comment_data);
            }else{
               $this->xsrl_send_email($comment_data);
            }
        }
        
    }
    /**
    *
    *
    *
    */
    public function xsrl_send_email($data){
        
        $posts = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type'      => 'xswc-review-discount',
                'post_status'    => 'publish',
                'fields' => 'ids',
            )
        );
        $args = array(
            'post_id' => $data['comment_post_ID'],
            'user_id' => $data['user_id'],
            'count'   => true, 
        );
        $comments_count = get_comments( $args );

        if($comments_count!=1){
            return;
        }
        if(empty($posts)){
            return;
        }
        $count = get_user_meta($data['user_id'] ,'xswcrd_review_count',true);
        if(empty($count)){
            $count = 0;
        }
        $count++;
        update_user_meta($data['user_id'] ,'xswcrd_review_count',$count);
        $option = get_option('xsrl_settings',true);
        $product_id = $data['comment_post_ID'];
        $user_info = get_userdata($data['user_id']);
        $name = $data['comment_author'];
        if($user_info->first_name){
            $name = $user_info->first_name;
        }else{
           $name  = $user_info->user_login;
        }

        $last_name = $user_info->last_name;
        $email = $data['comment_author_email'];
        
       
        $rules = array();
        foreach ($posts as $post_id){
            $discount_meta = get_post_meta($post_id,'xswcrd_options',true);
            if($discount_meta['trigger_event'] == 'single'){
                if(empty($discount_meta['trigger_product'])){
                   $rules[$post_id] = $discount_meta; 
                }
                if(!empty($discount_meta['trigger_product']) && in_array($product_id,$discount_meta['trigger_product'])){
                    $rules[$post_id] = $discount_meta;
                }
            }

            
        }
        if(empty($rules)){
            return;
        }
        foreach ($rules as $rule) {
            /**
            * Create a coupon programatically
            */
            $remain_qty = 0;
            $coupon_description = '';
            $product = '';
            $to = $email;
            $coupon_code = $name.'-'.md5(uniqid(rand(), true)); // Code
            $amount = $rule['coupon_amount']; // Amount
            if($rule['discount_type'] == 1){
                $discount_type = 'percent';
            }
            if($rule['discount_type'] == 2){
                $discount_type = 'fixed_cart';
            }
            if($rule['discount_type'] == 3){
                $discount_type = 'fixed_product';
            }
            if(isset($rule['valid_days']) && !empty($rule['valid_days'])){
                $days = '+'.$rule['valid_days'].' days';
            }
            $expDate = date('Y-m-d', strtotime($days));
            global $woocommerce;
            $coupon = new WC_Coupon();
            $coupon->set_code( $coupon_code );
            $coupon->set_description($rule['coupon_des']);
            $coupon->set_amount($rule['coupon_amount']);
            $coupon->set_discount_type( $discount_type );
            $coupon->set_date_expires($expDate);
            $coupon->set_usage_limit( 1 );
            if(isset($rule['single_use']) && $rule['single_use'] == 'yes'){
                $coupon->set_individual_use( true );
            }
            
            if(isset($rule['trigger_product']) && !empty($rule['products'])){
               $coupon->set_product_ids($rule['trigger_product']);
            }

            if(isset($rule['ex_products']) && !empty($rule['ex_products'])){
                $coupon->set_excluded_product_ids($rule['ex_products']);
            }

            if(isset($rule['category']) && !empty($rule['category'])){
                $coupon->set_product_categories($rule['category']);
            }
            if(isset($rule['ex_category']) && !empty($rule['ex_category'])){
                $coupon->set_excluded_product_categories($rule['ex_category']);
            }

            if(isset($rule['min_amount']) && !empty($rule['min_amount'])){
                $coupon->set_minimum_amount($rule['min_amount']);
            }

            if(isset($rule['max_amount']) && !empty($rule['max_amount'])){
                $coupon->set_maximum_amount($rule['max_amount']);
            }
            
            if(isset($rule['free_shipping']) && $rule['free_shipping'] == 'yes'){
                $coupon->set_free_shipping(true);
            }
            if(isset($rule['exclude_sale_items']) && $rule['exclude_sale_items'] == 'yes'){
                $coupon->set_exclude_sale_items(true);
            }
            $coupon->save();
            $coupon_description  = '<h2 style="color:#557da1; display:block; font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:18px; font-weight:bold; line-height:130%; margin:0 0 18px; text-align:left" >Coupon code:'.$coupon->get_code().'</h2>';
            $coupon_description .= '<p style="margin:0 0 16px"><i><br>'.$coupon->get_description().'</i></p>';
            if($coupon->discount_type = 'percent'){
                $coupon_description .= '<p style="margin:0 0 16px"><b><br>Coupon amount:'.$coupon->get_amount().' % off</b></p>';
            }else{
                $coupon_description .= '<p style="margin:0 0 16px"><b><br>Coupon amount:'.$coupon->get_amount().$coupon->get_discount_type().'off</b></p>';
            }
            
            $coupon_description .= '<p style="margin:0 0 16px"><b><br>Expiration date:'.date('F d, Y', strtotime($coupon->get_date_expires())).'</b></p>';
            $content = '<p style="margin:0 0 16px">'.nl2br($option['single_email_content']).'</p>';
            $content = preg_replace('#(?:<br\s*/?>\s*?){2,}#','</p><p style="margin:0 0 16px">',$content);
            $product = '<a href="'.get_permalink($product_id).'" >'.get_the_title($product_id).'</a>';
            $content = str_replace(
                array(
                    '{site_title}',
                    '{customer_name}',
                    '{customer_last_name}',
                    '{customer_email}',
                    '{product_name}',
                    '{coupon_description}',
                    '{total_reviews}',
                    '{remaining_reviews}',
                ),
                array(
                    get_bloginfo('name'),
                    $name,
                    $last_name,
                    $email,
                    $product,
                    $coupon_description,
                    $rule['request_qty'],
                    $remain_qty,

                ),
                $content
            );

            $subject = nl2br($option['single_email_subject']);
            $subject=str_replace(
                array(
                    '{site_title}',
                    '{customer_name}',
                    '{customer_last_name}',
                ),
                array(
                    get_bloginfo( 'name' ),
                    $name,
                    $last_name,
                ),
                $subject
            );
            $body ='<html lang="en-US">
                        <head>
                            <meta charset="utf-8">
                            <meta http-equiv="X-UA-Compatible" content="IE=edge">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no maximum-scale=1.0, user-scalable=no"/>
                            <title>'.get_bloginfo('name').'</title>
                        </head>
                        <body>
                            <table cellpadding="0" cellspacing="0" width="600" style="background-color: #fdfdfd;border: 1px solid #dcdcdc;border-radius: 3px; margin: auto;">
                                <thead style="background-color:#2FBB1C; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%;vertical-align: middle; border-radius: 3px 3px 0 0;">
                                    <tr>
                                        <td style="padding: 36px 48px; display: block; margin: 0">
                                            <h1 style=" font-family: Open Sans, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%;margin: 0;text-align: left;color: #ffffff;background-color: inherit;">'.$subject.'</h1>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td valign="top" style="padding:48px 48px 32px">
                                          <div style="color:#737373;font-family: Open Sans, sans-serif;font-size:14px;line-height:150%;text-align:left">
                                           '.$content.'
                                          </div>
                                        </td>
                                     </tr>
                                </tbody>
                            </table>
                        </body>
                    </html>';
            
            $headers = array( 'Content-Type: text/html; charset=UTF-8' );
            $mail = wp_mail( $to, $subject, $body, $headers,array( '' ));
            if($mail){
            }else{
                return;
            }  
        }
    }

    public function xsrl_after_order_email($order_get_id){
        $option = get_option('xsrl_settings',true);
        $order = wc_get_order($order_get_id );
        $order_data = $order->get_data();
        $user_info  = $order->get_user();
        if(isset($order_data['billing']['first_name'])){
            $name = $order_data['billing']['first_name'];
        }else{
           $name  = $user_info->user_login;
        }
        $last_name = $order_data['billing']['last_name'];
        $email = $order_data['billing']['email'];
        $posts = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type'      => 'xswc-review-discount',
                'post_status'    => 'publish',
                'fields' => 'ids',
            )
        );
        $rules = array();
        foreach ($order->get_items() as $item_key => $item ){
            $product_id   = $item->get_product_id();
            foreach ($posts as $post_id){
                $discount_meta = get_post_meta($post_id,'xswcrd_options',true);
                if($discount_meta['trigger_event'] == 'single'){
                    if(empty($discount_meta['trigger_product'])){
                        $rules[$post_id] = $discount_meta; 
                    }
                    if(!empty($discount_meta['trigger_product']) && in_array($product_id,$discount_meta['trigger_product'])){
                        $rules[$post_id] = $discount_meta;
                    }
                }   
            }
        }
        if(empty($rules)){
            return;
        }
        $to = $email;
        $content = '<p style="margin:0 0 16px">'.nl2br($option['buy_email_content']).'</p>';
        $content = preg_replace('#(?:<br\s*/?>\s*?){2,}#','</p><p style="margin:0 0 16px">',$content);
        $content = str_replace(
            array(
                '{site_title}',
                '{customer_name}',
                '{customer_last_name}',
                '{customer_email}',
            ),
            array(
                get_bloginfo('name'),
                $name,
                $last_name,
                $email,

            ),
            $content
        );

        $subject = nl2br($option['buy_email_subject']);
        $subject=str_replace(
            array(
                '{site_title}',
                '{customer_name}',
                '{customer_last_name}',
            ),
            array(
                get_bloginfo( 'name' ),
                $name,
                $last_name,
            ),
            $subject
        );
        $body ='<html lang="en-US">
                    <head>
                        <meta charset="utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no maximum-scale=1.0, user-scalable=no"/>
                        <title>'.get_bloginfo('name').'</title>
                    </head>
                    <body>
                        <table cellpadding="0" cellspacing="0" width="600" style="background-color: #fdfdfd;border: 1px solid #dcdcdc;border-radius: 3px; margin: auto;">
                            <thead style="background-color:#2FBB1C; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%;vertical-align: middle; border-radius: 3px 3px 0 0;">
                                <tr>
                                    <td style="padding: 36px 48px; display: block; margin: 0">
                                        <h1 style=" font-family: Open Sans, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%;margin: 0;text-align: left;color: #ffffff;background-color: inherit;">'.$subject.'</h1>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding:48px 48px 32px">
                                      <div style="color:#737373;font-family: Open Sans, sans-serif;font-size:14px;line-height:150%;text-align:left">
                                       '.$content.'
                                      </div>
                                    </td>
                                 </tr>
                            </tbody>
                        </table>
                    </body>
                </html>';
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        $mail = wp_mail( $to, $subject, $body, $headers);
        if($mail){
        }else{
            return;
        }
    }
}
