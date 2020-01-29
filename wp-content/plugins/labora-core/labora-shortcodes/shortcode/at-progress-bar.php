<?php
// P R O G R E S S B A R
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_progressbar' ) ) {
	function labora_sc_progressbar( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'title'							=> '',
			'title_color'					=> '',
			'title_tag'						=> 'h5',
			'txt_percent'					=> '1',
			'txt_percent_color'				=> '',
			'txt_percent_font_size'			=> '',
			'txt_percent_font_weight'		=> '',
			'active_background_color'		=> '',
			'active_border_color'			=> '',
			'no_active_background_color'	=> '',
			'no_active_background_transp'	=> '',
			'height'						=> '',
			'border_radius'					=> '',
			'txt_position'					=> 'false',
			'striped'						=> '',
		), $atts ) );

		$bar_border_extras = $bar_extras = $bar_height_extras = '';

		$title_color = $title_color ? 'color: ' . $title_color . ';' : '';
		$txt_percent_color = $txt_percent_color ? 'color: ' . $txt_percent_color . ';' : '';
		$txt_percent_font_size = $txt_percent_font_size ? 'font-size: ' . $txt_percent_font_size . ';' : '';
		$txt_percent_font_weight = $txt_percent_font_weight ? 'font-weight: ' . $txt_percent_font_weight . ';' : '';
		$active_background_color = $active_background_color ? 'background-color: ' . $active_background_color . ';' : '';
		$active_border_color = $active_border_color ? 'border: 1px solid ' . $active_border_color . ';' : '';
		$progress_number = (int) $txt_percent;

		if ( $height != '' ) {
			$height_px = ( strstr( $height, 'px', true ) ) ? $height : $height . 'px';
			$bar_height_extras .= 'height: ' . $height_px . ';';
		}
		if ( $border_radius != '' ) {
			$border_radius = ( strstr( $border_radius, 'px', true ) ) ? $border_radius : $border_radius . 'px';
			$bar_border_extras .= 'border-radius: ' . $border_radius . ';-moz-border-radius: ' . $border_radius . ';-webkit-border-radius: ' . $border_radius . ';';
		}
		if ( $no_active_background_color != '' ) {
			if ( $no_active_background_transp !== '' && ( $no_active_background_transp >= 0 && $no_active_background_transp <= 1 ) ) {
				$no_active_background_color = aivah_hex2rgb( $no_active_background_color );
				$bar_extras .= 'background-color: rgba(' . $no_active_background_color[0] . ', ' . $no_active_background_color[1] . ', ' . $no_active_background_color[2] . ', ' . $no_active_background_transp . ' );';
			} else {
				$bar_extras .= 'background-color: ' . $no_active_background_color . ';';
			}
		}
		if ( ! empty( $title_color ) ) {
			$extras = ' style="' . $title_color . '"';
		} else {
			$extras = '';
		}
		if ( $title_tag != '' ) {
			$before = '<' . $title_tag . ' class="at-progress-bar-holder clearfix" ' . $extras . '>';
			$after  = '</' . $title_tag . '>';
		}
		$out = $title_out = $bar_out = $striped_class = '';
		if ( $striped == 'true' ) {
			$striped_class = 'striped';
		}
		$title_out .= '<' . $title_tag . ' class="at-progress-title-holder clearfix" ' . $extras . '>';
		$title_out .= '<span class="at-progress-title">' . $title . '</span>';
		$title_out .= '<span class="at-progress-number" style="' . $txt_percent_color . $txt_percent_font_size . $txt_percent_font_weight . '"><span class="at-progress-num">' . $progress_number . '</span>%</span>';
		$title_out .= '</' . $title_tag . '>';
		$bar_out .= '<div class="at-progress-bar-holder" style="' . $bar_extras . $bar_border_extras . $bar_height_extras . '">';
		$bar_out .= '<span data-width="' . $progress_number . '" class="at-prgress-bar-color ' . $striped_class . '" style="' . $active_background_color . $active_border_color . $bar_height_extras . '">';
		$bar_out .= '</span>';
		$bar_out .= '</div>';

		$out .= '<div class="at-progress-horizontal-bar">';
		if ( 'true' == $txt_position ) {
			$out .= $title_out;
			$out .= $bar_out;
		} else {
			$out .= $bar_out;
			$out .= $title_out;
		}
		$out .= '</div>';

		return $out;
	}
	add_shortcode( 'progressbar', 'labora_sc_progressbar' );
}
