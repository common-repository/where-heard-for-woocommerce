<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://github.com/mkdo/where-heard-for-woocommerce
 * @since      1.0.0
 *
 * @package    Where_Heard_for_WooCommerce
 * @subpackage Where_Heard_for_WooCommerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Where_Heard_for_WooCommerce
 * @subpackage Where_Heard_for_WooCommerce/public
 * @author     Make Do <hello@makedo.in>
 */
class Where_Heard_for_WooCommerce_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $where_heard_for_woocommerce    The ID of this plugin.
	 */
	private $where_heard_for_woocommerce;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $where_heard_for_woocommerce       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $where_heard_for_woocommerce, $version ) {

		$this->where_heard_for_woocommerce = $where_heard_for_woocommerce;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->where_heard_for_woocommerce, plugin_dir_url( __FILE__ ) . 'css/where-heard-for-woocommerce-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->where_heard_for_woocommerce, plugin_dir_url( __FILE__ ) . 'js/where-heard-for-woocommerce-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Add a checkbox to seelct the Where Heard source at the checkout
	 * @param object $checkout Checkout object.
	 * @since    1.0.0
	 */
	function add_to_checkout( $checkout ) {
		// Fetch our settings data.
		$where_heard_checkbox    = get_option( 'where_heard_checkbox' );
		$where_heard_heading     = get_option( 'where_heard_heading' );
		$where_heard_description = get_option( 'where_heard_info' );
		$where_heard_label       = get_option( 'where_heard_label' );
		$where_heard_dropdown    = get_option( 'where_heard_dropdown' );

		// Convert our sources into an array.
		$sources = explode( "\n", $where_heard_dropdown );

		// Create an options array to pass to woocommerce_form_field.
		$options = array(
			'N/A' => __( 'Please select an option', WC_WHEREHEARD_TEXTDOMAIN ),
		);

		// Populate the array with our sources.
		if ( ! empty( $sources ) ) {
			foreach ( $sources as $source ) {
				$options[ esc_html( $source ) ] = esc_html( $source );
			}
		}

		// If all the settings have been configured.
		if ( ! empty( $where_heard_checkbox ) && ! empty( $options ) ) {

			// If no heading has been set, we'll need a sensible default.
			if ( empty( $where_heard_heading ) ) {
				$where_heard_heading = __( 'Where did you hear about us?', WC_WHEREHEARD_TEXTDOMAIN );
			}

			// Create a new section.
			echo '<section class="where-heard-section" aria-labelledby="where-heard-heading" aria-describedby="where-heard-description">';

			// Output the heading.
			echo '<h3 id="where-heard-heading">' . esc_html( $where_heard_heading ) . '</h3>';

			// Output the information.
			if ( ! empty( $where_heard_description ) ) {
				echo '<p id="where-heard-description">' . esc_html( $where_heard_description ) . '</p>';
			}

			// Output the select dropdown with label text.
			woocommerce_form_field( 'where_heard_source', array(
				'type'      => 'select',
				'class'     => array( 'input-select' ),
				'label'     => esc_html( $where_heard_label ),
				'required'  => false,
				'options'   => $options,
			), $checkout->get_value( 'where_heard_source' ) );

			// Create a nonce that we can use in update_order_meta().
			wp_nonce_field( 'whereheard_order', 'whereheard_order_security' );

			echo '</section>';
		}
	}

	/**
	 * Update order post meta with the Where Heard source
	 * @param object $order_id The order ID.
	 * @since    1.0.0
	 */
	public static function update_order_meta( $order_id ) {
		// Check for our nonce to ensure we're processing a valid order submission.
		$nonce = check_ajax_referer( 'whereheard_order', 'whereheard_order_security', false );

		if ( isset( $_POST['where_heard_source'] ) && $nonce ) {

			// Get our checkbox value.
			$source = sanitize_text_field( wp_unslash( $_POST['where_heard_source'] ) );

			// Add a default "N/A" status if the source isn't available.
			$source = ( ! empty( $source ) ? $source : __( 'N/A', WC_WHEREHEARD_TEXTDOMAIN ) );

			// Update the order post meta.
			update_post_meta( $order_id, 'where_heard_source', esc_attr( $source ) );
		}
	}

}
