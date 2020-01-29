<?php
// STAFF BOX
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_staff' ) ) {
	function labora_sc_staff( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'photo'			=> '',
			'title'			=> '',
			'role'			=> '',
			'delicious'		=> '',
			'digg'			=> '',
			'facebook'		=> '',
			'flickr'		=> '',
			'google'		=> '',
			'linkedin'		=> '',
			'pinterest'		=> '',
			'skype'			=> '',
			'stumbleupon'	=> '',
			'twitter'		=> '',
			'dribbble'		=> '',
			'yahoo'			=> '',
			'youtube'		=> '',
			'instagram'		=> '',
			'animation' 	=> '',
			'color'			=> 'black',
		), $atts));

		$person_social = array(
			'' => 'Select Sociable',
			'delicious'     => 'Delicious',
			'digg'          => 'Digg',
			'facebook'      => 'Facebook',
			'flickr'        => 'Flickr',
			'google'        => 'Goolge',
			'linkedin'      => 'Linkedin',
			'pinterest'     => 'Pinterest',
			'skype'         => 'Skype',
			'stumbleupon'   => 'Stumbleupon',
			'twitter'       => 'Twitter',
			'dribbble'      => 'Dribbble',
			'yahoo'         => 'Yahoo',
			'youtube'       => 'Youtube',
			'instagram'		=> 'instagram',
		);
		ksort( $person_social );//sort alphabetical order.

		$before_staff = $after_staff = $out = '';
		// Animation Effects
		//--------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';
		
		$out .= '<div ' . $animation . ' class="at-person-v6  '.$animation_class.' bio ">';
		if ( $photo != '' ) {
			$count = 0;
			$image_photo = labora_sc_resize( '',$photo,'','','','' );
			$out .= '<div class="at-person-v6-img">';
			$out .= $image_photo;
			foreach ( $person_social as $key => $value ) {
				if ( $key !='' ) {
					if ( $$key != '' ) {
						if ( $count < 1 ) {
							$before_staff = '<div class="at-person-v6-social">';
							$after_staff = '</div>';
						}
						$count++;
					}
				}
			}
			$out .= $before_staff;
			foreach ( $person_social as $key => $value ) {
				if ( $key != '' ) {
					if ( isset( $$key ) && $$key != '' ) {
						$out .= '<a class="' . $key . '" href="' . $$key . '"><i class="fa fa-' . $key . '"></i></a>';
					}
				}
			}
			$out .= $after_staff;
			$out .= '</div>';//.bio_thumb
		}

		if ( $title != '' ) {
			$out .= '<h4>' . $title . '</h4>';
			if ( $role != '' ) {
				$out .= '<h6 >' . $role . '</h6>';
			}
		}
		$out .= '</div><div class="clear"></div>';
		return $out;
	}
	add_shortcode( 'staff', 'labora_sc_staff' );
}
