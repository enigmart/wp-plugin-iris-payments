<?php
/**
 * Plugin Name: WooCommerce Iris Gateway
 * Plugin URI: https://wordpress.org/plugins/wc-iris-gateway/
 * Description: Adds a simple Iris payment gateway functionality to your WooCommerce store. This plugin will give your clients the ability to pay the 
 * order with iris, in the same way that the would pay with bank transfer.
 * Version: 1.0.1
 *
 * Author: Elissavet Soileme
 * Author URI: http://3site.gr
 *
 * Text Domain: wc-iris-gateway
 * Domain Path: /languages/
 *
 * Requires at least: 6.1
 * Tested up to: 6.3
 * 
 * WC requires at least: 8.0
 * WC tested up to: 8.3 *

 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WC_Iris_Gateway plugin class.
 *
 * @class WC_Iris_Gateway
 */
class WC_Iris_Gateway {

	/**
	 * Plugin bootstrapping.
	 */
	public static function init() {

		// Iris Payments setup
		add_action( 'init', array( __CLASS__, 'plugin_setup' ) );

		// Iris Payments gateway class.
		add_action( 'plugins_loaded', array( __CLASS__, 'includes' ), 0 );

		// Iris Payments text domain
    add_action( 'init', array( __CLASS__, 'load_plugin_textdomain' ) );

		// Make the Iris Payments gateway available to WC.
		add_filter( 'woocommerce_payment_gateways', array( __CLASS__, 'add_gateway' ) );

		// Registers WooCommerce Blocks integration.
		add_action( 'woocommerce_blocks_loaded', array( __CLASS__, 'wc_iris_gateway_block_support' ) );

		// Remove order actions for pending payment status.
    add_filter( 'woocommerce_my_account_my_orders_actions', array( __CLASS__, 'remove_wc_iris_gateway_order_actions_buttons' ), 10, 2 );

		// Declare HPOS compaibility.
		add_action( 'before_woocommerce_init', array( __CLASS__, 'wc_declare_hpos_compatibility' ) );

	}

  /**
   * Setup all the things.
   * Only executes if WooCommerce core plugin is active.
   * If WooCommerce is not installed or inactive an admin notice is displayed.
   * @return void
   */
  public static function plugin_setup() {
    if ( class_exists( 'WooCommerce' ) ) {
      add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( __CLASS__, 'plugin_action_links' ) );
    } else {
      add_action( 'admin_notices', array( __CLASS__, 'install_woocommerce_core_notice' ) );
    }
  }

  /**
   * Load the localisation file.
   * @access  public
   * @return  void
   */
  public static function load_plugin_textdomain() {
    load_plugin_textdomain( 'wc-iris-gateway', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
  }

	/**
	 * Add the Iris Payment gateway to the list of available gateways.
	 *
	 * @param array
	 */
	public static function add_gateway( $gateways ) {
		$gateways[] = 'WC_Gateway_Iris';
		return $gateways;
	}

	/**
	 * Plugin includes.
	 */
	public static function includes() {

		// Make the WC_Iris_Gateway class available.
		if ( class_exists( 'WC_Payment_Gateway' ) ) {
			require_once 'includes/class-wc-iris-gateway.php';
		}
	}

	/**
	 * Plugin url.
	 *
	 * @return string
	 */
	public static function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Plugin url.
	 *
	 * @return string
	 */
	public static function plugin_abspath() {
		return trailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Registers WooCommerce Blocks integration.
	 *
	 */
	public static function wc_iris_gateway_block_support() {
		if ( class_exists( 'Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType' ) ) {
			require_once 'includes/blocks/class-wc-iris-payments-blocks.php';
			add_action(
				'woocommerce_blocks_payment_method_type_registration',
				function( Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry ) {
					$payment_method_registry->register( new WC_Iris_Gateway_Blocks_Support );
				}
			);
		}
	}

	/**
   * Show action links on the plugin screen.
   * @access  public
   * @param	mixed $links Plugin Action links
   * @return	array
   */
  public static function plugin_action_links( $links ) {
    $action_links = array(
      'settings' => '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout&section=iris' ) . '" title="' . esc_attr( __( 'View WooCommerce Settings', 'wc-iris-gateway' ) ) . '">' . __( 'Settings', 'wc-iris-gateway' ) . '</a>',
    );

    return array_merge( $action_links, $links );
  }

  /**
   * WooCommerce Iris Gateway plugin install notice.
   * If the user activates this plugin while not having the WooCommerce Dynamic Pricing plugin installed or activated, prompt them to install WooCommerce Dynamic Pricing.
   * @return  void
   */
  public static function install_woocommerce_core_notice() {
    echo '<div class="notice notice-error is-dismissible">
      <p>' . __( 'The WooCommerce Iris Gateway extension requires that you have the WooCommerce core plugin installed and activated.', 'wc-iris-gateway' ) . ' <a href="https://wordpress.org/plugins/woocommerce/" target="_blank">' . __( 'Install WooCommerce', 'wc-iris-gateway' ) . '</a></p>
    </div>';
  }

  /**
   * Remove Pay, Cancel order action buttons on My Account > Orders if order status is Pending Payment.
   * @return  $actions
   */
  public static function remove_wc_iris_gateway_order_actions_buttons( $actions, $order ) {

    if ( $order->has_status( 'pending' ) && 'iris' === $order->get_payment_method() ) {
      unset( $actions['pay'] );
      unset( $actions['cancel'] );
    }

    return $actions;

  }

	/**
	 * Declare HPOS compatibility.
	 * @return  void
	 */
	public static function wc_declare_hpos_compatibility() {
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
		}
	}

}

WC_Iris_Gateway::init();

