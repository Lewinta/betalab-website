<?php
/*
* Add-on Name: Testimonial for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Testimonial' ) ) {
	class Labora_VC_Testimonial {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_testimonial_init' ) );
			add_shortcode( 'labora_testimonial', array( $this, 'labora_vc_testimonial_shortcode' ) );
		}
		// initialize the mapping function
		function labora_vc_testimonial_init() {
			if ( function_exists( 'vc_map' ) ) {
				$labora_cat_options = array();
				if ( $labora_testimonials = true ) {
					$labora_ttm_cat = get_terms( 'testimonial_cat', 'orderby=name&hide_empty=1' );
					if ( ! empty( $labora_ttm_cat ) && ! is_wp_error( $labora_ttm_cat ) ) {
						foreach ( $labora_ttm_cat as $category ) {
							$labora_cat_options[ $category->slug ] = $category->name;
						}
					}
				}
				vc_map(
					array(
					   'name' 		 => esc_html__( 'Testimonial', 'labora-vc-textdomain' ),
					   'base' 		 => 'labora_testimonial',
					   'class'		 => '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	 => 'Labora VC Addons',
					   'description' => esc_html__( 'Testimonial shortcode', 'labora-vc-textdomain' ),
					   'params' 	 => array(
					   		array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'Choose Style', 'labora-vc-textdomain' ),
								'param_name' 	=> 'style',
								'value' 	 	=> array(
														'Choose one...'	=> '',
														'Style 1'		=> 'style1',
														'Style 2' 		=> 'style2',
														'Style 3' 		=> 'style3',
													),
								'description' 	=> esc_html__( 'Choose the Style for Testimonial.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 			=> 'checkbox',
								'heading'  	 	=> esc_html__( 'Categories', 'labora-vc-textdomain' ),
								'param_name' 	=> 'cat',
								'value' 	 	=> $labora_cat_options,
								'description' 	=> esc_html__( 'Select the Testimonial Categories.','labora-vc-textdomain' ),
							),
					   		array(
								'type' 		  => 'textfield',
								'holder' 	  => 'div',
								'class'		  => '',
								'heading'     => esc_html__( 'Count or Limit', 'labora-vc-textdomain' ),
								'param_name'  => 'limit',
								'description' => esc_html__( 'Type the number that display on the counter.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'checkbox',
								'heading' 	  => esc_html__( 'Pagination', 'labora-vc-textdomain' ),
								'param_name'  => 'pagination',
								'description' => esc_html__( 'Check this if you wish to enable the pagination for testimonials. ( Default: disable )', 'labora-vc-textdomain' ),
								'value'		  => array( esc_html__( 'Yes', 'labora-vc-textdomain' ) => 'yes' ),
							),
						),
					)
				);
			}
		}

		function labora_vc_testimonial_shortcode( $atts, $content = null, $code ) {
			extract( shortcode_atts( array(
				'limit'		=> '-1',
				'style'   	=> 'style1',
				'cat'    	=> '',
				'pagination' => '',
			), $atts ) );

			global $post, $paged, $wp_query;

			$rand = rand( 10,100 );
			$testimonial_gravatar_image = $out = $before = $after = $out = '';

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$args = array(
				'post_type'	=> 'testimonialtype',
				'showposts'	=> $limit,
				'tax_query' => array(
					'relation' => 'OR',
				),
				'paged'		=> $paged,
			);

			if ( '' != $cat ) {
				$cats = explode( ',',$cat );
					$tax_cat = array(
						'taxonomy' 		=> 'testimonial_cat',
						'field' 		=> 'slug',
						'terms' 		=> $cats,
					);
					array_push( $args['tax_query'],$tax_cat );
			}
			$original_query = $wp_query;

			// Query executes here;
			$testomonials_query = new WP_Query( $args );
			$wp_query = $testomonials_query;

			if ( $testomonials_query->have_posts() ) :
				$out .= '<div class="at-testimonial-warp clearfix">';

				while ( $testomonials_query->have_posts() ) : $testomonials_query->the_post();
					$tm_last_class = $before = $after = $testimonial_gravatar_image = '';
					$company_name			= get_post_meta( get_the_ID(), 'labora_company_name', true );
					$website_name			= get_post_meta( get_the_ID(), 'labora_website_name', true );
					$website_url			= get_post_meta( get_the_ID(), 'labora_website_url', true );
					$testimonial_content	= get_the_excerpt( get_the_ID() );
					$testimonial_email 		= get_post_meta( get_the_ID(),'labora_testimonial_email',true );
					if ( '' != $website_url ) {
						$before = ' - <a href="' . esc_url( $website_url ) . '" target="_blank">';
						$after = '</a>';
					}

					// Style 1 && style2
					if ( $style == 'style1' || $style == 'style2' ) {
						if ( isset( $testimonial_email ) && '' != $testimonial_email ) {
							$testimonial_gravatar_image = get_avatar( $testimonial_email, 90 );
						} elseif ( has_post_thumbnail() ) {
							$testimonial_gravatar_image = labora_sc_resize( $post->ID, '','90', '90', '', '' );
						}
						$out .= '<div class="at-testimonial-item ' . $style . '">';
						if ( '' != $testimonial_content ) {
							$out .= '<div class="at-testimonial-blockquote">' . $testimonial_content . '</div>';
						}
						$out .= '<div class="at-testimonial-author">';
						if ( '' != $testimonial_gravatar_image ) {
							$out .= $testimonial_gravatar_image;
						}
						$clientname = get_the_title() ;
						$out .= '<h5>' . $clientname . '</h5>';
						$out .= '<span>' . $company_name . ', ' .  $website_name . '</span>';
						$out .= '</div>';
						$out .= '</div>';//at-testimonial-item
					}
					if ( $style == 'style3' ) {
						if ( isset( $testimonial_email ) && '' != $testimonial_email ) {
							$testimonial_gravatar_image = get_avatar( $testimonial_email, 200 );
						} elseif ( has_post_thumbnail() ) {
							$testimonial_gravatar_image = labora_sc_resize( $post->ID, '','350', '250', '', '' );
						}
						$out .= '<div class="at-testimonial-item ' . $style . '">';
						$out .= '<div class="at-testimonial-image">';
						if ( '' != $testimonial_gravatar_image ) {
							$out .= $testimonial_gravatar_image;
						}
						$out .= '</div>';
						$out .= '<div class="at-testimonial-blockquote">';
						$clientname = get_the_title();
						$out .= '<h5>' . $clientname . '</h5>';
						$out .= '<span class="at-testimonial-cmpy">' . $company_name . '</span>';
						$out .= '<span class="at-testimonial-site">' . $website_name . '</span>';
						$out .= '<p>' . $testimonial_content . '</p>';
						$out .= '</div>';
						$out .= '</div>';//at-testimonial-item
					}
				endwhile;
				if ( $pagination == 'yes' ) {
					if ( function_exists( 'labora_pagination' ) ) {
						ob_start();
						$out .= labora_pagination();
						$out .= ob_get_contents();
						ob_end_clean();
					}
				}
				endif;
			wp_reset_query();
			$wp_query = $original_query;
			return $out;
		}
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Testimonial' ) ) {
		$labora_vc_testimonial = new Labora_VC_Testimonial;
	}
	class WPBakeryShortCode_labora_vc_testimonial extends WPBakeryShortCode {
	}
}
