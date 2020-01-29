<?php
/**
 * Name: Labora Post Types
 * URI: http://aivahthemes.net/
 * Description: A brief description of the plugin.
 */

/**
 * Labora Plugin Class.
 */
define( 'LABORA_CPT_DIR', LABORA_CORE_DIR . 'labora-posttypes/' );
define( 'LABORA_CPT_URI', LABORA_CORE_URI . 'labora-posttypes/' );

if ( ! class_exists( 'Labora_PostType_Plugin' ) ) {

	class Labora_PostType_Plugin {
		public function __construct() {
			// post type function
			$this->labora_cpt_registers();
		}

		/**
		 * load custom post types templates
		 * @files slider, testimonials, gallery etc...
		 */
		function labora_cpt_registers() {

			require_once( LABORA_CPT_DIR .'/post-types/slider.php' );
			require_once( LABORA_CPT_DIR .'/post-types/testimonial.php' );
			require_once( LABORA_CPT_DIR .'/post-types/cases.php' );
			require_once( LABORA_CPT_DIR .'/post-types/staff.php' );
			require_once( LABORA_CPT_DIR .'/post-types/vacancy.php' );
			require_once( LABORA_CPT_DIR .'/post-types/service.php' );
			require_once( LABORA_CPT_DIR .'/post-types/gallery.php' );
		}
	}
}

$labora_posttype_plugin = new Labora_PostType_Plugin();

// Add post id row
add_filter( 'post_row_actions', 'labora_row_post_id', 10, 1 );
function labora_row_post_id( $actions ) {
	global $post;
	if ( $post->post_type != 'page' || $post->post_type != 'post' ) {
		$actions['itemid'] = 'ID: ' . $post->ID;
	}
	return $actions;
}
