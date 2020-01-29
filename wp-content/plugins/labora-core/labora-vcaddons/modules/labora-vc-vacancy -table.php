<?php
/*
* Add-on Name: vacancy for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Vacancys_Table' ) ) {
	class Labora_VC_Vacancys_Table {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_vacancy_table_init' ) );
			add_shortcode( 'labora_vacancy_table', array( $this, 'labora_vacancy_table_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'labora_vc_vacancy_script' ), 1 );
		}
		// intialize the  wp enqueue  scripts
		function labora_vc_vacancy_script() {
			wp_register_script( 'table-sorter', LABORA_VC_ADDON_URL . '/assets/js/jquery.tablesorter.min.js', false,false,'all' );
		}
		// initialize the mapping function
		function labora_vc_vacancy_table_init() {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
					   'name' 		 => esc_html__( 'Vacancys Table', 'labora-vc-textdomain' ),
					   'base' 		 => 'labora_vacancy_table',
					   'class'		 => '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	 => 'Labora VC Addons',
					   'description' => esc_html__( 'vacancy shortcode', 'labora-vc-textdomain' ),
					   'params' 	 => array(
						    array(
							   'type' 		  => 'textfield',
							   'holder' 	  => 'div',
							   'class'		  => '',
							   'heading'     => esc_html__( 'Count or Limit', 'labora-vc-textdomain' ),
							   'param_name'  => 'limit',
						 	   'description' => esc_html__( 'Type the number that display on the counter.', 'labora-vc-textdomain' ),
						    ),
							array(
								'type'       => 'colorpicker',
								'heading'    => esc_html__( 'Text Color', 'labora-vc-textdomain' ),
								'param_name' => 'txtcolor',
							),
						),
					)
				);
			}
		}
		function labora_vacancy_table_shortcode( $atts, $content = null, $code ) {
			extract( shortcode_atts( array(
				'css'	    => '',
				'limit'		=> '-1',
				'txtcolor'	=> '',
			), $atts ) );

			global $post, $paged, $wp_query;

			$out = '';

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			$css_class .= ' labora_vacancy_table_list';

			$args = array(
				'post_type'	=> 'vacancy',
				'showposts'	=> $limit,
				'paged'		=> $paged,
			);
			$original_query = $wp_query;

			// Query executes here;
			$vacancy_query = new WP_Query( $args );
			$wp_query = $vacancy_query;

			$vacancy_id = uniqid( 'labora_vacancy_' );
			$header_txt_color = $txtcolor ? 'color: ' . $txtcolor . ';':'';
			$styling 		  = ( $header_txt_color ) ? ' style="' . $header_txt_color . '"' : '' ;
			$heading_array = array(
				esc_html__( 'Job Posting Title','labora-vc-textdomain' ),
				esc_html__( 'Location','labora-vc-textdomain' ),
				esc_html__( 'Department','labora-vc-textdomain' ),
				esc_html__( 'Date','labora-vc-textdomain' ),
			);
			$out .= '<div class="at-vacancy-table-wrap ' . esc_attr( $css_class ) . '">';

			$out .= '<table id="at_' . $vacancy_id . '" class="at-vacancy-table tablesorter">';
			$out .= '<thead><tr>';
			foreach ( $heading_array as $key => $value ) {
				$out .= '<th class="header" ' . $styling . '>' . $value . '</th>';
			}
			$out .= '</tr></thead>';
			$out .= '<tbody>';

			if ( $vacancy_query->have_posts() ) :
				
				$out .= '<script>	
						jQuery(document).ready(function($){
							if($.isFunction($.fn.tablesorter)) {
								jQuery("#at_' . $vacancy_id . '").tablesorter({sortList: [[0,0]]} );
							}	
						});
						</script>';
				while ( $vacancy_query->have_posts() ) : $vacancy_query->the_post();

					$labora_department = get_post_meta( get_the_ID(), 'labora_department', true );
					$labora_location   = get_post_meta( get_the_ID(), 'labora_location', true );
					$labora_jobtype   = get_post_meta( get_the_ID(), 'labora_jobtype', true );

					$out .= '<tr><td><a href="' . get_permalink() . ' ">' . get_the_title() . '</a></td>';
					$out .= '<td>' . $labora_location . '</td>';
					$out .= '<td>' . $labora_department . '</td>';
					if ( $labora_jobtype != '' ) {
						$out .= '<td class="date"><span>' . $labora_jobtype . '</span>' . human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' ago</td></tr>';	# code...
					} else {
						$out .= '<td class="date">' . human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . esc_html__(' ago','labora-vc-textdomain' ) . '</td></tr>';
					}
				endwhile;
				else:	
					$out .= '<tr><td colspan="4">' . esc_html__('No Results Found','labora-vc-textdomain' ).'</td></tr>';
				endif;
				$out .= '</tr></tbody></table>';
				$out .= '</div>'; // vacancys-id
			wp_reset_query();
			$wp_query = $original_query;
			return $out;
		}
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Vacancys_Table' ) ) {
		$labora_vacancy_table = new Labora_VC_Vacancys_Table;
	}
	class WPBakeryShortCode_labora_vacancy_table extends WPBakeryShortCode {
	}
}
