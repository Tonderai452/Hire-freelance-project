<?php

  

// Template Name: Billing
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */
acf_form_head();

if ( is_user_logged_in() ){
   $user = wp_get_current_user();
   $user_id= $user->ID;
/*if ( in_array( 'administrator', (array) $user->roles ) ) {
    wp_redirect(admin_url()); exit();
} else{*/

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
        <section class="hero-profile uk-cover-background dashbord_heroimg" style="display:none;">
          <div class="overlay"></div>
          <div class="hero-content">
       
        </div>
        </section>
        <!-- End Hero Page Profile -->
    <?php
} );

function sd_view_content() {
             
       //$industries = get_field( 'industries',$pid );
      /* $industries = get_post_meta($pid, 'industries', true );        
                    $indOut = "";
                    foreach( $industries as $k=>$v ) :
                        $ins_id[] = $v;
                      $indOut .=  ( get_term( $v, 'industry' )->name ) . " / ";
                      
                      ?><?php 
                    endforeach;
                    $indOut = substr($indOut, 0, -3);
                    $exp = explode("/",$indOut );
                    $combval=array_combine($ins_id,$exp);
                    foreach($combval as $key =>$ex) {
                echo $ex;                   
                    }*/
                    
    if(isset($_POST['submit'])){
      $user_id = get_current_user_id();
      global $blog_id, $current_user, $show_avatars, $wpdb, $wp_user_avatar, $wpua_allow_upload, $wpua_edit_avatar, $wpua_functions, $wpua_upload_size_limit_with_units;
   
          $username =  $_POST['fname'];
         $lname =  $_POST['lname'];    
          $displayname = $_POST['displayname'];    
         $mail = $_POST['email'];
                    
          update_user_meta($user_id,'first_name',$username);
          update_user_meta($user_id,'last_name',$lname);
          update_user_meta($user_id,'display_name',$displayname);
           update_user_meta($user_id,'email',$mail);
           

           $Profile_des = $_POST['Profile_des'];
           
          $Tagline = $_POST['Tagline'];
          $all_skils = $_POST['Skils'];
          $mobnum = $_POST['mobnum'];
          $telnno = $_POST['telnno'];
          $facebook = $_POST['facebook'];
          $twitter = $_POST['twitter'];
          $linked = $_POST['linked'];
          //if($user_role=$current_user->roles[0]!='Co-working(Office_space)'){
          $indestries = $_POST['indestries'];
          $indestry = explode(',', $indestries);
             
          $indestries_name[] = $indestry[1];
          $subterm = $_POST['subterm_free'];
          $update_ind =  array_merge($indestries_name,$subterm);
      
      
      $current_user = wp_get_current_user();
//print_r($current_user);
   $current_user->roles[0];

 $user_role_free=trim($current_user->roles[0]);
          $role_co ='Freelancer_role';
          $cp_role = trim($role_co);
          if($user_role_free == $cp_role){ 
          $post_type = "freelancer";
          }
          
         
         $role_co ='Co-working(Office_space)';
         $cp_role = trim($role_co);
         if ($user_role_free == $cp_role) 
         { 
          $post_type = "co-working-space";
         }
          
          $role_co ='Freelance_Finder(Client)';
          $cp_role = trim($role_co);
          if($user_role_free == $cp_role)
          {
          $post_type = "job-listing";
          }
      
          
         $args= array( 
            'post_type' => $post_type,
            'post_title'   => $displayname,
            'post_content' =>  $Profile_des,
            'author' => $user_id,
        ); 
        $the_query = new WP_Query( $args );
     

// get his posts 'ASC'
  
            while ($the_query->have_posts()) : $the_query->the_post(); 
              
                $pid = get_the_ID();

           $file_handler = 'wpua-file'; //Form attachment Field name.
        
        $attach_id = media_handle_upload( $file_handler, $pid );
      
        //making it featured!
         set_post_thumbnail($pid, $attach_id );

        update_post_meta($post_id,'_thumbnail_id',$attach_id);
 
         update_post_meta( $pid, 'title', $displayname );              
        update_post_meta( $pid, 'tagline', $Tagline ); 
        update_post_meta( $pid, 'bio_description', $Profile_des ); 
         update_post_meta( $pid, 'skils', $all_skils );
        update_post_meta( $pid, 'mobile_number', $mobnum ); 
        update_post_meta( $pid, 'tel_number', $telnno ); 
        update_post_meta( $pid, 'facebook_url', $facebook ); 
        update_post_meta( $pid, 'tiwtter_url', $twitter ); 
        update_post_meta( $pid, 'linkedin_url', $linked );
        update_post_meta( $pid, 'fcpt_owned_by', $title );
        update_post_meta( $pid, 'email_address', $mail );
         
         
 $order_statuses = array('wc-on-hold', 'wc-processing', 'wc-completed');
## ==> Define HERE the customer ID
$customer_user_id = get_current_user_id(); // current user ID here for example
// Getting current customer orders
$customer_orders=get_posts( array(
'meta_value' => $customer_user_id, 
  'post_type' => 'shop_order', 
'numberposts' => -1
) );

// Iterating through each customer order
foreach($customer_orders as $customer_order){

 // Order ID
 $order_id = $customer_order->ID;
 update_post_meta( $pid, 'woocommerce_order_id', $order_id );
 update_post_meta( $pid, 'fcpt_owned_by', $user_id );
} 
  
         //wp_remove_object_terms( $pid, $term_slug, 'industry' );
       // wp_remove_object_terms( $pid, $term_children, 'industry' );
       //$append ='true';
     
      //wp_set_object_terms( $pid, $indestries_name, 'industry',$append); 
      
       //wp_set_object_terms( $pid, $subterm, 'industry',$append); 
         wp_set_object_terms( $pid, $update_ind, 'industry'); 
           
    
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
            if(!is_wp_error($attach_id)) {
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
            }
          }
        }
      endwhile;
           
        wp_reset_query();
echo  '<span class="emailsend">You’re almost done.</span>'; 

