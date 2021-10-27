<?php
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
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });

add_action( 'beans_header_after_markup', function(){
	?>
		<?php wc_print_notices(); ?>
		<!-- Hero Page Profile -->
		<section class="hero-profile uk-cover-background">
		  <div class="overlay"></div>
		  <div class="hero-content">
		  <div class="uk-container uk-container-center">

		    <div class="uk-grid">

		      <div class="uk-width-large-1-3 uk-text-center" data-uk-grid-margin>
		        <?php echo the_post_thumbnail( 'sd-portfolio-large', array( 'class' => 'profile-image' ) ); ?>
		      </div>

		      <?php if( have_posts() ): while( have_posts() ): the_post(); ?>

			      <div class="uk-width-large-2-3">

						<div class="min-header">
							<div class="uk-grid">
								<div class="uk-width-1-1">
									<h1 class="uk-float-left"><?php echo get_the_title(); ?></h1>
									<?php  
									
									$catid = '';
;									$current_user = wp_get_current_user();
								    $myterms = get_the_terms( get_the_ID(), 'industry');

									 if ( ! empty( $myterms ) ) {

										 foreach ( $myterms as $_term ) {
											 if ( $_term->parent == 0 ) //check for parent terms only
												 $term_slug =  $_term->name;
											 $catid = $_term->parent;
										 }

										 if ( ! empty( $catid ) ) {
											 $term_children = get_categories( array ( 'taxonomy' => 'industry', 'parent' => $catid, ));
										 }

									 }


                             if ( ! empty( $myterms ) ){
					         ?>
							<button class="uk-button uk-button-red uk-form-button-red writing_btn"><?php echo $term_slug; ?></button>
							 <?php } ?>
									  <ul class="social_link"> 
									  	<li>Share: &nbsp;</li>
									  	<li><a href="<?php echo get_field('linkedin_url' );?>"><i class="fa fa-linkedin fa-lg">&nbsp;</i></a></li>
									  	 <li><a href="<?php echo get_field('tiwtter_url' );?>"><i class="fa fa-twitter-square fa-lg">&nbsp;</i></a></li>
									  	   <li><a href="<?php echo get_field('email_address' );?>"><i class="fa fa-envelope fa-lg">&nbsp;</i></a></li>
									  	 <li><a href="<?php echo get_field('facebook_url' );?>"><i class="fa fa-facebook-square fa-lg">&nbsp;</i></a></li>
                                        
                                         
                                       
							          </ul>	
						</div>
						<div class="uk-width-1-1">
							<div style="overflow:hidden; padding:5px 0;">
								<?php
								$term_childrenddd = wp_get_post_terms( get_the_ID(), 'industry' );
								$terms_out = '';
								$term_count = count( $term_childrenddd );
								$term_iteration = 0;

								foreach ( $term_childrenddd as $indOut ){
									$term_iteration++;
									if( $indOut->parent !== 0 ){
										echo '<span class="c_industry">' . $indOut->name . ( $term_iteration < $term_count ? ' / ' : '' ) . '</span>';
									}?>
								<?php } ?>
							</div>
					    </div>
									  <div class="uk-width-1-1 skilspadding">

									   <?php $all_skils = get_post_meta( get_the_ID(), 'skils', true );
								
									    $sinle_skils =explode(",",$all_skils);
									    foreach($sinle_skils as $skils){
									  
									   ?>
									   <span class="uuk-button uk-button-blue uk-button-small margin_skils"><?php echo $skils;?></span>
									  <?php } ?>
									  </div>
							</div>
						</div>
	

					<?php if( $tagline = get_field('tagline') ) : ?>
				        <p class="lead uk-text-left" style="margin-bottom: 35px;">
				        	<span class="uk-text-large" style="font-size: 1.2em;">"<?php echo $tagline; ?>"</span>
				        </p>
			    	<?php endif; ?>

			      </div>

		      <?php endwhile; endif; wp_reset_postdata(); ?>

		    </div>
		  </div>
		</div>
		</section>
		<!-- End Hero Page Profile -->
	<?php
} );

