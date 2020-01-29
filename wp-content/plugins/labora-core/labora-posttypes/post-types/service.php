<?php
//service type
//--------------------------------------------------------
if ( ! function_exists( 'labora_cpt_service' ) ) {
	function labora_cpt_service() {
		$labels = array(
			'name'				=> esc_html__( 'Services','labora-pt-textdomain' ),
			'singular_name'		=> esc_html__( 'Service','labora-pt-textdomain' ),
			'add_new'			=> esc_html__( 'Add New', 'labora-pt-textdomain' ),
			'add_new_item'		=> esc_html__( 'Add Service','labora-pt-textdomain' ),
			'edit_item'			=> esc_html__( 'Edit Service','labora-pt-textdomain' ),
			'new_item'			=> esc_html__( 'New Item','labora-pt-textdomain' ),
			'view_item'			=> esc_html__( 'View Service Item','labora-pt-textdomain' ),
			'search_items'		=> esc_html__( 'Search Service Item','labora-pt-textdomain' ),
			'not_found'			=> esc_html__( 'Nothing found','labora-pt-textdomain' ),
			'not_found_in_trash' => esc_html__( 'Nothing found in Trash','labora-pt-textdomain' ),
			'parent_item_colon'	=> '',
			'all_items' 		=> esc_html__( 'All Services' ,'labora-pt-textdomain' ),
		);

		$labora_service_slug = get_option( 'labora_service_slug' ) ? get_option( 'labora_service_slug' ) : 'services';

		$args = array(
			'labels'			=> $labels,
			'public'			=> true,
			'exclude_from_search' => false,
			'show_ui'			=> true,
			'capability_type'	=> 'post',
			'hierarchical'		=> false,
			'rewrite'			=> array( 'slug' => $labora_service_slug, 'with_front' => false ),
			'query_var'			=> false,
			'menu_icon'			=> 'dashicons-index-card',
			'supports'			=> array( 'title','thumbnail','excerpt','service_cat','editor' ),
		);
		register_post_type( 'service' , $args );
	}
	add_action( 'init', 'labora_cpt_service' );
}
register_taxonomy( 'service_cat', 'service', array(
	'hierarchical'		 => true,
	'labels' => array(
		'name'			    => esc_html__( 'Categories', 'labora-pt-textdomain' ),
		'singular_name' 	=> esc_html__( 'Services', 'labora-pt-textdomain' ),
		'search_items'		=> esc_html__( 'Search Services','labora-pt-textdomain' ),
		'all_items' 		=> esc_html__( 'All Services','labora-pt-textdomain' ),
		'parent_item' 		=> esc_html__( 'Parent Services','labora-pt-textdomain' ),
		'parent_item_colon' => esc_html__( 'Parent Services:','labora-pt-textdomain' ),
		'edit_item' 		=> esc_html__( 'Edit Services','labora-pt-textdomain' ),
		'update_item' 		=> esc_html__( 'Update Services','labora-pt-textdomain' ),
		'add_new_item' 		=> esc_html__( 'Add Service Category','labora-pt-textdomain' ),
		'new_item_name' 	=> esc_html__( 'New Services ','labora-pt-textdomain' ),
		'menu_name' 		=> esc_html__( 'Service Categories','labora-pt-textdomain' ),
	),
	'show_ui'			=> true,
	'query_var'			=> true,
	'rewrite'			=> false,
));

if ( ! function_exists( 'labora_cpt_service_columns' ) ) {
	function labora_cpt_service_columns( $columns ) {
		$columns = array(
			'cb'       		=> '<input type="checkbox" />',
			'title'       	=> esc_html__( 'Title','labora-pt-textdomain' ),
			'author'       	=> esc_html__( 'Author','labora-pt-textdomain' ),
			'service_cat'   => esc_html__( 'Categories','labora-pt-textdomain' ),
			'service_label' => esc_html__( 'Label','labora-pt-textdomain' ),
			'service_cost' 	=> esc_html__( 'Cost','labora-pt-textdomain' ),
			'date'       	=> esc_html__( 'Date','labora-pt-textdomain' ),
		);
		return $columns;
	}
	add_filter( 'manage_edit-servicetype_columns', 'labora_cpt_service_columns' );
}
if ( ! function_exists( 'labora_cpt_service_manage_columns' ) ) {
	function labora_cpt_service_manage_columns( $name ) {
		global $post, $wp_query;
		switch ( $name ) {
			case 'service_cat':
				$terms = get_the_terms( $post->ID, 'service_cat' );
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
					echo '<em>' . esc_html__( 'No terms', 'labora-pt-textdomain' ) . '</em>';
				}
				break;

			case 'service_label':
				echo get_post_meta( get_the_ID(), 'service_label', true );
				break;
			case 'service_cost':
				echo get_post_meta( get_the_ID(), 'service_cost', true );
				break;	
		}
	}
	add_action( 'manage_posts_custom_column', 'labora_cpt_service_manage_columns', 10, 2 );
}
