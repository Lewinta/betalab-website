<?php
// CONTACT INFO
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_contact_info' ) ) {
	function labora_sc_contact_info( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'name'			=> '',
			'address'		=> '',
			'phone'			=> '',
			'email'			=> '',
			'website_name'	=> '',
			'website_url'   => '',
			'fax'           => '',
			'animation' 	=> '',
		), $atts));

		// Animation Effects
		//--------------------------------------------------------
		$animation = $animation ? ' data-animation="' . $animation . '"' : '';
		$animation_class = $animation ? 'iva_anim':'';

		$out = '<div ' . $animation . ' class="contactinfo-wrap  ' . $animation_class . ' ">';
		if ( $name ) {
			$out .= '<p class="contactinfo-title"><strong>' . $name . '</strong></p>';
		}
		if ( $address ) {
			$out .= '<p><i class="fa fa-map-marker fa-lg fa-fw"></i>';
			$out .= $address;
			$out .= '</p>';
		}
		if ( $phone ) {
			$out .= '<p><i class="fa fa-phone fa-lg fa-fw"></i>' . $phone . '</p>';
		}
		if ( $email ) {
			$out .= '<p><i class="fa fa-envelope fa-lg fa-fw"></i><a href="mailto:' . $email . '">' . $email . '</a></p>';
		}
		if ( $website_url ) {
			$out .= '<p><i class="fa fa-link fa-lg fa-fw"></i><a href="' . esc_url( $website_url ) . '">' . $website_name . '</a></p>';
		}
		if ( $fax ) {
			$out .= '<p><i class="fa fa-fax fa-lg fa-fw"></i>' . $fax . '</p>';
		}
		$out .= '</div>';
		return $out;
	}
	add_shortcode( 'contactinfo', 'labora_sc_contact_info' );
}
