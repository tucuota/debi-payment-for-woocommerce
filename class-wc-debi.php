<?php
/**
 * The core plugin class for Debi payment gateway.
 *
 * @package    WooCommerce_Debi
 * @author     Fernando del Peral <support@debi.pro>
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * WC_debi Payment Gateway
 *
 * @package    WooCommerce_Debi
 */
class WC_debi extends WC_Payment_Gateway
{
    private $sandbox_mode;
    private $token_debi_live;
    private $token_debi_sandbox;
    private $interest_quota_0;
    private $interest_quota_1;
    private $interest_quota_2;
    private $interest_quota_3;
    private $interest_quota_4;
    private $interest_quota_5;
    private $interest_quota_6;
    private $interest_quota_7;
    private $interest_quota_8;
    private $interest_quota_9;
    private $interest_quota_10;
    private $interest_quota_11;
    private $interest_quota_12;

    public function __construct()
    {
        $this->id = 'woo-debi';
        $this->method_title = __('Debi Payment Gateway', 'woocommerce-debi');
        $this->title = __('Debi Payment', 'woocommerce-debi');
        $this->has_fields = true;
        $this->init_form_fields();
        $this->init_settings();
        $this->enabled = $this->get_option('enabled');
        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');
        $this->sandbox_mode = $this->get_option('sandbox_mode');
        $this->token_debi_live = $this->get_option('token_debi_live');
        $this->token_debi_sandbox = $this->get_option('token_debi_sandbox');
        $this->interest_quota_0 = $this->get_option('interest_quota_0');
        $this->interest_quota_1 = $this->get_option('interest_quota_1');
        $this->interest_quota_2 = $this->get_option('interest_quota_2');
        $this->interest_quota_3 = $this->get_option('interest_quota_3');
        $this->interest_quota_4 = $this->get_option('interest_quota_4');
        $this->interest_quota_5 = $this->get_option('interest_quota_5');
        $this->interest_quota_6 = $this->get_option('interest_quota_6');
        $this->interest_quota_7 = $this->get_option('interest_quota_7');
        $this->interest_quota_8 = $this->get_option('interest_quota_8');
        $this->interest_quota_9 = $this->get_option('interest_quota_9');
        $this->interest_quota_10 = $this->get_option('interest_quota_10');
        $this->interest_quota_11 = $this->get_option('interest_quota_11');
        $this->interest_quota_12 = $this->get_option('interest_quota_12');

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
    }
    public function init_form_fields()
    {
        $this->form_fields = array(
            'enabled' => array(
                'title' => __('Enable/Disable', 'woocommerce-debi'),
                'type' => 'checkbox',
                'label' => __('Enable Custom Payment', 'woocommerce-debi'),
                'default' => 'no',
            ),
            'title' => array(
                'title' => __('Method Title', 'woocommerce-debi'),
                'type' => 'text',
                'description' => __('This controls the title', 'woocommerce-debi'),
                'default' => __('Credit or debit card in installments', 'woocommerce-debi'),
                'desc_tip' => true,
            ),
            'sandbox_mode' => array(
                'title' => __('Sanbox mode', 'woocommerce-debi'),
                'type' => 'checkbox',
                'label' => __('Sandbox', 'woocommerce-debi'),
                'default' => 'no',
                'description' => __('Check if you want to use sandbox mode for testing', 'woocommerce-debi'),
            ),
            'token_debi_live' => array(
                'title' => __('Token Debi Live', 'woocommerce-debi'),
                'type' => 'textarea',
                'css' => 'width:500px;',
                'default' => '',
                'description' => __('Generate token in developer section of debi', 'woocommerce-debi'),

            ),
            'token_debi_sandbox' => array(
                'title' => __('Token Debi Sandbox', 'woocommerce-debi'),
                'type' => 'textarea',
                'css' => 'width:500px;',
                'default' => '',
                'description' => __('Generate token in developer section of debi-test.pro', 'woocommerce-debi'),

            ),

            'interest_quota_0' => array(
                'title' => __('% interest for payment in two business days with debit', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),

            ),

            'interest_quota_1' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 1, 'woocommerce-debi'), 1),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_2' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 2, 'woocommerce-debi'), 2),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_3' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 3, 'woocommerce-debi'), 3),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_4' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 4, 'woocommerce-debi'), 4),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_5' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 5, 'woocommerce-debi'), 5),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_6' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 6, 'woocommerce-debi'), 6),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_7' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 7, 'woocommerce-debi'), 7),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_8' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 8, 'woocommerce-debi'), 8),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_9' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 9, 'woocommerce-debi'), 9),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_10' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 10, 'woocommerce-debi'), 10),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_11' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 11, 'woocommerce-debi'), 11),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_12' => array(
                'title' => sprintf(_n('%% interest for %d installment', '%% interest for %d installments', 12, 'woocommerce-debi'), 12),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ),

        );
    }

    public function process_payment($order_id)
    {
        global $woocommerce;
        $order = wc_get_order($order_id);

        if (!$order) {
            wc_add_notice(__('Order not found.', 'woocommerce-debi'), 'error');
            return false;
        }

        $items = $woocommerce->cart->get_cart();

        foreach ($items as $item => $values) {
            $_product = wc_get_product($values['data']->get_id());
            $product_title = $_product->get_title();
            $product_id = $_product->get_id();
        }
        $name = $woocommerce->customer->get_billing_last_name() . ', ' . $woocommerce->customer->get_billing_first_name();
        $email = $woocommerce->customer->get_billing_email();

        // Determine which token to use based on sandbox mode
        $is_sandbox = $this->sandbox_mode === 'yes';
        $token = $is_sandbox ? $this->token_debi_sandbox : $this->token_debi_live;
        
        // Sanitize and validate input
        $quotas = isset($_POST[$this->id . '-cuotas']) ? absint($_POST[$this->id . '-cuotas']) : 0;
        
        if ($quotas < 0 || $quotas > 12) {
            wc_add_notice(__('Invalid number of installments selected.', 'woocommerce-debi'), 'error');
            return false;
        }
        
        $nid_property = 'interest_quota_' . $quotas;
        $interest = $this->{$nid_property};
        $interest = is_numeric($interest) ? floatval($interest) : 0;
        
        $final_price = (float)$order->get_total() + ((float)$order->get_total() * (float)$interest / 100);
        
        $DNIoCUIL = isset($_POST['participant_id']) ? sanitize_text_field($_POST['participant_id']) : '';
        $number = isset($_POST[$this->id . '-payment_method_number']) ? sanitize_text_field($_POST[$this->id . '-payment_method_number']) : '';
        
        // Validate card number
        if (empty($number)) {
            wc_add_notice(__('Card number is required.', 'woocommerce-debi'), 'error');
            return false;
        }
        
        // Basic card number validation (should be numeric and have reasonable length)
        $number = preg_replace('/\D/', '', $number);
        if (empty($number) || strlen($number) < 13 || strlen($number) > 19) {
            wc_add_notice(__('Invalid card number.', 'woocommerce-debi'), 'error');
            return false;
        }

        update_post_meta($order_id, '_debi_final_price', sanitize_text_field($final_price));
        update_post_meta($order_id, '_debi_installment_count', sanitize_text_field($quotas));
        update_post_meta($order_id, '_debi_installment_amount', sanitize_text_field($final_price / $quotas));
        update_post_meta($order_id, '_debi_card_last_four', sanitize_text_field(substr($number, -4)));

        if (date('j') >= 29) {
            $day_of_month = 1;
        } else {
            $day_of_month = date('j');
        }


        // Save customer to Debi
        $response_customer = (new debi($token, $is_sandbox))->request('customers', [
            'method' => 'POST',
            'body' => [
                'name' => $name,
                'email' => $email,
                'identification_number' => $DNIoCUIL,
            ],
        ]);

        $data_customer = $response_customer['data'];
        $customer_id = $data_customer['id'];


        // Tokenize payment method
        $response_payment_method = (new debi($token, $is_sandbox))->request('payment_methods', [
            'method' => 'POST',
            'body' => [
                'type' => 'card',
                'card' => [
                    'number' => $number,
                ]
            ],
        ]);

        $data_payment_method = $response_payment_method['data'];
        $payment_method_id = $data_payment_method['id'];

        $request = (new debi($token, $is_sandbox))->request('subscriptions', [
            'method' => 'POST',
            'body' => [
                'amount' => $final_price / $quotas,
                'description' => 'Order ' . $order->id . ' - Product ' . $product_id . ' - ' . $product_title,
                'payment_method_id' => $payment_method_id,
                'interval_unit' => "monthly",
                'interval' => 1,
                'day_of_month' => $day_of_month,
                'count' => $quotas,
                'customer_id' => $customer_id,
            ],
        ]);

        // Save subscription_id for future updates
        $data = $request['data'];
        $subscription_id = $data['id'];

        if (empty($subscription_id)) {
            // $request['response']['code'] > 205
            // echo $request['response']['message'];
            return array(
                'result' => 'failure',
                // 'result' => 'failure',
                'redirect' => $this->get_return_url($order),
            );
        } else {

            if (!empty($subscription_id)) {
                update_post_meta($order_id, '_debi_subscription_id', sanitize_text_field($subscription_id));
            }

            // This also reduces stock (if cancelled later, it automatically increases)
            $order->update_status('processing');

            // Remove cart
            $woocommerce->cart->empty_cart();
            // Return thankyou redirect
            return array(
                'result' => 'success',
                // 'result' => 'failure',
                'redirect' => $this->get_return_url($order),
            );
        }
    }

    /**
     * Get formatted installment text
     *
     * @param int $count Number of installments
     * @param string $quota_amount Formatted quota amount
     * @param string $final_amount Formatted final amount
     * @param string $extra_text Additional text to append (e.g., "- DEBIT CARD ONLY")
     * @return string Formatted installment text
     */
    private function get_installment_text($count, $quota_amount, $final_amount, $extra_text = '') {
        $singular_text = __('%d installment of $ %s ($ %s)', 'woocommerce-debi');
        $plural_text = __('%d installments of $ %s ($ %s)', 'woocommerce-debi');
        
        $text = ($count == 1) ? $singular_text : $plural_text;
        
        $formatted = sprintf($text, $count, $quota_amount, $final_amount);
        
        if (!empty($extra_text)) {
            $formatted .= $extra_text;
        }
        
        return $formatted;
    }

    /**
     * Get formatted installment text for no interest options
     *
     * @param int $count Number of installments
     * @param string $quota_amount Formatted quota amount
     * @return string Formatted installment text
     */
    private function get_installment_no_interest_text($count, $quota_amount) {
        $singular_text = __('%d installment of $ %s (no interest)', 'woocommerce-debi');
        $plural_text = __('%d installments of $ %s (no interest)', 'woocommerce-debi');
        
        $text = ($count == 1) ? $singular_text : $plural_text;
        
        return sprintf($text, $count, $quota_amount);
    }

    public function payment_fields()
    {
            global $woocommerce;
            $amount = $woocommerce->cart->total;

            $items = $woocommerce->cart->get_cart();
            foreach ($items as $item => $values) {
                $_product = wc_get_product($values['data']->get_id());
                $product_title = $_product->get_title();
                $product_id = $_product->get_id();
            }
?>

            <fieldset>
                <?php echo $this->get_description(); ?>
                
                <p>
                    <label for="<?php echo esc_attr($this->id); ?>-cuotas"><?php _e('Select number of installments', 'woocommerce-debi'); ?><span class="required">*</span></label>
                    <select id="<?php echo esc_attr($this->id); ?>-cuotas" name="<?php echo esc_attr($this->id); ?>-cuotas">
                        <option value="" disabled selected><?php _e('Select number of installments', 'woocommerce-debi'); ?></option>
                        <?php
                        // Render installment options
                        for ($i = 0; $i <= 12; $i++) {
                            $property = 'interest_quota_' . $i;
                            if (!empty($this->$property)) {
                                $final_amount = number_format($amount + $amount * $this->{$property} / 100, 2, ',', ' ');
                                $final_quota = number_format($amount / ($i == 0 ? 1 : $i) + $amount * $this->{$property} / ($i == 0 ? 1 : $i) / 100, 2, ',', ' ');
                                
                                $extra_text = ($i == 0) ? ' ' . __('DEBIT CARD ONLY', 'woocommerce-debi') : '';
                                $text = $this->get_installment_text($i == 0 ? 1 : $i, $final_quota, $final_amount, $extra_text);
                                ?>
                                <option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($text); ?></option>
                                <?php
                            }
                        }

                        // Default options if no interest values are configured
                        $has_any_interest = false;
                        for ($i = 0; $i <= 12; $i++) {
                            $property = 'interest_quota_' . $i;
                            if (!empty($this->$property)) {
                                $has_any_interest = true;
                                break;
                            }
                        }

                        if (!$has_any_interest) {
                            ?>
                            <option value="1"><?php echo esc_html($this->get_installment_no_interest_text(1, number_format($amount, 2, ',', ' '))); ?></option>
                            <option value="2"><?php echo esc_html($this->get_installment_no_interest_text(2, number_format($amount / 2, 2, ',', ' '))); ?></option>
                            <option value="3"><?php echo esc_html($this->get_installment_no_interest_text(3, number_format($amount / 3, 2, ',', ' '))); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </p>

                <p class="form-row form-row-wide">
                    <label for="<?php echo esc_attr($this->id); ?>-payment"><?php _e('Enter your card number', 'woocommerce-debi'); ?> <span class="required">*</span></label>
                    <input id="<?php echo esc_attr($this->id); ?>-payment" name="<?php echo esc_attr($this->id); ?>-payment_method_number"></input>
                </p>

                <div class="clear"></div>

            </fieldset>

<?php
    }
}
