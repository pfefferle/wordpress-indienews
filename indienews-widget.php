<?php
/**
 * IndieNewsWidget class.
 *
 * @author Matthias Pfefferle
 */
class IndieNewsWidget {
	/**
	 * Init dashboards widgets
	 */
	public static function dashboard_widgets() {
		foreach ( INDIENEWS_LANGUAGES as $lang ) {
			wp_add_dashboard_widget( "indienews_feed_{$lang}", 'IndieNews ' . strtoupper( $lang ), function() use( $lang ) {
				self::indienews_feed( $lang );
			});
		}

		wp_add_dashboard_widget( "this_week_feed_{$lang}", __( 'This Week in the IndieWeb', 'indienews' ), array( 'IndieNewsWidget', 'this_week_feed' ) );

		add_filter( 'default_hidden_meta_boxes', array( 'IndieNewsWidget', 'default_hidden_meta_boxes' ), 99 );
	}

	/**
	 * IndieNews feed handler
	 */
	public static function indienews_feed( $lang = 'en' ) {
		echo '<div class="rss-widget">';
		@wp_widget_rss_output(array(
			'url' => 'https://granary.io/url?input=html&output=atom&url=https%3A//news.indieweb.org/' . $lang,
			'items' => 10,
			'show_summary' => 1,
			'show_author' => 0,
			'show_date' => 1
		));
		echo '</div>';
	}

	/**
	 * "This Week in the IndieWeb" feed handler
	 */
	public static function this_week_feed() {
		echo '<div class="rss-widget">';
		wp_widget_rss_output(array(
			'url' => 'https://indieweb.org/this-week/feed.xml',
			'items' => 10,
			'show_summary' => 1,
			'show_author' => 0,
			'show_date' => 1
		));
		echo '</div>';
	}

	/**
	 * Hide every language that is not the blog language and not 'en'
	 */
	public static function default_hidden_meta_boxes( $list ) {
		$language = get_indienews_language();

		foreach ( INDIENEWS_LANGUAGES as $supported_language ) {
			if ( ! in_array( $supported_language, array( $language, 'en' ) ) ) {
				$list[] = "indienews_feed_{$supported_language}";
			}
		}

		return $list;
	}
}
