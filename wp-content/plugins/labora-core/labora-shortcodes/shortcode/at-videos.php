<?php
// V I M E O   V I D E O
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_vimeo' ) ) {
	function labora_sc_vimeo( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'width'		=> '560',
			'height'	=> '315',
			'clip_id'	=> '',
			'autoplay'	=> '',
		), $atts));

		$out = '';
		if ( ! empty( $clip_id ) && is_numeric( $clip_id ) ) {
			$out .= '<div class="video-stage">';
			if ( empty( $clip_id ) || ! is_numeric( $clip_id ) ) {$out .= 'Invalid Vimeo clipid';}
			if ( $height && ! $width ) { $width = intval( $height * 16 / 9 ); }
			if ( ! $height && $width ) { $height = intval( $width * 9 / 16 ); }
			$out .= "<iframe src='http://player.vimeo.com/video/$clip_id?autoplay=$autoplay&ampportrait=0' width='$width' height='$height' frameborder='0'></iframe>";
			$out .= '</div>';
		}
		return $out;
	}
	add_shortcode( 'vimeo','labora_sc_vimeo' );
}

// Y O U T U B E   V I D E O 
//--------------------------------------------------------
if( !function_exists('labora_sc_youtube')){
	function labora_sc_youtube($atts, $content = null) {
		extract(shortcode_atts(array (
			'width'		=> '560',
			'height'	=> '315',
			'clipid'	=> '',
			'autoplay'	=> '',
		), $atts));
		
		$out = '';
		
		if (!empty($clipid)){
			$out .= '<div class="video-stage">';
			if (empty($clipid)) $out.='Invalid Youtube clipid';
			if ($height && !$width) $width = intval($height * 16 / 9);
			if (!$height && $width) $height = intval($width * 9 / 16);
			$out .='<iframe  src="http://www.youtube.com/embed/'.$clipid.'?autoplay='.$autoplay.'&amp;wmode=transparent" width='.$width.' height='.$height.' frameborder="0"></iframe></div>';
		}
		return $out;
	}
	add_shortcode('youtube','labora_sc_youtube');
}
