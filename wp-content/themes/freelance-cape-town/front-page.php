<?php
/*Template Name: Home Page*/
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */

beans_uikit_enqueue_components( array( 'slideshow', 'autocomplete' ), 'add-ons' );

beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
beans_remove_action( 'beans_breadcrumb' );
beans_remove_attribute( 'beans_main', 'class', 'uk-block' );

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });


add_action( 'beans_header_after_markup', function(){
	
	get_template_part( 'header', 'hero' );


	
} );

function sd_view_content() {

?>



<?php

SESSION_START();
$_SESSION['regCoWorker'] = $_GET['regCoWorker'];

$_SESSION['regFreelancer'] = $_GET['regFreelancer'];





?>
	
	<!-- Pricing Table -->
	<section class="section pricing uk-text-center" id = "pricingdiv">
	  <div class="uk-container uk-container-center">
	  	<div class="uk-width-1-1" >
	  		<div class="uk-width-1-3 left_column" id="sd_frontpage_products" style="margin-right:-25px;">
			<img class="coimg" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/img-1.png" alt="">	
		
	  			<div class="quckserarch">
	  			<h1>CO WORKING <br>OFFICE SPACE</h1>
	  			<p><a href="http://freelance.capetown/co-working-spaces/" target="_blank"><strong>-FIND</strong><span></span></a><p>
	  			<p><a name="regCoWorker" id="regCoWorker" href="http://freelance.capetown/registration-step-1?role=regCoWorker"><strong>-REGISTER</strong><span> </span></a></p> 
	  			</div>
	  		</div>
	  		<div class="uk-width-1-3 left_column" id="sd_frontpage_products" style="margin-right:25px;">
	  		<img class="coimg" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/img-2.png" alt="">
	  			  			<div class="quckserarch">
	  			<h1>BECOME A<br> FREELANCER</h1>
	  			<p><span class="pricelist">R599</span><?php  echo '<a href="http://freelance.capetown/registration-step-1?role=regFreelancer" name="regFreelancer" id="regFreelancer"><strong>-6 MONTH</strong> <span>MEMBERSHIP</span></a>'; ?></p>
	  			<p><span class="pricelist">R999</span><?php  echo '<a href="http://freelance.capetown/registration-step-1?role=regFreelancer"><strong>-1 YEAR</strong> <span>MEMBERSHIP</span></a>'; ?></p>
	  			</div>
	  		</div>
	  		
	  		<div class="uk-width-1-3 left_column" id="sd_frontpage_products">
	  <img class="coimg" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/img-3.png" alt="">
	   			<div class="quckserarch">
	  			<h1>FIND A <BR>FREELANCER</h1>
	  			<p><a href="http://freelance.capetown/freelancers/" target="_blank"><strong>-QUICK</strong><span>SEARCH</span></a></p>
	  			<p><?php  echo '<a href="http://freelance.capetown/registration-step-1?role=FindFreelancer"><strong>-BECOME </strong><span>Freelance finder client</span></a>'; ?></p>
	  			</div>
	  		</div>
	  	</div>
	  </div>
	</section>
	<!-- End Pricing Table -->

	<section class="section top-freelancers">
	  <div class="uk-container uk-container-center">
	    <h3 class="uk-text-center">Featured Freelancers in Cape Town</h3>
	    <p class="section-lead uk-text-center">These are our featured freelancers. Maybe your face will be here one day?</p>
	    <div class="uk-grid" data-uk-grid-match>

		<?php
			$featured_freelancers = new WP_Query([
				'posts_per_page' => 12,
				'post_type' => 'freelancer',
				'meta_key' => 'featured_listing',
				'meta_value' => 'yes'
			]);

			if( $featured_freelancers->have_posts() ){
				while( $featured_freelancers->have_posts() ){ $featured_freelancers->the_post(); global $post;
					?> 
						<div class="uk-width-medium-1-4 uk-width-1-1 freelancer-item uk-position-relative" data-uk-grid-margin style="margin-bottom:25px;">
							<a href="<?php echo the_permalink(); ?>">
		                    	<?php echo the_post_thumbnail('portfolio-square-medium', array('class' => 'border-highlight')); ?>
		                    </a>
							<div class="fct-caption uk-text-left">
								<h4 class="fct-title"><?php echo $post->post_title; ?> <!--<small>&nbsp;&nbsp;<i class="fa fa-star"></i><span>&nbsp;15</span></small>--></h4>
								<p class="fct-industry-tag">
			                      <?php
			                      if( $industries = get_field( 'industries' ) ) :
			                        $indOut = "<small class=\"uk-text-small\">"; $c = 0;
			                        foreach( $industries as $k=>$v ) : $c++;
			                          if( $c > 3 ){
			                            $indOut .= "......";
			                            break(1);
			                          }else{
			                            $indOut .=  "<strong>" . ( get_term( $v, 'industry' )->name ) . "</strong> / ";
			                          }
			                        endforeach;
			                        $indOut = substr($indOut, 0, -3);
			                        $indOut .= "</small>";
			                        echo $indOut;
			                      endif;
			                    ?>
			                    <div class="uk-clearfix">&nbsp;</div>
			                    </p>
								<a href="<?php echo get_the_permalink(); ?>" class="uk-button uk-button-blue uk-button-small" role="button" style="position:absolute;bottom:0;left:35px;">View Profile</a>
							</div>
						</div>
					<?php
				}
			}

			wp_reset_postdata(); // Reset that biatch
		?>
	      
	    </div>
	  </div>
	</section>
	<!-- End Top Freelancers -->

	<!-- Banner -->
	<section class="section banner">
	  <div class="uk-container uk-container-center">
	    <div class="uk-grid">
	      <div class="uk-width-medium-7-10 uk-push-3-10">
	        <h2>Looking for some talent?</h2>
	        <a href="<?php echo site_url(); ?>/freelancers" class="uk-button uk-button-red cta-btn" role="button">All Freelancers</a>
	      </div>
	    </div>
	  </div>
	</section>
	<!-- End Banner -->


	<!-- Testimonials -->
	<section class="section testimonials uk-text-center">
	  <div class="uk-container uk-container-center">
	    <h3>Tesitmonials</h3>
	    <p class="section-lead">Take a look at what fellow freelancers are saying about us</p>
	      <div class="uk-slidenav-position" data-uk-slideshow>
	          <div class="uk-slider-container">
	              <ul class="uk-slideshow uk-text-center">
	                <li>
	                    <div class="uk-width-small-1-1" data-uk-grid-match>
	                    <p class="uk-text-center test-quote"><em>Freelance Cape Town is unique in a sense that it gives local
	                      Freelancers the chance to fulfil local job demand.
	                      And it does it well!</em></p>
	                    <p class="author uk-text-center"><strong>Simon Dowdles</strong>, Web Developer</p>
	                    </div>
	                </li>
	                <li>
	                  <div class="uk-width-small-1-1" data-uk-grid-match>
	                  <p class="uk-text-center test-quote"><em>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sed dignissim magna,
	                    And it does it well!</em></p>
	                  <p class="author uk-text-center"><strong>Simon Dowdles</strong>, Web Developer</p>
	                  </div>
	                </li>
	                <li>
	                  <div class="uk-width-small-1-1" data-uk-grid-match>
	                  <p class="uk-text-center test-quote"><em>Nam ultrices tempor purus vitae gravida. Suspendisse euismod elementum tortor,
	                    And it does it well!</em></p>
	                  <p class="author uk-text-center"><strong>Simon Dowdles</strong>, Web Developer</p>
	                  </div>
	                </li>
	                <li>
	                  <div class="uk-width-small-1-1" data-uk-grid-match>
	                  <p class="uk-text-center test-quote"><em>Nulla suscipit, massa ac pretium tristique, elit dui viverra leo,
	                    And it does it well!</em></p>
	                  <p class="author uk-text-center"><strong>Simon Dowdles</strong>, Web Developer</p>
	                  </div>
	                </li>
	              </ul>
	              <ul class="uk-dotnav uk-dotnav-contrast uk-flex-center">
	                  <li data-uk-slideshow-item="0"><a href=""><img width="35" height="35" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/simonlogo.jpg"></a></li>
	                  <li data-uk-slideshow-item="1"><a href=""><img width="35" height="35" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/testi-icon-2.jpg"></a></li>
	                  <li data-uk-slideshow-item="2"><a href=""><img width="35" height="35" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/testi-icon-3.jpg"></a></li>
	                  <li data-uk-slideshow-item="3"><a href=""><img width="35" height="35" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/testi-icon-4.jpg"></a></li>
	              </ul>
	            </div>

	          </div>

	      </div>
	</section>

	<!-- End Testimonials -->

<?php

}

beans_load_document();
