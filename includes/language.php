<?php

$overrideLocaleEvoca = !empty(get_option('language_payment_evocabank')) ? get_option('language_payment_evocabank') : 'hy';
add_filter('plugin_locale','changeLanguageEvocaBank', 10, 2);

/**
 * change location event
 *
 * @param $locale
 * @param $domain
 * @return string
 */
function changeLanguageEvocaBank($locale, $domain)
{
    global $currentPluginDomainEvoca;
    global $overrideLocaleEvoca;
    if ($domain == $currentPluginDomainEvoca) {
        $locale = $overrideLocaleEvoca;
    }
    return $locale;
}