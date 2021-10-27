<?php 
/*
Template Name: co-working space */

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

function sd_view_content(){?>
 <?php if(isset($_POST['submit'])){
      
        if($_POST['roll_hidden_free']=='Freelancer_role')
          {
              /*unset($_SESSION['roll_hidden_find']);
              unset($_SESSION['roll_hidden_co-working']);
              */
              $freelancer =  $_POST['roll_hidden_free'];

              $_SESSION['roll_hidden_free'] = $freelancer;

              $username = $_POST['fname_free'];
              $_SESSION['username'] = $username;

              $lname = $_POST['lname_free'];
              $_SESSION['lname_free'] = $lname;

              $displayname = $_POST['displayname_free'];
              $_SESSION['displayname_free'] = $displayname;            

              $mail = $_POST['email_free'];

              $password = $_POST['pass_free'];
              $cpass = $_POST['cpass_free'];
              $_SESSION["regcust"] =$username;
              $indestries = $_POST['indestries_free'];
              
               $indestry = explode(',', $indestries);
               $indestries_name = $indestry[1];
               $_SESSION['industries_free'] = $indestries_name;

               $subterm = $_REQUEST['subterm_free'];
               $_SESSION['sub_industries_free'] = $subterm; 
             // print_r($_POST);
               //print_r($_SESSION);
             }
           
            /*Getting Form values For Freelancer Finder Role*/  
                 
                if($_POST['roll_hidden_find'] =='Freelance_Finder(Client)'){

                /*unset($_SESSION['roll_hidden_free']);
                unset($_SESSION['roll_hidden_co-working']);*/
                
                $freelancer=  $_POST['roll_hidden_find'];
                $_SESSION['roll_hidden_find'] = $freelancer;

                $username = $_POST['fname_find'];
                $_SESSION['fname_find'] =$username;

                $lname = $_POST['lname_find'];
                $_SESSION['lname_find'] =$lname;

                $displayname = $_POST['displayname_find'];
                $_SESSION['displayname_find'] = $displayname;

                $mail = $_POST['email_find'];
                $password = $_POST['pass_find'];
                $cpass = $_POST['cpass_find'];
                
                     
                $indestries = $_POST['indestries_find'];
                $indestry = explode(',', $indestries);
                $indestries_name = $indestry[1];
                $_SESSION['industries_find'] =$indestries_name;
                $subterm = $_REQUEST['subterm_find'];
                $_SESSION['subterm_find'] =$subterm;
                /*print_r($_POST);
                print_r($_SESSION);*/
                //echo "<pre>";print_r($_SESSION);echo"</pre>";

                } 

                /*Getting Form values For Co_Working Role*/  

                 if($_POST['roll_hidden_co-working']=='Co-working(Office_space)'){
                 
                 /*unset($_SESSION['roll_hidden_free']);
                
                 unset($_SESSION['roll_hidden_find']);*/

                 $freelancer=$_POST['roll_hidden_co-working'];
                 $_SESSION['roll_hidden_co-working'] = $freelancer;

                 $username = $_POST['fname_co'];
                 $_SESSION['fname_co'] = $username;

                 $lname = $_POST['lname_co'];
                 $_SESSION['lname_co'] = $lname;                 
                 
                 $displayname = $_POST['displayname_co'];
                 $_SESSION['disaplyname_co'] = $displayname;

                 $mail = $_POST['email_co'];
                 $password = $_POST['pass_co'];
                 $cpass = $_POST['cpass_co'];
               }
                 $userdata = array(
             
              'user_login' =>  $mail,
              'display_name' =>  $displayname,
              'user_email' =>  $mail,
              'user_pass'  => $password,
               'role' => $freelancer

          ); 
        
          if(email_exists($mail)){

            echo "<span class='user_error'>Email ID Already Registered</span>";
            
          }
         
          else{
               $user_id = wp_insert_user( $userdata ) ;
         
           /*$capabilities=array(
              'read'         => true,  // true allows this capability
              'edit_posts'   => true,
              'upload_files'          => true,
              'delete_posts' => false, // Use false to explicitly deny
              'edit_published_pages'  => true,
              'edit_others_pages'     => true
              );*/
              
                $capabilities=array(
              'read'         => true,
              'edit_files' => true,
        'edit_others_pages' => true,
        'edit_others_posts' => true,
        'edit_pages' => true,
        'edit_posts' => true,
        'edit_private_pages' => true,
        'edit_private_posts' => true,
        'edit_published_pages' => true,
        'edit_published_posts' => true,
        'publish_pages' => true,
        'publish_posts' => true,
        'read_private_pages' => true,
        'read_private_posts' => true,
        // ADDED: END

        'upload_files' => true,
        );
              
             add_role($freelancer, __(
 $freelancer),
 array(
        'read'         => true,
        'edit_files' => true,
        'edit_others_pages' => true,
        'edit_others_posts' => true,
        'edit_pages' => true,
        'edit_posts' => true,
        'edit_private_pages' => true,
        'edit_private_posts' => true,
        'edit_published_pages' => true,
        'edit_published_posts' => true,
        'publish_pages' => true,
        'publish_posts' => true,
        'read_private_pages' => true,
        'read_private_posts' => true,
        // ADDED: END

        'upload_files' => true,
 )
);
           //add_role( $freelancer, $freelancer, $capabilities );
            update_user_meta($user_id, 'confirm_password', $cpass);
           //add_role( $freelancer, $freelancer, $capabilities );
          update_user_meta($user_id,'first_name',$username);
                update_user_meta($user_id,'last_name',$lname);
                 update_user_meta($user_id,'email',$mail);
                 $unique_id='FCPT'.$username.$user_id;
                 update_user_meta($user_id,'user_unique_id',$unique_id);
             update_user_meta($user_id,'Parent_industry',$indestries_name);
             update_user_meta($user_id,'child_industry',$subterm);
                $url = get_site_url();     
                $user_id = base64_encode($user_id); 
$to = $mail;
$subject = "Profile activation link";
/*$content = '<span class="emailspace" style="padding:0 30px 0 0;">Welcome</span>'.$username.'<br><p>You are almost done, we just need you to click on the link below to verify your account so that you can continue with the last few steps::</p>
              <table>
                    <tr>
                          <td><span class="emailspace" style="padding:0 30px 0 0;">Name</span>'.$username.'</td>
                      </tr>
                      <tr>
                          <td><span class="emailspace" style="padding:0 30px 0 0;">Last Name</span> '.$lname.'</td>
                      </tr>
                      <tr>
                          <td><span class="emailspace" style="padding:0 30px 0 0;">Email Address</span> '.$mail.'</td>
                      </tr>
                      <tr>
                          <td><span class="emailspace" style="padding:0 30px 0 0;">Role</span>'.$freelancer.'</td>
                      </tr>
                      <tr>
                          <td> <a href='. $url. '/registration-step-new/?user_id='.$user_id.'>Your Profiles Activation Link Click here
</a></td>
                      </tr>
                     
                     
                  </table>';*/
				  
				  $content = '<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" data-gr-c-s-loaded="true" style="">
    <div id="wrapper" dir="ltr" style="background-color: #f5f5f5; margin: 0; padding: 70px 0 70px 0; -webkit-text-size-adjust: none !important; width: 100%;">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
            <tbody>
                <tr>
                    <td align="center" valign="top">
                        <div id="template_header_image">
                            <p style="margin-top: 0;"><img src="http://freelance.capetown/wp-content/uploads/2015/11/logo-nav.png" alt="Freelance Cape Town" style="border: none; display: inline; font-size: 14px; font-weight: bold; height: auto; line-height: 100%; outline: none; text-decoration: none; text-transform: capitalize;"></p>
                        </div>
                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="box-shadow: 0 1px 4px rgba(0,0,0,0.1) !important; background-color: #fdfdfd; border: 1px solid #dcdcdc; border-radius: 3px !important;">
                            <tbody>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- Header -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header" style="background-color: #128ac6; border-radius: 3px 3px 0 0 !important; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif;">
                                            <tbody>
                                                <tr>
                                                    <td id="header_wrapper" style="padding: 36px 48px; display: block;">
                                                        <h1 style="color: #ffffff; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #41a1d1; -webkit-font-smoothing: antialiased;">Profile activation link</h1>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Header -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- Body -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" id="body_content" style="background-color: #fdfdfd;">
                                                        <!-- Content -->
                                                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" style="padding: 48px;">
                                                                        <div id="body_content_inner" style="color: #737373; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">
                                                                            <p style="margin: 0 0 16px;">Welcome <strong>'.$username. '</strong>
																			</p>
                                                                            <p style="margin: 0 0 16px;">You are almost done, we just need you to click on the link below to verify your account so that you can continue with the last few steps:</p>
                                                                            <h2 style="color: #128ac6; display: block; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 130%; margin: 16px 0 8px; text-align: left;">Profile Details</h2>
                                                                            <table>
																			<tr>
																				  <td><span class="emailspace" style="padding:0 30px 0 0;">Name:</span>'.$username.'</td>
																			  </tr>
																			  <tr>
																				  <td><span class="emailspace" style="padding:0 30px 0 0;">Last Name:</span> '.$lname.'</td>
																			  </tr>
																			  <tr>
																				  <td><span class="emailspace" style="padding:0 30px 0 0;">Email Address:</span> '.$mail.'</td>
																			  </tr>
																			  <tr>
																				  <td><span class="emailspace" style="padding:0 30px 0 0;">Role:</span>'.$freelancer.'</td>
																			  </tr>
																			  <tr>
																				  <td></br></br> <a href='. $url. '/dashboard/?user_id='.$user_id.'>Your Profiles Activation Link Click here
														</a></td>
																			  </tr>
																			 
																			 
																		  </table>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <!-- End Content -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Body -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- Footer -->
                                        <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                                            <tbody>
                                                <tr>
                                                    <td valign="top" style="padding: 0; -webkit-border-radius: 6px;">
                                                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="2" valign="middle" id="credit" style="padding: 0 48px 48px 48px; -webkit-border-radius: 6px; border: 0; color: #71b9dd; font-family: Arial; font-size: 12px; line-height: 125%; text-align: center;">
                                                                        <p>Freelance Cape Town</p>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End Footer -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <iframe id="cph_xorcss" style="display: none;"></iframe>
    <iframe id="cph_styleTests" style="display: none;"></iframe>
</body>';
                   $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
          
            if(isset($to)){
              //echo $emails; exit();
              
            if(mail($to,$subject,$content,$headers)){
           
            echo  '<span class="emailsend">'.$successMsg = 'We have sent you a verification mail, with a verification link to continue the registration process, please check your mailbox / junkmail.'.'</span>'; 
            } else{
               echo  '<span class="emailsend">'.$successMsg = 'registration has failed.'.'</span>'; 

            }

            } 
}
} 

?>

?>

<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/src/isotope.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/src/jquery.isotope.min.js"></script>
	<link rel='stylesheet' id='penci_style-css'  href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/isotope.css" type='text/css' media='all' />
	
	
	
	
	


<section class="section top-freelancers">

  <div class="uk-container uk-container-center">
            <div class="post-header">
				
		<!--<h1><span class="single-post-title">OurVoice ( Blog )</span></h1>-->
					
		
	</div>
   
    

 
 
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/css/dropify.min.css" />
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/dropify.min.js"></script>
  <script type="text/javascript">  
            jQuery(document).ready(function(){
              function GetURLParameter(sParam)
                {
                    var sPageURL = window.location.search.substring(1);
                    var sURLVariables = sPageURL.split('&');
                    for (var i = 0; i < sURLVariables.length; i++) 
                    {
                        var sParameterName = sURLVariables[i].split('=');
                        if (sParameterName[0] == sParam) 
                        {
                            return sParameterName[1];
                        }
                    }
                }
              var brief_url = GetURLParameter('upload_brief');
              if(brief_url == 'yes')   
              {
                jQuery('.finder').css('display','block');
                jQuery('.freelancer').css('display','none');
                jQuery('.co-working').css('display','none');
                var freelancer =  jQuery('input[name=freelancers]:checked').val();
                jQuery('#roll_hidden_find').val(freelancer);
              }

              jQuery('.free_role').click(function () {
                jQuery('.freelancer').css('display','block');
                jQuery('.finder').css('display','none');
                jQuery('.co-working').css('display','none');
                var freelancer =  jQuery('input[name=freelancers]:checked').val();
          
        jQuery('#roll_hidden_free').val(freelancer);
                
              });
              
              jQuery('.finder_role').click(function () {
                jQuery('.finder').css('display','block');
                jQuery('.freelancer').css('display','none');
                jQuery('.co-working').css('display','none');
                var freelancer =  jQuery('input[name=freelancers]:checked').val();
                jQuery('#roll_hidden_find').val(freelancer);
              
          
              });
              jQuery('.co-working_role').click(function () {
                jQuery('.co-working').css('display','block');
                jQuery('.finder').css('display','none');
                jQuery('.freelancer').css('display','none');
                var freelancer =  jQuery('input[name=freelancers]:checked').val();
                jQuery('#roll_hidden_co-working').val(freelancer);
              });
            
            });
            </script>
            
<script type="text/javascript">
jQuery(document).ready(function(){

jQuery(".free_roll").click(function() { // Function Runs On NEXT Button Click
   if(jQuery("input[name='freelancers']:checked").length == 0){
jQuery('#custom-radio-selector').html('Please select user role !');
return false;
    }
    else{     
jQuery('#custom-radio-selector').hide();    
    }
     
  //freessss validation start
  
   var fname_free = jQuery("#fname_free").val();
    var lname_free = jQuery("#lname_free").val();
    var displayname_free = jQuery("#displayname_free").val(); 
     var pass_free = jQuery("#pass_free").val();
     var cpass_free = jQuery("#cpass_free").val();
     var email_free = jQuery("#email_free").val();
     var indestries_free = jQuery('select[name=indestries_free]').val()
      
       if(fname_free==''){
jQuery('#custom-fname').html('Please enter your first name !');
return false;
    }else{
jQuery('#custom-fname').hide();    
    }
      if(lname_free==''){
jQuery('#custom-lname').html('Please enter last name !');
return false;
    }else{
jQuery('#custom-lname').hide();    
    }
    
      if(displayname_free==''){
jQuery('#custom-displayname').html('Please enter display name !');
return false;
    }else{
jQuery('#custom-displayname').hide();    
    }
    if(email_free==''){
  jQuery('#custom-email').html('Please enter email!');
return false;
    }     
     else{    
jQuery('#custom-email').hide();    
    }
  if(pass_free==''){
jQuery('#custom-pass').html('Please enter password!');
return false;
    }else{
jQuery('#custom-pass').hide();   
    }
       if(cpass_free==''){
jQuery('#custom-cpass').html('Please enter confirm password!');
return false;
    }
    if(pass_free != cpass_free){
    jQuery('#custom-cpass').html('password not match!');
    return false;
    }    
    else{     
jQuery('#custom-cpass').hide();    
    }
    
     if(indestries_free==''){
jQuery('#custom-indestry').html('Please select an industry!');
return false;
    }else{
      
jQuery('#custom-indestry').hide();    
    }
   //freessss validation end
     
     });
     
     jQuery("#finder").click(function() { // Function Runs On NEXT Button Click
   if(jQuery("input[name='freelancers']:checked").length == 0){
jQuery('#custom-radio-selector').html('Please select user role !');
return false;
    }
    else{     
jQuery('#custom-radio-selector').hide();    
    }
  //finder validation start
  
   var fname_find = jQuery("#fname_find").val();
    var lname_find = jQuery("#lname_find").val();
    var displayname_find = jQuery("#displayname_find").val(); 
     var pass_find = jQuery("#pass_find").val();
     var cpass_find = jQuery("#cpass_find").val();
     var email_find = jQuery("#email_find").val();
     var indestries_find = jQuery('select[name=indestries_find]').val()
      
       if(fname_find == ''){
jQuery('#custom-fname_find').html('Please enter your first name !');
return false;
    }else{
      
jQuery('#custom-fname_find').hide();    
    }
      if(lname_find==''){
jQuery('#custom-lname_find').html('Please enter last name !');
return false;
    }else{
      
jQuery('#custom-lname_find').hide();    
    }
    
      if(displayname_find==''){
jQuery('#custom-displayname_find').html('Please enter display name !');
return false;
    }else{
      
jQuery('#custom-displayname_find').hide();    
    }
    if(email_find==''){
  jQuery('#custom-email_find').html('Please enter email!');
return false;
    }     
     else{
      
jQuery('#custom-email_find').hide();    
    }
  if(pass_find==''){
jQuery('#custom-pass_find').html('Please enter password!');
return false;
    }else{
      
jQuery('#custom-pass_find').hide();    
    }
       if(cpass_find==''){
jQuery('#custom-cpass_find').html('Please enter confirm password!');
return false;
    }
    if(pass_find != cpass_find){
    jQuery('#custom-cpass_find').html('password not match!');
    return false;
    }    
    else{     
jQuery('#custom-cpass_find').hide();    
    }
    
     if(indestries_find==''){
jQuery('#custom-indestry_find').html('Please select an industry!');
return false;
    }else{
      
jQuery('#custom-indestry_find').hide();    
    }
    });
   //finder validation end
  
//co- working validation start
    jQuery(".co_working").click(function() { // Function Runs On NEXT Button Click
   if(jQuery("input[name='freelancers']:checked").length == 0){
jQuery('#custom-radio-selector').html('Please select user role !');
return false;
    }
    else{     
jQuery('#custom-radio-selector').hide();    
    }
   var fname_co = jQuery("#fname_co").val();
    var lname_co = jQuery("#lname_co").val();
    var displayname_co = jQuery("#displayname_co").val(); 
     var pass_co = jQuery("#pass_co").val();
     var cpass_co = jQuery("#cpass_co").val();
     var email_co = jQuery("#email_co").val();
    
       if(fname_co==''){
jQuery('#custom-fname_co').html('Please enter your first name !');
return false;
    }else{
      
jQuery('#custom-fname_co').hide();    
    }
      if(lname_co==''){
jQuery('#custom-lname_co').html('Please enter last name !');
return false;
    }else{
      
jQuery('#custom-lname_co').hide();    
    }
    
      if(displayname_co==''){
jQuery('#custom-displayname_co').html('Please enter display name !');
return false;
    }else{
      
jQuery('#custom-displayname_co').hide();    
    }
    if(email_co==''){
  jQuery('#custom-email_co').html('Please enter email!');
return false;
    }     
     else{
      
jQuery('#custom-email_co').hide();    
    }
  if(pass_co==''){
jQuery('#custom-pass_co').html('Please enter password!');
return false;
    }else{
      
jQuery('#custom-pass_co').hide();    
    }
       if(cpass_co==''){
jQuery('#custom-cpass_co').html('Please enter confirm password!');
return false;
    }
    if(pass_co != cpass_co){
    jQuery('#custom-cpass_co').html('password not match!');
    return false;
    }    
    else{     
jQuery('#custom-cpass_co').hide();    
    }
       
    });
      jQuery('#email_free').focusout(function() {
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if (testEmail.test(this.value)) {jQuery('#custom-email').hide();}
    else 
      {
        jQuery('#custom-email').show();
    jQuery('#custom-email').html('please enter valid email address!');
     
  }
    });
    jQuery('#email_find').focusout(function() {
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if (testEmail.test(this.value)) {jQuery('#custom-email_find').hide();}
    else {
    jQuery('#custom-email_find').html('please enter valid email address!');}    
    });
   
      jQuery('#email_co').focusout(function() {
    var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    if (testEmail.test(this.value)) {jQuery('#custom-email_co').hide();}
    else {
    jQuery('#custom-email_co').html('please enter valid email address!');}
});
 });
   //co-working validation end
  
    var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}; 

var role = getUrlParameter('role'); 
if (role == "regCoWorker"){
	setTimeout(function(){ 
		jQuery('#joblist').trigger('click');
	}, 2000);
}

if (role == "regFreelancer"){
	setTimeout(function(){ 
		jQuery('#freelancer').trigger('click');
	}, 2000);
}

if (role == "FindFreelancer"){
	setTimeout(function(){ 
		jQuery('#creativefree').trigger('click');
	}, 2000);
}


   
     
</script>
<?php 
//
}
//session_destroy();
beans_load_document();
//session_destroy();
}

