<?php

/* Template Name: multistep2*/
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */
//session_start();
acf_form_head();


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
      <!--<section class="hero-profile uk-cover-background top_marging dashbord_heroimg">
          <div class="overlay"></div>
          <div class="hero-content">
       
        </div>
        </section>-->
        <!-- End Hero Page Profile -->
    <?php
} );

function sd_view_content(){
 $user_id = base64_decode($_REQUEST['user_id']);

/* global $wpdb;
    $ansatte = $wpdb->get_results("SELECT wp_usermeta.meta_value 
 FROM wp_users 
 JOIN wp_usermeta ON wp_users.ID = wp_usermeta.user_id 
 WHERE wp_usermeta.meta_key = 'wp_capabilities' AND wp_users.ID=$user_id
 ");
    
  print_r(unserialize($ansatte[0]->meta_value));
  */
 $info =get_userdata( $user_id );
 $user_email = $info->user_login;
 $user_pass = $info->user_pass;

 $creds = array();
 $creds['user_login'] = $user_email;
 $creds['user_password'] = $user_pass;
 $creds['remember'] = false;
 $user = wp_signon( $creds, false );
wp_set_current_user( $user_id, $user_email );
wp_set_auth_cookie( $user_id, true, false );
do_action( 'wp_login', $user_email );
 
// second step from freelnacer post  data 
?>
<!--input tag js and css-->
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/jquery-1.12.4.js">
</script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
   
 <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/bootstrap-tagsinput.css">
   <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/html5imageupload.css">
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/jQuery-1.11.1.js"></script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/bootstrap.3.2.0.min.js"></script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/html5imageupload.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/bootstrap-tagsinput.min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
  $.validate({
    modules : 'html5'
  });
</script>
 
  <!--input tag js and css-->
<div class="detail_top">
<ul id="progressbar">
<li class="active uk-button uk-button-red" >Details</li><span class="aero_red">&nbsp;&nbsp;>&nbsp;&nbsp;</span>
<li class="uk-button uk-button-red">Profiles</li><span class="aero_red">&nbsp;&nbsp;>&nbsp;&nbsp;</span>
<li class="uk-button uk-button-red">Billing</li>&nbsp;&nbsp;&nbsp;&nbsp;
<i class="fa fa-check-circle-o fa-lg fa_padding" aria-hidden="true"></i>
</ul>
</div>

<?php  $current_user = wp_get_current_user();
  $user_role_free=trim($current_user->roles[0]);
  $role_co ='Co-working(Office_space)';
         $cp_role = trim($role_co);
         if ($user_role_free == $cp_role) {?>
         	
         	
<section class="section top_marging">
    <div class="uk-container uk-container-center">
      <div class="uk-width-1-1" id="sd_frontpage_products">

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->


<div class="content_regis">
<!-- Multistep Form -->



<fieldset id="step2" class="step2">
<form method="post" name="new_user_step2"  action="<?php echo site_url(); ?>/custom-product/" enctype="multipart/form-data">
<div class="uk-width-1-1 ">
				<label for="lebbio"  class="lebbio commenleb">Profile Image</label>
            <!--<input type="file" id="input-file-now"  name="file" class="dropify" />-->
              <input name="wpua-file" id="<?php echo ($user=='add-new-user') ? 'wpua-file' : 'wpua-file-existing'?>" type="file" class="dropify" />
            </div>
<?php 
//echo "<pre>"; print_r($_POST); echo "</pre>";

$args = array(
			'post_id' => 'new',
			'field_groups' => array('group_56fe50c1eb560'),
			'form'               => false,
			);
			acf_form( $args );
			
			
			if(isset($_POST['submitd'])){
			
			
			//  To redirect form on a particular page
			header("Location:http://freelance.capetown/dashboard/");
			
			}
 ?>
          
<input class=" uk-button-red reg_sub step3"  name="submit" id="submitd"  onclick="return ValidateNo();" type="submit" value="Step 3">
        
</form>
</fieldset>
         
</div>

</div>
    </div>
  </section>

      	
        <?php 
         }
         
           $role_co ='Freelance_Finder(Client)';
         $cp_role = trim($role_co);
         if ($user_role_free == $cp_role) {      	     	
         	
         	
         	
         	?>
     <section class="section top_marging">
    <div class="uk-container uk-container-center">
      <div class="uk-width-1-1" id="sd_frontpage_products">
      <div class="content_regis">
<!-- Multistep Form -->
         <fieldset id="step2" class="step2">
         	<form method="post" name="new_user_step2"  action="<?php echo site_url(); ?>/custom-product/" enctype="multipart/form-data">
			<?php 
						
			$args = array(
			'post_id' => 'new',
			'field_groups' => array('group_5701303842237'),
			'form'               => false,
			);
			acf_form( $args );?>
         			
			
		<input class=" uk-button-red reg_sub step3"  name="submit" id="submit"  type="submit" value="Step 3">
				</form>         
         </fieldset>
         </div>

</div>
    </div>
  </section>
        
       <?php } 
         
        
         $role_co ='Freelancer_role';
         $cp_role = trim($role_co);
         if ($user_role_free == $cp_role) {
  ?>



<section class="section top_marging">
    <div class="uk-container uk-container-center">
      <div class="uk-width-1-1" id="sd_frontpage_products">

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->


<div class="content_regis">
<!-- Multistep Form -->



<fieldset id="step2" class="step2">
 <form method="post" name="new_user_step2"  action="<?php echo site_url(); ?>/custom-product/" enctype="multipart/form-data">
<div class="uk-width-1-1 text_center"><h3>PROFILE DETAILS</h3>
  <p class="para_details">Please fill in the following fields so we can populate your FCT profile</p>
</div>

         <div class="uk-width-1-1 ">
            <!--<input type="file" id="input-file-now"  name="file" class="dropify" />-->
              <input name="wpua-file" id="<?php echo ($user=='add-new-user') ? 'wpua-file' : 'wpua-file-existing'?>" type="file" class="dropify" />
            </div>
</div>


      <div class="uk-width-1-1 ">
          <label for="lebbio"  class="lebbio commenleb">Bio/Profile Description<span class="medatry_star">&nbsp;*</span></label>
          <textarea rows="6" cols="150" class="commen_reg_area" onblur="description();"  id="Profile_des" name="Profile_des"  placeholder="Tell us about yourself (minimum of 50 characters)"></textarea>
    <span id="custom-Profile_des" class="errorshow"></span>
    </div>
      <div class="uk-width-1-1 ">
        <label for="leblpqute" class="leblpqute commenleb"> Tagline / Quote<span class="medatry_star">&nbsp;*</span></label>
        <input class="text_field commen_reg" name="Tagline" id="lpqute"  placeholder="Create Front-end web development" type="text">
      <span id="custom-lpqute" class="errorshow"></span>
      </div>
  <div class="uk-width-1-1  bs-example">

        <label for="lebSkills" class="leblSkills commenleb"> Skills<span class="medatry_star">&nbsp;*</span></label>
		<p class="para_details">Press table to make new skill tag</p>
        <input class="text_field commen_reg space_skills" name="Skils" id="Skils" data-role="tagsinput"   type="text"> 
    	    <span id="custom-Skils" class="errorshow"></span>
    	    </div>

<div class="uk-grid ">
    <div class="uk-width-1-2 ">
      <label for="lebmobnum" class="lebmobnum commenleb">Mobile Number<span class="medatry_star">&nbsp;*</span></label>
      <input class="text_field commen_reg" name="mobnum1" disabled id="mobnum1" placeholder="+27" type="text" style= "width:10%;">
      <input class="text_field commen_reg" name="mobnum" id="mobnum" onkeypress="return isNumber(event)" placeholder="+123456789" type="text" style= "width:89%;">
    <span id="custom-mobnum" class="errorshow"></span>
    </div>
    <div class="uk-width-1-2 ">
      <label for="lebtenno" class="lebtenno commenleb">Telephone Number</label>
      <input class="text_field commen_reg" name="telnno" onkeypress="return isNumber(event)"  id="telnno" placeholder="0123456789" type="text"> 
      <!--<span id="custom-telnno" class="errorshow"></span>-->
    </div>
</div>

<div class="uk-grid ">
  <div class="uk-width-1-2 ">
    <label for="lebfacebook" class="lebfacebook commenleb">Facebook URL</label>
    <input class="text_field  commen_reg" name="facebook"  id="facebook" placeholder="http://www.facebook.com/yourprofile" type="url">
   <!--<span id="custom-facebook" class="errorshow"></span>-->
   </div>
    <div class="uk-width-1-2 ">
      <label for="lebtwitter" class="lebtwitter commenleb">Twitter URL</label>
      <input class="text_field  commen_reg" name="twitter"  id="twitter" placeholder="http://www.twitter.com/yourprofile" type="url"> 
       <!--<span id="custom-twitter" class="errorshow"></span>-->
       </div>
</div>
<div class="uk-width-1-2 ">
      <label for="leblinked" class="leblinked commenleb">Linkedln URL</label>
      <input class="text_field  commen_reg" name="linked"  id="linked" placeholder="http//za.linkedin.com//yourprofile"  type="url"> 
    <!--<span id="custom-linked" class="errorshow"></span>-->
    </div>
    <hr class="hrline">
      <div class="uk-width-3-4 infomargin">
       <p style="display:none;" id="displayid_step2" class="">Your information looks good ! Move on to the next step</p>
      </div>

      <input class=" uk-button-red reg_sub step3" name="submit" id="submit"  onclick="return ValidateNo();" type="submit" value="Step 3">
 
</form>
</fieldset>




          
</div>





</div>
    </div>
  </section>
 <?php }?>
 <script type="text/javascript">
$('.dropzone').html5imageupload();
</script>
  <script type="text/javascript">  
            jQuery(document).ready(function(){
                // Basic
               jQuery('.dropify').dropify();

                // Translated
                jQuery('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-d??posez un fichier ici ou cliquez',
                        replace: 'Glissez-d??posez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'D??sol??, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
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
            
        </script><script type="text/javascript" href=""></script>

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/dropify.min.css" />
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src//js/dropify.min.js"></script>




<script type="text/javascript">
jQuery(".step3").click(function() { 

	var Profile_des = jQuery("#Profile_des").val();
	var lpqute = jQuery("#lpqute").val();
   var Skils = jQuery("#Skils").val();
   var mobnum = jQuery("#mobnum").val();
   /*var telnno = jQuery("#telnno").val();
   var facebook = jQuery("#facebook").val();
   var twitter = jQuery("#twitter").val();
   var linked = jQuery("#linked").val();*/
   if(Profile_des!=''&& lpqute!='' && Skils!='' ){
    jQuery("#displayid_step2").addClass("displayid_step3");
 }        
	 if(Profile_des==''){
jQuery('#custom-Profile_des').html('Please enter your description !');
jQuery('#Profile_des').focus();
return false;
    }
    if (Profile_des.length < 50 ) {
            alert("Bio Description should be minimum of 50 characters");
            jQuery('#Profile_des').focus();
            return false;
        }
    else{    	
jQuery('#custom-Profile_des').hide();    
    }
    
       if(lpqute==''){
jQuery('#custom-lpqute').html('Please enter your Tagline !');
jQuery('#lpqute').focus();
return false;
    }else{    	
jQuery('#custom-lpqute').hide();    
    }  
    
        if(Skils==''){
jQuery('#custom-Skils').html('Please enter your Skils !');
jQuery('#custom-Skils').focus(); 
return false;
    }else{    	
jQuery('#custom-Skils').hide();    
    } 
        if(mobnum==''){
jQuery('#custom-mobnum').html('Please enter your mobile number !');
jQuery('#mobnum').focus(); 
return false;
    }else{    	
jQuery('#custom-mobnum').hide();    
    }  		  
  /*
     if(telnno==''){
jQuery('#custom-telnno').html('Please enter your telephone number !');
return false;
    }else{    	
jQuery('#custom-telnno').hide();    
    } 
       if(facebook==''){
jQuery('#custom-facebook').html('Please enter your facebook url !');
return false;
    }else{    	
jQuery('#custom-facebook').hide();    
    } 
    
      if(twitter==''){
jQuery('#custom-twitter').html('Please enter your twitter url !');
return false;
    }else{    	
jQuery('#custom-twitter').hide();    
    } 	
    
      if(linked==''){
jQuery('#custom-linked').html('Please enter your linkedin url !');
return false;
    }else{    	
jQuery('#custom-linked').hide();    
    } 	
  */  
    	  
  
});
   function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            alert("Please enter only Numbers.");

            return false;
        }

        return true;
    }

    function ValidateNo() {
        var phoneNo = document.getElementById('mobnum');

        if ( phoneNo.value.length < 9 ) {
            alert("Please enter valid mobile number");
            jQuery('#mobnum').focus(); 
            return false;
        }

        //alert("Success ");
        return true;
        }
   

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
.step2 .acf-field-56fe50dab5e9c{display: none !important;}
.bootstrap-tagsinput > input {
    border: #fff !important;
}

.displayid_step3{display: block !important;}
#displayid_step2{display: none;}
</style>

<?php 
 
}

beans_load_document();

