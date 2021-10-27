<?php
// Template Name: Image Upload
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

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/html5imageupload.css" />

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/html5imageupload.js"></script>
 
<?php 
function sd_view_content() {

?>

	<section class="section contact-page">
      <div class="uk-container uk-container-center">
        <div class="uk-grid">
          <form enctype="multipart/form-data" action="form.php" method="post" role="form">
            <div class="dropzone" data-width="960" data-height="540" data-resize="true" data-url="canvas.php" style="width: 100%;">
            <input type="file" name="thumb" />
            </div>
      </form>
        
        </div>
      </div>
    </section>
    <div class="dropzone" data-width="960" data-height="540" data-resize="true" data-url="canvas.php" style="width: 100%;">
  <input type="file" name="thumb" />
</div>
<script type="text/javascript">
$('.dropzone').html5imageupload();
</script>
<?php }
beans_load_document();
