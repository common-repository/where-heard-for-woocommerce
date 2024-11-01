<?php

/**
 * Fired during plugin activation
 *
 * @link       http://github.com/mkdo/where-heard-for-woocommerce
 * @since      1.0.0
 *
 * @package    Where_Heard_for_WooCommerce
 * @subpackage Where_Heard_for_WooCommerce/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Where_Heard_for_WooCommerce
 * @subpackage Where_Heard_for_WooCommerce/includes
 * @author     Make Do <hello@makedo.in>
 */
class Where_Heard_for_WooCommerce_Activator {

	/**
	 * Activate
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-where-heard-for-woocommerce-admin.php';
	}
}
