<?php
/*
 * Add new taxonomy, NOT hierarchical (like tags)
 * taxonomy = gallery_category
 * object type = gallery (Name of the object type for the taxonomy object)
 */
if ( ! function_exists( 'labora_cpt_gallery' ) ) {
	function labora_cpt_gallery() {

		$labels = array(
			'name'				 => esc_html__( 'Gallery','labora-pt-textdomain' ),
			'singular_name'		 => esc_html__( 'ALL Gallery','labora-pt-textdomain' ),
			'add_new'			 => esc_html__( 'Add New Gallery', 'labora-pt-textdomain' ),
			'add_new_item'		 => esc_html__( 'Add New Gallery','labora-pt-textdomain' ),
			'edit_item'			 => esc_html__( 'Edit Gallery','labora-pt-textdomain' ),
			'new_item'			 => esc_html__( 'New Item','labora-pt-textdomain' ),
			'view_item'			 => esc_html__( 'View Gallery Item','labora-pt-textdomain' ),
			'search_items'		 => esc_html__( 'Search Gallery Item','labora-pt-textdomain' ),
			'not_found'			 => esc_html__( 'Nothing found','labora-pt-textdomain' ),
			'not_found_in_trash' => esc_html__( 'Nothing found in Trash','labora-pt-textdomain' ),
			'parent_item_colon'	 => '',
			'all_items' 		 => esc_html__( 'All Galleries','labora-pt-textdomain' ),
		);
		$labora_gallery_slug = get_option( 'labora_gallery_slug' ) ? get_option( 'labora_gallery_slug' ) :'gallery';

		$args = array(
			'labels'				=> $labels,
			'public'				=> true,
			'exclude_from_search'	=> false,
			'show_ui'				=> true,
			'capability_type'		=> 'post',
			'hierarchical'			=> false,
			'rewrite'				=> array( 'slug' => $labora_gallery_slug, 'with_front' => true ),
			'query_var'				=> false,
			'menu_position'			=> null,
			'menu_icon'				=> 'dashicons-images-alt2',
			'supports'				=> array( 'title','thumbnail', 'page-attributes','editor','comments','tags' ),
			'taxonomies' 			=> array( 'gallery_category', 'post_tag' )
		);
		register_post_type( 'gallery' , $args );
	}
	add_action( 'init', 'labora_cpt_gallery' );
}
if ( ! function_exists( 'labora_cpt_gallery_taxonomies' ) ) {
	function labora_cpt_gallery_taxonomies() {
		register_taxonomy( 'gallery_category', 'gallery', array(
			'hierarchical'		=> true,
			'labels' => array(
				'name' 				=> esc_html__( 'Gallery Categories', 'labora-pt-textdomain' ),
				'singular_name' 	=> esc_html__( 'Gallery Categories', 'labora-pt-textdomain' ),
				'search_items' 		=> esc_html__( 'Search Gallery','labora-pt-textdomain' ),
				'parent_item' 		=> esc_html__( 'Parent Gallery' ,'labora-pt-textdomain' ),
				'parent_item_colon' => esc_html__( 'Parent Gallery:' ,'labora-pt-textdomain' ),
				'edit_item' 		=> esc_html__( 'Edit Gallery','labora-pt-textdomain' ),
				'update_item' 		=> esc_html__( 'Update Gallery Category','labora-pt-textdomain' ),
				'add_new_item' 		=> esc_html__( 'Add Gallery Category','labora-pt-textdomain' ),
				'new_item_name' 	=> esc_html__( 'New Gallery ','labora-pt-textdomain' ),
				'gallery_name' 	    => esc_html__( 'Gallery Categories' ,'labora-pt-textdomain' ),
			),
			'show_ui'			=> true,
			'query_var'			=> true,
			'rewrite'			=> false,
			'sort' 				=> true,
			'args' 				=> array( 'orderby' => 'menu_order' ),
			'has_archive'       => true,

		));
	}
	add_action( 'init', 'labora_cpt_gallery_taxonomies' );
}

if ( ! function_exists( 'labora_cpt_gallery_columns' ) ) {
	function labora_cpt_gallery_columns( $columns ) {
		$columns = array(
			'cb'      		 => '<input type="checkbox" />',
			'title'      	 => esc_html__( 'Title','labora-pt-textdomain' ),
			'venue'          => esc_html__( 'Venue','labora-pt-textdomain' ),
			'gallery_category' => esc_html__( 'Categories','labora-pt-textdomain' ),
			'gallery_id'	 => esc_html__( 'ID\'s','labora-pt-textdomain' ),
			'thumbnail'  	 => esc_html__( 'Thumbnails','labora-pt-textdomain' ),
		);
		return $columns;
	}
	add_filter( 'manage_edit-gallery_columns', 'labora_cpt_gallery_columns' );
}

if ( ! function_exists( 'labora_cpt_gallery_manage_columns' ) ) {
	function labora_cpt_gallery_manage_columns( $name ) {
		global $wpdb, $wp_query,$post;
		switch ( $name ) {
			case 'venue':
				echo get_post_meta( get_the_ID(),'gallery_venue',true );
				break;
			case 'gallery_category':
				$terms = get_the_terms( $post->ID, 'gallery_category' );
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
					echo '<em>'.esc_html__( 'No terms','labora-pt-textdomain' ).'</em>';
				}
				break;
			case 'gallery_id':
				echo get_the_ID();
				break;
		}
	}
	add_action( 'manage_posts_custom_column', 'labora_cpt_gallery_manage_columns', 10, 2 );
}
