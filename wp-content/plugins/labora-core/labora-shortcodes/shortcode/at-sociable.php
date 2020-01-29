<?php
	// SOCIABLES 
	//--------------------------------------------------------
 if ( ! function_exists('labora_sc_sociable') ) {
	function labora_sc_sociable ( $atts, $content = null) {
		extract(shortcode_atts(array(
			'title'		=> '',
			'color'     => 'black'
		), $atts ) );

		$out = '';
		if ( $title ) {
			$out .= '<h4 class="widget-title">'.$title.'<span></span></h4>'; 
		}
		$out .= labora_sc_social( $color );
		return $out;
	}
	add_shortcode('sociable','labora_sc_sociable');
}
