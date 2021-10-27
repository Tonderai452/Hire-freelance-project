<?php
//namespace SD\Freelance_Cape_Town\API;

add_action( 'rest_api_init', function () {
    register_rest_route( 'fcpt-api/v1', '/all', array( ///all/(?P<id>\d+)
        'methods' => 'GET',
        'callback' => 'sd_list_all_freelancers',
        'args' => array(
            'id' => array(
                'validate_callback' => function($param, $request, $key) {
                    //return is_numeric( $param );
                    return true;
                }
            ),
        ),
    ) );
} );

/**
 * Grab latest freelancers
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,
 * or null if none.
 */
function sd_list_all_freelancers( $data ) {
    
    $freelancers = get_posts( array(
        'post_type' => 'freelancer',
        'posts_per_page' => 200,
    ) );

    if ( empty( $freelancers ) ) {
        return new WP_Error( 'sd_no_freelancers', 'No Freelancers Found', array( 'status' => 404 ) );
    }

    return $posts;
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'fcpt-api/v1', '/freelancers-by-industry/(?P<industry>\S+)', array( ///all/(?P<id>\d+)
        'methods' => 'GET',
        'callback' => 'sd_list_freelancers_by_industry',
        'args' => array(
            'industry' => array(
                'validate_callback' => function($param, $request, $key) {
                    //return !empty( $param );
                    return true;
                }
            ),
        ),
    ) );
} );


/**
 * Grab freelancers by industry
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,
 * or null if none.
 */
function sd_list_freelancers_by_industry( $data ) {
    
    $freelancers = get_posts( array(
    	'post_type' => 'freelancer',
    	'status' => 'publish',
    	'tax_query' => array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'industry',
				'field'    => 'name',
				'terms'    => urldecode($data['industry']),
				'operator' => 'IN',
			),
		),
    ) );

    if ( empty( $freelancers ) ) {
        return new WP_Error( 'sd_no_freelancers', 'No Freelancers Found', array( 'status' => 404 ) );
    }

    return $freelancers;
    //return urldecode($data['industry']);

}

add_action( 'rest_api_init', function () {
    register_rest_route( 'fcpt-api/v1', '/all-industries/(?P<industry>\S+)', array( 
        'methods' => 'GET',
        'callback' => 'sd_list_all_industries',
        'args' => array(
            'industry' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_string( $param );
                }
            ),
        ),
    ) );
} );


/**
 * Grab freelancers by industry
 *
 * @param array $data Options for the function.
 * @return string|null Post title for the latest,
 * or null if none.
 */
function sd_list_all_industries( $data ) {
    
    $industries = get_terms( 'industry', array( 'hide_empty' => true, 'fields' => 'names', 'search' => $data['industry']) );

    if ( empty( $industries ) ) {
        return new WP_Error( 'sd_no_industries', 'No Industries Found', array( 'status' => 404 ) );
    }

    $formattedIndustries = [];

    foreach( $industries as $industry ){
    	$formattedIndustries[] = [
    		'value' => urldecode($industry),
    		'title' => urldecode($industry),
    		'url' => '#',
    		'text' => urldecode($industry)
    	];
    }

    return $formattedIndustries;

}

?>
