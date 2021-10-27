<?php
namespace SD\Freelance_Cape_Town\OptionsPages;

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

	add_action( 'after_setup_theme',  $n( 'sd_register_options_pages' ) );
}

/**
 * Registers Options Pages
 *
 * Registers ACF Pro Options Pages
 *
  * @since 0.1.0
 *
 * @return void
 */
function sd_register_options_pages() {
	
	if( function_exists('acf_add_options_page') ) {
	
		acf_add_options_page(array(
			'page_title' 	=> 'General Sitewide Settings',
			'menu_title'	=> 'General Sitewide Settings',
			'menu_slug' 	=> 'general-sitewide-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));

		acf_add_options_sub_page(array(
			'page_title' 	=> 'Social Media Options',
			'menu_title'	=> 'Social Media Options',
			'parent_slug' 	=> 'general-sitewide-settings',
		));
		
		acf_add_options_sub_page(array(
			'page_title' 	=> 'Email Addresses & Forms',
			'menu_title'	=> 'Email Addresses & Forms',
			'parent_slug'	=> 'general-sitewide-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));

		acf_add_options_page(array(
			'page_title' 	=> 'Home Page Titles',
			'menu_title'	=> 'Home Page Titles',
			'parent_slug' 	=> 'general-sitewide-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));

		acf_add_options_sub_page(array(
			'page_title' 	=> 'Footer Downloads',
			'menu_title'	=> 'Footer Downloads',
			'parent_slug'	=> 'general-sitewide-settings',
		));

		acf_add_options_page(array(
			'page_title' 	=> 'Custom Scripts',
			'menu_title'	=> 'Custom Scripts Settings',
			'parent_slug'	=> 'general-sitewide-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));
		
	}

 }
