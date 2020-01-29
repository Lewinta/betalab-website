<?php
// F A N C Y B O X
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_fancy_box' ) ) {
	function labora_sc_fancy_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'				=> '',
			'title_color'		=> '',
			'title_bgcolor'		=> '',
			'box_textcolor'		=> '',
			'box_bgcolor'		=> '',
			'ribbon_text'    	=> '',
			'default_color'		=> '',
			'ribbon_size'		=> '',
			'rib_custom_color'  => '',
			'ribbon_check'		=> '',
			'animation' 		=> '',
		), $atts ) );

		$titlebgcolor 		= $title_bgcolor 	? 'background-color:' . $title_bgcolor . ';' : '';
		$titlecolor			= $title_color 		? 'color:' . $title_color . ';' : '';
		$boxbgcolor			= $box_bgcolor 		? 'background-color:' . $box_bgcolor . ';' : '';
		$boxtextcolor		= $box_textcolor 	? 'color:' . $box_textcolor . ';' : '';

		if ( ! empty( $boxbgcolor ) || ! empty( $boxtextcolor ) ) {
			$boxextras = ' style="' . $boxbgcolor . $boxtextcolor . '"';
		} else {
			$boxextras = '';
		}

		if ( ! empty( $titlebgcolor ) || ! empty( $titlecolor ) ) {
			$extras = ' style="' . $titlebgcolor . $titlecolor . '"';
		} else {
			$extras = '';
		}
		$banner_class = '';
		if ( $ribbon_check == 'true' ) {
			$banner_class = 'class ="banner"';
		}
		// Animation Effects
		//-------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';

		$out  = '<div ' . $animation . ' class="fancybox ' . $animation_class . '" ' . $boxextras . '>';
		if ( $ribbon_text ) {
				$out .= '<div class="ribbon ribbon-' . $ribbon_size . ' ribbon-' . $default_color . '">';
				$out .= '<div ' . $banner_class . '>';
				$out .= '<div class="text ' . $default_color . '"  >' . $ribbon_text . '</div>';
				$out .= '</div>';
				$out .= '</div>';
		}

		if ( $title ) {
			$out .= '<h4 class="fancytitle" ' . $extras . '>' . $title . '</h4>';
		}

		$out .= '<div class="boxcontent">';
		$out .= do_shortcode( $content ) . '</div></div>';
		return $out;
	}
	add_shortcode( 'fancybox', 'labora_sc_fancy_box' );
}
// Callout Box
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_callout' ) ) {
	function labora_sc_callout( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'type' 							=> 'normal',
			'icon' 							=> '',
			'icon_size' 					=> '',
			'icon_color'					=> '',
			'background_color' 				=> '',
			'border_color' 					=> '',
			'padding_top' 					=> '',
			'padding_bottom' 				=> '',
			'btn_size' 						=> '',
			'btn_link' 						=> '',
			'btn_text' 						=> '',
			//'btn_target' 					=> '',
			'btn_text_color' 				=> '',
			'btn_hover_text_color' 			=> '',
			'btn_background_color' 			=> '',
			'btn_hover_background_color'	=> '',
			'btn_border_color' 				=> '',
			'btn_hover_border_color' 		=> '',
			'text_color' 					=> '',
			'text_size' 					=> '',
			'text_font_weight' 				=> '',
			'text_letter_spacing' 			=> '',
			'subtitle_color'				=> '',
			'title'							=> '',
			'subtitle'						=> '',
		), $atts));

		$callout_styles = $btn_styles = $btn_data_attr = $icon_styles = $out = $content_styles = $subtext_styles = '';

		if ( $background_color != '' ) {
			$callout_styles .= 'background-color: ' . $background_color . ';';
		}
		if ( $padding_top != '' ) {
			$callout_styles .= 'padding-top: ' . (int)$padding_top . 'px;';
		}
		if ( $padding_bottom != '' ) {
			$callout_styles .= 'padding-bottom: ' . (int)$padding_bottom . 'px;';
		}
		if ( $border_color != '' ) {
			$callout_styles .= 'border-top: 1px solid ' . $border_color . ';';
		}

		if ( ! empty( $background_color ) || ! empty( $padding_top ) || ! empty( $padding_bottom ) || ! empty( $border_color ) ) {
			$callout_style_extras = ' style="' . $callout_styles . '"';
		} else {
			$callout_style_extras = '';
		}

		if ( $btn_text_color != '' ) {
			$btn_styles .= 'color: ' . $btn_text_color . ';';
		}
		if ( $btn_background_color != '' ) {
			$btn_styles .= 'background-color: ' . $btn_background_color . ';';
		}
		if ( $btn_border_color != '' ) {
			$btn_styles .= 'border-color: ' . $btn_border_color . ';';
		}
		if ( $btn_background_color != '' ) {
			$btn_data_attr .= 'data-btn-bg=' . $btn_background_color . ' ';
		}
		if ( $btn_hover_text_color != '' ) {
			$btn_data_attr .= 'data-btn-color=' . $btn_hover_text_color . ' ';
		}
		if ( $btn_hover_background_color != '' ) {
			$btn_data_attr .= 'data-btn-hoverBg=' . $btn_hover_background_color . ' ';
		}
		if ( $btn_hover_border_color != '' ) {
			$btn_data_attr .= 'data-btn-hoverborder=' . $btn_hover_border_color . ' ';
		}
		if ( $icon_color != '' ) {
			$icon_styles .= 'style="color: ' . $icon_color . ';"';
		}

		if ( ! empty( $btn_text_color ) || ! empty( $btn_background_color ) || ! empty( $btn_border_color ) ) {
			$btn_style_extras = ' style="' . $btn_styles . '"';
		} else {
			$btn_style_extras = '';
		}

		$out = '<div class="at-callOutBox" ' . $callout_style_extras . '>';
		$out .= '<div class="at-callOut_inner">';
		$out .= '<div class="at-callOut-action">';

		if ( $text_size != '' ) {
			$content_styles .= 'font-size:' . (int)$text_size . 'px;';
		}
		if ( $text_color != '' ) {
			$content_styles .= 'color:' . $text_color . ';';
		}
		if ( $text_font_weight != '' ) {
			$content_styles .= 'font-weight:' . (int)$text_font_weight . ';';
		}
		if ( $text_letter_spacing != '' ) {
			$content_styles .= 'letter-spacing:' . (int)$text_letter_spacing . 'px;';
		}

		if ( ! empty( $text_size ) || ! empty( $text_color ) || ! empty( $text_font_weight )|| ! empty( $text_letter_spacing ) ) {
			$callout_action_text_extras = ' style="' . $content_styles . '"';
		} else {
			$callout_action_text_extras = '';
		}
		if ( $subtitle_color != '' ) {
			$subtext_styles .= 'style="color:' . $subtitle_color . ';"';
		}

		$out .= '<div class="at-callOut_text">';
		if ( $type == 'yes_icon' ) {
			$out .= '<div class="at-callout-action-icon-holder">';
			$out .= '<i class="fa ' . $icon . ' ' . $icon_size . '" ' . $icon_styles . '></i>';
			$out .= '</div>';
		}
		if ( $title != '' ) {
			$out .= '<div class="at-callout-action-text" ><h1 '.$callout_action_text_extras.'>' . $title .'</h1>';
			if ( $subtitle !='' ) {
				$out .= '<div class="at-callout-action-subtext" ' . $subtext_styles . ' >' . $subtitle . '</div>';
			}
			$out .= '</div>'; // at-callout-action-text
		}
		$out .= '</div>'; // at-callOut_text
		if ( $btn_text != '' ) {
			$out .= '<div class="at-callOut_btn"><div class="at-callout-action-button"><a href="' . $btn_link . '" class="btn ' . $btn_size . '" ' . $btn_style_extras . ' ' . $btn_data_attr . '><span class="btn-text">' . $btn_text . '</span></a></div></div>';
		}
		$out .= '</div>'; //at-callOut-action
		$out .= '</div>';//at-callOut_inner
		$out .= '</div>'; //at-callOutBox

		return $out;
	}
	add_shortcode( 'callout', 'labora_sc_callout' );
}
