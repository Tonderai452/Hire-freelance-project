<?php

/**
 * Freelance Cape Town functions and definitions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * @package Freelance Cape Town
 * @since 0.1.0
 */

// Useful global constants
define( 'SD_VERSION',      '0.1.0' );
define( 'SD_URL',          get_stylesheet_directory_uri() );
define( 'SD_TEMPLATE_URL', get_stylesheet_directory_uri() );
define( 'SD_PATH',         get_stylesheet_directory() . '/' );
define( 'SD_INC',          SD_PATH . 'includes/' );

// Include compartmentalized functions
require_once SD_INC . 'functions/core.php';
require_once SD_INC . 'functions/post-types.php';
require_once SD_INC . 'functions/media.php';
require_once SD_INC . 'functions/api.php';
require_once SD_INC . 'functions/woocommerce.php';
require_once SD_INC . 'functions/ajax.php';
require_once SD_INC . 'functions/acf.php';

// Include lib classes

// Run the setup functions
SD\Freelance_Cape_Town\Core\setup();
SD\Freelance_Cape_Town\PostTypes\setup();
SD\Freelance_Cape_Town\Media\setup();
SD\Freelance_Cape_Town\Ajax\setup();

// Include Beans. Do not remove the line below.
require_once( get_template_directory() . '/lib/init.php' );

require_once SD_INC . 'functions/beans.overrides.php';

// Remove default beans styling
remove_theme_support( 'beans-default-styling' );

// Enqueue the less file
beans_compiler_add_fragment( 'uikit', get_stylesheet_directory_uri() . '/style.less', 'less' );

// Remove Sidebar
add_action( 'widgets_init', 'bpcp_child_widgets_init' );
function bpcp_child_widgets_init()
{
	beans_deregister_widget_area( 'sidebar_primary' );
	beans_deregister_widget_area( 'sidebar_secondary' );
}

// Alter Header Image Dimensions
beans_add_attribute( 'beans_logo_image', 'class', 'uk-responsive-width' );
beans_add_attribute( 'beans_logo_image', 'style', 'width: 225px; margin-top: 5px;' );

// Add UK Sticky to menu
beans_add_attribute( 'beans_header', 'data-uk-sticky', '' );
beans_remove_attribute( 'beans_header', 'class', 'uk-block' );

// Register Query Vars
add_filter( 'query_vars', 'add_query_vars_filter' );

function add_query_vars_filter( $qvars ){
    $qvars[] = 'fid';
    $qvars[] = 'industry';
    return $qvars;
}

// Overrides
beans_uikit_enqueue_components( array( 'sticky' ), 'add-ons' );

if( !is_user_logged_in() ) :
	add_action('beans_menu_navbar_append_markup', function(){
		?>

	  <!-- Trigger the modal with a button -->
	 
	<li class="menu-item menu-item-type-post_type menu-item-object-page">
	<a class="fcpt-signin uk-button-blue reg_color" style="color:#fff !important;" href="<?php echo get_site_url().'/registration-step-1/';?>" >REGISTER</a>
			</li>
			
			<?php 
			add_action( 'beans_menu_offcanvas_append_markup', function(){
				
		?>
			<li class="menu-item menu-item-type-post_type menu-item-object-page">
	<a class="fcpt-signin uk-button-blue reg_color" style="color:#fff !important;" href="<?php echo get_site_url().'/registration-step-1/'; ?>" data-toggle="modal" data-uk-modal="{target: '#listnow'}">REGISTER</a>
			</li>
			
		<?php
	} );?>
	  
			<li class="fcpt-signin menu-item menu-item-type-post_type menu-item-object-page">
				<a class="fcpt-signin" href="#" data-uk-modal="{target: '#signUp'}">LOGIN</a>
			</li>
			<?php sd_show_cart(); ?>
		<?php
	});
	add_action( 'beans_menu_offcanvas_append_markup', function(){
		?>
			<li class="fcpt-signin menu-item menu-item-type-post_type menu-item-object-page">
				<a class="fcpt-signin" href="#" data-uk-modal="{target: '#signUp'}">LOGIN</a>
			</li>
			<?php sd_show_cart(); ?>
		<?php
	} );
endif;





