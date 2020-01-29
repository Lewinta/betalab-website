<?php
if ( ! function_exists( 'labora_sc_vacant_table' ) ) {
	function labora_sc_vacant_table( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'animation'			=> '',
			'header_txt_color'	=> '',
			'heading'			=> '',
		), $atts));
		$heading = explode( ',',$heading );
		
		// Animation Effects
		//--------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';
		
		$header_txt_color 	= $header_txt_color ? 'color: ' . $header_txt_color . ';':'';
		$styling 			= ( $header_txt_color ) ? ' style="' . $header_txt_color . '"' : '' ;

		$out = '';
		$out .= '<div class="at-vacant-table-wrap '.$animation_class.'" ' . $animation . '>';
		$out .= '<table id="at-vacant-table-104" class="at-vacant-table tablesorter">';
		$out .= '<thead>';
		$out .= '<tr>';
		foreach ( $heading as $key => $value ) {
			$out .= '<th class="at-vacant-header"><h4 ' . $styling . '>' . $value . '</h4></th>';
		}
		$out .= '</tr>';
		$out .= '</thead>';
		$out .= '<tbody>';
		$out .= do_shortcode( $content );
		$out .= '</tbody>';
		$out .= '</table>';
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'vacant_table', 'labora_sc_vacant_table' );
}
if ( ! function_exists( 'labora_sc_vacant' ) ) {
	function labora_sc_vacant( $atts, $content = null ) {
		extract( shortcode_atts( array(),$atts ) );

		$var = $atts;
		$out = '';
		$out .= '<tr>';
		foreach ( $var as $key => $value ) {
			$out .= '<td><a href="#">' . $value . '</a></td>';
		}
		$out .= '</tr>';
		return $out;
	}
	add_shortcode( 'vacant', 'labora_sc_vacant' );
}
