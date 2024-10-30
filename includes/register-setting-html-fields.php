<?php
function mup_first_name_setting_fields( $id = '' ) {
    $opt = mup_first_name_settings();

    ob_start(); ?>

    <div class="mup-field-wrap">
        <?php if ( ! empty( $id ) ): ?>
            <input type="hidden" name="first_name_id" value="<?php esc_attr_e( $id ); ?>"/>
        <?php endif; ?>

        <input class="mup-field-name" type="hidden" name="first_name"/>

        <p>
            <input type="text" placeholder="<?php esc_attr_e( $opt['placeholder'] ); ?>" disabled/>
        </p>

        <div class="mup-field-actions">
            <a class="mup-show-field-settings" href="#">
                <?php _e( 'Options', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-delete-field" href="#">
                <?php _e( 'Delete', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-up" href="#">
                <?php _e( 'Go Up', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-down" href="#">
                <?php _e( 'Go Down', 'mas-user-panel' ); ?>
            </a>
        </div>

        <div class="mup-field-settings">
            <p>
                <label for="mup-first-name-placeholder">
                    <?php _e( 'Placeholder', 'mas-user-panel' ); ?>
                </label>

                <input for="mup-first-name-placeholder" type="text" name="first_name_placeholder" value="<?php esc_attr_e( $opt['placeholder'] ); ?>"/>
            </p>

            <p>
                <input id="mup-first-name-required" type="checkbox" name="first_name_required" <?php checked( $opt['required'] ); ?>/>

                <label for="mup-first-name-required">
                    <?php _e( 'Required', 'mas-user-panel' ); ?>
                </label>
            </p>

            <p>
                <label for="mup-first-name-min">
                    <?php _e( 'Minimum Letter', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-first-name-min" type="number" name="first_name_min" value="<?php esc_attr_e( $opt['min'] ); ?>" min="0"/>
            </p>

            <p>
                <label for="mup-first-name-info">
                    <?php _e( 'Field Info', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-first-name-info" type="text" name="first_name_info" value="<?php esc_attr_e( $opt['info'] ); ?>"/>
            </p>
        </div>
    </div>

    <?php return ob_get_clean();
}

function mup_last_name_setting_fields( $id = '' ) {
    $opt = mup_last_name_settings();

    ob_start(); ?>

    <div class="mup-field-wrap">
        <?php if ( ! empty( $id ) ): ?>
            <input type="hidden" name="last_name_id" value="<?php esc_attr_e( $id ); ?>"/>
        <?php endif; ?>

        <input class="mup-field-name" type="hidden" name="last_name"/>

        <p>
            <input type="text" placeholder="<?php esc_attr_e( $opt['placeholder'] ); ?>" disabled/>
        </p>

        <div class="mup-field-actions">
            <a class="mup-show-field-settings" href="#">
                <?php _e( 'Options', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-delete-field" href="#">
                <?php _e( 'Delete', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-up" href="#">
                <?php _e( 'Go Up', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-down" href="#">
                <?php _e( 'Go Down', 'mas-user-panel' ); ?>
            </a>
        </div>

        <div class="mup-field-settings">
            <p>
                <label for="mup-last-name-placeholder">
                    <?php _e( 'Placeholder', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-last-name-placeholder" type="text" name="last_name_placeholder" value="<?php esc_attr_e( $opt['placeholder'] ); ?>"/>
            </p>

            <p>
                <input id="mup-last-name-required" type="checkbox" name="last_name_required" <?php checked( $opt['required'] ); ?>/>

                <label for="mup-last-name-required">
                    <?php _e( 'Required', 'mas-user-panel' ); ?>
                </label>
            </p>

            <p>
                <label for="mup-last-name-min">
                    <?php _e( 'Minimum Letter', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-last-name-min" type="number" name="last_name_min" value="<?php esc_attr_e( $opt['min'] ); ?>" min="0"/>
            </p>

            <p>
                <label for="mup-last-name-info">
                    <?php _e( 'Field Info', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-last-name-info" type="text" name="last_name_info" value="<?php esc_attr_e( $opt['info'] ); ?>"/>
            </p>
        </div>
    </div>

    <?php return ob_get_clean();
}

function mup_display_name_setting_fields( $id = '' ) {
    $opt = mup_display_name_settings();
    $id_attr = 'display-name';
    $name = 'display_name';

    ob_start(); ?>

    <div class="mup-field-wrap">
        <?php if ( ! empty( $id ) ): ?>
            <input type="hidden" name="<?php esc_attr_e( $name ); ?>_id" value="<?php esc_attr_e( $id ); ?>"/>
        <?php endif; ?>

        <input class="mup-field-name" type="hidden" name="<?php esc_attr_e( $name ); ?>"/>

        <p>
            <input type="text" placeholder="<?php esc_attr_e( $opt['placeholder'] ); ?>" disabled/>
        </p>

        <div class="mup-field-actions">
            <a class="mup-show-field-settings" href="#">
                <?php _e( 'Options', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-delete-field" href="#">
                <?php _e( 'Delete', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-up" href="#">
                <?php _e( 'Go Up', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-down" href="#">
                <?php _e( 'Go Down', 'mas-user-panel' ); ?>
            </a>
        </div>

        <div class="mup-field-settings">
            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder">
                    <?php _e( 'Placeholder', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder" type="text" name="<?php esc_attr_e( $name ); ?>_placeholder" value="<?php esc_attr_e( $opt['placeholder'] ); ?>"/>
            </p>

            <p>
                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-required" type="checkbox" name="<?php esc_attr_e( $name ); ?>_required" <?php checked( $opt['required'] ); ?>/>

                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-required">
                    <?php _e( 'Required', 'mas-user-panel' ); ?>
                </label>
            </p>

            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-min">
                    <?php _e( 'Minimum Letter', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-min" type="number" name="<?php esc_attr_e( $name ); ?>_min" value="<?php esc_attr_e( $opt['min'] ); ?>" min="0"/>
            </p>

            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-info">
                    <?php _e( 'Field Info', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-info" type="text" name="<?php esc_attr_e( $name ); ?>_info" value="<?php esc_attr_e( $opt['info'] ); ?>"/>
            </p>
        </div>
    </div>

    <?php return ob_get_clean();
}

function mup_user_login_setting_fields( $id = '' ) {
    $opt = mup_user_login_settings();
    $id_attr = 'user-login';
    $name = 'user_login';

    ob_start(); ?>

    <div class="mup-field-wrap">
        <?php if ( ! empty( $id ) ): ?>
            <input type="hidden" name="<?php esc_attr_e( $name ); ?>_id" value="<?php esc_attr_e( $id ); ?>"/>
        <?php endif; ?>

        <input class="mup-field-name" type="hidden" name="<?php esc_attr_e( $name ); ?>"/>

        <p>
            <input type="text" placeholder="<?php esc_attr_e( $opt['placeholder'] ); ?>" disabled/>
        </p>

        <div class="mup-field-actions">
            <a class="mup-show-field-settings" href="#">
                <?php _e( 'Options', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-up" href="#">
                <?php _e( 'Go Up', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-down" href="#">
                <?php _e( 'Go Down', 'mas-user-panel' ); ?>
            </a>
        </div>

        <div class="mup-field-settings">
            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder">
                    <?php _e( 'Placeholder', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder" type="text" name="<?php esc_attr_e( $name ); ?>_placeholder" value="<?php esc_attr_e( $opt['placeholder'] ); ?>"/>
            </p>

            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-min">
                    <?php _e( 'Minimum Letter', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-min" type="number" name="<?php esc_attr_e( $name ); ?>_min" value="<?php esc_attr_e( $opt['min'] ); ?>" min="0"/>
            </p>

            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-info">
                    <?php _e( 'Field Info', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-info" type="text" name="<?php esc_attr_e( $name ); ?>_info" value="<?php esc_attr_e( $opt['info'] ); ?>"/>
            </p>
        </div>
    </div>

    <?php return ob_get_clean();
}

function mup_user_email_setting_fields( $id = '' ) {
    $opt = mup_user_email_settings();
    $id_attr = 'user-email';
    $name = 'user_email';

    ob_start(); ?>

    <div class="mup-field-wrap">
        <?php if ( ! empty( $id ) ): ?>
            <input type="hidden" name="<?php esc_attr_e( $name ); ?>_id" value="<?php esc_attr_e( $id ); ?>"/>
        <?php endif; ?>

        <input class="mup-field-name" type="hidden" name="<?php esc_attr_e( $name ); ?>"/>

        <p>
            <input type="text" placeholder="<?php esc_attr_e( $opt['placeholder'] ); ?>" disabled/>
        </p>

        <div class="mup-field-actions">
            <a class="mup-show-field-settings" href="#">
                <?php _e( 'Options', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-up" href="#">
                <?php _e( 'Go Up', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-down" href="#">
                <?php _e( 'Go Down', 'mas-user-panel' ); ?>
            </a>
        </div>

        <div class="mup-field-settings">
            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder">
                    <?php _e( 'Placeholder', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder" type="text" name="<?php esc_attr_e( $name ); ?>_placeholder" value="<?php esc_attr_e( $opt['placeholder'] ); ?>"/>
            </p>

            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-info">
                    <?php _e( 'Field Info', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-info" type="text" name="<?php esc_attr_e( $name ); ?>_info" value="<?php esc_attr_e( $opt['info'] ); ?>"/>
            </p>
        </div>
    </div>

    <?php return ob_get_clean();
}

function mup_user_pass_setting_fields( $id = '' ) {
    $opt = mup_user_pass_settings();
    $id_attr = 'user-pass';
    $name = 'user_pass';

    ob_start(); ?>

    <div class="mup-field-wrap">
        <?php if ( ! empty( $id ) ): ?>
            <input type="hidden" name="<?php esc_attr_e( $name ); ?>_id" value="<?php esc_attr_e( $id ); ?>"/>
        <?php endif; ?>

        <input class="mup-field-name" type="hidden" name="<?php esc_attr_e( $name ); ?>"/>

        <p>
            <input type="text" placeholder="<?php esc_attr_e( $opt['placeholder'] ); ?>" disabled/>
        </p>

        <div class="mup-field-actions">
            <a class="mup-show-field-settings" href="#">
                <?php _e( 'Options', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-up" href="#">
                <?php _e( 'Go Up', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-down" href="#">
                <?php _e( 'Go Down', 'mas-user-panel' ); ?>
            </a>
        </div>

        <div class="mup-field-settings">
            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder">
                    <?php _e( 'Placeholder', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder" type="text" name="<?php esc_attr_e( $name ); ?>_placeholder" value="<?php esc_attr_e( $opt['placeholder'] ); ?>"/>
            </p>

            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder">
                    <?php _e( 'Confirm password placeholder', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder" type="text" name="conf_<?php esc_attr_e( $name ); ?>_placeholder" value="<?php esc_attr_e( $opt['conf_placeholder'] ); ?>"/>
            </p>

            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-info">
                    <?php _e( 'Field Info', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-info" type="text" name="<?php esc_attr_e( $name ); ?>_info" value="<?php esc_attr_e( $opt['info'] ); ?>"/>
            </p>

            <p>
                <label for="mup-user-pass-min">
                    <?php _e( 'Minimum Letter', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-user-pass-min" type="number" name="<?php esc_attr_e( $name ); ?>_min" value="<?php esc_attr_e( $opt['min'] ); ?>" min="0"/>
            </p>
        </div>
    </div>

    <?php return ob_get_clean();
}

function mup_user_url_setting_fields( $id = '' ) {
    $opt = mup_user_url_settings();
    $id_attr = 'user-url';
    $name = 'user_url';

    ob_start(); ?>

    <div class="mup-field-wrap">
        <?php if ( ! empty( $id ) ): ?>
            <input type="hidden" name="<?php esc_attr_e( $name ); ?>_id" value="<?php esc_attr_e( $id ); ?>"/>
        <?php endif; ?>

        <input class="mup-field-name" type="hidden" name="<?php esc_attr_e( $name ); ?>"/>

        <p>
            <input type="text" placeholder="<?php esc_attr_e( $opt['placeholder'] ); ?>" disabled/>
        </p>

        <div class="mup-field-actions">
            <a class="mup-show-field-settings" href="#">
                <?php _e( 'Options', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-delete-field" href="#">
                <?php _e( 'Delete', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-up" href="#">
                <?php _e( 'Go Up', 'mas-user-panel' ); ?>
            </a>

            <a class="mup-field-down" href="#">
                <?php _e( 'Go Down', 'mas-user-panel' ); ?>
            </a>
        </div>

        <div class="mup-field-settings">
            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder">
                    <?php _e( 'Placeholder', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-placeholder" type="text" name="<?php esc_attr_e( $name ); ?>_placeholder" value="<?php esc_attr_e( $opt['placeholder'] ); ?>"/>
            </p>

            <p>
                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-required" type="checkbox" name="<?php esc_attr_e( $name ); ?>_required" <?php checked( $opt['required'] ); ?>/>

                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-required">
                    <?php _e( 'Required', 'mas-user-panel' ); ?>
                </label>
            </p>

            <p>
                <label for="mup-<?php esc_attr_e( $id_attr ); ?>-info">
                    <?php _e( 'Field Info', 'mas-user-panel' ); ?>
                </label>

                <input id="mup-<?php esc_attr_e( $id_attr ); ?>-info" type="text" name="<?php esc_attr_e( $name ); ?>_info" value="<?php esc_attr_e( $opt['info'] ); ?>"/>
            </p>
        </div>
    </div>

    <?php return ob_get_clean();
}
