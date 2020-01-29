<?php
/*
* Add-on Name: at_timeline_history for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Timeline_History' ) ) {
	class Labora_VC_Timeline_History {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_timeline_history_init' ) );
			add_shortcode( 'labora_timeline_history', array( $this, 'labora_vc_timeline_history_shortcode' ) );
		}

		// Initialize the mapping function
		function labora_vc_timeline_history_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map(	array(
					'name'                    => esc_html__( 'Timeline History', 'labora-vc-textdomain' ),
					'base'                    => 'labora_timeline_history',
					'as_parent'               => array( 'only' => 'labora_vc_timeline' ),
					'content_element'		  => true,
					'show_settings_on_create' => false,
					'icon' 					  => LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					'category'                => esc_html__( 'Labora VC Addons', 'labora-vc-textdomain' ),
					'params'                  => array(
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

		function labora_vc_timeline_history_shortcode( $atts, $content ) {
			extract(shortcode_atts( array(
				'css'	=> '',
			), $atts ));
				$output = '';
				$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
				$output .= '<div class="at-history-wrap' . esc_attr( $css_class ) . '">';
			if ( ! empty( $content ) ) {
					$output .= '<div class="at-history"><ul>';
					$output .= wpb_js_remove_wpautop( $content );
					$output .= '</ul></div>'; //.at-history
			}
				$output .= '</div>';

				return $output;
		} //.labora_vc_timeline_history_shortcode
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Timeline_History' ) ) {
		$labora_vc_timeline_history = new Labora_VC_Timeline_History;
	}
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_labora_timeline_history extends WPBakeryShortCodesContainer {
		}
	}
}
