<?php
/*
* Add-on Name: labora_our_partner for Visual Composer
*/
if ( ! class_exists( 'Labora_Our_Partner' ) ) {
	class Labora_Our_Partner {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_our_partner_init' ) );
			add_shortcode( 'labora_our_partner', array( $this, 'labora_our_partner_shortcode' ) );
		}

		// Initialize the mapping function
		function labora_our_partner_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map(	array(
					'name'     => esc_html__( 'Our Partner', 'labora-vc-textdomain' ),
					'base'     => 'labora_our_partner',
					'content_element' => true,
					'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					'as_child' => array( 'only' => 'labora_partner_info' ),
					'category' => esc_html__( 'Labora VC Addons', 'labora-vc-textdomain' ),
					'params'   => array(
					array(
							'type' 			=> 'dropdown',
							'heading'  	 	=> esc_html__( 'Choose Style', 'labora-vc-textdomain' ),
							'param_name' 	=> 'display_style',
							'value' 	 	=> array(
													'Choose one...'	=> '',
													'Style1' => 'style1',
													'Style2' => 'style2',
												),
							'description' 	=> esc_html__( 'Choose Style for view ', 'labora-vc-textdomain' ),
					),
					array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Title', 'labora-vc-textdomain' ),
							'param_name' => 'title',
					),
					array(
							'type'       => 'textarea',
							'heading'    => esc_html__( 'Sub Title', 'labora-vc-textdomain' ),
							'param_name' => 'sub_title',
					),
					array(
							'type'       => 'textarea',
							'heading'    => esc_html__( 'Description', 'labora-vc-textdomain' ),
							'param_name' => 'description',
					),
					array(
							'type' 		  => 'attach_image',
							'holder' 	  => 'div',
							'class'		  => '',
							'heading'     => esc_html__( 'Logo', 'labora-vc-textdomain' ),
							'param_name'  => 'image',
							'description' => esc_html__( 'Upload Image you want to display for the partner.', 'labora-vc-textdomain' ),
					),
					array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Image Size', 'labora-vc-textdomain' ),
							'param_name'  => 'image_size',
							'description' => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "default" size.', 'labora-vc-textdomain' ),
					),
					array(
							'type'       => 'vc_link',
							'heading'    => esc_html__( 'Link', 'labora-vc-textdomain' ),
							'param_name' => 'link',
					),
					array(
							'type'       => 'checkbox',
							'param_name' => 'disable_image',
							'value'      => array(
								esc_html__( 'Disable Image', 'labora-vc-textdomain' ) => 'disable',
							),
						),
					array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'labora-vc-textdomain' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'labora-vc-textdomain' ),
						),
					),
				) );
			}
		}

		function labora_our_partner_shortcode( $atts ) {
			extract(shortcode_atts( array(
				'title'		 	=> '',
				'sub_title'  	=> '',
				'description'	=> '',
				'image'			=> '',
				'image_size' 	=> '',
				'disable_image' => '',
				'link' 			=> '',
				'display_style' => '',
				'css'	=> '',
			), $atts ) );

			$output = $image_output_src = '';
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			$link = vc_build_link( $link );

			$output .= '<div class="at-partner ' . $display_style . ' ' . $css_class . '">';
			if ( ! empty( $image ) ) {
				if ( ! $image_size ) {
					$image_size = 'labora-image-350x200-croped';
				}
				if ( function_exists( 'wpb_getImageBySize' ) ) {
					$partner_thumbnail = wpb_getImageBySize( array(
						'attach_id'  => $image,
						'thumb_size' => $image_size,
					) );
					$partner_thumbnail = $partner_thumbnail['thumbnail'];
					if ( $disable_image != 'disable' ) {
						$output .= '<div class="at-partner-image">';
						$output .= $partner_thumbnail;
						$output .= '</div>';
					}
				}
			}
			$output .= '<div class="at-partner-content">';
			$output .= '<h4><a target="' . esc_attr( $link['target'] ) . '" href="' . esc_url( $link['url'] ) . '">' . esc_html( $title ) . '</a></h4>';
			if ( $sub_title != 'style1' ) {
				$output .= '<h6 class="sub-title">' . $sub_title . '</h6>';
			}
			$output .= '<div class="desc">' . wpb_js_remove_wpautop( $description, true ) . '</div>';
			if (  $display_style != 'stye2' ) {
				if ( ! empty( $link['url'] ) ) {
					if ( ! $link['target'] ) {
						$link['target'] = '_self';
					}
					if ( ! $link['title'] ) {
						$link['title'] = esc_html__( 'visit website', 'labora-vc-textdomain' );
					}
					$output .= '<a class="read_more" target="' . esc_attr( $link['target'] ) . '" href="' . esc_url( $link['url'] ) . '">';
					$output .= '<span>' . esc_html( $link['title'] ) . '</span>';
					$output .= '</a>';
				}
			}
			$output .= '</div>';
			$output .= '</div>';// partner-content

			return $output;
		} //.labora_our_partner_shortcode
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_Our_Partner' ) ) {
		$labora_our_partner = new Labora_Our_Partner;
	}

	class WPBakeryShortCode_labora_our_partner extends WPBakeryShortCode {
	}
}
