<?php
	// S E R V I C E S
	//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_services_contents' ) ) {
	function labora_sc_services_contents( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'image'		=> '',
			'title'		=> '',
			'desc'		=> '',
			'link'		=> '',
			'width'		=> '640',
			'height'	=> '640',
			'animation'	=> '',
		), $atts));

		// Animation Effects
		//--------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim' : '';

		$out = '<div ' . $animation . ' class="iva-services ' . $animation_class . '">';
		if ( $image != '' ) {

			$out .= '<div class="service-img">';
			if ( $link != '' ) {
				$out .= '<a href="' . esc_url( $link ) . '" target="_blank">';
				$out .= '<figure><img src="' . $image . '" width="' . $width . '" height="' . $height . '" alt=""></figure>';
				$out .= '<span class="imgoverlay"></span>';
				$out .= '</a >';} else {
				$out .= '<figure><img src="' . $image . '" width="' . $width . '" height="' . $height . '" alt=""></figure>';
				$out .= '<span class="imgoverlay"></span>';
			}
				$out .= '</div>';

			if ( $title != '' || $link != '' || $desc !='' ) {
				$out .= '<div class="cs-title">';
				if ( $title != '' || $link != '' ){	
					$out .= '<h2><a href="'.esc_url($link).'" targrt="_blank">'.$title.'</a></h2>'; 
				}

				if( $desc !='' ){ 
					$out .= '<p>'.$desc.'</p>'; 
				}

				$out .= '</div>';
			}
		}
		
		$out .= '</div>';
	
		return $out;
	}
	add_shortcode('services', 'labora_sc_services_contents');
 }
?>
