<?php

	// L I G H T B O X
	//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_column_lightbox' ) ) {
	function labora_sc_column_lightbox( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'href'		=> '',
			'width'		=> '',
			'height'	=> '',
			'title'		=> '',
			'rel'		=> '',
			'inline'	=> '',
			'inlineid'	=> '',
			'inlinehtml' => '',
			'iframe'	=> '',
			'autoresize' => '',
		), $atts));

		if ( $width && $height ) {
			$imgresize = ( $width?'?lightbox[width]=' . $width . '':'') . ( $height?'&lightbox[height]=' . $height . '':'');
		}
		if ( $iframe == 'true' ) {
			$imgresize .= ( $iframe?'&lightbox[iframe]=' . $iframe . '':'' );
		}
		if ( $autoresize == 'true' ) {
			$autosize = ( $autoresize?'&lightbox[autoresize]=' . $autoresize . '':'');
		}
		return '<a title="' . $title . '" href="' . $href . $autosize . ( $imgresize ) . '"  ' . ( $rel?' data-rel="' . $rel . '"':'' ) . '' . ( ( $iframe == true )?' iframe="true"':'' ) . ' class="lightbox">' . do_shortcode( $content ) . '</a>';
	}
	add_shortcode( 'lightbox', 'labora_sc_column_lightbox' );
}
