<?php
// Template Name: customlogin
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */
session_start();
beans_uikit_enqueue_components( array( 'lightbox' ), 'add-ons' );

beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
beans_remove_action( 'beans_breadcrumb' );

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });

add_action( 'beans_header_after_markup', function(){?>
        <!-- Hero Page Profile -->
        <section class="hero-profile uk-cover-background top_marging">
          <div class="overlay"></div>
          <div class="hero-content">
       
        </div>
        </section>
        <!-- End Hero Page Profile -->
    <?php
} );
function sd_view_content(){

  ?>
<?php 
  if($_GET['status']==1 && $_GET['link']=='true'){
global $wpdb;
      
     $results= $wpdb->query("UPDATE wp_users SET user_status=1 WHERE user_status=0 AND ID='".$_GET['user_id']."' ");
    
}
?>
<section class="section top_marging dashbord_heroimg">
    <div class="uk-container uk-container-center">
      <div class="uk-width-1-1" id="sd_frontpage_products">
        <div class="content_customlogin">
<h2>Login Form</h2>

<?php echo do_shortcode('[profilepress-login id="1"]'); 

?>


 
</div>
</div>
    </div>
  </section>


<style>


.content_customlogin{
width:40%;
margin:20px auto;
}

.customloginform {
    border: 3px solid #f1f1f1;
}

#custom_login > h2 {
    margin: 0 auto;
    width: 50%;
}
#custom_login form{ width: 50%; margin:0 auto;}
input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.login_submit {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

.login_submit:hover {
    opacity: 0.8;
}

.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}
.form-group:last-child {
    display: none;
}
/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
</style>
<?php 
} beans_load_document();?>