function sd_view_content() {

?>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <script>
  $(function() {
    $(".video").click(function () {
      var theModal = $(this).data("target");
      videoSRC = $(this).attr("data-video");
      
      videoSRCauto = videoSRC;
      $(theModal + ' iframe').attr('src', videoSRCauto);
      $(theModal + ' button.close').click(function () {
        $(theModal + ' iframe').attr('src', videoSRC);
      });
    });
  });
  </script>
   <script>
  $(function() {
    $(".imagess").click(function () {
      var theModal = $(this).data("target");
      videoSRC = $(this).attr("data-video");
      
      videoSRCauto = videoSRC;
      $(theModal + ' img').attr('src', videoSRCauto);
      $(theModal + ' button.close').click(function () {
        $(theModal + ' img').attr('src', videoSRC);
      });
    });
  });

  </script>
<section class="section profile-main">
  <div class="uk-container uk-container-center">
    <div class="uk-grid">

    <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
      
      <!--<div class="uk-width-medium-1-1">
        <h3 class="uk-text-left">More About <?php echo get_the_title(); ?></h3><br>
      </div>-->
      
      <div class="uk-width-medium-1-3">
        <div class="widget">

            <h3>Contact Details</h3>

            <!--<?php if( $mobile = get_field( 'mobile_number' ) ) : ?>
	            <p>
	              <strong>Mobile</strong><br>
	              <span><?php echo is_user_logged_in() ? $mobile : "<a href='' <a data-uk-modal=\"{target: '#signUp'}\">Login or register</a> to view"; ?></span>
	            </p>
        	<?php endif; ?>

			<?php if( $work = get_field( 'tel_number' ) ) : ?>
	            <p>
	              <strong>Tel</strong><br>
	              <span><?php echo is_user_logged_in() ? $work : "<a href='' <a data-uk-modal=\"{target: '#signUp'}\">Login or register</a> to view"; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $email = get_field( 'email_address' ) && 1==2 ) : ?>
	            <p>
	              <strong>Email</strong><br>
	              <span><?php echo is_user_logged_in() ? $email : "<a href='' <a data-uk-modal=\"{target: '#signUp'}\">Login or register</a> to view"; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $web = get_field( 'website_url' ) ) : ?>
	            <p>
	              <strong>Web</strong><br>
	              <span><?php echo is_user_logged_in() ? "<a href=\"{$web}\" target=\"_blank\">{$web}</a>" : "<a href='' <a data-uk-modal=\"{target: '#signUp'}\">Login or register</a> to view"; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $fb = get_field( 'facebook_url' ) ) : ?>
	            <p>
	              <strong>Facebook</strong><br>
	              <span><?php echo is_user_logged_in() ? "<a href=\"{$fb}\" target=\"_blank\">{$fb}</a>" : "<a href='' <a data-uk-modal=\"{target: '#signUp'}\">Login or register</a> to view"; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $tw = get_field( 'tiwtter_url' ) ) : ?>
	            <p>
	              <strong>Twitter</strong><br>
	              <span><?php echo is_user_logged_in() ? "<a href=\"{$tw}\" target=\"_blank\">{$tw}</a>" : "<a href='' <a data-uk-modal=\"{target: '#signUp'}\">Login or register</a> to view"; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $li = get_field( 'linkedin_url' ) ) : ?>
	            <p>
	              <strong>LinkedIn</strong><br>
	              <span><?php echo is_user_logged_in() ? "<a href=\"{$li}\" target=\"_blank\">{$li}</a>" : "<a href='' <a data-uk-modal=\"{target: '#signUp'}\">Login or register</a> to view"; ?></span>
	            </p>
        	<?php endif; ?>
