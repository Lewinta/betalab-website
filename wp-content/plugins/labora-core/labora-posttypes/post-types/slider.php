<?php
/*
 * Add new taxonomy, NOT hierarchical (like tags)
 * taxonomy = slider
 * object type = slide (Name of the object type for the taxonomy object)
 */
if ( ! function_exists( 'labora_cpt_slider' ) ) {
	function labora_cpt_slider() {
		$labels = array(
			'name'				=> esc_html__( 'Slider', 'labora-pt-textdomain' ),
			'singular_name'		=> esc_html__( 'Slide', 'labora-pt-textdomain' ),
			'add_new'			=> esc_html__( 'Add New','labora-pt-textdomain' ),
			'add_new_item'		=> esc_html__( 'Add New Slide','labora-pt-textdomain' ),
			'edit_item'			=> esc_html__( 'Edit Slide','labora-pt-textdomain' ),
			'new_item'			=> esc_html__( 'New Slide','labora-pt-textdomain' ),
			'view_item'			=> esc_html__( 'View Slide','labora-pt-textdomain' ),
			'search_items'		=> esc_html__( 'Search Slide','labora-pt-textdomain' ),
			'not_found'			=> esc_html__( 'No Slider found','labora-pt-textdomain' ),
			'not_found_in_trash' => esc_html__( 'No Slider found in Trash','labora-pt-textdomain' ),
			'parent_item_colon'	=> '',
			'all_items' 		=> esc_html__( 'All Sliders' ,'labora-pt-textdomain' ),
		);
		$labora_slider_slug = get_option( 'labora_slider_slug' ) ? get_option( 'labora_slider_slug' ):'slider';
		$args = array(
			'labels'			=> $labels,
			'public'			=> true,
			'exclude_from_search' => false,
			'show_ui'			=> true,
			'capability_type'	=> 'post',
			'hierarchical'		=> false,
			'rewrite'			=> array( 'slug' => $labora_slider_slug, 'with_front' => true ),
			'query_var'			=> false,
			'menu_position'		=> null,
			'menu_icon'			=> 'dashicons-slides',
			'supports'			=> array( 'title', 'thumbnail', 'page-attributes' ),
			'taxonomies' 		=> array( 'slider_cat' ),
		);

		register_post_type( 'slider',$args );
	}
	add_action( 'init', 'labora_cpt_slider' );
}
if ( ! function_exists( 'labora_cpt_slider_taxonomies' ) ) {
	function labora_cpt_slider_taxonomies() {
		register_taxonomy( 'slider_cat', 'slider', array(
			'hierarchical'		=> true,
			'labels' 			=> array(
				'name' 				=> esc_html__( 'Slider Categories', 'labora-pt-textdomain' ),
				'singular_name' 	=> esc_html__( 'Slide', 'labora-pt-textdomain' ),
				'search_items' 		=> esc_html__( 'Search Slider','labora-pt-textdomain' ),
				'all_items' 		=> esc_html__( 'All Slider','labora-pt-textdomain' ),
				'parent_item' 		=> esc_html__( 'Parent Slider','labora-pt-textdomain' ),
				'parent_item_colon' => esc_html__( 'Parent Slider:','labora-pt-textdomain' ),
				'edit_item' 		=> esc_html__( 'Edit Slider','labora-pt-textdomain' ),
				'update_item' 		=> esc_html__( 'Update Sliders','labora-pt-textdomain' ),
				'add_new_item' 		=> esc_html__( 'Add Slider Category','labora-pt-textdomain' ),
				'new_item_name'		=> esc_html__( 'New Slider ','labora-pt-textdomain' ),
				'menu_name' 		=> esc_html__( 'Slider Categories','labora-pt-textdomain' ),
			),
			'show_ui'			=> true,
			'query_var'			=> true,
			'rewrite'			=> false,
		));
	}
	add_action( 'setup_theme', 'labora_cpt_slider_taxonomies' );
}
if ( ! function_exists( 'labora_cpt_slider_columns' ) ) {
	function labora_cpt_slider_columns( $columns ) {
		$columns = array(
			'cb'       	 => '<input type="checkbox" />',
			'title'      => esc_html__( 'Title','labora-pt-textdomain' ),
			'author'     => esc_html__( 'Author','labora-pt-textdomain' ),
			'slider_thumbnail' => esc_html__( 'Thumbnails','labora-pt-textdomain' ),
			'slider_cat' => esc_html__( 'Categories','labora-pt-textdomain' ),
			'date'       => esc_html__( 'Date','labora-pt-textdomain' ),
		);
		return $columns;
	}
	add_filter( 'manage_edit-slider_columns', 'labora_cpt_slider_columns' );
}

if ( ! function_exists( 'labora_cpt_slider_manage_columns' ) ) {
	function labora_cpt_slider_manage_columns( $name ) {
		global $wpdb, $wp_query, $post;
		switch ( $name ) {
			case 'slider_cat':
				$terms = get_the_terms( $post->ID, 'slider_cat' );
				//If the terms array contains items... (dupe of core)
				if ( ! empty( $terms ) ) {
					// Loop through terms
					foreach ( $terms as $term ) {
						//Add tax name & link to an array
						$post_terms[] = esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, '', 'edit' ) );
					}
					// Spit out the array as CSV
					echo wp_kses_post( implode( ', ', $post_terms ) );
				} else {
					// Text to show if no terms attached for post & tax
					echo '<em>' . esc_html__( 'No terms', 'labora-pt-textdomain' ) . '</em>';
				}
				break;
			case 'slider_thumbnail':
					echo the_post_thumbnail(array(100,100));
					break;
		}
	}
	add_action( 'manage_posts_custom_column', 'labora_cpt_slider_manage_columns', 10, 2 );
}
