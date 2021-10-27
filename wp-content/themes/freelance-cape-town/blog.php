<?php 
/*
Template Name: blog */

beans_uikit_enqueue_components( array( 'autocomplete' ), 'add-ons' );
beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
beans_remove_action( 'beans_breadcrumb' );
beans_remove_attribute( 'beans_main', 'class', 'uk-block' );
beans_add_attribute( 'beans_main', 'class', 'post-archive' );

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });

add_action( 'beans_header_after_markup', function(){
	?>

	<!-- Hero Page Home -->
	<?php //get_template_part( 'header', 'hero' ); ?>
	<!-- End Hero Page Home -->

	<?php
} );

function sd_view_content() {

?>

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/src/isotope.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/src/jquery.isotope.min.js"></script>
	<link rel='stylesheet' id='penci_style-css'  href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/isotope.css" type='text/css' media='all' />


<section class="section top-freelancers">

  <div class="uk-container uk-container-center">
            <div class="post-header">
				
		<!--<h1><span class="single-post-title">OurVoice ( Blog )</span></h1>-->
					
		
	</div>
    <div class="isotope " id="container" data-uk-grid-match>
           <?php
			   if ( have_posts() ) :
				    $args = array( 'post_type' => 'post', 'posts_per_page' => 10 );
				    $loop = new WP_Query( $args );
        		while ( $loop->have_posts() ) : $loop->the_post();	?>	
	    <div class="te-article CategoryRed isotope-item">
			  <?php if ( has_post_thumbnail() ) : ?>
						<div class="thumbnail">
						<a href="<?php the_permalink(); ?>" data-filter="*">
						<img width="150" height="100" src="<?php the_post_thumbnail_url(); ?>" class=" custom_hight attachment-thumb size-thumb wp-post-image" alt="<?php the_title();?>"  /></a>			
					 	</div>
					 <?php endif; ?>	
					
					
		
		         			<h2 class="grid-title height_title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>

							<div class="post-box-meta">
									<span class="dimond_img"><?php echo get_the_date(); ?></span>
									<span><?php echo get_comments_number(get_the_ID() ); ?> comments </span>
						    </div>			
				
				              <div class="item-content">
									<p><?php 
									echo wp_trim_words( get_the_content(), 40, '...' );
									?></p>
				                    <div class="grid-post-share-box">
				                       <div class="readmore"><a href="<?php the_permalink(); ?>">Read more</a></div>
			                       </div>
		                     </div>

		</div>				

    <?php endwhile;     ?>
			
    <?php else : ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; wp_reset_query(); ?>

 
 
    <?php 
}
    beans_load_document();
