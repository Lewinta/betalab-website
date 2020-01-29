<?php
// Accordion
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_accordion' ) ) {
	function labora_sc_accordion( $atts, $content ) {
		extract( shortcode_atts( array(
			'type'          => '',
			'mode'          => '',
			'animation'     => '',
		), $atts ) );

		// Animation Effect Options
		//--------------------------------------------------------
		$out = '';

		// Accordian Type Normal or FAQ
		$actype = ( $type == 'faq' ) ? 'faq' : 'arrow';

		if ( ! preg_match_all( "/(.?)\[(accordion)\b(.*?)(?:(\/))?\](?:(.+?)\[\/accordion\])?(.?)/s", $content, $matches ) ) {
			return do_shortcode( $content );
		} else {
		for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$matches[3][ $i ] = shortcode_parse_atts( $matches[3][ $i ] );
		}

		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';

		// Accordian Mode
		if ( $mode == 'accordion' ) {
			$out .= '<div ' . $animation . ' id="accordion' . rand( 10, 999 ) . '" class="ac_wrap ' . $actype . ' ' . $animation_class . '">';
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$active = ( $matches[3][ $i ]['active'] == 'true' ) ? 'active' : '';
				$out .= '<div class="ac_title ' . $active . '"><span class="' . $actype . '"></span>';
				if ( ( isset( $matches[3][ $i ]['icon'] ) ) ) {
					$out .= '<i class="fa ' . $matches[3][ $i ]['icon'] . '"></i>';
				}
				$out .= $matches[3][ $i ]['title'] . '</div>';
				$out .= '<div class="ac_content ' . $active . '">' . do_shortcode( trim( $matches[5][ $i ] ) ) . '</div>';
			}
			$out .= '</div>';
		}

		// Togggle Mode
		if ( $mode == 'toggle' ) {
			$out .= '<div ' . $animation . ' id="toggle' . rand( 1, 9 ) . '" class="ac_wrap ' . $animation_class . '">';
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$active = ( $matches[3][ $i ]['active'] == 'true' ) ? 'active' : '';
				$out .= '<div class="toggle-title ' . $actype . ' ' . $active . '"><span class="' . $actype . '"></span>';
				if ( ( isset( $matches[3][ $i ]['icon'] ) ) ) {
					$out .= '<i class="fa ' . $matches[3][ $i ]['icon'] . '"></i>';
				}
				$out .= $matches[3][ $i ]['title'] . '</div>';
				$out .= '<div class="toggle_content  ac_content ' . $actype . ' ' . $active . '">' . do_shortcode( trim( $matches[5][ $i ] ) ) . '</div>';
			}
			$out .= '</div>';
		}
		return $out;
		}
	}
	add_shortcode( 'accordion-wrap', 'labora_sc_accordion' );
	add_shortcode( 'accordion', 'labora_sc_accordion' );
}
