<?php
/**
 * Plugin Name: IndieNews
 * Plugin URI: https://github.com/pfefferle/wordpress-indienews
 * Description: Push your IndieWeb articles to the IndieNews page
 * Author: Matthias Pfefferle
 * Author URI: https://notiz.blog/
 * Version: 1.2.2
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: indienews
 * Domain Path: /languages
 * Update URI: https://github.com/pfefferle/wordpress-indienews
 */

define( 'INDIENEWS_LANGUAGES', array( 'en', 'sv', 'de', 'fr', 'nl' ) );
define( 'INDIEWEB_XYZ_LANGUAGES', array( 'en', 'de' ) );

/**
 * Initialize the plugin.
 */
function indienews_init() {
	// for plugins
	load_plugin_textdomain(
		'indienews', // unique slug
		false, // deprecated
		dirname( plugin_basename( __FILE__ ) ) . '/languages/' // path
	);

	require_once( dirname( __FILE__ ) . '/includes/functions.php' );

	require_once( dirname( __FILE__ ) . '/includes/class-indienews-widget.php' );
	add_action( 'wp_dashboard_setup', array( 'Indienews_Widget', 'dashboard_widgets' ) );

	require_once( dirname( __FILE__ ) . '/includes/class-indienews.php' );
	add_filter( 'term_links-post_tag', array( 'Indienews', 'add_indienews_tag_link' ) );
	add_filter( 'webmention_links', array( 'Indienews', 'send_webmentions' ), 10, 2 );
}
add_action( 'init', 'indienews_init' );
