jQuery(document).ready(function ($) {

    $('.single_add_to_cart_button, .ajax_add_to_cart').on('click', function () {
        ym(65800849,'reachGoal','korzina');
        gtag('event', 'v_korzinu', {'event_category': 'knopka'});
    });

    $('.tinkoff_credit_submit').on('click', function () {
        ym(65800849,'reachGoal','kredras');
        gtag('event', 'kredit_rass', {'event_category': 'knopka'});
    });

    $('.tm-woowishlist-button-single').on('click', function () {
        ym(65800849,'reachGoal','want');
        gtag('event', 'want', {'event_category': 'knopka'});
    });

});