-->
        </div>

          <div class="widget">
            <h3>Message <?php echo get_the_title(); ?></h3><br>
			<p><strong>Send your brief directly to freelancer</strong></p>
            <?php if( is_user_logged_in() ) : ?>
            <form class="uk-form" id="sd_message_freelancer" method="post">
	            <?php wp_nonce_field( 'fcp_message_user_' . get_the_ID(), 'fcpt_message_user' ); ?>
	            <input type="hidden" name="profile_id" value="<?php echo get_the_ID(); ?>">
                <div class="uk-form-row">
	                <textarea rows="10" placeholder="Send <?php echo get_the_title(); ?> A Message" class="" id="sd_message" name="sd_message"></textarea>
	                <script src='https://www.google.com/recaptcha/api.js'></script>
	                <p>
	                    <div class="g-recaptcha" data-sitekey="6LcZpxwTAAAAAB3xgwObdLAwB71wvZ8TU_vmLtmc"></div>
	                </p>
	                <p style="margin-bottom: 0;">
	                    <button type="submit" class="uk-button uk-button-red">Send</button> <img id="sd_message_loader" style="display:none;" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/ajax-preloader.gif" width="25" height="25" alt="..."> <span id="sd_message_response"></span>
	                </p>
                </div>
            </form>
        	<?php else : ?>
        		<span class="uk-text-danger uk-text-bold">You must be registered and logged in to send a user a message. Please <a data-uk-modal="{target: '#signUp'}" href="<?php echo site_url(); ?>/my-account">login</a> or <a href="<?php echo site_url(); ?>/register">register</a>.</span><br><br>
        	<?php endif; ?>
          </div>

          <br>

      </div>

      <?php endwhile; endif; wp_reset_postdata(); ?>

      <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	      <div class="uk-width-medium-2-3 profile-main-content">
	        
	        <h3 class="uk-text-left">About <?php echo get_the_title(); ?></h3>
	        <p class="uk-text-left">
	        	<?php //the_content(); 
	        	echo get_field( 'bio_description' );?>
	        </p>

	        
      <?php endwhile; endif; wp_reset_postdata(); ?>

      <!-- Portfolio -->
		      <div class="uk-grid">
			      <div class="uk-width-medium-1-1">
				      <br>
				      <hr>
				      <h3 class="uk-text-left">Work by <?php echo get_the_title(); ?></h3>
				      <br>
			      </div>

			      <?php if( $portfolios = get_field( 'portfolio_collection' ) ) : ?>
				      <?php //echo "<pre>"; print_r($portfolios);?>
				      <?php foreach( $portfolios as $portfolio ) : ?>

					      <div class="uk-width-medium-1-3 feature-work item" data-uk-grid-margin>
						      <a href="<?php echo $portfolio['portfolio_item_image']['url']; ?>" data-uk-lightbox="{group:'my-group'}" title="<div class='image_detail'><h4> <?php echo $portfolio['portfolio_item_caption'];?> </h4><p>


						<?php $string = $portfolio['portfolio_item_description'];
						      $string = strip_tags($string);

						      if (strlen($string) > 180) {

							      $stringCut = substr($string, 0, 180);
							      $string = substr($stringCut, 0, strrpos($stringCut, ' '));
						      }   echo $string.'...';  if($string!=''){?></p><a href='<?php echo $portfolio["portfolio_item_url"];?>' style='padding-bottom:8px; display:inline-block; text-align:center;'><?php echo $portfolio['portfolio_item_url']; ?></a><?Php } ?></div>"  href="_blank">
							      <img class="imagess" src="<?php echo $portfolio['portfolio_item_image']['sizes']['portfolio-square-large']; ?>">
						      </a>
					      </div>

				      <?php endforeach; ?>

			      <?php endif; ?>
		      </div>


		      <?php

		      if($video_arr = get_field( 'Video_collection' ) ) :?>
		      <div class="uk-width-medium-1-1">
			      <br>
			      <hr>
			      <h3 class="uk-text-left extrapad">Showcase Video Work</h3>
			      <br>
		      </div>

		      <div class="uk-grid profile_pad">

			      <?php foreach( $video_arr as $videos ) :
			      if($videos['vid_type']=='Youtube'){
				      //echo "<pre>";print_r($videos);echo "</pre>";
				      $vid_url = (explode("=",$videos['Video_item_url']));
				      $videos['Video_item_url'];
				      $allowed_video_format = str_replace("watch?v=","embed/", $videos['Video_item_url']);
				      ?>
				      <div class="uk-width-medium-1-4 feature-work " data-uk-grid-margin>
					      <a href="#"><img src="http://img.youtube.com/vi/<?php echo $vid_url[1]; ?>/hqdefault.jpg" class="video" data-video="<?php echo $allowed_video_format; ?>" data-toggle="modal" data-target="#videoModal" hight="" width="" /></a>
					      <h5><?php echo $videos['Video_title']; ?></h5>
					      <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						      <div class="modal-dialog">

							      <div class="modal-content">
								      <div class="modal-body custom_padd">

									      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									      <iframe width="100%" height="350" src="" frameborder="0" allowfullscreen></iframe>
								      </div>
								      <div class="modal-footer vid_des">

									      <h5><?php echo $videos['Video_title']; ?></h5>
									      <p><?php echo $videos['Video_description']; ?></p>
								      </div>
							      </div>
						      </div>
					      </div>
				      </div>

			      <?php } ?>

			      <?php
			      if($videos['vid_type']=='Vimeo'){
			      //echo $videos['vid_type'];


			      $vid_vim_url= (explode("/",$videos['Video_item_url']));

			      $allowed_format_vimeo = str_replace("vimeo.com","player.vimeo.com/video", $videos['Video_item_url']);
			      if(isset($vid_vim_url[2]) && $vid_vim_url[2] =='vimeo.com'){
			      ?>

				      <script>
                          $(document).ready(function () {
                              var vimeoVideoUrl = 'https://vimeo.com/<?php echo $vid_vim_url[3]; ?>';
                              var match = /vimeo.*\/(\d+)/i.exec(vimeoVideoUrl);
                              if (match) {
                                  var vimeoVideoID = match[1];
                                  $.getJSON('http://www.vimeo.com/api/v2/video/' + vimeoVideoID + '.json?callback=?', { format: "json" }, function (data) {
                                      featuredImg = data[0].thumbnail_large;
                                      $('#thumbImg').attr("src", featuredImg);
                                  });
                              }
                          });
				      </script>

				      <div class="uk-width-medium-1-3 feature-work image_width" data-uk-grid-margin>
					      <a href="#"> <img id="thumbImg" src="http://img.youtube.com/vi/<?php echo $vid_url[1]; ?>/hqdefault.jpg" class="video" data-video="<?php echo $allowed_format_vimeo; ?>" data-toggle="modal" data-target="#videoModal1" hight="" width=""/></a>
					      <h5><?php echo $videos['Video_title']; ?></h5>
					      <div class="modal fade" id="videoModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						      <div class="modal-dialog">
							      <div class="modal-content">
								      <div class="modal-body custom_padd">
									      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									      <iframe width="100%" height="350" src="" frameborder="0" allowfullscreen></iframe>
								      </div>
								      <div class="modal-footer">

									      <h5><?php echo $videos['Video_title']; ?></h5>
									      <p class="vid_des"><?php echo $videos['Video_description']; ?></p>
								      </div>
							      </div>
						      </div>
					      </div>
				      </div>


				      <?php
			      } }?>

			      <?php endforeach; ?>

			      <?php endif;

			      //multiple video get rk
			      ?>

		      </div>
      <!-- End Portfolio -->
    
    </div>
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