header('Location: http://freelance.capetown/dashboard/#menu1');

           }
?>
<!--input tag js and css-->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
   
 <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/bootstrap-tagsinput.css">
  
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/bootstrap-tagsinput.min.js"></script>
 
  <!--input tag js and css-->

<!-- freelancer profiles images css js -->





 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>



  



 <script type="text/javascript">
  jQuery(function() {
    jQuery(".video").click(function () {
      var theModal = jQuery(this).data("target");
      videoSRC = jQuery(this).attr("data-video");
      
      videoSRCauto = videoSRC;
      jQuery(theModal + ' iframe').attr('src', videoSRCauto);
      jQuery(theModal + ' button.close').click(function () {
        jQuery(theModal + ' iframe').attr('src', videoSRC);
      });
    });
  });
  </script>
   <script type="text/javascript">
  jQuery(function() {
   jQuery(".imagess").click(function () {
      var theModal =jQuery(this).data("target");
      videoSRC = jQuery(this).attr("data-video");
      videoSRCauto = videoSRC;
      jQuery(theModal + ' img').attr('src', videoSRCauto);
      jQuery(theModal + ' button.close').click(function () {
        jQuery(theModal + ' img').attr('src', videoSRC);
      });
    });
  });
  </script>


<!-- freelancer profiles images css js -->


 

<!-- freelancer profiles images css js end -->



<div class="content margin_top">
 <div class="uk-grid user_outer ">
    <div class="uk-width-3-10 tabpad">
        <?php
            $pid="";
            $current_user = wp_get_current_user();

            if ( ($current_user instanceof WP_User) ) {

        ?>

	        <div class="user">
		        <?php echo get_avatar( $current_user->user_email, 32 );?>
	        </div>

            <div class="userwell">
	            <?php echo 'Welcome back, ' . $current_user->display_name; ?>!<br>
	            <a href="<?php echo wp_logout_url(); ?>">Logout</a>
            </div>

        <?php

            }

            $user_role = $current_user->roles[0];

            if( $user_role ==='Freelance_Finder(Client)' ) {
				$joblisting_roll='Freelance_Finder(Client)';
            }

            if($user_role === 'Co-working(Office_space)' ) {
                $joblisting_roll = 'Co-working(Office_space)';
            }
    ?>
    </div>
        <div class="uk-width-7-10 resonscivediv"> 
          <ul class="nav nav-tabs custom_billing">
            <li class="active"><a data-toggle="tab" href="#home"><i class="fa fa-user-o" aria-hidden="true"></i>&nbsp;Details</a></li>
            <li><a data-toggle="tab" href="#menu1"><i class="fa fa-calendar-o" aria-hidden="true"></i>&nbsp;
              <?php  if(trim($user_role) == trim($joblisting_roll) && $user_role=='Freelance_Finder(Client)') 
              {echo "JOB LISTING";} 
              elseif(trim($user_role) == trim($joblisting_roll) && $user_role=='Co-working(Office_space)')
                {echo "SPACE LISTING";}
              else {?> &nbsp;Work<?php }?>
            </a></li>
            <li><a data-toggle="tab" href="#menu2"><i class="fa fa-comment" aria-hidden="true"></i>
&nbsp;Message</a></li>
            <li><a data-toggle="tab" href="#menu3"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;Billing</a></li>
         </ul>
    </div>
</div>

 <?php $user_id = get_current_user_id();


  $current_user = wp_get_current_user();
//print_r($current_user);
   $current_user->roles[0];

 $user_role_free=trim($current_user->roles[0]);
          $role_co ='Freelancer_role';
          $cp_role = trim($role_co);
          if($user_role_free == $cp_role){ 
          $post_type = "freelancer";
          }
          
         
         $role_co ='Co-working(Office_space)';
         $cp_role = trim($role_co);
         if ($user_role_free == $cp_role) 
         { 
          $post_type = "co-working-space";
         }
          
          $role_co ='Freelance_Finder(Client)';
          $cp_role = trim($role_co);
          if($user_role_free == $cp_role)
          {
          $post_type = "job-listing";
          }

