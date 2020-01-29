<?php
/*
* Add-on Name: staff for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Staff' ) ) {
	class Labora_VC_Staff
	{
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_staff_init' ) );
			add_shortcode( 'labora_vc_staff', array( $this, 'labora_vc_staff_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'labora_vc_staff_script' ), 1 );
		}

		// intialize the  wp enqueue  scripts
		function labora_vc_staff_script() {
			wp_register_script( 'labora-owl-carousel', LABORA_VC_ADDON_URL . 'assets/js/owl.carousel.js','jquery','','in_footer' );
			wp_enqueue_style( 'labora-owl-style', LABORA_VC_ADDON_URL . 'assets/css/owl.carousel.css', false, false, 'all' );
			wp_enqueue_style( 'labora-owl-theme', LABORA_VC_ADDON_URL . 'assets/css/owl.theme.css', false, false, 'all' );
		}
		// initialize the mapping function
		function labora_vc_staff_init() {
			if ( function_exists( 'vc_map' ) ) {
				$labora_cat_options = array();
					$labora_staff_category = get_terms( 'staff_category', 'orderby=name&hide_empty=1' );
					if ( ! empty( $labora_staff_category ) && ! is_wp_error( $labora_staff_category ) ) {
						foreach ( $labora_staff_category as $category ) {
							$labora_cat_options[ $category->slug ] = $category->name;
						}
					}
					// var_dump($labora_cat_options);
				vc_map(
					array(
					   'name' 		=> esc_html__( 'Staff','labora-vc-textdomain' ),
					   'base' 		=> 'labora_vc_staff',
					   'class' 		=> '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	=> 'Labora VC Addons',
					   'description' => esc_html__( 'Staff', 'labora-vc-textdomain' ),
					   'params' 	=> array(
							array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'Staff Orderby', 'labora-vc-textdomain' ),
								'param_name' 	=> 'orderby',
								'value' 	 	=> array(
														'ID' 			 => 'ID',
														'Title' 		 => 'title',
														'Date' 			 => 'date',
														'Menu Order' 	 => 'menu_order',
													),
								'description' 	=> esc_html__( 'Select the display orderby option you wish to use for staffs.', 'labora-vc-textdomain' ),
							),

							array(
									'type' 		 	=> 'dropdown',
									'heading' 	 	=> esc_html__( 'Staff Order', 'labora-vc-textdomain' ),
									'param_name' 	=> 'order',
									'std'		 	=> 'DESC',
									'value'		 	=> array(
															'Ascending'  => 'ASC',
															'Descending' => 'DSC',
														),
									'description' => esc_html__( 'Select the order you wish to use for staffs.', 'labora-vc-textdomain' ),
							),
							array(
							   'type' 			=> 'checkbox',
							   'heading'  	 	=> esc_html__( 'Categories', 'labora-vc-textdomain' ),
							   'param_name' 	=> 'cat',
							   'value' 	 		=> $labora_cat_options,
							   'description' 	=> esc_html__( 'Select the Staff Categories.','labora-vc-textdomain' ),
						    ),
							array(
									'type' 		 	=> 'dropdown',
									'heading' 	 	=> esc_html__( 'Staff display type', 'labora-vc-textdomain' ),
									'param_name' 	=> 'display_type',
									'std'		 	=> '',
									'value'		 	=> array(
															esc_html__( 'List', 'labora-vc-textdomain' ) => 'list',
															esc_html__( 'Grid', 'labora-vc-textdomain' ) => 'grid',
															esc_html__( 'Carousel', 'labora-vc-textdomain' ) => 'carousel',
														),
									'description' => esc_html__( 'Select the type you wish to display for staff.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Carousel Slides Per View', 'labora-vc-textdomain' ),
								'param_name'  => 'items',
								'description' => esc_html__( 'Enter number of slides to display at the same time.', 'labora-vc-textdomain' ),
								'dependency'  => array( 'element' => 'display_type','value' => array( 'carousel' ) ),
							 ),
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Carousel Speed', 'labora-vc-textdomain' ),
								'param_name'  => 'speed',
								'description' => esc_html__( 'Duration of animation between slides (in ms).', 'labora-vc-textdomain' ),
								'dependency'  => array( 'element' => 'display_type','value' => array( 'carousel' ) ),
							),
							array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'Display Column', 'labora-vc-textdomain' ),
								'param_name' 	=> 'columns',
								'value' 	 	=> array(
														esc_html__( '2 Columns', 'labora-vc-textdomain' ) => '2',
														esc_html__( '3 Columns', 'labora-vc-textdomain' ) => '3',
														esc_html__( '4 Columns', 'labora-vc-textdomain' ) => '4',
													),
								'dependency' 	=> array( 'element' => 'display_type','value' => array( 'grid', 'carousel' ) ),
								'description' 	=> esc_html__( 'Select the no. of columns you wish to display for staffs.', 'labora-vc-textdomain' ),
								'std'			=> '2',
							),
							array(
								'type' 		  => 'checkbox',
								'heading' 	  => esc_html__( 'Staff Pagination', 'labora-vc-textdomain' ),
								'param_name'  => 'pagination',
								'description' => esc_html__( 'Check this if you wish to enable the pagination for staffs. ( Default: disable )', 'labora-vc-textdomain' ),
								'value'		  => array( esc_html__( 'Yes', 'labora-vc-textdomain' ) => 'yes' ),
								'dependency'  => array( 'element' => 'display_type','value' => array( 'list', 'grid' ) ),
							),

							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Staff Limits', 'labora-vc-textdomain' ),
								'param_name'  => 'limit',
								'description' => esc_html__( 'Enter number of staffs to display (Note: Enter "-1" to display all staffs).', 'labora-vc-textdomain' ),
							 ),
						),
					)
				);
			}
		}

		function labora_vc_staff_shortcode( $atts ) {
			extract(shortcode_atts( array(
				'cat' 		=> '',
				'items' 	=> '3',
				'speed' 	=> '3000',
				'display_type' => '',
				'orderby' 	=> 'title',
				'order' 	=> 'ASC',
				'pagination' => '',
				'limit' 	=> '-1',
				'columns' 	=> '2',
				'no_margin' => '',
			), $atts));

			global $post, $wp_query;

			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$width = '350';	$height = '250';

			$staff_args = array(
				'post_type'	   	=> 'staff',
				'posts_per_page' => $limit,
				'paged'		=> $paged,
				'tax_query' => array(
					'relation' => 'OR',
				),
				'orderby'	=> $orderby,
				'order'		=> $order,
			);
			if ( '' != $cat ) {
				$cats = explode( ',',$cat );
					$tax_cat = array(
						'taxonomy' 	=> 'staff_category',
						'field' 	=> 'slug',
						'terms' 	=> $cats,
					);
					array_push( $staff_args['tax_query'],$tax_cat );
			}
			$original_query = $wp_query;
			$staff_post_type = new WP_Query( $staff_args );
			$wp_query = $staff_post_type;

			$carousel_id = rand( 10, 99 );

			$out = $c_pagination = $class_to_filter = $css = '';

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

			$css_class .= ' col_' . $columns;

			if ( $pagination == 'yes' ) {
				$c_pagination = 'true';
			} else {
				$c_pagination = 'false';
			}

			if ( $display_type === 'carousel' ) {
				$out .= '<script>
					jQuery(document).ready(function($) {
					 $("#staff_owl-' . $carousel_id . '").owlCarousel({
						autoPlay: ' . $speed . ',
						lazyLoad: true,
						pagination: ' . $c_pagination . ',
						navigation:false,
						touchDrag: true,
						stopOnHover: true,
						items : ' . $columns . ',
						itemsDesktop : [1199,4],
						itemsDesktopSmall : [1024,4],
						itemsTablet : [768,2],
						itemsMobile : [479,1]
					});
				});
				</script>';

				if ( $staff_post_type->have_posts() ) :
					$out .= '<div id="staff_owl-' . $carousel_id . '" class="owl-carousel">';
					while ( $staff_post_type->have_posts() ) : $staff_post_type->the_post();
						// Get the post details
						$labora_department = get_post_meta( get_the_ID(), 'labora_department', true );
						$labora_address    = get_post_meta( get_the_ID(), 'labora_address', true );
						$labora_phone      = get_post_meta( get_the_ID(), 'labora_phone', true );
						$labora_email      = get_post_meta( get_the_ID(), 'labora_email', true );
						$labora_sociable   = get_post_meta( get_the_ID(), 'labora_sociable', true );

						$out .= '<div class="at-person carousel">';
						if ( has_post_thumbnail( get_the_id() ) ) {
							$out .= '<div class="at-person-image"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
							$out .= get_the_post_thumbnail( get_the_ID(), array( $width, $height ) );
							$out .= '</a></div>';
						}
						$out .= '<div class="at-person-content"><h4><a href="' . esc_url( get_permalink( get_the_id() ) ) . '">' . get_the_title() . '</a></h4>';
						$out .= '<h6>' . $labora_department . '</h6>';
						$out .= '</div>';
						$out .= '</div>'; //.staff-item
					endwhile;
					$out .= '</div>';
				endif;
				wp_reset_query();
				$wp_query = $original_query;

			}
			if ( $display_type === 'list' ) {
				if ( $staff_post_type->have_posts() ) :
					while ( $staff_post_type->have_posts() ) : $staff_post_type->the_post();

						$labora_department = get_post_meta( get_the_ID(), 'labora_department', true );
						$labora_address    = get_post_meta( get_the_ID(), 'labora_address', true );
						$labora_phone      = get_post_meta( get_the_ID(), 'labora_phone', true );
						$labora_email      = get_post_meta( get_the_ID(), 'labora_email', true );
						$labora_sociable   = get_post_meta( get_the_ID(), 'labora_sociable', true );

						$out .= '<div class="at-person list">';
						if ( has_post_thumbnail( get_the_id() ) ) {
							$out .= '<div class="at-person-image"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
							$out .= get_the_post_thumbnail( get_the_ID(), array( $width, $height ) );
							$out .= '</a></div>';
						}
						$out .= '<div class="at-person-content"><h4><a href="' . esc_url( get_permalink( get_the_id() ) ) . '">' . get_the_title() . '</a></h4>';
						$out .= '<h6>' . $labora_department . '</h6>';
						$out .= '<p>' . get_the_excerpt() . '</p>';
						$out .= '<a class="read_more" href="' . esc_url( get_permalink() ) . '">';
						$out .= '<span>' . esc_html__( 'View Profile', 'labora-vc-textdomain' ) . '</span>';
						$out .= '</a>';
						$out .= '</div>';
						$out .= '</div>'; //.staff-item
					endwhile;

					// staff pagination
					if ( function_exists( 'labora_pagination' ) ) {
						if ( $pagination == 'yes' ) {
							$out .= '<div class="clear"></div>';
							ob_start();
							$out .= labora_pagination();
							$out .= ob_get_contents();
							ob_end_clean();
						}
					}
					endif;
					wp_reset_query();
					$wp_query = $original_query;
			}
			if ( $display_type === 'grid' ) {
				if ( $staff_post_type->have_posts() ) :
					$out .= '<div class="at-person grid ' . esc_attr( $css_class ) . '"><ul>';
					while ( $staff_post_type->have_posts() ) : $staff_post_type->the_post();

						$labora_department = get_post_meta( get_the_ID(), 'labora_department', true );
						$labora_address    = get_post_meta( get_the_ID(), 'labora_address', true );
						$labora_phone      = get_post_meta( get_the_ID(), 'labora_phone', true );
						$labora_email      = get_post_meta( get_the_ID(), 'labora_email', true );
						$labora_sociable   = get_post_meta( get_the_ID(), 'labora_sociable', true );
						$out .= '<li>';
						if ( has_post_thumbnail( get_the_id() ) ) {
							$out .= '<div class="at-person-image"><a href="' . esc_url( get_permalink( $post->ID ) ) . '">';
							$out .= get_the_post_thumbnail( get_the_ID(), '', arraY( $width, $height ) );
							$out .= '</a></div>';
						}
						$out .= '<div class="at-person-content"><h4><a href="' . esc_url( get_permalink( get_the_id() ) ) . '">' . get_the_title() . '</a></h4>';
						$out .= '<h6>' . $labora_department . '</h6>';
						$out .= '<p>' . labora_substr_text( get_the_excerpt(), 95 ) . '</p>';
						$out .= '<a class="read_more" href="' . esc_url( get_permalink() ) . '">';
						$out .= '<span>' . esc_html__( 'View Profile', 'labora-vc-textdomain' ) . '</span>';
						$out .= '</a>';
						$out .= '</div>';
						$out .= '</li>'; //.staff-item
					endwhile;
					$out .= '</ul></div>';//.staffs_lists
					// staff pagination
					if ( function_exists( 'labora_pagination' ) ) {
						if ( $pagination == 'yes' ) {
							$out .= '<div class="clear"></div>';
							ob_start();
							$out .= labora_pagination();
							$out .= ob_get_contents();
							ob_end_clean();
						}
					}
				endif;
				wp_reset_query();
				$wp_query = $original_query;
			}
			return $out;
		}
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Staff' ) ) {
		$labora_vc_staff = new Labora_VC_Staff;
	}
	class WPBakeryShortCode_labora_vc_staff extends WPBakeryShortCode {
	}
}
