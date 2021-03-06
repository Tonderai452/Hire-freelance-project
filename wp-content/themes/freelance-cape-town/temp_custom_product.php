<?php
/*Template Name: Product Register Step2*/
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */
//if ( is_user_logged_in() ) {
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
        <section class="hero-profile uk-cover-background top_marging">
          <div class="overlay"></div>
          <div class="hero-content">
       
        </div>
        </section>
        <!-- End Hero Page Profile -->
    <?php
} );

function sd_view_content(){?>
	 <div class="detail_top">
<ul id="progressbar">
<li class="active uk-button uk-button-red" >Details</li><span class="aero_red">&nbsp;&nbsp;>&nbsp;&nbsp;</span>
<li class="uk-button uk-button-red">Profiles</li><span class="aero">&nbsp;&nbsp;>&nbsp;&nbsp;</span>
<li class="uk-button uk-button-red">Billing</li>&nbsp;&nbsp;&nbsp;&nbsp;
<i class="fa fa-check-circle-o fa-lg fa_padding" aria-hidden="true"></i>
</ul>
</div>
  <?php 
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

   $current_user = wp_get_current_user();
   $user_id= $current_user->ID;
   //print_r($current_user);
    $current_user->roles[0];
   $P_indestries = get_user_meta( $current_user->ID, 'Parent_industry', 'true' ); 
   $c_indestries = get_user_meta( $current_user->ID, 'child_industry', 'true' ); 
   //$update_ind =  array_merge($P_indestries,$c_indestries);
	//echo "<pre>";
	//print_r($update_ind);
	//exit();
	$user_email = $current_user->user_email;
	//echo $current_user = $current_user->display_name;
    //echo $current_user->roles[0];
 
	// second step from freelnacer post  data 
     if(isset($_POST['submit'])){
     //echo "<pre>"; print_r($_POST); echo "</pre>";
     
     //echo "post value =". $_POST['acf']['field_56fe50c1eddb2pd'];
			 $current_user = wp_get_current_user();
          $title =  $current_user->display_name;
          $Profile_des = $_POST['Profile_des'];
          $Tagline = $_POST['Tagline'];
          $Skils = $_POST['Skils'];
          $mobnum = $_POST['mobnum'];
          $telnno = $_POST['telnno'];
          $facebook = $_POST['facebook'];
          $twitter = $_POST['twitter'];
          $linked = $_POST['linked'];
          $posthour = $_POST['acf']['field_56fe50c1eddb2ph'];
          $postday = $_POST['acf']['field_56fe50c1eddb2pd'];
          $postweek = $_POST['acf']['field_56fe50c1eddb2pw'];
          $postmonth = $_POST['acf']['field_56fe50c1eddb2pm'];
          $postaddress = $_POST['acf']['field_56fe50c1edaf9'];
          $postweburl = $_POST['acf']['field_56fe50c1edec4'];
			
			$postbiodes = $_POST['acf']['field_56fe51011e33f'];
			$posttelphone = $_POST['acf']['field_56fe50c1eddb2'];          
          $postoff_size = $_POST['acf']['field_58ca7d4ab7f79'];
           $postprofileimg = $_POST['acf']['field_56fe51d8fe45f'];
           $post_facilities = $_POST['acf']['field_58b035dcad00f'];
           $other_facilities = $_POST['acf']['field_56fe50c1edca0'];
           $pricing_options= $_POST['acf']['field_56fe50c1edd28'];
           $galleryimg= $_POST['acf']['field_56fe50c1edc0a'];
            $post_hero_image = $_POST['acf']['field_56fe50c1edb79'];
			/* echo "<pre>";
       print_r($_POST);*/
       //exit();
           // job listing 
      
          $jobpostdes = $_POST['acf']['field_5701324dc69c6'];
          $jobpostwork = $_POST['acf']['field_5701303844580'];
          $jobpostonsite = $_POST['acf']['field_5701303844610'];
          $jobpostdisolve = $_POST['acf']['field_570130384469d'];
          $jobpostpriceto = $_POST['acf']['field_5701303844726'];
          $jobpostpricefrom = $_POST['acf']['field_57013038447bf'];          
           $jobpostprofileimg = $_POST['acf']['field_5701303844848'];
           //job listing
		    $current_user->roles[0];
          $user_role_free=trim($current_user->roles[0]);
          $role_co ='Freelancer_role';
          $cp_role = trim($role_co);
          if($user_role_free == $cp_role){ 
          $post_type = "freelancer";
          }
          
         
        $role_co ='Co-working(Office_space)';
//         $role_co ='administrator';
         $cp_role = trim($role_co);
         if ($user_role_free == $cp_role) 
         { 
         	$post_type = "co-working-space";
         	$Profile_des = $postbiodes;
         	$postface = $_POST['acf']['field_56fe50c1edf5a'];
			$posttwitter = $_POST['acf']['field_56fe50c1edfe4'];
			$postlinked = $_POST['acf']['field_56fe50c1ee06f'];
         }
          
          $role_co ='Freelance_Finder(Client)';
          $cp_role = trim($role_co);
          if($user_role_free == $cp_role)
          {
          $Profile_des = $jobpostdes;
          $post_type = "job-listing";
          }
         					
                
			$new_post = array(
        'post_title'  =>  $title,
			'post_content' =>  $Profile_des,
        'post_status' =>  'Publish',           
        'post_type' =>  $post_type,  
        
        ); 
				  
        $pid = wp_insert_post($new_post);
          
    
        $file_handler1 = 'job_brief_document'; //Form attachment Field name.
        $file_handler = 'wpua-file';
        $attach_id = media_handle_upload( $file_handler, $pid );
      
      
        //making it featured!
        set_post_thumbnail($pid, $attach_id );

        update_post_meta($post_id,'job_brief_document',$attach_id);
 
         update_post_meta( $pid, 'title', $title ); 
        
        update_post_meta( $pid, 'tagline', $Tagline ); 
      // update_post_meta( $pid, 'bio_description', $Profile_des ); 
         update_post_meta( $pid, 'skils', $Skils );
        update_post_meta( $pid, 'mobile_number', $mobnum ); 
        update_post_meta( $pid, 'tel_number', $telnno ); 
        update_post_meta( $pid, 'facebook_url', $facebook ); 
        update_post_meta( $pid, 'tiwtter_url', $twitter ); 
        update_post_meta( $pid, 'linkedin_url', $linked );
       
        update_post_meta( $pid, 'fcpt_owned_by', $title );
        update_post_meta( $pid, 'email_address', $user_email );
        update_post_meta( $pid, 'fcpt_owned_by', $user_id );
        //wp_set_object_terms( $pid,'industries',$update_ind);
         update_field( 'field_5692338899d88', $update_ind, $pid );
         update_post_meta( $pid, 'per_hour', $posthour );
        update_post_meta( $pid, 'per_day', $postday );
        update_post_meta( $pid, 'per_week', $postweek );
        update_post_meta( $pid, 'per_month', $postmonth ); 
        update_post_meta( $pid, 'address', $postaddress );
        update_post_meta( $pid, 'website_url', $postweburl );
       
        update_post_meta( $pid, 'bio_description', $Profile_des );
        update_post_meta( $pid, 'tel_number', $posttelphone );
         update_post_meta( $pid, 'office_space_area', $postoff_size );
        update_field( 'field_58b035dcad00f', $post_facilities, $pid );
         update_field( 'field_56fe50c1edca0', $other_facilities, $pid );
         update_field( 'field_56fe50c1edd28', $pricing_options, $pid );
         update_field( 'field_56fe50c1edc0a', $galleryimg, $pid );
          update_field( 'field_56ebb58390f06', $post_hero_image, $pid );
          
          $role_co ='Co-working(Office_space)';
//         $role_co ='administrator';
         $cp_role = trim($role_co);
         if ($user_role_free == $cp_role) 
         { 
          update_post_meta( $pid, 'facebook_url', $postface );
         update_post_meta( $pid, 'twitter_url', $posttwitter );
         update_post_meta( $pid, 'linkedin_url', $postlinked );
         }
        // ****end of co-working space update

         // start job listing
                 update_post_meta( $pid, 'portfolio_item_description',$jobpostdes );
                  update_post_meta( $pid, 'type_of_work',$jobpostwork );
                  update_post_meta( $pid, 'on_site_or_remote',$jobpostwork );
                  update_post_meta( $pid, 'disclose_remuneration',$jobpostwork );
                  update_post_meta( $pid, 'price_to',$jobpostpriceto );
                   update_post_meta( $pid, 'price_from',$jobpostpricefrom );
                   update_post_meta( $pid, 'job_brief_document',$jobpostprofileimg );
                   update_field( 'field_5701303844848', $jobpostprofileimg, $pid );
                   
                   
         //job listing
         $append ='true';
          wp_set_object_terms( $pid, $P_indestries, 'industry',$append); 
        wp_set_object_terms( $pid, $c_indestries, 'industry',$append);
         
    $user_id = get_current_user_id();
		global $blog_id, $current_user, $show_avatars, $wpdb, $wp_user_avatar, $wpua_allow_upload, $wpua_edit_avatar, $wpua_functions, $wpua_upload_size_limit_with_units;
   
    $has_wp_user_avatar = has_wp_user_avatar(@$user->ID);
    // Get WPUA attachment ID
    $wpua = get_user_meta(@$user->ID, $wpdb->get_blog_prefix($blog_id).'user_avatar', true);

         $name = $_FILES['wpua-file']['name'];
        $file = wp_handle_upload($_FILES['wpua-file'], array('test_form' => false));
        $type = $_FILES['wpua-file']['type'];
        $upload_dir = wp_upload_dir();
        if(is_writeable($upload_dir['path'])) {
          if(!empty($type) && preg_match('/(jpe?g|gif|png)$/i', $type)) {
            // Resize uploaded image
            if((bool) $wpua_resize_upload == 1) {
              // Original image
              $uploaded_image = wp_get_image_editor($file['file']);
              // Check for errors
              if(!is_wp_error($uploaded_image)) {
                // Resize image
                $uploaded_image->resize($wpua_resize_w, $wpua_resize_h, $wpua_resize_crop);
                // Save image
                $resized_image = $uploaded_image->save($file['file']);
              }
            }
            // Break out file info
            $name_parts = pathinfo($name);
            $name = trim(substr($name, 0, -(1 + strlen($name_parts['extension']))));
            $url = $file['url'];
            $file = $file['file'];
             $title = $name;
            // Use image exif/iptc data for title if possible
            if($image_meta = @wp_read_image_metadata($file)) {
              if(trim($image_meta['title']) && !is_numeric(sanitize_title($image_meta['title']))) {
                $title = $image_meta['title'];
              }
            }
            // Construct the attachment array
            $attachment = array(
              'guid'           => $url,
              'post_mime_type' => $type,
              'post_title'     => $title,
              'post_content'   => ""
            );
            // This should never be set as it would then overwrite an existing attachment
            if(isset($attachment['ID'])) {
              unset($attachment['ID']);
            }
            // Save the attachment metadata
            //$attach_id = wp_insert_attachment($attachment, $file);
            //if(!is_wp_error($attach_id)) {
              // Delete other uploads by user
              $q = array(
                'author' => $user_id,
                'post_type' => 'attachment',
                'post_status' => 'inherit',
                'posts_per_page' => '-1',
                'meta_query' => array(
                  array(
                    'key' => '_wp_attachment_wp_user_avatar',
                    'value' => "",
                    'compare' => '!='
                  )
                )
              );
              $avatars_wp_query = new WP_Query($q);
              while($avatars_wp_query->have_posts()) : $avatars_wp_query->the_post();
                wp_delete_attachment($post->ID);
              endwhile;
              wp_reset_query();
              wp_update_attachment_metadata($attach_id, wp_generate_attachment_metadata($attach_id, $file));
              // Remove old attachment postmeta
              delete_metadata('post', null, '_wp_attachment_wp_user_avatar', $user_id, true);
              // Create new attachment postmeta
              update_post_meta($attach_id, '_wp_attachment_wp_user_avatar', $user_id);
              // Update usermeta
              update_user_meta($user_id, $wpdb->get_blog_prefix($blog_id).'user_avatar',$attach_id);
           // }
          }
        }

        session_destroy();
}
// second step from freelancer post data
?>

<section class="section top_marging">
    <div class="uk-container uk-container-center">
      <div class="uk-width-1-1" id="sd_frontpage_products">

<div class="content">
<!-- Multistep Form -->

<form class="regform" name="regform" id="regform" method="post">
<!-- Progress Bar -->

   
  <!-- Pricing Table -->
  
  <section class="section pricing uk-text-center">
    <div class="uk-container uk-container-center">
     
      <div class="uk-width-1-1" id="sd_frontpage_products">
                
        <?php //echo do_shortcode('[products columns="4" ids="102, 103, 104, 105"]'); ?>
        <div class="uk-grid">
         <?php  $user = wp_get_current_user();
          
  $user_role=$user->roles[0];
 
 $role_first='Freelancer_role';
   if (trim($user_role) == trim($role_first)) {
   	 
    ?>
<div class="uk-width-medium-1-6"> </div>
 <div class="uk-width-medium-1-4 ">
          
          <div class="headding" style="background:#128ac6; padding:15px 0 2px 0; color:#fff;">
             <h2 style="color:#fff;">12 MONTH</h2>
        </div>
        <?php echo do_shortcode('[products columns="1" ids="102"]'); ?>

      </div>
      <div class="uk-width-medium-1-4 ">
          <div class="headding" style="background:#128ac6; padding:15px 0 2px 0; color:#fff;">
             <h2 style="color:#fff;">6 MONTH</h2>
        </div>
        <?php echo do_shortcode('[products columns="1" ids="103"]'); ?>
     
      </div>


 <?php }
 $role_second='Freelance_Finder(Client)';
   if (trim($user_role) == trim($role_second)) {
 
   ?>
   <div class="uk-width-medium-1-6"> </div>
<div class="uk-width-medium-1-4 ">
          <div class="headding tester" style="background:#128ac6; padding:15px 0 2px 0; color:#fff;">
             <h2 style="color:#fff;">12 MONTH</h2>
        </div>
        <?php echo do_shortcode('[products columns="1" ids="105"]'); ?>
       
      </div>
      
      <div class="uk-width-medium-1-4 ">
          <div class="headding" style="background:#128ac6; padding:15px 0 2px 0; color:#fff;">
             <h2 style="color:#fff;">6 MONTH</h2>
        </div>
        <?php echo do_shortcode('[products columns="1" ids="1367"]'); ?>
     
      </div>
 <?php } 
 
  $role_third='Co-working(Office_space)';
   if (trim($user_role) == trim($role_third)) {
     	
   	?>
   
  <div class="uk-width-medium-1-3 ">
         <div class="headding" style="background:#128ac6; padding:15px 0 2px 0; color:#fff;">
             <h2 style="color:#fff;">12 MONTH</h2>
        </div>
        <?php echo do_shortcode('[products columns="1" ids="104"]');
        
               ?>
      </div>
 <?php }

  ?>
  
     
</div>
      </div>
  
    </div>
  </section>
  <!-- End Pricing Table -->
<hr class="hrline">
                <div class="uk-width-3-4 infomargin">
                 <p>Your information looks good ! Move on to the next step</p>
                </div>     
                <!--<input class="submit_btn next_btn uk-button-red" name="Submit" id="Submit" type="submit" value="Finish">-->
  <!-- End Pricing Table -->


</form>

          
</div>



<style type="text/css">


input[type=submit],
input[type=button]{
width: 120px;

padding: 5px;
height: 40px;

border: none;
border-radius: 4px;
color: white;
float: right;;

}


.woocommerce ul.products li.product a img {
    width: 155px !important;
    height: auto;
    display: block;
    margin: 0 0 1em;
	margin-top: 5px;
    margin-right: auto;
    margin-left: auto;
    box-shadow: none;
}


img.attachment-shop_catalog.size-shop_catalog.wp-post-image{
	width: 185px !important;
    height: 185px !important;
    display: inherit !important;
}

@media only screen and (max-width: 750px){
	img.attachment-shop_catalog.size-shop_catalog.wp-post-image {
    width: 185px !important;
    height: 140px !important;
    display: inherit !important;
}
}


</style>

</div>
    </div>
  </section>
 

<?php 
  
 

}
//} else{
	//wp_redirect( get_site_url().'/registration-step-1/', 301 ); exit; 

//}

beans_load_document();
