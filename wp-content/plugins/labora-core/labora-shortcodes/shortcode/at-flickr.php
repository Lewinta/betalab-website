<?php
// F L I C K R
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_flickr' ) ) {
	function labora_sc_flickr( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'limit'		=> '5',
			'id'		=> '8241331@N04',
			'display'	=> 'latest',
			'size'		=> 's',
			'layout'	=> 'x',
			'type'		=> 'user',
		), $atts));

		if ( $type == 'user' ) {
			$out = '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' . $limit . '&amp;display=' . $display . '&amp;size=' . $size . '&amp;layout=x&amp;source=user&amp;user=' . $id . '"></script>';
		}
		if ( $type == 'group' ) {
			$out = '<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=' . $limit . '&amp;display=' . $display . '&amp;size=' . $size . '&amp;layout=x&amp;source=group&amp;group=' . $id . '"></script>';
		}
		return $out;
	}
	add_shortcode( 'flickr', 'labora_sc_flickr' );
}
