<?php
function mup_first_name( $settings ) {
    $settings = unserialize( $settings );
    $placeholder = $settings['placeholder'];
    $info = $settings['info'];

    ob_start(); ?>

    <p>
        <input type='text' name="first_name" placeholder="<?php esc_attr_e( $placeholder ); ?>"/>

        <?php if ( ! empty( $info ) ): ?>
            <span class='mup-input-info'><?php esc_html_e( $info ); ?></span>
        <?php endif; ?>
    </p>

    <?php echo ob_get_clean();
}

function mup_last_name( $settings ) {
    $settings = unserialize( $settings );
    $placeholder = $settings['placeholder'];
    $info = $settings['info'];

    ob_start(); ?>

    <p>
        <input type='text' name="last_name" placeholder="<?php esc_attr_e( $placeholder ); ?>"/>

        <?php if ( ! empty( $info ) ): ?>
            <span class='mup-input-info'><?php esc_html_e( $info ); ?></span>
        <?php endif; ?>
    </p>

    <?php echo ob_get_clean();
}

function mup_display_name( $settings ) {
    $settings = unserialize( $settings );
    $placeholder = $settings['placeholder'];
    $info = $settings['info'];

    ob_start(); ?>

    <p>
        <input type='text' name="display_name" placeholder="<?php esc_attr_e( $placeholder ); ?>"/>

        <?php if ( ! empty( $info ) ): ?>
            <span class='mup-input-info'><?php esc_html_e( $info ); ?></span>
        <?php endif; ?>
    </p>

    <?php echo ob_get_clean();
}

function mup_user_login( $settings ) {
    $settings = unserialize( $settings );
    $placeholder = $settings['placeholder'];
    $info = $settings['info'];

    ob_start(); ?>

    <p>
        <input type='text' name="user_login" placeholder="<?php esc_attr_e( $placeholder ); ?>"/>

        <?php if ( ! empty( $info ) ): ?>
            <span class='mup-input-info'><?php esc_html_e( $info ); ?></span>
        <?php endif; ?>
    </p>

    <?php echo ob_get_clean();
}

function mup_user_email( $settings ) {
    $settings = unserialize( $settings );
    $placeholder = $settings['placeholder'];
    $info = $settings['info'];

    ob_start(); ?>

    <p>
        <input type='email' name="user_email" placeholder="<?php esc_attr_e( $placeholder ); ?>"/>

        <?php if ( ! empty( $info ) ): ?>
            <span class='mup-input-info'><?php esc_html_e( $info ); ?></span>
        <?php endif; ?>
    </p>

    <?php echo ob_get_clean();
}

function mup_user_pass( $settings ) {
    $settings = unserialize( $settings );
    $placeholder = $settings['placeholder'];
    $conf_placeholder = $settings['conf_placeholder'];
    $info = $settings['info'];
    $register = mup_register_options();

    ob_start(); ?>

    <p>
        <input type='password' name="user_pass" placeholder="<?php esc_attr_e( $placeholder ); ?>"/>

        <?php if ( ! empty( $info ) ): ?>
            <span class='mup-input-info'><?php esc_html_e( $info ); ?></span>
        <?php endif; ?>
    </p>

    <p>
        <input type='password' name="user_pass_confirm" placeholder="<?php esc_attr_e( $conf_placeholder ); ?>"/>
    </p>

    <?php if ( $register['pass_strength'] ): ?>
        <p>
            <span id="mup-password-strength"></span>
        </p>
    <?php endif; ?>

    <?php echo ob_get_clean();
}

function mup_user_url( $settings ) {
    $settings = unserialize( $settings );
    $placeholder = $settings['placeholder'];
    $info = $settings['info'];

    ob_start(); ?>

    <p>
        <input type='url' name="user_url" placeholder="<?php esc_attr_e( $placeholder ); ?>"/>

        <?php if ( ! empty( $info ) ): ?>
            <span class='mup-input-info'><?php esc_html_e( $info ); ?></span>
        <?php endif; ?>
    </p>

    <?php echo ob_get_clean();
}