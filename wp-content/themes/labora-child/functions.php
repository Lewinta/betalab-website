<?php
function labora_child_scripts( $file ) {
	$child_file = str_replace( get_template_directory_uri(), get_stylesheet_directory_uri(), $file );
	return( $child_file );
}
/**
 * Enqueue the files in child theme
 * If you wish to change any js file or css file then use 'labora_child_scripts' function for that specific file and place it in relevant folder.
 * for eg:wp_register_script('iva-countTo', labora_child_scripts(THEME_JS . '/jquery.countTo.js'), 'jquery','1.0','in_footer'); 
 */
function labora_child_require_file( $file ) {
	$child_file = str_replace( get_template_directory(), get_stylesheet_directory(), $file );
	if ( file_exists( $child_file ) ) {
		return( $child_file );
	} else {
		return( $file );
	}
}
/**
 * Register and enqueue scripts.
 */
if ( ! function_exists( 'labora_theme_enqueue_scripts' ) ) {
	function labora_theme_enqueue_scripts() {

		$labora_theme_data	= wp_get_theme();
		$labora_theme_version = $labora_theme_data->get( 'Version' );

		global $post;

		// Enqueue scripts.
		wp_enqueue_script( 'hoverintent', LABORA_THEME_JS . '/hoverIntent.js',array( 'jquery' ),'', true );
		wp_enqueue_script( 'superfish', LABORA_THEME_JS . '/superfish.js',array( 'jquery' ),'',true );

		if ( is_singular( 'gallery' ) || ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'gallery' ) )  || is_page_template( 'template-blog.php' ) ) {
			wp_enqueue_script( 'prettyphoto', LABORA_THEME_JS . '/jquery.prettyPhoto.js','','',true );
			wp_enqueue_style( 'prettyphoto', LABORA_THEME_CSS . '/prettyPhoto.css', array(), $labora_theme_version, false );
		}
		wp_enqueue_script( 'labora-customjs', LABORA_THEME_JS . '/labora-custom.js', array( 'jquery' ), $labora_theme_version , true );

		// AJAX URL
		$labora_data['ajaxurl'] = admin_url( 'admin-ajax.php' );

		// HOME URL
		$labora_data['home_url'] = get_home_url();

		// Directory URI
		$labora_data['directory_uri'] = get_template_directory_uri();

		// Pass data to javascript
		$labora_params = array(
			'l10n_print_after' => 'labora_localize_script_param = ' . wp_json_encode( $labora_data ) . ';',
		);
		wp_localize_script( 'jquery', 'labora_localize_script_param', $labora_params );

		/**
		 * enqueue styles.
		 */
		wp_enqueue_style( 'labora_parent_style', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'labora_child_style',
		    get_stylesheet_directory_uri() . '/style.css',
		    array('labora_parent_style')
		);
		wp_enqueue_style( 'font-awesome', LABORA_THEME_CSS . '/fontawesome/css/font-awesome.min.css' );
		wp_enqueue_style( 'labora-responsive', LABORA_THEME_CSS . '/responsive.css',$labora_theme_version, 'all' );
	}
	add_action( 'wp_enqueue_scripts','labora_theme_enqueue_scripts' );
}

function wpb_hook_javascript() {
	if (is_page ('Validate Result')) { 
	  ?>
		<script type="text/javascript">
			window.mobileCheck = function() {
  				let check = false;
  				(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
  				return check;
			};

		var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = decodeURIComponent(window.location.search.substring(1)), sURLVariables = sPageURL.split('&'), sParameterName, i;
			for (i = 0; i < sURLVariables.length; i++) { 
				sParameterName = sURLVariables[i].split('='); 
				if (sParameterName[0] === sParam) { 
					return sParameterName[1] === undefined ? true : sParameterName[1]; 
				} 
			} 
		};
		var url_key_code = getUrlParameter('key_code');
		if (url_key_code != null) { 
			setTimeout(() => {
				document.getElementById('key_code').value = url_key_code; 

				// Let's add action to the validate btn

				let btn = document.getElementById('validate-result-btn');
				btn.addEventListener('click', () => {
					const key_code = document.getElementById('key_code').value;
					const authorization = document.getElementById('authorization').value;
					const language = document.getElementById('language').value;
					const key = key_code + authorization
					$.ajax({
						url: "https://app.laboratoriobetalab.com/api/method/consultas.consultas.api.get_single_result",
						type: "POST",
						crossDomain: true,
						data: {
							key
						},
						dataType: "json"
					}).done(function({message}) {
						if (!!message){
							let lan = language == "English" ? 'en': 'es';
							window.location.replace(`${message}&_lang=${lan}`);
						}
						else{
							alert('No valid result Found')
						}
					});
					im_done();
				})
			}, 2000);
		} 

		

		</script>
	  <?php
	}
  }
  add_action('wp_head', 'wpb_hook_javascript');

/**
 * Flex Slider Enqueue Scripts
 */
