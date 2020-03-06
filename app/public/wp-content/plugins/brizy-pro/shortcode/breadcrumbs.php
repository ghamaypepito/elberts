<?php

class BrizyPro_Shortcode_Breadcrumbs extends Brizy_Shortcode_AbstractShortcode {

	private $position = 0;

	/**
	 * Get shortcode name
	 *
	 * @return string
	 */
	public function getName() {
		return 'breadcrumbs';
	}

	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return mixed|string
	 */
	public function render( $atts, $content = null ) {

		if ( wp_doing_ajax() ) {

			global $wp_query;

			$new_query = new WP_Query( array( 'posts_per_page' => 1 ) );

			if ( $new_query->have_posts() ) {
				$old_wp_query = $wp_query;
				$wp_query     = $new_query;

				$is_single           = $wp_query->is_single;
				$wp_query->is_single = true;

				$GLOBALS['post'] = $new_query->posts[0];
				$breadcrumbs     = $this->breadcrumbs();

				$wp_query            = $old_wp_query;
				$wp_query->is_single = $is_single;
			} else {
				$breadcrumbs = esc_html__( 'You have no posts. Please add one after that come back here and refresh the page.', 'brizy-pro' );
			}

			wp_reset_postdata();

			return $breadcrumbs;
		}

		return $this->breadcrumbs();
	}

