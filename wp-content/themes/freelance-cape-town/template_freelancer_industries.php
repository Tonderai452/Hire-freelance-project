<?php
/**
 * Template Name: freelancer_industries
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



function sd_view_content() {
  if(isset($_GET['search_ind'])){
$search_indstries = $_GET['search_ind']; }


 $args = array(
    'tax_query' => array(
        array(
            'taxonomy' => 'industry',
            'field' => 'slug',
            'terms' =>  $search_indstries
        ),
    ),
    'post_type' => 'freelancer'
);

$loop = new WP_Query( $args ); ?>

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
        <div class="uk-grid" data-uk-grid-match>

          <?php 
           
            if ( $loop->have_posts() ) { 

            while ( $loop->have_posts() ) : $loop->the_post(); ?>
                

                <div class="uk-width-medium-1-4 uk-width-1-1 freelancer-item uk-height-1-1 uk-position-relative" data-uk-grid-margin style="padding-bottom:30px;margin-bottom:25px;">
                   <?php     if (has_post_thumbnail()) {?>
                                 <a href="<?php echo the_permalink(); ?>"><?php echo the_post_thumbnail('sd-portfolio-large', array('class' => 'border-highlight max-height'));?></a><?php  }
                                         else { ?>

                               <a href="<?php echo the_permalink(); ?>">  <image class="border-highlight wp-post-image max-height" alt="Freelance.captown" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/noimage.png"/></a>
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
                        echo $indOut;
                      endif;
                    ?>
                    </p>
                    <a href="<?php echo the_permalink(); ?>" class="uk-button uk-button-blue uk-button-small" role="button" style="position:absolute;bottom:0;left:35px;">View Profile</a>
                  </div>
                </div>

                <?php
              endwhile;
            }//endif;
            else{ echo "<h2 style=text-align:center>No Record found<h2>";}
          ?>

        </div>
      </div>
  </section>

<?php

}

beans_load_document();
