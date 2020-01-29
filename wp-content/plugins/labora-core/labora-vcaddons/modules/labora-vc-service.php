<?php
/*
* Add-on Name: service for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Service' ) ) {
	class Labora_VC_Service {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_service_init' ) );
			add_shortcode( 'labora_service', array( $this, 'labora_vc_service_shortcode' ) );
		}
		// initialize the mapping function
		function labora_vc_service_init() {
			if ( function_exists( 'vc_map' ) ) {
				$labora_cat_options = array();
				if ( $labora_services = true ) {
					$labora_service_cat = get_terms( 'service_cat', 'orderby=name&hide_empty=1' );
					if ( ! empty( $labora_service_cat ) && ! is_wp_error( $labora_service_cat ) ) {
						foreach ( $labora_service_cat as $category ) {
							$labora_cat_options[ $category->slug ] = $category->name;
						}
					}
				}
				vc_map(
					array(
					   'name' 		 => esc_html__( 'Service', 'labora-vc-textdomain' ),
					   'base' 		 => 'labora_service',
					   'class'		 => '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	 => 'Labora VC Addons',
					   'description' => esc_html__( 'service shortcode', 'labora-vc-textdomain' ),
					   'params' 	 => array(
						    array(
							   'type' 			=> 'checkbox',
							   'heading'  	 	=> esc_html__( 'Categories', 'labora-vc-textdomain' ),
							   'param_name' 	=> 'cat',
							   'value' 	 		=> $labora_cat_options,
							   'description' 	=> esc_html__( 'Select the service Categories.','labora-vc-textdomain' ),
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
								'type'       => 'dropdown',
								'heading'    => esc_html__( 'Posts Per Row', 'labora-vc-textdomain' ),
								'param_name' => 'posts_per_row',
								'value'      => array(
									4 => 4,
									3 => 3,
									2 => 2,
									1 => 1,
								),
							),
					   		array(
								'type' 		 => 'dropdown',
								'heading'  	 => esc_html__( 'Choose Style', 'labora-vc-textdomain' ),
								'param_name' => 'display_style',
								'value' 	 => array(
														'Choose one...'	=> '',
														'Style 1'		=> 'style1',
														'Style 2' 		=> 'style2',
														'Style 3' 		=> 'style3',
													),
								'description' 	=> esc_html__( 'Choose the Style for service.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'heading'     => esc_html__( 'Image Size', 'labora-vc-textdomain' ),
								'param_name'  => 'image_size',
								'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use default size..', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'checkbox',
								'heading' 	  => esc_html__( 'Image Enable / Disable', 'labora-vc-textdomain' ),
								'param_name'  => 'image_display',
								'description' => esc_html__( 'Check this if you wish to enable the pagination for services. ( Default: disable )', 'labora-vc-textdomain' ),
								'value'		  => array( esc_html__( 'Yes', 'labora-vc-textdomain' ) => 'yes' ),
							),
						),
					)
				);
			}
		}
		function labora_vc_service_shortcode( $atts, $content = null, $code ) {
			extract( shortcode_atts( array(
				'css'	    	=> '',
				'limit'		 	=> '-1',
				'display_style' => '',
				'cat'    		=> '',
				'image_size'  	=> '',
				'image_display'	=> '',
				'posts_per_row' => '',
			), $atts ) );

			global $post, $paged, $wp_query;

			$out = '';
			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			$css_class .= ' col_' . $posts_per_row;

			$args = array(
				'post_type'	=> 'service',
				'showposts'	=> $limit,
				'tax_query' => array(
					'relation' => 'OR',
				),
				'paged'		=> $paged,
			);

			if ( '' != $cat ) {
				$cats = explode( ',',$cat );
					$tax_cat = array(
						'taxonomy' 	=> 'service_cat',
						'field' 	=> 'slug',
						'terms' 	=> $cats,
					);
					array_push( $args['tax_query'],$tax_cat );
			}
			$original_query = $wp_query;

			// Query executes here;
			$service_query = new WP_Query( $args );

			$wp_query = $service_query;

			if ( $service_query->have_posts() ) :

				$service_id = uniqid( 'at-service-id-' );
				$out .= '<div id=' . $service_id . ' class="at-service-container ' . esc_attr( $css_class ) . ' clearfix">';
				while ( $service_query->have_posts() ) : $service_query->the_post();

					$service_label 		= get_post_meta( get_the_ID(), 'labora_label', true );
					$service_cost  		= get_post_meta( get_the_ID(), 'labora_cost', true );
					$service_content	= get_the_excerpt( get_the_ID() );
					if ( $display_style == 'style1' || $display_style == 'style2' ) {
						$out .= '<div class="at-item ' . $display_style . '">';
						$out .= '<div class="at-image">';
						ob_start();
						if ( $image_display != 'yes' ) {
							if ( has_post_thumbnail() ) {
								if ( empty( $image_size ) ) {
									$image_size = 'labora-image-350x220-croped';
								}
								if ( function_exists( 'wpb_getImageBySize' ) ) {
									$post_thumbnail = wpb_getImageBySize( array(
										'attach_id'  => get_post_thumbnail_id(),
										'thumb_size' => $image_size,
									) );
									$post_thumbnail = $post_thumbnail['thumbnail'];
									$out .= '<a href="' . get_permalink() . '">';
									$out .= $post_thumbnail;
									$out .= '</a>';
								}
							} else {
								$no_image = LABORA_VC_ADDON_URL . 'assets/images/no_image.jpg';
								$out .= '<a href="' . get_permalink() . ' "><figure>' . labora_vc_resize( '', $no_image, $width, $height, 'service-thumb', $img_alt_title ) . '</figure></a>';
							}
						}
						$out .= ob_get_clean();
						$out .= '</div>'; // image class end
						$out .= '<div class="at-content">';
						if ( $display_style != 'style2' ) {
							$out .= '<h4><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h4>';
							$out .= '<p>' . $service_content . '</p>';
						} else {
							$service_cat = '';
							$term_list  = wp_get_post_terms( get_the_ID(), 'service_cat' );
							if ( $term_list ) {
								foreach ( $term_list as $term ) {
									$service_cat [] = $term->name;
								}
								$service_cat = implode( ', ', $service_cat );
							}
							if ( ! empty( $service_cat ) ) {
								$out .= '<div class="at-category"><span>' . $service_cat . '</span> <i class="fa fa-chevron-right"></i></div>';
							}
							$out .= '<h4><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h4>';
						}

						if ( ! empty( $service_cost ) ) {
							$out .= $service_cost;
						}
						if ( ! empty( $service_label ) ) {
							$out .= $service_label;
						}
						if ( $display_style != 'style2' ) {
							$out .= '<a class="more-link" href="' . esc_url( get_permalink() ) . '">';
							$out .= '<span>' . esc_html__( 'Read more', 'labora-vc-textdomain' ) . '</span>';
							$out .= '</a>';
						}
						$out .= '</div>'; // info end
						$out .= '</div>'; // item
					} elseif ( $display_style == 'style3' ) {
						$out .= '<div class="at-item ' . $display_style . '">';
						$out .= '<div class="at-image">';
						ob_start();
						if ( $image_display != 'yes' ) {
							if ( has_post_thumbnail() ) {
								if ( empty( $image_size ) ) {
									$image_size = 'labora-image-350x220-croped';
								}
								if ( function_exists( 'wpb_getImageBySize' ) ) {
									$post_thumbnail = wpb_getImageBySize( array(
										'attach_id'  => get_post_thumbnail_id(),
										'thumb_size' => $image_size,
									) );
									$post_thumbnail = $post_thumbnail['thumbnail'];
									$service_cat = '';
									$term_list  = wp_get_post_terms( get_the_ID(), 'service_cat' );
									if ( $term_list ) {
										foreach ( $term_list as $term ) {
											$service_cat [] = $term->name;
										}
										$service_cat = implode( ', ', $service_cat );
									}
									$out .= '<a href="' . get_permalink() . '">';
									if ( ! empty( $service_cat ) ) {
										$out .= '<div class="at-category"><span>' . $service_cat . '</span></div>';
									}
									$out .= $post_thumbnail;
									$out .= '</a>';
								}
							} else {
								$no_image = LABORA_VC_ADDON_URL . 'assets/images/no_image.jpg';
								$out .= '<a href="' . get_permalink() . ' "><figure>' . labora_vc_resize( '', $no_image, $width, $height, 'service-thumb', $img_alt_title ) . '</figure></a>';
							}
						}
						$out .= ob_get_clean();
						$out .= '</div>'; // image class end
						$out .= '<div class="at-content">';
						$out .= '<h4><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h4>';
						$out .= '<p>' . $service_content . '</p>';
						if ( ! empty( $service_cost ) ) {
							$out .= $service_cost;
						}
						if ( ! empty( $service_label ) ) {
							$out .= $service_label;
						}
						$out .= '<a class="more-link" href="' . esc_url( get_permalink() ) . '">';
						$out .= '<span>' . esc_html__( 'Read more', 'labora-vc-textdomain' ) . '</span>';
						$out .= '</a>';
						$out .= '</div>'; // info end
						$out .= '</div>'; // item
					}
				endwhile;
				endif;
				$out .= '</div>'; // services-list
			wp_reset_query();
			$wp_query = $original_query;
			return $out;
		}
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Service' ) ) {
		$labora_vc_service = new Labora_VC_Service;
	}
	class WPBakeryShortCode_labora_vc_service extends WPBakeryShortCode {
	}
}
