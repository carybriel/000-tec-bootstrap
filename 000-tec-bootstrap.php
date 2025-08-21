<?php
/**
 * Plugin Name: 000 Tec Bootstrap
 * Description: Prevents The Events Calendar plugins from loading on non-event pages of the main site.
 */

// This plugin must be placed in the /wp-content/mu-plugins/ directory
// The plugin name begin with 000, so that it loads before other MU plugins do (for example, object cache plugins).

add_filter( 'option_active_plugins', function ( $plugins ) {
    // Only act on the main site
    if ( ! is_main_site() ) {
        return $plugins;
    }

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';

    // Bail on admin, REST, Ajax, Cron, CLI
    if (
        defined( 'WP_ADMIN' ) && WP_ADMIN ||
        defined( 'REST_REQUEST' ) && REST_REQUEST ||
        defined( 'DOING_AJAX' ) && DOING_AJAX ||
        defined( 'DOING_CRON' ) && DOING_CRON ||
        defined( 'WP_CLI' ) && WP_CLI ||
        str_starts_with( $request_uri, '/wp-json/' )
    ) {
        return $plugins;
    }

    // Parse and normalize the request path
    $request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
    $parsed_path = trim( parse_url( $request_uri, PHP_URL_PATH ), '/' );

    // If path starts with "events" or "event", allow plugins to load
    if (
        str_starts_with( $parsed_path, 'events' ) ||
        str_starts_with( $parsed_path, 'event' ) ||
        str_starts_with( $parsed_path, 'organizer' ) ||
        str_starts_with( $parsed_path, 'venue' )
    ) {
        return $plugins;
    }

    // Plugins to disable if not on an event-related page
    $plugins_to_disable = [
        'the-events-calendar/the-events-calendar.php',
        'events-calendar-pro/events-calendar-pro.php',
        'events-calendar-pro/the-events-calendar-filterbar.php',
    ];

    return array_values( array_diff( $plugins, $plugins_to_disable ) );
}, 1 );