<?php
// Expandable
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_expandable' ) ) {
	function labora_sc_expandable( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'morelabel'		=> '',
			'lesslabel'		=> '',
			'bgcolor'	=> '',
			'textcolor' => '',
		), $atts));
		$out = $css_extras = '';
		$bgcolor = $bgcolor ? ' background-color:' . $bgcolor . ';' : '';
		$textcolor = $textcolor ? ' color:' . $textcolor . ';' : '';
		if ( $bgcolor || $textcolor ) {
			$css_extras  = ' style="' . $bgcolor . $textcolor . '"';
		}
		$out .= '<div class="at-expand-more-holder">';
		$out .= '<div class="at-expand-action-holder">';
		$out .= '<div class="at-expand-action-text" data-less-label="' . $lesslabel . '"  data-more-label="' . $morelabel . '" ' . $css_extras . '>';
		$out .= '<span class="at-expand-label-text">' . $morelabel . '</span>';
		$out .= '</div>';
		$out .= '</div>';
		$out .= '<div class="at-expand-content-outer" ' . $css_extras . '>';
		$out .= do_shortcode( $content );
		$out .= '</div>';
		$out .= '</div>';

		return $out;
	}
	add_shortcode( 'expandable', 'labora_sc_expandable' );
}
