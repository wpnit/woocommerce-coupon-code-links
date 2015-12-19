<?php
/**
 * Plugin Name: WooCommerce Coupon Code Links
 * Plugin URI: https://github.com/wpnit/woocommerce-coupon-code-links
 * Description: Automatically apply a coupon code passed via URL to the cart
 * Author: WPNit
 * Author URI: http://wpnit.com
 * Version: 1.0
 * Text Domain: woocommerce-coupon-code-links
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Check if WooCommerce is active
 */
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    if ( ! class_exists( 'WC_Coupon_Code_Links' ) ) {


/**
 * WooCommerce Coupon Code Links.
 *
 * Automatically apply a coupon code passed via URL to the cart.
 *
 * @class               WC_Coupon_Code_Links
 * @version             1.0.0
 * @author              WPNit
 */
class WC_Coupon_Code_Links {

    /**
    * Constructor
    */
    public function __construct() {
        $this->init();
    }

    /**
    * Init function
    */
    public function init() {
        add_action( 'wp_loaded', array( $this, 'apply_coupon_code' ), 30 );
        add_action( 'woocommerce_add_to_cart', array( $this, 'apply_coupon_code' ) );
    }

    public function apply_coupon_code() {
    	// Check if WooCommerce and sessions are available
    	if ( ! function_exists( 'WC' ) || ! WC()->session ) {
    		return;
    	}

    	// Filter the coupon code query variable name
    	$query_var = apply_filters( 'woocommerce_coupon_links_query_var', 'coupon_code' );

    	// Check if a coupon code isn't in the query string
    	if ( empty( $_GET[ $query_var ] ) ) {
    		return;
    	}

    	// Set a session cookie to persist the coupon in case the cart is empty.
    	WC()->session->set_customer_session_cookie( true );

    	// Apply the coupon to the cart.
    	// WC_Cart::add_discount() sanitizes the coupon code.
    	WC()->cart->add_discount( $_GET[ $query_var ] );
    }

}

$wc_coupon_code_links = new WC_Coupon_Code_Links();


    }
}
