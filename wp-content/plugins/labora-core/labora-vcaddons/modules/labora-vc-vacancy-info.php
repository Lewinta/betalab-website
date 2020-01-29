<?php
/*
* Add-on Name: vacancyinfo for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Vacancy_Info' ) ) {
	class Labora_VC_Vacancy_Info {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_vacancy_info_init' ) );
			add_shortcode( 'labora_vc_vacancy_info', array( $this, 'labora_vc_vacancy_info_shortcode' ) );
		}

		// Initialize the mapping function
		function labora_vc_vacancy_info_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map(	array(
					'name'			=> esc_html__( 'Vacancy Info', 'labora-vc-textdomain' ),
					'description'	=> esc_html__( 'Labora VC Addons', 'labora-vc-textdomain' ),
					'base'			=> 'labora_vc_vacancy_info',
					'icon'			=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					'category'		=> esc_html__( 'Labora VC Addons', 'labora-vc-textdomain' ),
					'params'		=> array(
					array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Title', 'labora-vc-textdomain' ),
							'param_name' => 'title',
					),
					array(
						   'type' 			=> 'colorpicker',
						   'holder' 	  => 'div',
						   'class' 			=> '',
						   'heading' 		=> esc_html__( 'Text color', 'labora-vc-textdomain' ),
						   'param_name' 	=> 'txt_color',
						   'value' 			=> '', //Default Red color
						   'group' 			=> esc_html__( 'Design', 'labora-vc-textdomain' ),
						   'description' 	=> esc_html__( 'Choose the color you want to display for the text', 'labora-vc-textdomain' ),
						),
					array(
							'type' 		  => 'css_editor',
							'heading'     => esc_html__( 'css', 'labora-vc-textdomain' ),
							'param_name'  => 'css',
							'group' 	  => esc_html__( 'Design', 'labora-vc-textdomain' ),
					),
					),
				) );
			}
		}

		function labora_vc_vacancy_info_shortcode( $atts ) {
			extract( shortcode_atts( array(
				'title'		=> '',
				'css' 		=> '',
				'txt_color'	=> '',
			), $atts ) );

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

			$output = $vacancy_style = '';

			if ( $txt_color ) { $vacancy_style = 'style=color:' . $txt_color . '; '; }

			$labora_department 	= get_post_meta( get_the_ID(), 'labora_department', true );
			$labora_location 	  	= get_post_meta( get_the_ID(), 'labora_location', true );
			$labora_education 		= get_post_meta( get_the_ID(), 'labora_education', true );
			$labora_salary 		= get_post_meta( get_the_ID(), 'labora_salary', true );
			$labora_jobtype 		= get_post_meta( get_the_ID(), 'labora_jobtype', true );

			if ( $css_class != '' ) {
				$output .= '<div class="' . esc_attr( $css_class ) . '">';
			}
			$output .= '<div class="vacancy_info" ' . $vacancy_style . '>';

			// Department
			if ( ! empty( $labora_department ) ) {
				$output .= '<div class="info">';
				$output .= '<div class="icon"><i class="fa fa-folder fa-fw"></i></div>';
				$output .= '<div class="text">' . esc_html__( 'Department:','labora-vc-textdomain' ) . '<strong>' . $labora_department . '</strong>';
				$output .= '</div>'; //.text
				$output .= '</div>'; //.info
			}
			// Location
			if ( ! empty( $labora_location ) ) {
				$output .= '<div class="info">';
				$output .= '<div class="icon"><i class="fa fa-map-marker fa-fw"></i></div>';
				$output .= '<div class="text">' . esc_html__( 'Project Location(s):', 'labora-vc-textdomain' ) . '<strong>' . $labora_location . '</strong>';
				$output .= '</div>'; //.text
				$output .= '</div>'; //.info
			}
			// Education
			if ( ! empty( $labora_education ) ) {
				$output .= '<div class="info">';
				$output .= '<div class="icon"><i class="fa fa-graduation-cap fa-fw"></i></div>';
				$output .= '<div class="text">' . esc_html__( 'Education:', 'labora-vc-textdomain' ) . '<strong>' . $labora_education . '</strong>';
				$output .= '</div>'; //.text
				$output .= '</div>'; //.info
			}
			// Salary
			if ( ! empty( $labora_salary ) ) {
				$output .= '<div class="info">';
				$output .= '<div class="icon"><i class="fa fa-credit-card fa-fw"></i></div>';
				$output .= '<div class="text">' . esc_html__( 'Salary:', 'labora-vc-textdomain' ) . '<strong>' . $labora_salary . '</strong>';
				$output .= '</div>'; //.text
				$output .= '</div>'; //.info
			}
			// Job type
			if ( ! empty( $labora_jobtype ) ) {			
				$output .= '<div class="info">';
				$output .= '<div class="icon"><i class="fa fa-briefcase fa-fw"></i></div>';
				$output .= '<div class="text">' . esc_html__( 'Job Type:', 'labora-vc-textdomain' ) . '<strong>' . $labora_jobtype . '</strong>';
				$output .= '</div>'; //.text
				$output .= '</div>'; //.info
			}
			$output .= '</div>'; //.vacancy_info
			if ( $css_class != '' ) { $output .= '</div>';	}

			return $output;
		} //.labora_vc_vacancyinfo_shortcode
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Vacancy_Info' ) ) {
		$labora_vc_vacancy_info = new Labora_VC_Vacancy_Info;
	}

	class WPBakeryShortCode_labora_vc_vacancy_info extends WPBakeryShortCode {
	}
}
