<?php
// Template Name: Manage Co-Working Space Listing
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

function sd_view_content(){

	/**
	 * Add ACF form for front end posting
	 * @uses Advanced Custom Fields Pro
	 */

	$new_post = array(
		'post_id'  => get_query_var('fid') ? get_query_var('fid') : 'manage_co_working_space_listing', // Create a new post OR load from existing...
		'new_post'		=> array(
			'post_type'		=> 'co-working-space',
			'post_status'	=> 'draft',
			//'post_title'  => $_POST['acf']['field_56e300b3821e5'],
        	//'post_content'  => $_POST['acf']['field_56e300b3822c5'],
		),
		// PUT IN YOUR OWN FIELD GROUP ID(s)
		'field_groups'       => array( 'group_56fe50c1eb560' ), // Create post field group ID(s)
		'form'               => true,
		//'return'             => add_query_arg( array( 'saved' => 'yes' ) ), // Redirect to new post url %post_url%
		'html_before_fields' => '',
		'html_after_fields'  => '',
		'submit_value'       => 'Save Listing',
		'updated_message'    => '
			<div class="uk-alert uk-alert-success" data-uk-alert>
			    <a href="" class="uk-alert-close uk-close"></a>
			    <p>
			    	Your listing has been submitted to us for review, thank you.
			    </p>
			</div>
		',
		'uploader' => 'wp',
		'submit_value' => __("Update My Co-Working Space", 'acf'),
		'form_attributes' => [
			'class' => 'uk-form sd-form-manage-listings'
		],
		
	);
						
	?>
		<div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div class="uk-width-1-1">
				
<?php
    $current_user = wp_get_current_user();
  $user_role_free=trim($current_user->roles[0]);
   $role_co ='Co-working(Office_space)';
         $cp_role = trim($role_co);
   
  
?>
					<h3><strong>Manage Co Working Space Listing:</strong> <span class="uk-text-primary"><?php  if ($user_role_free == $cp_role) { echo $current_user->display_name; } ?></span></h3>
					<a class="uk-button uk-button-blue uk-button-small" href="<?php echo get_site_url(); ?>/dashboard">Back To Dashboard</a>
					<?php acf_form( $new_post ); ?>
					




				</div>
			</div>
		</div>
		<p>&nbsp;</p>
	<?php
}

beans_load_document();
