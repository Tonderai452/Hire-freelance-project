<?php
	
	add_action( 'init', 'blockusers_init' );
		function blockusers_init() {
		if ( is_admin() && ! current_user_can( 'administrator' ) &&
		! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			wp_redirect( home_url() );
			exit;
		}
	}

	// Add Google Captcha to registration page
	/*add_action( 'wp_enqueue_scripts', function(){
		wp_register_script('recaptcha_api', 'https://www.google.com/recaptcha/api.js');
		wp_enqueue_script('recaptcha_api');
	} );
*/
	/*function sd_woo_extra_register_fields_after() {
		?>

		<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
			<p class="form-row form-row-wide">
				<label for="confirm_password"><?php _e( 'Confirm Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="password" class="input-text form-control" name="confirm_password" id="confirm_password" />
			</p>
		<?php endif; ?>

		<p class="form-row form-row-wide">
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<div class="g-recaptcha" data-sitekey="6LcZpxwTAAAAAB3xgwObdLAwB71wvZ8TU_vmLtmc"></div>
		</p>

		<?php
	}

	add_action( 'woocommerce_register_form', 'sd_woo_extra_register_fields_after' );

	add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );
	function my_custom_checkout_field( $checkout ) {
	?>
			<div class="uk-clearfix">&nbsp;</div>
			<p class="form-row form-row-wide">
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<div class="g-recaptcha" data-sitekey="6LcZpxwTAAAAAB3xgwObdLAwB71wvZ8TU_vmLtmc"></div>
		</p>
	<?php
	}
/*

	/**
	 * Validate the extra register fields.
	 *
	 * @param  string $username          Current username.
	 * @param  string $email             Current email.
	 * @param  object $validation_errors WP_Error object.
	 *
	 * @return void
	 */
	function sd_validate_extra_register_fields( $username, $email, $validation_errors ) {

		// Validate ReCaptcha
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$params = array(
			'secret' => '6LcZpxwTAAAAALkk9boqzIr_2NaPTq8rFkrmIpZc',
			'response' => $_POST['g-recaptcha-response']
		);
		$fields_string = "";
		foreach($params as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($params));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$gresult = curl_exec($ch);
		$gresult = json_decode($gresult);
		
		if( false === $gresult->success ){
			$validation_errors->add( 'g-recaptcha-response_error', __( 'You did not pass the security check, please try again.', 'sd' ) );
		}

		curl_close($ch);

		// End Validate ReCaptcha

	}

	add_action( 'woocommerce_register_post', 'sd_validate_extra_register_fields', 10, 3 );
	


	// Overide Add to Cart button text
	add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +	
	function woo_custom_cart_button_text() {
	    return __( 'Purchase This Now', 'sd' );
	}

	// Remove single product summary
	remove_action('woocommerce_single_product_summary','woocommerce_template_single_title',5);

	// Replace product summart ith product title
    add_action('woocommerce_single_product_summary', 'woocommerce_my_single_title',5);
    function woocommerce_my_single_title(){
    	echo "<h3 class=\"sdSingleProductTitle\">".get_the_title()."</h3>";
    }

    // Remove anything that came after sungle product summary
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);

    // Remove Related Products
    function wc_remove_related_products( $args ) {
		return array();
	}
	add_filter('woocommerce_related_products_args','wc_remove_related_products', 10); 

	// Remove Breadcrumbs
	add_filter('woocommerce_get_breadcrumb', function($crumbs){
    	return false;
    });

    // Generate own cart count object:
    function sd_show_cart(){
		global $woocommerce;

		$qty = $woocommerce->cart->get_cart_contents_count();
		$total = $woocommerce->cart->get_cart_total();
		$cart_url = $woocommerce->cart->get_cart_url();

		if($qty > 0) :
			echo '<li><a class="sd_cart_link" href="'.$cart_url.'">View Cart <span class="uk-text-bold uk-text-primary">('.$qty.')</span></a></li>';
		endif;
	}

	// Save post type after payment status change:

	add_action('woocommerce_order_status_changed', 'sdOrderPaidFor', 10, 3);

	function sdOrderPaidFor($order_id, $old_status, $new_status) {

		if( $new_status == 'failed' || $new_status == 'refunded' || $new_status == 'cancelled' ){

			return $order_id;
		}

	    $findArgs = array(
	    	'post_type' => array( 'freelancer', 'job-listing', 'co-working-space' ),
	    	'posts_per_page' => 99,
	    	'meta_query' => array(
	    		array(
	    			'key' => 'woocommerce_order_id',
	    			'value' => $order_id,
	    			'compare' => '='
	    		)
	    	)
	    );

	    $listingExists = new WP_Query( $findArgs );
	    // If this is a new order, create the temporary post, and send the user and admin a nice email
	    if( $listingExists->found_posts == 0 ){

	    	$wc_order = new WC_Order($order_id);
			$order_items = $wc_order->get_items();

	    	// Start Loop Over Order Items and Add Necessary Listings

	    	foreach( $order_items as $key=>$item ) :

	    		
	    		if( $item['name'] == "1 Year Premium Freelance Listing" ){

	    			//$NumImages = $item['item_meta']['_variation_id'][0] == 19119 ? 6 : 1;
	    			$user_id = $wc_order->get_user_id();

			    	$associated_post = wp_insert_post(array(
						'post_title' => 'New Premium Freelance Listing - 1 Year - Order #'.$order_id,
						'post_type'   => '',
						'post_status' => 'draft',
						'post_author' => $user_id,
						'meta_input' => array(
							'title' => 'New Premium Freelance Listing - 1 Year - Order #'.$order_id,
							'fcpt_owned_by' => $user_id,
							'expiry_date' => date('Y-m-d', strtotime( "today + 12 months" ) ),
							'admin_approved_listing' => 'no'
						)
					));

					update_post_meta( $associated_post, 'woocommerce_order_id', $order_id );
					//update_post_meta( $associated_post, 'expiry_date', date('d/m/Y', strtotime( "today + 12 months" ) ) );
					update_post_meta( $order_id, 'listing_id', $associated_post );
					update_post_meta( $order_id, 'fcpt_owned_by', $user_id );
					
					$user_id = $wc_order->get_user_id();
					$user = new WP_User( $user_id );
					//$admin_to = 'simondowdles@gmail.com';
					$admin_subject = 'A new featured listing has been purchased';
					$admin_body = "
A new listing has been purchased on your web site.\r\n\r\n
No edits have been made yet, you will receive an email once the user has editied their listings content. All user edits move into draft (unpublished) status, requiring admin approval before they are published.\r\n
Client details are as follows:\r\n\r\n
Name: " . $user->user_nicename . "\r\n
Email Address: " . $user->user_email . "\r\n\r\n
-- End Thank You --
";
					mail( $admin_to, $admin_subject, $admin_body );

				}
				
				elseif( $item['name'] == "1 Year Premium Co-Working Space Listing" ){

	    			//$NumImages = $item['item_meta']['_variation_id'][0] == 19119 ? 6 : 1;
	    			$user_id = $wc_order->get_user_id();

			    	$associated_post = wp_insert_post(array(
						'post_title' => '1 Year Premium Co-Working Space Listing #'.$order_id,
						'post_type'   => 'co-working-space',
						'post_status' => 'draft',
						'post_author' => $user_id,
						'meta_input' => array(
							'title' => '1 Year Premium Co-Working Space Listing - Order #'.$order_id,
							'fcpt_owned_by' => $user_id,
							'expiry_date' => date('Y-m-d', strtotime( "today + 12 months" ) ),
							'admin_approved_listing' => 'no'
						)
					));

			


					update_post_meta( $associated_post, 'woocommerce_order_id', $order_id );
					//update_post_meta( $associated_post, 'expiry_date', date('d/m/Y', strtotime( "today + 12 months" ) ) );
					update_post_meta( $order_id, 'listing_id', $associated_post );
					update_post_meta( $order_id, 'fcpt_owned_by', $user_id );
					
					$user_id = $wc_order->get_user_id();
					$user = new WP_User( $user_id );
					//$admin_to = 'simondowdles@gmail.com';
			    // $admin_to = 'simondowdles@gmail.com';
					$admin_subject = 'A new co working listing has been purchased';
					$admin_body = "
A new listing has been purchased on your web site.\r\n\r\n
No edits have been made yet, you will receive an email once the user has editied their listings content. All user edits move into draft (unpublished) status, requiring admin approval before they are published.\r\n
Client details are as follows:\r\n\r\n
Name: " . $user->user_nicename . "\r\n
Email Address: " . $user->user_email . "\r\n\r\n
-- End Thank You --
";
					mail( $admin_to, $admin_subject, $admin_body );

				}
				
				elseif( $item['name'] == "6 Months Premium Freelance Listing" ){

					$user_id = $wc_order->get_user_id();

			    	$associated_post = wp_insert_post(array(
						'post_title' => 'New Premium Freelance Listing - 6 Months - Order #'.$order_id,
						'post_type'   => '',
						'post_status' => 'draft',
						'post_author' => $user_id,
						'meta_input' => array(
							'title' => 'New Premium Freelance Listing - 6 Months - Order #'.$order_id,
							'fcpt_owned_by' => $user_id,
							'expiry_date' => date('Y-m-d', strtotime( "today + 6 months" ) ),
							'admin_approved_listing' => 'no'
						)
					));

					update_post_meta( $associated_post, 'woocommerce_order_id', $order_id );
					//update_post_meta( $associated_post, 'expiry_date', date('d/m/Y', strtotime( "today + 6 months" ) ) );
					update_post_meta( $order_id, 'listing_id', $associated_post );
					update_post_meta( $order_id, 'fcpt_owned_by', $user_id );
					
					$user_id = $wc_order->get_user_id();
					$user = new WP_User( $user_id );
					//$admin_to = 'simondowdles@gmail.com';
					$admin_subject = 'A new featured listing has been purchased';
					$admin_body = "
A new listing has been purchased on your web site.\r\n\r\n
No edits have been made yet, you will receive an email once the user has editied their listings content. All user edits move into draft (unpublished) status, requiring admin approval before they are published.\r\n
Client details are as follows:\r\n\r\n
Name: " . $user->user_nicename . "\r\n
Email Address: " . $user->user_email . "\r\n\r\n
-- End Thank You --
";
					mail( $admin_to, $admin_subject, $admin_body );

				}elseif( $item['name'] == "Premium Job Listing" ){

					$user_id = $wc_order->get_user_id();

			    	$associated_post = wp_insert_post(array(
						'post_title' => 'New Premium Job Listing - Order #'.$order_id,
						'post_type'   => 'job-listing',
						'post_status' => 'draft',
						'post_author' => $user_id,
						'meta_input' => array(
							'title' => 'New Premium Job Listing - Order #'.$order_id,
							'fcpt_owned_by' => $user_id,
							'expiry_date' => date('Y-m-d', strtotime( "today + 7 days" ) ),
							'admin_approved_listing' => 'no'
						)
					));

					update_post_meta( $associated_post, 'woocommerce_order_id', $order_id );
					//update_post_meta( $associated_post, 'expiry_date', date('d/m/Y', strtotime( "today + 1 months" ) ) );
					update_post_meta( $order_id, 'listing_id', $associated_post );
					update_post_meta( $order_id, 'fcpt_owned_by', $user_id );
					
					$user_id = $wc_order->get_user_id();
					$user = new WP_User( $user_id );
					//$admin_to = 'simondowdles@gmail.com';
					$admin_subject = 'A new job listing has been purchased';
					$admin_body = "
A new job listing has been purchased on your web site.\r\n\r\n
No edits have been made yet, you will receive an email once the user has editied their listings content. All user edits move into draft (unpublished) status, requiring admin approval before they are published.\r\n
Client details are as follows:\r\n\r\n
Name: " . $user->user_nicename . "\r\n
Email Address: " . $user->user_email . "\r\n\r\n
-- End Thank You --
";
					mail( $admin_to, $admin_subject, $admin_body );

				}

			endforeach;
	    }

	    // End Loop Over Order And Add Listing Items

		wp_reset_postdata();

	    return $order_id;
	}




