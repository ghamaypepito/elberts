<?php

class BrizyPro_Content_Providers_Wp extends Brizy_Content_Providers_AbstractProvider {

	const PROVIDER_CONFIG_NAME = 'wp';


	/**
	 * @return array|mixed
	 */
	public function getGroupedPlaceholders() {
		$placeholders = array(
			self::CONFIG_KEY_TEXT  => $this->getTextPlaceholders(),
			self::CONFIG_KEY_IMAGE => $this->getMediaPlaceholders(),
			self::CONFIG_KEY_LINK  => $this->getLinkPlaceholders()
		);

		//return array( self::PROVIDER_CONFIG_NAME => $placeholders );
		return array( self::PROVIDER_CONFIG_NAME => array_map( 'array_filter', $placeholders ) );
	}

	/**
	 * @return array|int
	 * @throws Exception
	 */
	public function getAllPlaceholders() {
		$placeholders = parent::getAllPlaceholders();

		array_unshift( $placeholders,
			new BrizyPro_Content_Placeholders_PostLoop(),
			new BrizyPro_Content_Placeholders_PostLoopPagination()
		);

		return $placeholders;
	}

	/**
	 *
	 * @return array
	 */
	private function getTextPlaceholders() {

		$holders = array_merge(
			array(
				new BrizyPro_Content_Placeholders_SimplePostAware( 'Post Title', 'brizy_dc_post_title', function ( $context ) {
					return apply_filters( 'the_title', $context->getWpPost()->post_title, $context->getWpPost()->ID );
				} ),

				new BrizyPro_Content_Placeholders_PostContent( 'Post Content', 'brizy_dc_post_content', Brizy_Content_Placeholders_Abstract::DISPLAY_BLOCK ),

				new BrizyPro_Content_Placeholders_Excerpt( 'Post Excerpt', 'brizy_dc_post_excerpt' ),

				new BrizyPro_Content_Placeholders_SimplePostAware( 'Post Date', 'brizy_dc_post_date', function ( $context ) {
					return get_the_date( '', $context->getWpPost() );
				} ),

				new BrizyPro_Content_Placeholders_SimplePostAware( 'Post Time', 'brizy_dc_post_time', function ( $context ) {
					return get_the_time( '', $context->getWpPost() );
				} ),

				new BrizyPro_Content_Placeholders_SimplePostAware( 'Post ID', 'brizy_dc_post_id', function ( $context ) {
					return $context->getWpPost()->ID;
				} ),

				new BrizyPro_Content_Placeholders_SimplePostAware( 'Post Comments Count', 'brizy_dc_comments_count', function ( $context ) {
					return get_comments_number( $context->getWpPost() );
				} ),
			),

			$this->getTextPlaceholderTerms(),

			array(

				new BrizyPro_Content_Placeholders_SimplePostAware( 'Author Name', 'brizy_dc_post_author_name', function ( $context ) {

					if ( get_the_author_meta( 'user_firstname', $context->getAuthor() ) || get_the_author_meta( 'user_lastname', $context->getAuthor() ) ) {
						return trim( get_the_author_meta( 'user_firstname', $context->getAuthor() ) . ' ' . get_the_author_meta( 'user_lastname', $context->getAuthor() ) );
					} else {
						return trim( get_the_author_meta( 'user_login', $context->getAuthor() ) );
					}
				} ),

				new BrizyPro_Content_Placeholders_SimplePostAware( 'Author Bio', 'brizy_dc_post_author_description', function ( $context ) {
					return get_the_author_meta( 'description', $context->getAuthor() );
				} ),

				new BrizyPro_Content_Placeholders_SimplePostAware( 'Author Email', 'brizy_dc_post_author_email', function ( $context ) {
					return get_the_author_meta( 'email', $context->getAuthor() );
				} ),

				new BrizyPro_Content_Placeholders_SimplePostAware( 'Author Website', 'brizy_dc_post_author_url', function ( $context ) {
					return get_the_author_meta( 'url', $context->getAuthor() );
				} ),

				new Brizy_Content_Placeholders_Simple( 'Site Title', 'brizy_dc_site_title', function () {
					return get_bloginfo();
				} ),

				new Brizy_Content_Placeholders_Simple( 'Site Tagline', 'brizy_dc_site_tagline', function () {
					return get_bloginfo( 'description' );
				} ),

				$this->getArchiveTitle(),

				new Brizy_Content_Placeholders_Simple( 'Archive Description', 'brizy_dc_archive_description', function () {
					return strip_tags( get_the_archive_description() );
				} )
			)
		);

		return $holders;
	}

