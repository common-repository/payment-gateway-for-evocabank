<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action('admin_init', 'hkdigital_pluginActivateHKDEvocaBank');
if (!function_exists('hkdigital_pluginActivateHKDEvocaBank')) {
    function hkdigital_pluginActivateHKDEvocaBank()
    {
        global $apiUrlEvoca;
        global $pluginDataEvoca;
        $pluginVersion = $pluginDataEvoca['Version'];
        if (get_option('hkd_evoca_bank_version_option') !== $pluginVersion) {
            try {
                if (isset($_SERVER['SERVER_NAME']) || isset($_SERVER['REQUEST_URI'])) {
                    $url = isset($_SERVER['SERVER_NAME']) ? sanitize_text_field($_SERVER['SERVER_NAME']) : sanitize_text_field($_SERVER['REQUEST_URI']);
                    $ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
                    $token = md5('hkd_init_banks_gateway_class');
                    $user = wp_get_current_user();
                    $email = (string)$user->user_email;
                    $data = ['version' => $pluginVersion, 'email' => $email, 'url' => $url, 'ip' => $ip, 'token' => $token, 'status' => 'inactive'];
                    update_option('hkd_evoca_bank_version_option', $pluginVersion);
                    wp_remote_post($apiUrlEvoca . 'bank/evoca/pluginActivate', [
                        'headers' => array('Accept' => 'application/json'),
                        'sslverify' => false,
                        'body' => $data]);
                }
            } catch (Exception $e) {
            }
        }
    }
}
