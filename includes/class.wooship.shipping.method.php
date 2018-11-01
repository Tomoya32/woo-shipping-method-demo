<?php
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    function wooship_shipping_method_init() {
        if ( ! class_exists( 'WOOSHIP_Shipping_Method' ) ) {
            class WOOSHIP_Shipping_Method extends WC_Shipping_Method {

                /**
                 * Constructor for Wooship class
                 *
                 * @access public
                 * @return void
                 */
                public function __construct($instance_id = 0) {
                    $this->id                 = 'wooship_shipping_method'; 
                    $this->method_title       = __( 'Wooship Demo Method' );
                    $this->method_description = __( 'Rates calculated should be API' );
                    $this->enabled            = "yes"; 
                    $this->title              = "Wooship Demo Method";
                    $this->instance_id        = absint( $instance_id );
                    $this->supports           = array(
                     'shipping-zones',
                     'instance-settings'
                    );

                    $this->init();
                    $this->tax_status         = 'taxable';
                    $this->title              = $this->get_option('title');
                    $this->enable_method      = $this->get_option('enable_method');
                    $this->debug_mode         = $this->get_option('debug_mode');

                    $this->default_weight     = $this->get_option('default_weight');
                    $this->default_size       = $this->get_option('default_size');

                    add_action('woocommerce_update_options_shipping', array($this, 'process_admin_options'));
                }


                /**
                 * Init your settings
                 *
                 * @access public
                 * @return void
                 */
                function init() {
                    $this->init_form_fields();
                    $this->init_settings();
                    add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
                }

                public function init_form_fields()
                {
                    $dimensions_unit = strtolower(get_option('woocommerce_dimension_unit'));
                    $weight_unit = strtolower(get_option('woocommerce_weight_unit'));
                    $size_unit = strtolower(get_option('woocommerce_size_unit'));

                    /**
                    * API section moved a subtab under Advanced tab
                    **/
                    $this->form_fields = array(
                         'title' => array(
                              'title' => __( 'Method Title', 'wooship' ),
                              'type' => 'text',
                              'description' => __( 'This controls the title which the user sees during checkout.', 'woocommerce' ),
                              'default' => __( 'Bluedrone', 'wooship' )
                              ),
                         'enable_method' => array(
                                'title' => __('Enable Shipping Method', 'wooship'),
                                'type' => 'checkbox',
                                'label' => __('Enable ', 'wooship'),
                                'default' => 'yes',
                                'description' => __('If disabled, shipping method will not work.'),
                          ),

                         'debug_mode' => array(
                                'title' => __('Enable Debug Mode', 'wooship'),
                                'type' => 'checkbox',
                                'label' => __('Enable ', 'wooship'),
                                'default' => 'no',
                                'description' => __('If debug mode is enabled, the shipping method will be activated just for the administrator. The debug mode will display all the debugging data at the cart and the checkout pages.'),
                          ),

                         'default_weight' => array(
                            'title' => __('Default Package Weight', 'wooship'),
                            'type' => 'text',
                            'default' => '0.5',
                            'css' => 'width:75px',
                            'description' => __("Weight unit: ".$weight_unit."<br> This weight will only be used if the product's weight are not set in the edit product's page.", 'wooship'),
                        ),

                        'default_size' => array(
                            'title' => __('Default Package Size', 'wooship'),
                            'type' => 'text',
                            'default' => '0.5',
                            'css' => 'width:75px',
                            'description' => __("This size will only be used if the product's size are not set in the edit product's page.", 'wooship'),
                        ),
                    );
                }

                function admin_options() {
                     ?>
                     <h2><?php _e('Wooship Settings','woocommerce'); ?></h2>
                     <table class="form-table">
                     <?php $this->generate_settings_html(); ?>
                     </table> <?php
                 }


                /**
                 * calculate_shipping function.
                 *
                 * @access public
                 * @param mixed $package
                 * @return void
                 */
                public function calculate_shipping( $package = array()) {
                    $rate = array(
                        'id' => $this->instance_id,
                        'label' => $this->title,
                        'cost' => '1.99',
                        'calc_tax' => 'per_order'
                    );
                    // Register the rate
                    $this->add_rate( $rate);
                }
            }
        }
    }

    add_action( 'woocommerce_shipping_init', 'wooship_shipping_method_init' );

    function add_wooship_shipping_method( $methods ) {
        $methods['wooship_shipping_method'] = 'WOOSHIP_Shipping_Method';
        return $methods;
    }

    add_filter( 'woocommerce_shipping_methods', 'add_wooship_shipping_method' );
}