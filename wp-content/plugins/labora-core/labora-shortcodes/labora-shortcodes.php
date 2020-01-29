<?php
/**
 * Name: Labora Shortcodes
 * URI: http://aivahthemes.net/
 * Description: A brief description of the plugin.
 */
//
define( 'LABORA_SC_DIR', LABORA_CORE_DIR . 'labora-shortcodes/shortcode' );
define( 'LABORA_SC_INC_DIR', LABORA_CORE_DIR . 'labora-shortcodes/includes/' );
define( 'LABORA_SC_JS_URI', LABORA_CORE_URI . 'labora-shortcodes/js/' );
define( 'LABORA_SC_CSS_URI', LABORA_CORE_URI . 'labora-shortcodes/css/' );
define( 'LABORA_SC_IMG_URI', LABORA_CORE_URI . 'labora-shortcodes/images/' );

if ( ! class_exists( 'Labora_shortcodes' ) ) {

	class Labora_shortcodes {

		public function  __construct() {
			$this->labora_sc_common();
			$this->labora_sc_shortcode_generator();
			$this->labora_sc_shortcodes();
		}

		/* Shortcodes  generator*/
		public function labora_sc_common(){
			require_once( LABORA_SC_INC_DIR . 'plugin_functions.php' );
			require_once( LABORA_SC_INC_DIR . 'image_resize.php' );
		}

		/* Shortcodes  generator*/
		public function labora_sc_shortcode_generator(){
			global $pagenow;
			if ( is_admin() && ( $pagenow =='post-new.php' || $pagenow =='post.php') ) {
				require_once( LABORA_SC_INC_DIR . 'shortcode-generator.php' );
		   }
		}

		/* Shortcodes */
		public function labora_sc_shortcodes() {
			require_once( LABORA_SC_DIR . '/at-fancy-box-image.php' );
			require_once( LABORA_SC_DIR . '/at-before-after.php' );
			require_once( LABORA_SC_DIR . '/at-table-sorting.php' );
			require_once( LABORA_SC_DIR . '/at-service-box.php' );
			require_once( LABORA_SC_DIR . '/at-image-icon-box.php' );
			require_once( LABORA_SC_DIR . '/at-accordion.php' );
			require_once( LABORA_SC_DIR . '/at-boxes.php' );
			require_once( LABORA_SC_DIR . '/at-blog.php' );
			require_once( LABORA_SC_DIR . '/at-buttons.php' );
			require_once( LABORA_SC_DIR . '/at-contact-info.php' );
			require_once( LABORA_SC_DIR . '/at-flickr.php' );
			require_once( LABORA_SC_DIR . '/at-general.php' );
			require_once( LABORA_SC_DIR . '/at-feature-box.php' );
			require_once( LABORA_SC_DIR . '/at-image.php' );
			require_once( LABORA_SC_DIR . '/at-layout.php' );
			require_once( LABORA_SC_DIR . '/at-lightbox.php' );
			require_once( LABORA_SC_DIR . '/at-tabs-toggles.php' );
			require_once( LABORA_SC_DIR . '/at-sociable.php' );
			require_once( LABORA_SC_DIR . '/at-videos.php' );
			require_once( LABORA_SC_DIR . '/at-staff.php' );
			require_once( LABORA_SC_DIR . '/at-services.php' );
			require_once( LABORA_SC_DIR . '/at-icon-box.php' );
			require_once( LABORA_SC_DIR . '/at-message-boxes.php' );
			require_once( LABORA_SC_DIR . '/at-progress-circle.php' );
	        require_once( LABORA_SC_DIR . '/at-progress-bar.php' );
			require_once( LABORA_SC_DIR . '/at-partial-section.php' );
			require_once( LABORA_SC_DIR . '/at-gallery.php' );
			require_once( LABORA_SC_DIR . '/at-expandable.php' );
			require_once( LABORA_SC_DIR . '/at-logo-carousel.php' );

			// Aditional shortcodes require only if post type exist
			global $wp_post_types;

			$testimonial_type = post_type_exists( 'testimonial_type' );
			if ( $testimonial_type = true ) {
				require_once( LABORA_SC_DIR . '/at-testimonials.php' );
			}
		}

		public function labora_sc_get_vars( $type = null, $taxonomy = null ) {
			$iva_terms = array();

			global $wp_post_types;

			$iva_testimonials = post_type_exists( 'testimonialtype' );

			switch ( $type ) {
				case 'pages': // Get Page Titles
					$iva_entries = get_pages( 'sort_column=post_parent,menu_order' );
					if ( ! empty( $iva_entries ) && ! is_wp_error( $iva_entries ) ) {
						foreach ( $iva_entries as $ivaPage ) {
							$iva_terms[ $ivaPage->ID ] = $ivaPage->post_title;
						}
					}
					break;

				case 'slider': // Get Slider Slug and Name
						$iva_entries = get_terms( 'slider_cat', 'orderby=name&hide_empty=1' );
					if ( ! empty( $iva_entries ) && ! is_wp_error( $iva_entries ) ) {
						foreach ( $iva_entries as $ivaSlider ) {
							$iva_terms[ $ivaSlider->slug ] = $ivaSlider->name;
						}
					}
					break;

				case 'posts': // Get Posts Slug and Name
					$iva_entries = get_categories( 'hide_empty=1' );
					if ( ! empty( $iva_entries ) && ! is_wp_error( $iva_entries ) ) {
						foreach ( $iva_entries as $ivaPosts ) {
							$iva_terms[ $ivaPosts->slug ] = $ivaPosts->name;
						}
					}
					break;

				case 'categories': //categories slug and name
						$iva_entries = get_categories( 'hide_empty=true' );
						if ( ! empty( $iva_entries ) && ! is_wp_error( $iva_entries ) ) {
							foreach ($iva_entries as $iva_posts) {
								$iva_terms[ $iva_posts->term_id ] = $iva_posts->name;
							}
						}
					break;

				case 'testimonial': // Get Testimonial Slug and Name
					if ( $iva_testimonials = true ) {
						$iva_entries = get_terms( 'testimonial_cat', 'orderby=name&hide_empty=1' );
						if ( ! empty( $iva_entries ) && ! is_wp_error( $iva_entries ) ) {
							foreach ( $iva_entries as $ivaTestimonial ) {
								$iva_terms[ $ivaTestimonial->slug ] = $ivaTestimonial->name;
							}
						}
					}
					break;

				case 'tags': // Get Taxonomy Tags
					$iva_entries = get_tags( array( 'taxonomy' => 'post_tag' ) );
					if ( ! empty( $iva_entries ) && ! is_wp_error( $iva_entries ) ) {
						foreach ( $iva_entries as $ivaTags ) {
							$iva_terms[ $ivaTags->slug ] = $ivaTags->name;
						}
					}
					break;

				case 'taxonomy': // Get Custom Post Categories Slug and Name
					$iva_entries = get_terms( $taxonomy, 'orderby=name&hide_empty=0' );
					if ( ! empty( $iva_entries ) && ! is_wp_error( $iva_entries ) ) {
						foreach ( $iva_entries as $ivaTaxonomies ) {
							$iva_terms[$ivaTaxonomies->slug] = $ivaTaxonomies->name;
						}
					}
					break;

				case 'gallery': // Get Slider Slug and Name
						$iva_entries = get_terms( 'gallery_category', 'orderby=name&hide_empty=1' );
					if ( ! empty( $iva_entries ) && ! is_wp_error( $iva_entries ) ) {
						foreach ( $iva_entries as $ivaGallery ) {
							$iva_terms[ $ivaGallery->slug ] = $ivaGallery->name;
						}
					}
					break;
			}
			return $iva_terms;
		}
	}
	$labora_sc_obj = new Labora_shortcodes();
}


