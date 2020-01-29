<?php
/*
* Add-on Name: ticket for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Partial_Section' ) ) {
	class Labora_VC_Partial_Section {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_partial_section_init' ) );
			add_shortcode( 'labora_partial_section', array( $this, 'labora_vc_partial_section_shortcode' ) );
		}
		// initialize the mapping function
		function labora_vc_partial_section_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
					   'name' 		 => esc_html__( 'Partial Section', 'labora-vc-textdomain' ),
					   'base' 		 => 'labora_partial_section',
					   'class'		 => '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	 => 'Labora VC Addons',
					   'description' => esc_html__( 'partial section shortcode', 'labora-vc-textdomain' ),
					   'params' 	 => array(
							array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'Choose Layout', 'labora-vc-textdomain' ),
								'param_name' 	=> 'ps_align',
								'value' 	 	=> array(
														'Choose one...'	=> '',
														'Content Left'	=> 'left',
														'Content Right' => 'right',
													),
								'description' 	=> esc_html__( 'Choose the alignment  for partial section', 'labora-vc-textdomain' ),
							),
							 array(
								'type' 			=> 'colorpicker',
								'class' 		=> '',
								'heading' 		=> esc_html__( 'Background color', 'labora-vc-textdomain' ),
								'param_name' 	=> 'ps_bgcolor',
								'value' 		=> '', //Default Red color
								'description' 	=> esc_html__( 'Choose the color you want to display for the Section background', 'labora-vc-textdomain' ),
							 ),
							array(
								'type' 		  	=> 'attach_image',
								'holder' 	  	=> 'div',
								'class'		  	=> '',
								'heading'     	=> esc_html__( 'Background Image', 'labora-vc-textdomain' ),
								'param_name'  	=> 'ps_image',
								'description' 	=> esc_html__( 'Upload Image you want to display for the Section background.', 'labora-vc-textdomain' ),
							),
							 array(
								'type' 			=> 'colorpicker',
								'class' 		=> '',
								'heading' 		=> esc_html__( 'Image Overlay Color', 'labora-vc-textdomain' ),
								'param_name' 	=> 'ps_bg_overlay_color',
								'value' 		=> '', //Default Red color
								'description' 	=> esc_html__( 'Choose the color you want to display for the text.', 'labora-vc-textdomain' ),
							 ),
							 array(
								'type' 			=> 'colorpicker',
								'class' 		=> '',
								'heading' 		=> esc_html__( 'Text color', 'labora-vc-textdomain' ),
								'param_name' 	=> 'ps_content_text_color',
								'value' 		=> '', //Default Red color
								'description' 	=> esc_html__( 'Choose the color you want to display for the text.', 'labora-vc-textdomain' ),
							 ),
							 array(
								'type' 			=> 'textarea',
								'holder' 		=> 'div',
								'class' 		=> '',
								'heading' 		=> esc_html__( 'Content', 'labora-vc-textdomain' ),
								'param_name' 	=> 'content',
								'value' 		=> '',
								'description' 	=> esc_html__( 'Enter Content to display on partial section.', 'labora-vc-textdomain' ),
							),
						),
					)
				);
			}
		}

		function labora_vc_partial_section_shortcode( $atts, $content = null, $code ) {
			extract( shortcode_atts( array(
				'ps_align'				=> 'left',
				'ps_image'   			=> '',
				'ps_bgcolor'    		=> '',
				'ps_bg_overlay_color'   => '',
				'ps_content_text_color' => '',
			), $atts ) );

			$out = $ps_bg_image = '';
			$ps_bgcolor = $ps_bgcolor ? 'background-color:' . $ps_bgcolor . ';':'';
			$ps_content_text_color = $ps_content_text_color ? 'color:' . $ps_content_text_color . ';':'';

			if ( $ps_image != '' ) {
				$ps_image = wp_get_attachment_url( $ps_image );
			}

			if ( $ps_image ) {
				$ps_bg_image .= 'background: url(' . $ps_image . ') 50% 0%;';
			}
			$ps_image_properties = ' style="' . $ps_bg_image . '"   ';

			// Partial Section Image Overlay Color
			if ( ! empty( $ps_bg_overlay_color ) ) {
				$ps_bg_overlay_color = ' style="background-color:' . $ps_bg_overlay_color . '"   ';
			} else {
				$ps_bg_overlay_color = '';
			}

			// Partial Section Background Color
			if ( ! empty( $ps_bgcolor ) ) {
				$ps_bgcolor_css = ' style="' . $ps_bgcolor . '"   ';
			} else {
				$ps_bgcolor_css = '';
			}

			// Content Text Color
			if ( ! empty( $ps_content_text_color ) ) {
				$ps_content_properties = ' style="' . $ps_content_text_color . '"   ';
			} else {
				$ps_content_properties = '';
			}

			switch ( $ps_align ) {
				case 'right':
							$out .= '<div class="partial_section_wrap" ' . $ps_bgcolor_css . '>';
							// Image
							$out .= '<div class="partial_section_image one_half nomargin" ' . $ps_image_properties . '>';
							$out .= '<div class="partial_img_overlay" ' . $ps_bg_overlay_color . '></div>';
							$out .= '</div>';
							// Content
							$out .= '<div class="partial-inner">';
							$out .= '<div class="one_half nomargin"></div>';
							$out .= '<div class="partial-content-wrap one_half nomargin verticle-middle" ' . $ps_content_properties . '>';
							$out .= '<div class="partial-content-inner">';
							$out .= do_shortcode( trim( $content ) );
							$out .= '</div>'; //.ps_right_inner
							$out .= '</div>'; //. partial_section_right
							$out .= '</div>';
							$out .= '</div>';
							break;
				case 'left':
							$out .= '<div class="partial_section_wrap" ' . $ps_bgcolor_css . '>';
							// Content
							$out .= '<div class="partial-inner">';
							$out .= '<div class="one_half nomargin"></div>';
							$out .= '<div class="partial-content-wrap one_half nomargin verticle-middle" ' . $ps_content_properties . '>';
							$out .= '<div class="partial-content-inner">';
							$out .= do_shortcode( trim( $content ) );
							$out .= '</div>'; //.ps_right_inner
							$out .= '</div>'; //. partial_section_right
							$out .= '</div>';
							// Image
							$out .= '<div class="partial_section_image one_half nomargin" ' . $ps_image_properties . '>';
							$out .= '<div class="partial_img_overlay" ' . $ps_bg_overlay_color . '></div>';
							$out .= '</div>';
							$out .= '</div>';
							break;
			}
			return $out;
		}
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Partial_Section' ) ) {
		$labora_vc_partial_section = new Labora_VC_Partial_Section;
	}
	class WPBakeryShortCode_labora_vc_partial_section extends WPBakeryShortCode {
	}
}
