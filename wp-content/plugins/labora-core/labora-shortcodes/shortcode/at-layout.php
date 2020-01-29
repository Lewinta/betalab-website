<?php
// C O L U M N   L A Y O U T S
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_column' ) ) {
	function labora_sc_column( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'no_margin' => 'false',
		), $atts));
		if ( $no_margin == 'true' ) {
			return '<div class="' . $code . ' nomargin">' . do_shortcode( trim( $content ) ) . '</div>';
		} else {
			return '<div class="' . $code . '">' . do_shortcode( trim( $content ) ) . '</div>';
		}
	}
}

if ( ! function_exists( 'labora_sc_column_last' ) ) {
	function labora_sc_column_last( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'no_margin' => 'false',
		), $atts));
		if ( $no_margin == 'true' ) {
			return '<div class="' . str_replace( '_last', '', $code ) . ' last nomargin">' . do_shortcode( trim( $content ) ) . '</div><div class="clear"></div>';
		} else {
			return '<div class="' . str_replace( '_last', '', $code ) . ' last">' . do_shortcode( trim( $content ) ) . '</div><div class="clear"></div>';
	
		}
	}
}

add_shortcode( 'one_half', 'labora_sc_column' );
add_shortcode( 'one_third', 'labora_sc_column' );
add_shortcode( 'one_fourth', 'labora_sc_column' );
add_shortcode( 'one_fifth', 'labora_sc_column' );
add_shortcode( 'one_sixth', 'labora_sc_column' );

add_shortcode( 'two_third', 'labora_sc_column' );
add_shortcode( 'three_fourth', 'labora_sc_column' );
add_shortcode( 'two_fifth', 'labora_sc_column' );
add_shortcode( 'three_fifth', 'labora_sc_column' );
add_shortcode( 'four_fifth', 'labora_sc_column' );
add_shortcode( 'five_sixth', 'labora_sc_column' );

add_shortcode( 'one_half_last', 'labora_sc_column_last' );
add_shortcode( 'one_third_last', 'labora_sc_column_last' );
add_shortcode( 'one_fourth_last', 'labora_sc_column_last' );
add_shortcode( 'one_fifth_last', 'labora_sc_column_last' );
add_shortcode( 'one_sixth_last', 'labora_sc_column_last' );

add_shortcode( 'two_third_last', 'labora_sc_column_last' );
add_shortcode( 'three_fourth_last', 'labora_sc_column_last' );
add_shortcode( 'two_fifth_last', 'labora_sc_column_last' );
add_shortcode( 'three_fifth_last', 'labora_sc_column_last' );
add_shortcode( 'four_fifth_last', 'labora_sc_column_last' );
add_shortcode( 'five_sixth_last', 'labora_sc_column_last' );