/**
 * register and enqueue scripts & styles for short codes
 */

if ( ! function_exists( 'labora_sc_admin_scripts' ) ) {

	function labora_sc_admin_scripts() {

		wp_enqueue_media();

		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'labora-sc-magnific-popup', LABORA_SC_JS_URI . 'admin/magnific-popup.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'labora-sc-plugin-shortcode',LABORA_SC_JS_URI . 'admin/shortcode.js' );
		wp_enqueue_script( 'labora-sc-script',LABORA_SC_JS_URI . 'admin/shortcode_script.js' );
		wp_enqueue_script( 'labora-sc-upload', LABORA_SC_JS_URI . 'admin/shortcode_upload.js', array( 'jquery', 'thickbox' ) );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'labora-sc-magnific-popup', LABORA_SC_CSS_URI . 'admin/magnific-popup.css', false, false, 'all' );
		wp_enqueue_style( 'labora-sc-shortcode-admin', LABORA_SC_CSS_URI . 'admin/shortcode_admin.css' );
	}
	add_action( 'admin_enqueue_scripts', 'labora_sc_admin_scripts' );
}

/**
 * register and enqueue scripts & styles for short codes
 */

if ( ! function_exists( 'labora_sc_frontend_scripts' ) ) {
	function labora_sc_frontend_scripts() {

		$protocol = is_ssl() ? 'https' : 'http';

		wp_register_script( 'progresscircle', LABORA_SC_JS_URI . 'frontend/jquery.easy-pie-chart.js', 'jquery','','in_footer' );
		wp_register_script( 'excanvas', LABORA_SC_JS_URI . 'frontend/excanvas.js', array( 'jquery' ),'','in_footer' );

		if ( ! wp_script_is( 'labora-sc-countTo', $list = 'registered' ) ) {
			wp_register_script( 'labora-sc-countTo', LABORA_SC_JS_URI . 'frontend/jquery.countTo.js', array( 'jquery' ),'1.0','in_footer' );
		}

		if ( ! wp_script_is( 'labora-sc-appear', $list = 'registered' ) ) {
			wp_register_script( 'labora-sc-appear',  LABORA_SC_JS_URI . 'frontend/jquery.appear.js', array( 'jquery' ),'1.0','in_footer' );
		}
	    wp_enqueue_script( 'labora-sc-easing', LABORA_SC_JS_URI . 'frontend/jquery.easing.1.3.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'labora-sc-sticky', LABORA_SC_JS_URI . 'frontend/jquery.sticky.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'labora-sc-script', LABORA_SC_JS_URI . 'frontend/sc_script.js', array( 'jquery' ), '', true );
		wp_register_style( 'labora-sc-shortcodes', LABORA_SC_CSS_URI . 'frontend/plugin_shortcodes.css', '', 'null', 'all' );
		wp_enqueue_style( 'labora-sc-animation', LABORA_SC_CSS_URI . 'frontend/animate.css' );

		wp_register_script( 'labora-sc-owl-carousel', LABORA_SC_JS_URI . 'frontend/owl.carousel.js',  array( 'jquery' ), '', 'in_footer' );
		wp_register_style( 'labora-sc-owl-style', LABORA_SC_CSS_URI . 'frontend/owl.carousel.css', array(), '1', 'all' );
		wp_register_style( 'labora-sc-owl-theme', LABORA_SC_CSS_URI . 'frontend/owl.theme.css', array(), '1', 'all' );
		wp_register_script( 'eventmove', LABORA_SC_JS_URI . 'frontend/jquery.event.move.js', '', '', 'in_footer' );
		wp_register_script( 'twenty-twenty', LABORA_SC_JS_URI . 'frontend/jquery.twentytwenty.js', '', '', 'in_footer' );
		wp_register_script( 'table-sorter', LABORA_SC_JS_URI . 'frontend/jquery.tablesorter.min.js', '', '', 'in_footer' );

		if ( ! wp_style_is( 'font-awesome', $list = 'enqueued' ) ) {
			wp_enqueue_style( 'font-awesome', LABORA_SC_CSS_URI . 'fontawesome/css/font-awesome.min.css', array(), false, 'all' );
		}
		wp_enqueue_style( 'pe-icon-7-stroke', LABORA_SC_CSS_URI . 'pe-icon-7-stroke/css/pe-icon-7-stroke.css' );
		wp_enqueue_style( 'labora-sc-shortcodes' );
		wp_enqueue_script( 'waypoints',LABORA_SC_JS_URI . 'frontend/waypoints.js' );

		global $post;

		if ( ! $post ) return false;

		$post_content = $post->post_content;

		if (
			is_a( $post, 'WP_Post' ) &&
			( has_shortcode( $post->post_content, 'blog_carousel') || has_shortcode( $post->post_content, 'testimonials') )
		) {
			wp_enqueue_script( 'labora-sc-owl-carousel' );
			wp_enqueue_style( 'labora-sc-owl-style' );
			wp_enqueue_style( 'labora-sc-owl-theme' );
		}
		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'counter') ) {
			wp_enqueue_script( 'labora-sc-countTo' );
			wp_enqueue_script( 'labora-sc-appear' );
		}

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'twenty_twenty') ) {
			wp_enqueue_script( 'eventmove' );
			wp_enqueue_script( 'twenty-twenty' );
		}

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'vacant_table') ) {
			wp_enqueue_script( 'table-sorter' );
		}
		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'image') ) {
			wp_enqueue_script( 'prettyPhoto', LABORA_SC_JS_URI . 'frontend/jquery.prettyPhoto.js','','',true );
			wp_enqueue_style( 'prettyphoto', LABORA_SC_CSS_URI . 'frontend/prettyPhoto.css', array(), '', false );
		}

	}
	add_action( 'wp_enqueue_scripts', 'labora_sc_frontend_scripts' );
}

