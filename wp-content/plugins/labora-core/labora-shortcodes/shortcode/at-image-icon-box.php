<?php
	// I M A G E   I C O N   B O X
	//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_image_icon_box' ) ) {
	function labora_sc_image_icon_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'icon'			=> '',
			'icon_color'	=> '',
			'heading'		=> '',
			'heading_color'	=> '',
			'content'		=> '',
			'content_color'	=> '',
			'bg_image'		=> '',
			'bg_color'		=> '',
			'border_color'	=> '',
			'link_text'		=> '',
			'link'			=> '',
			'link_target'	=> '',
			'animation'		=> '',
		), $atts));

		// Animation Effects
		//--------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';

		//
		$icon_color = $icon_color ? 'color:' . $icon_color . ';':'';
		$iconcolor 	= $icon_color ? 'style="' . $icon_color . '"':'';

		//
		$bg_color	= $bg_color ? ' background-color:' . $bg_color . ';':'';
		$bgcolor 	= $bg_color ? 'style="' . $bg_color . '"':'';

		//
		$border_color	= $border_color ? ' background-color:' . $border_color . ';':'';
		$bordercolor 	= $border_color ? 'style="' . $border_color . '"':'';

		//
		$heading_color 	= $heading_color ? 'color:' . $heading_color . ';':'';
		$headingcolor 	= $heading_color ? 'style="' . $heading_color . '"':'';

		//
		$content_color 	= $content_color ? 'color:' . $content_color . ';':'';
		$contentcolor 	= $content_color ? 'style="' . $content_color . '"':'';

		$out = $linktarget = '';

		$link = $link ? ' href="' . esc_url( $link ) . '"':'';

		if ( 'true' == $link_target ) {
			$linktarget = 'target = "_blank"';
		}

		$out .= '<div class="at-icon-box-v1  ' . $animation_class . '" ' . $animation . '>';
		$out .= '<a class="at-icon__main-v1" ' . $link . ' ' . $linktarget . '>';
		$out .= '<i class="fa ' . $icon . '" ' . $iconcolor . '></i>';
		if ( '' != $heading ) {
			$out .= '<h3 ' . $headingcolor . '>' . $heading . '</h3>';
		}
		if ( '' != $content ) {
			$out .= '<p ' . $contentcolor . '>' . $content . '</p>';
		}
		if ( '' != $bg_image ) {
			$out .= '<div class="at-icon__bgimg" style="background-image: url(' . $bg_image . ');"></div>';
		} else {
			$out .= '<div class="at-icon__bgimg"></div>';
		}
		if ( '' != $bgcolor ) {
			$out .= '<div class="at-icon__bgimg" ' . $bgcolor . '></div>';
		} else {
			$out .= '<div class="at-icon__bgimg"></div>';
		}
		$out .= '<span class="at-icon__border" ' . $bordercolor . '></span>';
		$out .= '</a>';
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'image_icon_box', 'labora_sc_image_icon_box' );
}