	/**
	 * @return array
	 */
	private function getMediaPlaceholders() {
		return array(
			new BrizyPro_Content_Placeholders_FeaturedImg( 'Featured Image', 'brizy_dc_img_featured_image' ),
			new BrizyPro_Content_Placeholders_Logo( 'Site logo', 'brizy_dc_img_site_logo' ),
			new BrizyPro_Content_Placeholders_SimplePostAware( 'Author Profile Picture', 'brizy_dc_img_avatar_url', function ( $context ) {
				return esc_url( get_avatar_url( $context->getAuthor() ) );
			} ),
		);
	}

	/**
	 * @return array
	 */
	private function getLinkPlaceholders() {
		$holders = array(
			new BrizyPro_Content_Placeholders_Link( 'Post URL', 'brizy_dc_url_post', function ( $context ) {
				if ( $context->getWpPost() ) {
					return get_permalink( $context->getWpPost() );
				}

				return '';
			} ),

			new BrizyPro_Content_Placeholders_Link( 'Author URL', 'brizy_dc_url_author', function ( $context ) {
				if ( $context->getWpPost() ) {
					return get_author_posts_url( $context->getAuthor() );
				}

				return '';
			} ),

			new BrizyPro_Content_Placeholders_Link( 'Comments URL', 'brizy_dc_url_comments', function ( $context ) {
				if ( $context->getWpPost() ) {
					return get_comments_link( $context->getWpPost()->ID );
				}

				return '';
			} ),

			new BrizyPro_Content_Placeholders_Link( 'Site URL', 'brizy_dc_url_site', function () {
				return esc_url( home_url( '/' ) );
			} ),

			$this->getUrlArchive()
		);

		// TODO - maybe to add and post meta => $this->getMetaPlaceholders( 'post', 'link', 'BrizyPro_Content_Placeholders_Link' )
		return $holders;
	}

	/**
	 * @return array
	 */
	private function getTextPlaceholderTerms() {

		$terms = get_taxonomies( array( 'public' => true, 'show_ui' => true ), 'objects' );
		$out   = array();

		foreach ( $terms as $tax ) {

			$out[] = new BrizyPro_Content_Placeholders_SimplePostAware( $tax->label, "brizy_dc_post_tax_{$tax->name}", function ( $context ) use ( $tax ) {

				$terms = get_terms( array(
						'object_ids' => $context->getWpPost()->ID,
						'taxonomy'   => $tax->name
					)
				);

				if ( ! $terms || is_wp_error( $terms ) ) {
					return '';
				}

				$links = array();

				foreach ( $terms as $term ) {

					if ( ! ( $url = get_term_link( $term ) ) || is_wp_error( $url ) ) {
						continue;
					}

					$links[] = '<a href="' . esc_url( $url ) . '">' . $term->name . '</a>';
				}

				return implode( ', ', $links );
			} );
		}

		return $out;
	}

	/**
	 * @return BrizyPro_Content_Placeholders_Link
	 */
	private function getUrlArchive() {

		return new BrizyPro_Content_Placeholders_Link( 'Archive URL', 'brizy_dc_url_archive', function () {

			if ( is_category() || is_tag() || is_tax() ) {
				$url = get_term_link( get_queried_object() );
			} elseif ( is_author() ) {
				$url = get_author_posts_url( get_queried_object_id() );
			} elseif ( is_year() ) {
				$url = get_year_link( get_query_var( 'year' ) );
			} elseif ( is_month() ) {
				$url = get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) );
			} elseif ( is_day() ) {
				$url = get_day_link( get_query_var( 'year' ), get_query_var( 'monthnum' ), get_query_var( 'day' ) );
			} elseif ( is_post_type_archive() ) {
				$url = get_post_type_archive_link( get_post_type() );
			} else {
				$url = '';
			}

			return $url;
		} );
	}

	/**
	 * @return Brizy_Content_Placeholders_Simple
	 */
	private function getArchiveTitle() {

		return new Brizy_Content_Placeholders_Simple( 'Archive Title', 'brizy_dc_archive_title', function () {

			if ( is_category() ) {
				$title = single_cat_title( '', false );
			} elseif ( is_tag() ) {
				$title = single_tag_title( '', false );
			} elseif ( is_author() ) {
				$title = get_the_author();
			} elseif ( is_year() ) {
				$title = get_the_date( _x( 'Y', 'yearly archives date format' ) );
			} elseif ( is_month() ) {
				$title = get_the_date( _x( 'F Y', 'monthly archives date format' ) );
			} elseif ( is_day() ) {
				$title = get_the_date( _x( 'F j, Y', 'daily archives date format' ) );
			} elseif ( is_post_type_archive() ) {
				$title = post_type_archive_title( '', false );
			} elseif ( is_tax() ) {
				$tax   = get_taxonomy( get_queried_object()->taxonomy );
				$title = sprintf( '%1$s: %2$s' , $tax->labels->singular_name, single_term_title( '', false ) );
			} else {
				$title = ''; // __( 'Archives' )
			}

			return apply_filters( 'get_the_archive_title', $title );
		} );
	}
}