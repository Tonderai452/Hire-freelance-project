<?php
// Template Name: multistep_ajex
/**
 * This core file should strictly be overwritten via your child theme.
 *
 * We strongly recommend to read Beans documentation to find out more how to
 * customize Beans theme.
 *
 * @author Beans
 * @link   http://www.getbeans.io
 */
   
/*if ( is_user_logged_in() ) {
  wp_redirect(get_site_url().'/dashboard/' );
exit;}
else{*/
//session_start();
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
	 

                 
	
	
	
	
	?>
		
		
    <?php
} );

function sd_view_content(){?> 
<?php if(isset($_POST['submit'])){
      //session_start();
          /*Getting Form values For Freelancer Role*/
         // echo "Hello".$_SESSION['roll_hidden_find'];
       /* if(isset($_SESSION['roll_hidden_free'])){
          $_POST['roll_hidden_free'] = $_SESSION['roll_hidden_free'];
        }
        if(isset($_SESSION['roll_hidden_find'])){
          $_POST['roll_hidden_find'] = $_SESSION['roll_hidden_find'];
        }
        if(isset($_SESSION['roll_hidden_co-working'])){
          $_POST['roll_hidden_co-working'] = $_SESSION['roll_hidden_co-working'];
        }*/
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
                 
                $freelancefinderoption = false;

				/*Getting Form values For Freelancer Finder Role*/  

                if($_POST['roll_hidden_find'] =='Freelance_Finder(Client)'){

                /*unset($_SESSION['roll_hidden_free']);
                unset($_SESSION['roll_hidden_co-working']);*/
                $freelancefinderoption = true;
				
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
				
							
				//  To redirect form on a particular page
				//header("Location:http://freelance.capetown/registration-step-new/?user_id=".$user_id);
				
				
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
																				  <td></br></br> <a href='. $url. '/registration-step-new/?user_id='.$user_id.'>Your Profiles Activation Link Click here
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
            
				if ($freelancefinderoption){					
					$ourlink = "http://freelance.capetown/registration-step-new/?user_id=".$user_id;
					header('Location: ' . $ourlink);					
				} else {				
					if(mail($to,$subject,$content,$headers)){
				   
					echo  '<span class="emailsend">'.$successMsg = 'We have sent you a verification mail, with a verification link to continue the registration process, please check your mailbox / junkmail.'.'</span>'; 
					} else{
					   echo  '<span class="emailsend">'.$successMsg = 'registration has failed.'.'</span>'; 

					}
				}
            } 
}
} 

?>



<?php 

	

?>




<?
session_start(); 
$_SESSION['role']=$_GET['role'];
?>

<section class="section top_marging">
    <div class="uk-container uk-container-center">
      <div class="uk-width-1-1 same_font_size" id="sd_frontpage_products">

<div class="content_regis">
<!-- Multistep Form -->


<!-- Progress Bar -->

    <!-- Fieldsets -->

    <fieldset id="first">
      <div class="uk-width-1-1 text_center"><h3>REGISTER FOR FREELANCE CAPE TOWN</h3>
      <p>You're minutes away from joining one of the most profile platforms in Cape Town</p>
    </div>
       <div class="uk-width-1-1 userradio">

      <p>Just so we're clear, are your a:<span class="medatry_star">&nbsp;*</span></p>
       <div class="uk-grid custom_radio ">

            <div class="uk-width-1-3 text_left">

               <input type="radio" name="freelancers" class="freelancers free_role"  id="freelancer"value="Freelancer_role"
                <?php 
               // echo ($_SESSION['roll_hidden_free'] == "Freelancer_role") ? 'checked="checked"' : '';
                ?>
               > Freelancer
             </div>
             <div class="uk-width-1-3 text_right ">
                   <input type="radio"  name="freelancers" class="freelancers finder_role"   id="creativefree" value="Freelance_Finder(Client)" 
                   <?php  
				   /*if( $_SESSION['roll_hidden_find']== 'Freelance Finder ( Client )'){
                   echo " checked='checked'";
                }*/
                 //echo ($_SESSION['roll_hidden_find'] == "Freelance_Finder(Client)") ? 'checked="checked"' : ''; 
                  
                ?> 
                   > Freelance Finder ( Client )

             </div>
             <div class="uk-width-1-3 left_align">
                   <input type="radio" name="freelancers" class="freelancers co-working_role" id="joblist" value="Co-working(Office_space)" 

                   <?php //if($_SESSION['role'] == 'regCoWorker'){
                  // echo " checked='checked'";
                //}
                
                //echo ($_SESSION['roll_hidden_co-working'] == "Co-working(Office_space)") ? 'checked="checked"' : '';
                ?>
                > Co-working ( Office space )
             </div>
             <span id="custom-radio-selector" class="errorshow" ></span>
        </div>
        <div style="color:red; margin-top:10px; font-weight:bold;"><span>Most important, what role do you want to register as??</span></div>
    </div>
	
	

    </div>
    
    <!-- Div for Freelancer Role Start -->