if( is_user_logged_in() ) :
	add_action('beans_menu_navbar_append_markup', function(){
		?>
			<li class="fcpt-signin menu-item menu-item-type-post_type menu-item-object-page">
				<a class="fcpt-signin" href="<?php echo wp_logout_url(); ?>">Logout</a>
			</li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page">
				<a class="fcpt-account" href="<?php echo site_url(); ?>/dashboard">
					<span class="uk-icon-button uk-icon-cog"></span>
				</a>
			</li>
			<?php sd_show_cart(); ?>
		<?php
	});
	add_action( 'beans_menu_offcanvas_append_markup', function(){
		?>
			<li class="fcpt-signin menu-item menu-item-type-post_type menu-item-object-page">
				<a class="fcpt-signin" href="<?php echo wp_logout_url(); ?>">Logout</a>
			</li>
			<li class="menu-item menu-item-type-post_type menu-item-object-page">
				<a class="fcpt-account" href="<?php echo site_url(); ?>/my-account">
					My Account
				</a>
			</li>
			<?php sd_show_cart(); ?>
		<?php
	} );
endif;

// LogIn Modal

// Enqueue UIKit Components used sitewide
beans_uikit_enqueue_components( array( 'modal' ), 'core' );

add_action( 'wp_footer', 'sd_signin_modal' );
function sd_signin_modal(){
	?>
		<!-- Sign In Modal -->

		<div class="uk-modal" id="signUp">
          <div class="uk-modal-dialog">
              <div class="uk-modal-header">

		        <h3 class="uk-text-center">
		        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_logo.png" width="50" height="50" alt="CPT">
		        	<div class="uk-clearfix">&nbsp;</div>
		        	Sign In To Freelance Cape Town
		        
		        </h3>
		        <!--<p class="uk-text-center">Howdy! Welcome back, lets get you signed in</p>-->
		      </div>
              <div class="modal-body woocommerce">
                
                <!-- login form -->
				<form method="post" class="login uk-form uk-form-stacked sign-up-form" style="margin:0;border:none;">

					<?php do_action( 'woocommerce_login_form_start' ); ?>

					<div class="uk-form-row" style="margin-top:0;">
						<label class="uk-form-label" for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input type="text" class="input-text uk-form-large uk-width-small-1-1" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
					</div>

					<div class="uk-form-row" style="margin-top:5px;">
						<label class="uk-form-label" for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
						<input class="uk-form-large uk-width-small-1-1" type="password" name="password" id="password" />
					</div>

					<?php do_action( 'woocommerce_login_form' ); ?>

					<div class="uk-form-row" style="margin-top:5px;">
						<?php wp_nonce_field( 'woocommerce-login' ); ?>
						<div class="uk-clearfix">&nbsp;</div>
						<input type="submit" class="uk-button uk-button-blue uk-button-large uk-float-right" name="login" value="<?php esc_attr_e( 'Sign In', 'woocommerce' ); ?>" />
						<div class="uk-clearfix">&nbsp;</div>
						<!--<label for="rememberme" class="inline uk-float-right">
							<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
						</label>-->
					</div>

					<p class="lost_password">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a> | <a href="<?php echo esc_url( site_url() . '/my-account' ); ?>"><?php _e( 'Register account', 'woocommerce' ); ?></a>
					</p>

					<?php do_action( 'woocommerce_login_form_end' ); ?>

				</form>
                <!-- end login form -->

              </div>
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
		<!-- End Sign In Modal -->
		
		
		
		
		
		
		
		
<!-- list now Modal -->

		<div class="uk-modal" id="listnow">
		 
          <div class="uk-modal-dialog" id="clo">
         
              <div class="uk-modal-header">
<a class="uk-modal-close uk-close"></a>
		        <h3 class="uk-text-center">
		        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_logo.png" width="50" height="50" alt="CPT">
		        	<div class="uk-clearfix">&nbsp;</div>
		        	Choose Your Plan
		        </h3>
		        <!--<p class="uk-text-center">Howdy! Welcome back, lets get you signed in</p>-->
		      </div>
		     
              <div class="modal-body woocommerce">
              <ul id="product-list">
		<?php 
		       $args = array(
		    'post_type'=> 'product',
		    'areas'    => 'painting',
		    'order'    => 'asc'
		    );              


			$the_query = new WP_Query( $args );

			if($the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post();
                  
			?>

		    <li class="service item_list">
				<?php global $woocommerce;
					$checkout_url = $woocommerce->cart->get_checkout_url();
			 		$product_id = get_the_ID();
			 		$url = site_url().'/shop/?add-to-cart='.$product_id.'';
			?>
			<a href="<?php echo $url;?>"> <?php the_post_thumbnail( 'small', array( 'class' => 'img-responsive center-block' ) );?>			 </a> 
			<h6><a href="<?php echo $url;?>"><?php the_title(); ?></a></h6>
              
               <span class="addcart "><a href="<?php echo $url;?>" class="uk-button uk-button-blue uk-button-small">Buy Now</a></span>
		    </li>

		<?php endwhile; else: ?>

		  

		<?php endif; wp_reset_postdata(); ?>

		</ul><!-- #product-list -->
                <!-- end login form -->

              </div>
<div style="clear:both;"></div>
          </div><!-- /.modal-dialog -->
<div style="clear:both;"></div>
        </div><!-- /.modal -->
		<!-- End List now Modal -->		
		<div style="clear:both;"></div>
		
		
	<?php
}

// Saving of Freelance Posts

function my_pre_save_post( $post_id ) {

    // Create new post
    $postType = @get_post( $post_id )->post_type;
    $post_content = isset($_POST['acf']['field_56fe5821d33f7']);
    if( $postType == 'freelancer'  && !is_admin() ){
    	$post = array(
    		'ID' => $post_id,
	    	'post_type'  => 'freelancer',
	        'post_status'  =>'publish',
	        'post_title'  => $_POST['acf']['field_56fe5821d3369'],
	        'post_content'  => $post_content,
	    );

    	if( get_field( 'ready_to_publish', $post_id ) == 'yes' && ( get_field( 'admin_approved_listing', $post_id ) == 'no' || (String) get_field( 'admin_approved_listing', $post_id ) == '' ) ) :
			$admin_to = 'simondowdles@gmail.com,marius@freelancecpt.com';
			$admin_subject = 'Please Approve Freelance Listing';
			$admin_body = "
A new freelance listing needs to be approved. Please view the listing at this link: " . ( get_admin_url() . 'post.php?post=' . $post_id . '&action=edit' ) . " \r\n\r\n
-- End Thank You --
";
			mail( $admin_to, $admin_subject, $admin_body );

		endif;

    }elseif( $postType == 'co-working-space'  && !is_admin() ){
    	$post = array(
    		'ID' => $post_id,
	    	'post_type'  => 'co-working-space',
	        'post_status'  => ( get_field( 'admin_approved_listing', $post_id ) == 'no' || (String) get_field( 'admin_approved_listing', $post_id ) == '' ) ? 'publish' : 'publish',
	        'post_title'  => $_POST['acf']['field_56fe50dab5e9c'],
	        'post_content'  => $_POST['acf']['field_56fe51011e33f'],
	    );

    	if( get_field( 'ready_to_publish', $post_id ) == 'yes' && ( get_field( 'admin_approved_listing', $post_id ) == 'no' || (String) get_field( 'admin_approved_listing', $post_id ) == '' ) ) :
			$admin_to = 'simondowdles@gmail.com,marius@freelancecpt.com';
			$admin_subject = 'Please Approve Coworking Listing';
			$admin_body = "
A new coworking listing needs to be approved. Please view the listing at this link: " . ( get_admin_url() . 'post.php?post=' . $post_id . '&action=edit' ) . " \r\n\r\n
-- End Thank You --
";
			mail( $admin_to, $admin_subject, $admin_body );

		endif;

    }elseif( $postType == 'job-listing'  && !is_admin() ){
    	
    	$post = array(
    		'ID' => $post_id,
	    	'post_type'  => 'job-listing',
	        'post_status'  => ( get_field( 'admin_approved_listing', $post_id ) == 'no' || (String) get_field( 'admin_approved_listing', $post_id ) == '' ) ? 'publish' : 'publish',
	        //'post_title'  => $_POST['acf']['field_57013242c69c5'],
	       // 'post_title'  => $current_user->display_name,
	       'post_content'  => $_POST['acf']['field_5701324dc69c6'],
	    );

    	if( get_field( 'ready_to_publish', $post_id ) == 'yes' && ( get_field( 'admin_approved_listing', $post_id ) == 'no' || (String) get_field( 'admin_approved_listing', $post_id ) == '' ) ) :
			$admin_to = 'simondowdles@gmail.com,marius@freelancecpt.com';
			$admin_subject = 'Please Approve Job Listing';
			$admin_body = "
A new job listing needs to be approved. Please view the listing at this link: " . ( get_admin_url() . 'post.php?post=' . $post_id . '&action=edit' ) . " \r\n\r\n
-- End Thank You --
";
			mail( $admin_to, $admin_subject, $admin_body );

		endif;

    }
    
    // insert the post
    $post_id = wp_insert_post( $post );

    //do_action( 'acf/save_post' , $post_id );
 
    // return the new ID
    return $post_id;
}

add_filter('acf/pre_save_post' , 'my_pre_save_post', 1 );

// Apply Featured Image to Listings

/**
 * Save ACF image field to post Featured Image
 * @uses Advanced Custom Fields Pro
 */
	add_action( 'acf/save_post', 'sd_save_image_field_to_featured_image', 10 );
	function sd_save_image_field_to_featured_image( $post_id ) {
		// Bail if not logged in or not able to post
		if( !is_admin() || 1 ) :

			if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
				return;
			}
			// Bail early if no ACF data
			if( empty($_POST['acf']) ) {
				return;
			}

			$image = '';

			// Get PostType of Saved Entity

			$postType = @get_post( $post_id )->post_type;

			if( $postType == 'freelancer' && !is_admin() ){
				// ACF image field key
				$image = $_POST['acf']['field_56fe5821d3cd8'];
			}elseif( $postType == 'co-working-space'  && !is_admin() ){
				// ACF image field key
				$image = $_POST['acf']['field_56fe51d8fe45f'];
			}
			
			
			// Bail if image field is empty
			if ( empty($image) || $image == '' ) {
				return;
			}
			// Add the value which is the image ID to the _thumbnail_id meta data for the current post
			add_post_meta( $post_id, '_thumbnail_id', $image );

		endif;
	}



