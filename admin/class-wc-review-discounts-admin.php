<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://xfinitysoft.com
 * @since      1.0.0
 *
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/admin
 * @author     Xfinity Soft <support@xfinitysoft.com>
 */
class XSRL_Review_Discounts_Admin {

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
	 * @param      string    $wc_review_discounts       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wc_review_discounts, $version ) {

		$this->wc_review_discounts = $wc_review_discounts;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function xsrl_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WC_Review_Discounts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WC_Review_Discounts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        $post_type = sanitize_text_field(isset($_GET['post_type']) ? $_GET['post_type'] :'');
        $page = sanitize_text_field(isset($_GET['page'])?$_GET['page']:'');
        if(isset($_GET['post'])){
            $post_id = sanitize_text_field(isset($_GET['post']) ? $_GET['post']: '');
            $post_type = get_post_type($post_id);
        }
        if($post_type == 'xswc-review-discount' || $page == 'xsrl_review_discount' || $page == 'xsrs_review_discount' ){
            wp_enqueue_style( 'select2', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
            wp_enqueue_style('woocommerce-admin-styles',plugins_url( "woocommerce/assets/css/admin.css" ));
            wp_enqueue_style( $this->wc_review_discounts, plugin_dir_url( __FILE__ ) . 'css/wc-review-discounts-admin.css', array(), $this->version, 'all' );
        }
		

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function xsrl_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WC_Review_Discounts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WC_Review_Discounts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
        $post_type = sanitize_text_field(isset($_GET['post_type']) ? $_GET['post_type'] :'');
        $page = sanitize_text_field(isset($_GET['page'])?$_GET['page']:'');
        if(isset($_GET['post'])){
            $post_id = sanitize_text_field(isset($_GET['post']) ? $_GET['post']: '');
            $post_type = get_post_type($post_id);
        }
        if($post_type == 'xswc-review-discount' || $page == 'xsrl_review_discount' || $page == 'xsrs_review_discount'){
           
            wp_enqueue_script('select2', plugin_dir_url( __FILE__ ) . 'js/select2.full.min.js', array( 'jquery' ), $this->version, true );
            wp_enqueue_script( $this->wc_review_discounts, plugin_dir_url( __FILE__ ) . 'js/wc-review-discounts-admin.js', array( 'jquery','wp-color-picker'), $this->version, true);
        }

	}

    public function xsrl_add_menu(){
        include_once(ABSPATH.'wp-admin/includes/plugin.php');
        if (!function_exists('is_plugin_active') || !is_plugin_active('wc-review-discounts/wc-review-discounts.php')) { 
            add_submenu_page(
                'edit.php?post_type=xswc-review-discount',
                __( 'Settings', 'wc-review-discounts' ),
                __( 'Settings', 'wc-review-discounts' ),
                'manage_options',
                'xsrl_review_discount',
                array($this,'xsrl_setting_callback')
            );
            add_submenu_page(
                'edit.php?post_type=xswc-review-discount',
                __( 'Support', 'wc-review-discounts' ),
                __( 'Support', 'wc-review-discounts' ),
                'manage_options',
                'xsrs_review_discount',
                array($this,'xsrl_support_callback')
            );
        }
    }

    /**
    * Display settings page
    * @since    1.0.0
    */
    public function xsrl_setting_callback(){
        include_once plugin_dir_path( __FILE__ ) . 'partials/wc-review-discounts-admin-display.php';
    }

    public function xsrl_support_callback(){
        include_once plugin_dir_path( __FILE__ ) . 'partials/wc-review-discounts-support.php';
    }

    /**
    * initial setting and register post type
    * @since    1.0.0
    */
    public function xsrl_inital_setting(){
        register_post_type( 'xswc-review-discount',
            array(
                'labels' => array(
                    'name'                  => esc_html__( 'Review Discounts', 'wc-review-discounts'),
                    'singular_name'         => esc_html__( 'Review Discount', 'wc-review-discounts'),
                    'menu_name'             => _x( 'Review Discounts', 'Admin menu name', 'wc-review-discounts' ),
                    'all_items'             => __( 'Review Discounts', 'wc-review-discounts' ),
                    'add_new'               => __( 'Add Review Discount', 'wc-review-discounts' ),
                    'add_new_item'          => __( 'Add Review Discount', 'wc-review-discounts' ),
                    'edit'                  => __( 'Edit', 'wc-review-discounts' ),
                    'edit_item'             => __( 'Edit Review Discount', 'wc-review-discounts' ),
                    'new_item'              => __( 'Add Review Discount', 'wc-review-discounts' ),
                    'search_items'          => __( 'Search Review Discount', 'wc-review-discounts' ),
                    'not_found'             => esc_html__('No Review Discount found', 'wc-review-discounts'),
                    'not_found_in_trash'    => esc_html__('No Review Discount found in trash', 'wc-review-discounts'),
                ),
                'public'                => true,
                'supports'              => array('title'),
                'show_ui'               => true,
                'capability_type'       => 'post',
                'show_in_menu'          => true,
                'menu_icon'             => 'dashicons-awards',
                'map_meta_cap'          => true,
                'publicly_queryable'    => true,
                'exclude_from_search'   => false,
                'hierarchical'          => false,
                'rewrite'               => array('slug' => 'xswc-review-discount', 'with_front' => true),
                'query_var'             => false,
                'has_archive'           => 'false',
     
            )
        );
        register_setting( 'xsrl_settings', 'xsrl_settings');
        register_setting( 'xsrl_sendgrid','xsrl_sendgrid');
    }
     /**
    * add meta box in button post type
    * @param string post_type, object post
    * @return null
    */
    public function xsrl_metabox($post_type, $post){
        if($post_type=="xswc-review-discount"){
            add_meta_box( 
                'xswcrd_metabox',
                __('Discount Options', 'wc-review-discounts'),
                array($this,'xsrl_render_meta_box'),
                $post_type,
                'normal',
                'default'
            );
        }
    }
 
    /**
    * Render  meta box
    * @param null
    * @return Null
    */
    public function xsrl_render_meta_box(){
        $ids = get_posts( array(
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'post_type' => 'product',
            'fields' => 'ids',
        ) );
        $cat_ids = get_terms( array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
        ) );
        global $post;
        $options = get_post_meta($post->ID,'xswcrd_options',true);
        include_once plugin_dir_path( __FILE__ ) . 'partials/wc-review-discounts-meta-box.php';
    }

    /**
    * Save post meta
    * @param int post_id
    * @return null
    */
    public function xsrl_save_meta_data($post_id){
        global $post;
        if (isset($_REQUEST['bulk_edit']))
            return;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
            return;
        }
        $xsrl_options = array();
        if(isset($_POST['xswcrd_options'])){
            foreach ($_POST['xswcrd_options'] as $key => $value) {
                if(is_array($value)){
                    $xsrl_options[$key] = array_map('sanitize_text_field', $value);
                }else{
                    $xsrl_options[$key] = sanitize_text_field($value);
                }
            }
        }
        if(!isset($xswcrd_options['trigger_product'])){
            $xswcrd_options['trigger_product'] = array();
        }
        if(!isset($xswcrd_options['trigger_category'])){
            $xswcrd_options['trigger_category'] = array();
        }
        update_post_meta($post_id,'xswcrd_options',$xsrl_options);
    }
    public function xsrl_review_discount_columns($columns){
        unset($columns['date']);
        $columns['description'] = esc_html__( 'Description', 'wc-review-discounts' );
        $columns['triggering'] = esc_html__( 'Triggering event', 'wc-review-discounts' );
        $columns['date'] =__('Date','wc-review-discounts');

        return $columns;
    } 
    public function custom_xsrl_review_discount_column($column, $post_id){
        $option = get_post_meta($post_id,'xswcrd_options',true);
        switch ( $column ) {

            case 'description' :
                if(isset($option['coupon_des'])){
                    echo sanitize_text_field($option['coupon_des']);
                }
                
                break;

            case 'triggering' :
                $text ='';
                if(isset($option['trigger_event'])){
                   if($option['trigger_event'] == 'single'){
                        if(empty($option['trigger_product']) && empty($option['trigger_category'])){
                            $text = "Review of any product";
                        }
                        if(!empty($option['trigger_product'])){
                            $text = "Review of ".count($option['trigger_product']). "specific products \n";
                        }
                        if(!empty($option['trigger_category'])){
                            $text .="Review of any product of ".count($option['trigger_category'])." specific categories";
                        }
                    }else{
                        if(isset($option['request_qty']) && !empty($option['request_qty'])){
                            $text = $option['request_qty']." reviews written \n";
                        }
                        if(isset($option['send-notice']) && $option['send-notice'] == 'yes'){
                            $text .= "Send notifications after ".$option['initial_qty']." reviews";
                        }
                    } 
                }
                echo nl2br(sanitize_text_field($text));
                break;

        }
    }
    public function xsrl_send_test_email(){
        global $current_user; 
        wp_get_current_user();
        $option = get_option('xsrl_settings',true);
        $email_type = sanitize_text_field($_POST['id']);
        $email = sanitize_email($_POST['email']);
        $name = $current_user->display_name;
        /**
        * Create a coupon programatically
        */
        $coupon_code = $current_user->display_name.'-'.md5(uniqid(rand(), true)); // Code
        $amount = '10'; // Amount
        $discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product

        $coupon = array(
        'post_title' => $coupon_code,
        'post_content' => '10% discount on cart total',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type' => 'shop_coupon');

        $new_coupon_id = wp_insert_post( $coupon );
        $expDate = date('Y-m-d', strtotime('+30 days'));
        // Add meta
        $args = array(
            'posts_per_page'   => 1,
            'orderby'          => 'rand',
            'post_type'        => 'product',
            'post_status'    => 'publish'
        ); 

        $random_products = get_posts( $args );
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
        update_post_meta( $new_coupon_id, 'individual_use', 'no' );
        foreach ( $random_products as $post ){
            update_post_meta( $new_coupon_id, 'product_ids', $post->ID );
        } 
        update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
        update_post_meta( $new_coupon_id, 'usage_limit', '1' );
        update_post_meta( $new_coupon_id, 'expiry_date', $expDate);
        update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
        update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
        global $woocommerce;
        $coupon = new WC_Coupon(get_the_title($new_coupon_id));
        $coupon_description  = '<h2 style="color:#557da1; display:block; font-family:Helvetica Neue,Helvetica,Roboto,Arial,sans-serif;font-size:18px; font-weight:bold; line-height:130%; margin:0 0 18px; text-align:left" >Coupon code:'.get_the_title($new_coupon_id).'</h2>';
        $coupon_description .= '<p style="margin:0 0 16px"><i><br>'.$coupon->description.'</i></p>';
        if($coupon->discount_type = 'percent'){
            $coupon_description .= '<p style="margin:0 0 16px"><b><br>Coupon amount:'.$coupon->amount.' % off</b></p>';
        }else{
            $coupon_description .= '<p style="margin:0 0 16px"><b><br>Coupon amount:'.$coupon->amount.$coupon->discount_type.'off</b></p>';
        }
        
        $coupon_description .= '<p style="margin:0 0 16px"><b><br>Expiration date:'.date('F d, Y', strtotime($coupon->expiry_date)).'</b></p>';
        $to = $email;
        $content = '<p style="margin:0 0 16px">'.nl2br($option[$email_type.'_email_content']).'</p>';
        $content = preg_replace('#(?:<br\s*/?>\s*?){2,}#','</p><p style="margin:0 0 16px">',$content);
        
        foreach ( $random_products as $post ){
            $product = '<a href="'.get_permalink($post->ID).'" >'.get_the_title($post->ID).'</a>';
        } 
        $product;
        $content = str_replace(
            array(
                '{site_title}',
                '{customer_name}',
                '{product_name}',
                '{coupon_description}',
                '{total_reviews}',
                '{remaining_reviews}',
            ),
            array(
                get_bloginfo( 'name' ),
                $name,
                $product,
                $coupon_description,
                '10',
                '3'

            ),
            $content
        );
        $subject = nl2br($option[$email_type.'_email_subject']);
        $subject=str_replace(
            array(
                '{site_title}',
            ),
            array(
                get_bloginfo( 'name' ),
            ),
            $subject
        );
        $body ='<!DOCTYPE>
                <html lang="en-US">
                    <head>
                        <meta charset="utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="description" content="">
                        <meta name="author" content="">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no maximum-scale=1.0, user-scalable=no /" >
                        <title>Theme From Scratch</title>
                    </head>
                    <body>
                        <table cellpadding="0" cellspacing="0" width="600" style="background-color: #fdfdfd;border: 1px solid #dcdcdc;border-radius: 3px; margin: auto;">
                            <thead style="background-color:#2FBB1C; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%;vertical-align: middle; border-radius: 3px 3px 0 0;">
                                <tr>
                                    <td style="padding: 36px 48px; display: block; margin: 0">
                                        <h1 style=" font-family: '."'Open Sans'".', sans-serif; font-size: 30px; font-weight: 300; line-height: 150%;margin: 0;text-align: left;color: #ffffff;background-color: inherit;">'.$subject.'</h1>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td valign="top" style="padding:48px 48px 32px">
                                      <div style="color:#737373;font-family: '."'Open Sans'".', sans-serif;font-size:14px;line-height:150%;text-align:left">
                                       '.$content.'
                                      </div>
                                    </td>
                                 </tr>
                            </tbody>
                        </table>
                    </body>
                </html>';
        $headers = array( 'Content-Type: text/html; charset=UTF-8' );
        $mail = wp_mail( $to, $subject, $body, $headers, array( '' ) );
        if($mail){
            wp_send_json( array('status'=>1 , 'message' => 'Email sent successfully.'));
        }else{
            wp_send_json( array('status'=>0 , 'message' => 'Email not sent'));
        }
        
        wp_die(); 
    }

    public function xs_send_mail(){
        $data = array();
        parse_str($_POST['data'], $data);
        $data['plugin_name'] = 'WooCommerce Review for Discount';
        $data['version'] = 'lite';
        $data['website'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
        $to = 'xfinitysoft@gmail.com';
        switch ($data['type']) {
            case 'report':
                $subject = 'Report a bug';
                break;
            case 'hire':
                $subject = 'Hire us to customize/develope Plugin/Theme or WordPress projects';
                break;
            
            default:
                $subject = 'Request a Feature';
                break;
        }
        
        $body = '<html><body><table>';
        $body .='<tbody>';
        $body .='<tr><th>User Name</th><td>'.$data['xs_name'].'</td></tr>';
        $body .='<tr><th>User email</th><td>'.$data['xs_email'].'</td></tr>';
        $body .='<tr><th>Plugin Name</th><td>'.$data['plugin_name'].'</td></tr>';
        $body .='<tr><th>Version</th><td>'.$data['version'].'</td></tr>';
        $body .='<tr><th>Website</th><td><a href="'.$data['website'].'">'.$data['website'].'</a></td></tr>';
        $body .='<tr><th>Message</th><td>'.$data['xs_message'].'</td></tr>';
        $body .='</tbody>';
        $body .='</table></body></html>';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $params ="name=".$data['xs_name'];
        $params.="&email=".$data['xs_email'];
        $params.="&site=".$data['website'];
        $params.="&version=".$data['version'];
        $params.="&plugin_name=".$data['plugin_name'];
        $params.="&type=".$data['type'];
        $params.="&message=".$data['xs_message'];
        $sever_response = wp_remote_post("https://xfinitysoft.com/wp-json/plugin/v1/quote/save/?".$params);
        $se_api_response = json_decode( wp_remote_retrieve_body( $sever_response ), true );
        
        if($se_api_response['status']){
            $mail = wp_mail( $to, $subject, $body, $headers );
            wp_send_json(array('status'=>true));
        }else{
            wp_send_json(array('status'=>false));
        }
        wp_die();
    }

}
