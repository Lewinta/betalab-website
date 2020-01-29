<?php
// T A B S G R O U P
//--------------------------------------------------------
if ( ! function_exists( 'labora_sc_tab_group' ) ) {
	function labora_sc_tab_group( $atts, $content = null, $code ) {
		extract(shortcode_atts( array(
			'tabtype'	=> '',
			'position'	=> '',
			'animation' => '',
		), $atts));

		$icons = $out = $customtabcolor = $customtabtextcolor = '';
		if ( $tabtype == 'vertabs' ) {
			$tabtype = 'vertabs';
		} else {
			$tabtype = 'hortabs';
		}
		switch ( $position ) {
			case'centertabs':
							$positiontype = 'centertabs';
							break;
			case'righttabs':
							$positiontype = 'righttabs';
							break;
			default:
							$positiontype = '';
		}

		if ( ! preg_match_all( "/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches ) ) {
			return do_shortcode( $content );
		} else {
			for ( $i = 0; $i < count($matches[0]); $i++ ) {
				$matches[3][ $i ] = shortcode_parse_atts( $matches[3][ $i ] );
			}

			// Animation Effects
			//--------------------------------------------------------
			$animation = $animation ? ' data-animation="' . $animation . '"' : '';
			$animation_class = $animation ? 'iva_anim':'';
			$out .= '<div ' . $animation . ' id="tab' . rand( 9, 1999 ) . '" class="' . $animation_class . ' systabspane ' . $tabtype . '">';
			$out .= '<ul  class="iva-tabs">';
			for ( $i = 0; $i < count( $matches[0] ); $i++ ) {
				if ( isset( $matches[3][ $i ]['tabcolor'] ) ) {
					if ( strpos( $matches[3][ $i ]['tabcolor'], '#' ) !== false ) {
						$customtabcolor = ' style="border-color:' . $matches[3][ $i ]['tabcolor'] . '"';
					}
				}
				if ( isset( $matches[3][ $i ]['textcolor'] ) ) {
					if ( strpos( $matches[3][ $i ]['textcolor'], '#') !== false ) {
						$customtabtextcolor = ' style="color:' . $matches[3][ $i ]['textcolor'] . '"';
					}
				}
				if ( isset( $matches[3][ $i ]['icon'] ) ) {
					$icons = $matches[3][ $i ]['icon'];
				}
				$out .= '<li class="' . $icons . '"  id="#' . $tabtype . $i . '" ' . $customtabcolor . '  ><a ' . $customtabtextcolor . ' href="#' . $tabtype . $i . '">' . $matches[3][ $i ]['title'] . '</a></li>';
			}
			$out .= '</ul>';
			$out .= '<div class="panes">';
			for( $i = 0; $i < count( $matches[0] ); $i++ ) {
				$out .= '<div  class="tab_content" id="' . $tabtype . $i . '" >' . do_shortcode( trim( $matches[5][ $i ] ) ) . '</div>';
			}
			$out .= '</div></div>';

			return $out;
		}
	}

	add_shortcode( 'tab', 'labora_sc_tab_group' );
	add_shortcode( 'minitabs', 'labora_sc_tab_group' );
}

	/* NavTabs Section
 	 *
	 */

	if ( !function_exists( 'labora_sc_tabs_container' ) )	{
		
		function labora_sc_tabs_container( $atts, $content = null, $code ) {

			extract( shortcode_atts( array(
				'animation' => '',
			), $atts));
			$icons = $out = $custombgcolor = $customtextcolor = '';
	        if ( ! preg_match_all("/(.?)\[(tab_section)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab_section\])?(.?)/s", $content, $matches) ) {
				return do_shortcode( $content );
	        } else {
				for( $i = 0; $i < count($matches[0]); $i++ ) {
					$matches[3][$i] = shortcode_parse_atts( $matches[3][$i] );
				}

				// Animation data attribute
				$animation = $animation ? ' data-animation="' . $animation . '"' : '';	
				$animation_class = $animation ? 'iva_anim':'';
				
				$out .= '<div '.$animation.' id="tabbed_section_'.rand(1,9).'" class="'. $animation_class .' iva_tabsContainer">';
				$out .= '<div class="iva_tabsWrap">';
				$out .= '<ul class="iva_tabNav">';

					for( $i = 0; $i < count( $matches[0] ); $i++ ) {
						// Generate Output
						$out .= '<li   id="#tab_section'.$i.'"><a  href="#tab_section'.$i.'">' . do_shortcode($matches[3][$i]['title']) . '</a></li>';

					}

				$out .= '</ul>';// .iva_tabNav
				$out .= '</div>';// .iva_tabsWrap

				$out .= '<div class="tab_sectionWrap">';
				for( $i = 0; $i < count( $matches[0] ); $i++ ) {

						if ( isset( $matches[3][$i]['bgcolor'] ) ) {
							if ( strpos($matches[3][$i]['bgcolor'], '#') !== false ) {
								$custombgcolor = ' style="background-color:'.$matches[3][$i]['bgcolor'].'"';
							}
						}
						//
						if ( isset( $matches[3][$i]['textcolor'] ) ) {
							if ( strpos($matches[3][$i]['textcolor'], '#') !== false ) {
								$customtextcolor = ' style="color:'.$matches[3][$i]['textcolor'].'"';
							}
						}
					
					$out .= '<div id="tab_section'.$i.'"><div class="tab_navContent" '.$custombgcolor.'>';
					$out .= '<div class="tab_sectionInner" '.$customtextcolor.'>';
					$out .= do_shortcode(trim($matches[5][$i]));
					$out .= '</div>';
					$out .= '</div></div>';
				}
				$out .= '</div></div>';
			       
				return $out;
			}
		}
		add_shortcode( 'tab_section', 'labora_sc_tabs_container' );
		add_shortcode( 'tabs_container', 'labora_sc_tabs_container' );
	}
	