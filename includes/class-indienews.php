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
				$links[] = '<a href="' . get_indienews_url() . '" rel="tag" class="u-category u-tag">#indienews</a>';

				return $links;
			}
		}

		$links[] = get_indieweb_xyz_link();

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
}
