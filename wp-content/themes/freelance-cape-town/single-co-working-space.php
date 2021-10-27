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
//beans_remove_action( 'beans_breadcrumb' );

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });

add_action( 'beans_header_after_markup', function(){
	?>
		<!-- Hero Page Profile -->
		<?php wc_print_notices(); ?>
		<section class="hero-profile uk-cover-background" <?php echo get_field( 'hero_image' )['url'] ? 'style="background: url('. (get_field( 'hero_image' )['url']) .') center center no-repeat; background-size:cover;"' : NULL; ?>>
		  
		  <div class="overlay">
		  	

		  </div>

		  <div class="hero-content">
		  <div class="uk-container uk-container-center">

		    <div class="uk-grid">

		      <div class="uk-width-large-1-3 uk-text-center" data-uk-grid-margin>
		        <?php echo the_post_thumbnail( 'sd-portfolio-large', array( 'class' => 'profile-image' ) ); ?>
		      </div>

		      <?php if( have_posts() ): while( have_posts() ): the_post();?>

			      <div class="uk-width-large-2-3">

						<div class="min-header">
							<div class="uk-grid">
								<div class="uk-width-1-1">
									<h1 class="uk-float-left"><?php echo get_the_title(); ?></h1>
								</div>
							</div>
						</div>
			        
						 <?php if( $cust_facilities = get_post_meta( get_the_ID(), 'special_facilities', true )): ?>
				        <div class="freelance-skill-tags" style="white-space: inherit !important;">
				        	<?php foreach( $cust_facilities as $sp_facility ) : ?>
					            <span class="uk-button uk-button-small uk-button-black" style="margin-bottom:10px;"><?php echo $sp_facility; ?></span>
				       		<?php endforeach; ?>
				        </div>
			    	<?php endif; ?>
			        <?php if( $facilities = get_field( 'facilities' ) ) : ?>
				        <div class="freelance-skill-tags" style="white-space: inherit !important;">
				        	
				        		<div class="fac_button">
				        	 <span class="uk-button-green"> Other Facilities </span></div>
				        	<?php foreach( $facilities as $facility ) : ?>
					            <span class="uk-button uk-button-small uk-button-blue" style="margin-bottom:10px;"><?php echo $facility['facility_name']; ?></span>
				       		<?php endforeach; ?>
				        </div>
			    	<?php endif; ?>

					<?php if( $excerpt = get_the_excerpt() && 1==2 ) : ?>
				        <p class="lead uk-text-left">
				        	<?php echo $excerpt; ?>
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

<section class="section profile-main">
  <div class="uk-container uk-container-center">
    <div class="uk-grid">

    <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
      
      <!--<div class="uk-width-medium-1-1">
        <h3 class="uk-text-left">More About <?php echo get_the_title(); ?></h3><br>
      </div>-->
      
      <div class="uk-width-medium-1-3">
        <div class="widget">

            <h3>Contact Details</h3><br>

            <?php if( $address = get_field( 'address' ) ) : ?>

	            <div id="sd_map" style="width:100%;height:300px;"></div>
				
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAQIi_HF1l3XDRpKX0zKNlivki0Q1Llopg&callback=initMap" async defer></script>

				<script>

					var map;
	      			function initMap() {
						jQuery(document).ready(function(){ 
							// GOOGLE MAPS
			                $mapCoOrdinates = {};
			                jQuery.ajax({
						        url : "https://maps.google.com/maps/api/geocode/json?address=<?php echo urlencode(str_replace('&','and',$address)); ?>&sensor=false&key=AIzaSyAQIi_HF1l3XDRpKX0zKNlivki0Q1Llopg",
						        method : "post",
						        success: function(data){
					            	if(data["status"] == "OK"){
						                $mapCoOrdinates.lat = data.results[0].geometry.location.lat;
						                $mapCoOrdinates.long = data.results[0].geometry.location.lng;
						                // START GOOGLE MAP
						                var map;
						                tHasMap = true;
					                    myLatlng = new google.maps.LatLng($mapCoOrdinates.lat,$mapCoOrdinates.long);
					                    myLatlngMarker = {lat: $mapCoOrdinates.lat, lng: $mapCoOrdinates.long};
					                    var mapOptions = {
					                        zoom: 16,
					                        center: new google.maps.LatLng($mapCoOrdinates.lat, $mapCoOrdinates.long)
					                    };
					                    var map = new google.maps.Map(document.getElementById("sd_map"), mapOptions);
					                    var marker = new google.maps.Marker({
										    position: myLatlngMarker,
										    map: map,
										    title: '<?php echo get_the_title(); ?>'
										});
						                // END GOOGLE MAP
						            }else{
						                jQuery("#sd_map").hide();
						            }
						        },
						        dataType: "json"
					    	});
			                // END GOOGLE MAPS
						});

					}
				</script>

			<?php endif; ?>

            <?php if( $address = get_field( 'address' ) ) : ?>
	            <p>
	              <strong>Address</strong><br>
	              <span><?php echo $address; ?></span>
	            </p>
        	<?php endif; ?>

			<?php if( $work = get_field( 'tel_number' ) ) : ?>
	            <p>
	              <strong>Tel</strong><br>
	              <span><?php echo $work; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $email = get_field( 'email_address' ) ) : ?>
	            <p>
	              <strong>Email</strong><br>
	              <span><?php echo $email; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $web = get_field( 'website_url' ) ) : ?>
	            <p>
	              <strong>Web</strong><br>
	              <span><?php echo "<a href=\"{$web}\" target=\"_blank\">{$web}</a>"; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $fb = get_field( 'facebook_url' ) ) : ?>
	            <p>
	              <strong>Facebook</strong><br>
	              <span><?php echo "<a href=\"{$fb}\" target=\"_blank\">{$fb}</a>"; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $tw = get_field( 'twitter_url' ) ) : ?>
	            <p>
	              <strong>Twitter</strong><br>
	              <span><?php echo "<a href=\"{$tw}\" target=\"_blank\">{$tw}</a>"; ?></span>
	            </p>
        	<?php endif; ?>

            <?php if( $li = get_field( 'linkedin_url' ) ) : ?>
	            <p>
	              <strong>LinkedIn</strong><br>
	              <span><?php echo "<a href=\"{$li}\" target=\"_blank\">{$li}</a>"; ?></span>
	            </p>
        	<?php endif; ?>

        </div>

          <div class="widget">
			<?php if( is_user_logged_in() ) : ?>
            <h3>Message <?php echo get_the_title(); ?></h3><br>
            <form class="uk-form" id="sd_message_co_working" method="post">
              <div class="uk-form-row">
                <?php wp_nonce_field( 'fcp_message_user_' . get_the_ID(), 'fcpt_message_user' ); ?>
                <input type="hidden" name="profile_id" value="<?php echo get_the_ID(); ?>">
                <textarea name="sd_message" rows="10" placeholder="Send <?php echo get_the_title(); ?> A Message" class=""></textarea>
                <p style="margin-bottom: 0;">
                  <button type="submit" class="uk-button uk-button-red">Send</button>
                </p>
              </div>
            </form>
			<?php else : ?>
				<span class="uk-text-danger uk-text-bold">You must be registered and logged in to send a co-working space a message. Please <a data-uk-modal="{target: '#signUp'}" href="<?php echo site_url(); ?>/my-account">login</a> or <a href="<?php echo site_url(); ?>/register">register</a>.</span><br><br>
			<?php endif; ?>
          </div>

          <br>

      </div>

      <?php endwhile; endif; wp_reset_postdata(); ?>

      <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	      <div class="uk-width-medium-2-3 profile-main-content">
	      <?php $per_hour = get_field( 'per_hour' ); 
	      $per_day = get_field( 'per_day' ); 
	      $per_week = get_field( 'per_week' ); 
	      $per_month = get_field( 'per_month' ); 
	      
	      
	      
	      
	      ?>
	       <table class="uk-table uk-table-condensed uk-table-striped" style="margin-bottom:0;">
	        		<thead>
	        		<tr>
		        			<th class="uk-width-1-2" colspan="2">RATES / FEES</th>
		        			
	        			</tr>
	        		</thead>
	        		<tbody>
	        			
	        			<tr>
	        				<td class="minwidth"><?php if ( ! empty( $per_hour ) ){ echo 'R' . $per_hour;} else { echo "Not Applicable";}?></td>
	        				<td>Per/Hour</td></tr>
	        				<tr>
	        				<td class="minwidth"><?php if( ! empty( $per_day ) ){ echo 'R' . $per_day;} else { echo "Not Applicable"; } ?></td>
	        				<td>Per/Day</td></tr>
	        				
	        				<tr><td class="minwidth"><?php if( ! empty( $per_week ) ){ echo 'R' . $per_week;} else { echo "Not Applicable"; }  ?></td>
	        				<td>Per/Week</td></tr>
	        				<tr><td class="minwidth"><?php if( ! empty ( $per_month ) ) { echo 'R' . $per_month;} else{ echo "Not Applicable";} ?></td>
	        				<td>Per/Month</td></tr>
	        				
	        			
	        	
	        		</tbody>
	        	</table>
	      
	      
	      
	        <?php if( $rates = get_field( 'pricing_options' ) ) : ?>
	        	<table class="uk-table uk-table-condensed uk-table-striped" style="margin-bottom:0;">
	        		<thead>
	        			<tr>
		        			<th class="uk-width-1-2" colspan="2">ADDITIONAL SERVICES AND PRICES</th>
	        			</tr>
	        		</thead>
	        		<tbody>
	        			<?php
				            if ( ! empty( $rates ) ) {
					            foreach ( $rates as $rate ) :
						            if ( ! empty( $rate[ 'pricing_label' ] ) && ! empty( $rate[ 'price' ] ) ) :
						            ?>
						            <tr>
							            <td class="minwidth"><?php echo $rate['pricing_label']; ?></td>
							            <td><?php echo 'R' . number_format( $rate[ 'price' ], 2, '.', ',' ); ?></td>
						            </tr>
						            <?php
					                endif;
					            endforeach;
				            }
	        		?>
	        		</tbody>
	        	</table>
	        	        		        	
	        	<hr style="margin-top:0;">
	        <?php endif; ?>
	       
	        
	        
	        <h3 class="uk-text-left">About <?php echo get_the_title(); ?></h3>
	       

	        <p class="uk-text-left">
	     	        	<?php the_content(); ?>
	        </p>
	        <?php if( $facilities = get_field( 'facilities' ) ) : ?>
	        	<div class="uk-clearfix">&nbsp;</div>
	        	<table class="uk-table uk-table-condensed uk-table-striped" style="margin-bottom:0;">
	        		<thead>
	        			<tr>
		        			<th class="uk-width-1-2">FACILITIES</th>
	        			</tr>
	        		</thead>
	        		<tbody>
	        			<?php $c = 0; foreach( $facilities as $facility ): $c++; ?>
	        			<tr>
	        				<td><?php echo '- ' . $facility['facility_name']; ?></td>
	        			</tr>
	        		<?php endforeach; ?>
	        		</tbody>
	        	</table>
	        	<hr style="margin-top:0;">
	        <?php endif; ?>
	        <div class="uk-clearfix">&nbsp;</div>
	        <?php if( $portfolios = get_field( 'image_gallery' ) ) : ?>
				<div class="uk-grid">
				<?php foreach( $portfolios as $portfolio ) : ?>
					<div class="uk-width-medium-1-3 feature-work" data-uk-grid-margin>
						<a href="<?php echo $portfolio['url']; ?>" data-uk-lightbox="{group:'my-work'}" href="_blank">
							<img src="<?php echo $portfolio['sizes']['portfolio-square-large']; ?>">
						</a>
					</div>
			    <?php endforeach; ?>
				</div>
		 	<?php endif; ?>
	      </div>

      <?php endwhile; endif; wp_reset_postdata(); ?>
    
    </div>
</div>
</section>

<?php

}

beans_load_document();
