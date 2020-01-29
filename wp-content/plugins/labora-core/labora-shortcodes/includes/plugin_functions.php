<?php
/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index
 * views, or a div element when on single views.
 *
 */

if ( ! function_exists( 'labora_sc_post_metadata' ) ) {
	/**
	 * Print HTML with meta information for the current post-date/time and author.
	 */
	function labora_sc_post_metadata( $at_pm_author = false, $at_pm_date = false, $at_pm_categories = false,  $at_pm_comments = false, $at_pm_likes = false ) {

		if ( is_sticky() && is_home() && ! is_paged() ) {
			echo '<span class="iva-pm-featured featured-post">' . esc_html__( 'Sticky', 'labora_shortcodes' ) . '</span>';
		}
		if ( $at_pm_author == 'author' ) {
		// Set up and print post meta information.
		echo '<span class="iva-pm-byauthor"><a href="'. esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ).'">'. get_the_author().'</a></span>';
		}
		if ( $at_pm_categories == 'categories' ) {
			if(get_the_category_list() ){
				echo '<span class="iva-pm-postin">'. get_the_category_list( ', ', '', '') .'</span>';
			}
		}
		if ( $at_pm_date == 'date' ) {
			echo '<span class="iva-pm-postin">'. get_the_date() .'</span>';
		}
		if ( $at_pm_comments == 'comments' ) {
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ){
				echo '<span class="iva-pm-comments">';
				comments_popup_link( esc_html__( '0 Comment', 'labora_shortcodes' ), esc_html__( '1 Comment', 'labora_shortcodes' ), esc_html__( '% Comments', 'labora_shortcodes' ) );
				echo '</span>';
			}
		}
		if ( $at_pm_likes == 'likes' ) {
			if ( function_exists( 'labora_post_like' ) ) {
				echo '<span class="iva-meta-likes">' . wp_kses_post( labora_post_like( 'iva_like' ) ). '</span>';
			}
		}
	}
}

if ( ! function_exists( 'labora_sc_pagination' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since hopes 1.0
 */
function labora_sc_pagination() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => esc_html__( '&larr; Previous', 'labora_shortcodes' ),
		'next_text' => esc_html__( 'Next &rarr;', 'labora_shortcodes' ),
	) );

	if ( $links ) {

		$out ='<nav class="navigation paging-navigation" role="navigation">';
		$out .='<div class="pagination loop-pagination">';
		$out .=$links;
		$out .='</div>';
		$out .='</nav>';
	}
	return $out;
}
endif;

// Sociables
if ( ! function_exists( 'labora_sc_social' ) ){
	function labora_sc_social( $color ) {
		$out = '';
		if ( get_option( 'labora_social_bookmark' ) != '' ) {

			$sys_social_bookmark_icons = explode('#;', get_option('labora_social_bookmark'));
			if( $color =="black" ){
				$icon_color = "iva_sociables_black";
			} else {
				$icon_color ='iva_sociables_white';
			}
			$out = '<ul class="iva_socials '.$icon_color.'">';
			for ( $i=0; $i < count( $sys_social_bookmark_icons ); $i++ ) {
				$sys_social_bookmark_icon = explode('#|', $sys_social_bookmark_icons[$i]);
				if ( $sys_social_bookmark_icon[1] == '' ) {
					$sys_social_bookmark_icon[1] = '#';
				}

				$out .= '<li class="'.$sys_social_bookmark_icon[1].'"><a href="'.esc_url( $sys_social_bookmark_icon[2] ).'" target="_blank">';
				$out .= '<i class="fa fa-'.$sys_social_bookmark_icon[1].' fa-fw" title="'.$sys_social_bookmark_icon[0].'"></i></a></li>';

			} //End for
			$out .= '</ul>';
		}

		return $out;
	}
}
add_filter( 'the_content', 'labora_sc_br_p_fix' );
/**
 * Filters the content to remove any extra paragraph or break tags
 * caused by shortcodes.
 *
 * @since 1.0.0
 *
 * @param string $content  String of HTML content.
 * @return string $content Amended string of HTML content.
 */

if ( ! function_exists( 'labora_sc_br_p_fix' ) ) {
	function labora_sc_br_p_fix( $content ) {
		$array = array(
        	'<p>['    => '[',
			']</p>'   => ']',
			']<br />' => ']',
    	);
		return strtr( $content, $array );
	}
}
