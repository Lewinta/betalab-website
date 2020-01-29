<?php
/**
 * Name: Labora VC Addons
 * URI: http://aivahthemes.com/
 * Description: Ultimate Addons for Visual Composer from AivahThemes
 */
define( 'LABORA_VC_ADDON_DIR', LABORA_CORE_DIR . 'labora-vcaddons/' );
define( 'LABORA_VC_ADDON_URL', LABORA_CORE_URI . 'labora-vcaddons/' );

if ( ! class_exists( 'Labora_VC_Extends' ) ) {
	class Labora_VC_Extends {
		function __construct() {
			$this->module_dir = LABORA_VC_ADDON_DIR . '/modules';
			add_action( 'after_setup_theme',array( $this, 'labora_vc_modules' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'labora_vc_enqueue_scripts' ), 99 );
		}
		function labora_vc_enqueue_scripts() {
			if ( ! is_404() && ! is_search() ) {

				global $post;

				if ( ! $post ) {
					return false;
				}
				$post_content = $post->post_content;

				// if (  stripos( $post_content, '[labora_vc_blog' ) ) {
					wp_enqueue_script( 'labora-owl-carousel' );
					wp_enqueue_style( 'labora-owl-style' );
					wp_enqueue_style( 'labora-owl-theme' );
				// }

				if ( stripos( $post_content, '[labora_vc_milestone' ) ) {
					wp_enqueue_script( 'labora-appear' );
					wp_enqueue_script( 'labora-countTo' );
				}
				if ( stripos( $post_content, '[labora_vc_counter' ) ) {
					wp_enqueue_script( 'labora_counter' );
				}
				if ( stripos( $post_content, '[labora_vc_price' ) ) {
					wp_enqueue_script( 'labora-model-effects' );
				}

				if ( stripos( $post_content, 'prettyPhoto' ) ) {
					wp_enqueue_script( 'prettyPhoto' );
					wp_enqueue_style( 'prettyPhoto' );
				}

				if ( stripos( $post_content, '[labora_vc_chart' ) ) {
			    	wp_enqueue_script( 'labora-charts' );
			    }
				if ( stripos( $post_content, '[labora_vacancy_table' ) ) {
					wp_enqueue_script( 'table-sorter' );
				}
			}
		}

		function labora_vc_modules() {
			foreach ( glob( $this->module_dir . '/*.php' ) as $module ) {
				require_once( $module );
			}
		}
	} // class end
	new Labora_VC_Extends;
} // end class check

if ( ! function_exists( 'labora_vc_admin_scripts' ) ) {
	function labora_vc_admin_scripts() {
		wp_enqueue_style( 'labora-vc-admin-style', LABORA_VC_ADDON_URL . 'assets/css/labora-vc-addon.css' );
	}
	add_action( 'admin_enqueue_scripts', 'labora_vc_admin_scripts' );
}
if ( ! function_exists( 'labora_vc_frontend_scripts' ) ) {
	function labora_vc_frontend_scripts() {
		wp_enqueue_style( 'labora-vc-style', LABORA_VC_ADDON_URL . 'assets/css/labora-vc-style.css' );
	}
	add_action( 'wp_enqueue_scripts', 'labora_vc_frontend_scripts' );
}
require_once( 'image-resize.php' );

if ( ! function_exists( 'labora_vc_excerpt_max_charlength' ) ) {
	function labora_vc_excerpt_max_charlength( $charlength ) {

		$excerpt = get_the_excerpt();

		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				return mb_substr( $subex, 0, $excut );
			} else {
				return $subex;
			}
			return '[...]';
		} else {
			return $excerpt;
		}
	}
}

if ( ! function_exists( 'labora_vc_get_attachment_id_from_src' ) ) {
	function labora_vc_get_attachment_id_from_src( $image_src ) {
		global $wpdb;
		$id = $wpdb->get_var( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE guid = %s", $image_src ) );
		return $id;
	}
}

/* Add Column Animation tab in Visual Composer Plugin */
if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {

	$labora_vc_dir = LABORA_VC_ADDON_DIR . '/templates/shortcodes';

	vc_set_shortcodes_templates_dir( $labora_vc_dir );

	$row_design_typotext = array(
		'type' 			=> 'colorpicker',
		'heading' 		=> esc_html__( 'Text Color', 'labora' ),
		'description' 	=> esc_html__( 'Choose the text color you want to display for the  Text.', 'labora' ),
		'param_name' 	=> 'textcolor',
		'group' 		=> esc_html__( 'Design Options', 'labora' ),
	);
	vc_add_param( 'vc_row', $row_design_typotext );
	
	$labora_enable_animation = array(
		'type' 		  => 'checkbox',
		'class' 	  => '',
		'heading' 	  => esc_html__( 'Enable Animation','labora' ),
		'value' 	  => array( 'Enable Column Animation?' => 'true' ),
		'param_name'  => 'enable_animation',
		'description' => esc_html__( 'Check this if you wish to enable animation', 'labora' ),
	);
	$labora_animation = array(
		'type' 		 => 'dropdown',
		'heading' 	 => esc_html__( 'CSS Animation', 'labora' ),
		'param_name' => 'css_animation',
		'admin_label' => false,
		'value' 	 => array(
			'None'			=> '',
			'fadeIn'		=> 'fadeIn',
			'fadeInLeft'	=> 'fadeInLeft',
			'fadeInRight'	=> 'fadeInRight',
			'fadeInUp'	  	=> 'fadeInUp',
			'fadeInDown'	=> 'fadeInDown',
		),
		'description' => esc_html__( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'labora' ),
		'dependency'  => array( 'element' => 'enable_animation', 'not_empty' => true ),
	);
	$labora_delay = array(
		'type' 		  => 'textfield',
		'class' 	  => '',
		'heading' 	  => esc_html__( 'Animation Delay', 'labora' ),
		'param_name'  => 'delay',
		'admin_label' => false,
		'description' => esc_html__( 'Delay before the animation starts ( e.g: 0.1s )', 'labora' ),
		'dependency'  => array( 'element' => 'enable_animation', 'not_empty' => true ),
	);
	vc_add_param( 'vc_column', $labora_enable_animation );
	vc_add_param( 'vc_column', $labora_animation );
	vc_add_param( 'vc_column', $labora_delay );
}

// 
if ( ! function_exists( 'labora_substr_text' ) ) {
	function labora_substr_text( $text = '', $len ) {
		if ( strlen( $text ) > $len ) {
			$text = substr( $text, 0, strpos( $text, ' ', $len ) );
			$text .= '...';
		}

		return $text;
	}
}
