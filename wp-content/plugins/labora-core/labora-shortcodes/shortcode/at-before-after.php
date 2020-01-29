<?php
// Twenty Twenty
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_twenty_twenty' ) ) {
	function labora_sc_twenty_twenty( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'before_image'		=> '',
			'after_image'		=> '',
			'width'				=> '',
			'height'			=> '',
			'animation'			=> '',
		), $atts));

		$before_image = labora_get_attachment_id_from_src( $before_image );
		$after_image = labora_get_attachment_id_from_src( $after_image );
		$width = $width ? $width : '800';
		$height = $height ? $height : '300';

		$out = '<script>
		jQuery(document).ready(function($) {
			jQuery(window).load(function($){
				jQuery(".twentytwenty-container[data-orientation!=horizontal]").twentytwenty({default_offset_pct: 0.6});
			});
		});
		</script>';

		// Animation Effects
		//--------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';
		$out .= '<div class="twentytwenty-container  ' . $animation_class . '" ' . $animation . '>';
		$out .= '<figure>' . wp_get_attachment_image( $before_image, array( $width, $height ), '', array( 'class' => 'image' ) ) . '</figure>';
		$out .= '<figure>' . wp_get_attachment_image( $after_image, array( $width, $height ), '', array( 'class' => 'image' ) ) . '</figure>';
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'twenty_twenty', 'labora_sc_twenty_twenty' );
}
