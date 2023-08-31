<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://xfinitysoft.com
 * @since      1.0.0
 *
 * @package    WC_Review_Discounts
 * @subpackage WC_Review_Discounts/admin/partials
 */
$tab = sanitize_text_field(isset($_GET['tab'])? $_GET['tab'] : 'general-settings');
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <h2>
        <?php esc_html_e('Review Discounts','wc-review-discounts'); ?>
        <a class="xs-pro-link" href="https://codecanyon.net/item/woocommerce-reviews-for-discount/33142777" target="_blank">
            <div class="xs-button-main">
                <?php submit_button(esc_html__("Pro Version" ,'wc-review-discounts'), 'secondary' , "xs-button"); ?>
            </div>
        </a>
    </h2>
    <?php settings_errors(); ?>
    <nav class="nav-tab-wrapper wp-clearfix" aria-label="Secondary menu">
        <a  class="nav-tab <?php  if($tab =='general-settings' ){ echo 'nav-tab-active'; } ?>" href="?post_type=xswc-review-discount&page=xsrl_review_discount&tab=general-settings">
            <?php esc_html_e('General Settings','wc-review-discounts'); ?>    
        </a>
        <a  class="nav-tab <?php  if($tab =='sendgrid-settings' ){ echo 'nav-tab-active'; } ?>" href="?post_type=xswc-review-discount&page=xsrl_review_discount&tab=sendgrid-settings">
            <?php esc_html_e('SendGrid Settings','wc-review-discounts'); ?>    
        </a>
    </nav>
    <div class="tab-content">
        <?php switch ($tab) {
            case 'sendgrid-settings':
                ?>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('xsrl_sendgrid') ;
                    do_settings_sections('xsrl_sendgrid') ;
                    $sendgrid_settings  = get_option('xsrl_sendgrid',array());
                    ?>
                    <h3><?php esc_html_e('SendGrid Settings ( Premium )','wc-review-discounts'); ?></h3>
                    <table class="form-table">
                        <tbody>
                            <tr>
                                <th><?php esc_html_e('Enable SendGrid','wc-review-discounts'); ?></th>
                                <td>
                                    <input type="checkbox" name="xsrl_sendgrid[enable]" <?php echo esc_attr(isset($sendgrid_settings['enable'])? 'checked' :''); ?> disabled>
                                    <span><?php esc_html_e('Use SendGrid to send emails', 'wc-review-discounts'); ?></span>
                                </td>
                            </tr>
                            <tr>
                                <th><?php esc_html_e('SendGrid From Email','wc-review-discounts'); ?></th>
                                <td>
                                    <input type="email" name="xsrl_sendgrid[email]" value="<?php echo esc_attr(isset($sendgrid_settings['email'])? $sendgrid_settings['email'] :''); ?>" disabled>
                                </td>
                            </tr>
                            <tr>
                                <th><?php esc_html_e('SendGrid Email API Key','wc-review-discounts'); ?></th>
                                <td>
                                    <input type="textarea" name="xsrl_sendgrid[api_key]" value="<?php echo esc_attr(isset($sendgrid_settings['api_key'])? $sendgrid_settings['api_key'] :''); ?>" disabled>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php  submit_button(esc_html__('Save Changes','wc-review-discounts')); ?>
                </form>
                <?php
                break;
            
            default:
                include_once plugin_dir_path( __FILE__ ) . 'wc-review-discounts-admin-settings.php';
                break;
        } ?>
    </div>    
</div>