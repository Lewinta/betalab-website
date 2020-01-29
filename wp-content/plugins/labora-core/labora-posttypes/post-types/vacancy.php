<?php
/*
 * Add new taxonomy, NOT hierarchical (like tags)
 * taxonomy = Staff
 * object type = Staff (Name of the object type for the taxonomy object)
 */
if ( ! function_exists( 'labora_cpt_vacancy' ) ) {
	function labora_cpt_vacancy() {
		$labels = array(
			'name'				=> esc_html__( 'Vacancy', 'labora-pt-textdomain' ),
			'singular_name'		=> esc_html__( 'Vacancy', 'labora-pt-textdomain' ),
			'add_new'			=> esc_html__( 'Add New','labora-pt-textdomain' ),
			'add_new_item'		=> esc_html__( 'Add New Vacancy','labora-pt-textdomain' ),
			'edit_item'			=> esc_html__( 'Edit Vacancy','labora-pt-textdomain' ),
			'new_item'			=> esc_html__( 'New Vacancy','labora-pt-textdomain' ),
			'view_item'			=> esc_html__( 'View Vacancy','labora-pt-textdomain' ),
			'search_items'		=> esc_html__( 'Search Vacancy','labora-pt-textdomain' ),
			'not_found'			=> esc_html__( 'No Vacancy found','labora-pt-textdomain' ),
			'not_found_in_trash' => esc_html__( 'No Vacancys found in Trash','labora-pt-textdomain' ),
			'parent_item_colon'	=> '',
			'all_items' 		=> esc_html__( 'All Vacancys' ,'labora-pt-textdomain' ),
		);
		$labora_vacancy_slug = get_option( 'labora_vacancy_slug' ) ? get_option( 'labora_vacancy_slug' ):'vacancy';
		$args = array(
			'labels'			=> $labels,
			'public'			=> true,
			'exclude_from_search' => true,
			'show_ui'			=> true,
			'capability_type'	=> 'post',
			'hierarchical'		=> false,
			'rewrite'			=> array( 'slug' => $labora_vacancy_slug, 'with_front' => true ),
			'query_var'			=> false,
			'menu_position'		=> null,
			'menu_icon'			=> 'dashicons-businessman',
			'supports'			=> array( 'title', 'editor' ),
		);

		register_post_type( 'vacancy', $args );
	}
	add_action( 'init', 'labora_cpt_vacancy' );
}
