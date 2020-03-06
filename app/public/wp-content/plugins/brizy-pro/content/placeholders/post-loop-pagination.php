<?php

class BrizyPro_Content_Placeholders_PostLoopPagination extends Brizy_Content_Placeholders_Abstract {

	/**
	 * @var
	 */
	private $twig;

	/**
	 * BrizyPro_Content_Placeholders_PostLoopPagination constructor.
	 * @throws Exception
	 */
	public function __construct() {
		$this->twig        = Brizy_TwigEngine::instance( BRIZY_PRO_PLUGIN_PATH . "/content/views/" );
		$this->placeholder = 'brizy_dc_post_loop_pagination';
		$this->label       = 'Post loop pagination';
		$this->setDisplay( self::DISPLAY_BLOCK );

	}

	/**
	 * @param Brizy_Content_Context $context
	 * @param Brizy_Content_ContentPlaceholder $contentPlaceholder
	 *
	 * @return mixed|string
	 * @throws Twig_Error_Loader
	 * @throws Twig_Error_Runtime
	 * @throws Twig_Error_Syntax
	 */
	public function getValue( Brizy_Content_Context $context, Brizy_Content_ContentPlaceholder $contentPlaceholder ) {

		global $wp_rewrite;
		$old_pagination_base         = $wp_rewrite->pagination_base;
		$wp_rewrite->pagination_base = BrizyPro_Content_Placeholders_PostLoop::getPaginationKey();

		// URL base depends on permalink settings.
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$url_parts    = explode( '?', $pagenum_link );
		$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
		$format       = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format       .= $wp_rewrite->using_permalinks() ? user_trailingslashit( BrizyPro_Content_Placeholders_PostLoop::getPaginationKey() . '/%#%', 'paged' ) : '?' . BrizyPro_Content_Placeholders_PostLoop::getPaginationKey() . '=%#%';


		$paginationContext               = array();
		$attributes                      = $contentPlaceholder->getAttributes();
		$paginationContext['totalCount'] = $this->getPostCount( $attributes );
		$paginationContext['pages']      = ceil( $paginationContext['totalCount'] / $attributes['count'] );
		$paginationContext['page']       = $this->getPageVar();
		$paginationContext['pagination'] = paginate_links( array(
			'prev_next' => false,
			'type'      => 'list',
			'format'    => $format,
			'current'   => $this->getPageVar(),
			'total'     => $paginationContext['pages']
		) );
		$wp_rewrite->pagination_base     = $old_pagination_base;

		return $this->twig->render( 'pagination.html.twig', $paginationContext );
	}

	/**
	 * @return mixed|string
	 */
	protected function getOptionValue() {
		return null;
	}

	/**
	 * @param $attributes
	 *
	 * @return int
	 */
	private function getPostCount( $attributes ) {

		$query = null;

		if ( $attributes['taxonomy'] == 'template' && $attributes['value'] == 'main_query' ) {
			global $wp_query;

			$queryVars                   = $wp_query->query_vars;
			$queryVars['orderby']        = isset( $attributes['orderby'] ) ? $attributes['orderby'] : 'none';
			$queryVars['order']          = isset( $attributes['order'] ) ? $attributes['order'] : 'ASC';
			$queryVars['posts_per_page'] = isset( $attributes['count'] ) ? $attributes['count'] : 3;
			$queryVars['post_type']      = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : $queryVars['post_type'];
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
				'post_type'      => 'any',
				'orderby'        => isset( $attributes['orderby'] ) ? $attributes['orderby'] : 'none',
				'order'          => isset( $attributes['order'] ) ? $attributes['order'] : 'ASC',
			);
			$query  = new WP_Query( $params );
		}

		$query->get_posts();
		$count = $query->found_posts;
		wp_reset_postdata();

		return $count;
	}

	/**
	 * @return int|mixed
	 */
	private function getPageVar() {
		if ( $paged = get_query_var( BrizyPro_Content_Placeholders_PostLoop::getPaginationKey() ) ) {
			return (int) $paged;
		}

		return 1;
	}


}