<?php
	// S E R V I C E   B O X
	//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_service_box' ) ) {
	function labora_sc_service_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'bg_image'		=> '',
			'bg_color'		=> '',
			'icon'			=> '',
			'icon_color'	=> '',
			'heading'		=> '',
			'heading_color'	=> '',
			'content'		=> '',
			'content_color'	=> '',
			'link_text'		=> '',
			'link'			=> '',
			'link_target'	=> '',
			'animation'		=> '',
		), $atts));

		// Animation Effects
		//--------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim' : '';

		//
		$icon_color = $icon_color ? 'color:' . $icon_color . ';':'';
		$iconcolor 	= $icon_color ? 'style="' . $icon_color . '"':'';

		//
		$bg_color	= $bg_color ? ' background-color:' . $bg_color . ';':'';
		$bgcolor 	= $bg_color ? 'style="' . $bg_color . '"':'';

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

		if ( '' != $bg_image ) {
			$out .= '<div class="at-info-box-v1 ' . $animation_class . '" ' . $animation . '>';
			$out .= '<div class="at-info-box-v1-image">';
			$out .= '<figure>' . labora_sc_resize( '', $bg_image, '', '', '', 'image' ) . '</figure>';
			$out .= '</div>';
			$out .= '<div class="at-info-box-v1-text" ' . $bgcolor . '>';
			$out .= '<div class="at-info-box-v1-title">';
			$out .= '<i class="fa fa-fw fa-2x ' . $icon . '" ' . $iconcolor . '></i>';
			if ( '' != $heading ) {
				$out .= '<h6 ' . $headingcolor . '>' . $heading . '</h6>';
			}
			$out .= '</div>';
			if ( '' != $content ) {
				$out .= '<p ' . $contentcolor . '>' . $content . '</p>';
			}
			$out .= '<a ' . $link . ' ' . $linktarget . ' class="read-more"><span>' . $link_text . '</span> <i class="fa fa-angle-double-right"></i></a>';
			$out .= '</div>';
			$out .= '</div>';
		}
		return $out;
	}
	add_shortcode( 'service_box', 'labora_sc_service_box' );
}
