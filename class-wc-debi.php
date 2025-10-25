<?php
require 'debi.php';

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
    private $hide_text_box;

    public function __construct()
    {
        $this->id = 'woo-debi';
        $this->method_title = __('Débito automático (debi)', 'woocommerce-debi');
        $this->title = __('Débito Automático', 'woocommerce-debi');
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
        $this->hide_text_box = $this->get_option('hide_text_box');

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
                'default' => __('Custom Payment', 'woocommerce-debi'),
                'desc_tip' => true,
            ),
            'description' => array(
                'title' => __('Customer Message', 'woocommerce-debi'),
                'type' => 'textarea',
                'css' => 'width:500px;',
                'default' => 'Indique 16 dígitos de su tarjeta',
                'description' => __('The message which you want it to appear to the customer in the checkout page.', 'woocommerce-debi'),
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
                'title' => __('% interés para pago en dos días habíles con débito', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),

            ),

            'interest_quota_1' => array(
                'title' => __('% interés para 1 cuota', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_2' => array(
                'title' => __('% interés para 2 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_3' => array(
                'title' => __('% interés para 3 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_4' => array(
                'title' => __('% interés para 4 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_5' => array(
                'title' => __('% interés para 5 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_6' => array(
                'title' => __('% interés para 6 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_7' => array(
                'title' => __('% interés para 7 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_8' => array(
                'title' => __('% interés para 8 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_9' => array(
                'title' => __('% interés para 9 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_10' => array(
                'title' => __('% interés para 10 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_11' => array(
                'title' => __('% interés para 11 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ), 'interest_quota_12' => array(
                'title' => __('% interés para 12 cuotas', 'woocommerce-debi'),
                'type' => 'number',
                'default' => '',
                'custom_attributes' => array(
                    'step' => 'any',
                    'min' => '0',
                    'max' => '100',
                ),
            ),
            'hide_text_box' => array(
                'title' => __('Hide Payment Fields', 'woocommerce-debi'),
                'type' => 'checkbox',
                'label' => __('Hide payment fields', 'woocommerce-debi'),
                'default' => 'no',
                'description' => __('Check to hide payment fields in checkout', 'woocommerce-debi'),
            ),

        );
    }

    public function process_payment($order_id)
    {

        global $woocommerce;
        $order = new WC_Order($order_id);


        $items = $woocommerce->cart->get_cart();

        foreach ($items as $item => $values) {
            $_product = wc_get_product($values['data']->get_id());
            $product_title = $_product->get_title();
            $product_id = $_product->get_id();
        }
        $name = $woocommerce->customer->get_billing_last_name() . ', ' . $woocommerce->customer->get_billing_first_name();
        $email = $woocommerce->customer->get_billing_email();


        $token = $this->get_option('token_debi_live');
        
        $quotas = $_POST[$this->id . '-cuotas'];
        $nid_property = 'interest_quota_' . $quotas;
        $interest = $this->{$nid_property};
        $final_price = (float)$order->get_total() + ((float)$order->get_total() * (float)$interest / 100);
        $marca_tarjeta = $_POST[$this->id . '-marca'];
        $DNIoCUIL = sanitize_text_field($_POST['DNI/CUIL']);
        $number = $_POST[$this->id . '-admin-note'];

        update_post_meta($order_id, 'Precio Final', sanitize_text_field($final_price));
        update_post_meta($order_id, 'Cantidad de cuotas', sanitize_text_field($quotas));
        update_post_meta($order_id, 'Monto de cuota', sanitize_text_field($final_price / $quotas));
        update_post_meta($order_id, 'Marca tarjeta', sanitize_text_field($marca_tarjeta));
        update_post_meta($order_id, 'Número', sanitize_text_field($number));

        if (date('j') >= 29) {
            $day_of_month = 1;
        } else {
            $day_of_month = date('j');
        }


        //save customer

        $response_customer = (new WP_Http)->request('https://api.debi.pro/v1/customers', [
            'method' => 'POST',
            'headers' => [
                "Authorization" => "Bearer $token",
                // "Api-Version" => "$version",
            ],
            'body' => [
                'name' => $name,
                'email' => $email,
                'identification_number' => $DNIoCUIL,
            ],
        ]);

        $body_customer = wp_remote_retrieve_body($response_customer);
        $data_customer = json_decode($body_customer)->data;
        $customer_id = $data_customer->id;


        //save payment_method (tokenize)

        $response_payment_method = (new WP_Http)->request('https://api.debi.pro/v1/payment_methods', [
            'method' => 'POST',
            'headers' => [
                "Authorization" => "Bearer $token",
                // "Api-Version" => "$version",
            ],
            'body' => [
                'type' => 'card',
                'card' => [
                    'number' => $number,
                ]
            ],
        ]);

        $body_payment_method = wp_remote_retrieve_body($response_payment_method);
        $data_payment_method = json_decode($body_payment_method)->data;
        $payment_method_id = $data_payment_method->id;

        $request = (new WP_Http)->request('https://api.debi.pro/v1/subscriptions', [
            'method' => 'POST',
            'headers' => [
                "Authorization" => "Bearer $token",
                // "Api-Version" => "$version",

            ],
            'body' => [
                'amount' => $final_price / $quotas,
                'description' => 'Orden ' . $order->id . ' - Actividad ' . $product_id . ' - ' . $product_title,
                'payment_method_id' => $payment_method_id,
                'interval_unit' => "monthly",
                'interval' => 1,
                'day_of_month' => $day_of_month,
                'count' => $quotas,
                'customer_id' => $customer_id,
            ],
        ]);


        //save subscription_id for future updates
        $body = wp_remote_retrieve_body($request);
        $data = json_decode($body)->data;
        $subscription_id = $data->id;

        if (empty($subscription_id)) {
            // $request['response']['code'] > 205
            // echo $request['response']['message'];
            return array(
                'result' => 'failure',
                // 'result' => 'failure',
                'redirect' => $this->get_return_url($order),
            );
        } elseif ($request['response']['code'] <= 205) {

            if (!empty($subscription_id)) {
                update_post_meta($order_id, 'subscription_id', sanitize_text_field($subscription_id));
            }

            //esto reduce el stock también (si cancelo posteriormente se sube automáticamente)
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

    public function payment_fields()
    {
        if ($this->hide_text_box !== 'yes') {
            global $woocommerce;
            // $amount = $woocommerce->cart->get_total(); aparece con signo ARS
            // $amount = $woocommerce->cart->cart_contents_total; anda pero rara función
            $amount = $woocommerce->cart->total;

            $items = $woocommerce->cart->get_cart();
            foreach ($items as $item => $values) {
                $_product = wc_get_product($values['data']->get_id());
                $product_title = $_product->get_title();
                $product_id = $_product->get_id();
            }
?>

            <fieldset>

                <p>
                    <label>Ingrese la cantidad de cuotas<span class="required">*</span></label>
                    <select id="<?php echo $this->id; ?>-cuotas" name="<?php echo $this->id; ?>-cuotas">
                        <option value="" disabled selected>Seleccione la cantidad de cuotas</option>
                        <?php
                        if ($this->interest_quota_0 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_0 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 1 + $amount * $this->interest_quota_0 / 1 / 100, 2, ',', ' ')
                        ?>
                            <option value=0><?php echo ("1 cuota de $ " . $final_quota . " ($ " . $final_amount) . ") SOLO CON TARJETA DE DÉBITO"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_1 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_1 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 1 + $amount * $this->interest_quota_1 / 1 / 100, 2, ',', ' ')
                        ?>
                            <option value=1><?php echo ("1 cuota de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_2 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_2 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 2 + $amount * $this->interest_quota_2 / 2 / 100, 2, ',', ' ')
                        ?>
                            <option value=2><?php echo ("2 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_3 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_3 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 3 + $amount * $this->interest_quota_3 / 3 / 100, 2, ',', ' ')
                        ?>
                            <option value=3><?php echo ("3 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_4 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_4 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 4 + $amount * $this->interest_quota_4 / 4 / 100, 2, ',', ' ')
                        ?>
                            <option value=4><?php echo ("4 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_5 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_5 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 5 + $amount * $this->interest_quota_5 / 5 / 100, 2, ',', ' ')
                        ?>
                            <option value=5><?php echo ("5 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_6 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_6 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 6 + $amount * $this->interest_quota_6 / 6 / 100, 2, ',', ' ')
                        ?>
                            <option value=6><?php echo ("6 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_7 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_7 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 7 + $amount * $this->interest_quota_7 / 7 / 100, 2, ',', ' ')
                        ?>
                            <option value=7><?php echo ("7 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_8 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_8 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 8 + $amount * $this->interest_quota_8 / 8 / 100, 2, ',', ' ')
                        ?>
                            <option value=8><?php echo ("8 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_9 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_9 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 9 + $amount * $this->interest_quota_9 / 9 / 100, 2, ',', ' ')
                        ?>
                            <option value=9><?php echo ("9 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_10 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_10 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 10 + $amount * $this->interest_quota_10 / 10 / 100, 2, ',', ' ')
                        ?>
                            <option value=10><?php echo ("10 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_11 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_11 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 11 + $amount * $this->interest_quota_11 / 11 / 100, 2, ',', ' ')
                        ?>
                            <option value=11><?php echo ("11 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        if ($this->interest_quota_12 != "") {
                            $final_amount = number_format($amount + $amount * $this->interest_quota_12 / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / 12 + $amount * $this->interest_quota_12 / 12 / 100, 2, ',', ' ')
                        ?>
                            <option value=12><?php echo ("12 cuotas de $ " . $final_quota . " ($ " . $final_amount) . ")"; ?>
                            </option>
                        <?php }

                        // actividades con plan de pago especial
                        //OJO PONER ID de las variaciones o si es producto simple, poner el id del producto. Por ej 1609 y 10 es combo elcasco varones 2021, indiv y compartida. 261 es test product
                        if (in_array($product_id, [261, 1609, 1610, 2125, 2124, 5462, 5496, 3744])) {
                            $special_interest = 0;
                            $special_installment = 12;
                            $final_amount = number_format($amount + $amount * $special_interest / 100, 2, ',', ' ');
                            $final_quota = number_format($amount / $special_installment + $amount * $special_interest / $special_installment / 100, 2, ',', ' ');
                            ?>
                            <option value="<?php echo $special_installment; ?>">
                                <?php echo $special_installment . " cuotas de $ " . $final_quota . " ($ " . $final_amount . "). PLAN COMBO."; ?>
                            </option>
                            <?php
                        }

                        // Opciones por defecto si no hay valores de interés configurados
                        $has_any_interest = false;
                        for ($i = 0; $i <= 12; $i++) {
                            $property = 'interest_quota_' . $i;
                            if (!empty($this->$property)) {
                                $has_any_interest = true;
                                break;
                            }
                        }

                        if (!$has_any_interest) {
                            // Mostrar opciones básicas sin interés
                            ?>
                            <option value="1">1 cuota de $ <?php echo number_format($amount, 2, ',', ' '); ?> (sin interés)</option>
                            <option value="2">2 cuotas de $ <?php echo number_format($amount / 2, 2, ',', ' '); ?> (sin interés)</option>
                            <option value="3">3 cuotas de $ <?php echo number_format($amount / 3, 2, ',', ' '); ?> (sin interés)</option>
                            <option value="6">6 cuotas de $ <?php echo number_format($amount / 6, 2, ',', ' '); ?> (sin interés)</option>
                            <option value="12">12 cuotas de $ <?php echo number_format($amount / 12, 2, ',', ' '); ?> (sin interés)</option>
                            <?php
                        }
                        ?>
                    </select>
                </p>

                <p>
                    <label>Indique marca de tarjeta de crédito o débito<span class="required">*</span></label>
                    <select id="<?php echo $this->id; ?>-marca" name="<?php echo $this->id; ?>-marca">
                        <option value="visa-credito">Visa Crédito</option>
                        <option value="visa-debito">Visa Débito</option>
                        <option value="mastercard">Mastercard</option>
                        <option value="nativa">Nativa</option>
                        <option value="argencard">Argencard</option>
                        <option value="diners-club">Diners Club</option>
                        <option value="maestro">Maestro</option>
                        <option value="mastercard-debit">Mastercard Debit</option>
                    </select>
                </p>

                <p class="form-row form-row-wide">
                    <label for="<?php echo $this->id; ?>-admin-note"><?php echo ($this->description); ?> <span class="required">*</span></label>
                    <input id="<?php echo $this->id; ?>-admin-note" name="<?php echo $this->id; ?>-admin-note"></input>
                </p>

                <div class="clear"></div>

            </fieldset>

<?php
        }
    }
}
