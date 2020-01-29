<?php
/*
* Add-on Name: Direction for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Cases' ) ) {
	class Labora_VC_Cases {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_case_init' ) );
			add_shortcode( 'labora_vc_case', array( $this, 'labora_vc_case_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'labora_vc_case_script' ), 1 );
		}
		function labora_vc_case_script() {
			wp_enqueue_script( 'isotope' );
		}
		// intialize the wp enqueue scripts
		function labora_vc_case_init() {
			$labora_cases_categories = get_terms( 'cases_category' );
			$labora_cases_categories_arr = array();

			if ( ! empty( $labora_cases_categories ) && ! is_wp_error( $labora_cases_categories ) ) {
				foreach ( $labora_cases_categories as $cases_category ) {
					$labora_cases_categories_arr[] = array( 'label' => $cases_category->name, 'value' => $cases_category->slug );
				}
			}
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
					   'name' 		=> esc_html__( 'Cases', 'labora-pt-textdomain' ),
					   'base' 		=> 'labora_vc_case',
					   'class' 		=> '',
					   'icon' 		=> LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' 	=> 'Labora VC Addons',
					   'description' => esc_html__( 'Cases', 'labora-pt-textdomain' ),
					   'params' 	=> array(
						   array(
							   'type' 		  => 'dropdown',
							   'heading'     => esc_html__( 'Layout', 'labora-vc-textdomain' ),
							   'param_name'  => 'style',
							   'description' => esc_html__( 'Chooseing Your layout', 'labora-vc-textdomain' ),
							   'value'		 => array(
								   esc_html__( 'Grid', 'labora-vc-textdomain' ) => 'grid',
								   esc_html__( 'Grid With Filter', 'labora-vc-textdomain' ) => 'grid_with_filter',
							   ),
						   ),
						   array(
							   'type' 		  => 'autocomplete',
							   'heading'     => esc_html__( 'Include Category', 'labora-vc-textdomain' ),
							   'param_name'  => 'cases_category',
							   'description' => esc_html__( 'Add Category. If not added show all category', 'labora-vc-textdomain' ),
							   'settings'	=> array(
								   'multiple'		=> true,
								   'sortable'		=> true,
								   'min_length'		=> 1,
								   'no_hide'		=> true,
								   'unique_value' 	=> true,
								   'display_inline' => true,
								   	'values'		=> $labora_cases_categories_arr,
							   ),
						   ),
						   array(
							   'type' 		  => 'dropdown',
							   'heading'     => esc_html__( 'Columns', 'labora-vc-textdomain' ),
							   'param_name'  => 'columns',
							   'description' => esc_html__( 'Chooseing Your Cols', 'labora-vc-textdomain' ),
							   'value'		 => array(
								   esc_html__( 'Select Columns','labora-vc-textdomain' ) => '',
								   esc_html__( 'Two Columns', 'labora-vc-textdomain' ) => '2',
								   esc_html__( 'Three Columns', 'labora-vc-textdomain' ) => '3',
								   esc_html__( 'Four Columns', 'labora-vc-textdomain' ) => '4',
							   ),
							   'dependency'  => array( 'element' => 'style','value' => array( 'grid' ) ),
						   	),
							array(
								'type' 		  => 'textfield',
								'heading'     => esc_html__( 'Count', 'labora-vc-textdomain' ),
								'param_name'  => 'limit',
								'description' => esc_html__( 'The number of items you want to see on the screen.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 			=> 'dropdown',
								'heading'  	 	=> esc_html__( 'cases Orderby', 'labora-vc-textdomain' ),
								'param_name' 	=> 'orderby',
								'value' 	 	=> array(
														'ID' 			 => 'ID',
														'Title' 		 => 'title',
														'Date' 			 => 'date',
														'Menu Order' 	 => 'menu_order',
													),
								'description' 	=> esc_html__( 'Select the display orderby option you wish to use for cases.', 'labora-vc-textdomain' ),
							),
							array(
									'type' 		 	=> 'dropdown',
									'heading' 	 	=> esc_html__( 'Cases Order', 'labora-vc-textdomain' ),
									'param_name' 	=> 'order',
									'std'		 	=> 'DESC',
									'value'		 	=> array(
															'Ascending'  => 'ASC',
															'Descending' => 'DSC',
														),
									'description' => esc_html__( 'Select the order you wish to use for cases.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'checkbox',
								'heading' 	  => esc_html__( 'Cases Pagination', 'labora-vc-textdomain' ),
								'param_name'  => 'pagination',
								'description' => esc_html__( 'Check this if you wish to enable the pagination for staffs. ( Default: disable )', 'labora-vc-textdomain' ),
								'value'		  => array( esc_html__( 'Yes', 'labora-vc-textdomain' ) => 'yes' ),
								'dependency'  => array( 'element' => 'style','value' => array( 'grid' ) ),
							),
							array(
								'type' 		  => 'textfield',
								'heading'     => esc_html__( 'Image Size', 'labora-vc-textdomain' ),
								'param_name'  => 'image_size',
								'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use default size..', 'labora-vc-textdomain' ),
							),
						),
					)
				);
			}
		}
		function labora_vc_case_shortcode( $atts ) {
			extract( shortcode_atts( array(
				'css'	    	=> '',
				'style'			=> '',
				'cases_category'	=> '',
				'orderby' 		=> 'title',
				'order' 		=> 'ASC',
				'pagination'	=> '',
				'limit' 		=> '-1',
				'columns'		=> '',
				'image_size'	=> '',
			), $atts ) );

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			$css_class .= 'at-cases-wrapper';
			$css_class .= ' col_' . $columns;

			$out = '';

			$cases_categories_arr = explode( ', ', $cases_category );

			$all_cases = new WP_Query( array(
				'post_type'     => 'cases',
				'orderby'		=> $orderby,
				'order'			=> $order,
				'posts_per_page' => $limit,
				'tax_query' => array(
					array(
						'taxonomy' => 'cases_category',
						'field'    => 'slug',
						'terms'    => $cases_categories_arr,
					),
				),
			) );

			$categories = get_terms( 'cases_category' );
			if ( ! empty( $cases_category ) ) {
				$categories_arr = array();
				$cases_categories_arr = explode( ', ', $cases_category );
				foreach ( $categories as $cat ) {
					if ( in_array( $cat->slug, $cases_categories_arr , true ) ) {
						$categories_arr[] = (object) array( 'name' => $cat->name, 'slug' => $cat->slug );
					}
				}

				$categories = $categories_arr;
			}


			$cases_id = uniqid( 'at-cases-' );
			if( $columns == '2' ) { 	$width = '470';	$height = '470'; }
			if( $columns == '3' ) { 	$width = '470';	$height = '470'; }
			if( $columns == '4' ) { 	$width = '470';	$height = '470'; }
		
			if ( $all_cases->have_posts() ) :
				$out .= '<div id=' . $cases_id . '  class="' . esc_attr( $css_class ) . '">';
				if ( $style == 'grid_with_filter' && $categories ) {
					$out .= '<ul class="at-cases-filter">';
					$out .= '<li><a href="#all" class="selected">' . esc_html__( 'All', 'Labora' ) . '</a></li>';
					foreach ( $categories as $cat ) {
						$out .= '<li><a href="#' . esc_attr( $cat->slug ) . '">' . esc_attr( $cat->name ) . '</a></li>';
					}
					$out .= '</ul>';
				}
				$out .= '<div class="at-cases-main">';
				while ( $all_cases->have_posts() ) : $all_cases->the_post();
					$cases_class = '';
					$cases_name = array();
					$term_list  = wp_get_post_terms( get_the_ID(), 'cases_category' );
					if ( $term_list ) {
						foreach ( $term_list as $term ) {
							$cases_class .= ' ' . $term->slug;
							$cases_name[] .= ' ' . $term->name;
						}
					}
					$img_alt_title = '';
					$out .= '<div class="at-cases-item grid-cases all' . esc_attr( $cases_class ) . '">';
					$out .= '<div class="at-cases clearfix">';
					$out .= '<div class="at-cases-details">';
					ob_start();
					if ( has_post_thumbnail() ) {
						if ( empty( $image_size ) ) {
							$image_size = 'labora-image-750x450-croped';
						}
						if ( function_exists( 'wpb_getImageBySize' ) ) {
							$post_thumbnail = wpb_getImageBySize( array(
								'attach_id'  => get_post_thumbnail_id(),
								'thumb_size' => $image_size,
							) );
							$post_thumbnail = $post_thumbnail['thumbnail'];
							$out .= $post_thumbnail;
						}
					} else {
						$no_image = LABORA_VC_ADDON_URL . 'assets/images/no_image.jpg';
						$out .= '<img src="' . $no_image . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" />';
					}
					$out .= ob_get_clean();
					$out .= '<div class="at-cases-content">';
					$out .= '<span class="title">' . get_the_title() . '</span>';
					if ( ! empty( $cases_name ) ) {
						$out .= '<span class="categories">' . implode( ', ', $cases_name ) . '</span>';
					}
					$out .= '</div>'; // info end
					$out .= '<a href="' . get_permalink() . '"></a>';
					$out .= '</div>'; // info end
					$out .= '</div>'; // at-cases
					$out .= '</div>'; // at-cases-item
				endwhile;
			 	wp_reset_query();
				$out .= '</div>';
				$out .= '</div>';
				echo $out;
			endif;
			?>
			<script type="text/javascript">
				jQuery(window).load(function($){
					var $container = jQuery("#<?php echo esc_js( $cases_id ); ?> .at-cases-main");
					var originLeft = true;
					if( jQuery('body').hasClass('rtl') ) {
						originLeft = false;
					}
					$container.isotope({
						layoutMode: 'fitRows',
						itemSelector: '.at-cases-item',
						transitionDuration: '0.8s',
						isOriginLeft: originLeft
					});
					jQuery('#<?php echo esc_js( $cases_id ); ?> .at-cases-filter a').on('click', function ($) {
							jQuery(this).closest('ul').find('li a.selected').removeClass('selected');
							jQuery(this).addClass('selected');
							var sort = jQuery(this).attr('href');
							sort = sort.substring(1);
							$container.isotope({
								filter: '.' + sort
							});
							return false;
					});
				});
			</script>
			<?php
		}
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Cases' ) ) {
		$labora_vc_work = new Labora_VC_Cases;
	}

	class WPBakeryShortCode_labora_vc_cases extends WPBakeryShortCode {
	}
}
