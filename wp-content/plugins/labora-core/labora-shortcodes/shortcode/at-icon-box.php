<?php
	//  I C O N  B O X
if ( !function_exists( 'labora_sc_icon_box' ) ){
	function labora_sc_icon_box( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'				=> '',
			'style'				=> '',
			'icon_type'         => '',
			'faicon'			=> '',
			'peicon'			=> '',
			'font_size'			=> '',
			'icon_color'		=> '',
			'title_color'		=> '',
			'def_icon_color'	=> '',
			'align'				=> 'left',
			'animation'			=> '',
		), $atts));

		//
		$fontsize = $font_size ? 'font-size:' . (int) $font_size . 'px;':'';
		$titlecolor = $title_color ? 'color:' . $title_color . ';':'';
		$fontprops = ( $titlecolor != '' || $fontsize != '' ) ? ' style="' . $fontsize . $titlecolor . '" ' : '';

		//style2,3
		$iconbgcolor	= $def_icon_color ? ' background-color:' . $def_icon_color . ';':'';
		$icon_bgcolor 	= $iconbgcolor ? 'style="' . $iconbgcolor . '"':'';

		//style1
		$iconcolor 	= $icon_color ? 'color:' . $icon_color . ';':'';
		$extras_style1 	= $iconcolor ? 'style="' . $iconcolor . '"':'';

		//Style 4,5
		$icon_bgcolor3	= $icon_color ? 'background-color:' . $icon_color . '':'';
		$icon_bgcolor_style3	= $icon_bgcolor3 ? 'style=' . $icon_bgcolor3 . ';':'';

		//
		$icon_border_style4	= $def_icon_color ? ' border:1px solid ' . $def_icon_color . ';':'';
		$icon_bgcolor_style4 	= $iconbgcolor ? 'style="' . $icon_border_style4 . ' ' . $iconbgcolor . '"':'';

		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';

		$out = '';
		$out .= '<div class="atp-services ' . $animation_class . ' ' . $align . '" ' . $animation . '>';

		//
		if ( $style == 'style1' ) {
			$out .= '<div class="serviceIcn_style1">';
			$out .= '<div class="services-icon">';
			if ( $icon_type == 'faicon' ) {		
				$faicon = $faicon ? $faicon : 'fa-home';
				$out .= '<i class="services_icon1 fa fa-fw fa-2x ' . $faicon . '" ' . $extras_style1 . '></i>';
			} else {
				$peicon = $peicon ? $peicon : 'pe-7s-home';
				$out .= '<i class="services_icon1 pe-2x pe-fw ' . $peicon . '" ' . $extras_style1 . '></i>';
			}
			$out .= '</div>';
			$out .= '<div class="services-content"><h3 ' . $fontprops . '>' . $title . '</h3>';
			if ( $content != '' ) {
				$out .= do_shortcode( $content );
			}
			$out .= '</div>';
			$out .= '</div>';
		}

		if ( $style == 'style2' ) {

			$out .= '<div class="serviceIcn_style2a">';
			$out .= '<div class="services_icon2a ' . $def_icon_color . '" >';
			if ( $icon_type == 'faicon' ) {
				$faicon = $faicon ? $faicon : 'fa-home';
				$out .= '<i class="fa fa-fw ' . $faicon . '"></i>';
			} else {
				$peicon = $peicon ? $peicon : 'pe-7s-home';
				$out .= '<i class="pe-fw ' . $peicon . '"></i>';
			}
			$out .= '</div>';
			$out .= '<div class="sIcn_heading2a">';
			$out .= '<h3 ' . $fontprops . '>' . $title . '</h3>';
			if ( $content != '' ) {
				$out .= '<div class="sIcn_content2a">' . do_shortcode( $content ) . '</div>';
			}
			$out .= '</div>';
			$out .= '</div>';
		}

		if ( $style == 'style3' ) {
			$out .= '<div class="serviceIcn_style2b">';
			$out .= '<div class="services_icon2b ' . $def_icon_color . '" >';
			if ( $icon_type == 'faicon' ) {
				$faicon = $faicon ? $faicon : 'fa-home';
				$out .= '<i class="fa fa-fw ' . $faicon . '"></i>';
			} else {
				$peicon = $peicon ? $peicon : 'pe-7s-home';
				$out .= '<i class="pe-fw ' . $peicon . '"></i>';
			}
			$out .= '</div>';
			$out .= '<div class="sIcn_heading2b">';
			$out .= '<h3 ' . $fontprops . '>' . $title . '</h3>';
			if ( $content != '' ) {
				$out .= '<div class="sIcn_content2b">' . do_shortcode( $content ) . '</div>';
			}
			$out .= '</div>';
			$out .= '</div>';

		}

		if ( $style == 'style4' ) {
			$out .= '<div class="Icnbox_style top">';
			if ( $icon_type == 'faicon') {
				$faicon = $faicon ? $faicon : 'fa-home';
				$out .= '<i class="services_icon3 fa ' . $faicon . '" ' . $icon_bgcolor_style3 . '></i>';
			} else {
				$peicon = $peicon ? $peicon : 'pe-7s-home';
				$out .= '<i class="services_icon3 ' . $peicon . ' pe-fw pe-2x" ' . $icon_bgcolor_style3 . '></i>';
			}
			$out .= '<div class="sIcn_heading2">';
			$out .= '<h3 ' . $fontprops . '>' . $title . '</h3>';
			if ( $content != '' ) {
				$out .= '<div class="sIcn_content2">' . do_shortcode( $content ) . '</div>';
			}
			$out .= '</div>';
			$out .= '</div>';
		}

		if ( $style == 'style5' ) {
			$out .= '<div class="Icnbox_style left">';
			if ( $icon_type == 'faicon' ) {
				$faicon = $faicon ? $faicon : 'fa-home';
				$out .= '<i class="services_icon4 fa ' . $faicon . '" ' . $icon_bgcolor_style3 . '></i>';
			} else {
				$peicon = $peicon ? $peicon : 'pe-7s-home';
				$out .= '<i class="services_icon4 ' . $peicon . 'pe-fw pe-2x" ' . $icon_bgcolor_style3 . '></i>';
			}
			$out .= '<div class="sIcn_heading2">';
			$out .= '<h3 ' . $fontprops . '>' . $title . '</h3>';
			if ( $content != '' ) {
				$out .= '<div class="sIcn_content4">' . do_shortcode( $content ) . '</div>';
			}
			$out .= '</div>';
			$out .= '</div>';
		}
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'iconbox', 'labora_sc_icon_box' );
}
