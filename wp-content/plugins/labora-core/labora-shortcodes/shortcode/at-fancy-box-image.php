<?php
/**
 * Fancy Box Image
 */
if ( ! function_exists( 'labora_sc_fancy_box_image' ) ) {
	function labora_sc_fancy_box_image( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'image'			=> '',
			'title'			=> '',
			's_desc'		=> '',
			'link_text'		=> '',
			'link'			=> '',
			'link_target'	=> '',
			'animation'		=> '',
		), $atts));

		$out = $linktarget = '';

		$link = $link ? ' href="' . esc_url( $link ) . '"':'';

		if ( 'true' == $link_target ) {
			$linktarget = 'target = "_blank"';
		}

		// Animation Effects
		//--------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';

		$out .= '<div class="container ' . $animation_class . '" ' . $animation . '>';
		$out .= '<div class="iva-fancy-box">';
		$out .= '<div style="background-image: url(' . $image . '); " class="iva-fancy-box-bg"></div>';
		$out .= '<div class="iva-fancy-box-inner">';
		$out .= '<h3>' . $title . '</h3>';
		$out .= '<p>' . $s_desc . '</p>';
		$out .= '</div>';
		if ( ! empty( $$link ) ) {
			$out .= '<div class="iva-fancy-box-link">' . $link_text . '<span class="iva-fb-arrow"></span></div>';
		}
		$out .= '<a class="iva-fb-box-link" ' . $link . ' ' . $linktarget . '></a>';
		$out .= '</div>';
		$out .= '</div>';

		return $out;
	}
	add_shortcode( 'fancyboximage', 'labora_sc_fancy_box_image' );
}
