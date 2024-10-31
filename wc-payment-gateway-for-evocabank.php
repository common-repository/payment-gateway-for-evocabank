<?php
/*
Plugin Name:Payment gateway for Evocabank
Plugin URI: #
Description: Pay with  Evocabank payment system. Please note that the payment will be made in Armenian Dram.
Version: 1.0.8
Author: HK Digital Agency LLC
Author URI: https://hkdigital.am
License: GPLv2 or later
*/


/*
 *
 * Սույն հավելման(plugin) պարունակությունը պաշպանված է հեղինակային և հարակից իրավունքների մասին Հայաստանի Հանրապետության օրենսդրությամբ:
 * Արգելվում է պարունակության  վերարտադրումը, տարածումը, նկարազարդումը, հարմարեցումը և այլ ձևերով վերափոխումը,
 * ինչպես նաև այլ եղանակներով օգտագործումը, եթե մինչև նման օգտագործումը ձեռք չի բերվել ԷՅՋԿԱ ԴԻՋԻՏԱԼ ԷՋԵՆՍԻ ՍՊԸ-ի թույլտվությունը:
 *
 */

$currentPluginDomainEvoca = 'payment-gateway-for-evocabank';
$apiUrlEvoca = 'https://plugins.hkdigital.am/api/';
$pluginDirUrlEvoca = plugin_dir_url(__FILE__);
$pluginBaseNameEvoca = dirname(plugin_basename(__FILE__));
if (!defined('ABSPATH')) exit;
if( !function_exists('get_plugin_data') ){
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
$pluginDataEvoca = get_plugin_data(__FILE__);


if (!function_exists('hkdigital_evoca_addEvocaBankGatewayClass')) {
    /**
     *
     * @param $gateways
     * @return array
     */
    function hkdigital_evoca_addEvocaBankGatewayClass($gateways)
    {
        $gateways[] = 'HKDigital_Evoca_Gateway';
        return $gateways;
    }
}

add_filter('woocommerce_payment_gateways', 'hkdigital_evoca_addEvocaBankGatewayClass');

include dirname(__FILE__) . '/console/command.php';
include dirname(__FILE__) . '/includes/thankyou.php';

if (is_admin()) {
    include dirname(__FILE__) . '/includes/activate.php';
}

include dirname(__FILE__) . '/includes/errorCodes.php';
include dirname(__FILE__) . '/includes/main.php';


add_action('plugin_action_links_' . plugin_basename(__FILE__), 'hkdigital_evocabank_gateway_setting_link');
if (!function_exists('hkdigital_evocabank_gateway_setting_link')) {
    function hkdigital_evocabank_gateway_setting_link($links)
    {
        $links = array_merge(array(
            '<a href="' . esc_url(admin_url('/admin.php')) . '?page=wc-settings&tab=checkout&section=hkd_evocabank">' . __('Settings', 'payment-gateway-for-evocabank') . '</a>'
        ), $links);
        return $links;
    }
}

add_action( 'woocommerce_blocks_loaded', 'hkdigital_woocommerce_evocabank_woocommerce_blocks_support' );

if (!function_exists('hkdigital_woocommerce_evocabank_woocommerce_blocks_support')) {
    function hkdigital_woocommerce_evocabank_woocommerce_blocks_support()
    {
        if (class_exists('Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType')) {
            require_once dirname(__FILE__) . '/includes/evocabank-blocks-support.php';
            add_action(
                'woocommerce_blocks_payment_method_type_registration',
                function (Automattic\WooCommerce\Blocks\Payments\PaymentMethodRegistry $payment_method_registry) {
                    $payment_method_registry->register(new EvocaBank_Blocks_Support);
                }
            );
        }
    }
}

if (!function_exists('hkdigital_woocommerce_evocabank_declare_hpos_compatibility')) {
    /**
     * Declares support for HPOS.
     *
     * @return void
     */
    function hkdigital_woocommerce_evocabank_declare_hpos_compatibility()
    {
        if (class_exists('\Automattic\WooCommerce\Utilities\FeaturesUtil')) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
        }
    }
}
add_action( 'before_woocommerce_init', 'hkdigital_woocommerce_evocabank_declare_hpos_compatibility' );
