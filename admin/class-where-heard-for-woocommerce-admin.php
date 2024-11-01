<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://github.com/mkdo/where-heard-for-woocommerce
 * @since      1.0.0
 *
 * @package    Where_Heard_for_WooCommerce
 * @subpackage Where_Heard_for_WooCommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Where_Heard_for_WooCommerce
 * @subpackage Where_Heard_for_WooCommerce/admin
 * @author     Make Do <hello@makedo.in>
 */
class Where_Heard_for_WooCommerce_Admin {

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
	 * @param      string $where_heard_for_woocommerce       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $where_heard_for_woocommerce, $version ) {

		$this->where_heard_for_woocommerce = $where_heard_for_woocommerce;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->where_heard_for_woocommerce, plugin_dir_url( __FILE__ ) . 'css/where-heard-for-woocommerce-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->where_heard_for_woocommerce, plugin_dir_url( __FILE__ ) . 'js/where-heard-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Output notices on activation
	 * @since    1.0.0
	 **/
	public static function admin_notice() {
		// If we have notices.
		if ( $notices = get_option( 'where_heard_for_woocommerce_deferred_admin_notices' ) ) {

			// Loop through the array and generate the notices.
			foreach ( $notices as $notice ) {
				echo '<div class="updated"><p>' . esc_html( $notice ) . '</p></div>';
			}

			// Clear out our notices option.
			delete_option( 'where_heard_for_woocommerce_deferred_admin_notices' );
		}
	}

	/**
	 * Add an admin notice to the output
	 * @since    1.0.0
	 **/
	public static function add_notice() {

		// Retrieve any existing notices.
	    $notices = get_option( 'where_heard_for_woocommerce_deferred_admin_notices', array() );

		// Prepare our notice.
		$activation = apply_filters( 'where_heard_for_woocommerce_activation_notice', __( 'Where Heard for WooCommerce has been installed and can be configured in the Products tab of your WooCommerce settings.' , WC_WHEREHEARD_TEXTDOMAIN ) );

	    // Add our activation notice to the array.
	    $notices[] = $activation;

	    // Update the notices setting including our notice.
	    update_option( 'where_heard_for_woocommerce_deferred_admin_notices' , $notices );
	}

	/**
	 * Add an activation notice if we haven't already displayed one
	 * @since    1.0.0
	 **/
	public function admin_init() {
		// Ensure the notice is shown only once.
		if ( 1 != get_option( 'where_heard_for_woocommerce_notice' ) ) {

			// Save the fact the plugin is active in an option.
			add_option( 'where_heard_for_woocommerce_notice', 1 );

			// Add our activation notice.
			$this->add_notice();
		}
	}

	/**
	 * Create a Where Heard section in the tab
	 * @param array $sections An array of sections.
	 * @since    1.0.0
	 **/
	public static function add_section( $sections ) {
		$sections['where_heard'] = apply_filters( 'where_heard_for_woocommerce_section_name', __( 'Where Heard', WC_WHEREHEARD_TEXTDOMAIN ) );

		return $sections;
	}

	/**
	 * Add settings to our section
	 * @param array $settings An array of settings.
	 * @since    1.0.0
	 */
	public static function add_settings( $settings ) {
		global $current_section;

		if ( 'where_heard' === $current_section ) {

			$settings_where_heard = array();

			$settings_where_heard[] = array(
				'name'  => __( 'Where Heard', WC_WHEREHEARD_TEXTDOMAIN ),
				'type'  => 'title',
				'desc'  => __( 'Knowing exactly where your customers are coming from is crucial when developing your ongoing marketing strategy. Once configured, this plugin will make this information available should the customer elect to share this with you.' ),
				'id'    => 'where_heard_section_title',
			);

			$settings_where_heard[] = array(
				'name'  => __( 'Enable Where Heard', WC_WHEREHEARD_TEXTDOMAIN ),
				'type'  => 'checkbox',
				'desc'  => __( 'Whether or not to enable Where Heard at the checkout.', WC_WHEREHEARD_TEXTDOMAIN ),
				'id'    => 'where_heard_checkbox',
				'class' => 'where-heard-checkbox',
			);

			$settings_where_heard[] = array(
				'name'  => __( 'Section Heading', WC_WHEREHEARD_TEXTDOMAIN ),
				'type'  => 'text',
				'desc'  => __( 'Optional heading for the Where Heard section at the checkout. Defaults to "Where did you hear about Us?".', WC_WHEREHEARD_TEXTDOMAIN ),
				'id'    => 'where_heard_heading',
				'class' => 'where-heard-heading',
			);

			$settings_where_heard[] = array(
				'name'  => __( 'Dropdown Label', WC_WHEREHEARD_TEXTDOMAIN ),
				'type'  => 'text',
				'desc'  => __( 'Label for the dropdown. Must be populated in order for the Where Heard option to appear at the checkout.', WC_WHEREHEARD_TEXTDOMAIN ),
				'id'    => 'where_heard_label',
				'class' => 'where-heard-label',
			);

			$settings_where_heard[] = array(
				'name'  => __( 'Dropdown Options', WC_WHEREHEARD_TEXTDOMAIN ),
				'type'  => 'textarea',
				'desc'  => __( 'Add options the user can select from. One per line. Must be populated in order for the Where Heard option to appear at the checkout.', WC_WHEREHEARD_TEXTDOMAIN ),
				'id'    => 'where_heard_dropdown',
				'class' => 'where-heard-dropdown',
			);

			$settings_where_heard[] = array(
				'name'  => __( 'Description', WC_WHEREHEARD_TEXTDOMAIN ),
				'type'  => 'textarea',
				'desc'  => __( 'Optional text explaining why the question is being asked.', WC_WHEREHEARD_TEXTDOMAIN ),
				'id'    => 'where_heard_info',
				'class' => 'where-heard-info',
			);

			$settings_where_heard[] = array(
				'type' => 'sectionend',
				'id'   => 'where_heard_section_end',
			);

			return apply_filters( 'where_heard_for_woocommerce_settings', $settings_where_heard );
		} else {
			return apply_filters( 'where_heard_for_woocommerce_settings', $settings );
		}
	}

	/**
	 * Add a Where Heard column to the order screen
	 * @param array $columns An array of column names.
	 * @since    1.0.0
	 */
	public static function add_orders_column( $columns ) {
		// Add columns into our new array if $columns is an array.
		$new_columns = (is_array( $columns )) ? $columns : array();

		// Remove the order actions column.
		unset( $new_columns['order_actions'] );

		// Create our column.
		$new_columns['where_heard'] = apply_filters( 'where_heard_for_woocommerce_orders_column_name', __( 'Where Heard', WC_WHEREHEARD_TEXTDOMAIN ) );

		// Put the order actions column back.
		$new_columns['order_actions'] = $columns['order_actions'];

		return $new_columns;
	}

	/**
	 * Populate the Where Heard column with the post meta
	 * @param string $column Column name.
	 * @since    1.0.0
	 */
	public static function add_column_data( $column ) {
		// Get the post meta containing the Where Heard source.
		global $post;

		$source = get_post_meta( $post->ID, 'where_heard_source', true );

		// Add a fallback of "N/A" if no source is available.
		$source = ( ! empty( $source ) ? $source : __( 'N/A', WC_WHEREHEARD_TEXTDOMAIN ) );

		// Output the Where Heard source in our column.
		if ( 'where_heard' === $column  ) {
			echo esc_html( $source );
		}
	}

	/**
	 * Add the Where Heard source for each order on the shop orders screen
	 * @param object $order Current order object.
	 * @since    1.0.0
	 */
	public static function add_order_details( $order ) {
		// Get the post meta containing the Where Heard source.
		$source = get_post_meta( $order->id, 'where_heard_source', true );

		// Add a fallback of "N/A" if no source is available.
		$source = ( ! empty( $source ) ? $source : __( 'N/A', WC_WHEREHEARD_TEXTDOMAIN ) );
		?>

	    <div class="order_data_column">
	        <h4><?php esc_html_e( 'Where Heard Details', WC_WHEREHEARD_TEXTDOMAIN ); ?></h4>
	        <?php
	            echo '<p><strong>' . esc_html__( 'Source', WC_WHEREHEARD_TEXTDOMAIN ) . ':</strong> ' . esc_html( $source ) . '</p>';
	        ?>
	    </div>

	<?php
	}

	/**
	 * Add the Where Heard meta to order emails
	 * @param object  $order The order object.
	 * @param boolean $sent_to_admin Whether the email is for the admin.
	 * @param boolean $plain_text Whether the email is plain text.
	 */
	function add_order_email_meta( $order, $sent_to_admin, $plain_text ) {

		if ( $sent_to_admin ) {
			// Get the post meta containing the Gift Aid status.
			$source = get_post_meta( $order->id, 'where_heard_source', true );

			// If a source has been selected confirm this in the email.
			if ( ! empty( $source ) ) {
				echo '<p class="where-heard-order-email"><strong>' . esc_html__( 'The customer heard of us via', WC_WHEREHEARD_TEXTDOMAIN ) . ': ' . esc_html( $source ) . '</strong></p>';
			}
		}
	}

	/**
	 * Create a WooCommerce Customer/Order CSV Export column for the Where Heard source
	 * @param array $column_headers Array of column headers.
	 * @since    1.0.0
	 */
	public static function wc_csv_export_modify_column_headers( $column_headers ) {
		// Add the new Gift Aid column.
		$new_headers = array(
			'where_heard' => 'where_heard',
		);

		return array_merge( $column_headers, $new_headers );
	}

	/**
	 * Populate the WooCommerce Customer/Order CSV Export column with the Where Heard source
	 * @param array  $order_data Array of column headers.
	 * @param array  $order Array of column headers.
	 * @param object $csv_generator Array of column headers.
	 * @since    1.0.0
	 */
	public static function wc_csv_export_modify_row_data( $order_data, $order, $csv_generator ) {
		// Get the post meta containing the Where Heard source.
		$source = get_post_meta( $order->id, 'where_heard_source', true );

		// Add a fallback of "N/A" if no source is available.
		$source = ( ! empty( $source ) ? $source : __( 'N/A', WC_WHEREHEARD_TEXTDOMAIN ) );

		// Prepare our data to be added to the column.
		$custom_data = array(
			'where_heard' => $source,
		);

		// Merge our data with the existing row data.
		$new_order_data = array();

		if ( isset( $csv_generator->order_format ) && ( 'default_one_row_per_item' == $csv_generator->order_format || 'legacy_one_row_per_item' == $csv_generator->order_format ) ) {

			foreach ( $order_data as $data ) {
				$new_order_data[] = array_merge( (array) $data, $custom_data );
			}
		} else {
			$new_order_data = array_merge( $order_data, $custom_data );
		}

		return $new_order_data;
	}
}
