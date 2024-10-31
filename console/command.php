<?php


// Add 30 minute cron job
if (!function_exists('hkdigital_cronSchedulesForEvocaBank')) {
    /**
     * Remove the specified resource from storage.
     *
     * @param $schedules
     * @return array
     */
    function hkdigital_cronSchedulesForEvocaBank($schedules)
    {
        if (!isset($schedules["30min"])) {
            $schedules["30min"] = array(
                'interval' => 30 * 60,
                'display' => __('Once every 30 minutes'));
        }
        return $schedules;
    }
}
add_filter('cron_schedules', 'hkdigital_cronSchedulesForEvocaBank');

if (!function_exists('hkdigital_initHKDEvocaPlugin')) {
    function hkdigital_initHKDEvocaPlugin()
    {
        if (!wp_next_scheduled('cronCheckOrderEvocaBank')) {
            wp_schedule_event(time(), '30min', 'cronCheckOrderEvocaBank');
        }
        add_rewrite_endpoint('cards', EP_PERMALINK | EP_PAGES, 'cards');
        flush_rewrite_rules();
    }
}
add_action('init', 'hkdigital_initHKDEvocaPlugin');