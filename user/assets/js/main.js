jQuery(document).ready(function ($){
    const avatarInput = $('#mup-upload-pro-pic');

    function readProPicURL(input) {
        if (input.prop('files') && input.prop('files')[0]) {
            let reader = new FileReader();

            reader.onload = function (e) {
                $('#mup-pro-pic img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.prop('files')[0]);
        }
    }

    avatarInput.on('change', function (){
        readProPicURL($(this));
    });
});