<?php
namespace SD\Freelance_Cape_Town\PostTypes;

/**
 * Set up theme defaults and register supported WordPress features.
 *
 * @since 0.1.0
 *
 * @uses add_action()
 *
 * @return void
 */
function setup() {
	
	$n = function( $function ) {
		return __NAMESPACE__ . "\\$function";
	};

	add_action( 'after_setup_theme',  $n( 'sd_do_post_types' ) );
	add_action( 'after_setup_theme',  $n( 'sd_do_taxonomies' ) );
}

/**
 * Registers Custom Post Types
 *
 * Registers all the necessary post (data) types for individual Eventful elements
 *
 * @uses register_post_type() For actual registration with WordPress
 *
 * @since 0.1.0
 *
 * @return void
 */
function sd_do_post_types() {
	
	// Register Hot Topics

	$flabels = array(
	    'name'               => __('Freelancers', 'sd'),
	    'singular_name'      => __('Freelancer', 'sd'),
	    'add_new'            => __('Add New', 'sd'),
	    'add_new_item'       => __('Add New Freelancer', 'sd'),
	    'edit_item'          => __('Edit Freelancer', 'sd'),
	    'new_item'           => __('New Freelancer', 'sd'),
	    'all_items'          => __('All Freelancers', 'sd'),
	    'view_item'          => __('View Freelancer', 'sd'),
	    'search_items'       => __('Search Freelancers', 'sd'),
	    'not_found'          => __('No Freelancers Found', 'sd'),
	    'not_found_in_trash' => __('No Freelancers Found in Trash', 'sd'),
	    'parent_item_colon'  => '',
	    'menu_name'          => __('Freelancers', 'sd')
  	);

	register_post_type( 'freelancer',
		array(
			'labels' => $flabels,
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'freelancers'),
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'capability_type' => 'post',
			'menu_icon' => 'dashicons-id',
			'show_in_rest'       => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_base' => 'freelancers',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'author',
				'custom-fields',
				'excerpt'
			),
		)
	);

	// ---------------

	$jlabels = array(
	    'name'               => __('Jobs', 'sd'),
	    'singular_name'      => __('Job', 'sd'),
	    'add_new'            => __('Add New', 'sd'),
	    'add_new_item'       => __('Add New Job', 'sd'),
	    'edit_item'          => __('Edit Job', 'sd'),
	    'new_item'           => __('New Job', 'sd'),
	    'all_items'          => __('All Jobs', 'sd'),
	    'view_item'          => __('View Job', 'sd'),
	    'search_items'       => __('Search Jobs', 'sd'),
	    'not_found'          => __('No Jobs Found', 'sd'),
	    'not_found_in_trash' => __('No Jobs Found in Trash', 'sd'),
	    'parent_item_colon'  => '',
	    'menu_name'          => __('Jobs', 'sd')
  	);

	register_post_type( 'job-listing',
		array(
			'labels' => $jlabels,
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'job-listings'),
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'capability_type' => 'post',
			'menu_icon' => 'dashicons-id',
			'show_in_rest'       => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_base' => 'job-listings',
			'supports' => array(
				'title',
				'editor',
				'author',
				'custom-fields',
				'excerpt'
			),
		)
	);

	// ---------------

	$slabels = array(
	    'name'               => __('Testimonial', 'sd'),
	    'singular_name'      => __('Testimonial', 'sd'),
	    'add_new'            => __('Add New', 'sd'),
	    'add_new_item'       => __('Add New Testimonial', 'sd'),
	    'edit_item'          => __('Edit Testimonial', 'sd'),
	    'new_item'           => __('New Testimonial', 'sd'),
	    'all_items'          => __('All Testimonials', 'sd'),
	    'view_item'          => __('View Testimonial', 'sd'),
	    'search_items'       => __('Search Testimonials', 'sd'),
	    'not_found'          => __('No Testimonials Found', 'sd'),
	    'not_found_in_trash' => __('No Testimonials Found in Trash', 'sd'),
	    'parent_item_colon'  => '',
	    'menu_name'          => __('Testimonials', 'sd')
  	);

	register_post_type( 'testimonial',
		array(
			'labels' => $slabels,
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'testimonial'),
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'capability_type' => 'post',
			'menu_icon' => 'dashicons-heart',
			'show_in_rest'       => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_base' => 'testimonials',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'author',
				'custom-fields',
				'excerpt'
			),
		)
	);

	// ---------------

	$cwlabels = array(
	    'name'               => __('Co-Working Spaces', 'sd'),
	    'singular_name'      => __('Co-Working Space', 'sd'),
	    'add_new'            => __('Add New', 'sd'),
	    'add_new_item'       => __('Add New Co-Working Space', 'sd'),
	    'edit_item'          => __('Edit Co-Working Space', 'sd'),
	    'new_item'           => __('New Co-Working Space', 'sd'),
	    'all_items'          => __('All Co-Working Spaces', 'sd'),
	    'view_item'          => __('View Co-Working Space', 'sd'),
	    'search_items'       => __('Search Co-Working Spaces', 'sd'),
	    'not_found'          => __('No Co-Working Spaces Found', 'sd'),
	    'not_found_in_trash' => __('No Co-Working Spaces Found in Trash', 'sd'),
	    'parent_item_colon'  => '',
	    'menu_name'          => __('Co-Working Spaces', 'sd')
  	);

	register_post_type( 'co-working-space',
		array(
			'labels' => $cwlabels,
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'co-working-spaces'),
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'capability_type' => 'post',
			'menu_icon' => 'dashicons-listing',
			'show_in_rest'       => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller',
			'rest_base' => 'co-working-spaces',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
				'author',
				'custom-fields',
				'excerpt'
			),
		)
	);


 }

 /**
 * Registers Custom Taxonomies
 *
 * Registers all the necessary custom taxonomies for speakers, hot topics, agenda items etc
 *
 * @uses register_taxonomy() For actual registration with WordPress
 *
 * @since 0.1.0
 *
 * @return void
 */
function sd_do_taxonomies() {
	
	// Register Speaker Type

	$stlabels = array(
		'name'              => __( 'Industries', 'sd' ),
		'singular_name'     => __( 'Industry', 'sd' ),
		'search_items'      => __( 'Search Industries', 'sd' ),
		'all_items'         => __( 'All Industries', 'sd' ),
		'parent_item'       => __( 'Parent Industries', 'sd' ),
		'parent_item_colon' => __( 'Parent Industry:', 'sd' ),
		'edit_item'         => __( 'Edit Industry', 'sd' ),
		'update_item'       => __( 'Update Industry', 'sd' ),
		'add_new_item'      => __( 'Add New Industry', 'sd' ),
		'new_item_name'     => __( 'New Industry', 'sd' ),
		'menu_name'         => __( 'Industries', 'sd' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $stlabels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => 'industry',
		'rewrite'           => array( 'slug' => 'industry' ),
		'show_in_rest'       => true,
		'rest_controller_class' => 'WP_REST_Taxonomies_Controller',
		'rest_base' => 'industries',
	);

	register_taxonomy( 'industry', array( 'freelancer', 'job-listing' ), $args );

	// ---------------
 }
