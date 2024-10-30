jQuery(document).ready(function ($) {
    ({ fields, linkPlaceholder, shortCodePlaceholder } = mupMain.panel_menus );

    $(document).on('change', '.mup-menu-type', function () {
        let placeholder;
        let type;

        if ($(this).val() === 'link') {
            type = 'url';
            placeholder = linkPlaceholder;
        } else {
            type = 'text';
            placeholder = shortCodePlaceholder;
        }

        $(this).parent().find('.mup-menu-content').attr('placeholder', placeholder);
        $(this).parent().find('.mup-menu-content').attr('type', type);
    });

    $(document).on('click', '#mup-add-menu-btn', function () {
        $('#mup-menu-fields-wrap').append(fields);
        let last = $('#mup-menu-fields-wrap > div').last();
        let order = [];

        $('#mup-menu-fields-wrap > div').each(function() {
            order.push($(this).find('.mup-menu-order').val());
        });

        last.css('order', Math.max(...order) + 1);
        last.find('.mup-menu-order').val(Math.max(...order) + 1);
    });

    $(document).on('click', '.mup-remove-menu', function (e) {
        e.preventDefault();
        $(this).parent().parent().parent().fadeOut(200);
        setTimeout(() => $(this).parent().parent().parent().remove(), 200);
    });
});