<?php

class BrizyPro_Content_Placeholders_PostContent extends BrizyPro_Content_Placeholders_SimplePostAware {

	/**
	 * @return string|callable
	 */
	protected $value;

	/**
	 * BrizyPro_Content_Placeholders_PostContent constructor.
	 *
	 * @param $label
	 * @param $placeholder
	 * @param string $display
	 */
	public function __construct( $label, $placeholder, $display = Brizy_Content_Placeholders_Abstract::DISPLAY_INLINE ) {
		$this->setLabel( $label );
		$this->setPlaceholder( $placeholder );
		$this->setDisplay( $display );
		$this->value = $this->getTheContentCallback();
	}

	private function getTheContentCallback() {
		return function ( $context ) {
			setup_postdata( $context->getWpPost() );

			return $content = get_the_content();
		};
	}
}