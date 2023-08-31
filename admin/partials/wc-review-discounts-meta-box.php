<?php wp_nonce_field('xsrl_meta_nonce','xsrl_meta_nonce'); ?>

<div class="panel woocommerce_options_panel">
    <div class="options_group">
        <p class="form-field">
            <label for='xsrl-coupon-des'><?php esc_html_e('Coupon description','wc-review-discounts'); ?></label>
            <textarea class="short" id="xsrl-coupon-des" name="xswcrd_options[coupon_des]" rows="2" cols="20"><?php esc_html_e( isset($options['coupon_des']) ? $options['coupon_des']:''); ?></textarea>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('Description of coupon.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
        <p class="form-field">
            <label for='xsrl-trigger-event'><?php esc_html_e('Triggering event','wc-review-discounts'); ?></label>
            <select name="xswcrd_options[trigger_event]" id="xsrl-trigger-event">
                <option value="single" <?php echo esc_attr((isset($options['trigger_event']) && $options['trigger_event'] == 'single') ? 'selected=selected':'');?>><?php esc_html_e('Single Review','wc-review-discounts'); ?></option>
                <option value="multiple" <?php echo esc_attr((isset($options['trigger_event']) && $options['trigger_event'] == 'multiple') ? 'selected=selected':'');?> disabled><?php esc_html_e('Multiple Review ( Premium )','wc-review-discounts'); ?></option>
            </select>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('When the coupon will be sent.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
    </div>
    <div class="options_group xsrl-single-event <?php echo (!isset($options['trigger_event']) || $options['trigger_event'] == 'single') ? '':'xsrl-hidden';?>">
        <p class="form-field">
            <label for="xsrl-trigger-product"><?php  esc_html_e('Triggering Products'); ?></label>
            <select name="xswcrd_options[trigger_product][]" id='xsrl-trigger-product' >
                <?php foreach ($ids as $id) { ?>
                    <option value="<?php echo esc_attr($id); ?>" <?php echo esc_attr((isset($options['trigger_product']) &&  in_array( $id,$options['trigger_product']) ) ? 'selected=selected':'');?>><?php echo get_the_title($id)?></option>
                <?php } ?>
            </select>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('Products that will be give a coupon if reviewed.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
    </div>
    <div class="options_group">
        <p class="form-field">
            <label for="xsrl-discount-type"><?php  esc_html_e('Discount Type','wc-review-discounts'); ?></label>
            <select name="xswcrd_options[discount_type]" id="xsrl-discount-type" class="select short">
                <option value="1" <?php echo esc_attr((isset($options['discount_type']) && $options['discount_type'] == '1') ? 'selected=selected':'');?>><?php esc_html_e('Percentage discount','wc-review-discounts') ?></option>
                <option value="2" <?php echo esc_attr((isset($options['discount_type']) && $options['discount_type'] == '2') ? 'selected=selected':'');?>><?php esc_html_e('Fixed cart discount' , 'wc-review-discounts');?></option>
                <option value="3" <?php echo esc_attr((isset($options['discount_type']) && $options['discount_type'] == '3') ? 'selected=selected':'');?>><?php esc_html_e('Fixed product discount' , 'wc-review-discounts'); ?></option>
            </select>
        </p>
        <p class="form-field">
            <label for="xsrl-coupon-amount"><?php esc_html_e('Coupon amount','wc-review-discounts'); ?></label>
            <input type="text" id="xsrl-coupon-amount" class="short wc_input_price" name="xswcrd_options[coupon_amount]" placeholder="0" required="1" value="<?php echo esc_attr(isset($options['coupon_amount']) ? $options['coupon_amount']:''); ?>" required>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('Value of the coupon.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
        <p class="form-field">
            <label for="xsrl-valid-days"><?php esc_html_e('Validity days','wc-review-discounts'); ?></label>
            <input type="number" class="short wc" name="xswcrd_options[valid_days]" min="1" value="<?php echo esc_attr(isset($options['valid_days']) ? $options['valid_days']:''); ?>" required>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('Set for how many days the coupon will be valid since the creation. Set to "0" for no expiration.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
        <p class="form-field">
            <label for="xsrl-free-shipping"><?php esc_html_e('Allow free shipping','wc-review-discounts'); ?></label>
            <input type="checkbox" name="xswcrd_options[free_shipping]" class="checkbox" value="yes" id="xsrl-free-shipping"  <?php echo esc_attr( (isset($options['free_shipping']) && $options['free_shipping'] == 'yes') ? 'checked=checked':''); ?> />
            <span>
                <?php esc_html_e(' Check this box if the coupon grants free shipping. The ','wc-review-discounts'); ?>
                <a href="?page=wc-settings&tab=shipping&section=WC_Shipping_Free_Shipping"><?php esc_html_e('free shipping method','wc-review-discounts'); ?></a>
                <?php esc_html_e('  must be enabled and set to require "a valid free shipping coupon" (see the "Free Shipping Requires" setting).','wc-review-discounts'); ?>
            </span>
        </p>
    </div>
    <div class="options_group">
        <p class="form-field">
            <label for="xsrl-single-use"><?php esc_html_e('Single use only','wc-review-discounts'); ?></label>
            <input type="checkbox" name="xswcrd_options[single_use]" class="checkbox" value="yes" id="xsrl-single-use" <?php echo esc_attr((isset($options['single_use']) && $options['single_use'] == 'yes') ? 'checked=checked':'');?> />
            <span><?php esc_html_e('Check this box if the coupon cannot be used in conjunction with other coupons.','wc-review-discounts'); ?></span>
        </p>
        <p class="form-field">
            <label for="xsrl-exclude-sale-items"><?php esc_html_e('Exclude sale items','wc-review-discounts'); ?></label>
            <input type="checkbox" name="xswcrd_options[exclude_sale_items]" class="checkbox" value="yes" id="xsrl-exclude-sale-items" <?php echo esc_attr( (isset($options['exclude_sale_items']) && $options['exclude_sale_items'] == 'yes') ? 'checked=checked':'');?> />
            <span><?php esc_html_e('Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are items in the cart that are not on sale.','wc-review-discounts'); ?></span>
        </p>
        <p class="form-field">
            <label for="xsrl-min-amount"><?php esc_html_e('Minimum amount to spend','wc-review-discounts'); ?></label>
            <input type="text" class="short wc_input_price" name="xswcrd_options[min_amount]" placeholder="No Minimum" value="<?php echo esc_attr(isset($options['min_amount']) ? $options['min_amount']:''); ?>">
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('This field allows you to set the minimum subtotal needed to use the coupon.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
        <p class="form-field">
            <label for="xsrl-max-amount"><?php esc_html_e('Maximum amount to spend','wc-review-discounts'); ?></label>
            <input type="text" class="short wc_input_price" name="xswcrd_options[max_amount]" placeholder="No Maximum" value="<?php echo esc_attr(isset($options['max_amount']) ? $options['max_amount']:''); ?>">
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('This field allows you to set the maximum subtotal allowed when using the coupon.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
        <p class="form-field">
            <label for="xsrl-products"><?php esc_html_e('Products','wc-review-discounts'); ?></label>
            <select name="xswcrd_options[products][]" id="xsrl-products" multiple="multiple">
                <?php foreach ($ids as $id) { ?>
                    <option value="<?php echo esc_attr($id) ?>" <?php echo esc_attr((isset($options['products']) && in_array($id, $options['products'])) ? 'selected=selected':'');?>><?php echo esc_html_e(get_the_title($id))?></option>
                <?php } ?>
            </select>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('Products that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
        <p class="form-field">
            <label for="xsrl-ex-products"><?php esc_html_e('Exclude products','wc-review-discounts'); ?></label>
            <select name="xswcrd_options[ex_products][]" id="xsrl-ex-products" multiple="multiple">
                <?php foreach ($ids as $id) { ?>
                    <option value="<?php echo esc_attr($id); ?>" <?php echo esc_attr((isset($options['ex_products']) && in_array($id, $options['ex_products'])) ? 'selected=selected':'');?>><?php esc_html_e(get_the_title($id))?></option>
                <?php } ?>
            </select>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('Products that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.', 'wc-review-discounts'); ?> </span>
            </span>
        </p>
        <p class="form-field">
            <label for="xsrl-category"><?php  esc_html_e('Product categories'); ?></label>
            <select name="xswcrd_options[category][]" id='xsrl-category' multiple="multiple" >
                <?php foreach ($cat_ids as $category) { ?>
                    <option value="<?php echo esc_attr($category->term_id); ?>" <?php echo esc_attr((isset($options['category']) && in_array($category->term_id, $options['category'])) ? 'selected=selected':'');?>><?php esc_html_e($category->name); ?></option>
                <?php } ?>
            </select>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('Product categories that the coupon will be applied to, or that need to be in the cart in order for the "Fixed cart discount" to be applied.', 'wc-review-discounts'); ?> </span>
            </span>
            
        </p>
        <p class="form-field">
            <label for="xsrl-ex-category"><?php  esc_html_e('Exclude categories'); ?></label>
            <select name="xswcrd_options[ex_category][]" id='xsrl-ex-category' multiple="multiple" >
                <?php foreach ($cat_ids as $category) { ?>
                    <option value="<?php echo esc_attr($category->term_id) ?>" <?php echo esc_attr((isset($options['ex_category']) && in_array($category->term_id, $options['ex_category'])) ? 'selected=selected':'');?>><?php esc_html_e($category->name); ?></option>
                <?php } ?>
            </select>
            <span class="xsrl-help-tip">
                <span class="xsrl-tip"> <?php esc_html_e('Product categories that the coupon will not be applied to, or that cannot be in the cart in order for the "Fixed cart discount" to be applied.', 'wc-review-discounts'); ?> </span>
            </span>
            
        </p>
    </div>
</div>