<div class="uk-width-1-1 freelancer">
 <form method="post" name="user_free" action="" >
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                  <label for="lebname " class="lebname commenleb"> First Name<span class="medatry_star">&nbsp;*</span></label>
                  <input class="text_field commen_reg" name="fname_free"  id="fname_free" value ="<?php echo $_SESSION['username'];?>" placeholder="First Name" type="text">
               <span id="custom-fname" class="errorshow" ></span>
              </div>
              
            <div class="uk-width-1-2 ">
                <label for="leblname " class="leblname commenleb"> Last Name<span class="medatry_star">&nbsp;*</span></label>
              <input class="text_field commen_reg" name="lname_free" id="lname_free" value ="<?php echo $_SESSION['lname_free']; ?>" placeholder="Last Name" type="text">
            <span id="custom-lname" class="errorshow" > </span>
             </div>
             
          </div>
         <div class="uk-grid ">
              <div class="uk-width-1-2 ">
                    <label for="lebdisplayname " class="lebdisplayname commenleb"> Display Name<span class="medatry_star">&nbsp;*</span></label>
                <input class="text_field commen_reg" name="displayname_free" value="<?php echo $_SESSION['disaplyname_free']; ?>" id ="displayname_free" placeholder="Display Name" type="text">
            <span id="custom-displayname" class="errorshow"></span>
            </div>
            
              <div class="uk-width-1-2 ">
                <label for="lebemail commenleb" class="lebemail commenleb">Email<span class="medatry_star">&nbsp;*</span></label>
              <input class="text_field commen_reg" name="email_free" id="email_free" type="email">
                <span id="custom-email" class="errorshow"></span>
                <span id="email_existfree" class="errorshow"></span>
               </div>
              
          </div>
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                      <label for="lebPassword" class="lebPassword commenleb">Password<span class="medatry_star">&nbsp;*</span></label>
                  <input class="text_field commen_reg" name="pass_free"   id ="pass_free" placeholder="Password" type="password">
             <span id="custom-pass" class="errorshow"></span>
              </div>
          
              <div class="uk-width-1-2 ">
                  <label for="lebcpass" class="lebcpass commenleb">Confirm Password<span class="medatry_star">&nbsp;*</span></label>
                <input class="text_field commen_reg" name="cpass_free"    id="cpass_free" placeholder="Confirm Password" type="password">
              <span id="custom-cpass" class="errorshow"></span>
              </div>
        
          </div>
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                  <?php                       
                   $args = array('taxonomy' => 'industry','hide_empty' => false,'parent'   => 0); 
                   $categories = get_terms( $args );
               
               
               
                              ?>
                       <label for="lebinds" class="lebcpass commenleb" >Industry<span class="medatry_star">&nbsp;*</span></label>
                  <select class="options commen_reg" id="subcatid" onblur="" name="indestries_free">
                  <option value="">Please select an industry</option>
                  <?php foreach ( $categories as $cat ) {?>
                  <option value="<?php echo $cat->term_id.','.$cat->name;?>" <?php if( $_SESSION['industries_free'] == $cat->name) echo 'selected'; ?> name="indestries_free">               
                  <?php echo $cat->name; ?></option>
                  <?php } ?>
                  </select>
                               
<span id="custom-indestry" class="errorshow"></span>

              </div>

              
              
        <input type="hidden" name="subterm_free" id ="subterm">
              <div class="uk-width-1-2" id="sub_category">
                 <label for="lebsubind " class="lebsubind commenleb">Sub-Industry</label>
                
                                   
                    <select class="options commen_reg"  name="subterm_find[]">
                          <option> Please select Sub-industry</option>
                          
                     </select>
          </div>
          </div>
          <hr class="hrline">
                <div class="uk-width-3-4 infomargin">
                 <p style="opacity:0;" id="displayid"> Your information looks good ! Move on to the next step</p>
                </div>     
                    <input type="hidden" id="roll_hidden_free" name="roll_hidden_free" value="" />
                <input class=" next_btn uk-button-red free_roll"  name="submit"  type="submit" value="Submit">
          
          </form>
    </div> <!--Freelancer Role Ends-->
    
 <!-- Freelancer Finder Starts-->   
    <?php //echo $_SESSION['fname_find'];?>
