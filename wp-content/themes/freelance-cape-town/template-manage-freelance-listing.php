<?php
// Template Name: Manage Freelance Listing
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */

acf_form_head();

beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
//beans_remove_action( 'beans_breadcrumb' );
beans_remove_attribute( 'beans_main', 'class', 'uk-block' );

add_action( 'beans_breadcrumb_before_markup', function(){
	echo '<p>&nbsp;</p>';
} );

add_action( 'beans_breadcrumb_after_markup', function(){
	echo '<p>&nbsp;</p>';
} );

add_action('wp_footer', function(){
	?>
		<script>
			jQuery(document).ready(function(){
				jQuery(document).on('mousedown', 'form#post input[type="submit"]', function(e){
					if( jQuery('input#acf-field_56fe5821d3369').val().indexOf("Order") > -1 || jQuery('input#acf-field_56fe5821d3369').val().indexOf("order") > -1  ){
						UIkit.modal.alert("<h4 class=\"uk-text-center\">Please change the title of your listing to something other than your order number. This is the public facing name of your listing.</h4>");
					}
					e.defaultPrevented = true;
					e.preventDefault();
					return false;
				});
			});
		</script>
	<?php
}, 30);

function sd_view_content(){

	/**
	 * Add ACF form for front end posting
	 * @uses Advanced Custom Fields Pro
	 */

	$new_post = array(
		'post_id'  => get_query_var('fid') ? get_query_var('fid') : 'manage_freelance_listing', // Create a new post OR load from existing...
		'listing_type'  => 'manage_freelance_listing', // Create a new post OR load 
		'new_post'		=> array(
			'post_type'		=> 'freelancer',
			'post_status'	=> 'draft',
			//'post_title'  => $_POST['acf']['field_56e300b3821e5'],
        	//'post_content'  => $_POST['acf']['field_56e300b3822c5'],
		),
		// PUT IN YOUR OWN FIELD GROUP ID(s)
		'field_groups'       => array( 'group_56fe5821d058e' ), // Create post field group ID(s)
		'form'               => true,
		//'return'             => add_query_arg( array( 'saved' => 'yes' ) ), // Redirect to new post url %post_url%
		'html_before_fields' => '',
		'html_after_fields'  => '',
		'submit_value'       => 'Save Listing',
		'updated_message'    => '
			<div class="uk-alert uk-alert-info" data-uk-alert>
			    <a href="" class="uk-alert-close uk-close"></a>
			    <p>
			    	Your listing has been saved, thank you. If you\'ve marked your listing as "Ready to Publish", an administrator will review it shortly
			    </p>
			</div>
		',
		'uploader' => 'wp',
		'submit_value' => __("Update My Listing", 'acf'),
		'form_attributes' => [
			'class' => 'uk-form sd-form-manage-listings'
		],
		
	);
						
	?>
		<div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div class="uk-width-1-1">
					<h3><strong>Manage Freelance Listing:</strong> <span class="uk-text-primary"><?php //echo get_query_var('fid') ? get_the_title( get_query_var('fid') ) : NULL; ?></span></h3>
					<?php acf_form( $new_post ); ?>
				</div>
			</div>
		</div>
		<p>&nbsp;</p>
	<?php
}

beans_load_document();
