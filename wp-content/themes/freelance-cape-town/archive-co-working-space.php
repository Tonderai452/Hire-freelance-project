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

beans_modify_action( 'beans_content_template', 'beans_main_append_markup', 'sd_view_content' );
beans_remove_action( 'beans_breadcrumb' );
beans_remove_attribute( 'beans_main', 'class', 'uk-block' );

// Temporarily remove comments for this page 
beans_remove_action('beans_comments_template');

beans_remove_markup('beans_post_meta_item_author');
add_filter('beans_post_meta_item_author_text_output', function( $in ){ return false; });
	
     
   //print_r($special_facility);
add_action( 'beans_header_after_markup', function(){
	
} );

function sd_view_content() {



?>


<?php

SESSION_START();

?>
	
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

  <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/src/js/bootstrap-multiselect.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<script type="text/javascript">

    $(document).ready(function() {

        $('#multiple-checkboxes').multiselect();

    });

</script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
	  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  
  <script type="text/javascript">
  
  $(function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 5000,
      values: [ 0, 5000 ],
      slide: function( event, ui ) {
        $( "#amount" ).html( "R" + ui.values[ 0 ] + " - R" + ui.values[ 1 ] );
		$( "#amount1" ).val(ui.values[ 0 ]);
		$( "#amount2" ).val(ui.values[ 1 ]);
      }
    });
    $( "#amount" ).html( "R" + $( "#slider-range" ).slider( "values", 0 ) +
     " - R" + $( "#slider-range" ).slider( "values", 1 ) );
  });
  </script>
	<section class="section top-freelancers">

      <div class="uk-container uk-container-center">

										
		<?php 
  
          	$filter_selected[] ="";
          	if(isset($_REQUEST['submit'])) 
	          {       
	          	//print_r($_REQUEST);

	          	 	 if(isset($_REQUEST['amount1']) || isset($_REQUEST['amount2']) )
	          	   {
	           		   $price1 = $_REQUEST['amount1'];
	           		   $price2 = $_REQUEST['amount2'];

	           		} else
	           		  {
	           		   $price1=0;
                       $price2=0;
                       }
 			         if(!empty($_REQUEST['search_text'])){
 			        
 			         $search_text=$_REQUEST['search_text'];
 			        }
 			        else
 			        {
 			        	$search_text=0;

 			        } 
	               if(isset($_REQUEST['cat_checkbox']))

	                {
	                	$filter_selected = $_REQUEST['cat_checkbox'];
	                } 
	                else{$filter_selected=[];

	                }
	                if(!empty($_REQUEST['office_space_area'])){

	                 $officespace_selected = $_REQUEST['office_space_area'];

	               } 
	               else{

	               	$officespace_selected =0;
	               }
	               	?> 

	           		
          <div class="uk-clearfix">&nbsp;</div>
          <div class="uk-clearfix">&nbsp;</div>
          							
								  <div class="uk-width-large-1-1 .uk-visible-large width-bar">
        					   
							<form class="uk-form uk-form-blank position_abs" method="POST" action="">
							    <div class="uk-grid">

							    	 <div class="uk-width-medium-1-5">
							          <?php if(!empty($search_text) && $search_text!="0" ){?>
							        <input type="text" class="search_text" placeholder="Enter keyword..." id="edit-search-api-views-fulltext" name="search_text" value="<?php echo $search_text;?>" size="30" maxlength="128" class="form-search-text">
							        <?php } else{?>

							        <input type="text" class="search_text" placeholder="Enter keyword..." id="edit-search-api-views-fulltext" name="search_text" value="" size="30" maxlength="128" class="form-search-text">
							       <?php } ?>
							        </div>
							        <div class="uk-width-medium-1-5">
							        	 <select id="multiple-checkboxes" multiple="multiple" name="cat_checkbox[]">
							        	 	
							        	 	<?php $fields = get_field_objects();          				
                      $special_facility = array_values($fields['special_facilities']['choices']);
					 foreach($special_facility as $specl_fac): ?>
									        <option  value="<?php echo $specl_fac?>"

									        	<?php 
				        		if(isset($_REQUEST["cat_checkbox"])) 
				        			{ if(in_array($specl_fac,$_REQUEST["cat_checkbox"]))
				        		{

				        			 echo 'selected="selected"'; 
				        		}
				        				
				        			} ?>
								>
									        	<?php echo $specl_fac?></option>
									        	<?php endforeach; ?>
									         </select>
										
							        </div>
							       <div class="uk-width-medium-1-5">
							       
							 		<select name="office_space_area" id="office_space" class="">
											<option value="-1">Office Space Size</option>
											<?php         				
                                           $office_space_area = array_values($fields['office_space_area']['choices']);
							        		   
							        		   foreach($office_space_area as $office_spacess): ?>

												<option value="<?php echo $office_spacess;?>" <?php 
            if(!empty($officespace_selected)){ 								
            if($office_spacess == $officespace_selected) { 
            echo 'selected="selected"'; 
            } }?>><?php echo $office_spacess;?></option>
											<?php endforeach; ?>
																						
							        	</select>
							        </div>
									  <!--<div class="uk-width-medium-1-6">
											<?php if(!empty($_REQUEST['amount1']) || !empty($_REQUEST['amount2']) )
	          	   { ?> <p class="range_para">Price Range :<span><?php  echo $price1; echo "-"; echo $price2;?> </span></p><?php } else{?>

										<p class="range_para"> Price Range:<span id="amount"></span></p>
										<?php } ?>
			  		                    <div id="slider-range"></div>
	                                   <input type="hidden" name="amount1" id="amount1" value="">
	                                   <input type="hidden" name="amount2" id="amount2" value="">
 
							        </div>-->
							        <div class="uk-width-medium-1-5">
							        	<input type="submit"   name="submit" value="Search" class=" uk-button uk-button-blue uk-button-small filter_sub">
							        </div>
							</div>
					</form>	
				</div>
         
 			<?php 
 			
 			
 			 
 			  //echo "<pre>"; print_r($search_query1); echo "</pre>";exit();
          		$count = count($filter_selected);//filter Result
          		
				$new_array =array();
				$co_post_id =array();
				$pricerange =array();
          		// $new_aarayy = array['meta_query'][0];
          		 $require_1 = "";
          		for($i = 0; $i<$count; $i++)
		     {

      		 $new_aarayy[] =  array(
                                    'key'   => 'special_facilities',
                                    'value' => $filter_selected[$i],
                                    'compare'   => 'LIKE'
		                             );
      	
            }
			$new_aarayy[] =  array(
                                    'key'   => 'office_space_area',
                                    'value' => $officespace_selected,
                                    'compare'   => 'LIKE'
		           
		                           );
			if(!empty($price1) || !empty($price2) ){ 
				
          		global $wpdb;
          		$query = $wpdb->get_results("Select post_id, meta_value From wp_postmeta where meta_key = 'pricing_options' AND meta_value > 0");
          		foreach ($query as $que) {
          				$qu_metavalue[] = $que->meta_value;
          		}
          			//print_r($qu_metavalue);
          		$meta_value = $qu_metavalue;
          		foreach ($meta_value as $metaval) {

          			for($j =0;$j<=$metaval;$j++)
          			{
          			$query = $wpdb->get_results("Select * from wp_postmeta where meta_key IN( 'pricing_options_".$j."_price') AND meta_value BETWEEN $price1 AND $price2");
          			  $rowcount = $wpdb->num_rows; //echo "<pre>";print_r($query);
          			for($k =0;$k<$rowcount;$k++){
          				  $co_post_id[] =$query[$k]->post_id;
          				 }

		     

          			}	

          				
          		}
       }          		

					               $a = array('relation' => 'OR');
					               $new = array_merge($a,$new_aarayy);
					               //$new = array_merge($new_aarayy,$pricerange);
					               //echo "<pre>"; print_r($new_aarayy); echo "</pre>";exit();
					            
					               $q1 = new WP_Query( array(
								    'post_type' => 'co-working-space',
								    's' => $search_text,
								    'compare'   => '='
								));

					             // echo "<pre>"; print_r($q1->posts); echo "</pre>";exit();

								$q2 = new WP_Query( array(
								    'post_type' => 'co-working-space',
								    'meta_query' => $new
								));
								//echo "<pre>"; print_r($q2->posts); echo "</pre>";exit();
									
									if(!empty($co_post_id)){
					                $q3 = new WP_Query( array(
								     'post_type' => 'co-working-space',
								     'post__in' => $co_post_id
								 ));
					            
					           
					           
					            //echo "<pre>"; print_r($q3); echo "</pre>";exit();

								$loop = new WP_Query();

								$loop->posts = array_unique( array_merge( $q1->posts, $q2->posts,$q3->posts), SORT_REGULAR );
								 $loop->post_count = count( $loop->posts );

						     }else{
						  		$loop = new WP_Query();

								$loop->posts = array_unique( array_merge( $q1->posts, $q2->posts), SORT_REGULAR );
								 $loop->post_count = count( $loop->posts );


						  }

						    //echo "<pre>";print_r($loop->posts);echo "</pre>"; exit();
						echo '<div class="uk-grid">';
						if ( $loop->have_posts() ) {

						while ( $loop->have_posts() ) : $loop->the_post(); ?>
											<div class="uk-width-medium-1-4 uk-width-1-1 freelancer-item uk-height-1-1 uk-position-relative max-height" data-uk-grid-margin="" style="padding-bottom:30px;">
					                   <?php   if (has_post_thumbnail()) {?>
					                  <a href="<?php echo the_permalink(); ?>">
					                  	  <?php echo the_post_thumbnail('small', array('class' => 'border-highlight max-height')); ?>
					                  </a>
					                   <?php } else { ?>

			                               <a href="<?php echo the_permalink(); ?>">  <image class="border-highlight wp-post-image max-height " alt="Freelance.captown" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/noimage.png"/></a>

			                               <?php } ?> 
	                                     
					                  <div class="fct-caption uk-text-left">
						                    <h4 class="fct-title"><?php echo get_the_title(); ?> <!--<small>&nbsp;&nbsp;<i class="fa fa-star"></i><span>&nbsp;15</span></small></h4>-->
						                    <p>&nbsp;</p>
						                    <a href="<?php echo the_permalink(); ?>" class="uk-button uk-button-blue uk-button-small" role="button" style="position:absolute;bottom:0;left:30px;">View Space</a>
					                  </div>
			                </div>    
						  			
						<?php endwhile;
						 
						 } // end if have post
                        else {
						  	if(!empty($_REQUEST['amount1']) || !empty($_REQUEST['amount2']) || !empty($_REQUEST['search_text']) || !empty($_REQUEST['cat_checkbox']) || $_REQUEST['office_space_area']!=-1){     
                	        echo '<h2 class="notpost">'.wpautop( 'Sorry, No Result Found' ).'</h2>';
                
	                    } // end empty condition 
                     }  // end else have post 	
							

                       	
							


						echo '</div>';	
					 
						
				//*** all field empety

         		if(empty($_REQUEST['amount1']) && empty($_REQUEST['amount2']) && empty($_REQUEST['search_text']) && empty($_REQUEST['cat_checkbox']) && $_REQUEST['office_space_area']==-1){  
       			              

          		echo '<div class="uk-grid">';

          		while( have_posts() ){ the_post();?>

						
					<div class="uk-width-medium-1-4 uk-width-1-1 freelancer-item uk-height-1-1 uk-position-relative max-height" data-uk-grid-margin="" style="padding-bottom:30px;">
		                   <?php   if (has_post_thumbnail()) {?>
		                  <a href="<?php echo the_permalink(); ?>">
		                  	  <?php echo the_post_thumbnail('sd-portfolio-large', array('class' => 'border-highlight max-height')); ?>
		                  </a>
		                   <?php } else { ?>

                               <a href="<?php echo the_permalink(); ?>">  <image class="border-highlight wp-post-image" alt="Freelance.captown" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/noimage.png"/></a>
                              <?php } ?>         
			                  <div class="fct-caption uk-text-left">
				                    <h4 class="fct-title"><?php echo get_the_title(); ?> <!--<small>&nbsp;&nbsp;<i class="fa fa-star"></i><span>&nbsp;15</span></small></h4>-->
				                    <p>&nbsp;</p>
				                    <a href="<?php echo the_permalink(); ?>" class="uk-button uk-button-blue uk-button-small" role="button" style="position:absolute;bottom:0;left:30px;">View Space</a>
			                  </div>
		                </div>
          			<?php
          		}
          		echo '</div>';
			} //*** all field empety if end

					
					
					
         	
          	} else { ?>
         

          	 <div class="uk-width-1-1">
          	<span id="listings"></span>
          	<h2 class="uk-text-bold uk-text-center co_text">CO-WORKING SPACES</h2>
          </div>

          <div class="uk-clearfix">&nbsp;</div>
          					
          						<div class="uk-width-large-1-1 .uk-visible-large width-bar">
        					   
							<form class="uk-form uk-form-blank position_abs" method="POST" action="">
							    <div class="uk-grid">

							    	 <div class="uk-width-medium-1-5">
							        <input type="text" class="search_text" placeholder="Enter keyword..." id="edit-search-api-views-fulltext" name="search_text" value="" size="30" maxlength="128" class="form-search-text">
							        </div>
							        <div class="uk-width-medium-1-5">
							         <select id="multiple-checkboxes" multiple="multiple" name="cat_checkbox[]">
							        	 	
							        	 	<?php $fields = get_field_objects();
							        	 	         				
                      $special_facility = array_values($fields['special_facilities']['choices']);
					 foreach($special_facility as $specl_fac): ?>
									        <option  value="<?php echo $specl_fac?>"

									        	<?php 
				        		if(isset($_REQUEST["cat_checkbox"])) 
				        			{ if(in_array($specl_fac,$_REQUEST["cat_checkbox"]))
				        		{

				        			 echo 'selected="selected"'; 
				        		}
				        				
				        			} ?>
								>
									        	<?php echo $specl_fac?></option>
									        	<?php endforeach; ?>
									         </select>
										
							        </div>
							       <div class="uk-width-medium-1-5">
							 		<select name="office_space_area" id="office_space" class="">
											<option value="-1">Office Space Size</option>
											<?php         				
                                           $office_space_area = array_values($fields['office_space_area']['choices']);
							        		   foreach($office_space_area as $office_spacess): ?>
								
												<option value="<?php  echo $office_spacess;?>"<?php 
				if(!empty($officespace_selected)){ 								
            if($office_spacess == $officespace_selected) { 
            echo 'selected="selected"'; 
            } }?>><?php echo $office_spacess;?></option>
											<?php endforeach; ?>
																						
							        	</select>
							        </div>
									  <!--<div class="uk-width-medium-1-6">
									  	<?php if(!empty($_REQUEST['amount1']) || !empty($_REQUEST['amount2']) )
	          	   { echo "Price Range:"; echo $price1; echo "-"; echo $price2;} else{?>
										<p class= "range_para"> Price Range:<span id="amount"></span></p>
										<?php }?>
			  		                    <div id="slider-range"></div>
	                                   <input type="hidden" name="amount1" id="amount1" value="">
	                                   <input type="hidden" name="amount2" id="amount2" value="">
 
							        </div>-->
							        <div class="uk-width-medium-1-5" style="text-align:center;">
							        	<input type="submit"   name="submit" value="Search" class=" uk-button uk-button-blue uk-button-small filter_sub">
							        </div>
									
									<div class="uk-width-medium-1-5">
							        	<a href="http://freelance.capetown/registration-step-1?role=regCoWorker" class="uk-button uk-button-blue uk-button-small" role="button" style="position:absolute;    margin: 17px 0px;">Register Space</a>
							        </div>
							</div>
					</form>	
				</div>
          	<?php
         		
          		

	               

          		echo '<div class="uk-grid">';

          		while( have_posts() ){ the_post();?>

						
					<div class="uk-width-medium-1-4 uk-width-1-1 freelancer-item uk-height-1-1 uk-position-relative max-height" data-uk-grid-margin="" style="padding-bottom:20px;    bottom: 22px;">
		                   <?php   if (has_post_thumbnail()) {?>
		                  <a href="<?php echo the_permalink(); ?>">
		                  	  <?php echo the_post_thumbnail('sd-portfolio-large', array('class' => 'border-highlight max-height')); ?>
		                  </a>
		                   <?php } else { ?>

                               <a href="<?php echo the_permalink(); ?>">  <image class="border-highlight wp-post-image" alt="Freelance.captown" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/noimage.png"/></a>
                              <?php } ?>         
			                  <div class="fct-caption uk-text-left">
				                    <h4 class="fct-title"><?php echo get_the_title(); ?> <!--<small>&nbsp;&nbsp;<i class="fa fa-star"></i><span>&nbsp;15</span></small></h4>-->
				                    <p>&nbsp;</p>
				                    <a href="<?php echo the_permalink(); ?>" class="uk-button uk-button-blue uk-button-small" role="button" style="position:absolute;bottom:0;left:30px;">View Space</a>
			                  </div>
		                </div>
          			<?php
          		}
          		echo '</div>';
          	} //else conditions
			
          


          		$pagination = paginate_links( [
          			'type' => 'array'
          		] );
          		if( !empty( $pagination ) ){
          			echo '<div class="uk-width-1-1">';
	          			echo '<ul class="uk-pagination">';
	          				foreach( $pagination as $paged ){
	          					echo '<li>' . $paged . '</li>';
	          				}
	          			echo '</ul>';
          			echo '</div>';
          		} 
          	

          ?>
        </div>
      
  </section>

<?php

}

beans_load_document();
?>


