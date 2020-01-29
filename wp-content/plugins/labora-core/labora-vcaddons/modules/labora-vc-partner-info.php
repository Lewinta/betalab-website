<?php
/*
* Add-on Name: labora_partner_info for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Partner_Info' ) ) {
	class Labora_VC_partner_info {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_partner_info_init' ) );
			add_shortcode( 'labora_partner_info', array( $this, 'labora_vc_partner_info_shortcode' ) );
		}

		// Initialize the mapping function
		function labora_vc_partner_info_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map(	array(
					'name'                    => esc_html__( 'Partner Info', 'labora-vc-textdomain' ),
					'base'                    => 'labora_partner_info',
					'as_parent'               => array( 'only' => 'labora_our_partner' ),
					'content_element'		  => true,
					'show_settings_on_create' => false,
					'icon' 					  => LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					'category'                => esc_html__( 'Labora VC Addons', 'labora-vc-textdomain' ),
					'params'                  => array(
					array(
								'type'       => 'textfield',
								'heading'    => esc_html__( 'Title', 'labora-vc-textdomain' ),
								'param_name' => 'title',
						),
					array(
								'type'       => 'css_editor',
								'heading'    => esc_html__( 'Css', 'labora-vc-textdomain' ),
								'param_name' => 'css',
								'group'      => esc_html__( 'Design options', 'labora-vc-textdomain' ),
					),
					),
					'js_view' => 'VcColumnView',
					)
				);
			}
		}

		function labora_vc_partner_info_shortcode( $atts, $content ) {
			extract(shortcode_atts( array(
				'css'	=> '',
			), $atts ) );

			$output = '';
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			if ( ! empty( $content ) ) {
				$output .= wpb_js_remove_wpautop( $content );
			}

			return $output;
		} //.labora_vc_partner_info_shortcode
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_partner_info' ) ) {
		$labora_vc_partner_info = new Labora_VC_partner_info;
	}
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_labora_partner_info extends WPBakeryShortCodesContainer {
		}
	}
}
