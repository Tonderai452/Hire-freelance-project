<?php

	// Disable comments on pages.
	add_action( 'init', 'beans_child_remove_page_comments' );

	function beans_child_remove_page_comments() {
		remove_post_type_support( 'page', 'comments' );  
	}

	beans_remove_attribute('beans_footer', 'class', 'uk-block');
	beans_wrap_markup('beans_footer', 'sd_footer', 'footer');
	add_action('sd_footer_prepend_markup', 'sd_add_footer_main');
	
	function sd_add_footer_main(){
		
		echo beans_open_markup('sd_main_footer', 'div', ['class'=>'main-footer']);
		echo '<div class="uk-container uk-container-center">';
			echo '<div class="uk-grid">';
				
				echo beans_open_markup('sd_main_footer_col_one', 'div', ['class' => 'uk-width-medium-1-2 footer-widget', 'data-uk-grid-margin']);
					?>
							<h3 class="main-footer-title">Recent Blogs </h3>
						<?php
							$newest_freelancers = new WP_Query([
								'posts_per_page' => 2,
								'post_type' => 'post',
								'order' => 'DESC'
							]);

							if( $newest_freelancers->have_posts() ) :
								while( $newest_freelancers->have_posts() ) : $newest_freelancers->the_post();
									global $post;
									?>
									<div class="mini-post uk-grid-margin">
						                <div class="uk-grid">
						                  <div class="uk-width-2-10">

						                  	<?php 
						                  	if (has_post_thumbnail()) {
						                     echo the_post_thumbnail('portfolio-square-medium', array('class' => 'mini-post-image footer_img')); }
                                         else { ?>

						                    <image src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/noimage.jpg" class="mini-post-image wp-post-image footer_img"/>
						                    <?php } ?>
						                  </div>

						                  <div class="uk-width-8-10">
						                    <h4 class="foo_link"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></h4></a>
						                    <p class="mini-post-timestamp-meta"><small>Joined on <?php echo get_the_date('Y-m-d'); ?></small></p>
						                  </div>
						                </div>
						            </div>
			            			<?php
			            		endwhile;
			            	endif;
			            	wp_reset_postdata();

			            ?>
					<?php
				echo beans_close_markup('sd_main_footer_col_one', 'div');
				
				
				
				echo beans_open_markup('sd_main_footer_col_one', 'div', ['class' => 'uk-width-medium-1-2 footer-widget', 'data-uk-grid-margin']);
					echo '<h3 class="main-footer-title">CONNECT</h3>';
					echo '<ul class="uk-grid-margin">';
						echo '<li><a href="https://www.facebook.com/freelancecapetown" target="_blank" title="" role="link"><img src="http://freelance.capetown/wp-content/uploads/2017/06/icon_facebook.png" alt="Facebook"/></a></li>';
						echo '<li><a href="https://twitter.com/capefreelance" target="_blank" title="" role="link"><img src="http://freelance.capetown/wp-content/uploads/2017/06/icon_twitter.png" alt="Twitter"/></a></li>';
						echo '<li><a href="https://www.instagram.com/freelancecapetown/" target="_blank" title="" role="link"><img src="http://freelance.capetown/wp-content/uploads/2017/06/icon_instagram.png" alt="Instagram"/></a></li>';
						//echo '<li><a href="skype:CapeFreelance?chat" title="" role="link">Skype</a></li>';
					echo '</ul>';
				echo beans_close_markup('sd_main_footer_col_one', 'div');
				//echo beans_open_markup('sd_main_footer_col_two', 'div', ['class' => 'uk-width-medium-1-2 footer-widget', 'data-uk-grid-margin']);
					//echo '<h3 class="main-footer-title">INSTAGRAM</h3>';
					//dynamic_sidebar('footer-insta-id'); 
					
				//echo beans_close_markup('sd_main_footer_col_two', 'div');
			
			echo '</div>';
		echo '</div>';
		echo beans_close_markup('sd_main_footer', 'div');
		
	}

	beans_wrap_markup('beans_footer', 'sd_sub_footer', 'div', ['class' => 'sub-footer']);

	add_filter( 'beans_footer_credit_right_text_output', function($text){ 
		return "<span style=\"color:#888;\">Made With &nbsp;<i class=\"uk-icon uk-icon-heart\" style=\"color:#f15942;\"></i>&nbsp; Using &nbsp;<a href=\"http://www.getbeans.io\" target=\"_blank\" title=\"Beans WordPress Theme Framework\" style=\"color:#f15942;text-decoration:none;\">Beans</a>&nbsp; Framework</span>"; 
	} );
?>
