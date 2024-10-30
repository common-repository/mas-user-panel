jQuery(document).ready(function ($) {
    let existingFields = [];

    ({first_name, last_name, display_name, user_login, user_email, user_pass, user_url} = mupRegFields);

    $('.mup-field-name').each(function () {
        existingFields.push($(this).attr('name'));
    });

    function fieldIndex() {
        $('.mup-field-wrap').each(function () {
            $(this).find('.mup-field-name').val($(this).index())
        });
    }

    fieldIndex();

    function addField(fieldName, field, type) {
        const wrap = $('#mup-reg-fields-wrap');

        if (type === fieldName) {
            if ($.inArray(type, existingFields) === -1) {
                wrap.append(field);
                existingFields.push(type);
                fieldIndex();
            }
        }
    }

    $(document).on('click', '#mup-buttons-wrap button', function (e) {
        let type = $(this).data('type');

        addField('first_name', first_name, type);
        addField('last_name', last_name, type);
        addField('display_name', display_name, type);
        addField('user_login', user_login, type);
        addField('user_email', user_email, type);
        addField('user_pass', user_pass, type);
        addField('user_url', user_url, type);
    });

    $(document).on('click', '.mup-show-field-settings', function (e) {
        e.preventDefault();
        $('.mup-field-settings').not($(this).parent().next()).slideUp(200);
        $(this).parent().next().slideToggle(200);
    });

    $(document).on('click', '.mup-delete-field', function (e) {
        e.preventDefault();
        let name = $(this).parent().parent().find('.mup-field-name').attr('name');
        const wrap = $(this).parents('.mup-field-wrap');
        wrap.fadeOut(200);
        existingFields = existingFields.filter(field => field !== name);

        setTimeout(() => {
            wrap.remove();
            fieldIndex();
        }, 200);
    });

    $(document).on('click', '.mup-field-up', function (e) {
        e.preventDefault();
        $(this).parents('.mup-field-wrap').after($(this).parents('.mup-field-wrap').prev());
        fieldIndex();
    });

    $(document).on('click', '.mup-field-down', function (e) {
        e.preventDefault();
        $(this).parents('.mup-field-wrap').next().after($(this).parents('.mup-field-wrap'));
        fieldIndex();
    });
});