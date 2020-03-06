<?php

class BrizyPro_Content_Placeholders_Excerpt extends Brizy_Content_Placeholders_Simple {

	/**
	 * Brizy_Editor_Content_GenericPlaceHolder constructor.
	 *
	 * @param string $label
	 * @param string $placeholder
	 */
	public function __construct( $label, $placeholder ) {
		parent::__construct( $label, $placeholder, function ( Brizy_Content_Context $context ) {
			return $this->get_the_excerpt( $context->getWpPost() );
		} );
	}

	/**
	 * It rewrites the function from wodpress core get_the_excerpt that applies the hook get_the_excerpt.
	 * The hook get_the_excerpt has a handle wp_trim_excerpt that applies the hook the_content.
	 * Applying the hook the_content will run an infinite loop because of some function like
	 * Brizy_Admin_Templates->filterPageContent() which are also hanging at this hook.
	 *
	 * @param WP_Post $post
	 *
	 * @return false|mixed|string
	 */
	public function get_the_excerpt( $post ) {

		if ( post_password_required( $post ) ) {
			return __( 'There is no excerpt because this is a protected post.', 'brizy-pro' );
		}

		return Brizy_Shortcode_PostField::wp_trim_excerpt( $post->post_excerpt, $post );
	}
}