if ( ! function_exists( 'labora_sc_enqueue_script_counter' ) ) {
	add_action( 'iva_enqueue_counter', 'labora_sc_enqueue_script_counter' );
	function labora_sc_enqueue_script_counter() {
		wp_enqueue_script( 'labora-sc-countDown', LABORA_SC_JS_URI . 'frontend/jquery.countdown.min.js', 'jquery','1.0','in_footer' );
	}
}

if ( ! function_exists( 'aivah_hex2rgb' ) ) {
	function aivah_hex2rgb( $hex ) {
		$hex = str_replace( '#', '', $hex );

		if ( strlen( $hex ) == 3) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = array( $r, $g, $b );
		return $rgb;
	}
}

if ( ! function_exists( 'labora_sc_buttons' ) ) {
	add_action( 'media_buttons', 'labora_sc_buttons', 11 );
	function labora_sc_buttons() {
		echo '<a class="button button-primary iva-event-shortcode-generator" href="#labora-sc-generator"><img src="' . esc_url( LABORA_SC_IMG_URI . 'plugin-icon.png' ) . '" />' . esc_html__( 'Labora Shortcodes', 'labora_shortcodes' ) . '</a>';
	}
}
if ( ! function_exists( 'labora_sc_get_attachment_id_from_src' ) ) {
	function labora_sc_get_attachment_id_from_src ( $image_src ) {
        global $wpdb;
        $id = $wpdb->get_var( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid = %s", $image_src ) );
        return $id;
    }
}
add_filter( 'the_content', 'labora_pre_process_shortcode' );
add_filter( 'widget_text', 'do_shortcode' );
if ( ! function_exists( 'labora_pre_process_shortcode' ) ) {
	function labora_pre_process_shortcode( $content ) {

		global $shortcode_tags;

		$labora_shortcode = array();

		foreach ( $shortcode_tags as $key => $value ) {
			if ( is_string( ( $value ) ) ) {
				if ( stristr( $value, 'labora_sc' ) ) {
					$labora_shortcode[ $key ] = $key;
				}
			}
		}
		$labora_block = join( '|',$labora_shortcode );

		// Opening tag
		$labora_output = preg_replace( '/(<p>)?\[( $labora_block )(\s[^\]]+)?\](<\/p>|<br \/>)?/','[$2$3]',$content );
		// Closing tag
		$labora_output = preg_replace( '/(<p>)?\[\/( $labora_block )](<\/p>|<br \/>)?/','[/$2]',$labora_output );

		return $labora_output;
	}
}
