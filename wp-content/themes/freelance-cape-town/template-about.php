<?php
// Template Name: About
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */

beans_uikit_enqueue_components( array( 'lightbox' ), 'add-ons' );

beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
beans_remove_action( 'beans_breadcrumb' );

// Temporarily remove comments for this page 
//beans_remove_action('beans_comments_template');

//beans_remove_markup('beans_post_meta_item_author');
//add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });
add_action( 'beans_header_after_markup', function(){
	get_template_part( 'header', 'heroabout' );
	}); 
function sd_view_content() {

?>

<section class="section profile-main">
  <div class="uk-container uk-container-center">
     
		 
      <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	      
	        <h2> <?php echo get_the_title(); ?></h2>
	          	<?php the_content(); ?>
	              
      <?php endwhile; endif; wp_reset_postdata(); ?>
    
  
</div>




  
  
  	
</section>

<?php

}

add_action( 'wp_footer', 'sd_inject_ajax_logic', 30 );
function sd_inject_ajax_logic(){
	?>
	<script>
		jQuery(document).ready(function(){
			jQuery(document).on('submit', 'form#sd_message_freelancer', function(e){
				jQuery('img#sd_message_loader').attr('style','');
				jQuery('span#sd_message_response').html('');
				// Send message to ajax action
				jQuery.ajax({
					url: '<?php echo admin_url(); ?>admin-ajax.php',
					data: { 
						action : 'sd_contact_freelancer',
						sd_logged_in_user : '<?php echo wp_get_current_user()->ID; ?>',
						sd_logged_in_user_email : '<?php echo wp_get_current_user()->user_email; ?>',
						sd_freelancer_id :  <?php echo get_queried_object()->ID; ?>,
						sd_freelancer_email : '<?php echo get_field( 'email_address',  get_queried_object()->ID ); ?>',
						sd_message : jQuery('#sd_message').val(),
						"g-recaptcha-response" : grecaptcha.getResponse(),
						wp_nonce : '<?php echo wp_create_nonce( 'sd_message_freelancer' ); ?>'
					},
					method: 'POST',
					dataType: 'json',
					success : function( r ){
						// r.success
						if( r.success !== 'y' ){
							// Replace spinner with error message
							jQuery('span#sd_message_response').html("<i class=\"uk-icon uk-icon-close uk-text-danger\"></i> Error sending message...");
						}else{
							if( r.success == 'y' ){
								// Replace spinner with success message
								jQuery('span#sd_message_response').html("<i class=\"uk-icon uk-icon-check uk-text-success\"></i> Message sent, thank you!");
							}
						}
						jQuery('img#sd_message_loader').attr('style','display:none;');
					}

				});
				return false;
				e.returnValue = false;
				e.preventDefault;
			});
		});
	</script>
	<?php
}

beans_load_document();?> 	
<?php 
