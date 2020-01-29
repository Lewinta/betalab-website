<?php
// Logo Carousel
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_logocarousel' ) ) {
	function labora_sc_logocarousel( $atts, $content = null, $code ) {
		extract(shortcode_atts( array(
			'title'			=> '',
			'link'			=> '',
			'link_target'	=> '',
			'width'			=> '600',
			'height'		=> '450',
			'items' 		=> '3',
			'speed' 		=> '3000',
		), $atts));

		global $post;
		$out = $linktarget = $images = '';

		$jcarousel_id = rand( 10,99 );

		$out .= '<script>
		jQuery(document).ready(function($) {
			$("#owl-' . $jcarousel_id . '").owlCarousel({
				autoPlay: ' . $speed . ',
				pagination : false,
				items : ' . $items . ',
				itemsDesktop : [1199,4],
				itemsDesktopSmall : [1024,4],
				itemsTablet : [768,2],
				itemsMobile : [479,2]
			});
		});
		</script>';

		wp_enqueue_style( 'labora-sc-owl-style' );
		wp_enqueue_style( 'labora-sc-owl-theme' );

		$out .= '<div class="clientcarousel">';
		$out .= '<div id="owl-' . $jcarousel_id . '" class="owl-carousel">';
		if ( ! preg_match_all( "/(.?)\[(logo)\b(.*?)(?:(\/))?\](?:(.+?)\[\/logo\])?(.?)/s", $content, $matches ) ) {
			return do_shortcode( $content );
		} else {
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$matches[3][ $i ] = shortcode_parse_atts( $matches[3][ $i ] );
			}
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$linktarget = '';
				if ( isset( $matches[3][ $i ]['image'] ) ) {
					$images = $matches[3][ $i ]['image'];
				}
				if ( isset( $matches[3][ $i ]['link'] ) ) {
					$link = $matches[3][ $i ]['link'];
				}
				if ( isset( $matches[3][ $i ]['link_target'] ) ) {
					$link_target = $matches[3][ $i ]['link_target'];
					if ( 'true' == $link_target ) {
						$linktarget = 'target = "_blank"';
					}
				}
				if ( isset( $matches[3][ $i ]['title'] ) ) {
					$title = $matches[3][ $i ]['title'];
				}

				$out .= '<div class="clientthumb">';
				if ( $images != '' ) {
					$out .= '<a href="' . esc_url( $link ) . '" ' . $linktarget . '>';
					$out .= '<figure>' . labora_sc_resize( '', $images, $width, $height, '', '' ) . '</figure>';
					$out .= '</a>';
				}
				$out .= '<span class="cl-title">' . $title . '</span>';
				$out .= '</div>';
			}
		}
		$out .= '</div>';
		$out .= '</div>';
		wp_enqueue_script( 'labora-sc-owl-carousel' );
		wp_reset_postdata();
		return $out;
	}
	add_shortcode( 'logocarousel', 'labora_sc_logocarousel' );
	add_shortcode( 'logo', 'labora_sc_logocarousel' );
}
