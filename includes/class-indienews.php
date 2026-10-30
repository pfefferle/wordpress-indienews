<?php
/**
 * IndieNews class.
 *
 * @author Matthias Pfefferle
 */
class Indienews {

	/**
	 * Add the IndieNews category.
	 *
	 * @param  array $links The rendered HTML links.
	 *
	 * @return array        updated list of links
	 */
	public static function add_indienews_tag_link( $links ) {
		// check if a post has an indie* tag
		foreach ( $links as $link ) {
			if ( preg_match( '/' . get_indienews_tag() . '/i', $link ) ) {
				$links[] = '<a href="' . get_indienews_url() . '" rel="tag" class="u-category u-tag">IndieNews</a>';

				break;
			}
		}

		return $links;
	}

	/**
	 * Notify the IndieNews page.
	 *
	 * @param  array $links   The array of tags of one specific post.
	 * @param  int   $post_ID The ID of the post.
	 *
	 * @return array          Array of updated WebMention links.
	 */
	public static function send_webmentions( $links, $post_id ) {
		$tags = wp_get_post_tags( $post_id );

		foreach ( $tags as $tag ) {
			if ( preg_match( '/' . get_indienews_tag() . '/i', $tag->name ) ) {
				$links[] = get_indienews_url();

				return $links;
			}
		}

		return $links;
	}

	/**
	 * Add the IndieNews category to the mf2/jf2 feed entry.
	 *
	 * XRay (used by IndieNews) prefers the `rel=alternate` mf2 JSON over the HTML.
	 *
	 * @param  array $entry   The jf2 entry.
	 * @param  int   $post_id The ID of the post.
	 *
	 * @return array          The updated jf2 entry.
	 */
	public static function add_indienews_category( $entry, $post_id ) {
		$entry['category'] = self::send_webmentions( isset( $entry['category'] ) ? $entry['category'] : array(), $post_id );

		return $entry;
	}
}
