<?php

// B U T T O N
if ( ! function_exists( 'labora_sc_button' ) ) {
	function labora_sc_button( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'sub_text'			=> '',
			'link'				=> '',
			'link_target'		=> '',
			'size'				=> 'medium',
			'align'				=> '',
			'icontype'			=> '',
			'icon_pos'		    => '',
			'fa_icon'			=> '',
			'pe_icon'			=> '',
			'style'				=> '',
			'full_width'		=> '',
			'width'				=> '',
			'margin'			=> '',
			'bg_color'			=> '',
			'hover_bg_color'	=> '',
			'text_color'		=> '',
			'hover_text_color'	=> '',
			'border_color' 		=> '',
			'hover_border_color' => '',
			'icon_color'		=> '',
			'hover_icon_color'	=> '',
		), $atts));

		$bgcolor = $cssextras = $icon = '';

		$data_bg_color = $bg_color ? ' data-btn-bg="' . $bg_color . '"' : '';
		$data_hover_bg_color = $hover_bg_color ? ' data-btn-hoverBg="' . $hover_bg_color . '"' : '';
		$data_text_color = $text_color ? ' data-btn-color="' . $text_color . '"':'';
		$data_hover_text_color = $hover_text_color ? ' data-btn-hoverColor="' . $hover_text_color . '"':'';
		$data_border_color = $border_color ? ' data-btn-border="' . $border_color . '"':'';
		$data_hover_border_color = $hover_border_color ? ' data-btn-hoverborder="' . $hover_border_color . '"':'';
		$data_icon_color = $icon_color ? ' data-btn-icon="' . $icon_color . '"':'';
		$data_hover_icon_color = $hover_icon_color ? ' data-btn-hovericon="' . $hover_icon_color . '"':'';

		// Generats data attribute with values if value exist
		if ( $hover_bg_color ) {
			$hoverbgcolor = $hover_bg_color ? $data_bg_color . $data_hover_bg_color : '';
		} else {
			$hoverbgcolor = $hover_bg_color ? $data_bg_color . ' data-btn-hoverBg="' . $bg_color . '"' : '';
		}

		// Generats data attribute with values if value exist
		if ( $hover_text_color != '' ) {
			$hovertextcolor	= $hover_text_color 	? $data_text_color . $data_hover_text_color :'';
		} else {
			$hovertextcolor	= $hover_text_color 	? $data_text_color . ' data-btn-hoverColor="' . $text_color . '"':'';
		}

		// Generats data attribute with values if value exist
		if ( $hover_border_color != '' ) {
			$hoverbordercolor	= $hover_border_color 	? $data_border_color . $data_hover_border_color :'';
		} else {
			$hoverbordercolor	= $hover_border_color 	? $data_border_color . ' data-btn-hoverborder="' . $border_color . '"':'';
		}

		// Generats data attribute with values if value exist
		if ( $hover_icon_color != '' ) {
			$hovericoncolor	= $hover_icon_color 	? $data_icon_color . $data_hover_icon_color :'';
		} else {
			$hovericoncolor	= $hover_icon_color 	? $data_icon_color . ' data-btn-hovericon="' . $icon_color . '"':'';
		}

		$link        = $link ? ' href="' . esc_url( $link ) . '"' : '';
		$linktarget  = ( $link_target == 'true' ) ? 'target = "_blank"' : '';
		$bgcolor     = $bg_color ? 'background-color:' . $bg_color . ';' : '';
		$textcolor   = $text_color ? ' color:' . $text_color . ';' : '';
		$bordercolor = $border_color ? ' border-color:' . $border_color . ';' : '';
		$width       = $width ? ' width:' . (int) $width . '%;' : '';
		$fullwidth = ( $full_width == 'true' ) ? ' full' : '';
		$iconcolor = $icon_color ? ' color:' . $icon_color . ';' : '';
		$icon_extras = ' style="' . $iconcolor . '"';

		$css_extras  = ' style="' . $bgcolor . $textcolor . $bordercolor . $width . '"';

		$subtext = '<span class="btn-sub-text">' . $sub_text . '</span>';
		if ( $icontype == 'faicon' ) {
			$icon = '<span class="btn-icon"><i ' . $hovericoncolor . $icon_extras . 'class="fa fa-fw ' . $fa_icon . '"></i></span>';
		} elseif ( $icontype == 'peicon' ) {
			$icon = '<span class="btn-icon"><i ' . $hovericoncolor . $icon_extras . 'class="pe-fw ' . $pe_icon . '"></i></span>';
		} else {

		}

		$button_class = 'btn ' . $align . ' ' . $size . ' ' . $icontype . ' ' . $icon_pos . ' ' . $fullwidth . ' ' . $style;

		if ( $content ) {
			$content = '<a ' . $link . $linktarget . $hoverbgcolor . $hovertextcolor . $hoverbordercolor . $css_extras . ' class="' . $button_class . '"><span class="btn-details">' . $icon . '<span class="btn-text">' . trim( $content ) . $subtext . '</span></span></a>';

			if ( $align === 'center' ) {
				return '<p class="center">' . $content . '</p>';
			} else {
				return $content;
			}
		}
	}
	add_shortcode( 'button', 'labora_sc_button' );
}
