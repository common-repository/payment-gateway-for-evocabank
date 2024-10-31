var $ = jQuery;
$(document).ready(function () {

    checkCheckboxes();

    $(document).on('change', '#woocommerce_hkd_evocabank_save_card', function () {
        checkCheckboxes();
    });

    $(document).on('mouseover', '.woocommerce-help-tip', function () {
        let parentId = $(this).parent().attr('for');
        if (parentId === 'woocommerce_hkd_evocabank_save_card_button_text') {
            $('#tiptip_content').css({
                'max-width': '300px',
                'width': '300px'
            }).html('<img src="'+ myScript.pluginsUrl + 'assets/images/bindingnew.jpg" width="300">');
        } else if(parentId === 'woocommerce_hkd_evocabank_save_card_header') {
            $('#tiptip_content').css({
                'max-width': '300px',
                'width': '300px'
            }).html('<img src="'+ myScript.pluginsUrl + 'assets/images/payment.jpg" width="300">');
        }else if(parentId === 'woocommerce_hkd_evocabank_save_card_use_new_card'){
            $('#tiptip_content').css({
                'max-width': '300px',
                'width': '300px'
            }).html('<img src="'+ myScript.pluginsUrl + 'assets/images/newcard.jpg" width="300">');
        }else{
            $('#tiptip_content').css({'max-width': '150px'});
        }
    });

    function checkCheckboxes() {
        $('.hiddenValue').parents('tr').hide();
        let saveCardMode = $('#woocommerce_hkd_evocabank_save_card').is(':checked');
        if (saveCardMode) {
            $('.saveCardInfo').parents('tr').show();
        } else {
            $('.saveCardInfo').parents('tr').hide();
        }
    }

    $('.terms_div_evoca').hide();

    $('a#toggle-terms_div_evoca').click(function () {
        if($('.terms_div_evoca').is(':visible')){
            $("#pluginMainWrap").css("width", "45%");
        }else{
            $("#pluginMainWrap").css("width", "60%");
        }
        $('.terms_div_evoca').slideToggle(500);
        return false;
    });
    $("#mainform .woocommerce-save-button").click(function () {
        if (
            ($('#terms_evoca').length &&  $("#terms_evoca").is(':checked')) || (!$('#terms_evoca').length)
        ) {
            return true;
        } else {
            $('.accept_terms_div_evoca').addClass('custom-select is-invalid');
            $('#terms-error_evoca').text('Խնդրում ենք համաձայնվել Հավելվածի Պայմաններ և դրույթներ -ին').show();
            return false;
        }
    });
});
