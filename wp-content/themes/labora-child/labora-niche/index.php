<?php
/**
 * This class extends Labora_Theme_Functions.
 */
if ( ! class_exists( 'Labora_Niche_Theme' ) ) {
	class Labora_Niche_Theme extends Labora_Theme_Functions {

		/**
	     * load seminar custom meta.
	     */
		function labora_theme_custom_meta() {
			parent::labora_theme_custom_meta();
			$this->child_index_require_once( LABORA_DIR . 'staff/staff-meta.php' );
			$this->child_index_require_once( LABORA_DIR . 'vacancy/vacancy-meta.php' );
		}

		function child_index_require_once( $file ) {
			$child_file = str_replace( get_template_directory(), get_stylesheet_directory(), $file );
			if ( file_exists( $child_file ) ) {
				require $child_file;
			} else {
				require $file;
			}
		}

		function labora_get_vars( $type ) {

			$labora_tax_options = parent::labora_get_vars( $type );

			switch ( $type ) {
				/**
				 * get service slug and name.
				 */
				 case 'services':
 					$args = array(
 						'posts_per_page'   => -1,
 						'offset'           => 0,
 						'orderby'          => 'post_date',
 						'order'            => 'DESC',
 						'post_type'        => 'service',
 						'post_status'      => 'publish',
 						'suppress_filters' => true,
 					);
 					$labora_services = get_posts( $args );
 					foreach ( $labora_services as $key => $entry ) {
 						$labora_tax_options[ $entry->ID ] = $entry->post_title;
 					}
 					break;
			}
			return $labora_tax_options;
		}
	}
	$labora_theme_ob = new Labora_Niche_Theme();
}
require labora_child_require_file( LABORA_DIR . 'labora-functions.php' );
require labora_child_require_file( LABORA_DIR . 'additional-themeoptions.php' );

// S I N G L E  P O S T T Y P E S
//---------------------------------------------------------------------------
if ( ! function_exists( 'labora_cpt_single_page' ) ) {
	function labora_cpt_single_page() {

		global $wp_query, $post;
		$customtype = $post->post_type;

		if ( file_exists( labora_child_require_file( LABORA_DIR . $customtype . '/' . 'single-' . $customtype . '.php') ) ) {
			return labora_child_require_file( LABORA_DIR . $customtype . '/single-' . $customtype . '.php' );
		} elseif ( file_exists( labora_child_require_file( LABORA_THEME_DIR . '/single-' . $customtype . '.php' ) ) ) {
			return labora_child_require_file( LABORA_THEME_DIR . '/single-' . $customtype . '.php' );
		} else {
			return labora_child_require_file( LABORA_THEME_DIR . '/single.php' );
		}
	}
	add_filter( 'single_template', 'labora_cpt_single_page' );
}

//Retrieve path of taxonomy template in current or parent template.
if ( ! function_exists( 'labora_cpt_taxonomy' ) ) {
	function labora_cpt_taxonomy() {

		global $wp_query, $post;
		$customtype = $post->post_type;
		$name 		= get_queried_object()->taxonomy;

		if ( file_exists( labora_child_require_file( LABORA_DIR . $customtype . '/taxonomy-' . $name . '.php' ) ) ) {
			return labora_child_require_file( LABORA_DIR . $customtype . '/taxonomy-' . $name . '.php' );
		} elseif ( labora_child_require_file( file_exists( LABORA_THEME_DIR . '/taxonomy-' . $name . '.php' ) ) ) {
			return labora_child_require_file( LABORA_THEME_DIR . '/taxonomy-' . $name . '.php' );
		} else {
			return labora_child_require_file( LABORA_THEME_DIR . '/archive.php' );
		}
	}
	add_filter( 'taxonomy_template', 'labora_cpt_taxonomy' );
}
