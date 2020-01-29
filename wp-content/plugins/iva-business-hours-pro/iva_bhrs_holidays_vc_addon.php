<?php
/*
 * Add-on Name: VC Addons for Holidays
 */
if ( ! class_exists( 'Iva_Business_Hours_Pro_Holidays' ) ) {
	class Iva_Business_Hours_Pro_Holidays {

		// Constructor
		function __construct() {
			add_action( 'init', array( $this, 'iva_bhp_holidays_init' ) );
			add_shortcode( 'iva_bhrs_holidays_addon', array( $this, 'iva_bhp_holidays_shortcode' ) );
		}

		// Initialize the location function
		function iva_bhp_holidays_init() {
			if ( function_exists( 'vc_map' ) ) {
				$iva_bhrs_holidays = get_option( 'iva_bh_holidays' ) ? get_option( 'iva_bh_holidays' ) : '';
				$holiday_options = array();
				if ( ! empty( $iva_bhrs_holidays ) ) {
					$iva_bh_hd_data = json_decode( $iva_bhrs_holidays );
					foreach ( $iva_bh_hd_data as $key => $value ) {
						$name = isset( $value->name ) ? strip_tags( $value->name ) : '';
						$holiday_options[ $name ] = $name;
					}
				}

				// VC Map
				vc_map(
					array(
					   'name' 		 => esc_html( 'BHP - Holidays', 'iva_business_hours' ),
					   'base' 		 => 'iva_bhrs_holidays_addon',
					   'class' 		 => '',
					   'icon' 		 => '',
					   'category' 	 => 'Aivah VC Addons',
					   'description' => __( 'Display BHP Holidays', 'iva_business_hours' ),
					   'params' 	 => array(
							array(
								'type'			 => 'textfield',
								'holder'		 => 'div',
								'class' 		 => '',
								'heading' 		 => __( 'Title', 'iva_business_hours' ),
								'param_name' 	 => 'title',
								'value' 		 => '',
								'description' 	 => __( 'Display title for holidays', 'iva_business_hours' ),
							),
							array(
								'type'			 => 'checkbox',
								'holder'		 => 'div',
								'class' 		 => '',
								'heading' 		 => __( 'Holidays', 'iva_business_hours' ),
								'param_name' 	 => 'holidays',
								'value' 		 => $holiday_options,
								'description' 	 => __( 'Check the Holidays you wish to display.', 'iva_business_hours' ),
							),
							array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'Choose Styles', 'iva_business_hours' ),
								'param_name' 	=> 'style',
								'value' 	 	=> array(
														'Choose one...'	=> '',
														'Style1'	=> 'style1',
														'Style2' => 'style2',
													),
								'description' 	=> esc_html__( 'Choose the Holidays Styles', 'iva_business_hours' ),
							),
						),
					)
				);
			}
		}
		// Shortcode handler function for Location
		function iva_bhp_holidays_shortcode( $atts ) {
			extract( shortcode_atts( array(
				'title'		=> '',
				'holidays' 	=> '',
				'style'		=> '',
			), $atts));
			$out = ''; //stores the output

			// Fetch Data
			global $wpdb;
			$holidays_name = explode( ',', $holidays );
			$extra_class = 'ivabh-hd-s1';
			$iva_bhrs_holidays  = get_option( 'iva_bh_holidays' ) ? get_option( 'iva_bh_holidays' ) : '';
			$iva_bh_date_format = get_option( 'iva_bh_date_format' ) ? get_option( 'iva_bh_date_format' ) : 'Y/m/d';
					if( 'style1' === $style ){ $extra_class="ivabh-hd-s1"; }
					if( 'style2' === $style ){ $extra_class="ivabh-hd-s2"; }

			if ( '' != $title ) { $out .= '<h3 class="iva-bhp-htitle">' . $title . '</h3>'; }

			if ( ! empty( $iva_bhrs_holidays ) ) {
				$iva_bh_hd_data = json_decode( $iva_bhrs_holidays );
				foreach ( $iva_bh_hd_data as $key => $value ) {
					$name 			= isset( $value->name ) ? strip_tags( $value->name ) : '';
					if ( in_array( $name, $holidays_name ) || in_array( '', $holidays_name ) ) {
						$start 			= isset( $value->start ) ? date( $iva_bh_date_format, $value->start ) : '';
						$end 			= isset( $value->end ) ? date( $iva_bh_date_format, $value->end ) : '';
						$desc 			= isset( $value->desc ) ? stripslashes( $value->desc ) : '';
						$desc_disable 	= isset( $value->desc_disable ) ? $value->desc_disable : '';
						$bgcolor 	= isset( $value->bgcolor ) ? $value->bgcolor : '';
						$text_color 	= isset( $value->color ) ? $value->color : '';
						$textcolor 		= $text_color 		? ' color:'.$text_color.';':'';
						$bg_color 		= $bgcolor 			? 'background-color:'.$bgcolor.';':'';
						if (!empty($bg_color) || !empty($textcolor)) {
							$extras = ' style="' . $bg_color . $textcolor . '"';
						} else {
							$extras = '';
						}

						if ( 'on' != $desc_disable ) {
							$out .= '<div class="ivabh-hd-hours '.$extra_class.'" '.$extras.'><p>';
							if ( strtotime( $end ) >= time() - (time() % 86400) ) {
								$out .= '<span class="days ">' . $name . '</span>';
								if ( $start == $end ) {
									$out .= '<span class="hours ">' . $start . '</span>';
								} else {
									$out .= '<span class="hours ">' . $start . ' - ' . $end . '</span>';
								}
								$out .= '<small>' . $desc . '</small>';
							}
							$out .= '</p></div>';
						}
					}
				}
			}
			return $out;
		}
	}
}

if ( class_exists( 'Iva_Business_Hours_Pro_Holidays' ) ) {
	$iva_business_hours_pro_holidays = new Iva_Business_Hours_Pro_Holidays;
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_iva_bhrs_holidays_addon extends WPBakeryShortCode { }
}
