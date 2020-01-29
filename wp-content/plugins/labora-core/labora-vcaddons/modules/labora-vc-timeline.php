<?php
/*
* Add-on Name: timeline for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Timeline' ) ) {
	class Labora_VC_Timeline {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_timeline_init' ) );
			add_shortcode( 'labora_vc_timeline', array( $this, 'labora_vc_timeline_shortcode' ) );
		}

		// Initialize the mapping function
		function labora_vc_timeline_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map(	array(
					'name'     => esc_html__( 'Timeline Info', 'labora-vc-textdomain' ),
					'base'     => 'labora_vc_timeline',
					'content_element' => true,
					'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					'as_child' => array( 'only' => 'labora_timeline_history' ),
					'category' => esc_html__( 'Labora VC Addons', 'labora-vc-textdomain' ),
					'params'   => array(
					array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Year', 'labora-vc-textdomain' ),
							'param_name' => 'year',
					),
					array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Title', 'labora-vc-textdomain' ),
							'param_name' => 'title',
					),
					array(
							'type'       => 'textarea',
							'heading'    => esc_html__( 'Description', 'labora-vc-textdomain' ),
							'param_name' => 'description',
					),
					),
				) );
			}
		}

		function labora_vc_timeline_shortcode( $atts ) {
			extract(shortcode_atts( array(
				'title'	=> '',
				'year' 	=> '',
				'description' => '',
			), $atts ));

				$output = '';
				$output .= '<li>';
				$output .= '<div class="at-cmpny-sep"></div>';
				$output .= '<div class="at-cmpny-text">';
				$output .= '<div class="at-cmpny-year">' . esc_html( $year ) . '</div>';
				$output .= '<h4>' . esc_html( $title ) . '</h4>';
				$output .= '<p>' . wpb_js_remove_wpautop( $description, true ) . '</p>';
				$output .= '</div>'; //.labora-cmpy-text
				$output .= '</li>';

			return $output;
		} //.labora_vc_timeline_shortcode
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Timeline' ) ) {
		$labora_vc_timeline = new Labora_VC_Timeline;
	}

	class WPBakeryShortCode_labora_vc_timeline extends WPBakeryShortCode {
	}
}
