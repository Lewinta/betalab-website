<?php
/*
* Add-on Name: gmap_address for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Gmap_Address' ) ) {
	class Labora_VC_Gmap_Address {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_gmap_address_init' ) );
			add_shortcode( 'labora_vc_gmap_address', array( $this, 'labora_vc_gmap_address_shortcode' ) );
		}

		// Initialize the mapping function
		function labora_vc_gmap_address_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(	array(
					'name'     => esc_html__( 'Address', 'labora-vc-textdomain' ),
					'base'     => 'labora_vc_gmap_address',
					'content_element' => true,
					'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					'as_child' => array( 'only' => 'labora_google_map' ),
					'category' => esc_html__( 'Labora VC Addons', 'labora-vc-textdomain' ),
					'params'   => array(
					array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Title', 'labora-vc-textdomain' ),
							'admin_label' => true,
							'param_name'  => 'title',
						),
					array(
							'type'       => 'textarea',
							'heading'    => esc_html__( 'Address', 'labora-vc-textdomain' ),
							'param_name' => 'address',
						),
					array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Phone', 'labora-vc-textdomain' ),
							'param_name' => 'phone',
						),
					array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Email', 'labora-vc-textdomain' ),
							'param_name' => 'email',
						),
					array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Latitude', 'labora-vc-textdomain' ),
							'param_name'  => 'lat',
							'description' => wp_kses( __( '<a href="http://www.latlong.net/convert-address-to-lat-long.html">Here is a tool</a> where you can find Latitude & Longitude of your location', 'labora-vc-textdomain' ), array( 'a' => array( 'href' => array() ) ) ),
						),
					array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Longitude', 'labora-vc-textdomain' ),
							'param_name'  => 'lng',
							'description' => wp_kses( __( '<a href="http://www.latlong.net/convert-address-to-lat-long.html">Here is a tool</a> where you can find Latitude & Longitude of your location', 'labora-vc-textdomain' ), array( 'a' => array( 'href' => array() ) ) ),
						),
					),
				) );
			}
		}

		function labora_vc_gmap_address_shortcode( $atts ) {
			extract(shortcode_atts( array(
				'title'	 => '',
				'lat' 	 => '',
				'lng'	 => '',
				'address' => '',
				'phone'	 => '',
				'email'	 => '',
			), $atts ) );

			$output = '';
			$output = '<div class="item" data-lat="' .$lat  . '" data-lang="' . $lng . '" data-title="' . $title  . '" data-address="' .  $address  . '">';

			$output .= '<div class="at_gmap_address">';
			if ( ! empty( $title ) ) {
				$output .= '<h4 class="gmap-address-title">' . esc_html( $title ) . '</h4>';
			}

			if ( ! empty( $address ) ) {
				$output .= '<p>';
				$output .= '<span class="gmap-icon"><i class="fa fa-map-marker fa-fw fa-lg"></i></span>';
				$output .= '<span class="details">';
				$output .= $address;
				$output .= '</span>';
				$output .= '</p>';
			}
			if ( ! empty( $phone ) ) {
				$output .= '<p>';
				$output .= '<span class="gmap-icon"><i class="fa fa-phone fa-fw fa-lg"></i></span>';
				$output .= '<span class="details">';
				$output .= esc_html( $phone );
				$output .= '</span>';
				$output .= '</p>';
			}
			if ( ! empty( $email ) ) {
				$output .= '<p>';
				$output .= '<span class="gmap-icon"><i class="fa fa-envelope-o fa-fw fa-lg"></i></span>';
				$output .= '<span class="details">';
				$output .= '<a href="mailto:' . antispambot( $email ) . '">' . antispambot( $email ) . '</a>';
				$output .= '</span>';
				$output .= '</p>';
			}
			$output .= '</div>'; //.at_gmap_address
			$output .= '</div>'; //.item
			return $output;
		} //.labora_vc_gmap_address_shortcode
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Gmap_Address' ) ) {
		$labora_vc_gmap_address = new Labora_VC_Gmap_Address;
	}

	class WPBakeryShortCode_labora_vc_gmap_address extends WPBakeryShortCode {
	}
}
