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

beans_uikit_enqueue_components( array( 'autocomplete' ), 'add-ons' );
beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
beans_remove_action( 'beans_breadcrumb' );
beans_remove_attribute( 'beans_main', 'class', 'uk-block' );
beans_add_attribute( 'beans_main', 'class', 'freelance-archive' );

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });

add_action( 'beans_header_after_markup', function(){
	
	get_template_part( 'header', 'hero' ); ?>
    
  
  <?php


} );



function sd_view_content() {

?>

<?php

// Get all industries and sub industries...
$industriesArgs = array (
	'type' => 'job-listing',
	'taxonomy' => 'industry',
	'orderby' => 'name',
	'order' => 'ASC',
	'hide_empty' => 1,
	// 'parent' => 0
);
global $industries;
$industries = get_categories( $industriesArgs );
// echo "Count is " . count($industries) . "<br>";
foreach( $industries as $k=>$industry ){
	$q = new WP_Query(
		[
			'post_type' => 'job-listing',
			'post_status' => 'publish',
			'tax_query' => [
				[
					'taxonomy' => 'industry',
					'field' => 'term_id',
					'terms' => $industry->term_id

				]
			]
		]
	);
	if( !$q->post_count > 0 ){
		unset($industries[$k]);
	}
}
// echo "Count is now " . count($industries)."<br>";
// End get all industries and sub industries ...

?>



<style>
section.hero.uk-cover-background{
	display:none;
}

img.tm-logo.uk-responsive-width{
	width: 202px;
    margin-top: 0px;
}
</style>

	<section class="section top-freelancers">

      <div class="uk-container uk-container-center">

        <span id="listings"></span>
          <div class="uk-width-1-1">
            <h2 class="uk-text-bold uk-text-center">FREELANCERS</h2>
          </div>
		  
		  <div class="uk-clearfix">&nbsp;</div>
		  
		  <div class="uk-width-large-1-1 .uk-visible-large width-bar">
        					   
							<form class="uk-form uk-form-blank position_abs" method="POST" action="">
							    <div class="uk-grid">

							    	 <div class="uk-width-medium-1-5">
							        <input type="text" class="search_text" placeholder="Enter keyword..." id="edit-search-api-views-fulltext" name="search_text" value="" size="30" maxlength="128" style="margin-top: 0px !important;">
							        </div>
							        <div class="uk-width-medium-1-5">
							         <select name="jobs_industry" id="jobs_industry" class="">
											<option value="-1">All Industries</option>
							        		<?php global $industries; foreach($industries as $industry): ?>
												<option value="<?php echo $industry->term_id; ?>"><?php echo ($industry->parent > 0 ? null : null) . $industry->name; ?></option>
											<?php endforeach; ?>
							        	</select>
										
							        </div>
							       <div class="uk-width-medium-1-5">
							 		<select name="jobs_industry" id="jobs_industry" class="">
											<option value="-1">All Industries</option>
							        		<?php global $industries; foreach($industries as $industry): ?>
												<option value="<?php echo $industry->term_id; ?>"><?php echo ($industry->parent > 0 ? null : null) . $industry->name; ?></option>
											<?php endforeach; ?>
							        	</select>
							        </div>
									  
							        <div class="uk-width-medium-1-5" style="text-align:center;">
							        	<input type="submit" name="submit" value="Search" class=" uk-button uk-button-blue uk-button-small filter_sub" style="margin-top: 0px !important;">
							        </div>
									
									<div class="uk-width-medium-1-5">
							        	<a href="http://freelance.capetown/registration-step-1/" class="uk-button uk-button-blue uk-button-small" role="button" style="position:absolute;    margin: 17px 0px;margin-top: 0px !important;" >Register Space</a>
							        </div>
							</div>
					</form>	
				</div>

          <div class="uk-clearfix">&nbsp;</div>
        <div class="uk-grid" data-uk-grid-match>

          <?php 
            if( have_posts() ) : 
              while( have_posts() ) : the_post();
        
              $count_value=  get_post_meta(get_the_ID(),'val_count','true');
             $admin_approved = get_field( 'admin_approved_listing' );
												
				if($admin_approved=='yes' || $admin_approved=='no'){
                ?>

                <div class="uk-width-medium-1-4 uk-width-1-1 freelancer-item uk-height-1-1 uk-position-relative" data-uk-grid-margin style="padding-bottom:30px;margin-bottom:25px;">
                   <?php     if (has_post_thumbnail()) {
												
												 ?>
                                 <a href="<?php echo the_permalink(); ?>" class="profile_count"><?php echo the_post_thumbnail('sd-portfolio-large', array('class' => 'border-highlight max-height_free profile_count'));?></a>
                                
                                 <form method="POST" id="profile">
                                    <?php   $result = $count_value + $_REQUEST['val_count']; update_post_meta(get_the_ID(),'val_count',$result); ?>
                                 <input type = "hidden" name="val_count" value="<?php echo $result; ?>" class="val_count" /> </form>
                               

                                 <?php  }
                                         else { ?>

                               <a href="<?php echo the_permalink(); ?>" class="profile_count">  <image class="border-highlight wp-post-image max-height_free" alt="Freelance.captown" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/noimage.png"/></a>
                            <form method="POST" id="profile">
                                    <?php   $result = $count_value + $_REQUEST['val_count']; update_post_meta(get_the_ID(),'val_count',$result); ?>
                                 <input type = "hidden" name="val_count" value="<?php echo $result; ?>" class="val_count" /> </form>
                              <?php } ?>                        

                  <div class="fct-caption uk-text-left">
                    <h4 class="fct-title"><?php echo get_the_title(); ?> <!--<small>&nbsp;&nbsp;<i class="fa fa-star"></i><span>&nbsp;15</span></small></h4>-->
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
                         $indOut;
                      endif;
                    ?>
                    </p>
                    <a href="<?php echo the_permalink(); ?>" class="uk-button uk-button-blue uk-button-small" role="button" style="position:absolute;bottom:0;left:35px;">View Profile</a>
                  </div>
                </div>

                <?php
             }
              endwhile;
            endif;
          ?>

        </div>
      </div>
  </section>



<?php

}

beans_load_document();
