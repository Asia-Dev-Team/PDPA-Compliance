<?php
/**
 * Plugin Name: Freepass PDPA Compliance
 * Plugin URI:  https://freepass.asia
 * Description: WordPress plugin for Adds a PDPA-compliant cookie consent banner to your site.
 * Version:     1.0.0
 * Author:      Mike Art (@trueresort)
 * Author URI:  https://trueresort.net
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: freepasspdpa
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Enqueue scripts and styles
function freepasspdpa_enqueue_scripts() {
    // Enqueue styles
    wp_enqueue_style(
        'freepasspdpa-style',
        plugin_dir_url( __FILE__ ) . 'css/freepasspdpa.css',
        array(),
        '1.0.0'
    );

    // Enqueue scripts
    wp_enqueue_script(
        'freepasspdpa-script',
        plugin_dir_url( __FILE__ ) . 'js/freepasspdpa.js',
        array(),
        '1.0.0',
        true
    );

    // Get plugin settings
    $options = get_option( 'freepasspdpa_options' );
    $message = isset( $options['message'] ) ? $options['message'] : __( 'We use cookies to improve your experience on our site. By clicking "Accept", you agree to our Privacy Policy.', 'freepasspdpa' );
    $accept_text = isset( $options['accept_text'] ) ? $options['accept_text'] : __( 'Accept', 'freepasspdpa' );
    $decline_text = isset( $options['decline_text'] ) ? $options['decline_text'] : __( 'Decline', 'freepasspdpa' );
    $privacy_url = isset( $options['privacy_url'] ) ? $options['privacy_url'] : '/privacy-policy';
    $privacy_text = isset( $options['privacy_text'] ) ? $options['privacy_text'] : __( 'Privacy Policy', 'freepasspdpa' );

    // Pass data from PHP to JS
    wp_localize_script(
        'freepasspdpa-script',
        'freepasspdpa_settings',
        array(
            'message'       => $message,
            'accept_text'   => $accept_text,
            'decline_text'  => $decline_text,
            'privacy_url'   => $privacy_url,
            'privacy_text'  => $privacy_text,
        )
    );
}
add_action( 'wp_enqueue_scripts', 'freepasspdpa_enqueue_scripts' );

// Add the settings menu to the admin panel
function freepasspdpa_add_admin_menu() {
    add_options_page(
        'Freepass PDPA Settings',
        'Freepass PDPA',
        'manage_options',
        'freepasspdpa',
        'freepasspdpa_options_page'
    );
}
add_action( 'admin_menu', 'freepasspdpa_add_admin_menu' );

// Initialize settings
function freepasspdpa_settings_init() {
    register_setting( 'freepasspdpa_settings', 'freepasspdpa_options' );

    add_settings_section(
        'freepasspdpa_section',
        __( 'Cookie Consent Settings', 'freepasspdpa' ),
        null,
        'freepasspdpa_settings'
    );

    // Settings fields
    add_settings_field(
        'message',
        __( 'Consent Message', 'freepasspdpa' ),
        'freepasspdpa_message_render',
        'freepasspdpa_settings',
        'freepasspdpa_section'
    );

    add_settings_field(
        'accept_text',
        __( 'Accept Button Text', 'freepasspdpa' ),
        'freepasspdpa_accept_text_render',
        'freepasspdpa_settings',
        'freepasspdpa_section'
    );

    add_settings_field(
        'decline_text',
        __( 'Decline Button Text', 'freepasspdpa' ),
        'freepasspdpa_decline_text_render',
        'freepasspdpa_settings',
        'freepasspdpa_section'
    );

    add_settings_field(
        'privacy_url',
        __( 'Privacy Policy URL', 'freepasspdpa' ),
        'freepasspdpa_privacy_url_render',
        'freepasspdpa_settings',
        'freepasspdpa_section'
    );

    add_settings_field(
        'privacy_text',
        __( 'Privacy Policy Text', 'freepasspdpa' ),
        'freepasspdpa_privacy_text_render',
        'freepasspdpa_settings',
        'freepasspdpa_section'
    );
}
add_action( 'admin_init', 'freepasspdpa_settings_init' );

// Settings field render functions
function freepasspdpa_message_render() {
    $options = get_option( 'freepasspdpa_options' );
    ?>
    <textarea cols="50" rows="5" name="freepasspdpa_options[message]"><?php echo esc_textarea( $options['message'] ); ?></textarea>
    <?php
}

function freepasspdpa_accept_text_render() {
    $options = get_option( 'freepasspdpa_options' );
    ?>
    <input type="text" name="freepasspdpa_options[accept_text]" value="<?php echo esc_attr( $options['accept_text'] ); ?>" />
    <?php
}

function freepasspdpa_decline_text_render() {
    $options = get_option( 'freepasspdpa_options' );
    ?>
    <input type="text" name="freepasspdpa_options[decline_text]" value="<?php echo esc_attr( $options['decline_text'] ); ?>" />
    <?php
}

function freepasspdpa_privacy_url_render() {
    $options = get_option( 'freepasspdpa_options' );
    ?>
    <input type="text" name="freepasspdpa_options[privacy_url]" value="<?php echo esc_attr( $options['privacy_url'] ); ?>" />
    <?php
}

function freepasspdpa_privacy_text_render() {
    $options = get_option( 'freepasspdpa_options' );
    ?>
    <input type="text" name="freepasspdpa_options[privacy_text]" value="<?php echo esc_attr( $options['privacy_text'] ); ?>" />
    <?php
}

// Plugin settings page
function freepasspdpa_options_page() {
    ?>
    <form action="options.php" method="post">
        <h2><?php esc_html_e( 'Freepass PDPA Settings', 'freepasspdpa' ); ?></h2>
        <?php
        settings_fields( 'freepasspdpa_settings' );
        do_settings_sections( 'freepasspdpa_settings' );
        submit_button();
        ?>
    </form>
    <?php
}