	private function breadcrumbs() {

		if ( is_home() || is_front_page() ) {
			return '';
		}

		$set = array(
			'home'     => esc_html__( 'Home', 'brizy-pro' ), // text for the 'Home' link
			'category' => esc_html__( 'Archive by Category "%s"', 'brizy-pro' ), // text for a category page
			'search'   => esc_html__( 'Search Results for "%s" Query', 'brizy-pro' ), // text for a search results page
			'tag'      => esc_html__( 'Posts Tagged "%s"', 'brizy-pro' ), // text for a tag page
			'author'   => esc_html__( 'Articles Posted by %s', 'brizy-pro' ), // text for an author page
			'404'      => esc_html__( 'Error 404', 'brizy-pro' ), // text for the 404 page
			'page'     => esc_html__( 'Page %s', 'brizy-pro' ), // text 'Page N'
			'cpage'    => esc_html__( 'Comment Page %s', 'brizy-pro' ) // text 'Comment Page N'
		);

		global $post;
		$parent_id = ( $post ) ? $post->post_parent : '';

		$out = $this->link( $set['home'], home_url( '/' ) );

		if ( is_search() ) {

			$out .= $this->link( sprintf( $set['search'], get_search_query() ), '', '' );

		} elseif ( is_year() ) {

			$out .= $this->link( get_the_time( 'Y' ), '', '' );

		} elseif ( is_month() ) {

			$out .= $this->link( get_the_time( 'Y' ), get_year_link( get_the_time( 'Y' ) ) );
			$out .= $this->link( get_the_time( 'F' ), '', '' );

		} elseif ( is_day() ) {

			$out .= $this->link( get_the_time( 'Y' ), get_year_link( get_the_time( 'Y' ) ) );
			$out .= $this->link( get_the_time( 'F' ), get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) );
			$out .= $this->link( get_the_time( 'd' ), get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ), '' );

		} elseif ( is_single() && ! is_attachment() ) {

			if ( get_post_type() == 'product' && class_exists( 'WooCommerce' ) ) {

				$terms = wc_get_product_terms(
					get_the_ID(), 'product_cat', apply_filters(
						'woocommerce_breadcrumb_product_terms_args', array(
							'orderby' => 'parent',
							'order'   => 'DESC',
						)
					)
				);

				foreach ( $terms as $term ) {
					$parents                   = get_ancestors( $term->term_id, 'product_cat' );
					$parents                   = ! $parents ? array() : get_terms( array(
						'include'  => $parents,
						'fields'   => 'id=>name',
						'taxonomy' => 'product_cat',
						'orderby'  => 'parent',
					) );
					$parents[ $term->term_id ] = $term->name;

					foreach ( $parents as $cat_id => $cat_name ) {

						$out .= $this->link( $cat_name, get_term_link( $cat_id ) );
					}
				}

				if ( get_query_var( 'cpage' ) ) {
					$out .= $this->link( get_the_title(), get_permalink() );
					$out .= $this->link( sprintf( $set['cpage'], get_query_var( 'cpage' ) ), '', '' );
				} else {
					$out .= $this->link( get_the_title(), '', '' );
				}

			} elseif ( get_post_type() != 'post' ) {

				$post_type = get_post_type_object( get_post_type() );

				$out .= $this->link( $post_type->labels->name, get_post_type_archive_link( $post_type->name ) );
				$out .= $this->link( get_the_title(), '', '' );

			} else {

				$cat       = get_the_category();
				$catID     = $cat[0]->cat_ID;
				$parents   = get_ancestors( $catID, 'category' );
				$parents   = array_reverse( $parents );
				$parents[] = $catID;

				foreach ( $parents as $cat ) {
					$out .= $this->link( get_cat_name( $cat ), get_category_link( $cat ) );
				}

				if ( get_query_var( 'cpage' ) ) {
					$out .= $this->link( get_the_title(), get_permalink() );
					$out .= $this->link( sprintf( $set['cpage'], get_query_var( 'cpage' ) ), '', '' );
				} else {
					$out .= $this->link( get_the_title(), '', '' );
				}
			}

		} elseif ( is_category() || is_tag() || is_tax() ) {

			$wp_the_query   = $GLOBALS['wp_the_query'];
			$queried_object = $wp_the_query->get_queried_object();
			$term_object    = get_term( $queried_object );
			$taxonomy       = $term_object->taxonomy;
			$term_parent    = $term_object->parent;

			if ( 0 !== $term_parent ) {

				// Get all the current term ancestors
				$parent_term_links = [];

				while ( $term_parent ) {
					$term                = get_term( $term_parent, $taxonomy );
					$parent_term_links[] = $this->link( $term->name, get_term_link( $term ) );
					$term_parent         = $term->parent;
				}

				$out .= implode( '', array_reverse( $parent_term_links ) );
			}

			$out .= $this->link( $term_object->name, get_term_link( $term_object ), '' );

		} elseif ( is_post_type_archive() ) {

			$post_type = get_post_type_object( get_post_type() );

			if ( get_query_var( 'paged' ) ) {

				$out .= $this->link( $post_type->label, get_post_type_archive_link( $post_type->name ) );
				$out .= $this->link( sprintf( $set['page'], get_query_var( 'paged' ) ), '', '' );

			} else {
				$out .= $this->link( $post_type->label, '', '' );
			}

		} elseif ( is_attachment() ) {

			$parent    = get_post( $parent_id );
			$cat       = get_the_category( $parent->ID );
			$catID     = $cat[0]->cat_ID;
			$parents   = get_ancestors( $catID, 'category' );
			$parents   = array_reverse( $parents );
			$parents[] = $catID;

			foreach ( $parents as $cat ) {
				$out .= $this->link( get_cat_name( $cat ), get_category_link( $cat ) );
			}

			$out .= $this->link( $parent->post_title, get_permalink( $parent ) );
			$out .= $this->link( get_the_title(), '', '' );

		} elseif ( is_page() && ! $parent_id ) {

			$out .= $this->link( get_the_title(), get_permalink(), '' );

		} elseif ( is_page() && $parent_id ) {

			$parents = get_post_ancestors( get_the_ID() );

			foreach ( array_reverse( $parents ) as $pageID ) {
				$out .= $this->link( get_the_title( $pageID ), get_page_link( $pageID ) );
			}

			$out .= $this->link( get_the_title(), get_permalink(), '' );

		} elseif ( is_author() ) {

			$author = get_userdata( get_query_var( 'author' ) );

			if ( get_query_var( 'paged' ) ) {

				$out .= $this->link( sprintf( $set['author'], $author->display_name ), get_author_posts_url( $author->ID ) );
				$out .= $this->link( sprintf( $set['page'], get_query_var( 'paged' ) ), '', '' );

			} else {
				$out .= $this->link( sprintf( $set['author'], $author->display_name ), '', '' );
			}

		} elseif ( is_404() ) {

			$out .= $this->link( $set['404'], '', '' );

		} elseif ( has_post_format() && ! is_singular() ) {
			$out .= $this->link( get_post_format_string( get_post_format() ), '', '' );
		}

		return '<ul class="brz-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">' . $out . '</ul>';
	}

	private function link( $title, $url = '', $separator = true ) {

		$sep       = '';
		$a_tag     = '<span class="brz-span" itemprop="item">';
		$a_tag_end = '</span>';

		if ( $separator ) {
			$sep = '<svg id="nc-right-arrow-heavy" class="brz-icon-svg" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"><g class="nc-icon-wrapper" fill="currentColor"><path d="M5.204 16L3 13.91 9.236 8 3 2.09 5.204 0l7.339 6.955c.61.578.61 1.512 0 2.09L5.204 16z" fill="currentColor" fill-rule="nonzero" stroke="none" stroke-width="1" class="nc-icon-wrapper"/></g></svg>';

			$url       = $url ? $url : $this->get_current_url();
			$a_tag     = '<a class="brz-a" itemprop="item" href="' . esc_url( $url ) . '">';
			$a_tag_end = '</a>';
		}

		$this->position += 1;

		$li =
			'<li class="brz-li" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">' .
				$a_tag .
					'<span itemprop="name">' . $title . '</span>' .
				$a_tag_end .
				'<meta itemprop="position" content="' . $this->position . '" />' .
				$sep .
			'</li>';

		return $li;
	}

	private function get_current_url() {

		global $wp;

		return home_url( add_query_arg( array( $_GET ), $wp->request ) );
	}
}