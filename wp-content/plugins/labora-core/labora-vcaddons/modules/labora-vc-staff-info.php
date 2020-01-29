<?php
/*
* Add-on Name: Direction for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Staff_Info' ) ) {
	class Labora_VC_Staff_Info {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_staff_info_init' ) );
			add_shortcode( 'labora_vc_staff_info', array( $this, 'labora_vc_staff_info_shortcode' ) );
		}

		// intialize the wp enqueue scripts
		function labora_vc_staff_info_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
					   'name' 		=> esc_html__( 'Staff Info', 'labora-vc-textdomain' ),
					   'base' 		=> 'labora_vc_staff_info',
					   'class' 		=> '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	=> 'Labora VC Addons',
					   'description' => esc_html__( 'Location', 'labora-vc-textdomain' ),
					   'params' 	=> array(
							array(
								'type' 		  => 'css_editor',
								'heading'     => esc_html__( 'css', 'labora-vc-textdomain' ),
								'param_name'  => 'css',
							),
						),
					)
				);
			}
		}
		function labora_vc_staff_info_shortcode( $atts ) {
			extract( shortcode_atts( array(
				'css'	    => '',
			), $atts ) );

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			$out = '';
			$labora_department = get_post_meta( get_the_ID(), 'labora_department', true );
			$labora_address    = get_post_meta( get_the_ID(), 'labora_address', true );
			$labora_phone      = get_post_meta( get_the_ID(), 'labora_phone', true );
			$labora_email      = get_post_meta( get_the_ID(), 'labora_email', true );
			$labora_sociable   = get_post_meta( get_the_ID(), 'labora_sociable', true );
			$labora_education   = get_post_meta( get_the_ID(), 'labora_education', true );

			$out .= '<div class="at-staff-wapper' . esc_attr( $css_class ) . '">';
			$out .= '<div class="at-staff-info">';
			$out .= '<div class="info">';
			if ( $labora_phone ) {
				$out .= '<div class="phone"><i class="fa fa-phone"></i><span>' . $labora_phone . '</span></div>';
			}
			if ( $labora_email ) {
				$out .= '<div class="email"><i class="fa fa-envelope"></i><span><a href="mailto:' . $labora_email . '">' . $labora_email . '</a></span></div>';
			}
			if ( $labora_address ) {
				$out .= '<div class="address"><i class="fa fa-map-marker"></i>';
				$out .= '<span>' . stripslashes( nl2br( $labora_address ) ) . '</span>';
				$out .= '</div>';
			}
			$out .= '</div>';
			$out .= '<div class="info">';
			if ( $labora_education ) {
				$out .= '<div class="edu"><i class="fa fa-university"></i><span>' . $labora_education . '</span></div>';
			}
			if ( function_exists( 'labora_social_icon' ) ) {
				$out .= '<div class="social">';
				$out .= labora_social_icon( $labora_sociable );
				$out .= '</div>'; // Sociables end
			}
			$out .= '</div>';
			$out .= '</div>';
			$out .= '</div>';
			return $out;
		}
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Staff_Info' ) ) {
		$labora_vc_staff = new Labora_VC_Staff_Info;
	}

	class WPBakeryShortCode_labora_vc_staff_info extends WPBakeryShortCode {
	}
}
