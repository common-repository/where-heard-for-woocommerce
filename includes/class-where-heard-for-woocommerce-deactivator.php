<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://github.com/mkdo/where-heard-for-woocommerce
 * @since      1.0.0
 *
 * @package    Where_Heard_for_WooCommerce
 * @subpackage Where_Heard_for_WooCommerce/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Where_Heard_for_WooCommerce
 * @subpackage Where_Heard_for_WooCommerce/includes
 * @author     Make Do <hello@makedo.in>
 */
class Where_Heard_for_WooCommerce_Deactivator {

	/**
	 * Deactivate
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Remove the option we used to prevent the notice showing more than once.
		if ( get_option( 'where_heard_for_woocommerce_notice' ) ) {
			delete_option( 'where_heard_for_woocommerce_notice' );
		}
	}
}
