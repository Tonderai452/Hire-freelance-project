<?php
namespace SD\Freelance_Cape_Town\Media;

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

	add_action( 'init',  $n( 'mediaStuff' )        );
}

function mediaStuff() {
	add_image_size( 'portfolio-square-xsmall', 80, 80, array('center', 'center') );
	add_image_size( 'portfolio-square-small', 125, 125, array('center', 'center') );
	add_image_size( 'portfolio-square-medium', 250, 250, array('center', 'center') );
	add_image_size( 'portfolio-square-large', 500, 500, array('center', 'center') );
	add_image_size( 'portfolio-square-xlarge', 800, 800, array('center', 'center') );
}