query_posts(array( 
            'post_type' => $post_type,
            'author' => $user_id,
        ) ); 
           
            while (have_posts()) : the_post(); 

                 $pid = get_the_ID();
                  endwhile;
                 wp_reset_query();
  ?>

  <div class="container tab-content">
    <div id="home" class="tab-pane fade in active">
      
      <div class="content_detail">
     
        <!-- Detail Form -->
          <h2>YOUR DETAILS</h2>
          <p>You can chage all your details on this page</p>
       <?php if($current_user->roles[0]=='Freelancer_role') { ?>
         <form method="post" name="new_user_step2" action=" <?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">

          <div class="uk-grid ">
            <div class="uk-width-1-3 ">
           <!--  <input type="file" id="input-file-now"  name="file" class="dropify" /></p> -->
            <?php //echo do_shortcode('[avatar_upload]'); ?>

            <input name="wpua-file" id="<?php echo ($user=='add-new-user') ? 'wpua-file' : 'wpua-file-existing'?>" type="file" class="dropify" />


            </div>
            <div class="uk-width-1-2 avtar_outer">
              <?php echo get_avatar( $current_user->ID, 64 ); ?>           
            </div>
          </div>
          <hr class="hrline">
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                  <label for="lebname " class="lebname commenleb"> First Name</label>
                  <input class="text_field commen_reg" name="fname" required="required" id="fname" value="<?php echo get_user_meta( $user_id, 'first_name', 'true' );?> " required="required" placeholder="First Name" type="text">
              <span id="custom-fname" class="errorshow" ></span>
              </div>  
            <div class="uk-width-1-2 ">
                <label for="leblname " class="leblname commenleb"> Last Name</label>
              <input class="text_field commen_reg" name="lname" required="required" id="lname" value="<?php echo get_user_meta( $user_id, 'last_name', 'true' );?> " required="required" placeholder="Last Name" type="text">
             <span id="custom-lname" class="errorshow" > </span>
             </div>
          </div>
          <div class="uk-grid ">
              <div class="uk-width-1-2 ">
                    <label for="lebdisplayname " class="lebdisplayname commenleb"> <?php  if($user_role=$current_user->roles[0]=='Freelance_Finder(Client)'){ echo 'Display name / Company name';} else {?> Display Name<?php }?></label>
                <input class="text_field commen_reg" name="displayname" value="<?php echo $current_user->display_name;?>" required="required" id ="displayname" placeholder="Display Name" type="text">
           <span id="custom-displayname" class="errorshow"></span>
            </div>
                            
               <div class="uk-width-1-2 ">
                <label for="lebemail commenleb" class="lebemail commenleb">Email</label>
              <input class="text_field commen_reg" data-validation="email" value="<?php echo get_user_meta( $user_id, 'email', 'true' );?>"  data-validation-error-msg="You did not enter a valid e-mail" name="email" id="email" required="required"   type="email">
                
                <span id="custom-email" class="errorshow"></span>
               </div>
          </div>
         
          
         <?php  if($user_role=$current_user->roles[0]!='Co-working(Office_space)') { ?>
          


  <div class="uk-grid"  style="display:block">
                <div class="uk-width-1-2 ">
               
                  <?php 
                      $parent_industry = get_terms( array( 'taxonomy' => 'industry','hide_empty' => false,'parent' => 0) );
                      $myterms = get_the_terms( $pid, 'industry' );
                      if ( ! empty( $myterms ) ) {
	                      foreach ($myterms as $_term) {
		                      if ($_term->parent == 0) //check for parent terms only
			                      $term_slug =  $_term->name;
		                        $catid = $_term->parent;
	                      }
                      }

               ?>
                  <label for="lebinds" class="lebcpass commenleb" >Industry</label>
                  <select class="options commen_reg" id="subcatid" name="indestries">
                  <option value="">Please select an industry</option>
                  <?php foreach ( $parent_industry as $cat ) { ?>
                  <option value="<?php echo $cat->term_id.','.$cat->name;?>" <?php if($cat->name == $term_slug) {  echo 'selected="selected"'; } ?>  name="indstries">
                  <?php echo $cat->name; ?></option>
                  <?php } ?>
                  </select>
                              
                  <span id="custom-indestry" class="errorshow"></span>


              </div>
             <div class="uk-width-1-2 " id="sub_category">
                 <label for="lebsubind " class="lebsubind commenleb">Sub-Industry</label>
                       
              <dl class="dropdown"> 
            <dt>
            <a href="#">
              <span class="hida options"> Please select Sub-industry</span>    
              <p class="multiSel"></p>  
            </a>
            </dt>
          
            <dd>
                <div class="mutliSelect">
                    <?php //$term_children =wp_get_post_terms( $pid,'industry' );
                          $term_children = get_the_terms( $pid, 'industry' );
                          /*echo "<pre>";
                          print_r($term_children);*/?>
                    <ul>
                    <?php 
                             
                         //all child cat
                    $catid ="";
                   $parent_industry = get_terms( array( 'taxonomy' => 'industry', 'parent' => 0 ) );
                   
                    $myterms = get_the_terms($pid, 'industry');
                              
                       foreach ($myterms as $_term) {
                          if ($_term->parent == 0) //check for parent terms only
                              $term_slug =  $_term->name;
                                 $catid = $_term->parent;
                       }      


                     //$term_children_all =get_categories( array ('taxonomy' => 'industry', 'parent' => $catid ));    
                // get all child industry   
                 $term_children_all = get_term_children( $catid, 'industry' );   
                                 
                   //all selected child cat
                     $subind_val =array();
                     $term_children =wp_get_post_terms( $pid,'industry' );
                        //print_r($term_children);                            
                    foreach($term_children as $subinds) { // only selected
                    // if($subinds->parent!=0){
                      $subind_val[] =$subinds->name;
                               // }
                      }
                     //all selected child cat
                      foreach($term_children_all as $sel_term){ 
                      $c_all_term = get_term_by( 'id', $sel_term, 'industry' );
                    ?>
                     <li>
                            <input name="subterm_free[]" id="multiple-checkboxes" type="checkbox" value="<?php echo $c_all_term->name; ?>"<?php if(in_array($c_all_term->name,$subind_val)){ echo 'checked="checked"';} ?>  /><?php echo $c_all_term->name; ?>
                            
                       </li> 
                       <?php 
                                           
                       }
                       //print_r($c_all_term);  
                       ?>
                    </ul>
                </div>
            </dd>
         
        </dl> 
  
  
          </div>
          
  
          
</div>
<?php }?>
               
      <hr class="hrline">
            <div class="uk-width-1-1 ">
                <label for="lebbio"  class="lebbio commenleb">Bio/Profile Description</label>
                <textarea rows="6" cols="150" id="Profile_des" class="commen_reg_area"   name="Profile_des" required="required"  placeholder="Tell us about yourself"><?php echo get_post_meta($pid,'bio_description','true'); ?></textarea>
          <span id="custom-Profile_des" class="errorshow"></span>
          </div>
           <div class="uk-width-1-1 ">
              <label for="leblpqute" class="leblpqute commenleb"> Tagline / Quote</label>
              <input class="text_field commen_reg" name="Tagline" value="<?php echo get_post_meta( $pid, 'tagline', 'true' );?>" id="lpqute"  placeholder="Create Front-end web development" type="text">
          </div>
           <div class="uk-width-1-1 ">
              <label for="lebSkills" class="leblSkills commenleb"> Skills</label>
            
              <?php      $all_skils = get_post_meta($pid, 'skils', true );
                
                      $sinle_skils =explode(",",$all_skils);
                      
                                ?>
              <input class="text_field space_skills commen_reg" name="Skils" data-role="tagsinput" value="<?php print_r($all_skils); ?>" id="Skils"  type="text"> 
          </div>

<div class="uk-grid ">
    <div class="uk-width-1-2 ">
      <label for="lebmobnum" class="lebmobnum commenleb">Mobile Number</label>
      <input class="text_field comonurl commen_reg" name="mobnum" id="mobnum" value="<?php echo get_post_meta( $pid, 'mobile_number', 'true' );?>" onkeypress="return isNumber(event)"  placeholder="+27824637402" type="text">
    </div>
    <div class="uk-width-1-2 ">
      <label for="lebtenno" class="lebtenno commenleb">Telephone Number</label>
      <input class="text_field comonurl commen_reg" value="<?php echo get_post_meta( $pid, 'tel_number', 'true' );?>" name="telnno"  id="telnno" placeholder="+27216882030" type="text"> 
     
    </div>
</div>

<div class="uk-grid ">
  <div class="uk-width-1-2 ">
    <label for="lebfacebook" class="lebfacebook commenleb">Facebook URL</label>
    <input class="text_field comonurl commen_reg" name="facebook" value="<?php echo get_post_meta( $pid, 'facebook_url', 'true' );?>"  id="facebook" placeholder="http://www.facebook.com/yourprofile" type="url" >
  </div>
    <div class="uk-width-1-2 ">
      <label for="lebtwitter" class="lebtwitter commenleb">Twitter URL</label>
      <input class="text_field comonurl commen_reg " name="twitter"  id="twitter" value="<?php echo get_post_meta( $pid, 'tiwtter_url', 'true' );?>" placeholder="http://www.twitter.com/yourprofile" type="url"> 
    </div>
</div>
<div class="uk-width-1-2 ">
      <label for="leblinked" class="leblinked commenleb">Linkedln URL</label>
      <input class="text_field comonurl commen_reg" name="linked"  id="linked" value="<?php echo get_post_meta( $pid, 'linkedin_url', 'true' );?>" placeholder="http//za.linkedin.com//yourprofile" type="url"> 
    </div>
      <input type="hidden" name="term_selected" id="term_selected" value = "">
      <div class="uk-width-1-5 detail_save">
       <input class=" uk-button-success reg_sub"  name="submit" id="submit"  onclick="return ValidateNo();" type="submit" value="Next">
      </div>

      
 
</form>
<?php } ?>
  <?php 
  $title =  $current_user->display_name;
   if($current_user->roles[0]=='Co-working(Office_space)') { 
  /**
   * Add ACF form for front end posting
   * @uses Advanced Custom Fields Pro
   */

  $new_post = array(
    'post_id'  => $pid, // Create a new post OR load from existing...
    'post_type'   => 'co-working-space',
      'post_status' => 'published',
     'post_title'  => 'true',
    // PUT IN YOUR OWN FIELD GROUP ID(s)
    'field_groups'       => array( 'group_56fe50c1eb560' ), // Create post field group ID(s)
    'form'               => true,
    //'return'             => add_query_arg( array( 'updated' => 'true' ) ), // Redirect to new post url %post_url%
    'updated_message'    => '
      
        
            Your listing has been submitted to us for review, thank you.
      
      
    ',
    'uploader' => 'wp',
    'submit_value' => __("Update My Co-Working Space", 'acf'),
    'form_attributes' => [
      'class' => 'uk-form sd-form-manage-listings'
    ],
    
  );
acf_form( $new_post );
}
//echo $pid.$current_user->roles[0]; 
if($current_user->roles[0]=='Freelance_Finder(Client)') { ?>

 <form method="post" name="new_user_step2" action=" <?php $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">

          <div class="uk-grid ">
            <div class="uk-width-1-3 ">
           <!--  <input type="file" id="input-file-now"  name="file" class="dropify" /></p> -->
            <?php //echo do_shortcode('[avatar_upload]'); ?>

            <input name="wpua-file" id="<?php echo ($user=='add-new-user') ? 'wpua-file' : 'wpua-file-existing'?>" type="file" class="dropify" />


            </div>
            <div class="uk-width-1-2 avtar_outer">
              <?php echo get_avatar( $current_user->ID, 64 ); ?>           
            </div>
          </div>
          <hr class="hrline">
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                  <label for="lebname " class="lebname commenleb"> First Name</label>
                  <input class="text_field commen_reg" name="fname" required="required" id="fname" value="<?php echo get_user_meta( $user_id, 'first_name', 'true' );?> " required="required" placeholder="First Name" type="text">
              <span id="custom-fname" class="errorshow" ></span>
              </div>  
            <div class="uk-width-1-2 ">
                <label for="leblname " class="leblname commenleb"> Last Name</label>
              <input class="text_field commen_reg" name="lname" required="required" id="lname" value="<?php echo get_user_meta( $user_id, 'last_name', 'true' );?> " required="required" placeholder="Last Name" type="text">
             <span id="custom-lname" class="errorshow" > </span>
             </div>
          </div>
          <div class="uk-grid ">
              <div class="uk-width-1-2 ">
                    <label for="lebdisplayname " class="lebdisplayname commenleb"> <?php  if($user_role=$current_user->roles[0]=='Freelance_Finder(Client)'){ echo 'Display name / Company name';} else {?> Display Name<?php }?></label>
                <input class="text_field commen_reg" name="displayname" value="<?php echo $current_user->display_name;?>" required="required" id ="displayname" placeholder="Display Name" type="text">
           <span id="custom-displayname" class="errorshow"></span>
            </div>
                            
               <div class="uk-width-1-2 ">
                <label for="lebemail commenleb" class="lebemail commenleb">Email</label>
              <input class="text_field commen_reg" data-validation="email" value="<?php echo get_user_meta( $user_id, 'email', 'true' );?>"  data-validation-error-msg="You did not enter a valid e-mail" name="email" id="email" required="required"   type="email">
                
                <span id="custom-email" class="errorshow"></span>
               </div>
          </div>
         
          
         <?php  if($user_role=$current_user->roles[0]!='Co-working(Office_space)') { ?>
          


  <div class="uk-grid"  style="display:block">
                <div class="uk-width-1-2 ">
               
                  <?php 
                      $parent_industry = get_terms( array( 'taxonomy' => 'industry','hide_empty' => false,'parent'   => 0) );
                      $myterms = get_the_terms($pid, 'industry');
                      foreach ($myterms as $_term) {
                          if ($_term->parent == 0) //check for parent terms only
                          $term_slug =  $_term->name;
                          $catid = $_term->parent;
                       }   
               ?>
          
                       <label for="lebinds" class="lebcpass commenleb" >Industry</label>
                  <select class="options commen_reg" id="subcatid" name="indestries">
                  <option value="">Please select an industry</option>
                  <?php foreach ( $parent_industry as $cat ) { ?>
                  <option value="<?php echo $cat->term_id.','.$cat->name;?>" <?php if($cat->name==$term_slug) {  echo 'selected="selected"'; } ?>  name="indstries">               
                  <?php echo $cat->name; ?></option>
                  <?php } ?>
                  </select>
                              
                  <span id="custom-indestry" class="errorshow"></span>


              </div>
             <div class="uk-width-1-2 " id="sub_category">
                 <label for="lebsubind " class="lebsubind commenleb">Sub-Industry</label>
                       
              <dl class="dropdown"> 
            <dt>
            <a href="#">
              <span class="hida options"> Please select Sub-industry</span>    
              <p class="multiSel"></p>  
            </a>
            </dt>
          
            <dd>
                <div class="mutliSelect">
                    <?php //$term_children =wp_get_post_terms( $pid,'industry' );
                          $term_children = get_the_terms( $pid, 'industry' );
                          /*echo "<pre>";
                          print_r($term_children);*/?>
                    <ul>
                    <?php 
                             
                         //all child cat
                    $catid ="";
                   $parent_industry = get_terms( array( 'taxonomy' => 'industry', 'parent' => 0 ) );
                   
                    $myterms = get_the_terms($pid, 'industry');
                              
                       foreach ($myterms as $_term) {
                          if ($_term->parent == 0) //check for parent terms only
                              $term_slug =  $_term->name;
                                 $catid = $_term->parent;
                       }      


                     //$term_children_all =get_categories( array ('taxonomy' => 'industry', 'parent' => $catid ));    
                // get all child industry   
                 $term_children_all = get_term_children( $catid, 'industry' );   
                                 
                   //all selected child cat
                     $subind_val =array();
                     $term_children =wp_get_post_terms( $pid,'industry' );
                        //print_r($term_children);                            
                    foreach($term_children as $subinds) { // only selected
                    // if($subinds->parent!=0){
                      $subind_val[] =$subinds->name;
                               // }
                      }
                     //all selected child cat
                      foreach($term_children_all as $sel_term){ 
                      $c_all_term = get_term_by( 'id', $sel_term, 'industry' );
                    ?>
                     <li>
                            <input name="subterm_free[]" id="multiple-checkboxes" type="checkbox" value="<?php echo $c_all_term->name; ?>"<?php if(in_array($c_all_term->name,$subind_val)){ echo 'checked="checked"';} ?>  /><?php echo $c_all_term->name; ?>
                            
                       </li> 
                       <?php 
                                           
                       }
                       //print_r($c_all_term);  
                       ?>
                    </ul>
                </div>
            </dd>
         
        </dl> 
  
  
          </div>
         
          
</div>
<?php }?>
      <hr class="hrline">
<div class="uk-grid ">
      <input type="hidden" name="term_selected" id="term_selected" value = "">
      <div class="uk-width-1-5 detail_save">
       <input class=" uk-button-success reg_sub"  name="submit_job" id="submit_job"  onclick="return ValidateNo();" type="submit" value="Next">
</div>
</div>
</form>
<?php }?>
</div>
</div>

    <!-- portfolio section start -->

     <div id="menu1" class="tab-pane fade">
      <div class="content_detail">
    
      <?php 
      
           $user_role=$current_user->roles[0];
          if($user_role='Freelance_Finder(Client)')
          {
         $job_roll='Freelance_Finder(Client)';
          } 

     if($user_role='Co-working(Office_space)')
          {
           $job_roll='Co-working(Office_space)';
         } 
         
         if($user_role='Freelancer_role')
          {
           $job_roll='Freelancer_role';
         } 
       if (trim($user_role) == trim($job_roll)) {
        
     
      $post_type_map = [
      
      'co-working-space' => 'Co-Working Space Listing',
      'job-listing' => 'Job Listing',
    ];
    $post_type_edit_link_map = [
      
      'co-working-space' => 'manage-co-working-space-listing',
      'job-listing' => 'manage-job-listing',
    ];
    global $current_user;
    //print_r($current_user->data->ID);
    $args = array(
      'post_type' => array('co-working-space', 'job-listing' ),
      'post_status' => array( 'pending', 'draft', 'future', 'publish' ),
      //'author' => $current_user->data->ID,
      'posts_per_page' => '999',
      'author' => $current_user->ID,
      'meta_key' => 'fcpt_owned_by',
      
      'meta_compare' => '='
    );
    $mylistings = new WP_Query($args);
    //echo "<pre>"; print_r($mylistings); echo "</pre>";
    //echo $current_user->ID;
    if( $mylistings->have_posts() ){
      echo '<table class="uk-table uk-table-striped uk-table-condesned" id="sdMyAccountListingOrders">';
      while( $mylistings->have_posts() ){ $mylistings->the_post();
        global $post;
        $progressArray = [];
        $progressArray['industries'] = implode(",",(array) @get_field('industries', $post->ID));
        $progressArray['skills'] = (string) implode(",",(array) @get_field('skills', $post->ID)[0]);
        $progressArray['tagline'] = (string) @get_field('tagline', $post->ID);
        $progressArray['mobile_number'] = (string) @get_field('mobile_number', $post->ID);
        $progressArray['tel_number'] = (string) @get_field('tel_number', $post->ID);
        $progressArray['email_address'] = (string) @get_field('email_address', $post->ID);
        $progressArray['website_url'] = (string) @get_field('website_url', $post->ID);
        $progressArray['facebook_url'] = (string) @get_field('facebook_url', $post->ID);
        $progressArray['tiwtter_url'] = (string) @get_field('tiwtter_url', $post->ID);
        $progressArray['linkedin_url'] = (string) @get_field('linkedin_url', $post->ID);
        $progressArray['behance_url'] = (string) @get_field('behance_url', $post->ID);
        $progressArray['profile_image'] = (string) @get_field('profile_image', $post->ID)['url'];
        $progressArray['portfolio_collection'] = (string) @get_field('portfolio_collection', $post->ID)[0]['portfolio_item_image']['url'];

        $progress = 0;

        global $p;
        $p = 0;

        array_walk($progressArray, function($v){
          global $p;
          if( (string) $v > "" ){
            $p++;
          }
        });

        $progress = ceil( ($p/(count($progressArray))*100) );

        /*$statusArray = array(
          'freelancer' => '<span class="text-danger">[ Awaiting Approval ]</span>',
          'listing' => '<span class="text-success">[ Approved ]</span>',
        );*/
        echo '<tr>';
          echo '<td><span class="uk-text-bold" style="font-size:1.25em;">' . get_the_title() . '</span><br><span class="uk-text-small uk-text-muted">' . ( $post_type_map[ $post->post_type ] ) . ': </span> <span class="uk-text-danger uk-text-small" style="font-size:.75em;">Expires '. get_field( 'expiry_date' ) .'</span> </td>';
          echo '<td>' . ( '<a style="margin-left:5px;background:#2980b9;" href="'.get_permalink( get_the_ID() ).'" class="uk-button uk-button uk-float-right uk-button-primary"><i class="fa fa-eye"></i> Preview</a><a title="Edit Listing" href="'.add_query_arg( array('fid' => get_the_id() ), site_url().'/'.$post_type_edit_link_map[ $post->post_type ] ).'" class="uk-button uk-button uk-button-primary uk-float-right"><i class="fa fa-pencil"></i> Edit</a></td>' ); //<span class="uk-float-right sdExpires uk-text-muted">Expires ' . date( 'Y-m-d', strtotime( get_the_date() . " + 1 year" ) ) . '</span>' ) . '
        echo '</tr>';
        echo '
        <tr style="height:4px;">
          <td colspan="2" style="padding:0;">
            <div class="uk-progress" style="background:#dedede;">
              <div class="uk-progress-bar" style="width:' . $progress . '%;background:#00a8e6;padding:1px 2px;height:4px;">
                <div style="overflow:hidden;clear:both;padding:1px;font-size:.6em;"></div>
              </div>
            </div>
          </td>
        </tr>
        <tr style="background:#fff;">
          <td colspan="2" style="font-size:1.35em;color:#ccc;padding:0;">
            <span class="uk-badge" style="background:#00a8e6;color:#fff;padding:2px 8px 4px 8px;margin-top:-5px;">' . $progress . '% Complete</span>
          </td>
        </tr>';

        echo '
        <tr style="background: none;"> 
          <td colspan="2">&nbsp;</td>
        </tr>
        ';

      }
      echo '</table>';
    }else{
      echo '<table class="uk-table uk-table-striped uk-table-condesned" id="sdMyAccountListingOrders">';
       $user_role=$current_user->roles[0];
   
   if (trim($user_role) == trim($job_roll)) {
        echo '<tr class="list-group-item" style="display:none;"><td colspan="2">You have not purchased any listings yet. </td></tr>';
        }
        
      echo '</table>';
    }

 do_action( 'woocommerce_before_my_account' ); 

   } 
   
  

 $user_role=$current_user->roles[0];
   
   if (trim($user_role) == trim($job_roll)) {
  
    
    
     ?>
 <!-- job listing end-->
 
      <div class="uk-width-1-1 upworkh2 ">
      <h2>PREVIOUSLY UPLOADED WORK</h2>
      <p>Just some of the work that you've already uploaded</p>
     </div>
       <?php 
         query_posts(array( 
          'author'        =>  $current_user->ID,
        'post_type' => 'freelancer',
        'showposts' => -1 
    ) ); 

       ?>



       <div class="uk-grid">
       

 
         <?php if( have_posts() ): the_post(); ?>
         <div class="uk-width-1-1" style="margin:20px 0;">
        <?php echo '<a title="Edit Listing" href="'.add_query_arg( array('fid' => get_the_id() ), site_url().'/manage-freelance-portfolio'.$post_type_edit_link_map[ $post->post_type ] ).'" class="uk-button uk-button uk-button-primary linkbtn"><i class="fa fa-pencil"></i> Add And Edit portfolios</a>';?>
          
       </div>
       <div class="uk-width-medium-1-1">
              <br>
              <hr>
              <h3 class="uk-text-left">Work by <?php echo get_the_title(); ?></h3>
              <br>
            </div>
          <?php if( $portfolios = get_field( 'portfolio_collection' ) ) : ?>
              <?php //echo "<pre>"; print_r($portfolios);
              
               $admin_approved = get_field( 'admin_approved_listing' );
                        
        if($admin_approved=='yes'){
              ?>

          <?php foreach( $portfolios as $portfolio ) : ?>
            
            <div class="uk-width-medium-1-3 feature-work image_width" data-uk-grid-margin>
            <a href="#"><img src="<?php echo $portfolio['portfolio_item_image']['sizes']['portfolio-square-large']; ?>" class="imagess" data-video="<?php echo $portfolio['portfolio_item_image']['sizes']['portfolio-square-large']; ?>" data-toggle="modal" data-target="#imgModal" hight="" width="" /></a>
            
              <div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                
                <div class="modal-content">
                  <div class="modal-body custom_padd">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="false">&times;</span></button>
                    <img style="border:none;" width="100%" height="500" src="" />
                  </div>
                      <div class="modal-footer margin_top">
                    
                   <h5><?php echo $portfolio['portfolio_item_caption'];?></h5>
                     <p class="imgdes">  <?php echo $portfolio['portfolio_item_description']; ?></p>
                     <a class="url_link" href ="<?php echo $portfolio['portfolio_item_url']; ?>"><?php echo $portfolio['portfolio_item_url']; ?></a>
                    
                      </div>
            </div>
                </div>
              </div>
            </div>


            
              

            <?php endforeach; 
            } // end admin approv codition
            ?>

        <?php endif; ?>
        <?php  endif; wp_reset_postdata(); ?>
          </div>
     
          
          
          
          
<div class="uk-width-medium-1-1">
                  <br>
                  <hr>
                  <h3 class="uk-text-left">Showcase your work & creativity here</h3>
                  <br>
                      </div>


<div class="uk-grid">
         <?php 
         query_posts(array( 
          'author'        =>  $current_user->ID,
        'post_type' => 'freelancer',
        'showposts' => -1 
    ) ); 

      if( have_posts() ):  the_post(); 
        if($video_arr = get_field( 'Video_collection' ) ) :?>
                         
          

                <?php 
                 $admin_approved = get_field( 'admin_approved_listing' );
                        
        if($admin_approved=='yes'){
                
                foreach( $video_arr as $videos ) :?>
                
                  <?php if($videos['vid_type']=='Youtube'){ ?>  
          <?php  $vid_url = (explode("=",$videos['Video_item_url'])); 
                $videos['Video_item_url'];
                $allowed_video_format = str_replace("watch?v=","embed/", $videos['Video_item_url']);
          ?>
          
          <div class="uk-width-medium-1-3 feature-work " data-uk-grid-margin>
             <a href="#"><img src="http://img.youtube.com/vi/<?php echo $vid_url[1]; ?>/hqdefault.jpg" class="video" data-video="<?php echo $allowed_video_format; ?>" data-toggle="modal" data-target="#videoModal" hight="" width="" /></a>
            <h5><?php echo $videos['Video_title']; ?></h5>
            <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  
                  <div class="modal-content">
                      <div class="modal-body custom_padd">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <iframe width="100%" height="350" src="" frameborder="0" allowfullscreen></iframe>
                      </div>
                          <div class="modal-footer vid_des">
                           
                          <h5><?php echo $videos['Video_title']; ?></h5>
                        <p><?php echo $videos['Video_description']; ?></p>
                        </div>
                    </div>
                </div>
            </div>                    
        </div>

            <?php } ?>
                
                <?php       
            if($videos['vid_type']=='Vimeo'){ 
              //echo $videos['vid_type'];

              
              $vid_vim_url= (explode("/",$videos['Video_item_url']));
                   $allowed_format_vimeo = str_replace("vimeo.com","player.vimeo.com/video", $videos['Video_item_url']);       
              if(isset($vid_vim_url[2]) && $vid_vim_url[2] =='vimeo.com'){                         
             ?>
             <div class="uk-width-medium-1-3 feature-work" data-uk-grid-margin>
             <script>
                    jQuery(document).ready(function () {
                        var vimeoVideoUrl = 'https://vimeo.com/<?php echo $vid_vim_url[3]; ?>';
                        var match = /vimeo.*\/(\d+)/i.exec(vimeoVideoUrl);
                        if (match) {
                            var vimeoVideoID = match[1];
                            jQuery.getJSON('http://www.vimeo.com/api/v2/video/' + vimeoVideoID + '.json?callback=?', { format: "json" }, function (data) {
                                featuredImg = data[0].thumbnail_large;
                                jQuery('#thumbImg').attr("src", featuredImg);
                            });
                        }
                    });
                </script> 
              <a href="#"> <img id="thumbImg" src=" " class="video" data-video="<?php echo $allowed_format_vimeo; ?>" data-toggle="modal" data-target="#videoModal1" hight="" width=""/></a>
            <h5><?php echo $videos['Video_title']; ?></h5>
              <div class="modal fade" id="videoModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                          <div class="modal-body custom_padd">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <iframe width="100%" height="350" src="" frameborder="0" allowfullscreen></iframe>
                          </div>
                             <div class="modal-footer">
                               
                              <h5><?php echo $videos['Video_title']; ?></h5>
                            <p class="vid_des"><?php echo $videos['Video_description']; ?></p>
                        </div>
                    </div>
                  </div>
              </div>
              
                     </div> 
                      
                       <?php 
                              } }?>
                             
                  <?php 
                  
                  endforeach;
                  }
                   ?>
                    
              <?php endif; 

      //multiple video get rk
      ?>

        
    
      <?php  endif; wp_reset_postdata(); ?>
</div>


<?php } ?>

