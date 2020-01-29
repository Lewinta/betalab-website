<?php
//AUDIO
if ( ! function_exists( 'labora_sc_audio' ) ) {
	function labora_sc_audio( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'         => '',
			'audio_path'    => '',
		), $atts));

		return '<div >' . $audio_path . '</div>';
	}
	add_shortcode( 'audionew', 'labora_sc_audio' );
}


// DIVIDER
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_divider' ) ) {
	function labora_sc_divider( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'margin' => '',
			'type' => '',
			'style' => '',
			'bordercolor' => '',
		), $atts));

		$bordercolor = $bordercolor ? 'border-color:' . $bordercolor . ';' : '';
		$margin      = $margin ? 'margin:' . $margin . ';' : '';
		if ( ! empty( $bordercolor ) || ! empty( $margin ) ) {
			$extras = ' style="' . $bordercolor . $margin . '"';
		} else {
			$extras = '';
		}

		return '<div class="divider ' . $type . ' ' . $style . '" ' . $extras . '></div>';
	}
	add_shortcode( 'divider', 'labora_sc_divider' );
}

// HR ELEMENT
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_hr_space' ) ) {
	function labora_sc_hr_space( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'icon_type' => '',
			'fa_icon'  	=> '',
			'pe_icon'  	=> '',
			'icon_color' => '',
			'position' => '',
			'border_color' => '',
		), $atts));
		$icon_color = $icon_color ? 'color:' . $icon_color . ';' : '';
		$border_color = $border_color ? 'border-color:' . $border_color . ';' : '';
		$out = '';
		$out .= '<div class="at-hr at-hr-' . $position . '">';
		$out .= '<span class="at-hr-inner" style="' . $border_color . '">';
		if ( $icon_type == 'faicon' ) {		
			$fa_icon = $fa_icon ? $fa_icon : 'fa-home';
			$out .= '<i  style="' . $icon_color . '" class="fa ' . $fa_icon . '"></i>';
		} elseif ( $icon_type == 'peicon' ) {
			$pe_icon = $pe_icon ? $pe_icon : 'pe-7s-home';
			$out .= '<i  style="' . $icon_color . '" class="' . $pe_icon . ' pe-lg"></i>';
		} else {
			$out .= '<span class="at-hr-inner-style" style="' . $border_color . '"></span>';
		}
		$out .= '</span>';
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'hr_space', 'labora_sc_hr_space' );
}

// DIVIDER SPACE
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_demo_space' ) ) {
	function labora_sc_demo_space( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'height' => '30',
		), $atts));

		return '<div class="demo_space" ' . ($height ? ' style="height:' . (int) $height . 'px"' : '') . '></div>';
	}
	add_shortcode( 'demo_space', 'labora_sc_demo_space' );
}


// CUSTOM DIVIDER
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_custom_divider' ) ) {
	function labora_sc_custom_divider( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'img' 		=> '',
			'align' 	=> 'aligncenter',
			'margin_bottom' => '',
		), $atts));
		return '<div class="customdivider" ' . ($margin_bottom ? ' style="margin-bottom:' . (int) $margin_bottom . 'px"' : '') . '><img  class="' . $align . '" src="' . $img . '" alt=""></div>';
	}
	add_shortcode( 'custom_divider', 'labora_sc_custom_divider' );
}


// DIVIDER WITH SPACE
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_divider_space' ) ) {
	function labora_sc_divider_space( $atts, $content = null ) {
		return '<div class="divider_space"></div>';
	}
	add_shortcode( 'divider_space', 'labora_sc_divider_space' );
}


// DIVIDER LINE
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_divider_line' ) ) {
	function labora_sc_divider_line( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'bgcolor' => '',
		), $atts));
		$bgcolor = $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
		if ( ! empty( $bgcolor ) ) {
			$extras = ' style="' . $bgcolor . '"';
		} else {
			$extras = '';
		}

		return '<div class="divider_line" ' . $extras . '></div>';
	}
	add_shortcode( 'divider_line', 'labora_sc_divider_line' );
}


// CLEAR
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_clear' ) ) {
	function labora_sc_clear( $atts, $content = null ) {
		return '<div class="clear"></div>';
	}
	add_shortcode( 'clear', 'labora_sc_clear' );
}


// A L I G N M E N T
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_align' ) ) {
	function labora_sc_align( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'position' => '',
		), $atts));
		return '<div class="' . $position . '">' . do_shortcode( $content ) . '</div>';
	}
	add_shortcode( 'align', 'labora_sc_align' );
}