function sd_add_rewrite_rules() {
    global $wp_rewrite;
 
    $new_rules = array(
        'freelancers/industry/(.+)/?$' => 'index.php?post_type=freelancer&industry=' . $wp_rewrite->preg_index(1)
    );
    $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

add_action( 'generate_rewrite_rules', 'sd_add_rewrite_rules' );

// Amend Job Loop if POST filter is set

if(isset($_GET['jobs_industry'])){
	global $filterIndustry;
	$filterIndustry = (int) $_GET['jobs_industry'];
	if($filterIndustry > 0){
		add_action('pre_get_posts', function($query){
			global $filterIndustry;
			global $wp_query;

			if ( !$query->is_main_query() ){
				return;
			}

			$taxquery = array(
				array(
					'taxonomy' => 'industry',
					'field' => 'term_id',
					'terms' => $filterIndustry,
					'operator'=> 'IN'
				)
			);

			$query->set('post_type' ,'job-listing');
			$query->set('post_status' ,'publish');
			$query->set('tax_query', $taxquery);

			//we remove the actions hooked on the '__after_loop' (post navigation)
			remove_all_actions ( '__after_loop');
		});
	}
}

// End Amend Job Loop if POST filter is set
$args = array(
	'name'          => __( 'Blog sidebar', 'sd' ),
	'id'            => 'blog-sidebar-ct',
	'description'   => '',
        'class'         => '',
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h4 class="widget-title"><span class="pattern-grey"></span><span><span>',
	'after_title'   => '</span></span></h4>' ); 

 register_sidebar($args);
 
 
$args = array(
	'name'          => __( 'Footer instagram', 'theme_text_domain' ),
	'id'            => 'footer-insta-id',
	'description'   => '',
        'class'         => '',
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>' );
register_sidebar($args);
// Remove the password strength meter from the WooCommerce checkout
			function removePasswordStrength() {
			    if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
			       wp_dequeue_script( 'wc-password-strength-meter' );
			    }
			}
 
        add_action( 'wp_print_scripts', 'removePasswordStrength', 100 );
//user Registration process
		add_action( 'wp_ajax_my_action', 'my_action' );
		add_action( 'wp_ajax_nopriv_my_action', 'my_action' );


function my_industry_scripts() {
   
   //wp_enqueue_script( 'jquery-1.12.4', get_stylesheet_directory_uri() . '/assets/src/js/jquery-1.12.4.js',  true );
    
	//wp_register_script('jQuery-1.11.1', get_stylesheet_directory_uri() . '/assets/src/js/jQuery-1.11.1.js', array('jquery'),'1.11.1', true);

	//wp_enqueue_script('jQuery-1.11.1');

    
    //wp_register_script( 'bootstrap.3.2.0.min', get_stylesheet_directory_uri() . '/assets/src/js/bootstrap.3.2.0.min.js',  array('jquery'),'3.2.0', true );
    //wp_enqueue_script('bootstrap.3.2.0.min');

    //wp_enqueue_script( 'html5imageupload.js', get_stylesheet_directory_uri() . '/assets/src/js/html5imageupload.js',  array('jquery'),'', true );
}
add_action( 'wp_enqueue_scripts', 'my_industry_scripts' );

function remove_scripts_styles_footer() {
    //----- JS
    //wp_deregister_script('jquery'); // Jetpack
}
 
add_action('wp_footer', 'remove_scripts_styles_footer');


add_action('wp_ajax_my_action', 'my_action'); // For logged in users
add_action('wp_ajax_nopriv_my_action', 'my_action'); // For non-logged in users

?>

<?php function my_action() {	
				 $catid = $_POST['termid'];
                $term_children = get_term_children( $catid, 'industry' ); 
		  				/*echo "<pre>";
		  				print_r($term_children);
		  				echo "<pre>";*/
		  				?>	
		  				
           <!-- <label for="lebsubind " class="lebsubind commenleb">Sub-Industry</label>                             
		                       	 <select id="multiple-checkboxes" class="options commen_reg min_hight_sel" multiple="multiple" name="subterm[]">
		                          <?php foreach ( $term_children as $child ) {
		                      $term = get_term_by( 'id', $child, 'industry' );?>
		                          <option value="<?php echo $term->name;?>"><?php echo $term->name;?></option>
		                          <?php }?>
		                     </select>-->
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
				            <ul>
				            <?php foreach ( $term_children as $child ) {
						                      $term = get_term_by( 'id', $child, 'industry' );?>
				                <li>
				                    <input name="subterm_free[]" id="multiple-checkboxes" type="checkbox" value="<?php echo $term->name;?>" /><?php echo $term->name;?>
				               </li>
				               <?php }?>
				            </ul>
				        </div>
				    </dd>
				 
				</dl>		                     

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
  <?php  exit;
		                    
}
add_action('wp_ajax_my_action_find', 'my_action_find'); // For logged in users
add_action('wp_ajax_nopriv_my_action_find', 'my_action_find'); // For non-logged in users

 function my_action_find() {
	
				 $catid = $_POST['termid_find'];
                $term_children = get_term_children( $catid, 'industry' ); 
		  				?>	
		  				
         
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
				            <ul>
				            <?php foreach ( $term_children as $child ) {
						                      $term = get_term_by( 'id', $child, 'industry' );?>
				                <li>
				                    <input name="subterm_find[]" id="multiple-checkboxes" type="checkbox" value="<?php echo $term->name;?>" /><?php echo $term->name;?>
				               </li>
				               <?php }?>
				            </ul>
				        </div>
				    </dd>
				 
				</dl>		                     

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
		                    <?php  exit;}
/*finder sub industry*/                    
		                    
add_action('wp_ajax_my_action_email', 'my_action_email');
add_action('wp_ajax_nopriv_my_action_email', 'my_action_email');
			
function my_action_email() {
$email_free = $_POST['email_free'];
$exists = email_exists($email_free);
if ( $exists ) {
    echo "Email Already Exist";
} 
else{
	 echo "OK";
	}	
	exit();
}			
			
add_action('wp_ajax_my_action1', 'my_action1'); // For logged in users
add_action('wp_ajax_nopriv_my_action1', 'my_action1'); // For non-logged in users

function my_action1() {
		         $freelancer =  $_POST['freelancer'];
			     $username = $_POST['fname'];
			     $lname = $_POST['lname'];
			     $displayname = $_POST['displayname'];
			     $mail = $_POST['email'];
			     $indestries = $_POST['indestries'];
                 $indestry = explode(',', $indestries);
                 $indestries_name = $indestry[1];
                 $subterm = $_REQUEST['subterm'];
			       $password = $_POST['password'];
			       $cpass = $_POST['cpass'];
			      $_SESSION["regcust"] =$username;
			      
			     if(!empty($username) || !empty($password) || !empty($mail)){
			         $userdata = array(
					   
					    'user_login' =>  $mail,
					    'display_name' =>  $displayname,
					    'user_email' =>  $mail,
					    'user_pass'  => $password,
					     'role' => $freelancer

					); 
					 

                   
					  $user_id = wp_insert_user( $userdata ) ;
					 $creds = array();
				    $creds['user_login'] = $mail;
				    $creds['user_password'] = $password;
				    $creds['remember'] = false;
				    $user = wp_signon( $creds, false );
					}
					/* $capabilities=array(
              'read'         => true,  // true allows this capability
              'edit_posts'   => true,
              'delete_posts' => false, // Use false to explicitly deny
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
           add_role( $freelancer, $freelancer, $capabilities );
					  update_user_meta($user_id, 'confirm_password', $cpass);
					 //add_role( $freelancer, $freelancer, $capabilities );
					update_user_meta($user_id,'first_name',$username);
		            update_user_meta($user_id,'last_name',$lname);
		             update_user_meta($user_id,'email',$mail);
		             $unique_id='FCPT'.$username.$user_id;
		             update_user_meta($user_id,'user_unique_id',$unique_id);
	  				 update_user_meta($user_id,'Parent_industry',$indestries_name);
	  				 update_user_meta($user_id,'child_industry',$subterm);
                     

			//wp_die(); // this is required to terminate immediately and return a proper response
		}
		//end user Registration process

		//start create post in user
            /* add_action( 'wp_ajax_my_action_step2', 'my_action_step2' );
		add_action( 'wp_ajax_nopriv_my_action_step2', 'my_action_step2' );*/

          //function my_action_step2() {
				
				       //step 2
			    //echo $authorimg = $_POST['authorimg'];
			      /* $Profile_des = $_REQUEST['Profile_des'];

			     $lpqute = $_REQUEST['lpqute'];
			     $Skils = $_REQUEST['Skils'];
			     $mobnum = $_REQUEST['mobnum'];
			     $telnno = $_REQUEST['telnno'];
			     $facebook = $_REQUEST['facebook'];
			     $twitter = $_REQUEST['twitter'];
			     $linked = $_REQUEST['linked'];
			     $file = $_REQUEST['file'];

				//step 2 
					
			        //post data
			        $new_post = array(
			        'post_title'  =>  $_SESSION["regcust"],

			        'post_status' =>  'publish',           
			        'post_type' =>  'freelancer',  
			        
			        );
			        //SAVE THE POST
		 $pid = wp_insert_post($new_post);
		 
		 update_post_meta($pid,'title',$_SESSION["regcust"] ); 
         update_post_meta( $pid, 'tagline', $lpqute ); 
          update_post_meta( $pid, 'bio_description', $Profile_des ); 
         update_post_meta( $pid, 'skils', $Skils );
        update_post_meta( $pid, 'mobile_number', $mobnum ); 
        update_post_meta( $pid, 'tel_number', $telnno ); 
        update_post_meta( $pid, 'facebook_url', $facebook ); 
        update_post_meta( $pid, 'tiwtter_url', $twitter ); 
        update_post_meta( $pid, 'linkedin_url', $linked );
         $current_user = wp_get_current_user();
   //print_r($current_user);
       $P_indestries = get_user_meta( $current_user->ID, 'Parent_indestries', 'true' ); 
       $c_indestries = get_user_meta( $current_user->ID, 'child_indestries', 'true' ); 
        $append ='true';
        $terms=wp_set_object_terms( $pid, $P_indestries, 'industry',$append); 
        wp_set_object_terms( $pid, $c_indestries, 'industry',$append);
        session_destroy('regcust');*/
		//wp_die(); // this is required to terminate immediately and return a proper response
		//}

//add_action( 'wp_footer', 'my_action_javascript' ); // Write our JS below here

//start create post in user

// ENABLE AJAX :




//custom user dashbord redirect
add_action( "template_redirect", "wc_custom_redirect_after_purchase" );
function wc_custom_redirect_after_purchase() {
global $wp;

if ( is_checkout() && ! empty( $wp->query_vars["order-received"] ) ) {
wp_redirect(get_site_url().'/dashboard/' );
exit;
}
}

//Using this code you can activate your plugin from the functions.php
//function activate_plugin_via_php() {
	//$active_plugins = get_option( 'active_plugins' );
	//array_push($active_plugins, 'ppress/profilepress.php'); /* Here just replace unyson plugin directory and plugin file*/
	//update_option( 'active_plugins', $active_plugins );   
//}
//add_action( 'init', 'activate_plugin_via_php' );
//custom user dashbord redirect

add_filter('woocommerce_login_redirect', 'wc_login_redirect');
 
function wc_login_redirect( $redirect_to ) {
     $redirect_to = get_site_url().'/dashboard/';
     return $redirect_to;
}
// order complete after admin send emails start
add_filter( 'woocommerce_email_recipient_customer_completed_order', 'your_email_recipient_filter_function', 10, 2);

function your_email_recipient_filter_function($recipient, $object) {
    $recipient = $recipient . ',newaccounts@freelancecapetown.com ,simondowdles@gmail.com';
    return $recipient; 
}
// order complete after admin send emails end

// checkout page change phone to mobile
function change_phone_to_mobile($translation, $text, $domain) {
    if ($domain == 'woocommerce') {
        switch ($text) {
            case 'Phone':
                $translation = 'Mobile';
                break;
   
        }
    }
    return $translation;
}
add_filter('gettext', 'change_phone_to_mobile', 10, 3);
// checkout page change phone to mobile
// Hide Admin Bar for All Users Except Adminministrators
function bs_hide_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'bs_hide_admin_bar');


if ( ! function_exists( 'fcpt_message_user' ) ) {

	add_action( 'init', 'fcpt_message_user' );

	/**
	 * Handle messaging of users
	 */
	function fcpt_message_user () {
		if ( ! empty( $_POST[ 'sd_message' ] ) ) {
			$message = wp_strip_all_tags( $_POST[ 'sd_message' ] );
			$profile_id = sanitize_key( $_POST[ 'profile_id' ] );
			if ( ! wp_verify_nonce( $_POST[ 'fcpt_message_user' ], 'fcp_message_user_' . $profile_id ) ) {
				return;
			}
			$original_post = get_post( $profile_id );

			if (  empty( $original_post ) ) {
				return false;
			}

			$profile_owner = new WP_User( $original_post->post_author );
			$profile_owner_email = $profile_owner->user_email;
			$current_user = wp_get_current_user();
			$Project_subject = 'Project Subject:'.get_the_title();
			$Due_date =  date( 'Y-m-d H:i:s' );
			$Budget;

			ob_start();
			include( get_stylesheet_directory() . '/includes/templates/email/profile_message.php' );
			$message_template = ob_get_clean();

			include( get_stylesheet_directory() . '/includes/classes/SdMessageEmail.class.php' );
			$email = new SdMessageEmail();
			$email->body = sprintf(
				$message_template,
				esc_html( $current_user->display_name ),
				nl2br('Message: '. $message ),
				esc_html( date( 'Y-m-d H:i:s' ) ),
				esc_html( $Project_subject ),
				esc_html('Due Date: '.$Due_date),
				esc_html('Budget: '.$Budget )
			);

			$send = wp_mail(
				$profile_owner_email,
				"Freelance Cape Town - New Message From {$current_user->display_name}",
				$email->buildSource(),
				array(
					'Content-Type: text/html' . "\r\n",
					'MIME-Version: 1.0' . "\r\n",
					'Bcc: simondowdles@gmail.com' . "\r\n",
					'Bcc: info@freelancecpt.com' . "\r\n",
				)
			);

			if ( $send ) {
				wc_add_notice( __( 'Your message has been successfully sent, thank you.' ), 'success' );
			} else {
				wc_add_notice( __( 'Your message failed to send.' ), 'error' );
			}

		}
	}

}

/* --custom shortcode */
add_shortcode( 'wpshout_sample_shortcode', 'wpshout_sample_shortcode' );
function wpshout_sample_shortcode() {
    return '<!-- Proceed Modal Modal -->

		<div class="uk-modal" id="proceed">
          <div class="uk-modal-dialog">
              <div class="uk-modal-header">

		        <h3 class="uk-text-center">
		        	<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_logo.png" width="50" height="50" alt="CPT">
		        	<div class="uk-clearfix">&nbsp;</div>
		        	Freelance Cape Town
		        
		        </h3>
		        <!--<p class="uk-text-center">Howdy! Welcome back, lets get you signed in</p>-->
		      </div>
              <div class="modal-body woocommerce">
                
               <h3>we have sent you a verification mail, with a verification link to continue the registration process, please check your mailbox / junkmail</h3>

              </div>
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
		<!-- Proceed Modal -->
    ';
}


?>
