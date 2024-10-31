<?php

if (isset($_POST['woocommerce_hkd_evocabank_language_payment_evocabank'])) {
    $language = $_POST['woocommerce_hkd_evocabank_language_payment_evocabank'];
    if ($language === 'hy' || $language === 'ru_RU' || $language === 'en_US')
        update_option('language_payment_evocabank', $language);
}