// G O O G L E   F O N T
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_googlefont' ) ) {
	function labora_sc_googlefont( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'font'   => 'RaleWay',
			'size'   => '32px',
			'margin' => '0px',
			'weight' => '',
			'extend' => '',
			'fontstyle' => '',
			'color'  => '',
		), $atts));
		$google = preg_replace( '/ /', '+', $font );
		$protocol = (is_ssl()) ? 'https://' : 'http://';

		if ( $fontstyle == 'true' ) {
			$font_style = 'italic';
		} else {
			$font_style = 'normal';
		}
		if ( $color ) {
			$color = "color :$color";
		} else {
			$color = '';
		}
		if ( ! $weight &&  $extend ) {
			return '<link href="' . $protocol . 'fonts.googleapis.com/css?family=' . $google . ':400'. '&subset=' . $extend . '" rel="stylesheet" type="text/css">
					<div class="google-font" style="font-family:\'' . $font . '\', serif !important; font-size:' . (int) $size . 'px !important;font-weight:' . $weight . ' !important; margin:' . $margin . '  !important; font-style:' . $font_style . ' !important; ' . $color . '">' . do_shortcode( $content ) . '</div>';

		} elseif ( ! $extend && $weight ) {
			return '<link href="' . $protocol . 'fonts.googleapis.com/css?family=' . $google . ':' . $weight . '" rel="stylesheet" type="text/css">
					<div class="google-font" style="font-family:\'' . $font . '\', serif !important; font-size:' . (int) $size . 'px !important;font-weight:' . $weight . ' !important; margin:' . $margin . '  !important; font-style:' . $font_style . ' !important; ' . $color . '">' . do_shortcode( $content ) . '</div>';

		} elseif ( $extend && $weight ) {
			return '<link href="' . $protocol . 'fonts.googleapis.com/css?family=' . $google . ':' . $weight . '&subset=' . $extend . '" rel="stylesheet" type="text/css">
					<div class="google-font" style="font-family:\'' . $font . '\', serif !important; font-size:' . (int) $size . 'px !important;font-weight:' . $weight . ' !important; margin:' . $margin . '  !important; font-style:' . $font_style . ' !important; ' . $color . '">' . do_shortcode( $content ) . '</div>';

		} else {
			return '<link href="' . $protocol . 'fonts.googleapis.com/css?family=' . $google . ':400" rel="stylesheet" type="text/css">
				<div class="google-font" style="font-family:\'' . $font . '\', serif !important; font-size:' . (int) $size . 'px !important; margin:' . $margin . ' !important; font-style:' . $font_style . ' !important; ' . $color . '">' . do_shortcode( $content ) . '</div>';

		}
	}
	add_shortcode( 'googlefont', 'labora_sc_googlefont' );
}


// HIGHLIGHT
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_highlight' ) ) {
	function labora_sc_highlight( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'type' => '',
			'bgcolor' => '',
			'text_color' => '',
		), $atts));

		$bgcolor   = $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
		$textcolor = $text_color ? 'color:' . $text_color . ';' : '';

		if ( $type == 'highlight1' ) {
			$highlight = 'highlight1';
		} else {
			$highlight = 'highlight2';
		}

		if ( ! empty( $textcolor ) || ! empty( $bgcolor ) ) {
			$extras = ' style="' . $bgcolor . $textcolor . '"';
		} else {
			$extras = '';
		}
		return '<span class="' . $highlight . '" ' . $extras . '>' . do_shortcode( $content ) . '</span>';
	}
	add_shortcode( 'highlight', 'labora_sc_highlight' );
}