if ( ! function_exists( 'labora_flexslider_enqueue_scripts' ) ) {
	add_action( 'labora_theme_flexslider','labora_flexslider_enqueue_scripts' );
	function labora_flexslider_enqueue_scripts() {
		$fs_slidespeed 	 = get_option( 'labora_flexslidespeed' ) ? get_option( 'labora_flexslidespeed' ) : '3000';
		$fs_slideeffect  = get_option( 'labora_flexslideeffect' ) ? get_option( 'labora_flexslideeffect' ) : 'fade';
		$fs_slidednav	 = get_option( 'labora_flexslidednav' ) ? get_option( 'labora_flexslidednav' ) : 'true';
		$flexslider_args = array(
								'slideeffect' => $fs_slideeffect,
								'slidespeed'  => $fs_slidespeed,
								'slidednav'	  => $fs_slidednav,
							);
		wp_enqueue_script( 'flexslider', LABORA_THEME_JS . '/jquery.flexslider-min.js', array( 'jquery' ), '', true );
		wp_localize_script( 'flexslider', 'flexslider_args', $flexslider_args );
		wp_enqueue_style( 'flexslider-style', LABORA_THEME_CSS . '/flexslider.css' );
	}
}

/**
 * Theme Class
 */
 if ( ! class_exists( 'Labora_Theme_Functions' ) ) {
 	class Labora_Theme_Functions {
		public $labora_meta_box;
		public function __construct() {
			$this->labora_theme_constants();
			$this->labora_theme_support();
			$this->labora_theme_admin_scripts();
			$this->labora_theme_admin_interface();
			$this->labora_theme_custom_widgets();
			$this->labora_theme_custom_meta();
			$this->labora_theme_meta_generator();
			$this->labora_theme_extras();
		}

		function labora_theme_constants() {

			/**
			 * Set the file path based on whether the Options
			 * Framework is in a parent theme or child theme
			 * Directory Structure
			 */

			$labora_theme_data	= wp_get_theme();
			$labora_theme_name = $labora_theme_data->get( 'Name' );

			define( 'LABORA_FRAMEWORK', '2.0' );
			define( 'LABORA_THEME_NAME', $labora_theme_name );
			define( 'LABORA_THEME_URI', get_template_directory_uri() );
			define( 'LABORA_THEME_DIR', get_template_directory() );
			define( 'LABORA_THEME_JS', LABORA_THEME_URI . '/js' );
			define( 'LABORA_THEME_CSS', LABORA_THEME_URI . '/css' );
			define( 'LABORA_FRAMEWORK_DIR', LABORA_THEME_DIR . '/framework/' );
			define( 'LABORA_FRAMEWORK_URI', LABORA_THEME_URI . '/framework/' );
			define( 'LABORA_ADMIN_URI',  LABORA_FRAMEWORK_URI . 'admin' );
			define( 'LABORA_ADMIN_DIR',  LABORA_FRAMEWORK_DIR . 'admin' );
			define( 'LABORA_THEME_WIDGETS',  LABORA_FRAMEWORK_DIR . 'widgets/' );
			define( 'LABORA_THEME_CUSTOM_META',  LABORA_FRAMEWORK_DIR . 'custom-meta/' );
		}
		/**
		 * allows a theme to register its support of a certain features
		 */
		function labora_theme_support() {

			add_theme_support( 'post-formats', array(
				'aside',
				'audio',
				'link',
				'image',
				'gallery',
				'quote',
				'status',
				'video',
				'event',
			));
			add_theme_support( 'post-thumbnails' );
			add_theme_support( 'automatic-feed-links' );
			add_editor_style( 'editor-style.css' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'menus' );

			// Register menu.
			register_nav_menus( array(
				'primary-menu' => esc_html__( 'Primary Menu', 'labora' ),
			));


			// Define content width.
			if ( ! isset( $content_width ) ) {
				$content_width = 1100;
			}
		}
		/**
		 * scripts and styles enqueue .
		 */
		function labora_theme_admin_scripts() {
			$this->child_require_once( LABORA_FRAMEWORK_DIR . 'common/admin-scripts.php' );
		}
		/**
		 * Admin interface .
		 */
		function labora_theme_admin_interface() {
			$this->child_require_once( LABORA_FRAMEWORK_DIR . 'common/iva-googlefont.php' );
			$this->child_require_once( LABORA_FRAMEWORK_DIR . 'admin/admin-interface.php' );
			$this->child_require_once( LABORA_FRAMEWORK_DIR . 'admin/theme-options.php' );
		}
		/**
		 * Widgets .
		 */
		function labora_theme_custom_widgets() {
			$this->child_require_once( LABORA_THEME_WIDGETS . '/register-widget.php' );
			$this->child_require_once( LABORA_THEME_WIDGETS . '/iva-wg-contactinfo.php' );
			$this->child_require_once( LABORA_THEME_WIDGETS . '/iva-wg-sociable.php' );
			$this->child_require_once( LABORA_THEME_WIDGETS . '/iva-wg-recentpost.php' );
			$this->child_require_once( LABORA_THEME_WIDGETS . '/iva-wg-icon-box.php' );
			$this->child_require_once( LABORA_THEME_WIDGETS . '/iva-wg-button.php' );
		}
		/** load meta generator templates
		 * @files slider, Menus, page, posts,
		 */
		function LABORA_THEME_CUSTOM_META() {
			$this->child_require_once( LABORA_THEME_CUSTOM_META . '/page-meta.php' );
			$this->child_require_once( LABORA_THEME_CUSTOM_META . '/post-meta.php' );
			$this->child_require_once( LABORA_THEME_CUSTOM_META . '/slider-meta.php' );
			$this->child_require_once( LABORA_THEME_CUSTOM_META . '/testimonial-meta.php' );
			$this->child_require_once( LABORA_THEME_CUSTOM_META . '/gallery-meta.php' );
		}

		function labora_theme_meta_generator() {
			$this->child_require_once( LABORA_THEME_CUSTOM_META . '/meta-generator.php' );
		}

		/**
		 * Theme functions
		 * @uses skin generat$this->child_require_once(or
		 * @uses pagination
		 * @uses sociables
		 * @uses Aqua imageresize // Credits : http://aquagraphite.com/
		 * @uses plugin activation class
		 */
		function labora_theme_extras() {
			$this->child_require_once( LABORA_THEME_DIR . '/css/skin.php' );
			$this->child_require_once( LABORA_FRAMEWORK_DIR . 'includes/mega-menu.php' );
			$this->child_require_once( LABORA_FRAMEWORK_DIR . 'common/iva-generator.php' );
			$this->child_require_once( LABORA_FRAMEWORK_DIR . 'includes/image-resize.php' );
			$this->child_require_once( LABORA_FRAMEWORK_DIR . 'includes/class-activation.php' );
		}
		
		
		function child_require_once( $file ) {
			$child_file = str_replace(get_template_directory(), get_stylesheet_directory(), $file );
			if ( file_exists( $child_file ) ) {
				require_once( $child_file );
			} else {
				require_once( $file );
			}
		}
		
		/**
		 * Custom switch case for fetching
		 * posts, post-types, custom-taxonomies, tags
		 */
		 function labora_get_vars( $type ) {
			$labora_tax_options = array();
			switch ( $type ) {
				/**
				 * Get page titles.
				 */
				case 'pages':
					$labora_get_pages = get_pages( 'sort_column=post_parent,menu_order' );
					if ( ! empty( $labora_get_pages ) && ! is_wp_error( $labora_get_pages ) ) {
						foreach ( $labora_get_pages as $page ) {
							$labora_tax_options[ $page->ID ] = $page->post_title;
						}
					}
					break;
				/**
				 * Get slider slug and name.
				 */
				case 'slider':
					$labora_slider_cats = get_terms( 'slider_cat', 'orderby=name&hide_empty=0' );
					if ( ! empty( $labora_slider_cats ) && ! is_wp_error( $labora_slider_cats ) ) {
						foreach ( $labora_slider_cats as $slider ) {
							$labora_tax_options[ $slider->slug ] = $slider->name;
						}
					}
					break;

				/**
				 * Get posts slug and name.
				 */
				case 'posts':
					$labora_post_cats = get_categories( 'hide_empty=0' );
					if ( ! empty( $labora_post_cats ) && ! is_wp_error( $labora_post_cats ) ) {
						foreach ( $labora_post_cats as $cat ) {
							$labora_tax_options[ $cat->slug ] = $cat->name;
						}
					}
					break;

				/**
				 * Get categories slug and name.
				 */
				case 'categories':
					$labora_post_cats = get_categories( 'hide_empty=true' );
					if ( ! empty( $labora_post_cats ) && ! is_wp_error( $labora_post_cats ) ) {
						foreach ( $labora_post_cats as $cat ) {
							$labora_tax_options[ $cat->term_id ] = $cat->name;
						}
					}
					break;

				/**
				 * Get taxonomy tags.
				 */
				case 'tags':
					$labora_tags = get_tags(array(
						'taxonomy' => 'post_tag',
					) );
					if ( ! empty( $labora_tags ) && ! is_wp_error( $labora_tags ) ) {
						foreach ( $labora_tags as $tags ) {
							$labora_tax_options[ $tags->slug ] = $tags->name;
						}
					}
					break;

				/**
				 * Slider arrays for theme options.
				 */
				case 'slider_type':
					$labora_tax_options = array(
						'' 				=> esc_html__( 'Select Slider', 'labora' ),
						'flexslider' 	=> esc_html__( 'Flex Slider', 'labora' ),
						'static_image' 	=> esc_html__( 'Static Image', 'labora' ),
						'customslider'	=> esc_html__( 'Custom Slider', 'labora' ),
					);
					break;
			}

			return $labora_tax_options;
		}
	}
}
/**
 * Section to decide whether use child theme or parent theme 
 */
if ( ! defined('LABORA_NICHE_DIR') ) {
	define( 'LABORA_NICHE_DIR', labora_child_require_file( get_template_directory() . '/labora-niche/') );
}
