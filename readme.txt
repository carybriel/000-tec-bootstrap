=== 000 Tec Bootstrap ===
Contributors: Cary Briel
Tags: events, performance, mu-plugins, the-events-calendar
Requires at least: 6.0
Tested up to: 6.6
Stable tag: 1.0
License: MIT

Prevents The Events Calendar plugins from loading on non-event pages of the main site, improving performance.

== Description ==

This must-use plugin disables The Events Calendar plugins (and related add-ons) on non-event pages of the main site.  
By limiting plugin loading only to event-related pages, it reduces unnecessary overhead and improves site performance.

### Features
- Only runs on the **main site** in a multisite network.
- Detects requests to `/events`, `/event`, `/organizer`, and `/venue` paths and allows The Events Calendar plugins to load.
- Automatically bypasses admin, REST, Ajax, Cron, and WP-CLI requests to avoid breaking functionality.
- Lightweight — uses the `option_active_plugins` filter to disable specific plugins before they load.

### Important Note
When this plugin is active, any templates or custom blocks that reference event data **must use standard WordPress functions (e.g. `WP_Query`, `get_posts`)** to query Events Calendar content types.  
Do **not** rely on `tribe_*` functions or APIs, as they are only available when The Events Calendar is fully bootstrapped — which will not be the case on non-event pages.

== Installation ==

1. Copy `000-tec-bootstrap.php` into your `wp-content/mu-plugins/` directory.  
   - If `mu-plugins` does not exist, create it.  
2. Make sure the filename begins with `000` so it loads before other MU plugins (e.g. object caching).  
3. No further configuration is required.

== Frequently Asked Questions ==

= Why use an MU plugin? =  
MU (must-use) plugins load automatically and cannot be deactivated via the admin UI. This ensures the filtering logic always runs before other plugins.

= Which plugins are disabled? =  
- The Events Calendar (`the-events-calendar/the-events-calendar.php`)  
- Events Calendar Pro (`events-calendar-pro/events-calendar-pro.php`)  
- Filter Bar (`events-calendar-pro/the-events-calendar-filterbar.php`)  

= How should I query event data in templates or blocks? =  
Use standard WordPress functions (`WP_Query`, `get_posts`, etc.) against the `tribe_events` custom post type and related taxonomies.  
Do **not** use `tribe_*` functions outside event pages, as The Events Calendar is not initialized and those functions will not be available.

= Will this break event pages? =  
No. Event-related pages continue to load normally with the required plugins.

== Changelog ==

= 1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0 =
Initial release.