// F A N C Y   H E A D I N G
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_fancy_heading' ) ) {
	function labora_sc_fancy_heading( $atts, $content = null, $code )	{
		extract(shortcode_atts(array(
			'headingcolor' 	=> '',
			'sepcolor' 	    => '',
			'fancy_style'	=> 'v1',
			'heading' 		=> 'h1',
			'align' 		=> '',
			'title'			=> '',
			'subtitle'		=> '',
			'icon_color'	=> '',
			'heading_style'	=> '',
			'border_color'	=> '',
			'margin_bottom' => '',
			'margin_top' => '',
			'fancy_border'	=> '',
		), $atts));

		$headingcolor = $headingcolor ? 'color:' . $headingcolor . ';' : '';
		$border_color = $border_color ? 'border-color:' . $border_color . ';' : '';
		$icon_color = $icon_color ? 'color:' . $icon_color . ';' : '';
		$sepcolor     = $sepcolor ? 'background-color:' . $sepcolor . ';' : '';
		$sepbgcolor = ' style="' . $sepcolor . '"';
		$headingstyle = '';

		if ( ! empty( $headingcolor ) ) {
			$extras = ' style="' . $headingcolor . '"';
		} else {
			$extras = '';
		}
		if ( ! empty( $icon_color ) ) {
			$icon_extras = ' style="' . $icon_color . '"';
		} else {
			$icon_extras = '';
		}
		if ( ! empty( $border_color ) ) {
			$border_color = ' style="' . $border_color . '"';
		} else {
			$border_color = '';
		}
		$before = $after = $out = $xlclass = '';
		if ( $heading == 'xlarge' ) {
			$heading = 'h1';
			$xlclass = 'xlarge';
		}
		if ( $heading == 'large' ) {
			$heading = 'h1';
			$xlclass = 'large';
		}
		if ( $heading != '' ) {
			$before = '<' . $heading . ' class="at-fancy-title-' . $fancy_style . ' ' . $xlclass . '" ' . $extras . '>';
			$after  = '</' . $heading . '>';
		}

		$margins = ( $margin_bottom != '' || $margin_top != '' ) ? ' style="margin-bottom:' . (int) $margin_bottom . 'px; margin-top:' . (int) $margin_top . 'px;"' : '';

		$out .= '<div class="at-fancy-heading-' . $fancy_style . ' ' . $align . '" ' . $margins .'>';
		if ( 'v1' == $fancy_style  ) {
			$out .= $before . $title . $after;
		}
		if ( 'v3' == $fancy_style  ) {
			$out .= $before . '<span >' . $title . '</span>' . $after;
		}
		if ( 'v4' == $fancy_style  ) {
			$out .= $before . '<i class="fa fa-caret-right fa-fw" ' . $icon_extras . '></i>' . $title . '<i class="fa fa-caret-left fa-fw" ' . $icon_extras . '></i>' . $after;
		}
		if ( 'v6' == $fancy_style  ) {
			$out .= $before . '<span class="at-fancy-line-' . $fancy_style . ' ' . $fancy_border . '" ' . $border_color . ' >' . $title . '</span>' . $after;
		}
		if ( 'v2' === $fancy_style  || 'v5' === $fancy_style ) {
			$out .= $before . $title . $after;
		}
		if ( 'v1' == $fancy_style ) {
			$out .= '<span class="at-fancy-heading-' . $fancy_style . '-sep"  ' . $sepbgcolor . '></span>';
		}
		if ( $subtitle != '' ) {
			if ( 'v5' == $fancy_style  ) {
				$out .= '<p class="at-fancy-subtitle-' . $fancy_style . '">' . do_shortcode( $subtitle ) . '</p>';
			} else {
				$out .= '<span class="at-fancy-subtitle-' . $fancy_style . '">' . do_shortcode( $subtitle ) . '</span>';
			}
		}
		$out .= '</div>';
		if ( 'v5' == $fancy_style ) {
			$out .= '<div class="at-fancy-heading-' . $fancy_style . '-sep ' . $align . '"  ' . $sepbgcolor . '></div>';
		}
		return $out;
	}
	add_shortcode( 'fancyheading', 'labora_sc_fancy_heading' );
}

// D R O P C A P
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_dropcap' ) ) {
	function labora_sc_dropcap( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'color'         => '',
			'letter'        => '',
			'type'          => '',
			'text'          => '',
			'text_color'    => '',
			'bgcolor'       => '',
		), $atts));

		if ( $type == 'dropcap1' ) {
			$drop_class = 'dc-square';
			$drop_style = ( $bgcolor ) ? 'style="background-color:' . $bgcolor . ';color:' . $text_color . '"':'';

		} elseif ( $type =='dropcap2' ) {
			$drop_class = 'dc-circle';
			$drop_style = ($bgcolor) ? 'style="background-color:' . $bgcolor . ';color:' . $text_color . '"':'';

		} elseif ( $type == 'dropcap3' ) {
			$drop_class = 'dc-text';
			$drop_style = ( $text_color ) ? 'style="color:' . $text_color . '"':'';
		}

		if ( $type == 'dropcap3' ) {
			return '<span  class="dropcap dropcap3 ' . $drop_class . '" ' . $drop_style . '>' . do_shortcode( $letter ) . '</span>';
		} else {
			return '<span  class="dropcap ' . $drop_class . '" ' . $drop_style . '>' . do_shortcode( $letter ) . '</span>';
		}

	}
	add_shortcode( 'dropcap', 'labora_sc_dropcap' );
}