</div>
</div>

    <!-- portfolio section end -->

    <div id="menu2" class="tab-pane fade">
      <div class="content_detail">
      <h3>Message</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
  </div>
    <div id="menu3" class="tab-pane fade">
      <div class="content_detail">
        <h3>YOUR BILLING</h3>
      <p>See how many views your profile has,your messages and click-through</p>
        <div class=".uk-width-large-1-1 .uk-visible-large lookgood"><i class="fa fa-check-circle-o fa-lg fa_padding" aria-hidden="true"></i>Everything looks good! Check here from time to time tosee if it aint.</div>
      <h3>YOUR STATS</h3>
      <p> See how many views your profile has,your messages and click-through</p>
     <div class="uk-grid res_tabdiv">
   
      <?php $views_count= get_post_meta(get_the_ID(),'val_count','true');?>
    <div class="uk-width-1-3 billviews">
    <span class="messagedate">Views</span>
    <span class="valcount"><?php if(!empty($views_count)){echo $views_count; } else{ echo "0";} ?></span> </div>
    <div class="uk-width-1-3 billmass">
    <span class="messagedate">Activation Date</span>
    
    <span class="valcount">
     <?php
      global $current_user;
    //print_r($current_user->data->ID);
    $args = array(
      'post_type' => array('freelancer','co-working-space', 'job-listing' ),
      'post_status' => array( 'pending', 'draft', 'future', 'publish' ),
      //'author' => $current_user->data->ID,
      'posts_per_page' => '1',
      'meta_key' => 'fcpt_owned_by',
      'meta_value' => $current_user->data->ID,
      'meta_compare' => '='
    );
    $mylistings = new WP_Query($args);
    if( $mylistings->have_posts() ){
    
      while( $mylistings->have_posts() ){ $mylistings->the_post();
        
        global $woocommerce, $post;

            $order = new WC_Order($post->ID);

            //to escape # from order id 

            $order_id = trim(str_replace('#', '', $order->get_order_number()));
        $order = new WC_Order($order_id);
              $order_date = $order->order_date .'<br>';
             $purchage_date =explode(" ",$order_date);
             echo $purchage_date[0].'<br>';
            
            }}
             ?>
    
    </span> </div>
    <div class="uk-width-1-3 billclick">
    
    <span class="messagedate">Expires Date</span>
    <span class="valcount">
      <?php
    $mylistings = new WP_Query($args);
    if( $mylistings->have_posts() ){
    
      while( $mylistings->have_posts() ){ $mylistings->the_post();
        
        global $post;

                      
          echo   get_field( 'expiry_date' ).'<br>';
        
            }}
             ?>
    
    
    </span> </div>

