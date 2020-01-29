<?php
// I M A G E
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_image' ) ) {
	function labora_sc_image( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'src'			=> '',
			'size'			=> '',
			'lightbox'		=> '',
			'lightbox_url' 	=> '',
			'width'			=> '',
			'height'		=> '',
			'link'			=> '',
			'target'		=> '',
			'frame_style'	=> '',
			'alt'			=> '',
			'class'			=> '',
			'align'			=> '',
			'title'			=> '',
			'caption'		=> '',
			'caption_location' => '',
			'margin_bottom' => '',
			'animation' => '',
		), $atts));

		$link_target = $no_link = $rel = $out = $src_lightbox = $lightbox_enabled = $margin_bottom_extras = '';
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';
		if ( $margin_bottom != '' ) {
			$margin_bottom = ( strstr( $margin_bottom, 'px', true ) ) ? $margin_bottom : $margin_bottom . 'px';
			$margin_bottom_extras .= 'margin-bottom: ' . $margin_bottom . ';';
		}

		if ( ! $width || ! $height ) {
			if ( ! $width ) { $width = ''; }
			if ( ! $height ) { $height = ''; }
		}
		$attachment_id = labora_sc_get_attachment_id_from_src( $src );
		$image_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		if ( ! empty( $image_alt ) ) {
			$image_alt = $image_alt;
		} elseif ( ! empty( $alt ) ) {
			$image_alt = $alt;
		} elseif ( ! empty( $title ) ) {
			$image_alt = $title;
		}

		if ( $lightbox == 'true' ) {
			$class = 'lightbox-enable';
		} else {
			$class = 'at-image-link';
		}
		if ( $size == 'crop' ) {
			$image_output_src = labora_sc_resize( '', $src, $width, $height, $class, $image_alt );
			$max_width = $width;
		} else {
			$image_attributes = wp_get_attachment_image_src( $attachment_id, $size, '' );
			$max_width = $image_attributes['1'];
			$image_output_src = labora_sc_resize( '', $image_attributes['0'], $image_attributes['1'], $image_attributes['2'], $class, $image_alt );
		}
		if ( $lightbox == 'true' ) {
			$lightbox_url = ! empty( $lightbox_url ) ? ( $lightbox_link = $lightbox_url ) : $lightbox_link = $src;
			$lightbox_enabled = 'lightbox-yes';
			$rel = ' data-rel="prettyPhoto"';
			$rel .= ' class="at-image-lightbox lightbox"';
		} else {
			if ( $link != '' ) {
				if ( preg_match_all( '!http://.+\.(?:jpe?g|png|gif)!Ui', $link,$matches ) ) {
					$link = '#';
				}
			}
			if ( $link == '#' ) {
				$no_link = 'image_no_link';
			}
		}
		if ( $target == 'true' ) {
			$link_target = ' target="_blank"';
		}

		$out .= '<div class="at-image ' . $animation_class . ' ' . $lightbox_enabled . ' ' . $align . ' ' . $frame_style . ' ' . $caption_location . '" style="' . $margin_bottom_extras . '" ' . $animation . '>';
		$out .= '<div class="at-image-holder" style="max-width:' . $max_width . 'px;">';
		$out .= '<div class="at-image-inner">';

		if ( $lightbox == 'true' ) {
			$out .= $image_output_src;
			$out .= '<div class="at-image-overlay"></div>';
			$out .= '<a ' . $link_target . ' ' . $rel . ' ' . ( $no_link ? ' class="' . $no_link . '  at-lightbox"':'' ) . ' alt="' . $alt . '" href="' . esc_url( $lightbox_link ) . '">';
			$out .= '<i class="pe-3x pe-fw pe-7s-plus"></i>';
			$out .= '</a>';

		} else {
			if ( $link != '' ) {
				$out .= '<a ' . $link_target . '' . $rel . ' ' . ( $no_link? ' class="' . $no_link . '"':'' ) . ' alt="' . $alt . '" href="' . esc_url( $link ) . '">';
			}
			$out .= $image_output_src;
			if ( $link != '' ) {
				$out .= '</a>';
			}
		}
		$out .= '</div>'; //.at-image-inner
		if ( ! empty( $title ) || ! empty( $caption ) ) {
			$out .= '<div class="at-image-caption">';
			if ( ! empty( $title ) ) {	$out .= '<span class="at-image-caption-title">' . $title . '</span>';	}
			if ( ! empty( $caption ) ) { $out .= '<span class="at-image-caption-txt">' . $caption . '</span>';	}
			$out .= '</div>';
		}
		$out .= '</div>'; //.at-image-holder
		$out .= '</div>'; //.labora-image

		return $out;
	}
	add_shortcode( 'image', 'labora_sc_image' );
}
