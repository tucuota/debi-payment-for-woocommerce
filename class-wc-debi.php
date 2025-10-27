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
        $this->method_title = __('Debi', 'debi-payment-gateway-for-woocommerce');
        $this->title = __('Debi Payment', 'debi-payment-gateway-for-woocommerce');
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
                'title' => __('Enable/Disable', 'debi-payment-gateway-for-woocommerce'),
                'type' => 'checkbox',
                'label' => __('Enable Custom Payment', 'debi-payment-gateway-for-woocommerce'),
                'default' => 'no',
            ),
            'title' => array(
                'title' => __('Method Title', 'debi-payment-gateway-for-woocommerce'),
                'type' => 'text',
                'description' => __('This controls the title', 'debi-payment-gateway-for-woocommerce'),
                'default' => __('Credit or debit card in installments', 'debi-payment-gateway-for-woocommerce'),
                'desc_tip' => true,
            ),
            'sandbox_mode' => array(
                'title' => __('Sanbox mode', 'debi-payment-gateway-for-woocommerce'),
                'type' => 'checkbox',
                'label' => __('Sandbox', 'debi-payment-gateway-for-woocommerce'),
                'default' => 'no',
                'description' => __('Check if you want to use sandbox mode for testing', 'debi-payment-gateway-for-woocommerce'),
            ),
            'token_debi_live' => array(
                'title' => __('Token Debi Live', 'debi-payment-gateway-for-woocommerce'),
                'type' => 'textarea',
                'css' => 'width:500px;',
                'default' => '',
                'description' => __('Generate token in developer section of debi', 'debi-payment-gateway-for-woocommerce'),

            ),
            'token_debi_sandbox' => array(
                'title' => __('Token Debi Sandbox', 'debi-payment-gateway-for-woocommerce'),
                'type' => 'textarea',
                'css' => 'width:500px;',
                'default' => '',
                'description' => __('Generate token in developer section of debi-test.pro', 'debi-payment-gateway-for-woocommerce'),

            ),

            'interest_quota_0' => array(
                'title' => __('% interest for payment in two business days with debit', 'debi-payment-gateway-for-woocommerce'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ),
        );
        
        // Generate interest quota fields dynamically (1-12)
        for ($i = 1; $i <= 12; $i++) {
            $this->form_fields['interest_quota_' . $i] = array(
                // translators: %d is the installment count
                'title' => sprintf(_n('%% interest for %1$d installment', '%% interest for %1$d installments', $i, 'debi-payment-gateway-for-woocommerce'), $i),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            );
        }
    }

    public function process_payment($order_id)
    {
        global $woocommerce;
        $order = wc_get_order($order_id);

        if (!$order) {
            wc_add_notice(__('Order not found.', 'debi-payment-gateway-for-woocommerce'), 'error');
            return false;
        }

        // WooCommerce payment gateways handle nonce verification automatically
        // The nonce is verified by WooCommerce's process_payment() wrapper

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
        $quotas = isset($_POST[$this->id . '-cuotas']) ? absint(wp_unslash($_POST[$this->id . '-cuotas'])) : 0;
        
        if ($quotas < 0 || $quotas > 12) {
            wc_add_notice(__('Invalid number of installments selected.', 'debi-payment-gateway-for-woocommerce'), 'error');
            return false;
        }
        
        $nid_property = 'interest_quota_' . $quotas;
        $interest = $this->{$nid_property};
        $interest = is_numeric($interest) ? floatval($interest) : 0;
        
        $final_price = (float)$order->get_total() + ((float)$order->get_total() * (float)$interest / 100);
        
        $DNIoCUIL = isset($_POST['participant_id']) ? sanitize_text_field(wp_unslash($_POST['participant_id'])) : '';
        $number = isset($_POST[$this->id . '-payment_method_number']) ? sanitize_text_field(wp_unslash($_POST[$this->id . '-payment_method_number'])) : '';
        
        // Validate card number
        if (empty($number)) {
            wc_add_notice(__('Card number is required.', 'debi-payment-gateway-for-woocommerce'), 'error');
            return false;
        }
        
        // Basic card number validation (should be numeric and have reasonable length)
        $number = preg_replace('/\D/', '', $number);
        if (empty($number) || strlen($number) < 13 || strlen($number) > 19) {
            wc_add_notice(__('Invalid card number.', 'debi-payment-gateway-for-woocommerce'), 'error');
            return false;
        }

        update_post_meta($order_id, '_debi_final_price', sanitize_text_field($final_price));
        update_post_meta($order_id, '_debi_installment_count', sanitize_text_field($quotas));
        update_post_meta($order_id, '_debi_installment_amount', sanitize_text_field($final_price / $quotas));
        update_post_meta($order_id, '_debi_card_last_four', sanitize_text_field(substr($number, -4)));

        if (gmdate('j') >= 29) {
            $day_of_month = 1;
        } else {
            $day_of_month = gmdate('j');
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
            return array(
                'result' => 'failure',
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
            
            return array(
                'result' => 'success',
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
        // translators: %1$d is the installment count, %2$s is the installment amount, %3$s is the total amount
        $singular_text = __('%1$d installment of $ %2$s ($ %3$s)', 'debi-payment-gateway-for-woocommerce');
        // translators: %1$d is the installment count, %2$s is the installment amount, %3$s is the total amount
        $plural_text = __('%1$d installments of $ %2$s ($ %3$s)', 'debi-payment-gateway-for-woocommerce');
        
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
        // translators: %1$d is the installment count, %2$s is the installment amount
        $singular_text = __('%1$d installment of $ %2$s (no interest)', 'debi-payment-gateway-for-woocommerce');
        // translators: %1$d is the installment count, %2$s is the installment amount
        $plural_text = __('%1$d installments of $ %2$s (no interest)', 'debi-payment-gateway-for-woocommerce');
        
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
                <?php echo wp_kses_post($this->get_description()); ?>
                
                <p>
                    <label for="<?php echo esc_attr($this->id); ?>-cuotas"><?php esc_html_e('Select number of installments', 'debi-payment-gateway-for-woocommerce'); ?><span class="required">*</span></label>
                    <select id="<?php echo esc_attr($this->id); ?>-cuotas" name="<?php echo esc_attr($this->id); ?>-cuotas">
                        <option value="" disabled selected><?php esc_html_e('Select number of installments', 'debi-payment-gateway-for-woocommerce'); ?></option>
                        <?php
                        // Render installment options
                        for ($i = 0; $i <= 12; $i++) {
                            $property = 'interest_quota_' . $i;
                            if (!empty($this->$property)) {
                                $final_amount = number_format($amount + $amount * $this->{$property} / 100, 2, ',', ' ');
                                $final_quota = number_format($amount / ($i == 0 ? 1 : $i) + $amount * $this->{$property} / ($i == 0 ? 1 : $i) / 100, 2, ',', ' ');
                                
                                $extra_text = ($i == 0) ? ' ' . __('DEBIT CARD ONLY', 'debi-payment-gateway-for-woocommerce') : '';
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
                    <label for="<?php echo esc_attr($this->id); ?>-payment"><?php esc_html_e('Enter your card number', 'debi-payment-gateway-for-woocommerce'); ?> <span class="required">*</span></label>
                    <input id="<?php echo esc_attr($this->id); ?>-payment" name="<?php echo esc_attr($this->id); ?>-payment_method_number"></input>
                </p>

                <div class="clear"></div>

            </fieldset>

<?php
    }
}
