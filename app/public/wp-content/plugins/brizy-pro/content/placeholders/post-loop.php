<?php

class BrizyPro_Content_Placeholders_PostLoop extends Brizy_Content_Placeholders_Abstract {

	/**
	 * @var
	 */
	private $twig;

	/**
	 * BrizyPro_Content_Placeholders_PostLoop constructor.
	 * @throws Exception
	 */
	public function __construct() {
		$this->setLabel( 'Post Loop' );
		$this->setPlaceholder( 'brizy_dc_post_loop' );
		$this->setDisplay( self::DISPLAY_BLOCK );
		$this->twig = Brizy_TwigEngine::instance( BRIZY_PRO_PLUGIN_PATH . "/content/views/" );
	}

	/**
	 * @param Brizy_Content_ContentPlaceholder $contentPlaceholder
	 * @param Brizy_Content_Context $context
	 *
	 * @return false|mixed|string
	 */
	public function getValue( Brizy_Content_Context $context, Brizy_Content_ContentPlaceholder $contentPlaceholder ) {

		$attributes = $contentPlaceholder->getAttributes();

		$posts = $this->getPosts( $attributes );

		$content = '';

		foreach ( $posts as $post ) {
			try {

				$newContext = Brizy_Content_ContextFactory::createContext( $context->getProject(), null, $post, null, true );

				$placeholderProvider = new Brizy_Content_PlaceholderProvider( $newContext );
				$extractor           = new Brizy_Content_PlaceholderExtractor( $placeholderProvider );

				list( $placeholders, $acontent ) = $extractor->extract( $contentPlaceholder->getContent() );

				$replacer = new Brizy_Content_PlaceholderReplacer( $newContext, $placeholderProvider, $extractor );

				$content .= $replacer->getContent( $placeholders, $acontent );

			} catch ( Exception $e ) {
				continue;
			}
		}

		return $content;
	}

	/**
	 * @return mixed|string
	 */
	protected function getOptionValue() {
		return $this->getReplacePlaceholder();
	}

	/**
	 * @param $attributes
	 *
	 * @return array
	 */
	private function getPosts( $attributes ) {

		$paged = $this->getPageVar();
		$query = null;

		if ( $attributes['taxonomy'] == 'template' && $attributes['value'] == 'main_query' ) {
			global $wp_query;

			$queryVars                   = $wp_query->query_vars;
			$queryVars['orderby']        = isset( $attributes['orderby'] ) ? $attributes['orderby'] : ( isset( $queryVars['orderby'] ) ? $queryVars['orderby'] : null );
			$queryVars['order']          = isset( $attributes['order'] ) ? $attributes['order'] : ( isset( $queryVars['order'] ) ? $queryVars['order'] : null );
			$queryVars['posts_per_page'] = isset( $attributes['count'] ) ? (int) $attributes['count'] : ( isset( $queryVars['posts_per_page'] ) ? $queryVars['posts_per_page'] : null );
			$queryVars['post_type']      = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : ( isset( $queryVars['post_type'] ) ? $queryVars['post_type'] : null );
			$queryVars['paged']          = (int) $paged;
			$query                       = new WP_Query( $queryVars );
		} else {
			$params = array(
				'tax_query'      => array(
					array(
						'taxonomy' => $attributes['taxonomy'],
						'field'    => 'term_id',
						'terms'    => $attributes['value']
					)
				),
				'posts_per_page' => isset( $attributes['count'] ) ? $attributes['count'] : 3,
				'orderby'        => isset( $attributes['orderby'] ) ? $attributes['orderby'] : 'none',
				'order'          => isset( $attributes['order'] ) ? $attributes['order'] : 'ASC',
				'post_type'      => 'any',
				'paged'          => $paged,
			);
			$query  = new WP_Query( $params );
		}

		$posts = $query->get_posts();

		wp_reset_postdata();

		return $posts;
	}

	/**
	 * @return int|mixed
	 */
	private function getPageVar() {
		if ( $paged = get_query_var( self::getPaginationKey() ) ) {
			return (int) $paged;
		}

		return 1;
	}


	/**
	 * Return the pagination key. bpage is the default value.
	 *
	 * @return mixed|void
	 */
	public static function getPaginationKey() {
		return apply_filters( 'brizy_postloop_pagination_key','bpage' );
	}
}