</div>
<hr style="width:98%; margin: 30px 0 0 -11px;">
    </div>

  </div>

</div>

        
          <!--sub category-->
       
<script type="text/javascript">
/*
  Dropdown with Multiple checkbox select with jQuery - May 27, 2013
  (c) 2013 @ElmahdiMahmoud
  license: http://www.opensource.org/licenses/mit-license.php
*/

jQuery(".dropdown dt a").on('click', function(e) {
  e.preventDefault();
  jQuery(".dropdown dd ul").slideToggle('fast');
e.preventDefault();
});

jQuery(".dropdown dd ul li a").on('click', function(e) {
  
  jQuery(".dropdown dd ul").hide();
});

function getSelectedValue(id) {
  return jQuery("#" + id).find("dt a span.value").html();
}

jQuery(document).bind('click', function(e) {
  var $clicked = jQuery(e.target);
  if (!$clicked.parents().hasClass("dropdown")) jQuery(".dropdown dd ul").hide();
});

jQuery('.mutliSelect input[type="checkbox"]').on('click', function() {

  var title = jQuery(this).closest('.mutliSelect').find('input[type="checkbox"]').val(),
    title = jQuery(this).val() + ",";
   var a = [];
    var cboxes = jQuery('input[type="checkbox"]:checked');
   var len = cboxes.length;     
    jQuery('.dropdown  dt a p.multiSel').html(len + 'selected');
  if (jQuery(this).is(':checked')) {
    var html = '<span title="' + title + '">' + title + '</span>';
    //jQuery('.multiSel').append(html);
    //jQuery('.multiSel').val(len);
    
    jQuery(".hida").hide();
  } else {
    jQuery('span[title="' + title + '"]').remove();
    var ret = jQuery(".hida");
    jQuery('.dropdown dt a').append(ret);

  }
  
});
 
    
    
