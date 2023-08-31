<form method="post" action="options.php">
    <?php
    settings_fields('xsrl_settings') ;
    do_settings_sections('xsrl_settings') ;
    $settings  = get_option('xsrl_settings',array());
    ?>
    <h3><?php esc_html_e('Review For Discounts settings','wc-review-discounts'); ?></h3>
    <table class="form-table">
        <tbody>
            <tr>
                <th><?php esc_html_e('Enable WooCommerce Review For Discounts','wc-review-discounts');?></th>
                <td>
                    <label class="xsrl-switch">
                        <input type="checkbox" name="xsrl_settings[enable]" <?php echo esc_attr((isset($settings['enable']) && $settings['enable'] == 'on') ? 'checked':''); ?> >
                        <span class="xsrl-slider"></span>
                    </label>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('The coupon will be sent','wc-review-discounts') ?></th>
                <td>
                    <select name="xsrl_settings[send_coupons]">
                        <option value="1" <?php echo esc_attr((isset($settings['send_coupons']) && $settings['send_coupons'] == '1') ? 'selected=selected':''); ?>><?php esc_html_e('After review approval' ,'wc-review-discounts'); ?></option>
                        <option value="2" <?php echo esc_attr((isset($settings['send_coupons']) && $settings['send_coupons'] == '2') ? 'selected=selected':''); ?>><?php esc_html_e('After review composition' ,'wc-review-discounts');?></option>
                    </select>
                    <p class="description"><?php esc_html_e('Choose when coupon will be sent','wc-review-discounts');?></p>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Email header color (Premium)','wc-review-discounts'); ?></th>
                <td>
                    <input type="text" name="xsrl_settings[email_header_color]" value="<?php echo esc_attr((isset($settings['email_header_color'])) ?$settings['email_header_color']: '#2FBB1C'); ?>" class="xsrl-color-picker" id="email_header_color" disabled>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Deletion of Expired Coupons (Premium)','wc-review-discounts') ?></th>
                <td>
                    <label class="xsrl-switch">
                        <input type="checkbox" name="xsrl_settings[delete_auto_coupons]" <?php echo esc_attr((isset($settings['delete_auto_coupons']) && $settings['delete_auto_coupons'] == 'on') ? 'checked':''); ?> disabled>
                        <span class="xsrl-slider"></span>
                    </label>
                    <p class="description">
                        <?php esc_html_e('Delete automatically expired coupons (only those created by this plugin)','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
    <h3><?php esc_html_e('Email settings for the single review','wc-review-discounts'); ?></h3>
    <table class="form-table">
        <tbody>
            <tr>
                <th><?php esc_html_e('Email type','wc-review-discounts'); ?></th>
                <td>
                    <select name="xsrl_settings[single_email_type]">
                        <option value="1" <?php echo esc_attr((isset($settings['single_email_type']) && $settings['single_email_type'] == '1') ? 'selected=selected':''); ?>><?php esc_html_e('HTML','wc-review-discounts'); ?></option>
                        <option value="2" <?php echo esc_attr((isset($settings['single_email_type']) && $settings['single_email_type'] == '2') ? 'selected=selected':''); ?> disabled><?php esc_html_e('Plain text (Premium)','wc-review-discounts'); ?></option>
                    </select>
                    <p class="description">
                        <?php esc_html_e('Choose which email format you want to use','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Email subject' , 'wc-review-discounts' );?></th>
                <td>
                    <input type="text" name="xsrl_settings[single_email_subject]" value="<?php echo (isset($settings['single_email_subject']))? esc_attr($settings['single_email_subject']) : ''; ?>" required="required">
                    <p class="description">
                        <?php esc_html_e('Allowed placeholders: {site_title} {customer_name} {customer_last_name}','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Email content' , 'wc-review-discounts' );?></th>
                <td>
                    <textarea name="xsrl_settings[single_email_content]" rows="5" cols="50" required="required"><?php esc_html_e((isset($settings['single_email_subject']))? $settings['single_email_content'] : ''); ?></textarea>
                    <p class="description">
                        <?php esc_html_e('Allowed placeholders: {site_title} {customer_name} {customer_last_name} {customer_email} {product_name} {coupon_description}','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Test email' , 'wc-review-discounts' );?></th>
                <td>
                    <input type="email" name="xsrl_settings[single_email_test]" id="xsrl_single_email_test" value="<?php echo (isset($settings['single_email_test']))? esc_attr($settings['single_email_test']) : ''; ?>">

                    <?php submit_button( esc_html__( 'Send Test Email', 'wc-review-discounts' ), 'secondary','single_email_test',true,array('data-class'=>'email_test','data-id'=>'single') ); ?>
                    <p class="description">
                        <?php esc_html_e('Type an email address to send a test email','wc-review-discounts') ?>
                    </p>
                    <div class="xsrl-single-email-notice">
                        <p></p>
                        <button type="button" class="notice-dismiss xsrl-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice.','wc-review-discounts');?></span></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h3><?php esc_html_e('Email settings for multiple reviews (Premium)','wc-review-discounts'); ?></h3>
    <table class="form-table">
        <tbody>
                        <tr>
                <th><?php esc_html_e('Email type','wc-review-discounts'); ?></th>
                <td>
                    <select name="xsrl_settings[multi_email_type]" disabled>
                        <option value="1" <?php echo esc_attr((isset($settings['multi_email_type']) && $settings['multi_email_type'] == '1') ? 'selected=selected':''); ?>><?php esc_html_e('HTML','wc-review-discounts'); ?></option>
                        <option value="2" <?php echo esc_attr((isset($settings['multi_email_type']) && $settings['multi_email_type'] == '2') ? 'selected=selected':''); ?>><?php esc_html_e('Plain text','wc-review-discounts'); ?></option>
                    </select>
                    <p class="description">
                        <?php esc_html_e('Choose which email format you want to use','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Email subject' , 'wc-review-discounts' );?></th>
                <td>
                    <input type="text" name="xsrl_settings[multi_email_subject]" value="<?php echo esc_attr((isset($settings['multi_email_subject']))? esc_attr($settings['multi_email_subject']) : ''); ?>" disabled>
                    <p class="description">
                        <?php esc_html_e('Allowed placeholders: {site_title} {customer_name} {customer_last_name}','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Email content' , 'wc-review-discounts' );?></th>
                <td>
                    <textarea name="xsrl_settings[multi_email_content]" rows="5" cols="50" disabled><?php esc_html_e( (isset($settings['multi_email_subject']))? $settings['multi_email_content'] : '' ); ?></textarea>
                    <p class="description">
                        <?php esc_html_e('Allowed placeholders: {site_title} {customer_name} {customer_last_name} {customer_email} {total_reviews} {coupon_description}','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Test email' , 'wc-review-discounts' );?></th>
                <td>
                    <input type="email" name="xsrl_settings[multi_email_test]" value="<?php echo esc_attr((isset($settings['multi_email_test']))? $settings['multi_email_test']: ''); ?>" id="xsrl_multi_email_test" disabled>
                    <?php submit_button( esc_html__( 'Send Test Email', 'wc-review-discounts' ), 'secondary','multi_email_test',true,array('data-class'=>'email_test','data-id'=>'multi','disabled'=>'disabled') ); ?>
                    <p class="description">
                        <?php esc_html_e('Type an email address to send a test email','wc-review-discounts') ?>
                    </p>
                    <div class="xsrl-multi-email-notice">
                        <p></p>
                        <button type="button" class="notice-dismiss xsrl-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice.','wc-review-discounts');?></span></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h3><?php esc_html_e('Email settings for customer close to the target (Premium)','wc-review-discounts'); ?></h3>
    <table class="form-table">
        <tbody>
                        <tr>
                <th><?php esc_html_e('Email type','wc-review-discounts'); ?></th>
                <td>
                    <select name="xsrl_settings[target_email_type]" disabled>
                        <option value="1" <?php echo esc_attr((isset($settings['target_email_type']) && $settings['target_email_type'] == '1') ? 'selected=selected':''); ?>><?php esc_html_e('HTML','wc-review-discounts'); ?></option>
                        <option value="2" <?php echo esc_attr((isset($settings['target_email_type']) && $settings['target_email_type'] == '2') ? 'selected=selected':''); ?> ><?php esc_html_e('Plain text ','wc-review-discounts'); ?></option>
                    </select>
                    <p class="description">
                        <?php esc_html_e('Choose which email format you want to use','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Email subject' , 'wc-review-discounts' );?></th>
                <td>
                    <input type="text" name="xsrl_settings[target_email_subject]" value="<?php echo (isset($settings['target_email_subject']))? esc_attr($settings['target_email_subject']) : ''; ?>" disabled>
                    <p class="description">
                        <?php esc_html_e('Allowed placeholders: {site_title} {customer_name} {customer_last_name}','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Email content' , 'wc-review-discounts' );?></th>
                <td>
                    <textarea name="xsrl_settings[target_email_content]" rows="5" cols="50" disabled><?php esc_html_e( (isset($settings['target_email_subject']))? $settings['target_email_content'] : ''); ?></textarea>
                    <p class="description">
                        <?php esc_html_e('Allowed placeholders: {site_title} {customer_name} {customer_last_name} {customer_email} {remaining_reviews}','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Test email' , 'wc-review-discounts' );?></th>
                <td>
                    <input type="email" name="xsrl_settings[target_email_test]" value="<?php echo (isset($settings['target_email_test']))? esc_attr($settings['target_email_test']) : ''; ?>" id='xsrl_target_email_test' disabled>
                    <?php submit_button( esc_html__( 'Send Test Email', 'wc-review-discounts' ), 'secondary','target_email_test',true,array('data-class'=>'email_test','data-id'=>'target','disabled' =>'disabled') ); ?>
                    <p class="description">
                        <?php esc_html_e('Type an email address to send a test email','wc-review-discounts') ?>
                    </p>
                    <div class="xsrl-target-email-notice">
                        <p></p>
                        <button type="button" class="notice-dismiss xsrl-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice.','wc-review-discounts');?></span></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <h3><?php esc_html_e('Email settings for customer after buying product','wc-review-discounts'); ?></h3>
    <table class="form-table">
        <tbody>
            <tr>
                <th><?php esc_html_e('Email type','wc-review-discounts'); ?></th>
                <td>
                    <select name="xsrl_settings[buy_email_type]">
                        <option value="1" <?php echo esc_attr((isset($settings['buy_email_type']) && $settings['buy_email_type'] == '1') ? 'selected=selected':''); ?>><?php esc_html_e('HTML','wc-review-discounts'); ?></option>
                        <option value="2" <?php echo esc_attr((isset($settings['buy_email_type']) && $settings['buy_email_type'] == '2') ? 'selected=selected':''); ?> disabled><?php esc_html_e('Plain text (Premium)','wc-review-discounts'); ?></option>
                    </select>
                    <p class="description">
                        <?php esc_html_e('Choose which email format you want to use','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Email subject' , 'wc-review-discounts' );?></th>
                <td>
                    <input type="text" name="xsrl_settings[buy_email_subject]" value="<?php echo (isset($settings['buy_email_subject']))? esc_attr($settings['buy_email_subject']) : ''; ?>" required="required">
                    <p class="description">
                        <?php esc_html_e('Allowed placeholders: {site_title} {customer_name} {customer_last_name}','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Email content' , 'wc-review-discounts' );?></th>
                <td>
                    <textarea name="xsrl_settings[buy_email_content]" rows="5" cols="50" required="required"><?php esc_html_e( (isset($settings['buy_email_subject']))? $settings['buy_email_content'] : ''); ?></textarea>
                    <p class="description">
                        <?php esc_html_e('Allowed placeholders: {site_title} {customer_name} {customer_last_name} {customer_email}','wc-review-discounts') ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php  esc_html_e('Test email' , 'wc-review-discounts' );?></th>
                <td>
                    <input type="email" name="xsrl_settings[buy_email_test]" value="<?php echo (isset($settings['buy_email_test']))? esc_attr($settings['buy_email_test']) : ''; ?>" id='xsrl_buy_email_test'>
                    <?php submit_button( esc_html__( 'Send Test Email', 'wc-review-discounts' ), 'secondary','buy_email_test',true,array('data-class'=>'email_test','data-id'=>'buy') ); ?>
                    <p class="description">
                        <?php esc_html_e('Type an email address to send a test email','wc-review-discounts') ?>
                    </p>
                    <div class="xsrl-buy-email-notice">
                        <p></p>
                        <button type="button" class="notice-dismiss xsrl-notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice.','wc-review-discounts');?></span></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <?php submit_button(esc_html__('Save Changes','wc-review-discounts')); ?>
</form>