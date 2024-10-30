jQuery( document ).ready( function( $ ) {
// trigger the wdmChkPwdStrength
    $( 'body' ).on( 'keyup', 'input[name=user_pass], input[name=user_pass_confirm]', function( event ) {
        wdmChkPwdStrength(
            // password field
            $('input[name=user_pass]'),
            // confirm password field
            $('input[name=user_pass_confirm]'),
            // strength status
            $('#mup-password-strength'),
            // Submit button
            $('input[type=submit]'),
            // blacklisted words which should not be a part of the password
            ['admin', 'happy', 'hello', '1234']
        );
    });

    function wdmChkPwdStrength( $pwd,  $confirmPwd, $strengthStatus, $submitBtn, blacklistedWords ) {
        var pwd = $pwd.val();
        var confirmPwd = $confirmPwd.val();
    
        // extend the blacklisted words array with those from the site data
        blacklistedWords = blacklistedWords.concat( wp.passwordStrength.userInputBlacklist() )
    
        // every time a letter is typed, reset the submit button and the strength meter status
        // disable the submit button
        $submitBtn.attr( 'disabled', 'disabled' );
        $strengthStatus.removeClass( 'mup-pass-short mup-pass-bad mup-pass-good mup-pass-strong mup-pass-mismatch' );
    
        // calculate the password strength
        var pwdStrength = wp.passwordStrength.meter( pwd, blacklistedWords, confirmPwd );
    
        // check the password strength
        switch ( pwdStrength ) {
            case 2:
                $strengthStatus.addClass( 'mup-pass-bad' ).html( pwsL10n.bad );
                break;
            case 3:
                $strengthStatus.addClass( 'mup-pass-good' ).html( pwsL10n.good );
                break;
            case 4:
                $strengthStatus.addClass( 'mup-pass-strong' ).html( pwsL10n.strong );
                break;
            case 5:
                $strengthStatus.addClass( 'mup-pass-mismatch' ).html( pwsL10n.mismatch );
                break;
            default:
                $strengthStatus.addClass( 'mup-pass-short' ).html( pwsL10n.short );
        }

        // set the status of the submit button
        if ( 4 === pwdStrength && '' !== confirmPwd.trim() ) {
            $submitBtn.removeAttr( 'disabled' );
        }

        return pwdStrength;
    }
});