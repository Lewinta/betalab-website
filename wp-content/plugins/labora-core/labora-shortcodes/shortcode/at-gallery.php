<?php
function labora_sc_galleria( $atts, $content = null, $code ) {
	extract(shortcode_atts(array(
		'cat'			=> '',
		'postid_g'		=> '',
		'limit'			=> '-1',
		'columns'		=> '',
		'orderby'		=> 'ID',
		'order'			=> 'ASC',
		'pagination'	=> '',
	), $atts));

	$column_index = 0;
	if ( $columns == '4' ) {
		$class = 'col_fourth';
	}
	if ( $columns == '3' ) {
		$class = 'col_third';
	}
	if ( $columns == '2' ) {
		$class = 'col_two';
	}
	if ( $columns == '' ) {
		$class = '';
	}

	//Album Image Sizes
	$width = '470';
	$height = '470';
	$out = '';

	if ( get_query_var( 'paged' ) ) {
		$paged = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$paged = get_query_var( 'page' );
	} else {
		$paged = 1;
	}

	$orderby = $orderby ? $orderby : 'ID';
	$order   = $order ? $order : 'ASC';

	if ( $cat != 'null' ) {
		$query = array(
			'post_type'			=> 'gallery',
			'showposts'			=> $limit,
			'tax_query' => array(
				'relation' => 'OR',
			),
			'orderby'	=> $orderby,
			'order'		=> $order,
			'paged'		=> $paged,
		);
	}
	if ( $cat != '' ) {
		$cats = explode( ',',$cat );
		$tax_cat = array(
			'taxonomy' 		=> 'gallery_category',
			'field' 		=> 'slug',
			'terms' 		=> $cats,
		);
		array_push( $query['tax_query'],$tax_cat );
	}
	$postid_array = array();
	$postid_array = explode( ',',$postid_g );
	if ( $postid_g != '' ) {
		$query = array(
				'post_type'	=> 'gallery',
				'post__in'	=> $postid_array,
		);
	}
	query_posts( $query ); //get the results
	global $post;
	if ( have_posts() ) : while ( have_posts() ) : the_post();
			$gallery_venue			= get_post_meta( $post->ID, 'labora_gallery_venue', true );
			$img_alt_title 			= get_the_title();
			$column_index++;
			$last = ( $column_index == $columns && $columns != 1 ) ? 'end ' : '';

			$permalink	= get_permalink( get_the_id() );
			$image		= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full', true );

			$out .= '<div class="gallery-list ' . $class . ' ' . $last . '">';
			$out .= '<div class="custompost_entry">';
			if ( has_post_thumbnail() ) {
				$out .= '<div class="custompost_thumb port_img">';
				$out .= '<figure>';
				$out .= get_the_post_thumbnail( $post->ID, array( $width, $height ) );
				$out .= '</figure>';
				$out .= '<div class="hover_type">';
				$out .= '<a class="hovergallery"  href="' . $permalink . '" title="' . get_the_title() . '"></a>';
				$out .= '</div>';
				$out .= '<span class="imgoverlay"></span>';
				$out .= '</div>';
			}
			$out .= '<div class="gallery-desc">';
			$out .= '<h2 class="entry-title"><a href="' . $permalink . '">' . get_the_title() . '</a></h2>';
			if ( $gallery_venue != '' ) {
				$out .= '<span>' . $gallery_venue . '</span>';
			}
			$out .= '</div>';
			$out .= '</div>';
			$out .= '</div>';
			if ( $column_index == $columns ) {
				$column_index = 0;
				$out .= '<div class="clear"></div>';
			}
			endwhile;
	$out .= '<div class="clear"></div>';
	if ( function_exists( 'labora_sc_pagination' ) ) {
		if ( $pagination == 'true' ) {
			$out .= labora_sc_pagination();
		}
	}
	wp_reset_query();
	endif;
	return $out;
}
add_shortcode( 'gallery','labora_sc_galleria' ); //add shortcode
