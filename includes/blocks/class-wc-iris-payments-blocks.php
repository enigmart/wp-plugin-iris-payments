<?php
use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

/**
 * Iris Payments Blocks integration
 *
 */
final class WC_Iris_Gateway_Blocks_Support extends AbstractPaymentMethodType {

	/**
	 * The gateway instance.
	 *
	 * @var WC_Gateway_Iris
	 */
	private $gateway;

	/**
	 * Payment method name/id/slug.
	 *
	 * @var string
	 */
	protected $name = 'iris';

	/**
	 * Initializes the payment method type.
	 */
	public function initialize() {
		$this->settings = get_option( 'woocommerce_iris_settings', [] );
	}

	/**
	 * Returns if this payment method should be active. If false, the scripts will not be enqueued.
	 *
	 * @return boolean
	 */
	public function is_active() {
		return filter_var( $this->get_setting( 'enabled', false ), FILTER_VALIDATE_BOOLEAN );
	}

	/**
	 * Return enable_for_virtual option.
	 *
	 * @return boolean True if store allows COD payment for orders containing only virtual products.
	 */
	private function get_enable_for_virtual() {
		return filter_var( $this->get_setting( 'enable_for_virtual', false ), FILTER_VALIDATE_BOOLEAN );
	}

	/**
	 * Return enable_for_methods option.
	 *
	 * @return array Array of shipping methods (string ids) that allow Iris. (If empty, all support COD.)
	 */
	private function get_enable_for_methods() {
		$enable_for_methods = $this->get_setting( 'enable_for_methods', [] );
		if ( '' === $enable_for_methods ) {
			return [];
		}
		return $enable_for_methods;
	}

	/**
	 * Return user_roles option.
	 *
	 * @return array Array of user roles (string ids) that allow Iris. (If empty, all support COD.)
	 */
	private function get_enable_for_roles() {
		$enabled_roles = $this->get_setting( 'user_roles', [] );

		if ( '' === $enabled_roles ) {
			return [];
		}

		return $enabled_roles;
	}

	/**
	 * Return the curent user roles.
	 *
	 * @return array The user roles assigned to the current user.
	 */
	private function get_current_user_role() {
		$user = wp_get_current_user();
		return $user->roles;
	}

	/*
	 * Returns an array of scripts/handles to be registered for this payment method.
	 *
	 * @return array
	 */
	public function get_payment_method_script_handles() {
		$script_path       = '/assets/js/frontend/blocks.js';
		$script_asset_path = WC_Iris_Gateway::plugin_abspath() . 'assets/js/frontend/blocks.asset.php';
		$script_asset      = file_exists( $script_asset_path )
			? require( $script_asset_path )
			: array(
				'dependencies' => array(),
				'version'      => '1.2.0'
			);
		$script_url = WC_Iris_Gateway::plugin_url() . $script_path;

		wp_register_script(
			'wc-iris-payments-blocks',
			$script_url,
			$script_asset[ 'dependencies' ],
			$script_asset[ 'version' ],
			true
		);

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'wc-iris-payments-blocks', 'wc-iris-gateway', WC_Iris_Gateway::plugin_abspath() . 'languages/' );
		}

		return [ 'wc-iris-payments-blocks' ];
	}

	/**
	 * Returns an array of key=>value pairs of data made available to the payment methods script.
	 *
	 * @return array
	 */
	public function get_payment_method_data() {

		return [
			'title'        		 	  		 	=> $this->get_setting( 'title' ),
			'description'  		 	   			=> $this->get_setting( 'description' ),
			'instructions'  		 	   			=> $this->get_setting( 'instructions' ),
			'vat_number'  		 	   			=> $this->get_setting( 'vat_number' ) ,
			'account_name'  		 	   	=> $this->get_setting( 'account_name' ) ,
			'qr_code'  		 	   			=> $this->get_setting( 'qr_code' ) ,
			'order_status' 		 	   			=> $this->get_setting( 'order_status' ),
			'enableForUserRoles' 	   	 	=> $this->get_enable_for_roles(),
			'currentUserRole' 	  	   	=> $this->get_current_user_role(),
			'enableForShippingMethods' 	=> $this->get_enable_for_methods(),
			'enableForVirtual'		   		=> $this->get_enable_for_virtual(),
			'supports'                 	=> $this->get_supported_features(),
		];
	}
}
