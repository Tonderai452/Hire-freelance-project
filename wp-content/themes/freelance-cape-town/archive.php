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
		<!-- Hero Page Profile -->
		<link rel='stylesheet' id='penci_style-css'  href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/blog_style.css" type='text/css' media='all' />
		
		<!-- End Hero Page Profile -->
	<?php
} );

function sd_view_content() {

?>

<div class="container container-single penci_sidebar">
	<div id="main">
		
 <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
	<article id="post-836" class="">

	<div class="post-header">
		
		
		<h1><span class="single-post-title"><?php echo get_the_title(); ?></span></h1>

					<div class="post-box-meta">

				<span class="author-post">posted by <strong><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a></strong></span>
				<span><?php echo get_the_date(); ?></span>
				<span><?php echo get_comments_number(get_the_ID() ); ?> comments </span>
				</div>
		
	</div>

	
					<div class="post-image">
					<a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url(); ?>" class="" sizes="(max-width: 1170px) 100vw, 1170px" width="1170" height="1029"></a>
				</div>
					
	
	<div class="post-entry">
		<div class="inner-post-entry">
			<?php echo get_the_content(); ?>
					</div>
	</div>

			<div class="tags-share-box">
			<div class="pattern-grey"></div>
			<div class="post-tags">
			<span>Tags:</span>  
				
			 <?php

			$posttags = get_the_tags();

			if ($posttags) {
			  foreach($posttags as $tag) {?>
			    
			<a href="<?php echo get_tag_link($tag->term_id); ?>"><?php echo $tag->name . ',';  ?></a>
			  <?php }
			}
			?>
                   </div>
							
				<div class="post-share">
					<span class="share-title">Share:</span>
					<div class="list-posts-share">
												<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"><i class="fa fa-facebook"></i></a>
						<a target="_blank" href="https://twitter.com/home?status=Check%20out%20this%20article:%20Freelance%20with%20photographer%20Fred%20van%20Leeuwen%20aka%20The%20Image%20Engineer%20-%20<?php the_permalink(); ?>"><i class="fa fa-twitter"></i></a>
						<a target="_blank" href="https://plus.google.com/share?url=http://freelance.capetown/"><i class="fa fa-google-plus"></i></a>
						<a target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>"><i class="fa fa-pinterest"></i></a>
					</div>
				</div>
					</div>
	
		

			<div class="post-pagination">
				<div class="prev-post">
			<div class="prev-post-title">
				<span><i class="fa fa-angle-double-left"></i>Previous Post</span>
			</div>
				<div class="pagi-text">
					<h5 class="prev-title"><?php previous_post_link(); ?></h5>
				</div>
	
		</div>
	
			<div class="next-post">
			<div class="prev-post-title next-post-title">
				<span>Next Post<i class="fa fa-angle-double-right"></i></span>
			</div>
			
				<div class="pagi-text">
					<h5 class="next-title"><?php if(next_post_link()!= ''){echo next_post_link();} ?></h5>
				</div>
			
		</div>
	</div>	
	
	<div class="post-comments" id="comments">
	<div id="comments_pagination"></div>
	<div style="text-align:center;">
        <?php comment_form(); ?>

	</div>
		
	</div>

</article>			
	<?php endwhile; endif; wp_reset_postdata(); ?>
		</div>
<div id="sidebar">
	<?php dynamic_sidebar('blog-sidebar-ct'); ?> 
	

<!-- END CONTAINER -->
</div>

<?php

}

add_action( 'wp_footer', 'sd_inject_ajax_logic', 30 );
function sd_inject_ajax_logic(){
	?>

	<?php
}

beans_load_document();?> 	
<?php 
