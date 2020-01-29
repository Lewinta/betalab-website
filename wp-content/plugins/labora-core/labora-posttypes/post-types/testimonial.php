<?php
//Testimonial type
//--------------------------------------------------------
if ( ! function_exists( 'labora_cpt_testimonial' ) ) {
	function labora_cpt_testimonial() {
		$labels = array(
			'name'				=> esc_html__( 'Testimonials','labora-pt-textdomain' ),
			'singular_name'		=> esc_html__( 'Testimonial','labora-pt-textdomain' ),
			'add_new'			=> esc_html__( 'Add New', 'labora-pt-textdomain' ),
			'add_new_item'		=> esc_html__( 'Add Testimonial','labora-pt-textdomain' ),
			'edit_item'			=> esc_html__( 'Edit Testimonial','labora-pt-textdomain' ),
			'new_item'			=> esc_html__( 'New Item','labora-pt-textdomain' ),
			'view_item'			=> esc_html__( 'View Testimonial Item','labora-pt-textdomain' ),
			'search_items'		=> esc_html__( 'Search Testimonial Item','labora-pt-textdomain' ),
			'not_found'			=> esc_html__( 'Nothing found','labora-pt-textdomain' ),
			'not_found_in_trash' => esc_html__( 'Nothing found in Trash','labora-pt-textdomain' ),
			'parent_item_colon'	=> '',
			'all_items' 		=> esc_html__( 'All Testimonials' ,'labora-pt-textdomain' ),
		);

		$labora_testimonial_slug = get_option( 'labora_testimonial_slug' ) ? get_option( 'labora_testimonial_slug' ) : 'testimonialtype';

		$args = array(
			'labels'			=> $labels,
			'public'			=> true,
			'exclude_from_search' => false,
			'show_ui'			=> true,
			'capability_type'	=> 'post',
			'hierarchical'		=> false,
			'rewrite'			=> array( 'slug' => $labora_testimonial_slug, 'with_front' => true ),
			'query_var'			=> false,
			'menu_icon'			=> 'dashicons-testimonial',
			'supports'			=> array( 'title','thumbnail','excerpt','testimonial_cat' ),
		);
		register_post_type( 'testimonialtype' , $args );
	}
	add_action( 'init', 'labora_cpt_testimonial' );
}
register_taxonomy( 'testimonial_cat', 'testimonialtype', array(
	'hierarchical'		 => true,
	'labels' => array(
		'name'			    => esc_html__( 'Categories', 'labora-pt-textdomain' ),
		'singular_name' 	=> esc_html__( 'Testimonials', 'labora-pt-textdomain' ),
		'search_items'		=> esc_html__( 'Search Testimonials','labora-pt-textdomain' ),
		'all_items' 		=> esc_html__( 'All Testimonials','labora-pt-textdomain' ),
		'parent_item' 		=> esc_html__( 'Parent Testimonials','labora-pt-textdomain' ),
		'parent_item_colon' => esc_html__( 'Parent Testimonials:','labora-pt-textdomain' ),
		'edit_item' 		=> esc_html__( 'Edit Testimonials','labora-pt-textdomain' ),
		'update_item' 		=> esc_html__( 'Update Testimonials','labora-pt-textdomain' ),
		'add_new_item' 		=> esc_html__( 'Add Testimonial Category','labora-pt-textdomain' ),
		'new_item_name' 	=> esc_html__( 'New Testimonials ','labora-pt-textdomain' ),
		'menu_name' 		=> esc_html__( 'Testimonial Categories','labora-pt-textdomain' ),
	),
	'show_ui'			=> true,
	'query_var'			=> true,
	'rewrite'			=> false,
));

if ( ! function_exists( 'labora_cpt_testimonial_columns' ) ) {
	function labora_cpt_testimonial_columns( $columns ) {
		$columns = array(
			'cb'       			=> '<input type="checkbox" />',
			'title'       		=> esc_html__( 'Title','labora-pt-textdomain' ),
			'author'       		=> esc_html__( 'Author','labora-pt-textdomain' ),
			'testimonialcat'    => esc_html__( 'Categories','labora-pt-textdomain' ),
			'testimonial_email' => esc_html__( 'Email','labora-pt-textdomain' ),
			'date'       		=> esc_html__( 'Date','labora-pt-textdomain' ),
		);
		return $columns;
	}
	add_filter( 'manage_edit-testimonialtype_columns', 'labora_cpt_testimonial_columns' );
}
if ( ! function_exists( 'labora_cpt_testimonial_manage_columns' ) ) {
	function labora_cpt_testimonial_manage_columns( $name ) {
		global $post, $wp_query;
		switch ( $name ) {
			case 'testimonialcat':
				$terms = get_the_terms( $post->ID, 'testimonial_cat' );
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

			case 'testimonial_email':
				echo get_post_meta( get_the_ID(), 'testimonial_email', true );
				break;
		}
	}
	add_action( 'manage_posts_custom_column', 'labora_cpt_testimonial_manage_columns', 10, 2 );
}