// B L O C K Q U O T E
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_blockquote' ) ) {
	function labora_sc_blockquote( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'align' 	=> '',
			'cite' 		=> '',
			'citelink' 	=> '',
			'width' 	=> '',
			'animation' => '',
			'bg_color'  => '',
			'txt_color' => '',
		), $atts));

		// Animation Effects
		//--------------------------------------------------------
		$out = '';
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';
	
		$bgcolor 	= $bg_color ? 'background-color: ' . $bg_color . '; ' : '';
		$text_color = $txt_color ? 'color: ' . $txt_color . ';':'';
		$width = $width ? ' width: ' . $width . ';' : '';
		$styling 	= ( $bgcolor || $text_color || $width !='' ) ? ' style="'. $bgcolor . $text_color . $width . '"' : '' ;

		$out .= '<blockquote ' . $animation . ' ' . $styling . ' class="' . $animation_class . ' ' . ( $align ? ' align' . $align:'' ) . '">';
		$out .= '<p >' . do_shortcode( $content ) . '</p>';

		if ( $cite && $citelink ) {
			$out .= '<cite><a href="' . esc_url( $citelink ) . '">- ' . $cite . '</a></cite>';
		} elseif ( ! $cite && $citelink ) {
			$out .= '<cite><a href="' . esc_url( $citelink ) . '">' . esc_url( $citelink ) . '</a></cite>';
		} elseif ( $cite && ! $citelink ) {
			$out .= $cite;
		}
		$out .= '</blockquote>';
		return $out;
	}
	add_shortcode( 'blockquote', 'labora_sc_blockquote' );
}


// L I S T   I C O N S
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_list' ) ) {
	function labora_sc_list( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'icon_type' => '',
			'faicon'  	=> '',
			'peicon'  	=> '',
			'color' 	=> '',
			'bgcolor'   => '',
			'liststyle' => 'default',
		), $atts));
			$color = $color ? 'color:' . $color . ';' : '';
			$bgcolor = $bgcolor ? 'background-color:' . $bgcolor . ';' : '';
			$liststyle = $liststyle ?  $liststyle : '';

		if ( $liststyle == 'default' ) {
			if ( $icon_type == 'faicon' ) {
				$faicon = $faicon ? $faicon : 'fa-home';
				$icon_type = '<span class="icon-wrapper"><i class="fa fa-fw ' . $faicon . '"  style="' . $color . '"></i></span>';
			} elseif ($icon_type == 'peicon') {
				$peicon = $peicon ? $peicon : 'pe-7s-home';
				$icon_type = '<span class="icon-wrapper"><i class="' . $peicon . ' pe-lg" style="' . $color . '"></i></span>';
			} else {
				$icon_type = '';
			}
			$iconstring = str_replace( '<ul>', '<ul class="iva-checklist iva-liststyle1">', do_shortcode( $content ) );
			$out = str_replace( '<li>', '<li class="iva-li-item-content">' . $icon_type . '', do_shortcode( $iconstring ) );
		} else {
			if ( $icon_type == 'faicon' ) {
				$faicon = $faicon ? $faicon : 'fa-home';
				$icon_type = '<span class="icon-wrapper"><i class="fa fa-fw ' . $faicon . ' list_circle"  style="' . $color . $bgcolor . '"></i></span>';			} else {
				$peicon = $peicon ? $peicon : 'pe-7s-home';
				$icon_type = '<span class="icon-wrapper"><i class="' . $peicon . ' pe-lg list_circle"  style="' . $color . $bgcolor . '"></i></span>';
			}
			$iconstring = str_replace( '<ul>', '<ul class="iva-checklist iva-liststyle2">', do_shortcode( $content ) );
			$out = str_replace( '<li>', '<li class="iva-li-item-content">' . $icon_type . '', do_shortcode( $iconstring ) );
		}
		return $out;
	}
	add_shortcode( 'list', 'labora_sc_list' );
}

