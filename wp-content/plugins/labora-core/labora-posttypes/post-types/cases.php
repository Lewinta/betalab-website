<?php
/*
 * Add new taxonomy, NOT hierarchical (like tags)
 * taxonomy = cases_category
 * object type = case (Name of the object type for the taxonomy object)
 */
if ( ! function_exists( 'labora_cpt_case' ) ) {
	function labora_cpt_case() {

		$labels = array(
			'name'				 => esc_html__( 'Cases','labora-pt-textdomain' ),
			'singular_name'		 => esc_html__( 'Case','labora-pt-textdomain' ),
			'add_new'			 => esc_html__( 'Add New Case', 'labora-pt-textdomain' ),
			'add_new_item'		 => esc_html__( 'Add New Case','labora-pt-textdomain' ),
			'edit_item'			 => esc_html__( 'Edit Case','labora-pt-textdomain' ),
			'new_item'			 => esc_html__( 'New Case','labora-pt-textdomain' ),
			'view_item'			 => esc_html__( 'View Case','labora-pt-textdomain' ),
			'search_items'		 => esc_html__( 'Search Case','labora-pt-textdomain' ),
			'not_found'			 => esc_html__( 'Nothing found','labora-pt-textdomain' ),
			'not_found_in_trash' => esc_html__( 'Nothing found in Trash','labora-pt-textdomain' ),
			'parent_item_colon'	 => '',
			'all_items' 		 => esc_html__( 'All Cases','labora-pt-textdomain' ),
		);
		$labora_case_slug = get_option( 'labora_case_slug' ) ? get_option( 'labora_case_slug' ) :'cases';

		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'exclude_from_search'	=> true,
			'show_ui'				=> true,
			'capability_type'		=> 'post',
			'hierarchical'			=> false,
			'rewrite'				=> array( 'slug' => $labora_case_slug, 'with_front' => true ),
			'query_var'				=> false,
			'menu_position'			=> null,
			'menu_icon'				=> 'dashicons-portfolio',
			'supports'				=> array( 'title','thumbnail','excerpt','editor' ),
			'taxonomies' 			=> array( 'cases_category' ),
		);
		register_post_type( 'cases' , $args );
	}
	add_action( 'init', 'labora_cpt_case' );
}
if ( ! function_exists( 'labora_cpt_case_taxonomies' ) ) {
	function labora_cpt_case_taxonomies() {
		register_taxonomy( 'cases_category', 'cases', array(
			'hierarchical'		=> true,
			'labels' => array(
				'name' 				=> esc_html__( 'Cases Categories', 'labora-pt-textdomain' ),
				'singular_name' 	=> esc_html__( 'Cases Categories', 'labora-pt-textdomain' ),
				'search_items' 		=> esc_html__( 'Search Case','labora-pt-textdomain' ),
				'parent_item' 		=> esc_html__( 'Parent Case' ,'labora-pt-textdomain' ),
				'parent_item_colon' => esc_html__( 'Parent Case:' ,'labora-pt-textdomain' ),
				'edit_item' 		=> esc_html__( 'Edit Case','labora-pt-textdomain' ),
				'update_item' 		=> esc_html__( 'Update Cases Category','labora-pt-textdomain' ),
				'add_new_item' 		=> esc_html__( 'Add Cases Category','labora-pt-textdomain' ),
				'new_item_name' 	=> esc_html__( 'New Case ','labora-pt-textdomain' ),
				'case_name' 	    => esc_html__( 'Cases Categories' ,'labora-pt-textdomain' ),
			),
			'show_ui'			=> true,
			'query_var'			=> true,
			'rewrite'			=> false,
			'sort' 				=> true,
			'args' 				=> array( 'orderby' => 'menu_order' ),
			'has_archive'       => true,

		));
	}
	add_action( 'init', 'labora_cpt_case_taxonomies' );
}

if ( ! function_exists( 'labora_cpt_cases_columns' ) ) {
	function labora_cpt_cases_columns( $columns ) {
		$columns = array(
			'cb'      		 => '<input type="checkbox" />',
			'title'      	 => esc_html__( 'Title','labora-pt-textdomain' ),
			'cases_category' => esc_html__( 'Categories','labora-pt-textdomain' ),
			'case_id'	 => esc_html__( 'ID\'s','labora-pt-textdomain' ),
		);
		return $columns;
	}
	add_filter( 'manage_edit-cases_columns', 'labora_cpt_cases_columns' );
}

if ( ! function_exists( 'labora_cpt_case_manage_columns' ) ) {
	function labora_cpt_case_manage_columns( $name ) {
		global $wpdb, $wp_query,$post;
		switch ( $name ) {
			case 'cases_category':
				$terms = get_the_terms( $post->ID, 'cases_category' );
				//If the terms array contains items... (dupe of core)
				if ( ! empty( $terms ) ) {
					//Loop through terms
					foreach ( $terms as $term ) {
						//Add tax name & link to an array
						$post_terms[] = esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, '', 'edit' ) );
					}
					//Spit out the array as CSV
					echo implode( ', ', $post_terms );
				} else {
					//Text to show if no terms attached for post & tax
					echo '<em>' . esc_html__( 'No terms','labora-pt-textdomain' ) . '</em>';
				}
				break;
			case 'case_id':
				echo get_the_ID();
				break;
		}
	}
	add_action( 'manage_posts_custom_column', 'labora_cpt_case_manage_columns', 10, 2 );
}
