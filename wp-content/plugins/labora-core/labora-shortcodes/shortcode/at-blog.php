<?php
// BLOG =
if ( ! function_exists( 'labora_sc_blog' ) ) {
	function labora_sc_blog( $atts, $content = null ) {
		extract( shortcode_atts(array(
			'style' 	=> 'style1',
			'columns' 	=> '3',
			'cat'		=> '',
			'limit'		=> '-1',
			'pagination' => 'true',
			'postmeta'  => 'true',
			'items'		=> '4',
			'speed'		=> '3000',
			'thumbnail'	=> 'true',
			'content'	=> 'true',
		), $atts ) ); 

		global $post, $paged, $wp_query;

		$out = '';

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) {
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}
 
		$args = array(
			'showposts'	=> $limit,
			'tax_query' => array(
				'relation' => 'OR',
			),
			'paged'		=> $paged,
		);

		if ( $cat != '' ) {
			$cats = explode( ',', $cat );
			$tax_cat = array(
				'taxonomy' => 'category',
				'field'    => 'slug',
				'terms'    => $cats,
			);
			array_push( $args['tax_query'],$tax_cat );
		}

		$temp = $wp_query;
		$wp_query = null;

		// Query executes here;
		$wp_query = new WP_Query( $args );
		$labora_column_index = 0;

		if ( $columns == '2' ) { $labora_class = 'one_half'; }
		if ( $columns == '3' ) { $labora_class = 'one_third'; }
		if ( $columns == '4' ) { $labora_class = 'one_fourth'; }
		if ( $columns == '5' ) { $labora_class = 'one_fifth'; }

		/**
		 * Blog Style 3
		 * Enqueues Scripts and Styles if blog style 3
		 */
		if ( $style === 'style3' ) {
			$jcarousel_id = rand( 10, 9999 );
			$width = '540';	$height = '540';

			// Enqueue Owl Carousel
			wp_enqueue_style( 'labora-sc-owl-style' );
			wp_enqueue_style( 'labora-sc-owl-theme' );
			wp_enqueue_script( 'labora-sc-owl-carousel' );

			$out = '<script>
						jQuery(document).ready(function($) {
							$("#blogcarousel-' . $jcarousel_id . '").owlCarousel({
								autoPlay: ' . $speed . ',
								items : ' . $items . ',
								itemsDesktop : [1199,4],
								itemsDesktopSmall : [979,2],
								itemsTablet : [768,2],
								itemsMobile : [479,1]
							});
						});
					</script>';
			$out .= '<div class="container">';
			$out .= '<div id="blogcarousel-' . $jcarousel_id . '" class="owl-carousel">';
		}

		/* Start While Loop */
		if ( $wp_query-> have_posts() ) : while (  $wp_query->have_posts() ) :  $wp_query->the_post();
				$labora_column_index++;
				$labora_last = ( $labora_column_index == $columns && $columns != '1' ) ? 'last ' : '';
				$post_format = get_post_format();

				/**
				 * Blog Style 2
				 */
				if ( 'style2' === $style ) {

					$out .= '<article id="post-' . get_the_ID() . '" class="' . join( ' ', get_post_class( 'post', get_the_ID() ) ) . '  ' . esc_attr( $labora_class ) . ' ' . esc_attr( $labora_last ) . '">';
					$out .= '<div class="at-blog-sc-v1">';

					// Image
					if ( ( $post_format == 'image') || ( $post_format == '' ) ) {
						if ( has_post_thumbnail() && $thumbnail == 'true' ) {
							$out .= '<div class="at-post-thumb">';
							$out .= '<a href="' . esc_url( get_permalink() ) . '">';
							$out .= '<figure>' . get_the_post_thumbnail( $post->ID, 'full', '' ) . '</figure>';
							$out .= '</a>';
							$out .= '</div>';
						}
					}
					$out .= '<div class="at-post-content">';
					// Title
					$out .= '<h2 class="at-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . get_the_title() . '</a></h2>';
					// Content
					if ( $content == 'true' ) {
						$out .= '<div class="at-entry-content">';
						if ( $post_format == '' ) {
							if ( has_excerpt() ) {
								$out .= get_the_excerpt();
							} else {
								$out .= do_shortcode( get_the_content() );
								$out .= wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'labora_shortcodes' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								));
							}
						} elseif ( $post_format == 'status' ) {
							$status = get_post_meta( $post->ID, 'labora_status', true );
							if ( $status != '' ) {
								$out .= '<div class="status-content">';
								$out .= '<p>' . $status . '</p>';
								$out .= '</div>';
							}
						} elseif ( $post_format == 'quote' ) {
							$quote = get_post_meta( $post->ID, 'labora_postformat_quote', true );
							$out .= '<p class="quote">' . $quote . '</p>';
						} else {
							$out .= do_shortcode( get_the_content() );
							$out .= wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'labora_shortcodes' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
							) );
						}
						$out .= '</div>';//.entry-content
					}
					$out .= '</div>';
					if ( 'true' == $postmeta ) {
						$out .= '<div class="at-post-meta">';
						ob_start();
						$out .= labora_sc_post_metadata( '','date','','comments','likes' );
						$out .= ob_get_contents();
						ob_end_clean();
						$out .= '</div>';//.entry-meta
					}
					$out .= '</div>';//.blog-list
					$out .= '</article>';//article
				} elseif ( 'style1' === $style ) {
					/**
				 	* Blog Style 1
				 	*/
					$out .= '<div class="at-blog-list-v1">';
					$out .= '<article id="post-' . get_the_ID() . '" class="' . join( ' ', get_post_class( 'post', get_the_ID() ) ) . '">';

					if ( ( $post_format == 'image') || ( $post_format == '' ) ) {
						if ( has_post_thumbnail() && 'true' === $thumbnail ) {
							$out .= '<div class="at-post-thumb">';
							$out .= '<a href="' . esc_url( get_permalink() ) . '">';
							$out .= '<figure>' . get_the_post_thumbnail( $post->ID, 'thumbnail', '' ) . '</figure>';
							$out .= '</a>';
							$out .= '</div>';
						}
					}
					$out .= '<div class="at-post-content">';
					if ( 'true' === $postmeta ) {
						$out .= '<div class="at-blog-list-meta">';
						ob_start();
						$out .= labora_sc_post_metadata('','date','','','');
						$out .= ob_get_contents();
						ob_end_clean();
						$out .= '</div>';
					}
					$out .= '<h2 class="at-entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . get_the_title() . '</a></h2>';
					

					if ( 'true' === $content ) {
						$out .= '<div class="entry-content">';
						if ( $post_format == '' ) {
							if ( has_excerpt() ) {
								$out .= substr( get_the_excerpt(), 0, 80 );
							} else {
								$out .= do_shortcode( get_the_content() );
							}
						} elseif ( $post_format == 'status' ) {
							$status = get_post_meta( $post->ID, 'status', true );
							if ( $status != '' ) {
								$out .= '<div class="status-content">';
								$out .= '<p>' . $status . '</p>';
								$out .= '</div>';
							}
						} elseif ( $post_format == 'quote' ) {
							$quote = get_post_meta( $post->ID, 'postformatmetabox-quote', true );
							$out .= '<p class="quote">' . $quote . '</p>';
						} else {
							$out .= do_shortcode( get_the_content() );
							$out .= wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'labora_shortcodes' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								)
							);
						}
						$out .= '</div>';
					}
					$out .= '</div>';
					$out .= '</div>';
					$out .= '</article>';
				} elseif ( $style === 'style3' ) {
					$blogtitle = get_the_title();
					$post_date = get_the_time( 'M  j   Y', get_the_id() );
					$imagesrc  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', false, '' );

					// post title
					$out .= '<div class="at-blog-sc-owl-v1">';
					if ( has_post_thumbnail( $post->ID ) && $thumbnail == 'true' ) {
						$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', true );
							$out .= '<div class="at-post-thumb">';
							$out .= '<a href="' . esc_url( get_permalink() ) . '">';
							$out .= '<figure>' . get_the_post_thumbnail( $post->ID, 'full', '' ) . '</figure>';
							$out .= '</a>';
							$out .= '</div>';
					}
					$out .= '<div class="at-post-content">';
					$out .= '<h2 class="at-entry-title"><a href="' . get_permalink( $post->ID ) . '" >' . $blogtitle . '</a></h2>';
					$out .= '</div>';
					if ( 'true' == $postmeta ) {
						$out .= '<div class="at-post-meta">';
						ob_start();
						$out .= labora_sc_post_metadata( '','date','','comments','likes' );
						$out .= ob_get_contents();
						ob_end_clean();
						$out .= '</div>';//.entry-meta
					}
					$out .= '</div>';
				}
				if ( $labora_column_index == $columns ) {
					$labora_column_index = 0;
				}
				endwhile;
				$out .= '<div class="clear"></div>';
		if ( function_exists( 'labora_sc_pagination' ) ) {
			if ( $pagination == 'true' ) {
				ob_start();
				$out .= labora_sc_pagination();
				$out .= ob_get_contents();
				ob_end_clean();
			}
		}
		$wp_query = null;
		$wp_query = $temp;
	endif;

		if ( $style === 'style3' ) {
			$out .= '</div>';//.carousel
			$out .= '</div>';//.container
		}

		wp_reset_postdata();

		return $out;

	}
	//EOF labora_sc_blog
	add_shortcode( 'blog','labora_sc_blog' );
}