// L I S T   I C O N S  I T E M
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_list_icon_item' ) ) {
	function labora_sc_list_icon_item( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'icon_type' => '',
			'faicon'  	=> '',
			'peicon'  	=> '',
			'icon_list_style' => 'transparent',
			'icon_color'   => '',
			'icon_bgcolor'   => '',
			'title_color' 	=> '',
			'title_txt'   => '',
			'title_txt_size'   => '',
		), $atts));
		$icon_color = $icon_color ? 'color:' . $icon_color . ';' : '';
		$icon_bgcolor = $icon_bgcolor ? 'background-color:' . $icon_bgcolor . ';' : '';
		$title_color = $title_color ? 'color:' . $title_color . ';' : '';
		$title_txt_size = $title_txt_size ? 'font-size:' . $title_txt_size . ';' : '';
		$icon_list_style = $icon_list_style ?  $icon_list_style : '';
		$out = '';
		$out .= '<div class="at-icon-list-item">';
		if ( $icon_type == 'faicon' ) {
			$faicon = $faicon ? $faicon : 'fa-home';
			$icon_type = '<i class="fa fa-fw ' . $faicon . ' ' . $icon_list_style . '" style="' . $icon_color . $icon_bgcolor . '"></i>';
		} else {
			$peicon = $peicon ? $peicon : 'pe-7s-home';
			$icon_type = '<i class="' . $peicon . ' ' . $icon_list_style . ' pe-lg"  style="' . $icon_color . $icon_bgcolor . '"></i>';
		}
		$out .= $icon_type;
		$out .= '<p style="' . $title_color . $title_txt_size . '">' . $title_txt . '</p>';
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'list_icon_item', 'labora_sc_list_icon_item' );
}



// F O N T A W E S O M E   I C O N S
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_awesomefont' ) ) {
	function labora_sc_awesomefont( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'icon_type' => '',
			'faicon'  	=> '',
			'peicon'  	=> '',
			'color' => '',
			'size' => '',
		), $atts));

		$color = $color ? 'color:' . $color . ';' : '';
		$size  = $size ? 'font-size:' . (int) $size . 'px"' : '';

		$out = '';
		if ( $icon_type == 'faicon' ) {
			$faicon = $faicon ? $faicon : 'fa-home';
			$out .= '<i  style="' . $color . ' ' . $size . '" class="fa ' . $faicon . '"></i>';
		} else {
			$peicon = $peicon ? $peicon : 'pe-7s-angle-right';
			$out .= '<i  style="' . $color . ' ' . $size . '" class="' . $peicon . ' pe-lg"></i>';
		}

		return $out;

	}
	add_shortcode( 'icons', 'labora_sc_awesomefont' );
}


// F A N C Y   A M P E R S A N D
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_fancy_ampersand' ) ) {
	function labora_sc_fancy_ampersand( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'color' => '',
			'size' 	=> '',
		), $atts));

		$color = $color ? 'color:' . $color . ';' : '';
		$size  = $size ? 'font-size:' . (int) $size . 'px;' : '';

		return '<span class="fancy_ampersand" style="' . $color . ' ' . $size . '">&amp;</span>';
	}
	add_shortcode( 'fancy_ampersand', 'labora_sc_fancy_ampersand' );
}