<div class="uk-width-1-1 finder " style="display:none;">
<form method="post" name="user_finder" action="" >
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                  <label for="lebname " class="lebname commenleb"> First Name<span class="medatry_star">&nbsp;*</span></label>
                  <input class="text_field commen_reg" name="fname_find"  id="fname_find" value = "<?php echo $_SESSION['fname_find'];?>" placeholder="First Name" type="text">
               <span id="custom-fname_find" class="errorshow" ></span>
              </div>
              
            <div class="uk-width-1-2 ">
                <label for="leblname " class="leblname commenleb"> Last Name<span class="medatry_star">&nbsp;*</span></label>
              <input class="text_field commen_reg" name="lname_find"  id="lname_find" value = "<?php echo $_SESSION['lname_find'];?>" placeholder="Last Name" type="text">
            <span id="custom-lname_find" class="errorshow" > </span>
             </div>
             
          </div>
         <div class="uk-grid ">
              <div class="uk-width-1-2 ">
                    <label for="lebdisplayname " class="lebdisplayname commenleb"> Display name / Company name<span class="medatry_star">&nbsp;*</span></label>
                <input class="text_field commen_reg" name="displayname_find" value = "<?php echo $_SESSION['displayname_find'];?>"  id ="displayname_find" placeholder="Display Name" type="text">
            <span id="custom-displayname_find" class="errorshow"></span>
            </div>
            
              <div class="uk-width-1-2 ">
                <label for="lebemail commenleb" class="lebemail commenleb">Email<span class="medatry_star">&nbsp;*</span></label>
              <input class="text_field commen_reg" data-validation="email" data-validation="email" data-validation-error-msg="You did not enter a valid e-mail" name="email_find" id="email_find"   type="email">
                <span id="custom-email_find" class="errorshow"></span>
                <span id="email_exist" class="errorshow"></span>
               </div>
              
          </div>
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                      <label for="lebPassword" class="lebPassword commenleb">Password<span class="medatry_star">&nbsp;*</span></label>
                  <input class="text_field commen_reg" name="pass_find"   id ="pass_find" placeholder="Password" type="password">
             <span id="custom-pass_find" class="errorshow"></span>
              </div>
          
              <div class="uk-width-1-2 ">
                  <label for="lebcpass" class="lebcpass commenleb">Confirm Password<span class="medatry_star">&nbsp;*</span></label>
                <input class="text_field commen_reg" name="cpass_find"    id="cpass_find" placeholder="Confirm Password" type="password">
              <span id="custom-cpass_find" class="errorshow"></span>
              </div>
        
          </div>
          <p class="industry_text">*Let us help you find the perfect fit to your query / need. Indicate below, in which industry and sub industry you need assistance with.
</p>
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                  <?php 
                      
                   $args = array('taxonomy' => 'industry','hide_empty' => false,'parent'   => 0); 
                   
                $categories = get_terms( $args );
               
               
               
                              ?>
                       <label for="lebinds" class="lebcpass commenleb" >Industry<span class="medatry_star">&nbsp;*</span></label>
                  <select class="options commen_reg" id="subcatid_find" onblur="myFunction()" name="indestries_find">
                  <option value="">Please select an industry</option>
                  <?php foreach ( $categories as $cat ) { ?>
                  <option value="<?php echo $cat->term_id.','.$cat->name;?>" <?php if( $_SESSION['industries_find']== $cat->name) echo 'selected'; ?>name="indestries_find">               
                  <?php echo $cat->name; ?></option>
                  <?php } ?>
                  </select>
                               
