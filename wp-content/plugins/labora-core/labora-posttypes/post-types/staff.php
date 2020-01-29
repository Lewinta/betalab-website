<?php
/*
 * Add new taxonomy, NOT hierarchical (like tags)
 * taxonomy = Staff
 * object type = Staff (Name of the object type for the taxonomy object)
 */
if ( ! function_exists( 'labora_cpt_staff' ) ) {
	function labora_cpt_staff() {
		$labels = array(
			'name'				=> esc_html__( 'Staff', 'labora-pt-textdomain' ),
			'singular_name'		=> esc_html__( 'Staff', 'labora-pt-textdomain' ),
			'add_new'			=> esc_html__( 'Add New','labora-pt-textdomain' ),
			'add_new_item'		=> esc_html__( 'Add New Staff','labora-pt-textdomain' ),
			'edit_item'			=> esc_html__( 'Edit Staff','labora-pt-textdomain' ),
			'new_item'			=> esc_html__( 'New Staff','labora-pt-textdomain' ),
			'view_item'			=> esc_html__( 'View Staff','labora-pt-textdomain' ),
			'search_items'		=> esc_html__( 'Search Staff','labora-pt-textdomain' ),
			'not_found'			=> esc_html__( 'No Staff found','labora-pt-textdomain' ),
			'not_found_in_trash' => esc_html__( 'No Staff found in Trash','labora-pt-textdomain' ),
			'parent_item_colon'	=> '',
			'all_items' 		=> esc_html__( 'All Staff' ,'labora-pt-textdomain' ),
		);
		$labora_staff_slug = get_option( 'labora_staff_slug' ) ? get_option( 'labora_staff_slug' ):'staff';
		$args = array(
			'labels'			=> $labels,
			'public'			=> true,
			'exclude_from_search' => true,
			'show_ui'			=> true,
			'capability_type'	=> 'post',
			'hierarchical'		=> false,
			'rewrite'			=> array( 'slug' => $labora_staff_slug, 'with_front' => true ),
			'query_var'			=> false,
			'menu_position'		=> null,
			'menu_icon'			=> 'dashicons-id',
			'supports'			=> array( 'title','excerpt','thumbnail','editor' ),
			'taxonomies' 		=> array( 'staff_category' ),
		);

		register_post_type( 'staff', $args );
	}
	add_action( 'init', 'labora_cpt_staff' );
}
if ( ! function_exists( 'labora_cpt_staff_taxonomies' ) ) {
	function labora_cpt_staff_taxonomies() {
		register_taxonomy( 'staff_category', 'staff', array(
			'hierarchical'		=> true,
			'labels' 			=> array(
				'name' 				=> esc_html__( 'Staff Categories', 'labora-pt-textdomain' ),
				'singular_name' 	=> esc_html__( 'Staff', 'labora-pt-textdomain' ),
				'search_items' 		=> esc_html__( 'Search Staff','labora-pt-textdomain' ),
				'all_items' 		=> esc_html__( 'All Staff','labora-pt-textdomain' ),
				'parent_item' 		=> esc_html__( 'Parent Staff','labora-pt-textdomain' ),
				'parent_item_colon' => esc_html__( 'Parent Staff:','labora-pt-textdomain' ),
				'edit_item' 		=> esc_html__( 'Edit Staff','labora-pt-textdomain' ),
				'update_item' 		=> esc_html__( 'Update Staff','labora-pt-textdomain' ),
				'add_new_item' 		=> esc_html__( 'Add Staff Category','labora-pt-textdomain' ),
				'new_item_name'		=> esc_html__( 'New Staff ','labora-pt-textdomain' ),
				'menu_name' 		=> esc_html__( 'Staff Categories','labora-pt-textdomain' ),
			),
			'show_ui'			=> true,
			'query_var'			=> true,
			'rewrite'			=> false,
		));
	}
	add_action( 'setup_theme', 'labora_cpt_staff_taxonomies' );
}
if ( ! function_exists( 'labora_cpt_staff_columns' ) ) {
	function labora_cpt_staff_columns( $columns ) {
		$columns = array(
			'cb'       	 => '<input type="checkbox" />',
			'title'      => esc_html__( 'Title','labora-pt-textdomain' ),
			'staff_id' => esc_html__( 'ID\'s','labora-pt-textdomain' ),
			'author'     => esc_html__( 'Author','labora-pt-textdomain' ),
			'staff_thumbnail' => esc_html__( 'Thumbnails','labora-pt-textdomain' ),
			'date'       => esc_html__( 'Date','labora-pt-textdomain' ),
		);
		return $columns;
	}
	add_filter( 'manage_edit-staff_columns', 'labora_cpt_staff_columns' );
}

if ( ! function_exists( 'labora_cpt_staff_manage_columns' ) ) {
	function labora_cpt_staff_manage_columns( $name ) {
		global $wpdb, $wp_query, $post;
		switch ( $name ) {
			case 'staff_id':
				echo get_the_ID();
				break;
			case 'staff_thumbnail':
					echo the_post_thumbnail(array(100,100));
					break;	
		}
	}
	add_action( 'manage_posts_custom_column', 'labora_cpt_staff_manage_columns', 10, 2 );
}
