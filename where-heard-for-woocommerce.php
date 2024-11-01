<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://github.com/mkdo/where-heard-for-woocommerce
 * @since             1.0.0
 * @package           Where_Heard_for_WooCommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Where Heard for WooCommerce
 * Plugin URI:        http://github.com/mkdo/where-heard-for-woocommerce/
 * Description:       Ask your customers where they heard of you, and view that data in the admin area.
 * Version:           1.1.2
 * Author:            Make Do <hello@makedo.in>
 * Author URI:        http://github.com/mkdo/where-heard-for-woocommerce/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       where-heard-for-woocommerce
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WC_WHEREHEARD_TEXTDOMAIN', 'where-heard-for-woocommerce' );

// Bootstrap the plugin if WooCommerce is active.
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-where-heard-for-woocommerce-activator.php
	 */
	function activate_where_heard_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-where-heard-for-woocommerce-activator.php';
		Where_Heard_for_WooCommerce_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-where-heard-for-woocommerce-deactivator.php
	 */
	function deactivate_where_heard_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-where-heard-for-woocommerce-deactivator.php';
		Where_Heard_for_WooCommerce_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_where_heard_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_where_heard_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-where-heard-for-woocommerce.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    1.0.0
	 */
	function run_where_heard_for_woocommerce() {

		$plugin = new Where_Heard_for_WooCommerce();
		$plugin->run();

	}
	run_where_heard_for_woocommerce();
}
