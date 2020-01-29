<?php
	// S E R V I C E S
	//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_content' ) ) {
	function labora_sc_content( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'image'		=> '',
			'bgcolor' => '',
			),
		$atts ));
		$bgcolor   = $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
		if ( ! empty( $bgcolor ) ) {
			$extras = ' style="' . $bgcolor . '"';
		} else {
			$extras = '';
		}
		$out = '<div class="fb-area">';
		$out .= '<div class="feature-box" ' . $extras . '>';
		$out .= '<div class="mid">';
		$out .= '<div class="fb-icon">';
		$out .= '<img src="' . $image . '" alt="">';
		$out .= '</div>';
		$out .= '</div>';
		$out .= '</div>';
		$out .= do_shortcode( $content );
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'featurebox', 'labora_sc_content' );
}
