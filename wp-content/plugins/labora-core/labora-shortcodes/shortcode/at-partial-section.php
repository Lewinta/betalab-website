<?php
// P A R T I A L  S E C T I O N
//--------------------------------------------------------
function labora_sc_partial_section( $atts, $content = null, $code ) {
	extract( shortcode_atts( array(
		'ps_align'				=> 'left',
		'ps_image'   			=> '',
		'ps_attachment' 		=> '',
		'ps_repeat'    			=> '',
		'ps_position'   		=> '',
		'ps_bgcolor'    		=> '',
		'ps_content_bgcolor'	=> '',
		'ps_content_text_color' => '',
	), $atts));

	$ps_bg_prop = $out = '';
	$ps_bgcolor    = $ps_bgcolor ? 'background-color:' . $ps_bgcolor . ';':'';
	$ps_content_bgcolor    = $ps_content_bgcolor ? 'background-color:' . $ps_content_bgcolor . ';':'';
	$ps_content_text_color = $ps_content_text_color ? 'color:' . $ps_content_text_color . ';':'';

	if ( $ps_image ) {
		$ps_bg_prop .= 'background-image:url( ' . $ps_image . ' );';
		if ( $ps_repeat ) {
			$ps_bg_prop .= 'background-repeat:' . $ps_repeat . ';';
		}
		if ( $ps_position ) {
			$ps_bg_prop .= 'background-position:' . $ps_position . ';';
		}
		if ( $ps_attachment ) {
			$ps_bg_prop .= 'background-attachment:' . $ps_attachment . ';';
		}
	}

	// Left
	if ( ! empty( $ps_bgcolor ) || ! empty( $ps_image ) ) {
		$ps_image_properties = ' style="' . $ps_bgcolor.$ps_bg_prop . '"   ';
	} else {
		$ps_image_properties = '';
	}

	// Right
	if ( ! empty( $ps_content_bgcolor ) || ! empty( $ps_content_text_color ) ) {
		$ps_content_properties = ' style="' . $ps_content_bgcolor . $ps_content_text_color . '"   ';
	} else {
		$ps_content_properties = '';
	}

	switch ( $ps_align ) { 
		case 'left':
					$out .= '<div class="partial_section_wrap">';

					// Image
					$out .= '<div class="partial_section_image" ' . $ps_image_properties . '>';
					$out .= '</div>'; //.section_inner

					// Content
					$out .= '<div class="partial_section_content" ' . $ps_content_properties . '>';
					$out .= '<div class="ps_content">';
					$out .= do_shortcode( trim( $content ) );
					$out .= '</div>'; //.ps_right_inner
					$out .= '</div>'; //. partial_section_right

					$out .= '</div>';
					break;
		case 'right':
					$out .= '<div class="partial_section_wrap">';

					// content
					$out .= '<div class="partial_section_content" ' . $ps_content_properties . '>';
					$out .= '<div class="ps_content">';
					$out .= do_shortcode( trim( $content ) );
					$out .= '</div>'; //.ps_right_inner
					$out .= '</div>'; //. partial_section_right
					//Image
					$out .= '<div class="partial_section_image" ' . $ps_image_properties . '>';
					$out .= '</div>'; //.section_inner
					$out .= '</div>';
					break;
	}
	return $out;
}
add_shortcode( 'partial_section', 'labora_sc_partial_section' );