// S E C T I O N  F U L L W I D T H
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_section' ) ) {
	function labora_sc_section( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'bgcolor'    	=> '',
			'textcolor'  	=> '',
			'padding'    	=> '',
			'parallax'   	=> '',
			'video'      	=> '',
			'opacity'    	=> '',
			'pattern'   	=> '',
			'image'      	=> '',
			'position'   	=> '',
			'repeat'     	=> '',
			'attachment'	=> '',
			'video_bg' 		=> '',
			'content_type' 	=> '',
			'row_id'		=> '',
		), $atts));

		$videoclass = $full_width_class = $str = $out = '';
		$videoclass = 'iva-page-section';

		$textcolor  = $textcolor ? 'color:' . $textcolor . ' !important;':'';
		$padding    = $padding ? 'padding:' . $padding . ';' : '' ;
		$opacity    = $opacity ? 'opacity:' . $opacity . ';':'';
		$bgcolor    = $bgcolor ? 'background-color:' . $bgcolor . ';':'';
		$parallaxid = rand( 1,99 );

		if ( is_page_template( 'template_stretched.php' ) ) {
			if ( $content_type == 'inner_width' ) {
				$full_width_class	= 'inner_content';
			} elseif ( $content_type == 'full_width_background' ) {
				$full_width_class = 'full-width-class';
			} elseif ( $content_type == 'full_content_background' ) {
				$full_width_class = 'full-content-class';
			}
		} else {
			$full_width_class = '';
		}
		if ( $parallax == 'true' ) {
			$extraclass= 'parallaxsection';
		} else {
			$extraclass = '';
		}

		if ( $image ) {
			$str .= 'background-image:url(' . $image . ');';
			if ( $repeat ) {
				$str .= 'background-repeat:' . $repeat . ';';
			}
			if ( $position ) {
				$str .= 'background-position:' . $position . ';';
			}
			if ( $attachment ) {
				$str .= 'background-attachment:' . $attachment . ';';
			}
		}

		$section_pattern  = LABORA_SC_IMG_URI . '/patterns/' . $pattern;
		$pattern = $pattern ? 'background-image:url( ' . $section_pattern . ');':'';
		if ( ! empty( $bgcolor ) || ! empty( $image ) || ! empty( $textcolor ) || ! empty( $padding ) ) {
			$inner_extras = 'style="' . $bgcolor . $str . $padding . $textcolor . '"';
		} else {
			$inner_extras = '';
		}
		if ( $pattern || ! empty( $opacity ) ) {
			$pattern = 'style="' . $pattern . $opacity . '"';
		}

		$out .= '<div data-id="section' . $parallaxid . '"  class="section_row ' . $full_width_class . '  clearfix section_bg ' . $extraclass . '  ' . $videoclass . ' " ' . $inner_extras . '>';
		$out .= '<div class="iva-section-patterns" ' . $pattern . '></div>';

		if ( $video_bg = 'true' &&  $video ) {
			$out .= '<div class="iva-section-video">';
			$out .= '<video width="100%"  poster="' . $image . '" preload="auto" loop autoplay muted>';
		 	if ( $video ) { $out .= '<source src="' . $video . '" type="video/mp4" />'; }
			$out .= '</video>';
			$out .= '</div>';
		}
		if ( is_page_template( 'template_stretched.php' ) ) {
			if ( $content_type == 'full_width_background' ) {
				$out .= '<div class="page_content"><div class="section_inner" id ="' . $row_id . '">' . do_shortcode( $content ) . '</div></div>';
			} elseif ( $content_type == 'full_content_background') {
				$out .= '<div class="page_fullcontent" id ="' . $row_id . '">' . do_shortcode( $content ) . '</div>';
			} elseif ( $content_type == 'inner_width' ) {
				$out .= '<div class="page_inner"><div class="section_inner" id ="' . $row_id . '">' . do_shortcode( $content ) . '</div></div>';
			} else {
				$out .= '<div class="section_inner" id ="' . $row_id . '">' . do_shortcode( $content ) . '</div>';
			}
		} else {
			$out .= '<div class="section_inner" id ="' . $row_id . '">' . do_shortcode( $content ) . '</div>';
		}
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'section', 'labora_sc_section' );
}

// Fun Fact
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_funfact' ) ) {
	function labora_sc_funfact( $atts, $content = null, $code ) {
		extract(shortcode_atts(array(
			'icon_style'		=> false,
			'icon_color'		=> '',
			'title_color'		=> '',
			'main_title'		=> '',
			'data_number'		=> '',
			'data_value'		=> '',
			'position'			=> '',
			'icon_position'		=> 'left',
		), $atts));
		$out = '';
		$iconcolor = $icon_color ? 'color:' . $icon_color . ';' : '';
		$titlecolor = ( $title_color != '' ) ? ' style="color:' . $title_color . ';"':'';
		$factposition = ( $position != '' ) ? ' style="text-align:' . $position . ';"':'';
		$icon_position_align = '<div class="at-funfact-icon">';
		if ( $icon_style ) { $icon_position_align .= '<i style="' . $iconcolor . '" class="fa ' . $icon_style . ' fa-fw"></i>'; }
		$icon_position_align .= '</div>';
		$out .= '<div class="at-funfact-wrap">';
		if ( $icon_position == 'left' ) { $out .= $icon_position_align; }
		$out .= '<div class="at-funfact" ' . $factposition . '>';
		$out .= '<span ' . $titlecolor . ' data-number="' . $data_number . '" class="funfact-number">' . $data_value . '</span>';
		$out .= '<p ' . $titlecolor . ' class="funfact-number-title">' . $main_title . '</p>';
		$out .= '</div>';
		if ( $icon_position == 'right' ) { $out .= $icon_position_align; }
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'funfact', 'labora_sc_funfact' );
}

