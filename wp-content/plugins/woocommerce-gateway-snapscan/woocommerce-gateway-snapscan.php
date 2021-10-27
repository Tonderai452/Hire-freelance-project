<?php
/**
 * Plugin Name: WooCommerce SnapScan Gateway
 * Plugin URI: http://woothemes.com/products/woocommerce-gateway-snapscan/
 * Description: Receive payments using SnapScan.
 * Author: SnapScan
 * Author URI: http://www.snapscan.co.za/
 * Version: 1.0.1
 *
 * Copyright (c) 2015 SnapScan
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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
	exit;
}

if ( ! function_exists( 'woothemes_queue_update' ) )
        require_once( 'woo-includes/woo-functions.php' );

/* Integrate with the WooThemes Updater plugin for plugin updates. */
woothemes_queue_update( plugin_basename( __FILE__ ), 'e81054a615f5a27ed29e33d04b2a8131', '1337648' );

/**
 * Required functions
 */

load_plugin_textdomain( 'woocommerce-gateway-snapscan', false, trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );

add_action( 'plugins_loaded', 'woocommerce_snapscan_init', 0 );

/**
 * Initialize the gateway.
 *
 */
function woocommerce_snapscan_init() {

	if ( ! class_exists( 'WC_Payment_Gateway' ) ) {
		return;
	}

	require_once( plugin_basename( 'includes/class-wc-gateway-snapscan.php' ) );
	add_filter( 'woocommerce_payment_gateways', 'woocommerce_snapscan_add_gateway' );
}

/**
 * Add the gateway to WooCommerce
 *
 * @param $methods
 *
 * @return array
 */
function woocommerce_snapscan_add_gateway( $methods ) {
	$methods[] = 'WC_Gateway_SnapScan';

	return $methods;
}
