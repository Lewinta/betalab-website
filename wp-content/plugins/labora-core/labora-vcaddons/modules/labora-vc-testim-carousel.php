<?php
/*
* Add-on Name: Testimonial Carousel for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Testimonial_Carousel' ) ) {
	class Labora_VC_Testimonial_Carousel {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_testimonial_carousel_init' ) );
			add_shortcode( 'labora_testimonial_carousel', array( $this, 'labora_vc_testimonial_carousel_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'labora_vc_testim_script' ), 1 );
		}
		function labora_vc_testim_script() {
			wp_register_script( 'labora-owl-carousel', LABORA_VC_ADDON_URL . 'assets/js/owl.carousel.js','jquery','','in_footer' );
			wp_enqueue_style( 'labora-owl-style', LABORA_VC_ADDON_URL . 'assets/css/owl.carousel.css', false, false, 'all' );
			wp_enqueue_style( 'labora-owl-theme', LABORA_VC_ADDON_URL . 'assets/css/owl.theme.css', false, false, 'all' );
		}
		// initialize the mapping function
		function labora_vc_testimonial_carousel_init() {
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
					   'name' 		 => esc_html__( 'Testimonial Carousel', 'labora-vc-textdomain' ),
					   'base' 		 => 'labora_testimonial_carousel',
					   'class'		 => '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	 => 'Labora VC Addons',
					   'description' => esc_html__( 'Testimonial Carousel shortcode', 'labora-vc-textdomain' ),
					   'params' 	 => array(
					   		array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'Choose Style', 'labora-vc-textdomain' ),
								'param_name' 	=> 'style',
								'value' 	 	=> array(
														'Choose one...'	=> '',
														'Style 1'		=> 'style1',
														'Style 2' 		=> 'style2',
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
								'type' 			=> 'textfield',
								'heading'  	 	=> esc_html__( 'Photo Size', 'labora-vc-textdomain' ),
								'param_name' 	=> 'photo_size',
								'description'	=> esc_html__( 'Choose Photo Size for Testimonial eg( 150X150).', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Testimonial Per Row', 'labora-vc-textdomain' ),
								'param_name'  => 'itemslimit',
								'value' 	 	=> array(
														'Choose one...'	=> '',
														'Style 1'		=> 'style1',
														'Style 2' 		=> 'style2',
													),
								'description' => esc_html__( 'Enter number of testimonials to display per row.', 'labora-vc-textdomain' ),
							 ),
							array(
								'type' 		  => 'checkbox',
								'heading' 	  => esc_html__( 'Hide Arrows', 'labora-vc-textdomain' ),
								'param_name'  => 'hide_arrows',
								'value'		  => array( esc_html__( 'Yes', 'labora-vc-textdomain' ) => 'yes' ),
								'description' => esc_html__( 'Check this if you wish to hide the Arrows', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'checkbox',
								'heading' 	  => esc_html__( 'Pagination', 'labora-vc-textdomain' ),
								'param_name'  => 'pagination',
								'value'		  => array( esc_html__( 'Yes', 'labora-vc-textdomain' ) => 'yes' ),
								'description' => esc_html__( 'Check this if you wish to disable the pagination', 'labora-vc-textdomain' ),
							),
							array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'Choose Navigation Type', 'labora-vc-textdomain' ),
								'param_name' 	=> 'navigation_type',
								'value' 	 	=> array(
														esc_html__( 'Choose one...', 'labora-vc-textdomain' )	=> '',
														esc_html__( 'Arrows', 'labora-vc-textdomain' ) => 'arrows',
														esc_html__( 'Bullets', 'labora-vc-textdomain' ) => 'bullets',
													),
								'description' 	=> esc_html__( 'Choose Navigation Type for Testimonial.', 'labora-vc-textdomain' ),
							),
						),
					)
				);
			}
		}

		function labora_vc_testimonial_carousel_shortcode( $atts, $content = null, $code ) {
			extract( shortcode_atts( array(
				'limit'				=> '-1',
				'style'   			=> 'style1',
				'cat'    			=> '',
				'photo_size'		=> '',
				'itemslimit' 		=> '3',
				'hide_arrows'		=> '',
				'pagination'		=> '',
				'navigation_type'   => 'arrows',
			), $atts ) );

			global $post,$paged;

			$rand = rand( 10,100 );
			$testimonial_gravatar_image = $out = $before = $after = $out = '';

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}
			$c_pagination = $c_navigation = '';

			if ( $pagination == 'yes' ) {
				$c_pagination = 'pagination :false,';
			} elseif ( $navigation_type == 'bullets' ) {
				$c_pagination = 'pagination :true,';
				$c_navigation = 'navigation :false,';
			}

			if ( $hide_arrows == 'yes' ) {
				$c_navigation = 'navigation :false,';
			} elseif ( $navigation_type == 'arrows' ) {
				$c_navigation = 'navigation :true,';
				$c_pagination = 'pagination :false,';
			}

			$query = array(
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
				array_push( $query['tax_query'],$tax_cat );
			}
			// Query executes here;
			$testimonials_query = new WP_Query( $query );

			// Style 'carousel'
			$owl_carousel_id = rand( 10,99 );
			$out .= '<script>
			jQuery(document).ready(function($) {
				$("#testim-owl-' . $owl_carousel_id . '").owlCarousel({
					autoPlay: 500000, //Set AutoPlay to 3 seconds
					items : ' . $itemslimit . ',
					autoHeight : true,
					' . $c_navigation . '
					navigationText: ["<i class=\'fa fa-angle-up fa-2x fa-fw\'></i>","<i class=\'fa fa-angle-down fa-2x fa-fw\'></i>"],
					' . $c_pagination . '
					// theme : "labora-testim-owl-theme",
					itemsDesktop : [1199,1],
					itemsDesktopSmall : [1024,1],
					itemsTablet : [768,1],
					itemsMobile : [479,1]
				});
			});
			</script>';

			$out .= '<div id="testim-owl-' . $owl_carousel_id . '" class="owl-carousel">';

			if ( $testimonials_query->have_posts() ) :	while ( $testimonials_query->have_posts() ) : $testimonials_query->the_post();
					$tm_last_class = $before = $after = $testimonial_gravatar_image = '';
					$company_name			= get_post_meta( get_the_ID(), 'labora_company_name', true );
					$website_name			= get_post_meta( get_the_ID(), 'labora_website_name', true );
					$website_url			= get_post_meta( get_the_ID(), 'labora_website_url', true );
					$testimonial_content	= get_the_excerpt( get_the_ID() );
					$testimonial_email 		= get_post_meta( get_the_ID(),'labora_testimonial_email',true );

					if ( isset( $testimonial_email ) && '' != $testimonial_email ) {
						if ( $style == 'style1' || $style == 'style2' ) {
							$testimonial_gravatar_image = get_avatar( $testimonial_email, 90 );
						}
					} elseif ( has_post_thumbnail() ) {

						if ( empty( $photo_size ) ) {
							if ( $style == 'style1' || $style == 'style2' ) {
								$photo_size = '90x90';
							}
						}
						$testim_author_photo = wpb_getImageBySize( array(
							'attach_id' => get_post_thumbnail_id(),
							'thumb_size' => $photo_size,
						) );
						$testimonial_gravatar_image = $testim_author_photo['thumbnail'];
					}
					// Style 'carousel'
					$out .= '<div class="testimonial-carousel">';

					if ( '' != $website_url ) {
						$before = ' - <a href="' . esc_url( $website_url ) . '" target="_blank">';
						$after = '</a>';
					}
					// Style 1
					if ( $style == 'style1' || $style == 'style2' ) {
						$out .= '<div class="at-testimonial-item ' . $style . '">';
						if ( '' != $testimonial_content ) {
							$out .= '<div class="at-testimonial-blockquote">' . $testimonial_content . '</div>';
						}
						$out .= '<div class="at-testimonial-author">';
						if ( '' != $testimonial_gravatar_image ) {
							$out .= $testimonial_gravatar_image;
						}
						$out .= '<h5>' . get_the_title( $post->ID ) . '</h5>';
						if ( ! empty( $company_name ) || ! empty( $website_name ) ) {
							$out .= '<span>' . $company_name . $before . $website_name . $after . '</span>';
						}
						$out .= '</div>'; // .at-testimonial-author
						$out .= '</div>'; // .at-testimonial-item
					}
					$out .= '</div>';//.testimonial-carousel
				endwhile;
				$out .= '</div>';//.owl-carousel
				endif;
			wp_reset_postdata();
			return $out;
		}
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Testimonial_Carousel' ) ) {
		$labora_vc_testimonial_carousel = new Labora_VC_Testimonial_Carousel;
	}
	class WPBakeryShortCode_labora_vc_testimonial_carousel extends WPBakeryShortCode {
	}
}