// C O U N T D O W N
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_countdown' ) ) {
	function labora_sc_countdown( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'     => '',
			'year'      => '',
			'month'     => '',
			'day'       => '',
			'hour'      => '',
			'minute'    => '',
			'bgcolor'	=> '',
			'textcolor' => '',
			'class'  	=> '',
			'format'	=> 'dHMS',
		), $atts));
		do_action( 'iva_enqueue_counter' );
		$out = '';
		$second = '00';
		if ( $title != '' ) {
			$out .= $title;
		}
		$extraclass = ($class !='') ? ' class="' . $class . '"':'';
		$random_num  = rand( 1, 9999 );
		$out .= '<script type="text/javascript">
		jQuery(function($) {
			var enddate = new Date(' . $year . ' , ' . $month . '-1 , ' . $day . ',' . $hour . ',' . $minute . ',0);
			$("#iva-countdown-' . $random_num . '").countdown({
				until: enddate,
				format: "' . $format . '",
				padZeroes: true,
				labels:["Years","Months","Weeks","Days","Hours","Minutes","Seconds"],
				labels1:["Year","Month","Week","Day","Hour","Minute","Second"]
			});
		});
		</script>';
		$out .= '<div id="iva-countdown-' . $random_num . '" ' . $extraclass . '></div>';
		return $out;
	}
	add_shortcode( 'countdown', 'labora_sc_countdown' );
}

// P R I C E G R O U P
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_price_group' ) ) {
	function labora_sc_price_group( $atts, $content ) {
		extract(shortcode_atts(array(
		), $atts));

		wp_reset_postdata();

		$GLOBALS['price_count'] = 0;
		$count = 0;

		$columnid = $class = $output = $featured = '';
		do_shortcode( $content );

		if ( is_array( $GLOBALS['price'] ) ) {
			foreach ( $GLOBALS['price'] as $price ) {

				if ($price['featured'] == 'true' ) {
					$featured = 'featured';
				} else {
					$featured = '';
				}

				$output .= '<div class="column ' . $featured . $columnid . '">';
				$bgcolor = $price['headingbgcolor'];
				$color   = $price['headingcolor'];
				$textcolor = $price['textcolor'];
				$bgcolor = $bgcolor ? 'background-color:' . $bgcolor . ';':'';
				$color   = $color ? 'color:' . $color . '; ' : '';
				$extras  = ( $color != ''|| $bgcolor != '' ) ?' style="' . $color . $bgcolor . '"':'';

				$textcolor = $textcolor ? 'color:' . $textcolor . ';':'';
				$info_extras = ( $textcolor != '') ? ' style="' . $textcolor . '"' : '';

				$output .= '<div class="price-head" ' . $extras . '>';
				$output .= '<h2 class="title">' . $price['title'] . '</h2>';
				$output .= '<h4 class="price-font">' . do_shortcode( $price['price'] ) . '</h4>';
				$output .= '</div>';
				$output .= '<div class="price-content" ' . $info_extras . '>' . do_shortcode( $price['content'] ) . '</div>';
				$output .= '</div>';
				$count++;
			}
			if ( $count == '3' ) { $class = 'col3'; }

			$html  = '<div class="pricetable ' . $class . ' "><div class="pricing-inner">';
			$html .= $output;
			$html .= '</div>';
		}

		$html .= '</div>';
		unset( $GLOBALS['price'], $GLOBALS['price_count'] );

		return $html;
	}
}
// P R I C E
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_price' ) ) {
	function labora_sc_price( $atts, $content ) {
		extract(shortcode_atts(array(
			'title'				=> '',
			'featured'			=> '',
			'price'				=> '',
			'headingbgcolor'	=> '',
			'headingcolor'		=> '',
			'textcolor'			=> '',
		), $atts));

		$x = $GLOBALS['price_count'];
		$GLOBALS['price'][ $x ] = array(
			'title'				=> $title,
			'featured'			=> $featured,
			'price'				=> do_shortcode( $price ),
			'headingbgcolor'	=> $headingbgcolor,
			'headingcolor'		=> $headingcolor,
			'textcolor'			=> $textcolor,
			'content'			=>  $content,
		);
		$GLOBALS['price_count']++;
	}
	add_shortcode( 'pricingcolumns', 'labora_sc_price_group' );
	add_shortcode( 'col', 'labora_sc_price' );
}
?>