<span id="custom-indestry_find" class="errorshow"></span>

              </div>

              
              
        <input type="hidden" name="subterm_find" id ="subterm">
              <div class="uk-width-1-2" id="sub_category_find">
                 <label for="lebsubind " class="lebsubind commenleb">Sub-Industry</label>
                
                                   
                    <select class="options commen_reg"  name="subterm_find[]">
                          <option> Please select Sub-industry</option>
                          
                     </select>
          </div>
          </div>
          <hr class="hrline">
                <div class="uk-width-3-4 infomargin">
                 <p id="displayid" style="opacity:0;"> Your information looks good ! Move on to the next step</p>
                </div>    
                 <input type="hidden" id="roll_hidden_find" name="roll_hidden_find" value="" />  
                <input id= "finder" class=" next_btn uk-button-red finder"  name="submit"  type="submit" value="Submit">
          
          </form>
    </div> <!-- Freelancer Finder Ends-->
    
    <!-- Co-Working Starts-->
   <div class="uk-width-1-1 co-working" style="display:none;">
   <form method="post" name="user_co-working" action="" >
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                  <label for="lebname " class="lebname commenleb"> First Name<span class="medatry_star">&nbsp;*</span></label>
                  <input class="text_field commen_reg" name="fname_co"  id="fname_co" value = "<?php echo $_SESSION['fname_co'];?>" placeholder="First Name" type="text">
               <span id="custom-fname_co" class="errorshow" ></span>
              </div>
              
            <div class="uk-width-1-2 ">
                <label for="leblname " class="leblname commenleb"> Last Name<span class="medatry_star">&nbsp;*</span></label>
              <input class="text_field commen_reg" name="lname_co"  id="lname_co" value = "<?php echo $_SESSION['lname_co'];?>" placeholder="Last Name" type="text">
            <span id="custom-lname_co" class="errorshow" > </span>
             </div>
             
          </div>
         <div class="uk-grid ">
              <div class="uk-width-1-2 ">
                    <label for="lebdisplayname " class="lebdisplayname commenleb"> Office Space / Shared working space<span class="medatry_star">&nbsp;*</span></label>
                <!--<input class="text_field commen_reg" name="displayname_co"   placeholder=" / "  type="text" id ="displayname_co">-->
				
				<!--<input type="radio" class="" id ="displayname_co" name="displayname_co" value="Office Space" />
				Office Space
				<input type="radio" class="" name="displayname_co" value="Shared working space" />
				Shared working space-->
				
				<input class="text_field commen_reg" name="displayname_co"  id ="displayname_co" placeholder="Office Space / Shared working space" value = "<?php echo $_SESSION['disaplyname_co'];?>" type="text">
				 
            <span id="custom-displayname_co" class="errorshow"></span>
            </div>
            
              <div class="uk-width-1-2 ">
                <label for="lebemail commenleb" class="lebemail commenleb">Email<span class="medatry_star">&nbsp;*</span></label>
              <input class="text_field commen_reg" data-validation="email" data-validation="email" data-validation-error-msg="You did not enter a valid e-mail" name="email_co" id="email_co"    type="email">
                <span id="custom-email_co" class="errorshow"></span>
                <span id="email_exist" class="errorshow"></span>
               </div>
              
          </div>
          <div class="uk-grid ">
                <div class="uk-width-1-2 ">
                      <label for="lebPassword" class="lebPassword commenleb">Password<span class="medatry_star">&nbsp;*</span></label>
                  <input class="text_field commen_reg" name="pass_co"   id ="pass_co" placeholder="Password" type="password">
             <span id="custom-pass_co" class="errorshow"></span>
              </div>
          
              <div class="uk-width-1-2 ">
                  <label for="lebcpass" class="lebcpass commenleb">Confirm Password<span class="medatry_star">&nbsp;*</span></label>
                <input class="text_field commen_reg" name="cpass_co"   id="cpass_co" placeholder="Confirm Password" type="password">
              <span id="custom-cpass_co" class="errorshow"></span>
              </div>      
          </div>
           <hr class="hrline">
                <div class="uk-width-3-4 infomargin">
                 <p id="displayid" style="opacity:0;"> Your information looks good ! Move on to the next step</p>
                </div> 
				
		
                <input type="hidden" id="roll_hidden_co-working" name="roll_hidden_co-working" value="Co-working(Office_space)" />  

                <input class=" next_btn uk-button-red co_working"  name="submit"   type="submit" value="Submit" >
				
          </form>
    </div> <!-- Co-Working Ends-->
	
	
	
         
       
         <!-- first step form -->
    </fieldset>

 
</div>



<style type="text/css">

/* Above line is to import google font style */

#displayid {
    display: none;
}
#displayid_step2{display: none;}

fieldset{
display:none;
width: 99%;
padding:20px;
margin-top:50px;
margin-left: 85px;


}

input[type=submit],
input[type=button]{
padding: 5px;
height: 40px;

border: none;
border-radius: 4px;
color: white;
float: right;;

}



</style>

</div>
    </div>
  </section>
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
                //var freelancer =  jQuery('input[name=freelancers]:checked').val();
                jQuery('#roll_hidden_find').val('Freelance_Finder(Client)');
              }

              jQuery('.free_role').click(function () {
                jQuery('.freelancer').css('display','block');
                jQuery('.finder').css('display','none');
                jQuery('.co-working').css('display','none');
               // var freelancer =  jQuery('input[name=freelancers]:checked').val();
				jQuery('#roll_hidden_free').val('Freelancer_role');
              });
              
              jQuery('.finder_role').click(function () {
                jQuery('.finder').css('display','block');
                jQuery('.freelancer').css('display','none');
                jQuery('.co-working').css('display','none');
                //var freelancer =  jQuery('input[name=freelancers]:checked').val();
                jQuery('#roll_hidden_find').val('Freelance_Finder(Client)');
              
          
              });
              jQuery('.co-working_role').click(function () {
                jQuery('.co-working').css('display','block');
                jQuery('.finder').css('display','none');
                jQuery('.freelancer').css('display','none');
                //var freelancer =  jQuery('input[name=freelancers]:checked').val();
                jQuery('#roll_hidden_co-working').val('Co-working(Office_space)');
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
