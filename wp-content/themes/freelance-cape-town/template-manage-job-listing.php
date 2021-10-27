<?php
// Template Name: Manage Job Listing

if ( !defined( 'ABSPATH' ) ) exit;
acf_form_head();

beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
//beans_remove_action( 'beans_breadcrumb' );
beans_remove_attribute( 'beans_main', 'class', 'uk-block' );

add_action( 'beans_breadcrumb_before_markup', function(){
	echo '<p>&nbsp;</p>';
} );

add_action( 'beans_breadcrumb_after_markup', function(){
	echo '<p>&nbsp;</p>';
} );
	 function sd_view_content(){
	 	$fid = $_REQUEST['fid'];
		$user_id = get_current_user_id(); 
		$owned_by = get_post_meta($fid,'fcpt_owned_by');
		$owned_by_value = $owned_by[0];
	/*if(in_array($user_id,$owned_by))
	{*/
	 	?>
	
<script type="text/javascript">
jQuery(document).ready(function(){
jQuery('.emailsend').delay(10000).fadeOut('slow');
});
</script>
	 	
	 	<?php
				                      
		if(isset($_GET['Step']) && $_GET['Step']=='next'){
			$ins_id ="";
			$freelance_id =array();
           	$fid =$_GET['fd'];
            //$job_post_link= get_permalink( $fid );
		    $job_post_link= site_url().'/job-listings/ ';
			if( have_posts() ): while( have_posts() ): the_post(); 
			 $fids =$_GET['fd']; 
			
			?>
		  <section class=" profile-main">
			  <div class="uk-container uk-container-center">
			  	 <?php
				if(isset($_REQUEST['cat_checkbox']))
				{
				    //print_r($_REQUEST['cat_checkbox'] );
					$admin_approved = get_field( 'admin_approved_listing' , $fid); 
					$mail_send = get_post_meta($fid,'mail_send',true);
           	  if($admin_approved == "yes")
           	  {
           	  if($mail_send != 1)
           	  {
				
					foreach($_REQUEST['cat_checkbox'] as $ids){

					$args = array(
				    'post_type' => 'freelancer',
				    'post_status' => 'publish',
				    'posts_per_page' => -1,
				    'tax_query' => array(
				        array(
				            'taxonomy' => 'industry',
				            'field' => 'id',
				            'terms' => $ids,
				        )
				    )
				);    //echo "<pre>";
						//query_posts($args);
					$allemail="";
					$post_link ="";
						$the_query = new WP_Query( $args );
						//$freelance_id = '';
					while ( $the_query->have_posts() ) : $the_query->the_post();
					    //echo "<pre>";print_r($the_query);echo "</pre>";
					    $freelance_id[] = get_the_ID(); 	
					     	 //$post_link= the_permalink(); 			   
                  endwhile;
				      	}

				      	$freelance_id1 = array_unique($freelance_id);
				      	$freelance_id1 = array_values($freelance_id1);
				      	//print_r($freelance_id1);
				      	//exit();
				      	$flag = 0;
				        	foreach($freelance_id1 as $freeid)
				      	{
				      			if (isset($_REQUEST['cat_checkbox']))  {
				      		//echo "<br>".$freeid;

				      		$allemail = get_field( 'email_address', $freeid);
				      	   $admin_approved = get_field( 'admin_approved_listing' , $freeid); 
				         	//$admin_approved = trim($admin_approved,'"');
				         	$post_link= get_permalink( $freeid );
				           	//exit();
				           	//$a1 = get_field( 'industries',$freeid );
				           	$a1 = wp_get_post_terms($freeid, 'industry', array("fields" => "ids"));
                       
									$a2 = $_REQUEST['cat_checkbox'];
						
									$result = @array_values(array_intersect($a1,$a2));

									
									//echo "<br> result = ".$freeid." = ";print_r($result);
									 $result1 = count($result);	
									//exit();
										for($i=0; $i < $result1 ; $i++){
										
				      		$industry_cat = get_the_category_by_ID($result[$i]);
				      	
				          		 //Email information
					  //$admin_email = "developermy@mailinator.com";
					 $checkbox = implode(',',$_REQUEST['cat_checkbox']);
					  $subject = 'Job interview notification:'.get_field( "job_listing_title",$fids );
					  $description = $_REQUEST['description'];
					  $freelancer_mess = $_REQUEST['freelancer_mess'];	 
					 
					  $htmlContent = '
					    <html>
					    <head>
					        <title>Welcome to Freelance.capetown/</title>
					    </head>
					    <body>
					    <p> Hello,<br> <br> I would like you to apply on my job. <br> The job details is given below:<br><br><br> </p>
					        <h1>'.get_field( "job_listing_title",$fids ).'</h1>
					        <table cellspacing="0" style="border: 2px dashed #FB4314; width: 500px; height: 300px;">
					        	<tr>
					                <th>Price From:</th><td>'.get_field( "price_from",$fids ).'</td>
					            </tr>
					            <tr>
					                <th>Price To:</th><td>'.get_field( "price_to",$fids ).'</td>
					            </tr>
					            <tr>
					                <th>Type of Work:</th><td>'.get_field( "type_of_work",$fids ).'</td>
					            </tr>
					            <tr>
					                <th>On Site or Remote:</th><td>'.get_field( "on_site_or_remote",$fids ).'</td>
					            </tr>
					            <tr>
					                <th>Disclose Remuneration?:</th><td>'.get_field("disclose_remuneration",$fids ).'</td>
					            </tr>
					             <tr>
					                <th>Industry:</th><td>'.$industry_cat.'</td>
					            </tr>
					        	<tr>
					                <th>Message:</th><td>'.$freelancer_mess.'</td>
					            </tr>
					               <tr>
					                <th>Job Description :</th><td>'.$description.'</td>
					            </tr>
					           
					            <tr>
					                <td><a href="'.$job_post_link.'" style="padding:8px; cursor:pointer; text-align:center; color: rgb(0, 0, 0); float: right; marging:0 10px; border:none;  background-color:#00a8e6;">Apply Now</a></td>
					            </tr>
					        </table>
					    </body>
					    </html>';

				// Set content-type header for sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						//echo $admin_approved;
						if( isset($allemail) && $admin_approved == "yes"){
						    
							
						if(mail($allemail,$subject,$htmlContent,$headers)):
							$flag = 1;
						update_post_meta($fid,'mail_send', 1);
						  					   
						endif;
							  //} 
							}
							/*else{
							    echo "</br>";
							    echo $admin_approved."!!".$freeid;
							    echo "</br>";
							    
							}*/
				   }
						

					 }
				} 
                      
 
					   
	}
	
	else{ echo  '<span class="emailsend">Email Already sent </span><br>';}
           	  }
	else{
	    echo "<h2>Your Listing has not been approved by Admin. You can send the brief once your listing has been approved by Admin.</h2>";
	    exit();
	}
					if($flag ==1){
							echo  '<span class="emailsend">'.$successMsg = 'Email has sent successfully.'.'</span>';	
					}//else{echo  '<span class="emailsend">'.$errorMsg = 'Email sending fail.'.'</span>';}

				 	   } 
	                    //$emails[]=array_unique($allemail);

	                         //$email_to=  implode(',',$allemail);
	                        // $link = implode(',', $post_link);
	                         //print_r($link);
	                         //print_r($email_to);

                 //echo $fids;
				 ?>
           	
           	
           		    
			     <a class="uk-button uk-button-blue uk-button-small" style="margin-bottom:20px;" href="<?php echo get_site_url(); ?>/dashboard">Back To Dashboard</a>
			    <div class="uk-grid">
			       
			    	<div class="uk-width-1-3"><label for="Job Listing Title"><h4>Job Listing Title :<h4><h5> <?php echo get_field( 'job_listing_title',$fids );?><h5></label></div>

			    	<div class="uk-width-1-3"><label for="Price From"><h4>Price From : </h4> <h5> <?php echo get_field( 'price_from',$fids );?></h4></label></div>

			    	<div class="uk-width-1-3"><label for="Price To"><h4>Price To : </h4><h5> <?php echo get_field( 'price_to',$fids );?></h4></label></div>

			    	<div class="uk-width-1-3"><label for="Type of Work"><h4>Type of Work : </h4><h5> <?php echo get_field( 'type_of_work',$fids );?></h5></label></div>

			    	<div class="uk-width-1-3"><label for="On Site or Remote"><h4>On Site or Remote  :</h4> <h5> <?php echo get_field( 'on_site_or_remote',$fids );?></h5></label></div>

			    	<div class="uk-width-1-3"><label for="Disclose Remuneration?"><h4>Disclose Remuneration?  :</h4> <h5> <?php echo get_field( 'disclose_remuneration',$fids );?></h5></label></div>

			    	<div class ="uk-width-1-1">
			    	 <div class="pricing-levels-3">          

			    <form method="POST" name="job_notification" action="">
    	
			    	
			    	<div class="categorychecklist-holder">
		
			    <?php if( $industries = get_field( 'industries',$fids ) ) : ?>

				        <h2 class="freelance-skills" style="font-size:1em;">
				        	<div><h4><label for="Your Selected Categories">Your Selected Industries</label></h4></div>
				        		<div class="uk-scrollable-box">
                             <ul class="uk-list">
  

				        	<?php
				        		
				        		$indOut = "";
				        		foreach( $industries as $k=>$v ) :
				        			  $ins_id[] = $v;
				        			$indOut .=  ( get_term( $v, 'industry' )->name ) . " / ";
				        			
				        			?><?php 
				        		endforeach;
				        		$indOut = substr($indOut, 0, -3);
				        		$exp = explode("/",$indOut );
				        		$combval=array_combine($ins_id,$exp);
				        		foreach($combval as $key =>$ex) {?>
				        			
				        		<li><label><input type="checkbox" id="cat_checkbox" name="cat_checkbox[]" value="<?php echo $key?>" <?php 
				        		if(isset($_POST["cat_checkbox"])) 
				        			{ if(in_array($key,$_POST["cat_checkbox"]))
				        		{

				        			echo 'checked="checked"'; 
				        		}
				        				
				        			} ?>/ > <span><?php echo $ex; ?></span></label>
				        			<input type="hidden" id="cat_checkbox_hid" name="cat_checkbox_hid" value=""/>
				        		</li>
				        		<?php }?>
				        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
				        <script type = "text/javascript">
              	  $(document).ready(function(){
              	  		$('.submit_job .extra_sub').click(function(){
              	  			
              	  			var cnt = $('input[type=checkbox]:checked').length;
			    			//alert(cnt);		
              	  			if(cnt == 0)
              	  			{

              	  				alert('Please select atleast one industry');
              	  				return false;
              	  				jquery('.freelance-skills').focus();
              	  			}	
              	  		});

              	  });

              		</script>
              		 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
			    		<script>

			    		$('input[type=checkbox]').change(function(e){
			    			
					   if ($('input[type=checkbox]:checked').length > 4) {
					        $(this).prop('checked', false)
					        $( "#dialog" ).dialog();
					        //alert("allowed only 4");
					   }
					   
					});
			    		</script>	
				        	
				     <div id="dialog" title="industry">Allowed Only 4</div>  
				             
    </ul>
</div>
				      	
				        <div class="uk-clearfix">&nbsp;</div>
			    	<?php endif; ?>
			
		           </div>
			    	<div ><label for="Description"><h4> Description</h4></label></div>
			    	<textarea rows="8" cols="200" name="description" id="description"><?php echo get_field( 'job_listing_description',$fids );?> </textarea>
			    	<input type="hidden" id="description_hid" name="description_hid" value=""/>
			    	<div>
			    		<label for="Message for Freelancer"><h4> Message for Freelancer</h4></label></div>
			    	<textarea rows="8" cols="200" id="freelancer_mess" name="freelancer_mess"> </textarea>
					<input type="hidden" id="freelancer_mess_hid" name="freelancer_mess_hid" value=""/>
			    	<div class="submit_job"><input type="submit" class ="uk-button uk-button-small uk-button-primary extra_sub" value="Submit"/></div>
			    	<div class="priview_btn"><input  onClick="process1();" type="button" id="myBtn" class ="uk-button uk-button-small uk-button-primary extra_sub" value="Preview"/></div>
					
				</form>
				 

			    	 </div>
			   </div>
			   </div>
			</div>
	 </section>
	 <?php endwhile; endif; wp_reset_postdata(); ?>
	
				 <!-- Trigger/Open The Modal -->


<!-- The Modal -->
 
<div id="myModal" class="modal preview_model">
<div class="popupout">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
    	<div></div>
      <span class="close">&times;</span>
     
    </div>


    <div class="modal-body">
      <?php
        
					 	
      echo $htmlContent = '
					      <p> Hello,<br> <br> I would like you to apply on my job. <br> The job details is given below:<br><br><br> </p>
					        <h5>'.get_field( "job_listing_title",$fids ).'</h5>
					        <table cellspacing="0" class="previwbtn" style="min-width: 30%; height: auto; text-align:left;">
					        	<tr>
					                <td>Price From: '.get_field( "price_from",$fids ).'</td>
					           
					                <td>Price To: '.get_field( "price_to",$fids ).'</td>
					            </tr>
					            <tr>
					                <td>Type of Work: '.get_field( "type_of_work",$fids ).'</td>
					            
					                <td>On Site or Remote: '.get_field( "on_site_or_remote",$fids ).'</td>
					            </tr>
					            <tr>
					                <td>Disclose Remuneration?:</td><td>'.get_field("disclose_remuneration",$fids ).'</td>
					            </tr>
					            
					        	<tr>
					                <td>Message:</td><td id="freedes"></td>
					            </tr>
					               <tr>
					                <td>Job Description :</td><td id="mydesc"></td>
					            </tr>
					           
					           
					        </table><br><br>';
       ?>
    </div>
   
  </div>

</div>	   
</div>     


    <?php



	                   
              } 

              	         //email code


				      	

				      

	/**
	 * Add ACF form for front end posting
	 * @uses Advanced Custom Fields Pro
	 */

     //Output: myquery
	if(!isset($_GET['Step'])){
    $url = site_url().'/manage-job-listing/';
    $fid = get_query_var('fid');
	$new_post = array(
		
		'post_id'  => get_query_var('fid') ? get_query_var('fid') : 'manage_freelance_listing', // Create a new post OR load from existing...
		'listing_type'  => 'manage_freelance_listing', // Create a new post OR load 
		'new_post'		=> array(
			'post_type'		=> 'freelancer',
			'post_status'	=> 'draft',
			//'post_title'  => $_POST['acf']['field_56e300b3821e5'],
        	//'post_content'  => $_POST['acf']['field_56e300b3822c5'],
		),
		
		// PUT IN YOUR OWN FIELD GROUP ID(s)
		'field_groups'       => array( 'group_5701303842237' ), // Create post field group ID(s)
		'form'               => true,
		//'return'             => add_query_arg( array( 'saved' => 'yes' ) ), // Redirect to new post url %post_url% 
		//template-manage-job-listing-cat.php

		'return' => add_query_arg( array('Step'=>'next','fd'=>$fid), $url ),
		'html_before_fields' => '',
		'html_after_fields'  => '',
		'submit_value'       => 'Save Listing',
		'updated_message'    => '
			<div class="uk-alert uk-alert-success" data-uk-alert>
			    <a href="" class="uk-alert-close uk-close"></a>
			    <p>
			    	Your job listing has been submitted to us for review, thank you.
			    </p>
			</div>
		',
		'uploader' => 'wp',
		'submit_value' => __("Update My Listing", 'acf'),
		'form_attributes' => [
			'class' => 'uk-form sd-form-manage-listings'
		],
		
	);
		
	?>
		<div class="uk-container uk-container-center">
			<div class="uk-grid">
				<div class="uk-width-1-1">
					<h3><strong>Manage Job Listing:</strong> <span class="uk-text-primary"><?php //echo get_query_var('fid') ? get_the_title( get_query_var('fid') ) : NULL; ?></span></h3>
					<a class="uk-button uk-button-blue uk-button-small" href="<?php echo get_site_url(); ?>/dashboard">Back To Dashboard</a>
					<!--a class="uk-button uk-button-blue uk-button-small" href="<?php echo get_site_url(); ?>/manage-job-listing/?Step=next&fid=<?php echo $fid;?>">Send Brief</a>-->
					<?php acf_form( $new_post ); ?>
				</div>
			</div>
		</div>
		<p>&nbsp;</p>
	<?php
	//echo  get_field( 'email_address',get_query_var('fid') );
	
}
/*}
else{

	wp_redirect(home_url());
}*/
}
beans_load_document();?>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
	document.getElementById("description_hid").value = document.getElementById("description").value; 
	document.getElementById("freelancer_mess_hid").value = document.getElementById("freelancer_mess").value; 
	
	var dis = document.getElementById("description").value;
	var freedis = document.getElementById("freelancer_mess").value;
	
	document.getElementById("mydesc").innerHTML = dis;
	document.getElementById("freedes").innerHTML = freedis;
	
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