</script> 
          <!-- sub cate end-->
          

 <script type="text/javascript">  
            jQuery(document).ready(function(){
                // Basic
                jQuery('.dropify').dropify();

                // Translated
                jQuery('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = jQuery('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = jQuery('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                jQuery('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        </script>

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/dropify.min.css" />
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src//js/dropify.min.js"></script>

<script type="text/javascript">
jQuery("#submit").click(function() { // Function Runs On NEXT Button Click

   var fname = jQuery("#fname").val();
   
    var lname = jQuery("#lname").val();
    var displayname = jQuery("#displayname").val(); 
     var email = jQuery("#email").val();
     var indestries = jQuery('select[name=indestries]').val()
   var Profile_des = jQuery("#Profile_des").val();
    if(fname==''){
   jQuery('#custom-fname').html('Please enter your first name !');
return false;
    }else{
      
jQuery('#custom-fname').hide();    
    }
     if(lname==''){
jQuery('#custom-lname').html('Please enter last name !');
return false;
    }else{
      
jQuery('#custom-lname').hide();    
    }
      if(displayname==''){
jQuery('#custom-displayname').html('Please enter display name !');
return false;
    }else{
      
jQuery('#custom-displayname').hide();    
    }
   
if(email==''){
jQuery('#custom-email').html('Please enter email!');
return false;
    }     
     else{
      
jQuery('#custom-email').hide();    
    }
    if(indestries==''){
jQuery('#custom-indestry').html('Please select an industry!');
return false;
    }else{
      
jQuery('#custom-indestry').hide();    
    }
  
  
   if(Profile_des==''){
jQuery('#custom-Profile_des').html('Please enter your description !');
return false;
    }else{
      
jQuery('#custom-fname').hide();    
    }

});
jQuery('form[name="new_user_step2"]').submit(function(e){
    e.preventDefault();

    var ctab = jQuery('.custom_billing li.active'); 
	var href = ctab.next().find('a').attr('href');
	var link = 'a[href="' + href + '"]';
	jQuery(link).trigger('click');
	
	
});
</script>
<script type="text/javascript">
jQuery('#email').focusout(function() {
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if (testEmail.test(this.value)) {jQuery('#custom-email').hide();}
    else {
    jQuery('#custom-email').html('please enter valid email address!');}
});
//skills space bar tag
jQuery('input.space_skills').tagsinput({
    confirmKeys: [13, 32, 44]
});

//skills space bar tag
</script>
<style type="text/css">
.bootstrap-tagsinput > input {
    border: #fff !important;
}

.acf-fields > .acf-field:first-child{visibility: hidden !important;}
</style>
<?php

}

add_action( 'wp_footer', 'sd_inject_ajax_logic', 30 );

function sd_inject_ajax_logic(){
	?>

	<?php
}

beans_load_document();?>    
<?php
//} //isadmin condition 
}

else{

  wp_redirect( home_url(), '302' );
}
