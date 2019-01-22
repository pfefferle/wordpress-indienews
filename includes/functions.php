<?php
/**
 * Get the blogs language and check if it supported.
 *
 * @return string The blogs language with a default fallback.
 */
function get_indienews_language( $supported_languages = INDIENEWS_LANGUAGES ) {
	$locale = get_locale();
	$locale = substr( $locale, 0, 2 );

	$supported_languages = apply_filters( 'indienews_supported_languages', $supported_languages );

	if ( in_array( $locale, $supported_languages ) ) {
		return $locale;
	} else {
		return apply_filters( 'indienews_default_languages', 'en' );
	}
}

/**
 * Get the link to the correct IndieNews page.
 *
 * @return string The correct URL.
 */
function get_indienews_url() {
	return 'https://news.indieweb.org/' . get_indienews_language( INDIENEWS_LANGUAGES );
}

/**
 * Get the link to the correct IndieNews.xyz page.
 *
 * @return string The correct URL.
 */
function get_indienews_xyz_url( $post_id = null ) {
	if ( ! $post_id ) {
		$post = get_post();
		$post_id = $post->ID;
	}

	$categories = wp_get_post_categories( $post_id );

	if ( $categories ) {
		$category = current( $categories );
		$category = $category['slug'];
	} else {
		$category = 'hottubs';
	}

	return 'https://indieweb.xyz/' . get_indienews_language( INDIEWEB_XYZ_LANGUAGES ) . '/' . $category;
}

/**
 * Get the link to the correct IndieWeb.xyz page.
 *
 * @return string The correct URL.
 */
function get_indieweb_xyz_link() {
	return '<a href="' . get_indienews_xyz_url() . '" rel="tag" class="u-category u-tag u-syndication">' . wp_parse_url( get_indienews_xyz_url(), PHP_URL_PATH ) . '</a>';
}

/**
 * Get the IndieNews tag that is used to check if the post
 * is about the IndieWeb or not. Default is "indie".
 *
 * @return string The tag to filter by.
 */
function get_indienews_tag() {
	$tag = apply_filters( 'indienews_tag', 'indie' );

	return preg_quote( $tag );
}
