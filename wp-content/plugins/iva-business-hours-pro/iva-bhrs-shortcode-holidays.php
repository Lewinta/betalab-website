<?php
if ( ! function_exists( 'iva_bhp_holidays_shortcode' ) ) {
	function iva_bhp_holidays_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'id'	=> '',
			'style'	=> 'style1',
		), $atts ) );

		do_action( 'iva_bh_front_scripts' );
		// Fetch Data
		global $wpdb;

		$extra_class   = '';
		$holidays_name = explode( ',', $id );

		$iva_bhrs_holidays       = get_option( 'iva_bh_holidays' ) ? get_option( 'iva_bh_holidays' ) : '';
		$iva_bh_date_format      = get_option( 'iva_bh_date_format' ) ? get_option( 'iva_bh_date_format' ) : 'Y/m/d';
		$iva_bh_display_holidays = get_option( 'iva_bh_display_holidays' ) ? get_option( 'iva_bh_display_holidays' ) : '';
		$iva_bh_holidays_order   = get_option( 'iva_bh_holidays_order' ) ? get_option( 'iva_bh_holidays_order' ) : '';

		if ( 'style1' === $style ) {
			$extra_class = 'ivabh-hd-s1';
		}
		if ( 'style2' === $style ) {
			$extra_class = 'ivabh-hd-s2';
		}
		if ( 'style3' === $style ) {
			$extra_class = 'ivabh-hd-s3';
		}

		if ( ! empty( $iva_bhrs_holidays ) ) {
			$iva_bh_hd_data = json_decode( $iva_bhrs_holidays );
			if ( ! function_exists( 'iva_bhp_sc_holidays_order' ) ) {
				function iva_bhp_sc_holidays_order( $a, $b ) {
					$t1 = $a->start;
					$t2 = $b->start;
					return $t1 - $t2;
				}
			}
			if ( 'on' !== $iva_bh_holidays_order ) {
				usort( $iva_bh_hd_data, 'iva_bhp_sc_holidays_order' );
			}

			$out = '';
			foreach ( $iva_bh_hd_data as $key => $value ) {
				$name = isset( $value->name ) ? strip_tags( $value->name ) : '';
				if ( in_array( $name, $holidays_name, true ) || in_array( '', $holidays_name, true ) ) {
					$start        = isset( $value->start ) ? date( $iva_bh_date_format, $value->start ) : '';
					$end          = isset( $value->end ) ? date( $iva_bh_date_format, $value->end ) : '';
					$desc         = isset( $value->desc ) ? stripslashes( $value->desc ) : '';
					$desc_disable = isset( $value->desc_disable ) ? $value->desc_disable : '';
					$bgcolor      = isset( $value->bgcolor ) ? $value->bgcolor : '';
					$text_color   = isset( $value->color ) ? $value->color : '';
					$textcolor    = $text_color ? ' color:' . $text_color . ';' : '';
					$bg_color     = $bgcolor ? 'background-color:' . $bgcolor . ';' : '';

					if ( ! empty( $bg_color ) || ! empty( $textcolor ) ) {
						$extras = ' style="' . $bg_color . $textcolor . '"';
					} else {
						$extras = '';
					}

					if ( 'on' !== $desc_disable ) {
						$out .= '<div class="ivabh-hd-hours ' . $extra_class . '" ' . $extras . '><p>';
						if ( 'on' !== $iva_bh_display_holidays ) {
							if ( strtotime( $end ) >= time() - ( time() % 86400 ) ) {
								$out .= '<span class="days">' . esc_html( $name ) . '</span>';
								if ( $end === $start ) {
									$out .= '<span class="hours ">' . esc_html( $start ) . '</span>';
								} else {
									$out .= '<span class="hours ">' . esc_html( $start ) . ' - ' . esc_html( $end ) . '</span>';
								}
								$out .= '<span class="hd_desc">' . esc_html( $desc ) . '</span>';
							}
						}
						$out .= '</p></div>';
					}
				}
			}
			return $out;
		}
	}
	add_shortcode( 'iva_bhrs_holidays', 'iva_bhp_holidays_shortcode' );
}
