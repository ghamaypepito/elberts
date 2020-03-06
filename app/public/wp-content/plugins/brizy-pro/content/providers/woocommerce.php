<?php

class BrizyPro_Content_Providers_Woocommerce extends Brizy_Content_Providers_AbstractProvider {

	const PROVIDER_CONFIG_NAME = 'woocommerce';

	public function getGroupedPlaceholders() {
		$placeholders = array(
			self::CONFIG_KEY_TEXT  => $this->getTextPlaceholders(),
			self::CONFIG_KEY_IMAGE => $this->getMediaPlaceholders(),
			self::CONFIG_KEY_LINK  => $this->getLinkPlaceholders()
		);

		return array( self::PROVIDER_CONFIG_NAME => array_map( 'array_filter', $placeholders ) );
	}

	/**
	 * @return array
	 */
	public function getTextPlaceholders() {

		$holders = array(
			$this->get_review_text(),
			$this->get_rating_text(),

			new Brizy_Content_Placeholders_Simple( 'Title Description', 'brizy_dc_title_description', function ( $context, $contentPlaceholder ) {
				return esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'woocommerce' ) ) );
			} ),

			new BrizyPro_Content_Placeholders_SimplePostAware( 'Regular Price', 'brizy_dc_regular_price', function ( $context, $contentPlaceholder ) {
				// wc_get_stock_html() => single-product/stock.php
				// In stock and something with backorders.

				$availability = $context->getProduct()->get_availability();

				return $availability['availability'];
			} ),

			$this->get_sku_text(),

			new Brizy_Content_Placeholders_Simple( 'Additional Info Title', 'brizy_dc_info_title_text', function ( $context, $contentPlaceholder ) {
				return esc_html( apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional information', 'woocommerce' ) ) );
			} ),

			$this->get_price_text(),
			$this->get_sale_text(),
			$this->get_reviews_title_text(),
			$this->get_upsells_title_text(),
			$this->get_related_title_text(),
		);

		return array_merge( $holders, $this->get_product_attributes_text() );
	}

	/**
	 * @return array
	 */
	public function getMediaPlaceholders() {
		return array();
	}

	/**
	 * @return array
	 */
	public function getLinkPlaceholders() {
		$holders = array(
			$this->get_review_link()
		);

		return $holders;
	}

	private function get_review_link() {

		return new BrizyPro_Content_Placeholders_Link( 'Review link', 'brizy_dc_review_url', function ( $context, $contentPlaceholder ) {
			$link = '#reviews';
			if(!$context->getProduct()) return;
			if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ||  ! comments_open( $context->getProduct() ) ) {
				$link = '';
			}

			return $link;
		} );
	}

	private function get_review_text() {

		return new BrizyPro_Content_Placeholders_SimplePostAware( 'Review', 'brizy_dc_review', function ( $context, $contentPlaceholder ) {
			$review = '';
			if ( 'no' !== get_option( 'woocommerce_enable_review_rating' ) && comments_open( $context->getProduct() ) && $context->getProduct()->get_rating_count() > 0 ) {

				$review_count = $context->getProduct()->get_review_count();
				$review       = '<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(' . sprintf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ) . ')</a>';
			}

			return $review;
		} );
	}

	private function get_rating_text() {

		return new BrizyPro_Content_Placeholders_SimplePostAware( 'Rating', 'brizy_dc_rating', function ( $context, $contentPlaceholder ) {
			$rating_count = $context->getProduct()->get_rating_count();
			$rating       = '';

			if ( $rating_count > 0 && 'no' !== get_option( 'woocommerce_enable_review_rating' ) ) {
				$rating = wc_get_rating_html( $context->getProduct()->get_average_rating(), $rating_count );
			}

			return $rating;
		} );
	}

	private function get_price_text() {
		// TODO - Must be more elements: Currency, Regular price, Sale price, Min Price/Max Price for variable product.
		//$price = wc_get_price_to_display( $this->context->getProduct(), array( 'price' => $this->context->getProduct()->get_regular_price() ) );

		return new BrizyPro_Content_Placeholders_SimplePostAware( 'Price', 'brizy_dc_price_text', function ( $context, $contentPlaceholder ) {
				return $context->getProduct()->get_price_html();
		} );
	}

	private function get_sku_text() {
		// meta.php

		return new BrizyPro_Content_Placeholders_SimplePostAware( 'SKU Text', 'brizy_dc_sku_text', function ( $context, $contentPlaceholder ) {
			$sku = '';
				if ( wc_product_sku_enabled() && ( $context->getProduct()->get_sku() || $context->getProduct()->is_type( 'variable' ) ) ) {
					$sku = ( $sku = $context->getProduct()->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' );
					$sku = '<span class="sku_wrapper">' . esc_html__( 'SKU:', 'woocommerce' ) . ' <span class="sku">' . $sku . '</span></span>';
				}

			return $sku;
		} );
	}

	private function get_product_attributes_text() {
		// wc_display_product_attributes() calls file product-attributes.php

		$out = array();

		$out[] = new BrizyPro_Content_Placeholders_SimplePostAware( esc_html__( 'Weight', 'woocommerce' ), 'brizy_dc_weight_text', function ( $context, $contentPlaceholder ) {

			$display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $context->getProduct()->has_weight() || $context->getProduct()->has_dimensions() );

			if ( $display_dimensions && $context->getProduct()->has_dimensions() ) {
				return esc_html( wc_format_weight( $context->getProduct()->get_weight() ) );

			}

			return '';
		} );

		$out[] = new BrizyPro_Content_Placeholders_SimplePostAware( esc_html__( 'Dimensions', 'woocommerce' ), 'brizy_dc_dimensions_text', function ( $context, $contentPlaceholder ) {
			$display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $context->getProduct()->has_weight() || $context->getProduct()->has_dimensions() );

			if ( $display_dimensions && $context->getProduct()->has_dimensions() ) {

				return esc_html( wc_format_dimensions( $context->getProduct()->get_dimensions( false ) ) );
			}

			return '';
		} );

		// TODO - This var must be exists to the edit mode.
		if ( ! $this->context->getProduct() ) {
			return $out;
		}

		$attributes = array_filter( $this->context->getProduct()->get_attributes(), 'wc_attributes_array_filter_visible' );

		/* @var $attribute WC_Product_Attribute */
		foreach ( $attributes as $variation => $attribute ) {
			$label = wc_attribute_label( $attribute->get_name() );

			$out[] = new Brizy_Content_Placeholders_Simple( $label, "brizy_dc_{$variation}", function ( $attribute, $context ) {

				$values = array();

				if ( $attribute->is_taxonomy() ) {
					$attribute_taxonomy = $attribute->get_taxonomy_object();
					$attribute_values   = wc_get_product_terms( $context->getProduct()->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

					foreach ( $attribute_values as $attribute_value ) {
						$value_name = esc_html( $attribute_value->name );

						if ( $attribute_taxonomy->attribute_public ) {
							$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
						} else {
							$values[] = $value_name;
						}
					}
				} else {
					$values = $attribute->get_options();

					foreach ( $values as &$value ) {
						$value = make_clickable( esc_html( $value ) );
					}
				}

				return apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
			} );
		}

		return $out;
	}

	private function get_sale_text() {
		// sale-flash.php
		return new BrizyPro_Content_Placeholders_SimplePostAware( 'Sale!', 'brizy_dc_sale', function ( $context, $contentPlaceholder ) {
			$sale = '';
			if ( $context->getProduct()->is_on_sale() ) {
				$sale = apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $context->getWpPost(), $context->getProduct() );
			}

			return $sale;
		} );
	}

	private function get_reviews_title_text() {
		// sale-flash.php

		return new BrizyPro_Content_Placeholders_SimplePostAware( 'Reviews Title', 'brizy_dc_reviews_title', function ( $context, $contentPlaceholder ) {
			if ( ! comments_open( $context->getProduct() ) ) {
				return '';
			}

			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $context->getProduct()->get_review_count() ) ) {
				/* translators: 1: reviews count 2: product name */
				return sprintf(
					esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ),
					esc_html( $count ),
					'<span>' . get_the_title( $context->getWpPost() ) . '</span>'
				);
			}

			return __( 'Reviews', 'woocommerce' );
		} );
	}

	private function get_upsells_title_text() {
		// up-sells.php
		return new BrizyPro_Content_Placeholders_SimplePostAware( 'Upsells Title', 'brizy_dc_upsells_title', function ( $context, $contentPlaceholder ) {
			$limit   = '-1';
			$columns = 4;
			$orderby = 'rand';
			$order   = 'desc';

			// Handle the legacy filter which controlled posts per page etc.
			$args = apply_filters( 'woocommerce_upsell_display_args', array(
				'posts_per_page' => $limit,
				'orderby'        => $orderby,
				'columns'        => $columns,
			) );

			$orderby = apply_filters( 'woocommerce_upsells_orderby', isset( $args['orderby'] ) ? $args['orderby'] : $orderby );
			$limit   = apply_filters( 'woocommerce_upsells_total', isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : $limit );

			// Get visible upsells then sort them at random, then limit result set.
			$upsells = wc_products_array_orderby( array_filter( array_map( 'wc_get_product', $context->getProduct()->get_upsell_ids() ), 'wc_products_array_filter_visible' ), $orderby, $order );
			$upsells = $limit > 0 ? array_slice( $upsells, 0, $limit ) : $upsells;

			$title = '';

			if ( $upsells ) {
				$title = esc_html__( 'You may also like&hellip;', 'woocommerce' );
			}

			return $title;
		} );
	}

	private function get_related_title_text() {
		// single-product/related.php
		return new BrizyPro_Content_Placeholders_SimplePostAware( 'Related Title', 'brizy_dc_related_title', function ( $context, $contentPlaceholder ) {
			$posts_per_page = 2;
			// Get visible related products then sort them at random.
			$related_products = array_filter( array_map( 'wc_get_product', wc_get_related_products( $context->getProduct()->get_id(), $posts_per_page, $context->getProduct()->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
			$related_products = wc_products_array_orderby( $related_products, 'rand', 'desc' );

			$title = '';

			if ( $related_products ) {
				$title = esc_html__( 'Related products', 'woocommerce' );
			}

			return $title;
		} );
	}


}