<?php
/*
* Add-on Name: at_Google_Map for Visual Composer
*/
if ( ! class_exists( 'Labora_vc_Google_Map' ) ) {
	class Labora_vc_Google_Map {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_google_map_init' ) );
			add_shortcode( 'labora_google_map', array( $this, 'labora_vc_google_map_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'labora_vc_gmap_script' ), 1 );
		}

		function labora_vc_gmap_script() {
			wp_register_script( 'labora-owl-carousel', LABORA_VC_ADDON_URL . 'assets/js/owl.carousel.js','jquery','','in_footer' );
			wp_enqueue_style( 'labora-owl-style', LABORA_VC_ADDON_URL . 'assets/css/owl.carousel.css', false, false, 'all' );
			wp_enqueue_style( 'labora-owl-theme', LABORA_VC_ADDON_URL . 'assets/css/owl.theme.css', false, false, 'all' );
			$labora_google_api_key = get_option( 'labora_google_api_key' );
			if ( $labora_google_api_key ) {
				wp_enqueue_script( 'labora-gmap',  '//maps.googleapis.com/maps/api/js?v=3.exp&key=' . get_option( 'labora_google_api_key' ) . '&libraries=places','jquery','','' );
			}
		}

		// Initialize the mapping function
		function labora_vc_google_map_init() {
			if ( function_exists( 'vc_map' ) ) {

				vc_map(	array(
					'name'                    => esc_html__( 'Google Map', 'labora-vc-textdomain' ),
					'base'                    => 'labora_google_map',
					'as_parent'               => array( 'only' => 'labora_vc_gmap_address' ),
					'content_element'		  => true,
					'show_settings_on_create' => false,
					'icon' 					  => LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					'category'                => esc_html__( 'Labora VC Addons', 'labora-vc-textdomain' ),
					'params'                  => array(
					array(
						'type'        => 'textfield',
							'heading'     => esc_html__( 'Map Height', 'labora-vc-textdomain' ),
							'param_name'  => 'map_height',
							'value'       => '',
							'description' => esc_html__( 'Enter map height in px. Without height the map will not work', 'labora-vc-textdomain' ),
						),
					array(
							'type'       => 'textfield',
							'heading'    => esc_html__( 'Map Zoom', 'labora-vc-textdomain' ),
							'param_name' => 'map_zoom',
							'value'      => 11,
						),
					array(
							'type'       => 'attach_image',
							'heading'    => esc_html__( 'Marker Image', 'labora-vc-textdomain' ),
							'param_name' => 'marker',
						),
					array(
							'type'       => 'checkbox',
							'param_name' => 'disable_mouse_whell',
							'value'      => array(
								esc_html__( 'Disable map zoom on mouse wheel scroll', 'labora-vc-textdomain' ) => 'disable',
							),
						),
					array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Extra class name', 'labora-vc-textdomain' ),
							'param_name'  => 'el_class',
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'labora-vc-textdomain' ),
						),
					array(
							'type'       => 'css_editor',
							'heading'    => esc_html__( 'Css', 'labora-vc-textdomain' ),
							'param_name' => 'css',
							'group'      => esc_html__( 'Design options', 'labora-vc-textdomain' ),
						),
					),
					'js_view' => 'VcColumnView',
					)
				);
			}
		}

		function labora_vc_google_map_shortcode( $atts, $content ) {
			extract(shortcode_atts( array(
				'title'	=> '',
				'css'	=> '',
				'map_height' => '',
				'map_zoom' => '',
				'marker' => '',
				'disable_mouse_whell' => '',
				'el_class' => '',
			), $atts ) );
				$gmap_id = uniqid( 'at-gmap-' );
				$map_id = uniqid( 'map_' );
				$owl_id     = uniqid( 'owl_' );
				$owl_nav_id = uniqid( 'owl-nav-' );
				$output = '';
			if (  empty( $marker ) ) {
						$marker = LABORA_VC_ADDON_URL . 'assets/images/gmap_marker.png';
			} else {
					$marker = wp_get_attachment_image_url( $marker, 'full' );
			}
				$output .= '<script type="text/javascript">
				jQuery(document).ready(function($) {
					var owl = jQuery("#at_' . $owl_id . '");
					owl.owlCarousel({
						pagination :true,
						touchDrag: true,
						items : 3,
						animateOut: "slideOutUp",
					    animateIn: "slideInUp",
						addClassActive : true,
						afterAction: function () {
							labora_setMarkers();
						}
					});
					function labora_setMarkers(){
					var locations = [];
					var owl = jQuery("#at_' . $owl_id . '");
				    owl.find(".owl-item.active").each(function (i) {
					locations.push([parseFloat($(this).find(".item").data("lat")), parseFloat($(this).find(".item").data("lang")), $(this).find(".item").data("title"), $(this).find(".item").data("address")]);
					});
						var loc_length = locations.length;
						var loc_lat = locations[0][0];
						var loc_lng = locations[0][1];
						var map = new google.maps.Map(document.getElementById( "' . $gmap_id . '" ), {
							zoom: ' . esc_js( $map_zoom ) . ',
							scrollwheel: " ' . esc_js( $disable_mouse_whell ) . ' ",
							zoomControlOptions: {
								position: google.maps.ControlPosition.LEFT_TOP
							},

						  center: new google.maps.LatLng( loc_lat, loc_lng ),
						  mapTypeId: google.maps.MapTypeId.ROADMAP
						});
						var infowindow = new google.maps.InfoWindow();
						var marker, i;
						for (i = 0; i < locations.length; i++) {
							loc = new google.maps.LatLng( locations[i][0], locations[i][1] );
							var infocontent = "" ;
							marker = new google.maps.Marker({
								position: new google.maps.LatLng( locations[i][0], locations[i][1]),
								map: map,
								icon : "' . esc_url( $marker ) . '"
							});
							google.maps.event.addListener(marker, "mouseover", (function(marker, i) {
								return function() {
							  infowindow.setContent( locations[i][2] + "<br>" +  locations[i][3] );
							  infowindow.open(map, marker);
							}
						  })(marker, i));
						google.maps.event.addListener(marker, "mouseout", (function(marker, i) {
							  return function() {
							infowindow.setContent( locations[i][2] + "<br>" +  locations[i][3] );
							infowindow.close(map, marker);
						  }
						})(marker, i));
						 infocontent = locations[i][2] + "<br>" +  locations[i][3]
						  markercontent( marker, infocontent );
						}
					function markercontent(marker, title ) {
					var infowindow = new google.maps.InfoWindow({
						content: title
					});
					jQuery(".item").on("mouseenter", function() {

					  if( marker.getPosition().lat() == $(this).data("lat" ) ) {
								infowindow.open(" ' . esc_js( $map_id ) . ' ", marker );
						}
					});
					jQuery(".item").on("mouseleave", function() {

					  if( marker.getPosition().lat() == $(this).data("lat" ) ) {
								infowindow.close(" ' . esc_js( $map_id ) . ' ", marker );
						}
					});
					}
				    }
				});
				</script>';

				$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
			if ( $title ) {
					$output .= '<h1>' . $title . '</h1>';
			}
			if ( ! empty( $content ) ) {
					$output .= '<div id="' . esc_attr( $map_id ) . '" class="at_gmap_container' . esc_attr( $css_class ) . '">';
					$output .= '<div id="' . esc_attr( $gmap_id ) . '" class="at_gmap" style="width:100%; height:' . $map_height . '"></div>';
					$output .= '</div>';

					$output .= '<div class="at_gmap_address-wrap">';
					$output .= '<div class="inner">';

					$output .= '<div class="at_addrs owl-carousel" id="at_' . esc_attr( $owl_id ) . '">';
					$output .= wpb_js_remove_wpautop( $content );
					$output .= '</div>';//. addresses

					$output .= '<div class="owl-dots-wr">';
					$output .= '<div class="owl-dots" id="' . esc_attr( $owl_nav_id ) . '"></div>';
					$output .= '</div>';

					$output .= '</div>';//.inner
					$output .= '</div>';//.at_gmap_address-wrap
			}

				return $output;
		} //.labora_vc_Google_Map_shortcode
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_vc_Google_Map' ) ) {
		$labora_vc_google_map = new Labora_vc_Google_Map;
	}
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_labora_google_map extends WPBakeryShortCodesContainer {
		}
	}
}
