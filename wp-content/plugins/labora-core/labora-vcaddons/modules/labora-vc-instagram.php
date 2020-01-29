<?php
/*
* Add-on Name: instagram for Visual Composer
*/
if ( ! class_exists( 'Labora_VC_Instagram' ) ) {
	class Labora_VC_Instagram {
		// constructor
		function __construct() {
			add_action( 'init', array( $this, 'labora_vc_instagram_init' ) );
			add_shortcode( 'labora_vc_instagram', array( $this, 'labora_vc_instagram_shortcode' ) );
		}

		// initialize the mapping function
		function labora_vc_instagram_init( $instance ) {
			if ( function_exists( 'vc_map' ) ) {
				vc_map(
					array(
					   'name' 	=> esc_html__( 'Instagram','labora-vc-textdomain' ),
					   'base' 	=> 'labora_vc_instagram',
					   'class' 	=> '',
					   'icon' 	 => LABORA_VC_ADDON_URL . 'assets/images/aivah_vc_icon.png',
					   'category' => 'Labora VC Addons',
					   'description' => esc_html__( 'instagram Categories', 'labora-vc-textdomain' ),
					   'params' => array(
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Instagram Title', 'labora-vc-textdomain' ),
								'param_name'  => 'title',
								'description' => esc_html__( 'Enter the title you wish to display for the instagram.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'holder' 	  => 'div',
								'class'		  => '',
								'heading'     => esc_html__( 'Username', 'labora-vc-textdomain' ),
								'param_name'  => 'username',
								'description' => esc_html__( 'Enter instagram Username.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Number of photos', 'labora-vc-textdomain' ),
								'param_name'  => 'limit',
								'description' => esc_html__( 'Enter Number of photos to display for Instagram.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'holder' 	  => 'div',
								'class'		  => '',
								'heading'     => esc_html__( 'Description', 'labora-vc-textdomain' ),
								'param_name'  => 'desc',
								'description' => esc_html__( 'Enter Description for Instagram.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Instagram Link', 'labora-vc-textdomain' ),
								'param_name'  => 'i_link',
								'description' => esc_html__( 'Enter Instagram Link for Instagram.', 'labora-vc-textdomain' ),
							),
							array(
								'type' 		  => 'textfield',
								'class'		  => '',
								'heading'     => esc_html__( 'Link Text', 'labora-vc-textdomain' ),
								'param_name'  => 'link_text',
								'description' => esc_html__( 'Enter Link Text for Instagram.', 'labora-vc-textdomain' ),
							),
						),
					)
				);
			}
		}
		function labora_vc_instagram_shortcode( $atts, $args, $instance ) {
			extract( shortcode_atts( array(
				'title'		=> '',
				'desc'		=> '',
				'username'	=> 'envato',
				'limit'		=> '5',
				'number'	=> '',
				'class'		=> '',
				'imgclass'	=> '',
				'target'	=> '_blank',
				'link'      => '',
				'i_link'	=> '',
				'link_text'	=> '',
			), $atts ) );

			$out = '';
			$out .= '<div class="labora_instagram__inner">';
			$out .= '<div class="labora_instagram__content">';
			$out .= '<div class="col-sm-12">';
			$out .= '<i class="fa fa-instagram fa-5x"></i>';
			if ( ! empty( $title ) ) {
				$out .= '<h2 class="labora_instagram_title">' . $title . '</h2>';
			}
			$out .= '<p class="labora_instagram_desc">' . $desc . '<a class="text-white" href="' . esc_url( $i_link ) . '" target="' . esc_attr( $target ) . '">' . $link_text . '</a></p>';
			$out .= '</div>';
			$out .= '</div>';
			$out .= '</div>';

			if ( $username != '' ) {
				$media_array = $this->labora_vc_scrape_instagram( $username, $limit );
				if ( is_wp_error( $media_array ) ) {
					$out .= wp_kses_post( $media_array->get_error_message() );
				} else {
					// filter for images only?
					if ( $images_only = apply_filters( 'wpiw_images_only', 'false' ) ) {
						$media_array = array_filter( $media_array, array( $this, 'images_only' ) );
						$out .= '<ul class="labora_instagram">';
						foreach ( $media_array as $item ) {
							$out .= '<li class="one_fifth">
							<a href="' . esc_url( $item['link'] ) . '" target="' . esc_attr( $target ) . '"  class="' . esc_attr( $class ) . '">
							<img src="' . esc_url( $item['large'] ) . '"  alt="' . esc_attr( $item['description'] ) . '" title="' . esc_attr( $item['description'] ) . '"  class="' . esc_attr( $imgclass ) . '"/>
							</a>
							</li>';
						}
						$out .= '</ul>';
					}
					if ( $link != '' ) {
						$out .= '<p class="clear"><a href="//instagram.com/' . esc_attr( trim( $username ) ) . '" rel="me" target="' . esc_attr( $target ) . '">' . wp_kses_post( $link ) . '</a></p>';
					}
				}
				return $out;
			}
		}

		function labora_vc_scrape_instagram( $username, $slice = 9 ) {

			$username = strtolower( $username );
			$username = str_replace( '@', '', $username );

			if ( false === ( $instagram = get_transient( 'instagram-m7-' . sanitize_title_with_dashes( $username ) ) ) ) {
				$remote = wp_remote_get( 'http://instagram.com/' . trim( $username ) );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'labora-vc-textdomain' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'labora-vc-textdomain' ) );
				}

				$shards = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json = explode( ';</script>', $shards[1] );
				$insta_array = json_decode( $insta_json[0], true );

				if ( ! $insta_array ) {
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'labora-vc-textdomain' ) );
				}
				if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
					$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
				} else {
					return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'labora-vc-textdomain' ) );
				}

				if ( ! is_array( $images ) ) {
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'labora-vc-textdomain' ) );
				}
				$instagram = array();

				foreach ( $images as $image ) {

					$image['thumbnail_src'] = preg_replace( '/^https:||http:/i', '', $image['thumbnail_src'] );
					$image['large'] = $image['thumbnail_src'];
					$image['display_src'] = preg_replace( '/^https:||http:/i', '', $image['display_src'] );

					if ( $image['is_video'] == true ) {
						$type = 'video';
					} else {
						$type = 'image';
					}

					$caption = esc_html__( 'Instagram Image', 'labora-vc-textdomain' );
					if ( ! empty( $image['caption'] ) ) {
						$caption = $image['caption'];
					}

					$instagram[] = array(
						'description'   => $caption,
						'link'		  	=> '//instagram.com/p/' . $image['code'],
						'time'		  	=> $image['date'],
						'comments'	  	=> $image['comments']['count'],
						'likes'		 	=> $image['likes']['count'],
						'large'			=> $image['large'],
						'original'		=> $image['display_src'],
						'type'		  	=> $type,
					);
				}
				// do not set an empty transient - should help catch private or empty accounts
				if ( ! empty( $instagram ) ) {
					$instagram = base64_encode( serialize( $instagram ) );
					set_transient( 'instagram-m7-' . sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
				}
			}

			if ( ! empty( $instagram ) ) {
				$instagram = unserialize( base64_decode( $instagram ) );
				return array_slice( $instagram, 0, $slice );
			} else {
				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'labora-vc-textdomain' ) );
			}
		}

		function images_only( $media_item ) {
			if ( $media_item['type'] == 'image' ) {
				return true;
			}
			return false;
		}
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {

	if ( class_exists( 'Labora_VC_Instagram' ) ) {
		$labora_instagram = new Labora_VC_Instagram;
	}
	class WPBakeryShortCode_labora_instagram extends WPBakeryShortCode {
	}
}
