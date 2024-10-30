<?php
$allowed = [ 'general', 'login', 'register', 'panel' ];

if ( isset( $_GET['section'] ) and in_array( $_GET['section'], $allowed ) ) {
    $section = $_GET['section'];
    include_once MUP_ADMIN_PATH . "/pages/form-handler/$section.php";
} else {
    include_once MUP_ADMIN_PATH . '/pages/form-handler/general.php';
}
?>

<div id="mup-wrap" class="wrap">
    <h1><?php _e( 'Settings', 'mas-user-panel' ); ?></h1>

    <?php if ( isset( $error ) ): ?>
        <div class="notice notice-error is-dismissible">
            <p><strong><?php esc_html_e( $error ); ?></strong></p>
        </div>
    <?php endif; ?>

    <?php if ( isset( $success ) ): ?>
        <div class="notice notice-success is-dismissible">
            <p><strong><?php esc_html_e( $success ); ?></strong></p>
        </div>
    <?php endif; ?>

    <div id="mup-tabs">
        <div id="mup-side-tab" class="nav-tab-wrapper">
            <a class="nav-tab <?php echo ( ! isset( $section ) or ( isset( $section ) and $section === 'general' ) ) ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( [ 'section' => 'general' ] ) ); ?>">
                <?php _e( 'General', 'mas-user-panel' ); ?>
            </a>

            <a class="nav-tab <?php echo ( isset( $section ) and $section === 'login' ) ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( [ 'section' => 'login' ] ) ); ?>">
                <?php _e( 'Login', 'mas-user-panel' ); ?>
            </a>

            <a class="nav-tab <?php echo ( isset( $section ) and $section === 'register' ) ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( [ 'section' => 'register' ] ) ); ?>">
                <?php _e( 'Register', 'mas-user-panel' ); ?>
            </a>

            <a class="nav-tab <?php echo ( isset( $section ) and $section === 'panel' ) ? 'nav-tab-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( [ 'section' => 'panel' ] ) ); ?>">
                <?php _e( 'User Panel', 'mas-user-panel' ); ?>
            </a>
        </div>

        <div id="mup-content-tab">
            <?php
            if ( isset( $section ) ) {
                include_once MUP_ADMIN_PATH . "pages/setting-forms/$section.php";
            } else {
                include_once MUP_ADMIN_PATH . 'pages/setting-forms/general.php';
            }
            ?>
        </div>
    </div>
</div>